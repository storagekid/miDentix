<template>
  <div id="users-info-box">
    <div class="rows">
      <div class="col-xs-9">
        <div class="panel panel-default">
          <div class="panel-heading text-center" v-if="admin">
            <h3 class="panel-title"></span>Odontólogos</h3>
          </div>
          <div class="panel-body" v-show="!loading">
            <vue-table 
              v-if="users" 
              :table-items="users" 
              :table-columns="tableColumns"
              :table-options="tableOptions"
              >
            </vue-table>
          </div>
        </div>
      </div>
      <div class="col-xs-3">
        <div class="panel panel-default">
          <div class="panel-heading text-center" v-if="admin">
            <h3 class="panel-title"></span>Opciones</h3>
          </div>
          <div class="panel-body" v-show="!loading">
            <vue-model-options
              v-if="users" 
              :table-items="users" 
              :table-columns="tableColumns"
              :table-options="tableOptions"
            >
            </vue-model-options>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import * as moment from 'moment';
    import 'moment/locale/es';
    import vueModelOptions from '../components/vue-model-options';
    export default {
        components: {vueModelOptions},
        props: ['page','admin'],
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              loading: true,
              users: null,
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
                      noOptions:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'especialties',
                  label: 'Especialidades',
                  show: true,
                  parse: ['especialties',false],
                  sorting: {
                    active: false,
                  },
                  filtering: {
                    active: true,
                    key: 'name',
                    options: {
                      object:'especialties'
                    } 
                  },
                  width:'',
                },
                {
                  name: 'requestsCount',
                  label: 'Nº Reclamaciones',
                  show: true,
                  sorting: {
                    active: true,
                    options: {
                      integer:true
                    }
                  },
                  filtering: {
                    active: true,
                    key: 'requestsCount',
                    options: {
                      numeric: true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'clinicsCount',
                  label: 'Nº Clínicas',
                  show: true,
                  sorting: {
                    active: true,
                    options: {
                      integer:true
                    }
                  },
                  filtering: {
                    active: true,
                    key: 'clinicsCount',
                    options: {
                      numeric: true
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
                  linkable: {
                    target: 'mailto:'
                  },
                  width:'',
                },
                {
                  name: 'phone',
                  label: 'Phone',
                  show: false,
                  sorting: {
                    active: true,
                  },
                  filtering: {
                    active: true,
                    key:'phone',
                    options: {
                      search: ['phone'],
                      noOptions: true
                    }
                  },
                  linkable: {
                    target: 'tel:'
                  },
                  width:'',
                },
                {
                  name: 'license_year',
                  label: 'Año de Licencia',
                  show: true,
                  sorting: {
                    active: true,
                    options: {
                      integer:true
                    }
                  },
                  filtering: {
                    active: true,
                    key: 'license_year',
                    options: {
                      integer:true
                    } 
                  },
                  width:'',
                },
                {
                  name: 'last_access',
                  label: 'Estado',
                  show: true,
                  object: 'user',
                  boolean: ['Offline','Online'],
                  sorting: {
                    active: true,
                    options: {
                      object: 'user'
                    }
                  },
                  filtering: {
                    active: true,
                    key: 'last_access',
                    options: {
                      object: 'user',
                      boolean: ['Offline','Online']
                    } 
                  },
                  width:'',
                },
              ],
              tableOptions: {
                model: 'profiles',
                counterColumn: true,
                actions: ['show','edit','delete'],
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
          userEspecialtiesBuilder() {
            for (let user of this.users) {
              let especialties = [];
              let ids = [];
              for (let schedule of user.schedules) {
                for (let especialty of schedule.especialties) {
                  if (ids.indexOf(especialty.id) == -1) {
                    ids.push(especialty.id);
                    especialties.push(especialty);
                  }
                } 
              }
              user.especialties = especialties;
            }
          },
          fetchUsers() {
            axios.get('/api/dentists')
              .then(data => {
                if (data.data.users) {
                  this.users = data.data.users;
                  this.userEspecialtiesBuilder();
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
          this.fetchUsers();
        }
    }
</script>
<style type="text/css">
</style>