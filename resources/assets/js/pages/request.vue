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
                <button class="btn btn-sm btn-block btn-primary form-control" @click.prevent="filterDates">Aplicar</button>
              </div>
            </form>
          </div>
          <ul class="list-group" v-if="!filtering.date.state">
              <li v-for="filter in filtering.keys" class="col-xs-6 list-item">
                  <input type="checkbox" name="" @click="toggleFilterItem(filter.keys, filtering.name)" v-model="filter.state"><span v-text="filter.label"></span>
              </li>
          </ul>
          <button class="btn btn-sm btn-block btn-info" @click="toggleFiltering">Cerrar</button>
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
          v-if="!addRequest.method && !showRequest.method && profileSrc.requests.length"
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
        <table 
          class="table table-responsive" 
          v-if="admin && !showRequest.method"
          >
          <thead>
            <tr>
              <th class="clinic">
                Usuario
                <p>
                    <span class="glyphicon glyphicon-triangle-bottom" @click="orderColumn('lastname1',{object:'profile'})"></span>
                    <span class="glyphicon glyphicon-filter" @click="filterColumn('lastname1',{object:'profile'})"></span>
                    <button 
                        class="btn btn-sm btn-danger delete-Schedule"
                        v-if="filtering.name == 'lastname1'"
                        @click="clearFilters()"
                        >
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </p>
              </th>
              <th class="clinic">
                Clínica
                <p>
                    <span class="glyphicon glyphicon-triangle-bottom" @click="orderColumn('city',{object:'clinic'})"></span>
                    <span class="glyphicon glyphicon-filter" @click="filterColumn('city',{object:'clinic'})"></span>
                    <button 
                        class="btn btn-sm btn-danger delete-Schedule"
                        v-if="filtering.name == 'city'"
                        @click="clearFilters()"
                        >
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </p>
              </th>
              <th class="hidden-xs">
                Tipo
                <p>
                    <span class="glyphicon glyphicon-triangle-bottom" @click="orderColumn('type')"></span>
                    <span class="glyphicon glyphicon-filter" @click="filterColumn('type')"></span>
                    <button 
                        class="btn btn-sm btn-danger delete-Schedule"
                        v-if="filtering.name == 'type'"
                        @click="clearFilters()"
                        >
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </p>
              </th>
              <th>
                Detalle
                <p>
                    <span class="glyphicon glyphicon-triangle-bottom" @click="orderColumn('type_detail1')"></span>
                    <span class="glyphicon glyphicon-filter" @click="filterColumn('type_detail1')"></span>
                    <button 
                        class="btn btn-sm btn-danger delete-Schedule"
                        v-if="filtering.name == 'type_detail1'"
                        @click="clearFilters()"
                        >
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </p>
              </th>
              <th class="hidden-xs">
                Fecha
                <p>
                    <span class="glyphicon glyphicon-triangle-bottom" @click="orderColumn('created_at')"></span>
                    <span class="glyphicon glyphicon-filter" @click="filterColumn('created_at',{date:true})"></span>
                    <button 
                        class="btn btn-sm btn-danger delete-Schedule"
                        v-if="filtering.name == 'created_at'"
                        @click="clearFilters()"
                        >
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </p>
              </th>
              <th class="hidden-xs">Texto</th>
              <th class="icons">
                Estado
                <p>
                    <span class="glyphicon glyphicon-triangle-bottom" @click="orderColumn('closed_at')"></span>
                    <span class="glyphicon glyphicon-filter" @click="filterColumn('closed_at')"></span>
                    <button 
                        class="btn btn-sm btn-danger delete-Schedule"
                        v-if="filtering.name == 'closed_at'"
                        @click="clearFilters()"
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
        <div id="norequest" v-if="!profileRequests.total && !requests" class="alert alert-info text-center empty">
          <div v-if="!admin">
            <h3>No has realizado ninguna solicitud.</h3>
              <p v-if="page == 'home'">Entra en la sección Necesidades y cuéntanos cómo podemos ayudarte.</p>
              <p v-else>Pulsa en Nueva Solicitud para empezar a crear tu primera petición.</p>
          </div>
          <div v-else> 
            <h3>Aún no se han mandado solicitudes.</h3>
          </div>
        </div>
        <button 
          type="submit" 
          class="btn btn-sm btn-info btn-block" 
          v-if="showRequest.method"
          @click.prevent="toggleShowRequest"
          ><h4>Volver</h4>
        </button>
        <button 
          type="submit" 
          class="btn btn-sm btn-primary btn-block" 
          v-if="admin && showRequest.method && !showRequest.request.closed_at"
          @click.prevent="closeRequest"
          ><h4>Cerrar Solicitud</h4>
        </button>
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
          toggleFiltering() {
            if (this.requests.length == this.filtering.selected.length) {
              this.filtering.name = '';
              this.filtering.state = false;
            } else {
              this.filtering.state = false;
            }
          },
          clearFilters() {
            this.filtering.name = '';
            this.filtering.keys = [];
            this.filtering.state = false;
            this.selectAllItems();
          },
          selectAllItems() {
            for (var i = 0; i < this.requests.length; i++) {
                if (this.filtering.selected.indexOf(this.requests[i].id) == -1) {
                    this.filtering.selected.push(this.requests[i].id);
                }
            }
            for (var i = 0; i < this.filtering.keys.length; i++) {
                this.filtering.keys[i].state = true;
            }
          },
          selectAllFilters() {
              if (this.requests.length == this.filtering.selected.length) {
                  this.filtering.selected = [];
                  for (var i = 0; i < this.filtering.keys.length; i++) {
                      this.filtering.keys[i].state = false;
                  }
                  return;
              }
              for (var i = 0; i < this.requests.length; i++) {
                  if (this.filtering.selected.indexOf(this.requests[i].id) == -1) {
                      this.filtering.selected.push(this.requests[i].id);
                  }
              }
              for (var i = 0; i < this.filtering.keys.length; i++) {
                  this.filtering.keys[i].state = true;
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
                  for (var o = 0; o < this.filtering.keys.length; o++) {
                      if (this.filtering.keys[o].keys.indexOf(this.requests[i].id) != -1) {
                          this.filtering.keys[o].state = selected;
                      }
                  }
              }
          },
          filterColumn(name, options={object:null,date:false}) {
            if (options.date) {
              this.filtering.date.state = true;
            } else {
              this.filtering.date.state = false;
            }
            if (this.filtering.name != '' && this.filtering.name != name) {
              flash({
                  message: 'Elimina el filtro aplicado.', 
                  label: 'danger'
              });
              return false;
            }
              if (this.filtering.name != name) {
                  this.filtering.name = name;
                  this.filtering.keys = [];
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
                      // var clinicObject = {keys: key};
                      if (labels.indexOf(cleanName) == -1) {
                          labels.push(cleanName);
                          var key = {label: fullName, keys: [id], state: 'checked'};
                          keys.push(key);
                      } else {
                          for (var o = 0; o < keys.length; o++) {
                              if (keys[o].label == fullName) {
                                  keys[o].keys.push(id);
                              }
                          }
                      }
                  }
                  this.filtering.keys = keys;
                  // this.filtering.keys.sort();
              } else {
                  this.filtering.state = true;
              }
          },
          checkFilter(id) {
              return this.filtering.selected.indexOf(id) == -1 ? false : true;
          },
          filterDates() {
            console.log('Start Date: '+moment(this.filtering.date.start).format('x'));
            console.log('End Date: '+moment(this.filtering.date.end).format('x'));
            let startDate = moment(this.filtering.date.start).format('x');
            let endDate = moment(this.filtering.date.end).format('x');
            for (let date of this.filtering.keys) {
              // console.log('Item Date: '+moment(date.label).format('x'));
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
          toggleFilterItem(ids, name) {
              if (ids.length > 1) {
                  for (var i = 0; i < ids.length; i++) {
                      if (this.filtering.selected.indexOf(ids[i]) == -1) {
                          this.filtering.selected.push(ids[i]);
                      } else {
                          this.filtering.selected.splice(this.filtering.selected.indexOf(ids[i]),1);
                      }
                  }
              } else {
                  if (this.filtering.selected.indexOf(ids[0]) == -1) {
                      this.filtering.selected.push(ids[0]);
                  } else {
                      this.filtering.selected.splice(this.filtering.selected.indexOf(ids[0]),1);
                  }
              }
          },
          orderColumn(name, options={object:null,date:false}) {
            console.log(name);
              if (this.lastOrder.name != name) {
                  this.lastOrder.name = name;
                  this.lastOrder.keys = [];
                  this.lastOrder.type = 'desc';
                  for (var i = 0; i < this.requests.length; i++) {
                    if (options.object) {
                      if (this.requests[i][options.object][name] == null) {
                        this.lastOrder.keys.push('-');
                      } else {
                        this.lastOrder.keys.push(cleanUpSpecialChars(this.requests[i][options.object][name].toLowerCase()));
                      }
                    } else {
                      if (this.requests[i][name] == null) {
                        console.log('NULL1');
                        this.lastOrder.keys.push('-');
                      } else {
                        this.lastOrder.keys.push(cleanUpSpecialChars(this.requests[i][name].toLowerCase()));
                      }
                    }
                  }
                  this.lastOrder.keys.sort();
              } else {
                  if (this.lastOrder.type == 'desc') {
                      this.lastOrder.type = 'asc'
                      this.lastOrder.keys.reverse();
                  } else {
                      this.lastOrder.type = 'desc';
                      this.lastOrder.keys.sort();
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
                      console.log(response.data.request);
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
          },
          fetchProfile() {
            axios.get('/api/requests')
              .then(data => {
                console.log(data.data);
                this.profileSrc = data.data.profile;
                this.types = data.data.types;
                this.details = data.data.details;
                this.labs = data.data.labs;
                if (data.data.requests) {
                  this.requests = data.data.requests;
                  this.selectAllFilters();
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