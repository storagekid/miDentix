<template>
  <div id="users-info-box">
    <div class="row">
      <div class="col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading text-center" v-if="admin">
            <h3 class="panel-title">Clínicas</h3>
          </div>
          <div class="panel-body" v-show="!loading">
            <vue-table 
              v-if="model.items && !model.state" 
              :table-items="model.items" 
              :table-columns="tableColumns"
              :table-options="tableOptions"
              @toggleCreateModel="model.state = 'creating'"
              >
            </vue-table>
            <model-new-form
              v-if="model.state == 'creating'"
              :form-data="modelNewFormData"
              :modelNewFormOptions="modelNewFormDataOptions"
              @CreatingModelCanceled="model.state=null"
              >
            </model-new-form>
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
    import vueTable from '../../components/vue-table';
    import vueModelOptions from '../../components/vue-model-options';
    export default {
        components: {vueTable,vueModelOptions,modelNewForm},
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
                  name: 'fullName',
                  label: 'Clínica',
                  show: true,
                  linebreak: {
                    needles: ['(','esq.'],
                    options: {
                      small: true
                    }
                  },
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'fullName',
                    options: {
                      search:['fullName'],
                      noOptions:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'city',
                  label: 'Ciudad',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'city',
                    options: {
                      search:['city'],
                      noOptions:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'address_real_1',
                  label: 'Dirección real 1',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'address_real_1',
                    options: {
                      search:['address_real_1'],
                      noOptions:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'address_real_2',
                  label: 'Dirección real 2',
                  show: false,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'address_real_2',
                    options: {
                      search:['address_real_2'],
                      noOptions:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'address_adv_1',
                  label: 'Dirección adv 1',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'address_adv_1',
                    options: {
                      search:['address_adv_1'],
                      noOptions:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'address_adv_2',
                  label: 'Dirección adv 2',
                  show: false,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'address_adv_2',
                    options: {
                      search:['address_adv_2'],
                      noOptions:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'postal_code',
                  label: 'CP',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'postal_code',
                    options: {
                      search:['postal_code'],
                      noOptions:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'phone_real',
                  label: 'Tel. Real',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'phone_real',
                    options: {
                      search:['phone_real'],
                      noOptions:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'phone_adv',
                  label: 'Tel. Comercial',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'phone_adv',
                    options: {
                      search:['phone_adv'],
                      noOptions:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'email_ext',
                  label: 'Email',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'email_ext',
                    options: {
                      search:['email_ext'],
                      noOptions:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'sanitary_code',
                  label: 'Código Sanitario',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'sanitary_code',
                    options: {
                      search:['sanitary_code'],
                      noOptions:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'provinciaName',
                  label: 'Provincia',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key: 'provinciaName',
                    options: {
                      search:['provinciaName'],
                      noOptions:false,
                    },
                  },
                  width:'',
                },
                {
                  name: 'stateName',
                  label: 'CCAA',
                  show: true,
                  linebreak: {
                    needles: [','],
                    options: {
                      small: true
                    }
                  },
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key: 'stateName',
                    options: {
                      search:['stateName'],
                      noOptions:false,
                    },
                  },
                  width:'',
                },
                {
                  name: 'countryName',
                  label: 'País',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key: 'countryName',
                    options: {
                      search:['countryName'],
                      noOptions:false,
                    },
                  },
                  width:'',
                },
              ],
              tableOptions: {
                model: 'Clinic',
                counterColumn: true,
                actions: ['show','edit','delete'],
                showNew: true,
              },
              modelNewFormData: {
                models: ['country','provincia','state'],
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
                    affects: 'provincia_id',
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
                  provincia_id: {
                    label: 'Provincia',
                    rules: ['required'],
                    name: 'provincia_id',
                    value: null,
                    dependsOn: 'state_id',
                    type: {
                      name: 'select',
                      model:'provincia',
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
          fetchModel() {
            axios.get('/api/'+this.model.name)
              .then(data => {
                if (data.data.model) {
                  this.model.items = data.data.model;
                  this.loading = false;
                  window.events.$emit('loaded');
                }
              });
          },
          updateFooter(e) {
            this.footer.totalRows = e;
          }
        },
        computed: {
        },
        created() {
          window.events.$emit('loading');
          window.events.$on('rowsSelected', this.updateFooter);
        },
        mounted() {
          moment.locale('es');
          this.fetchModel();
          this.model.state = 'creating';
        }
    }
</script>
<style type="text/css">
</style>