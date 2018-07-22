<template>
  <div id="orders-home">
    <div class="row">
      <div class="col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading text-center" v-if="admin">
            <h3 class="panel-title">Pedidos</h3>
          </div>
          <div class="panel-body" v-show="!loading">
            <vue-table 
              v-if="models.orders.items && !models.orders.state" 
              :table-items="models.orders.items" 
              :table-columns="tableColumns"
              :table-options="tableOptions"
              @toggleCreateModel="models.orders.state = 'creating'"
              >
            </vue-table>
            <modal name="new-model" height="auto" width="1000px" maxWidht="80%">
              <model-new-form
                :form-data="modelNewFormData"
                :modelNewFormOptions="modelNewFormDataOptions"
                @CreatingModelCanceled="models.orders.state=null"
              >
              </model-new-form>
            </modal>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import * as moment from 'moment';
    import 'moment/locale/es';
    import model from '../../mixins/model.js';
    import modelNewForm from '../../components/model/model-new-form.vue';
    import vueModelOptions from '../../components/vue-model-options';
    export default {
        components: {vueModelOptions,modelNewForm},
        mixins: [model],
        props: ['admin'],
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              loading: true,
              header: {},
              body: {},
              footer: {
                totalRows: 0,
              },
              tableColumns: [
                {
                  name: 'itemName',
                  label: 'Material',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'itemName',
                    options: {
                      search:['itemName'],
                      noOptions:false
                    } 
                  },
                  width:'',
                },
                {
                  name: 'userName',
                  label: 'Ordenante',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'userName',
                    options: {
                      search:['userName'],
                      noOptions:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'providerName',
                  label: 'Proveedor',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'providerName',
                    options: {
                      search:['providerName'],
                      noOptions:false
                    } 
                  },
                  width:'',
                },
              ],
              tableOptions: {
                model: 'Orders',
                counterColumn: true,
                actions: ['show','edit','delete'],
                showNew: false,
              },
              modelNewFormData: {
                models: ['country','county','state'],
                fields: {
                  country_id: {
                    label: 'País',
                    rules: [],
                    name: 'country_id',
                    value: null,
                    dontRecord: true,
                    affects: 'state_id',
                    type: {
                      name: 'select',
                      model:'country',
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
                    dontRecord: true,
                    dependsOn: 'country_id',
                    affects: 'county_id',
                    type: {
                      name: 'select',
                      model:'state',
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
                    rules: ['required'],
                    name: 'county_id',
                    value: null,
                    dependsOn: 'state_id',
                    type: {
                      name: 'select',
                      model:'county',
                      text: 'nombre',
                      value:'id',
                      default: {
                        value: null,
                        text: 'Selecciona una Provincia',
                        disabled: true,
                      },
                    },
                  },
                  name: {
                    label: 'Ciudad/Municipio',
                    rules: ['required','min:5','max:64'],
                    name: 'name',
                    value: null,
                    colClasses: 'col-xs-12 col-md-4',
                    type: {
                      name: 'inputText',
                    },
                  },
                  address_real_1: {
                    label: 'Dirección Real 1',
                    rules: ['required','min:5','max:255'],
                    name: 'address_real_1',
                    value: null,
                    colClasses: 'col-xs-12 col-md-4',
                    type: {
                      name: 'inputText',
                    },
                  },
                  address_real_2: {
                    label: 'Dirección Real 2',
                    rules: [],
                    name: 'address_real_2',
                    value: null,
                    colClasses: 'col-xs-12 col-md-4',
                    type: {
                      name: 'inputText',
                    },
                  },
                  address_adv_1: {
                    label: 'Dirección Comercial 1',
                    rules: ['required'],
                    name: 'address_adv_1',
                    value: null,
                    type: {
                      name: 'inputText',
                    },
                  },
                  address_adv_2: {
                    label: 'Dirección Comercial 2',
                    rules: [],
                    name: 'address_adv_2',
                    value: null,
                    type: {
                      name: 'inputText',
                    },
                  },
                  phone_real: {
                    label: 'Telefono Real',
                    rules: ['required'],
                    name: 'phone_real',
                    value: null,
                    type: {
                      name: 'inputText',
                    },
                  },
                  phone_adv: {
                    label: 'Telefono Comercial',
                    rules: ['required'],
                    name: 'phone_adv',
                    value: null,
                    type: {
                      name: 'inputText',
                    },
                  },
                  postal_code: {
                    label: 'Código Postal',
                    rules: ['required'],
                    name: 'postal_code',
                    value: null,
                    type: {
                      name: 'inputText',
                    },
                  },
                  sanitary_code: {
                    label: 'Código Sanitario',
                    rules: [],
                    name: 'sanitary_code',
                    value: null,
                    type: {
                      name: 'inputText',
                    },
                  },
                  email_ext: {
                    label: 'Extensión Email',
                    rules: [],
                    name: 'email_ext',
                    value: null,
                    type: {
                      name: 'inputText',
                    },
                  }
                }
              },
              modelNewFormDataOptions: {
                checkSourceData: true,
              }
            }
        },
        methods: {
          updateFooter(e) {
            this.footer.totalRows = e;
          }
        },
        computed: {
        },
        created() {
          window.events.$emit('loading');
          window.events.$on('rowsSelected', this.updateFooter);
          this.fetchModels(['clinics','orders']);
        },
        mounted() {
          moment.locale('es');
          // this.model.state = 'creating';
        }
    }
</script>
<style type="text/css">
</style>