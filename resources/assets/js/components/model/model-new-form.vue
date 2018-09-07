<template>
  <div id="model-new-container">
    <loading v-if="!$store.state.Form.forms[model]"></loading>
    <div class="fx fx-col jf-center" v-else>
      <div class="modal-heading text-center">
        <slot name="header" v-if="!batchMode">
          <h3 class="panel-title">{{updating ? 'Actualizar' : 'Nuevo'}} elemento</h3>
        </slot>
        <h3 class="panel-title" v-else>Edición Múltiple</h3>
      </div>
      <div class="modal-body">
        <div class="panel-default fx-100">
          <div class="panel-body">
            <form id="new-model-form" @submit.prevent="sendAction">
              <div class="fx fx-50 fx-wrap jf-between">
                <div 
                  v-for="(field, index) in fields" 
                  v-if="showField(field)"
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
                    :required="field.rules.includes('required')"
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
                      v-if="(!field.dependsOn || (field.dependsOn && modelToSave[field.dependsOn] == modelItem[field.dependsOn]))"
                      :value="modelItem[field.type.value]"
                      :selected="modelToSave[field.name]"
                      >
                      {{modelItem[field.type.text]}}
                    </option>
                    <!-- <option 
                      v-for="(modelItem, index) in $store.state.Model.models[field.type.model].items" 
                      :key="index"
                      v-if="(!field.dependsOn || (field.dependsOn && modelToSave[field.dependsOn] == modelItem[field.dependsOn])) && 
                      !$store.state.Scope[field.type.model] || (!$store.state.Scope[field.type.model].selected || $store.state.Scope[field.type.model].selected == modelItem.id)"
                      :value="modelItem[field.type.value]"
                      :selected="modelToSave[field.name]"
                      >
                      {{modelItem[field.type.text]}}
                    </option> -->
                  </select>
                  <input 
                    v-if="field.type.name == 'inputText'"
                    type="text" 
                    :name="field.name"
                    class="form-control"
                    v-model="modelToSave[field.name]"
                    @blur="validateField(field.name,modelToSave[field.name],field.rules)"
                    :required="field.rules.includes('required')"
                    >
                  <input 
                    v-if="field.type.name == 'email'"
                    type="email" 
                    validate
                    required
                    :name="field.name"
                    class="form-control"
                    v-model="modelToSave[field.name]"
                    @blur="validateField(field.name,modelToSave[field.name],field.rules)"
                    :required="field.rules.includes('required')"
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
                    :required="field.rules.includes('required')"
                    >
                  <input 
                    v-if="field.type.name == 'checkBox'"
                    type="checkbox"
                    :name="field.name"
                    class="form-control"
                    :value="field.value"
                    v-model="modelToSave[field.name]"
                    :required="field.rules.includes('required')"
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
              <template v-if="Object.keys(relations).length">
                  <div 
                    v-for="(relation, index) in relations" 
                    :key="index"
                    v-if="modelToSave[relation.name]"
                    >
                    <hr>
                    <h3>{{relation.label}}</h3>
                    <template>
                        <vue-table 
                        :model="relation.name"
                        mode="vuex"
                        :related-model="model"
                        :table-items="modelToSave[relation.name]"
                        >
                      </vue-table>
                    </template> 
                  </div>
              </template>
              <button type="submit" ref="sendButton" class="hidden">
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer fx mr-10">
        <button 
          class="btn btn-warning btn-sm" 
          @click.prevent="cancelCreating"
          >
          Cancelar
        </button>
        <button
          class="btn btn-primary btn-sm" 
          :disabled="!readyToSave" 
          @click="sendForm"
          >
          Guardar
        </button>
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
            if (this.forms[this.model].ready) {
              }
          },
        },
        methods: {
          sendForm(e) {
            this.$refs.sendButton.click()
          }, 
          showField(field) {
            if (this.batchMode && field.batch) {
              return true;
            } else if (this.modal.mode == 'multiColumn' && this.modal.fields.includes(field.name)) {
              return true;
            } else if (!this.batchMode && this.modal.mode != 'multiColumn') {
              return true;
            }
            else {
              return false;
            }
          },
          changeFile(field) {
            this.$refs[field][0].click();
          },
          newRelation(relationSource) {
            this.$store.commit('Form/newRelationForm',{model: this.model, relation: relationSource})
          },
          setFiles(name, file) {
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
            for (let relation in this.relations) {
              this.$store.commit('Model/deleteTempNewRelation', {'name': relation, 'relation': this.model});
            }
            this.$store.commit('Modal/hideModal', {name: this.modalName});
          },
          sendAction() {
            if (this.relatedModel) {
              this.updating ? this.updateRelation() : this.createNewRelation();
            } 
            else {
              this.updating || this.multiColumnMode ? this.updateModel() : this.createNew();              
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
            this.$store.dispatch('Model/updateModel', {name: this.model, model: this.modelToSave, ids:this.modal.ids, fields: this.modal.fields, hasFiles: this.formOptions.hasFiles});
          },
          modelToSaveBuilder() {
            let modelItem = null;
            let defFields = {};
            let batchMode = false;
            let defRelations = this.relations;
            if (this.modal.mode == 'edit') {
              if (this.modal.items.length === 1) {
                modelItem = this.modal.items[0]; 
              } else if (this.modal.items.length > 1) {
                batchMode = true;
              }
            }
            if (batchMode) {
              defFields = this.batchFields;
            } else if (this.modal.mode == 'multiColumn') {
              for (let field in this.fields) {
                if (this.modal.fields.includes(field)) {
                  defFields[field] = this.fields[field];
                }
              }
              defRelations = null;
            } else {
              defFields = this.fields;
            }
            if (defRelations && this.modal.mode != 'edit') {
              for (let relation in defRelations) {
                if (this.$store.state.Scope[relation]) {
                  if (this.$store.state.Scope[relation].selected) {
                    this.$store.dispatch('Model/setNewRelation', {name: this.model, 'relation': relation, item: {clinic_id: this.$store.state.Scope.clinics.selected}});
                  }
                }
              }
            }
            
            this.$store.commit('Model/modelToSaveBuilder', {model: this.model, fields: defFields, item: modelItem, relations: defRelations});
          },
          initializeForm() {
            axios.get('/api/form?model=' + this.model + '&ids='+this.modal.ids + '&relation=' + this.relatedModel).then(({data}) => {
                this.fields = data.form.fields;
                this.models = data.form.models;
                this.relations = data.form.relations;
                // this.options = data.table.options;
            }).then(() => {
              if (this.models) {
                this.$store.dispatch('Model/fetchModels', {models: this.models});
              }
              this.$store.commit('Form/setForm', {model: this.model, models: this.models, relations: this.relations});
              this.modelToSaveBuilder();                
              this.$store.commit('Form/formsReady');
              if (this.formOptions.checkSourceData) {
                let fieldsForChecking;
                if (this.batchMode) {
                  fieldsForChecking = this.batchFields;
                } else if (this.modal.mode == 'multiColumn') {
                  fieldsForChecking = this.multiColumnFields;
                } else {
                  fieldsForChecking = this.fields;
                }
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
          multiColumnMode() {
            return  this.modal.mode == 'multiColumn';
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
          multiColumnFields() {
            let fields = {};
            if (this.modal.mode == 'multiColumn') {
              for (let field in this.fields) {
                if (this.modal.fields.includes(field.name)) {
                  fields[field] = this.fields[field];
                }
              }
             return fields;
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