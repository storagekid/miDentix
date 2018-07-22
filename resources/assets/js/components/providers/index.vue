<template>
  <div id="providers" class="fx pv-20">
    <template>
      <modal name="delete-model" height="auto" width="1000px" maxWidht="80%">
        <model-delete-form
          >
        </model-delete-form>
      </modal>
    </template>
    <template>
      <modal name="new-model" height="auto" width="1000px" maxWidht="80%">
        <model-new-form
            :form-data="modelNewFormData"
            :modelNewFormOptions="modelNewFormDataOptions"
          >
          <h3 slot="header" class="panel-title">Nuevo Proveedor</h3>
        </model-new-form>
      </modal>
    </template>
    <template v-if="$store.getters.ready">
      <div class="fx fx-w-100 jf-around">
        <div class="fx fx-75 fx-col">  
          <div class="fx fx-col">
            <div class="panel panel-default fx-100">
              <div class="panel-heading text-center">
                <h3 class="panel-title">Proveedores</h3>
              </div>
              <div class="panel-body">
                <vue-table 
                  v-if="models.providers.items && !models.providers.state" 
                  :table-columns="tableColumns"
                  :table-options="tableOptions"
                  model="providers"
                  mode="vuex"
                  @toggleCreateModel="models.stationaries.state = 'creating'"
                  >
                </vue-table>
              </div>
            </div>
          </div>
        </div>  
      </div>
    </template>
  </div>
</template>

<script>
    import * as moment from 'moment';
    import modelNewForm from '../../components/model/model-new-form.vue';
    import modelDeleteForm from '../../components/model/model-delete-form.vue';
    import 'moment/locale/es';
    export default {
        components: {modelNewForm, modelDeleteForm},
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              //Table
              footer: {
                totalRows: 0,
              },
              tableColumns: [
                {
                  name: 'name',
                  label: 'Nombre',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'name',
                    options: {
                      search:['name'],
                      noOptions:false
                    } 
                  },
                  width:'',
                },
                {
                  name: 'email',
                  label: 'Email',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'email',
                    options: {
                      search:['email'],
                      noOptions:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'address',
                  label: 'Dirección',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'address',
                    options: {
                      search:['address'],
                      noOptions:true
                    } 
                  },
                  width:'',
                },
              ],
              tableOptions: {
                model: 'providers',
                counterColumn: true,
                actions: ['show','edit','delete'],
                showNew: true,
              },
              modelNewFormData: {
                model: 'providers',
                models: ['countries','counties','states'],
                fields: {
                  country_id: {
                    label: 'País',
                    rules: ['required'],
                    name: 'country_id',
                    value: null,
                    dontRecord: false,
                    affects: 'state_id',
                    type: {
                      name: 'select',
                      model:'countries',
                      text: 'name',
                      value:'id',
                      default: {
                        value: null,
                        text: 'Selecciona un País',
                        disabled: true,
                      },
                    },
                  },
                  state_id: {
                    label: 'CCAA',
                    rules: [],
                    name: 'state_id',
                    value: null,
                    dontRecord: false,
                    dependsOn: 'country_id',
                    affects: 'county_id',
                    type: {
                      name: 'select',
                      model:'states',
                      text: 'name',
                      value:'id',
                      default: {
                        value: null,
                        text: 'Selecciona una CCAA',
                        disabled: true,
                      },
                    },
                  },
                  county_id: {
                    label: 'Provincia',
                    rules: [],
                    name: 'county_id',
                    value: null,
                    dependsOn: 'state_id',
                    affects: 'clinic_id',
                    type: {
                      name: 'select',
                      model:'counties',
                      text: 'name',
                      value:'id',
                      default: {
                        value: null,
                        text: 'Selecciona una Provincia',
                        disabled: true,
                      },
                    },
                  },
                  clinic_id: {
                    label: 'Clínica',
                    rules: [],
                    name: 'clinic_id',
                    value: null,
                    dontRecord: false,
                    dependsOn: 'county_id',
                    type: {
                      name: 'select',
                      model:'clinics',
                      text: 'fullName',
                      value:'id',
                      default: {
                        value: null,
                        text: 'Selecciona una Clínica',
                        disabled: true,
                      },
                    },
                  },
                  name: {
                    label: 'Nombre',
                    rules: ['required','min:5','max:64'],
                    name: 'name',
                    value: null,
                    colClasses: 'col-xs-12 col-md-4',
                    type: {
                      name: 'inputText',
                    },
                  },
                  description: {
                    label: 'Descripción',
                    rules: ['required','min:5','max:64'],
                    name: 'description',
                    value: null,
                    colClasses: 'col-xs-12 col-md-4',
                    type: {
                      name: 'inputText',
                    },
                  },
                  price: {
                    label: 'Precio',
                    rules: ['required'],
                    name: 'price',
                    value: null,
                    colClasses: 'col-xs-12 col-md-4',
                    type: {
                      name: 'inputDecimal',
                    },
                  },
                  details: {
                    label: 'Detalles',
                    rules: ['required','min:5','max:255'],
                    name: 'details',
                    value: null,
                    colClasses: 'col-xs-12 col-md-4',
                    type: {
                      name: 'inputText',
                    },
                  },
                  customizable: {
                    label: 'Personalizable',
                    rules: [],
                    name: 'customizable',
                    value: false,
                    colClasses: 'col-xs-12 col-md-4',
                    type: {
                      name: 'checkBox',
                    },
                  },
                  design: {
                    label: 'Diseño',
                    rules: [],
                    name: 'design',
                    value: false,
                    colClasses: 'col-xs-12 col-md-4',
                    type: {
                      name: 'file',
                    },
                  },
                }
              },
              modelNewFormDataOptions: {
                checkSourceData: true,
                hasFiles: false,
              }
            }
        },
        watch: {
        },
        computed: {
          models() {
            return this.$store.state.models;
          },
        },
        methods: {
        },
        created() {
          this.$store.dispatch('fetchModels',['providers']);
        },
        mounted() {
        }
    }
</script>
<style type="text/css">
</style>