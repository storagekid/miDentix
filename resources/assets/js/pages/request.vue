<template>
  <div id="requests-info-box">
    <div class="panel panel-default">
      <div class="panel-heading text-center" v-if="showElement">
        <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>  Mis Solicitudes</h3>
      </div>
      <div class="panel-heading text-center" v-if="admin">
        <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>Solicitudes</h3>
      </div>
      <div id="filterColumn" class="col-xs-4 col-xs-offset-4" v-show="filtering.state">
          <div class="row buttons" v-if="!filtering.date.state">
              <div class="col-xs-6">
                  <button class="btn btn-sm btn-block btn-info" @click="selectAllFilters">Todos</button>
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
          <ul class="list-group" v-if="!filtering.date.state && filtering.state">
              <li v-for="filter in filtering.filters[filtering.name].keys" class="col-xs-6 list-item">
                  <input type="checkbox" name="" @click="toggleFilterItem(filter.keys, filter.state, filtering.name)" v-model="filter.state"><span v-text="filter.label"></span>
              </li>
          </ul>
          <button class="btn btn-sm btn-block btn-info" @click="toggleFiltering">Cerrar</button>
      </div>
      <div class="row">
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
            <tr v-for="request in profileSrc.requests.slice(0,5)">
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
                  class="btn btn-primary"
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
            <tr v-for="request in profileSrc.requests">
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
                  class="btn btn-primary"
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
        <div class="panel-body">
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
                      <span :class="filterClasses('lastname1')" @click="filterColumn('lastname1',{object:'profile'})"></span>
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
                      <span :class="filterClasses('type_detail1')" @click="filterColumn('type_detail1')"></span>
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
                      <span :class="filterClasses('closed_at')" @click="filterColumn('closed_at')"></span>
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
                    class="btn btn-primary"
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
        <div class="form-group col-xs-12 col-sm-10 col-sm-offset-1">
          <button 
            type="submit" 
            class="btn btn-sm btn-info btn-block form-control" 
            v-if="showRequest.method"
            @click.prevent="toggleShowRequest"
            ><h4>Volver</h4>
          </button>
          <button 
            type="submit" 
            class="btn btn-sm btn-success btn-block form-control" 
            v-if="admin && showRequest.method && !showRequest.request.closed_at"
            @click.prevent="closeRequest"
            ><h4>Cerrar Solicitud</h4>
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
</template>

<script>
    import * as moment from 'moment';
    import 'moment/locale/es';
    export default {
        components: {},
        props: ['page','admin'],
        data() {
            return {
              lastOrder: {
                  name: '',
                  keys: [],
                  type: 'desc',
              },
              filtering: {
                filters: {},
                name: '',
                state: false,
                date: {
                  state: false,
                  start: null,
                  end: null,
                },
                keys: [],
                selected: [],
                backup: [],
              },
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
              requests: {},
            }
        },
        watch: {
        },
        methods: {
          // Filetring Methods
          filterClasses(object) {
            if (this.filtering.filters[object]) {
              return 'glyphicon glyphicon-filter selected';
            }
            return 'glyphicon glyphicon-filter';
          },
          orderClasses(object) {
            if (this.lastOrder.name == object && this.lastOrder.type == 'asc') {
              return 'glyphicon glyphicon-triangle-top selected';
            } else if (this.lastOrder.name == object && this.lastOrder.type == 'desc') {
              return 'glyphicon glyphicon-triangle-bottom selected';
            }
            return 'glyphicon glyphicon-triangle-bottom';
          },
          toggleFiltering() {
            if (this.requests.length == this.filtering.selected.length) {
              delete(this.filtering.filters[this.filtering.name]);
              if (this.filtering.name == 'created_at') {
                this.filtering.date = {};
              }
              this.filtering.name = '';
              this.filtering.state = false;
            } else {
              this.filtering.name = '';
              this.filtering.state = false;
            }
          },
          clearAllFilters() {
            if (this.filtering.state) {
              flash({
                  message: 'Cierra la ventana para activar el botón', 
                  label: 'warning'
              });
              return false;
            }
            this.selectAllItems();
            this.filtering.filters = {};
          },
          clearFilters(filter) {
            if (this.filtering.state) {
              flash({
                  message: 'Cierra la ventana para activar el botón', 
                  label: 'warning'
              });
              return false;
            }
            for (let item of this.filtering.filters[filter].keys) {
              for (let key of item.keys) {
                if (this.filtering.selected.indexOf(key) == -1) {
                  this.filtering.selected.push(key);
                }
              }
            }
            delete(this.filtering.filters[filter]);
            if (filter == 'created_at') {
              this.filtering.date = {};
            }
          },
          selectAllItems() {
            for (var i = 0; i < this.requests.length; i++) {
                if (this.filtering.selected.indexOf(this.requests[i].id) == -1) {
                    this.filtering.selected.push(this.requests[i].id);
                }
            }
          },
          selectAllFilters() {
              if (this.requests.length == this.filtering.selected.length) {
                  this.filtering.selected = [];
                  for (var i = 0; i < this.filtering.filters[this.filtering.name].keys.length; i++) {
                      this.filtering.filters[this.filtering.name].keys[i].state = false;
                  }
                  return;
              }
              for (var i = 0; i < this.requests.length; i++) {
                  if (this.filtering.selected.indexOf(this.requests[i].id) == -1) {
                      this.filtering.selected.push(this.requests[i].id);
                  }
              }
          },
          invertSelectionFilters() {
              var selected = '';
              for (var i = 0; i < this.requests.length; i++) {
                  if (this.filtering.selected.indexOf(this.requests[i].id) == -1) {
                      this.filtering.selected.push(this.requests[i].id);
                      selected = true;
                  } else {
                      this.filtering.selected.splice(this.filtering.selected.indexOf(this.requests[i].id),1);
                      selected = false;
                  }
                  // var cleanName = cleanUpSpecialChars(this.requests[i][name].toLowerCase());
                  for (var o = 0; o < this.filtering.filters[this.filtering.name].keys.length; o++) {
                      if (this.filtering.filters[this.filtering.name].keys[o].keys.indexOf(this.requests[i].id) != -1) {
                          this.filtering.filters[this.filtering.name].keys[o].state = selected;
                      }
                  }
              }
          },
          startFilters() {
            if (this.filtering.filters['closed_at']) {
              delete(this.filtering.filters['closed_at']);
            }
            this.filterColumn('closed_at');
            this.filtering.state = false;
            let empty = true;
            for (let item of this.filtering.filters['closed_at'].keys) {
              if (item.label == 'Resuelta') {
                console.log(item.keys);
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
          filterColumn(name, options={object:null,date:false}) {
            if (this.filtering.state) {
              flash({
                  message: 'Cierra la ventana para activar el botón', 
                  label: 'warning'
              });
              return false;
            }
            if (options.date) {
              this.filtering.date.state = true;
            } else {
              this.filtering.date.state = false;
            }
            this.filtering.filters[name] = {};
            this.filtering.filters[name].name = name;
            this.filtering.filters[name].keys = [];
            this.filtering.name = name;
            this.filtering.state = true;
            var labels = [];
            var keys =[];
            let cleanName = '';
            let fullName = '';
            for (var i = 0; i < this.requests.length; i++) {
              if (!options.object) {
                if (this.requests[i][name] == null) {
                  cleanName = '-';
                  if (name == 'closed_at') {
                    fullName = 'Pendiente';
                  } else {
                    fullName = 'N/A';
                  }
                } else {
                  if (name == 'closed_at') {
                    cleanName = 'resuelta';
                    fullName = 'Resuelta';
                  } else {
                    cleanName = cleanUpSpecialChars(this.requests[i][name].toLowerCase());
                    fullName = this.requests[i][name];
                  }
                }
              } else {
                if (this.requests[i][options.object][name] == null) {
                  cleanName = '-';
                  fullName = 'N/A';
                } else {
                  cleanName = cleanUpSpecialChars(this.requests[i][options.object][name].toLowerCase());
                  fullName = this.requests[i][options.object][name];
                }
              }
              var id = this.requests[i].id;
              let state = false;
              if (labels.indexOf(cleanName) == -1) {
                  labels.push(cleanName);
                  var key = {label: fullName, keys: [id], state: state};
                  keys.push(key);
              } else {
                for (var o = 0; o < keys.length; o++) {
                  if (keys[o].label == fullName) {
                      keys[o].keys.push(id);
                  }
                }
              }
            }
            this.filtering.filters[name].keys = keys;
            this.filtering.filters[name].keys.forEach((item, index) => {
              for (let id of item.keys) {
                if (this.filtering.selected.indexOf(id) != -1) {
                  this.filtering.filters[name].keys[index].state = 'checked';
                  break;
                }
              }
            });
            this.filtering.state = true;
          },
          checkFilter(id) {
              return this.filtering.selected.indexOf(id) == -1 ? false : true;
          },
          filterDates(object) {
            console.log('Start Date: '+moment(this.filtering.date.start).format('x'));
            console.log('End Date: '+moment(this.filtering.date.end).format('x'));
            let startDate = moment(this.filtering.date.start).format('x');
            let endDate = moment(this.filtering.date.end).format('x');
            for (let date of this.filtering.filters[object].keys) {
              if (moment(date.label).format('x') > startDate && moment(date.label).format('x') < endDate) {
                for (let key of date.keys) {
                  if (this.filtering.selected.indexOf(key) == -1) {
                      this.filtering.selected.push(key);
                  } 
                }
              } else {
                for (let key of date.keys) {
                  if (this.filtering.selected.indexOf(key) != -1) {
                      this.filtering.selected.splice(this.filtering.selected.indexOf(key),1);
                  }
                }
              }
            }
          },
          toggleFilterItem(ids, state, name) {
              if (ids.length > 1) {
                  for (var i = 0; i < ids.length; i++) {
                      if (this.filtering.selected.indexOf(ids[i]) == -1 && !state) {
                          this.filtering.selected.push(ids[i]);
                      } else if (this.filtering.selected.indexOf(ids[i]) != -1 && state) {
                          this.filtering.selected.splice(this.filtering.selected.indexOf(ids[i]),1);
                      }
                  }
              } else {
                  if (this.filtering.selected.indexOf(ids[0]) == -1 && !state) {
                      this.filtering.selected.push(ids[0]);
                  } else if (this.filtering.selected.indexOf(ids[0]) != -1 && state) {
                      this.filtering.selected.splice(this.filtering.selected.indexOf(ids[0]),1);
                  }
              }
          },
          orderColumn(name, options={object:null,date:false,order:false}) {
              if (this.lastOrder.name != name) {
                  this.lastOrder.name = name;
                  this.lastOrder.keys = [];
                  for (var i = 0; i < this.requests.length; i++) {
                    if (options.object) {
                      if (this.requests[i][options.object][name] == null) {
                        this.lastOrder.keys.push('-');
                      } else {
                        this.lastOrder.keys.push(cleanUpSpecialChars(this.requests[i][options.object][name].toLowerCase()));
                      }
                    } else {
                      if (this.requests[i][name] == null) {
                        this.lastOrder.keys.push('-');
                      } else {
                        this.lastOrder.keys.push(cleanUpSpecialChars(this.requests[i][name].toLowerCase()));
                      }
                    }
                  }
                  if (options.order) {
                    if (options.order == 'asc') {
                      this.lastOrder.type = 'asc'
                      this.lastOrder.keys.sort();
                    } else {
                      this.lastOrder.keys.sort();
                      this.lastOrder.keys.reverse();
                      this.lastOrder.type = 'desc';
                    }
                  } else {
                    this.lastOrder.keys.sort();
                    this.lastOrder.type = 'asc';
                  }
              } else {
                  if (this.lastOrder.type == 'desc') {
                      this.lastOrder.type = 'asc'
                      this.lastOrder.keys.sort();
                  } else {
                      this.lastOrder.type = 'desc';
                      this.lastOrder.keys.sort();
                      this.lastOrder.keys.reverse();
                  }
              }
              var orderedRequests = [];
              var cleanName = '';
              for (var i = 0; i < this.lastOrder.keys.length; i++) {
                  for (var o = 0; o < this.requests.length; o++) {
                    if (options.object) {
                      if (this.requests[o][options.object][name] == null) {
                        var cleanName = '-';
                      } else {
                        var cleanName = cleanUpSpecialChars(this.requests[o][options.object][name].toLowerCase());
                      }
                    } else {
                      if (this.requests[o][name] == null) {
                        var cleanName = '-';
                      } else {
                        var cleanName = cleanUpSpecialChars(this.requests[o][name].toLowerCase());
                      }
                    }
                    if (cleanName == this.lastOrder.keys[i]) {
                        orderedRequests.push(this.requests[o]);
                        this.requests.splice(o,1);
                        break;
                    } 
                  }
              }
              this.requests = orderedRequests;
          },
          // END Filetring Methods
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
            this.fetchProfile();
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
                      this.notifyClosed(this.showRequest.request.id);
                      window.events.$emit('requestClosed');
                      this.toggleShowRequest();
                    }
                });
          },
          notifyClosed(id) {
            for (let request of this.requests) {
              if (request.id == id) {
                request.closed_at = moment().format();
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
                  this.requests = data.data.requests;
                  this.selectAllFilters();
                  this.startFilters();
                  this.applyUrlFilters();
                  this.orderColumn('created_at',{order:'desc'});
                }
                this.calculateRatio();
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
          moment.locale('es');
          this.fetchProfile();
          this.hideIfPage();
        }
    }
</script>
<style type="text/css">
</style>