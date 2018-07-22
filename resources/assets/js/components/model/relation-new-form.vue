<template>
  <div id="model-new-container">
    <loading v-if="!$store.getters.ready"></loading>
    <div class="fx jf-center" v-else>
      <div class="panel panel-default">
        <div class="panel-heading text-center">
          <slot name="header">
            <h3 class="panel-title">Nuevo elemento</h3>
          </slot>
        </div>
        <div class="panel-body">
          <form>
            <div class="row">
              <div 
                v-for="(field, index) in newModelForm.fields" 
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
                <input 
                  v-if="field.type.name == 'file'"
                  type="file"
                  :name="field.name"
                  class="form-control"
                  @change="setFiles($event.target.name, $event.target.files[0])"
                  >
              </div>
            </div>
          </form>
          <button 
          class="btn btn-warning btn-sm" 
            @click.prevent="cancelCreating"
            >
            Cancelar
          </button>
          <button 
          class="btn btn-primary btn-sm" 
            @click.prevent="createNew"
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
        props: ['formData', 'model'],
        data() {
            return {
              newModelForm: this.formData,
              modelToSave: {},
            }
        },
        watch: {
        },
        methods: {
          setFiles(name, file) {
            this.modelToSave[name] = file;
            this.modelNewFormOptions['hasFiles'] = this.modelToSave[name] ? true : false;
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
              this.newModelForm.fields[fieldAffects].rules
            );
            if (this.newModelForm.fields[fieldAffects].affects) {
              return this.newModelForm.fields[fieldAffects].affects;
            }
            return false;
          },
          cancelCreating() {
            this.$store.commit('hideRelationForm', {model: this.model, relation: this.newModelForm.name});
            // this.$store.state.forms[this.model]['relations'][this.newModelForm.name].active = false
          },
          createNew() {
            this.$store.dispatch('createNewModel', {name: this.newModelForm.model, model: this.modelToSave, hasFiles: this.modelNewFormOptions.hasFiles});
            this.$modal.hide('new-model');
          },
          modelToSaveBuilder() {
            for (let field in this.newModelForm.fields) {
              this.$set(
                this.modelToSave,
                this.newModelForm.fields[field].name,
                null,
              )
            }
          }
        },
        computed: {
          readyToSave() {
            return !this.errorsCount;
          },
        },
        created() {
          if (this.newModelForm.models) {
            this.$store.dispatch('fetchModels', this.newModelForm.models);
          }
          this.modelToSaveBuilder();
        },
        beforeMount() {
        },
    }
</script>
<style type="text/css">
</style>