<template>
  <div>
    <label>{{field.label}}</label>
    <select 
      v-if="field.type.name == 'select'" 
      v-model="modelToSave[field.name]"
      :disabled="field.dependsOn ? !modelToSave[field.dependsOn] : false"
      :patata="fieldDependency(field.dependsOn)"
      :name="field.name"
      class="form-control"
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
        v-for="modelItem in models[field.type.model]" 
        :value="modelItem[field.type.value]"
        :selected="modelToSave[field.name]"
        >
        {{modelItem[field.type.text]}}
      </option>
    </select>
  </div>
</template>

<script>
    export default {
        props: ['selectData'],
        data() {
            return {
              : this.formData,
              models: {},
              modelsFetched: 0,
              modelToSave: {},
              // modelToSave: {
              //   country_id: null,
              //   state_id: null,
              //   provincia_id: null,
              // },
              readyToSave: false,
            }
        },
        watch: {
        },
        methods: {
          fieldDependency(field) {
            console.log(field);
            if (this.modelToSave[field] == null) {
              console.log(this.modelToSave[field]);
              return true;
            } else {
              console.log(this.modelToSave[field]);
              return false
            }
          },
          updateSelectField(e,field) {
            console.log(e.target.value);
            console.log(field);
            this.modelToSave[field] = e.target.value;
          },
          cancelCreating() {
            this.$emit('CreatingModelCanceled');
          },
          createNew() {
          },
          fetchModel(model) {
            axios.get('/api/'+model).then(data => {
              this.models[model] = data.data; 
              this.modelsFetched++;
            });
          },
          modelToSaveBuilder() {
            for (let field in this.newModelForm.fields) {
              console.log(field);
              if (!this.newModelForm.fields[field].dontRecord) {
                this.modelToSave[this.newModelForm.fields[field].name] = null;
              }
            }
          }
        },
        computed: {
          phase2() {
            if (this.newModel.country && this.newModel.state && this.newModel.county) {
              return true;
            }
            return false;
          },
          ready() {
            return this.newModelForm.models.length == this.modelsFetched;
          }
        },
        beforeCreate() {
          this.modelToSaveBuilder();
        },
        created() {
          // this.modelToSaveBuilder();
          console.log(this.modelToSave);
          if (this.newModelForm.models) {
            for (let model of this.newModelForm.models) {
              this.fetchModel(model);
            }
          }
        },
        mounted() {
        }
    }
</script>