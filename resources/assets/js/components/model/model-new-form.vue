<template>
  <div id="model-new-container" v-if="ready">
    <div class="row">
      <div class="col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading text-center">
            <h3 class="panel-title">Nueva Clínica</h3>
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
                      v-for="(modelItem, index) in models[field.type.model]" 
                      :key="index"
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
                </div>
              </div>
            </form>
            <button 
            class="btn btn-warning btn-sm" 
              @click.prevent="cancelCreating"
              @click.right.prevent="$modal.hide('new-clinic')"
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
  </div>
</template>

<script>
    import errors from '../../mixins/errors.js';
    import validations from '../../mixins/validations.js';
    export default {
        mixins: [errors,validations],
        props: ['formData','modelNewFormOptions'],
        data() {
            return {
              newModelForm: this.formData,
              formOptions: this.modelNewFormOptions,
              models: {},
              modelsFetched: 0,
              modelToSave: {},
            }
        },
        watch: {
        },
        methods: {
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
              this.newModelForm.fields[fieldAffects].rules
            );
            if (this.newModelForm.fields[fieldAffects].affects) {
              return this.newModelForm.fields[fieldAffects].affects;
            }
            return false;
          },
          cancelCreating() {
            this.$emit('CreatingModelCanceled');
          },
          createNew() {
            // this.modelToSaveBuilder();
          },
          fetchModel(model) {
            axios.get('/api/'+model).then(data => {
              this.models[model] = data.data; 
              this.modelsFetched++;
            });
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
          ready() {
            return this.newModelForm.models.length == this.modelsFetched;
          }
        },
        created() {
          this.modelToSaveBuilder();
          if (this.newModelForm.models) {
            for (let model of this.newModelForm.models) {
              this.fetchModel(model);
            }
          }
        },
        beforeMount() {
          if (this.formOptions.checkSourceData) {
            for (let field in this.newModelForm.fields) {
              this.validateField(
                field,
                this.newModelForm.fields[field].value,
                this.newModelForm.fields[field].rules
              );
            }
          }
        },
        mounted() {
        }
    }
</script>
<style type="text/css">
</style>