<template>
  <div id="users-info-box">
    <div class="rows">
      <div class="col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading text-center" v-if="admin">
            <h3 class="panel-title"></span>Clínicas</h3>
          </div>
          <div class="panel-body" v-show="!loading">
            <vue-table 
              v-if="model.items" 
              :table-items="model.items" 
              :table-columns="tableColumns"
              :table-options="tableOptions"
              >
            </vue-table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import * as moment from 'moment';
    import 'moment/locale/es';
    import vueTable from '../components/vue-table';
    import vueModelOptions from '../components/vue-model-options';
    export default {
        components: {vueTable,vueModelOptions},
        props: ['admin','model','tableData'],
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              loading: true,
              model: {
                name: 'clinics',
                items: null,
              }, 
              tableColumns: [
                {
                  name: 'fullName',
                  label: 'Clínica',
                  show: true,
                  linebreak: {
                    needles: ['(','esq.'],
                    small: true
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
              ],
              tableOptions: {
                model: function (){return this.model.name},
                counterColumn: true,
                actions: ['show','edit','delete'],
                showNew: true,
              },
              header: {},
              body: {},
              footer: {
                totalRows: 0,
              },
            }
        },
        methods: {
          exportExcel() {
            axios({
              url: '/export-excel',
              method: 'POST',
              responseType: 'blob', // important
              data: {
                model:'Profile', ids:this.filtering.selected
              }
            }).then((response) => {
              const url = window.URL.createObjectURL(new Blob([response.data]));
              const link = document.createElement('a');
              link.href = url;
              link.setAttribute('download', 'usuarios miGabinete '+moment().format()+'.xlsx');
              document.body.appendChild(link);
              link.click();
            });
          },
          // userEspecialtiesBuilder() {
          //   for (let user of this.users) {
          //     let especialties = [];
          //     let ids = [];
          //     for (let schedule of user.schedules) {
          //       for (let especialty of schedule.especialties) {
          //         if (ids.indexOf(especialty.id) == -1) {
          //           ids.push(especialty.id);
          //           especialties.push(especialty);
          //         }
          //       } 
          //     }
          //     user.especialties = especialties;
          //   }
          // },
          fetchModel() {
            axios.get('/api/'+this.model.name)
              .then(data => {
                if (data.data.model) {
                  this.model.items = data.data.model;
                  // this.userEspecialtiesBuilder();
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
        }
    }
</script>
<style type="text/css">
</style>