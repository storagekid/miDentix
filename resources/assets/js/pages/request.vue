<template>
  <div id="requests-info-box">
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
        <div class="row" v-if="!showRequest.method">
          <div class="form-group col-xs-12 col-sm-10 col-sm-offset-1">
            <button 
              class="btn btn-sm btn-info btn-block clear-filters" 
              v-if="Object.keys(this.filtering.filters).length"
              @click.prevent="clearAllFilters"
              ><h4>Borrar Filtros</h4>
            </button>
          </div>
        </div>
        <div :class="panelClass">
          <a href="#" 
            class="text-center" 
            style="display: inherit;" 
            v-if="!showRequest.method && showElement"
            @click.prevent="toggleAddRequest">
            <button type="button" :class="addRequest.topButtonClasses">
              <h3><span :class="addRequest.topButtonIcon"></span>{{addRequest.topButtonText}}</h3>
            </button>
          </a>
          <new-request
            :newRequest="addRequest.method"
            :clinics="admin ? showRequest.requestClinic : profileSrc.clinics"
            :types="types" 
            :details="details"
            :labs="labs"
            :profileId="profileSrc.id"
            :request="showRequest.request"
            @added="notifyAdded"
            v-if="addRequest.method || showRequest.method"
            >
          </new-request>
          <table 
            class="table table-responsive" 
            v-if="!addRequest.method && !showRequest.method && !admin && profileRequests.total"
            >
            <thead>
              <tr>
                <th class="clinic">Clínica</th>
                <th class="hidden-xs">Tipo</th>
                <th v-if="showElement">Detalle</th>
                <th class="hidden-xs">Fecha</th>
                <th v-if="showElement" class="hidden-xs">Texto</th>
                <th class="icons">Estado</th>
                <th v-if="showElement" class="buttons-text icons"></th>
              </tr>
            </thead>
            <tbody v-if="page == 'home'">
              <tr v-for="request in requests.slice(0,5)">
                <td><strong>{{request.clinic.city}}</strong><br>({{request.clinic.address_real_1}})</td>
                <td>{{request.type}}</td>
                <td v-if="showElement" class="hidden-xs">{{request.type_detail1 ? request.type_detail1 : '-'}}</td>
                <td class="hidden-xs" v-text="requestDate(request.created_at)"></td>
                <td v-if="showElement" class="hidden-xs">{{request.description.substring(0,50)+'...'}}
                </td>
                <td>
                  <div :class="requestClasses(request.closed_at)">
                    <span class="hidden-xs" v-text="requestText(request.closed_at)">
                    </span>
                    <span :class="requestIcon(request.closed_at)"></span>
                  </div>
                </td>
                <td v-if="showElement">
                  <button 
                    type="button" 
                    class="btn btn-sm btn-primary"
                    @click="toggleShowRequest(request)"
                    >
                    <span class="hidden-xs">Detalles
                    </span>
                    <span class="glyphicon glyphicon-arrow-right visible-xs-block"></span>
                  </button>
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr v-for="request in requests">
                <td><strong>{{request.clinic.city}}</strong><br>({{request.clinic.address_real_1}})</td>
                <td>{{request.type}}</td>
                <td v-if="showElement" class="hidden-xs">{{request.type_detail1 ? request.type_detail1 : '-'}}</td>
                <td class="hidden-xs" v-text="requestDate(request.created_at)"></td>
                <td v-if="showElement" class="hidden-xs">{{request.description.substring(0,50)+'...'}}
                </td>
                <td>
                  <div :class="requestClasses(request.closed_at)">
                    <span class="hidden-xs" v-text="requestText(request.closed_at)">
                    </span>
                    <span :class="requestIcon(request.closed_at)"></span>
                  </div>
                </td>
                <td v-if="showElement">
                  <button 
                    type="button" 
                    class="btn btn-sm btn-primary"
                    @click="toggleShowRequest(request)"
                    >
                    <span class="hidden-xs">Detalles
                    </span>
                    <span class="glyphicon glyphicon-arrow-right visible-xs-block"></span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="panel-body-admin">
            <table 
              class="table table-responsive" 
              v-if="admin && !showRequest.method"
              >
              <thead>
                <tr>
                  <th class="clinic">
                    Usuario
                    <p>
                        <span :class="orderClasses('lastname1')" @click="orderColumn('lastname1',{object:'profile'})"></span>
                        <span :class="filterClasses('lastname1')" @click="filterColumn('lastname1',{object:'profile',search:['name','lastname1','lastname2'],noOptions:true})"></span>
                        <button 
                            class="btn btn-sm btn-danger delete-Schedule"
                            v-if="filtering.filters['dontShow']"
                            @click="clearFilters('lastname1')"
                            >
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </p>
                  </th>
                  <th class="clinic">
                    Clínica
                    <p>
                        <span :class="orderClasses('city')" @click="orderColumn('city',{object:'clinic'})"></span>
                        <span :class="filterClasses('city')" @click="filterColumn('city',{object:'clinic'})"></span>
                        <button 
                            class="btn btn-sm btn-danger delete-Schedule"
                            v-if="filtering.filters['dontShow']"
                            @click="clearFilters('city')"
                            >
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </p>
                  </th>
                  <th class="hidden-xs">
                    Tipo
                    <p>
                        <span :class="orderClasses('type')" @click="orderColumn('type')"></span>
                        <span :class="filterClasses('type')" @click="filterColumn('type')"></span>
                        <button 
                            class="btn btn-sm btn-danger delete-Schedule"
                            v-if="filtering.filters['dontShow']"
                            @click="clearFilters('type')"
                            >
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </p>
                  </th>
                  <th>
                    Detalle
                    <p>
                        <span :class="orderClasses('type_detail1')" @click="orderColumn('type_detail1')"></span>
                        <span :class="filterClasses('type_detail1')" @click="filterColumn('type_detail1',{nullName:'N/A'})"></span>
                        <button 
                            class="btn btn-sm btn-danger delete-Schedule"
                            v-if="filtering.filters['dontShow']"
                            @click="clearFilters('type_detail1')"
                            >
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </p>
                  </th>
                  <th class="hidden-xs">
                    Fecha
                    <p>
                        <span :class="orderClasses('created_at')" @click="orderColumn('created_at')"></span>
                        <span :class="filterClasses('created_at')" @click="filterColumn('created_at',{date:true})"></span>
                        <button 
                            class="btn btn-sm btn-danger delete-Schedule"
                            v-if="filtering.filters['dontShow']"
                            @click="clearFilters('created_at')"
                            >
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </p>
                  </th>
                  <th class="hidden-xs">Texto</th>
                  <th class="icons">
                    Estado
                    <p>
                        <span :class="orderClasses('closed_at')" @click="orderColumn('closed_at')"></span>
                        <span :class="filterClasses('closed_at')" @click="filterColumn('closed_at',{nullName:'Pendiente',boolean:['Pendiente','Resuelta']})"></span>
                        <button 
                            class="btn btn-sm btn-danger delete-Schedule"
                            v-if="filtering.filters['dontShow']"
                            @click="clearFilters('closed_at')"
                            >
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </p>
                  </th>
                  <th class="buttons-text icons"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="request in requests" v-show="checkFilter(request.id)">
                  <td><strong>{{request.profile.lastname1}} {{request.profile.lastname2}}, {{request.profile.name}}</strong></td>
                  <td><strong>{{request.clinic.city}}</strong><br>({{request.clinic.address_real_1}})</td>
                  <td>{{request.type}}</td>
                  <td class="hidden-xs">{{request.type_detail1 ? request.type_detail1 : '-'}}</td>
                  <td class="hidden-xs" v-text="requestDate(request.created_at)"></td>
                  <td class="hidden-xs">{{request.description.substring(0,50)+'...'}}
                  </td>
                  <td>
                    <div :class="requestClasses(request.closed_at)">
                      <span class="hidden-xs" v-text="requestText(request.closed_at)">
                      </span>
                      <span :class="requestIcon(request.closed_at)"></span>
                    </div>
                  </td>
                  <td>
                    <button 
                      type="button" 
                      class="btn btn-sm btn-primary"
                      @click="toggleShowRequest(request)"
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
          <div id="norequest" v-if="!profileRequests.total && !Object.keys(requests).length && !addRequest.method" class=" text-center empty">
            <div  class="col-xs-10 col-xs-offset-1 alert alert-info">
              <div v-if="!admin">
                <h3>No has realizado ninguna solicitud.</h3>
                  <p v-if="page == 'home'">Entra en la sección <a href="/requests"><strong>Necesidades</strong></a> y cuéntanos cómo podemos ayudarte.</p>
                  <p v-else>Pulsa en Nueva Solicitud para empezar a crear tu primera petición.</p>
              </div>
              <div v-else> 
                <h3>Aún no se han mandado solicitudes.</h3>
              </div>
            </div>
          </div>
          <div class="form-group col-xs-12 col-sm-8 col-sm-offset-2">
            <button 
              type="submit" 
              class="btn btn-sm btn-success btn-block form-control" 
              v-if="admin && showRequest.method && !showRequest.request.closed_at"
              @click.prevent="closeRequest"
              ><h4>Cerrar Solicitud</h4>
            </button>
            <button 
              type="submit" 
              class="btn btn-sm btn-info btn-block form-control" 
              v-if="showRequest.method"
              @click.prevent="toggleShowRequest"
              ><h4>Volver</h4>
            </button>
          </div>
        </div>
        <div class="panel-footer">
          <div class="progress">
            <div 
              class="progress-bar progress-bar-primary progress-bar-striped" :style="profileRequests.barStyle"
              v-if="profileRequests.ratio > 10"
              >
              <span>{{profileRequests.barText}}</span>
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
              showRequest: {
                method: false,
                request: {},
                requestClinic: [],
              },
              profileSrc: {
                requests: [],
              },
              profileRequests: {
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
              requests: [],
            }
        },
        watch: {
        },
        methods: {
          startFilters() {
            if (this.filtering.filters['closed_at']) {
              delete(this.filtering.filters['closed_at']);
            }
            this.filterColumn('closed_at',{nullName:'Pendiente',boolean:['Pendiente','Resuelta']});
            this.filtering.state = false;
            let empty = true;
            for (let item of this.filtering.filters['closed_at'].keys) {
              if (item.label == 'Resuelta') {
                // console.log(item.keys);
                empty = false;
                this.toggleFilterItem(item.keys, 'checked', this.filtering.name);
              }
            }
            if (empty) {
              delete(this.filtering.filters['closed_at']);
            }
            this.filtering.name = '';
          },
          applyUrlFilters() {
            // this.filtering.filters = {};
            // this.selectAllItems();
            // Example with Array
            // ?created_at[0]=2017-12-01&created_at[1]=2017-01-01&closed_at=Pendiente
            let search = getAllUrlParams();
            for (let filter in search) {
              if (Array.isArray(search[filter])) {
                for (let sub of search[filter]) {
                  sub = sub.replace(/%20/g, " ");
                }
              } else {
                search[filter] = search[filter].replace(/%20/g, " ");
              }
              if (filter == 'created_at') {
                this.filterColumn('created_at',{date:true});
                this.filtering.date.end = search['created_at'][0];
                this.filtering.date.start = search['created_at'][1];
                this.filtering.date.state = true;
                this.filterDates('created_at');
                this.filtering.state = false;
              } else if (filter == 'user') {
                let fullname = search['user'][1].replace(/%20/g, " ");
                // console.log(fullname);
                this.filterColumn('lastname1',{object:'profile',search:['name','lastname1','lastname2'],noOptions:true});
                this.filtering.search.string = fullname;
                this.filtering.state = false;
                this.searchString();
              } else {
                this.filterColumn(filter);
                this.filtering.state = false;
                let ids = [];
                for (let item of this.filtering.filters[filter].keys) {
                  let cleanName = cleanUpSpecialChars(item.label.toLowerCase());
                  if (cleanName != search[filter]) {
                    ids = item.keys;
                    // console.log('Search Filter: '+search[filter]);
                    this.toggleFilterItem(ids, 'checked', filter);
                  }
                }
              }
            }
            this.resetFiltering();
          },
          hideIfPage() {
            if (this.page == 'home' || this.admin) {
              this.showElement = false;
            }
          },
          toggleShowRequest(request) {
            if (this.showRequest.method) {
              this.showRequest.method = false;
              this.showRequest.request = {};
              this.showRequest.requestClinic = [];
            } else {
              this.showRequest.request = request;
              this.showRequest.requestClinic.push(request.clinic);
              this.showRequest.method = true;
            }
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
              return 'Pendiente';
            }
            return 'Resuelta';
          },
          requestIcon(closeDate) {
            if (!closeDate) {
              return 'glyphicon glyphicon-question-sign visible-xs-block';
            }
            return 'glyphicon glyphicon-ok-sign visible-xs-block';
          },
          calculateRatio() {
            this.profileRequests.total = 0;
            this.profileRequests.resolved = 0;
            let origin = this.profileSrc.requests;
            if (this.admin) {
              origin = this.requests;
            }
            for (let request of origin) {
              this.profileRequests.total++;
              if (request.closed_at) {
                this.profileRequests.resolved++;
              }
            }
            let ratio = Math.floor((this.profileRequests.resolved*100)/this.profileRequests.total);
            if (isNaN(ratio)) ratio = 0;
            this.profileRequests.ratio = ratio;
            this.profileRequests.barStyle = 'width: '+ratio+'%';
            this.profileRequests.barText = ratio+'% Resueltas';
          },
          notifyAdded() {
            flash({
                message: 'Solicitud enviada.', 
                label: 'success'
            });
            this.toggleAddRequest();
            setTimeout(function() {window.location.href = '/requests'}, 1000);
            // this.fetchProfile();
          },
          closeRequest() {
            axios.patch('/requests/'+this.showRequest.request.id, {
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
                      let newRequest = response.data.request;
                      this.notifyClosed(this.showRequest.request.id, newRequest);
                      window.events.$emit('requestClosed');
                      this.toggleShowRequest();
                    }
                });
          },
          notifyClosed(id, newRequest) {
            for (let request of this.requests) {
              if (request.id == id) {
                // request.closed_at = moment().format();
                request.closed_at = newRequest.closed_at;
                request.closed_by = newRequest.closed_by;
                break;
              }
            }
            this.startFilters();
            this.calculateRatio();
          },
          fetchProfile() {
            axios.get('/api/requests')
              .then(data => {
                this.profileSrc = data.data.profile;
                this.types = data.data.types;
                this.details = data.data.details;
                this.labs = data.data.labs;
                if (data.data.requests) {
                  // console.log(data.data);
                  // this.requests = data.data;
                  this.requests = []; 
                  for (let request of data.data.requests) {
                    // console.log(request);
                    this.requests.push(request);
                  }
                  if (App.role == 'admin') {
                    this.buildFiltering('requests');
                    this.selectAllItems();
                    this.startFilters();
                    this.applyUrlFilters();
                  }
                  this.buildOrdering('requests');
                  this.orderColumn('created_at',{order:'desc'});
                }
                this.calculateRatio();
                this.loading = false;
                window.events.$emit('loaded');
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
          this.fetchProfile();
          // setTimeout(function(){this.fetchProfile()}.bind(this),1000);
          this.hideIfPage();
         this.$emit('extratimeSolved');
        }
    }
</script>
<style type="text/css">
</style>