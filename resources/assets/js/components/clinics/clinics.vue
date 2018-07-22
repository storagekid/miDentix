<template>
  <div id="clinics-home" class="fx pv-20">
     <template>
      <modal name="new-model" height="auto" width="1000px" maxWidht="80%">
        <model-new-form
            :form-data="modelNewFormData"
            :modelNewFormOptions="modelNewFormDataOptions"
          >
        </model-new-form>
      </modal>
    </template>
    <template>
      <modal name="delete-model" height="auto" width="1000px" maxWidht="80%">
        <div class="fx jf-center">
          <div class="fx-100 panel panel-default">
            <div class="panel-heading text-center">
              <h3 class="panel-title">Eliminar Registros</h3>
            </div>
            <div class="panel-body">
              <button 
              class="btn btn-warning btn-sm" 
                @click.prevent="$modal.hide('delete-model')"
                >
                Cancelar
              </button>
              <button 
              class="btn btn-primary btn-sm" 
                @click.prevent="createNew"
                >
                Eliminar
              </button>
            </div>
          </div>
        </div>
      </modal>
    </template>
    <template v-if="$store.getters.ready">
      <div class="panel panel-default">
        <div class="panel-heading text-center">
          <h3 class="panel-title">Clínicas</h3>
        </div>
        <div class="panel-body">
          <vue-table
            :model="'clinics'"
            :mode="'vuex'" 
            :table-columns="tableColumns"
            :table-options="tableOptions"
            >
          </vue-table>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
    import modelNewForm from '../../components/model/model-new-form.vue';
    import vueModelOptions from '../../components/vue-model-options';
    export default {
        components: {vueModelOptions,modelNewForm},
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
                  show: false,
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
                  show: false,
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
                  show: false,
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
                  show: false,
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
                  name: 'countyName',
                  label: 'Provincia',
                  show: true,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key: 'countyName',
                    options: {
                      search:['countyName'],
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
                model: 'clinics',
                counterColumn: true,
                actions: ['show','edit','delete'],
                showNew: true,
              },
              modelNewFormData: {
                model: 'clinics',
                models: ['countries','counties','states'],
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
                    dontRecord: true,
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
                    rules: ['required'],
                    name: 'county_id',
                    value: null,
                    dependsOn: 'state_id',
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
                  city: {
                    label: 'Ciudad/Municipio',
                    rules: ['required','min:5','max:64'],
                    name: 'city',
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
          },
        },
        computed: {
          // items() {
          //   return this.$store.state.models['clinics'].items;
          // },
        },
        created() {
          window.events.$on('rowsSelected', this.updateFooter);
          this.$store.dispatch('fetchModels', ['clinics']);
        },
        mounted() {
          // this.$store.dispatch('fetchModels',['clinics']);
          // this.$store.dispatch('setTableClass',{name:'Patata'});          
          // this.$store.dispatch('setTable',
          //   {
          //     name:'clinics',
          //     options:{
          //       model: 'clinics',
          //       counterColumn: true,
          //       actions: ['show','edit','delete'],
          //       showNew: true,
          //     },
          //     columns: [
          //       {
          //         name: 'fullName',
          //         label: 'Clínica',
          //         show: true,
          //         linebreak: {
          //           needles: ['(','esq.'],
          //           options: {
          //             small: true
          //           }
          //         },
          //         sorting: {
          //           active: true,
          //         },
          //         filtering: {
          //           active: true,
          //           key:'fullName',
          //           options: {
          //             search:['fullName'],
          //             noOptions:true
          //           } 
          //         },
          //         width:'',
          //       },
          //       {
          //         name: 'city',
          //         label: 'Ciudad',
          //         show: false,
          //         sorting: {
          //           active: true,
          //         },
          //         filtering: {
          //           active: true,
          //           key:'city',
          //           options: {
          //             search:['city'],
          //             noOptions:true
          //           } 
          //         },
          //         width:'',
          //       },
          //       {
          //         name: 'address_real_1',
          //         label: 'Dirección real 1',
          //         show: true,
          //         sorting: {
          //           active: true,
          //         },
          //         filtering: {
          //           active: true,
          //           key:'address_real_1',
          //           options: {
          //             search:['address_real_1'],
          //             noOptions:true
          //           } 
          //         },
          //         width:'',
          //       },
          //       {
          //         name: 'address_real_2',
          //         label: 'Dirección real 2',
          //         show: false,
          //         sorting: {
          //           active: true,
          //         },
          //         filtering: {
          //           active: true,
          //           key:'address_real_2',
          //           options: {
          //             search:['address_real_2'],
          //             noOptions:true
          //           } 
          //         },
          //         width:'',
          //       },
          //       {
          //         name: 'address_adv_1',
          //         label: 'Dirección adv 1',
          //         show: false,
          //         sorting: {
          //           active: true,
          //         },
          //         filtering: {
          //           active: true,
          //           key:'address_adv_1',
          //           options: {
          //             search:['address_adv_1'],
          //             noOptions:true
          //           } 
          //         },
          //         width:'',
          //       },
          //       {
          //         name: 'address_adv_2',
          //         label: 'Dirección adv 2',
          //         show: false,
          //         sorting: {
          //           active: true,
          //         },
          //         filtering: {
          //           active: true,
          //           key:'address_adv_2',
          //           options: {
          //             search:['address_adv_2'],
          //             noOptions:true
          //           } 
          //         },
          //         width:'',
          //       },
          //       {
          //         name: 'postal_code',
          //         label: 'CP',
          //         show: true,
          //         sorting: {
          //           active: true,
          //         },
          //         filtering: {
          //           active: true,
          //           key:'postal_code',
          //           options: {
          //             search:['postal_code'],
          //             noOptions:true
          //           } 
          //         },
          //         width:'',
          //       },
          //       {
          //         name: 'phone_real',
          //         label: 'Tel. Real',
          //         show: true,
          //         sorting: {
          //           active: true,
          //         },
          //         filtering: {
          //           active: true,
          //           key:'phone_real',
          //           options: {
          //             search:['phone_real'],
          //             noOptions:true
          //           } 
          //         },
          //         width:'',
          //       },
          //       {
          //         name: 'phone_adv',
          //         label: 'Tel. Comercial',
          //         show: false,
          //         sorting: {
          //           active: true,
          //         },
          //         filtering: {
          //           active: true,
          //           key:'phone_adv',
          //           options: {
          //             search:['phone_adv'],
          //             noOptions:true
          //           } 
          //         },
          //         width:'',
          //       },
          //       {
          //         name: 'email_ext',
          //         label: 'Email',
          //         show: true,
          //         sorting: {
          //           active: true,
          //         },
          //         filtering: {
          //           active: true,
          //           key:'email_ext',
          //           options: {
          //             search:['email_ext'],
          //             noOptions:true
          //           } 
          //         },
          //         width:'',
          //       },
          //       {
          //         name: 'sanitary_code',
          //         label: 'Código Sanitario',
          //         show: false,
          //         sorting: {
          //           active: true,
          //         },
          //         filtering: {
          //           active: true,
          //           key:'sanitary_code',
          //           options: {
          //             search:['sanitary_code'],
          //             noOptions:true
          //           } 
          //         },
          //         width:'',
          //       },
          //       {
          //         name: 'countyName',
          //         label: 'Provincia',
          //         show: true,
          //         sorting: {
          //           active: true,
          //         },
          //         filtering: {
          //           active: true,
          //           key: 'countyName',
          //           options: {
          //             search:['countyName'],
          //             noOptions:false,
          //           },
          //         },
          //         width:'',
          //       },
          //       {
          //         name: 'stateName',
          //         label: 'CCAA',
          //         show: true,
          //         linebreak: {
          //           needles: [','],
          //           options: {
          //             small: true
          //           }
          //         },
          //         sorting: {
          //           active: true,
          //         },
          //         filtering: {
          //           active: true,
          //           key: 'stateName',
          //           options: {
          //             search:['stateName'],
          //             noOptions:false,
          //           },
          //         },
          //         width:'',
          //       },
          //       {
          //         name: 'countryName',
          //         label: 'País',
          //         show: true,
          //         sorting: {
          //           active: true,
          //         },
          //         filtering: {
          //           active: true,
          //           key: 'countryName',
          //           options: {
          //             search:['countryName'],
          //             noOptions:false,
          //           },
          //         },
          //         width:'',
          //       },
          //     ],
          // });
        }
    }
</script>
<style type="text/css">
</style>