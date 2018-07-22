<template>
  <div id="model-new-container">
    <loading v-if="!$store.state.forms[model]"></loading>
    <div class="fx jf-center" v-else>
      <div class="panel panel-default">
        <div class="panel-heading text-center">
          <slot name="header">
            <h3 class="panel-title">{{updating ? 'Actualizar' : 'Nuevo'}} elemento</h3>
          </slot>
        </div>
        <div class="">
          <form>
            <div class="row">
              <div 
                v-for="(field, index) in fields" 
                :key="index"
                class="form-group"
                :class="field.colClasses ? field.colClasses : 'col-xs-12 col-md-4'"
                >
                <label>{{field.label}}</label>
                <span
                  v-if="field.rules.includes('required')"
                  class="required-reminder"
                  >
                  *
                </span>
                <select 
                  v-if="field.type.name == 'select'" 
                  v-model="modelToSave[field.name]"
                  :disabled="field.dependsOn ? !modelToSave[field.dependsOn] : false"
                  :name="field.name"
                  class="form-control"
                  @change="selectChangedActions(field.name,modelToSave[field.name],field.rules,field.affects)"
                  >
                  <option 
                    v-if="field.type.default" 
                    :value="field.type.default.value" 
                    :disabled="field.type.default.disabled"
                    :selected="modelToSave[field.name]"
                    >
                    {{field.type.default.text}}
                  </option>
                  <option 
                    v-for="(modelItem, index) in $store.state.models[field.type.model].items" 
                    :key="modelItem.id"
                    v-if="!field.dependsOn || (field.dependsOn && modelToSave[field.dependsOn] == modelItem[field.dependsOn])"
                    :value="modelItem[field.type.value]"
                    :selected="modelToSave[field.name]"
                    >
                    {{modelItem[field.type.text]}}
                  </option>
                </select>
                <span
                  v-if="errorsHas(field.name)"
                  class="glyphicon glyphicon-exclamation-sign error-icon"
                >
                  <div
                    class="tooltip error-tip"
                  >
                  <ul>
                    <li v-for="(description, index) in errors.errorsInField[field.name]" :key="index">
                      {{errors.descriptions[field.name][description]}}
                    </li>
                  </ul>
                  </div>
                </span>
                <input 
                  v-if="field.type.name == 'inputText'"
                  type="text" 
                  :name="field.name"
                  class="form-control"
                  v-model="modelToSave[field.name]"
                  @blur="validateField(field.name,modelToSave[field.name],field.rules)"
                  >
                <input 
                  v-if="field.type.name == 'inputDecimal'"
                  type="number"
                  min="0.01"
                  step="0.01" 
                  :name="field.name"
                  class="form-control"
                  v-model="modelToSave[field.name]"
                  @blur="validateField(field.name,modelToSave[field.name],field.rules)"
                  >
                <input 
                  v-if="field.type.name == 'checkBox'"
                  type="checkbox"
                  :name="field.name"
                  class="form-control"
                  :value="field.value"
                  v-model="modelToSave[field.name]"
                  >
                <span
                  v-if="field.type.name == 'file'"
                >
                  <p
                    v-if="modelToSave[field.name]"
                  >
                    {{typeof modelToSave[field.name] === 'object' ? modelToSave[field.name].name : modelToSave[field.name]}}
                    <button
                      @click.prevent="changeFile(field.name)"
                      >
                      Cambiar
                    </button>
                    <button
                      @click.prevent="$store.commit('removeFile', {'model': model, 'file': field.name})"
                      >
                      Eliminar
                    </button>                    
                  </p>
                  <input 
                  v-show="!modelToSave[field.name]"
                  type="file"
                  :ref="field.name"
                  :name="field.name"
                  class="form-control"
                  @change="setFiles($event.target.name, $event.target.files[0])"
                  >
                </span>
              </div>
            </div>
          </form>
          <template v-if="Object.keys(relations).length">
            <hr>
              <div v-for="(relation, index) in relations" :key="index">
                <h3>{{relation.label}}</h3>
                <!-- <button 
                  class="btn btn-primary btn-sm" 
                  @click.prevent="newRelation(relation.name)" 
                  v-text="'Añadir'"
                  v-if="!forms[model]['relations'][relation.name].active"
                  >
                </button> 
                <relation-new-form
                  v-if="forms[model]['relations'][relation.name].active"
                  :model="model" 
                  :form-data="relation"
                  >
                  <h3 slot="header" class="panel-title">{{relation.header}}</h3>
                </relation-new-form> -->
                <template v-if="modelToSave[relation.name]">
                    <vue-table 
                    :model="relation.name"
                    mode="vuex"
                    :related-model="model"
                    :table-items="$store.state.models[model].modelToSave[relation.name]"
                    >
                  </vue-table>
                </template> 
              </div>
            <hr>
          </template>
          <button 
          class="btn btn-warning btn-sm" 
            @click.prevent="cancelCreating"
            >
            Cancelar
          </button>
          <button 
          class="btn btn-primary btn-sm" 
            @click.prevent="sendAction"
            :disabled="!readyToSave" 
            >
            Guardar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import errors from '../../mixins/errors.js';
    import validations from '../../mixins/validations.js';
    import relationNewForm from '../../components/model/relation-new-form.vue';
    export default {
        mixins: [errors,validations],
        props: ['model', 'relatedModel', 'modelNewFormOptions'],
        components: {relationNewForm},
        data() {
            return {
              fields: {},
              models: [],
              relations: {},
              // formOptions: this.modelNewFormOptions,
              formOptions: {
                checkSourceData: true,
                hasFiles: false,
              },
              // modelToSave: {},
            }
        },
        watch: {
          forms() {
            console.log("Form Changed");
            if (this.forms[this.model].ready) {
                console.log("Form Ready");
              }
          },
        },
        methods: {
          changeFile(field) {
            console.log(field);
            this.$refs[field][0].click();
          },
          newRelation(relationSource) {
            this.$store.commit('newRelationForm',{model: this.model, relation: relationSource})
          },
          setFiles(name, file) {
            console.log(file);
            this.modelToSave[name] = file;
            // this.$store.commit('setFileToModel', {'model': this.model, 'name': file.name, field: name});
            this.formOptions['hasFiles'] = this.modelToSave[name] ? true : false;
          },
          selectChangedActions(fieldName,fieldValue,fieldRules,fieldAffects) {
            this.validateField(fieldName,fieldValue,fieldRules);
            while (fieldAffects) {
              fieldAffects = this.checkFieldCascade(fieldName,fieldValue,fieldRules,fieldAffects);
            }
          },
          checkFieldCascade(fieldName,fieldValue,fieldRules,fieldAffects) {
            this.modelToSave[fieldAffects] = null;
            // this.$set(this.modelToSave,fieldAffects, null);
            this.validateField(
              fieldAffects,
              this.modelToSave[fieldAffects],
              this.fields[fieldAffects].rules
            );
            if (this.fields[fieldAffects].affects) {
              return this.fields[fieldAffects].affects;
            }
            return false;
          },
          cancelCreating() {
            this.$store.commit('hideModal', {name: this.modalName});
          },
          sendAction() {
            if (this.relatedModel) {
              this.updating ? this.updateRelation() : this.createNewRelation();
            } 
            else {
              this.updating ? this.updateModel() : this.createNew();              
            }
            this.$store.commit('hideModal', {name: this.modalName});            
          },
          updateRelation() {
            this.$store.dispatch('updateRelation', {name: this.relatedModel, relation: this.model, item: this.modelToSave});            
          },
          createNewRelation() {
            this.$store.dispatch('setNewRelation', {name: this.relatedModel, relation: this.model, item: this.modelToSave});            
          },
          createNew() {
            this.$store.dispatch('createNewModel', {name: this.model, model: this.modelToSave, hasFiles: this.formOptions.hasFiles});
          },
          updateModel() {
            console.log('Updating!!!');
            this.$store.dispatch('updateModel', {name: this.model, model: this.modelToSave, hasFiles: this.formOptions.hasFiles});
          },
          modelToSaveBuilder(modelItem=null) {
            this.$store.commit('modelToSaveBuilder', {model: this.model, fields: this.fields, item: modelItem, relations: this.relations});
          },
          initializeForm() {
            axios.get('/api/form?model=' + this.model + '&ids='+this.modal.ids + '&relation=' + this.relatedModel).then(({data}) => {
                this.fields = data.form.fields;
                this.models = data.form.models;
                this.relations = data.form.relations;
                // this.options = data.table.options;
            }).then(() => {
              if (this.models) {
                this.$store.dispatch('fetchModels', this.models);
              }
              this.$store.commit('setForm', {model: this.model, models: this.models, relations: this.relations});
              if (this.modal.mode == 'edit') {
                if (this.modal.items.length === 1) {
                  this.modelToSaveBuilder(this.modal.items[0]); 
                  // this.$store.state.models[this.model].modelToSave = this.modal.items[0];                  
                }
              } else {
                this.modelToSaveBuilder();                
              }
              this.$store.commit('formsReady');
              if (this.formOptions.checkSourceData) {
                for (let field in this.fields) {
                  this.validateField(
                    field,
                    this.modelToSave[field],
                    this.fields[field].rules
                  );
                }
              }
            });
          }
        },
        computed: {
          readyToSave() {
            return !this.errorsCount;
          },
          forms() {
            return this.$store.state.forms;
          },
          creating() {
            return this.modal.mode === 'create';
          },
          updating() {
            return this.modal.mode === 'edit';
          },
          modalName() {
            // let start = this.modal.mode === 'edit' ? 'updating-' : 'new-';
            return  'new-' + this.model + '-model';
          },
          modal() {
            return this.$store.state.modals[this.modalName];
          },
          modelToSave() {
            return this.$store.state.models[this.model].modelToSave;
          }
        },
        created() {
          this.$store.commit('formsNotReady');
          this.initializeForm();
          // this.modelToSaveBuilder();
        },
        destroyed() {
            this.$store.commit('destroyForm',{name: this.model});
            this.$store.commit('restoreModelState',{name: this.model});
        }
    }
</script>
<style type="text/css">
</style>