<template>
  <div id="model-new-container">
    <loading v-if="!$store.state.Form.forms[model]"></loading>
    <div class="fx jf-center" v-else>
      <div class="panel panel-default fx-100">
        <div class="panel-heading text-center">
          <slot name="header" v-if="!batchMode">
            <h3 class="panel-title">{{updating ? 'Actualizar' : 'Nuevo'}} elemento</h3>
          </slot>
          <h3 class="panel-title" v-else>Edición Múltiple</h3>
        </div>
        <div class="panel-body">
          <form>
            <div class="fx fx-50 fx-wrap jf-between">
              <div 
                v-for="(field, index) in fields" 
                v-if="!batchMode || (batchMode && field.batch)"
                :key="index"
                class="form-group"
                :class="field.colClasses ? field.colClasses : 'fx-b-50'"
                >
                <label>{{field.label}}</label>
                <span
                  v-if="field.rules.includes('required')"
                  class="required-reminder"
                  >
                  *
                </span>
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
                    v-for="(modelItem, index) in $store.state.Model.models[field.type.model].items" 
                    :key="index"
                    v-if="!field.dependsOn || (field.dependsOn && modelToSave[field.dependsOn] == modelItem[field.dependsOn])"
                    :value="modelItem[field.type.value]"
                    :selected="modelToSave[field.name]"
                    >
                    {{modelItem[field.type.text]}}
                  </option>
                </select>
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
                      @click.prevent="$store.commit('Model/removeFile', {'model': model, 'file': field.name})"
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
              <div v-for="(relation, index) in relations" :key="index">
                <hr>
                <h3>{{relation.label}}</h3>
                <template v-if="modelToSave[relation.name]">
                    <vue-table 
                    :model="relation.name"
                    mode="vuex"
                    :related-model="model"
                    :table-items="$store.state.Model.models[model].modelToSave[relation.name]"
                    >
                  </vue-table>
                </template> 
              </div>
          </template>
        </div>
        <div class="panel-footer fx mr-10">
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
    export default {
        mixins: [errors,validations],
        props: ['model', 'relatedModel', 'modelNewFormOptions'],
        data() {
            return {
              fields: {},
              models: [],
              relations: {},
              formOptions: {
                checkSourceData: true,
                hasFiles: false,
              },
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
            this.$store.commit('Form/newRelationForm',{model: this.model, relation: relationSource})
          },
          setFiles(name, file) {
            console.log(file);
            this.modelToSave[name] = file;
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
            this.$store.commit('Modal/hideModal', {name: this.modalName});
          },
          sendAction() {
            if (this.relatedModel) {
              this.updating ? this.updateRelation() : this.createNewRelation();
            } 
            else {
              this.updating ? this.updateModel() : this.createNew();              
            }
            this.$store.commit('Modal/hideModal', {name: this.modalName});            
          },
          updateRelation() {
            if (this.ghostMode) {
              return this.$store.dispatch('Model/updateGhostRelation', {name: this.relatedModel, relation: this.model, ids:this.modal.ids, modelToSave: this.modelToSave});
            }
            this.$store.dispatch('Model/updateRelation', {name: this.relatedModel, relation: this.model, ids:this.modal.ids, item: this.modelToSave});            
          },
          createNewRelation() {
            this.$store.dispatch('Model/setNewRelation', {name: this.relatedModel, relation: this.model, item: this.modelToSave});            
          },
          createNew() {
            this.$store.dispatch('Model/createNewModel', {name: this.model, model: this.modelToSave, hasFiles: this.formOptions.hasFiles});
          },
          updateModel() {
            console.log('Updating!!!');
            this.$store.dispatch('Model/updateModel', {name: this.model, model: this.modelToSave, ids:this.modal.ids, hasFiles: this.formOptions.hasFiles});
          },
          modelToSaveBuilder(options={modelItem:null, batch:false}) {
            let defFields;

            if (options.batch) {
              defFields = this.batchFields;
            } else {
              defFields = this.fields;
            }
            // console.log(defFields);
            this.$store.commit('Model/modelToSaveBuilder', {model: this.model, fields: defFields, item: options.modelItem, relations: this.relations});
          },
          initializeForm() {
            axios.get('/api/form?model=' + this.model + '&ids='+this.modal.ids + '&relation=' + this.relatedModel).then(({data}) => {
                this.fields = data.form.fields;
                this.models = data.form.models;
                this.relations = data.form.relations;
                // this.options = data.table.options;
            }).then(() => {
              if (this.models) {
                this.$store.dispatch('Model/fetchModels', this.models);
              }
              this.$store.commit('Form/setForm', {model: this.model, models: this.models, relations: this.relations});
              if (this.modal.mode == 'edit') {
                if (this.modal.items.length === 1) {
                  this.modelToSaveBuilder({modelItem:this.modal.items[0]}); 
                } else if (this.modal.items.length > 1) {
                  console.log('Batch Updating!!!!');
                  // this.modelToSaveBatchBuilder(this.modal.items[0]);
                  this.modelToSaveBuilder({batch:this.batchMode});
                }
              } else {
                this.modelToSaveBuilder();                
              }
              this.$store.commit('Form/formsReady');
              if (this.formOptions.checkSourceData) {
                let fieldsForChecking = this.batchMode ? this.batchFields : this.fields;
                for (let field in fieldsForChecking) {
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
            return this.$store.state.Form.forms;
          },
          creating() {
            return this.modal.mode === 'create';
          },
          updating() {
            return this.modal.mode === 'edit';
          },
          // Ghost mode active when parent Model is new and the no record persisted on the DB.
          ghostMode() {
            if (this.relatedModel) {
              if (!this.$store.state.Model.models[this.relatedModel].modelToSave.id) {
                return true;
              }
            }
            return false;
          },
          batchMode() {
            if (this.updating) {
              return this.$store.state.Modal.modals[this.modalName].items.length > 1;              
            }
          },
          batchFields() {
            let batchFields = {};
            if (this.batchMode) {
              for (let field in this.fields) {
                if (this.fields[field].batch) {
                  batchFields[field] = this.fields[field];
                }
              }
             return batchFields;
            }
          },
          modalName() {
            return  'new-' + this.model + '-model';
          },
          modal() {
            return this.$store.state.Modal.modals[this.modalName];
          },
          modelToSave() {
            return this.$store.state.Model.models[this.model].modelToSave;
          }
        },
        created() {
          this.$store.commit('Form/formsNotReady');
          this.initializeForm();
        },
        destroyed() {
            this.$store.commit('Form/destroyForm',{name: this.model});
            this.$store.commit('Model/restoreModelState',{name: this.model});
            this.$store.commit('Model/restoreNewIds',{model: this.model, relation: this.relatedModel});
        }
    }
</script>
<style type="text/css">
</style>