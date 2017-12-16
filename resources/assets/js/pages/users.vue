<template>
  <div id="users-info-box">
    <div class="panel panel-default">
      <div class="panel-heading text-center" v-if="showElement">
        <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>  Mis Solicitudes</h3>
      </div>
      <div class="panel-heading text-center" v-if="admin">
        <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>Solicitudes</h3>
      </div>
      <div v-show="!loading">
        <div id="filterColumn" class="col-xs-4 col-xs-offset-4" v-show="filtering.state">
            <div class="row buttons" v-if="!filtering.date.state && filtering.showOptions">
                <div class="col-xs-6">
                    <button class="btn btn-sm btn-block btn-info" @click="selectAllFilters">Todos/Ninguno</button>
                </div>
                <div class="col-xs-6">
                    <button class="btn btn-sm btn-block btn-info" @click="invertSelectionFilters">Invertir Selección</button>
                </div>
            </div>
            <div class="row dates" v-if="filtering.date.state">
              <form>
                <div class="col-xs-6 form-group">
                  <label for="start-date">Desde:</label>
                  <input class="form-control" type="date" name="start-date" v-model="filtering.date.start">
                </div>
                <div class="col-xs-6 form-group">
                  <label for="end-date">Hasta:</label>
                  <input class="form-control" type="date" name="end-date" v-model="filtering.date.end">
                </div>
                <div class="col-xs-12 form-group">
                  <button class="btn btn-sm btn-block btn-primary form-control" @click.prevent="filterDates(filtering.name)">Aplicar</button>
                </div>
              </form>
            </div>
            <div class="row dates" v-if="filtering.search.state">
              <form @submit.prevent="">
                <div class="col-xs-12 form-group">
                  <label for="search">Buscar:</label>
                  <input class="form-control" type="text" name="search" v-model="filtering.search.string" @keyup="searchString">
                </div>
              </form>
            </div>
            <ul class="list-group" v-if="!filtering.date.state && filtering.state && filtering.showOptions">
                <li v-for="filter in filtering.filters[filtering.name].keys" class="col-xs-6 list-item">
                    <input type="checkbox" name="" @click="toggleFilterItem(filter.keys, filter.state, filtering.name)" v-model="filter.state"><span v-text="filter.label"></span>
                </li>
            </ul>
            <button class="btn btn-sm btn-block btn-info" @click="toggleFiltering">Cerrar</button>
        </div>
        <div class="row" v-if="!userSelected">
          <div class="form-group col-xs-12 col-sm-10 col-sm-offset-1">
            <button 
              class="btn btn-sm btn-info btn-block clear-filters" 
              v-if="Object.keys(this.filtering.filters).length"
              @click.prevent="clearAllFilters"
              ><h4>Borrar Filtros</h4>
            </button>
          </div>
        </div>
        <div class="panel-body">
          <div :class="panelClass">
            <table 
              class="table table-responsive" 
              v-if="admin && !this.userSelected"
              >
              <thead>
                <tr>
                  <th class="clinic">
                    Nombre
                    <p>
                        <span :class="orderClasses('lastname1')" @click="orderColumn('lastname1')"></span>
                        <span :class="filterClasses('lastname1')" @click="filterColumn('lastname1',{search:['name','lastname1','lastname2'],noOptions:true})"></span>
                    </p>
                  </th>
                  <th class="clinic">
                    Especialidades
                    <p>
                        <span :class="orderClasses('name')" @click="orderColumn('name')"></span>
                        <span :class="filterClasses('name')" @click="filterColumn('name',{object:'especialties'})"></span>
                    </p>
                  </th>
                  <th class="hidden-xs">
                    Nº Solicitudes
                    <p>
                        <span :class="orderClasses('requestsCount')" @click="orderColumn('requestsCount',{integer:true})"></span>
                        <span :class="filterClasses('requestsCount')" @click="filterColumn('requestsCount',{numeric:true})"></span>
                    </p>
                  </th>
                  <th class="clinic">
                    Nº Clínicas
                    <p>
                        <span :class="orderClasses('clinicsCount')" @click="orderColumn('clinicsCount',{integer:true})"></span>
                        <span :class="filterClasses('clinicsCount')" @click="filterColumn('clinicsCount',{numeric:true})"></span>
                    </p>
                  </th>
                  <th class="clinic">
                    Email
                    <p>
                        <span :class="orderClasses('email')" @click="orderColumn('email')"></span>
                        <span :class="filterClasses('email')" @click="filterColumn('email',{search:['email'],noOptions:true})"></span>
                    </p>
                  </th>
                  <th class="hidden-xs">
                    Teléfono
                    <p>
                        <span :class="orderClasses('phone')" @click="orderColumn('phone')"></span>
                        <span :class="filterClasses('phone')" @click="filterColumn('phone')"></span>
                    </p>
                  </th>
                  <th class="hidden-xs">
                    Año de Licencia
                    <p>
                        <span :class="orderClasses('license_year')" @click="orderColumn('license_year',{integer:true})"></span>
                        <span :class="filterClasses('license_year')" @click="filterColumn('license_year',{integer:true})"></span>
                    </p>
                  </th>
                  <th class="icons">
                    Estado
                    <p>
                        <span :class="orderClasses('last_access')" @click="orderColumn('last_access',{object:'user'})"></span>
                        <span :class="filterClasses('last_access')" @click="filterColumn('last_access',{object:'user',boolean:['Offline','Online']})"></span>
                    </p>
                  </th>
                  <th class="buttons-text icons"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users" v-show="checkFilter(user.id)">
                  <td><strong>{{user.lastname1}} {{user.lastname2}}, {{user.name}}</strong></td>
                  <td><strong v-html="parseEspecialties(index)"></strong></td>
                  <td><strong><a 
                    :href="'/requests?user[0]='
                          +user.id+'&user[1]='
                          +userCompleteName(index)
                    ">{{user.requestsCount}}
                  </a></strong</td>
                  <td class="hidden-xs">{{user.clinicsCount}}</td>
                  <td class="hidden-xs"><a :href="'mailTo:'+user.email">{{user.email}}</a></td>
                  <td class="hidden-xs">{{user.phone}}
                    <td class="hidden-xs" v-text="user.license_year"></td>
                  </td>
                  <td>
                    <div :class="requestClasses(user.user.last_access)">
                      <span class="hidden-xs" v-text="requestText(user.user.last_access)">
                      </span>
                      <span :class="requestIcon(user.user.last_access)"></span>
                    </div>
                  </td>
                  <td>
                    <button 
                        type="button" 
                        class="btn btn-primary btn-sm"
                        @click="toggleShowDetails(index)"
                        >
                        <span class="hidden-xs">Detalles
                        </span>
                        <span class="glyphicon glyphicon-arrow-right visible-xs-block"></span>
                      </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row" v-if="this.admin && this.userSelected">
          <div class="col-xs-12 col-md-10 col-md-offset-1">
            <div class="col-xs-12 col-sm-4 vcenter">
              <div class="alert alert-info form-group">
                <h3><strong>{{userSelected.name}} {{userSelected.lastname1}}</strong></h3>
                <p>Email: <strong>{{userSelected.email}}</strong></p>
                <p>Teléfono: <strong>{{userSelected.phone}}</strong></p>
                <p>DNI: <strong>{{userSelected.personal_id_number}}</strong></p>
                <p>Licencia: <strong>{{userSelected.license_number}}</strong></p>
                <p>Año Licencia: <strong>{{userSelected.license_year}}</strong></p>
                <p>Especialidades: <strong v-html="parseEspecialties(0,userSelected.especialties,true)"></strong></p>
                <p>Último Acceso: <strong>{{userSelected.user.last_access ? userSelected.user.last_access : 'Nunca'}}</strong></p>
              </div>
<!--               <div class="row" v-if="extratimeSelected.state == 1">
                <div class="form-group col-xs-6">
                  <button class="btn btn-success btn-block btn-sm"
                  @click="closeExtratime(extratimeSelected.id,2)"
                  >Aceptar
                  </button>
                </div>
                <div class="form-group col-xs-6">
                  <button class="btn btn-danger btn-block btn-sm"
                  @click="closeExtratime(extratimeSelected.id,0)"
                  >Denegar
                  </button>
                </div>
              </div>
              <div class="row" v-if="extratimeSelected.state == 2">
                <div class="form-group col-xs-12 alert alert-success">
                  <p>Aceptada el: <strong>{{extraDate(extratimeSelected.updated_at)}}</strong></p>
                </div>
              </div>
              <div class="row" v-if="extratimeSelected.state == 0">
                <div class="form-group col-xs-12 alert alert-danger">
                  <p>Denegada el: <strong>{{extraDate(extratimeSelected.updated_at)}}</strong></p>
                </div>
              </div> -->
              <div class="row">
                <div class="form-group col-xs-12">
                  <button class="btn btn-info btn-block btn-sm" @click="toggleShowDetails">Volver</button>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-8 tutorial-prompt vcenter">
              <schedule
                :profileSelected="userSelected"
                :admin="true"
                >
              </schedule>
            </div>
          </div>
        </div>
        <div class="panel-footer">
          <div class="progress">
            <div 
              class="progress-bar progress-bar-primary progress-bar-striped" :style="profileusers.barStyle"
              v-if="profileusers.ratio > 10"
              >
              <span>{{profileusers.barText}}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import * as moment from 'moment';
    import 'moment/locale/es';
    import tableFiltering from '../mixins/table-filtering.js';
    import tableOrdering from '../mixins/table-ordering.js';
    export default {
        components: {},
        mixins: [tableFiltering,tableOrdering],
        props: ['page','admin'],
        data() {
            return {
              loading: true,
              // showRequest: {
              //   method: false,
              //   request: {},
              //   requestClinic: [],
              // },
              profileSrc: {
                users: [],
              },
              profileusers: {
                resolved: 0,
                total: 0,
                barStyle: '',
                barText: '',
                ratio: 0,
              },
              labs: [],
              types: [],
              details: [],
              addRequest: {
                  method: false,
                  topButtonText: 'Nueva Solicitud',
                  topButtonClasses: 'btn btn-sm btn-info',
                  topButtonIcon: 'glyphicon glyphicon-plus-sign',
              },
              showElement: true,
              users: {},
              userSelected: false,
            }
        },
        watch: {
        },
        methods: {
          startFilters() {
            if (this.filtering.filters['last_access']) {
              delete(this.filtering.filters['last_access']);
            }
            this.filterColumn('last_access',{object:'user',boolean:['Offline','Online']});
            this.filtering.state = false;
            let empty = true;
            for (let item of this.filtering.filters['last_access'].keys) {
              if (item.label == 'Online') {
                console.log(item.keys);
                empty = false;
                this.toggleFilterItem(item.keys, 'checked', this.filtering.name);
              }
            }
            if (empty) {
              delete(this.filtering.filters['last_access']);
            }
            this.filtering.name = '';
          },
          applyUrlFilters() {
            // Example with Array
            // ?created_at[0]=2017-12-01&created_at[1]=2017-01-01&closed_at=Pendiente
            let search = getAllUrlParams();
            for (let filter in search) {
              search[filter] = search[filter].replace(/%20/g, " ");
              if (filter == 'created_at') {
                this.filterColumn('created_at',{date:true});
                this.filtering.date.end = search['created_at'][0];
                this.filtering.date.start = search['created_at'][1];
                this.filtering.date.state = true;
                this.filterDates('created_at');
                this.filtering.state = false;
              } else {
                this.filterColumn(filter);
                this.filtering.state = false;
                let ids = [];
                for (let item of this.filtering.filters[filter].keys) {
                  let cleanName = cleanUpSpecialChars(item.label.toLowerCase());
                  if (cleanName != search[filter]) {
                    ids = item.keys;
                    console.log('Search Filter: '+search[filter]);
                    this.toggleFilterItem(ids, 'checked', filter);
                  }
                }
              }
            }
          },
          hideIfPage() {
            if (this.page == 'home' || this.admin) {
              this.showElement = false;
            }
          },
          toggleShowRequest(request) {
            return;
            // if (this.showRequest.method) {
            //   this.showRequest.method = false;
            //   this.showRequest.request = {};
            //   this.showRequest.requestClinic = [];
            // } else {
            //   this.showRequest.request = request;
            //   this.showRequest.requestClinic.push(request.clinic);
            //   this.showRequest.method = true;
            // }
          },
          toggleAddRequest() {
            if (!this.addRequest.method) {
              this.addRequest.method = true;
              this.addRequest.topButtonText = 'Cancelar';
              this.addRequest.topButtonClasses = 'btn btn-sm btn-danger';
              this.addRequest.topButtonIcon = 'glyphicon glyphicon-remove';
            } else {
              this.addRequest.method = false;
              this.addRequest.topButtonText = 'Nueva Solicitud';
              this.addRequest.topButtonClasses = 'btn btn-sm btn-info';
              this.addRequest.topButtonIcon = 'glyphicon glyphicon-plus-sign';
            }
          },
          requestDate(orgDate) {
            let date = moment(orgDate).format('L');
            return date;
          },
          requestClasses(closeDate) {
            if (!closeDate) {
              return 'label label-warning list-badget';
            }
            return 'label label-success list-badget';
          },
          requestText(closeDate) {
            if (!closeDate) {
              return 'Offline';
            }
            return 'Online';
          },
          requestIcon(closeDate) {
            if (!closeDate) {
              return 'glyphicon glyphicon-question-sign visible-xs-block';
            }
            return 'glyphicon glyphicon-ok-sign visible-xs-block';
          },
          calculateRatio() {
            this.profileusers.total = 0;
            this.profileusers.resolved = 0;
            let origin = this.profileSrc.users;
            if (this.admin) {
              origin = this.users;
            }
            for (let request of origin) {
              this.profileusers.total++;
              if (request.closed_at) {
                this.profileusers.resolved++;
              }
            }
            let ratio = Math.floor((this.profileusers.resolved*100)/this.profileusers.total);
            if (isNaN(ratio)) ratio = 0;
            this.profileusers.ratio = ratio;
            this.profileusers.barStyle = 'width: '+ratio+'%';
            this.profileusers.barText = ratio+'% Resueltas';
          },
          notifyAdded() {
            flash({
                message: 'Solicitud enviada.', 
                label: 'success'
            });
            this.toggleAddRequest();
            this.fetchProfile();
          },
          closeRequest() {
            axios.patch('/users/'+this.showRequest.request.id, {
              'request': this.showRequest.request,
              }).catch((error) => {
                  if (error.response.data.errors) {
                    for (let item in error.response.data.errors) {
                        flash({
                            message: error.response.data.errors[item][0], 
                            label: 'danger'
                        });
                      }
                  }
                  if (error.response.data.message && error.response.status == 400) {
                    return flash({
                          message: error.response.data.message, 
                          label: 'danger'
                      });
                  }
                }).then(response => {
                    if (response.status == 200) {
                      flash({
                          message: 'Solicitud cerrada.', 
                          label: 'success'
                      });
                      this.notifyClosed(this.showRequest.request.id);
                      window.events.$emit('requestClosed');
                      this.toggleShowRequest();
                    }
                });
          },
          notifyClosed(id) {
            for (let request of this.users) {
              if (request.id == id) {
                request.closed_at = moment().format();
                break;
              }
            }
            this.startFilters();
            this.calculateRatio();
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
          parseEspecialties(index,object,string) {
            let especialties = [];
            let glue = '<br>';
            if (string) {glue = ', '}
            if (object) {
              for (let especialty of object) {
                if (especialties.indexOf(especialty.name) == -1) {
                  especialties.push(especialty.name);
                }
              }
              return especialties.join(glue);
            }
            let source = '';
            if (App.role == 'admin') {
              source = 'users';
            } else {
              source = 'users';
            }
            for (let especialty of this[source][index].especialties) {
              if (especialties.indexOf(especialty.name) == -1) {
                especialties.push(especialty.name);
              }
            }
            return especialties.join(glue);
          },
          userCompleteName(index) {
            let lastname2 = this.users[index].lastname2 ? this.users[index].lastname2 : '';
            let fullname = this.users[index].name+' '+this.users[index].lastname1+' '+lastname2;
            return cleanUpSpecialChars(fullname.toLowerCase());
          },
          toggleShowDetails(id=null, extratime=null) {
            if (this.userSelected) {
              console.log('Toggleling')
              this.userSelected = false;
            } else {
              this.userSelected = this.users[id];
            }
          },
          fetchUsers() {
            axios.get('/api/users')
              .then(data => {
                if (data.data.users) {
                  this.users = data.data.users;
                  this.userEspecialtiesBuilder();
                  this.buildFiltering('users');
                  this.buildOrdering('users');
                  this.selectAllItems();
                  this.startFilters();
                  this.loading = false;
                  window.events.$emit('loaded');
                  // this.applyUrlFilters();
                  // this.orderColumn('license_year',{order:'desc'});
                }
                // this.calculateRatio();
              });
          },
        },
        computed: {
          panelClass() {
            if (this.admin) {
              return 'panel-body-admin';
            } else {
              return 'panel-body';
            }
          }
        },
        created() {
          window.events.$emit('loading');
        },
        mounted() {
          moment.locale('es');
          this.fetchUsers();
          this.hideIfPage();
        }
    }
</script>
<style type="text/css">
</style>