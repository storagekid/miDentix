<template>
  <div id="users-info-box">
    <div class="panel panel-default">
      <div class="panel-heading text-center" v-if="showElement">
        <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>  Mis Solicitudes</h3>
      </div>
      <div class="panel-heading text-center" v-if="admin">
        <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>Solicitudes</h3>
      </div>
      <div id="filterColumn" class="col-xs-4 col-xs-offset-4" v-show="filtering.state">
          <div class="row buttons" v-if="!filtering.date.state && filtering.showOptions">
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
          <div class="row dates" v-if="filtering.search.state">
            <form>
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
      <div class="panel-body">
        <div :class="panelClass">
          <table 
            class="table table-responsive" 
            v-if="admin && !showRequest.method"
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
                      <span :class="filterClasses('phone')" @click="filterColumn('phone',{search:['phone'],noOptions:true})"></span>
                  </p>
                </th>
                <th>
                  DNI
                  <p>
                      <span :class="orderClasses('personal_id_number')" @click="orderColumn('personal_id_number')"></span>
                      <span :class="filterClasses('personal_id_number')" @click="filterColumn('personal_id_number',{search:['personal_id_number'],noOptions:true})"></span>
                  </p>
                </th>
                <th class="hidden-xs">
                  Nº de Licencia
                  <p>
                      <span :class="orderClasses('license_number')" @click="orderColumn('license_number')"></span>
                      <span :class="filterClasses('license_number')" @click="filterColumn('license_number')"></span>
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
                      <span :class="filterClasses('last_access')" @click="filterColumn('last_access',{object:'user',boolean:true})"></span>
                  </p>
                </th>
                <th class="buttons-text icons"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users" v-show="checkFilter(user.id)">
                <td><strong>{{user.lastname1}} {{user.lastname2}}, {{user.name}}</strong></td>
                <td><strong>{{user.email}}</strong></td>
                <td>{{user.phone}}</td>
                <td class="hidden-xs">{{user.personal_id_number}}</td>
                <td class="hidden-xs">{{user.license_number}}
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
                    class="btn btn-primary"
                    @click="toggleShowRequest(user)"
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
                showOptions: true,
                date: {
                  state: false,
                  start: null,
                  end: null,
                },
                search: {
                  state: false,
                  string: null,
                  target: [],
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
            if (this.users.length == this.filtering.selected.length) {
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
            for (var i = 0; i < this.users.length; i++) {
                if (this.filtering.selected.indexOf(this.users[i].id) == -1) {
                    this.filtering.selected.push(this.users[i].id);
                }
            }
          },
          selectAllFilters() {
              if (this.users.length == this.filtering.selected.length) {
                  this.filtering.selected = [];
                  for (var i = 0; i < this.filtering.filters[this.filtering.name].keys.length; i++) {
                      this.filtering.filters[this.filtering.name].keys[i].state = false;
                  }
                  return;
              }
              for (var i = 0; i < this.users.length; i++) {
                  if (this.filtering.selected.indexOf(this.users[i].id) == -1) {
                      this.filtering.selected.push(this.users[i].id);
                  }
              }
          },
          invertSelectionFilters() {
              var selected = '';
              for (var i = 0; i < this.users.length; i++) {
                  if (this.filtering.selected.indexOf(this.users[i].id) == -1) {
                      this.filtering.selected.push(this.users[i].id);
                      selected = true;
                  } else {
                      this.filtering.selected.splice(this.filtering.selected.indexOf(this.users[i].id),1);
                      selected = false;
                  }
                  // var cleanName = cleanUpSpecialChars(this.users[i][name].toLowerCase());
                  for (var o = 0; o < this.filtering.filters[this.filtering.name].keys.length; o++) {
                      if (this.filtering.filters[this.filtering.name].keys[o].keys.indexOf(this.users[i].id) != -1) {
                          this.filtering.filters[this.filtering.name].keys[o].state = selected;
                      }
                  }
              }
          },
          startFilters() {
            if (this.filtering.filters['last_access']) {
              delete(this.filtering.filters['last_access']);
            }
            this.filterColumn('last_access',{object:'user',boolean:true});
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
          searchString() {
            console.log('searching');
            this.filtering.selected = [];
            for (let string of this.filtering.search.target) {
              if (string[1].indexOf(this.filtering.search.string) != -1) {
                this.filtering.selected.push(string[0]);
              }
            }
          },
          filterColumn(name, options={object:null,date:false,integer:false,boolean:false,search:false,noOptions:false}) {
            if (this.filtering.state) {
              flash({
                  message: 'Cierra la ventana para activar el botón', 
                  label: 'warning'
              });
              return false;
            }
            if (options.noOptions) {
              this.filtering.showOptions = false;
            }
            if (options.search) {
              this.filtering.search.state = true;
              let target = [];
              for (let user of this.users) {
                if (this.filtering.selected.indexOf(user.id) != -1) {
                  let fullstring = '';
                  for (let field of options.search) {
                    fullstring += user[field]+' ';
                  }
                  target.push([user.id,fullstring])
                }
              }
              this.filtering.search.target = target;
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
            for (var i = 0; i < this.users.length; i++) {
              if (!options.object) {
                if (this.users[i][name] == null) {
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
                    fullName = this.users[i][name];
                    if (options.integer) {
                      cleanName = fullName;
                    } else {
                      cleanName = cleanUpSpecialChars(this.users[i][name].toLowerCase());
                    }
                  }
                }
              } else {
                if (options.boolean) {
                  if (this.users[i][options.object][name] == null) {
                    cleanName = 'offline';
                    fullName = 'Offline';
                  } else {
                    cleanName = 'online';
                    fullName = 'Online';
                  }
                } else if (this.users[i][options.object][name] == null) {
                  cleanName = '-';
                  fullName = 'N/A';
                } else {
                  fullName = this.users[i][options.object][name];
                  if (options.integer) {
                    cleanName = fullName;
                  } else {
                    cleanName = cleanUpSpecialChars(this.users[i][options.object][name].toLowerCase());
                  }
                }
              }
              var id = this.users[i].id;
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
          orderColumn(name, options={object:null,date:false,order:false,integer:false}) {
              if (this.lastOrder.name != name) {
                  this.lastOrder.name = name;
                  this.lastOrder.keys = [];
                  for (var i = 0; i < this.users.length; i++) {
                    if (options.object) {
                      if (this.users[i][options.object][name] == null) {
                        this.lastOrder.keys.push('-');
                      } else {
                        if (options.integer) {
                          this.lastOrder.keys.push(this.users[i][options.object][name]);
                        } else {
                          this.lastOrder.keys.push(cleanUpSpecialChars(this.users[i][options.object][name].toLowerCase()));
                        }
                      }
                    } else {
                      if (this.users[i][name] == null) {
                        this.lastOrder.keys.push('-');
                      } else {
                        if (options.integer) {
                          this.lastOrder.keys.push(this.users[i][name]);
                        } else {
                          this.lastOrder.keys.push(cleanUpSpecialChars(this.users[i][name].toLowerCase()));
                        }
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
              var orderedusers = [];
              var cleanName = '';
              for (var i = 0; i < this.lastOrder.keys.length; i++) {
                  for (var o = 0; o < this.users.length; o++) {
                    if (options.object) {
                      if (this.users[o][options.object][name] == null) {
                        var cleanName = '-';
                      } else {
                        if (options.integer) {
                          var cleanName = this.users[o][options.object][name];
                        } else {
                          var cleanName = cleanUpSpecialChars(this.users[o][options.object][name].toLowerCase());
                        }            
                      }
                    } else {
                      if (this.users[o][name] == null) {
                        var cleanName = '-';
                      } else {
                        if (options.integer) {
                          var cleanName = this.users[o][name];
                        } else {
                          var cleanName = cleanUpSpecialChars(this.users[o][name].toLowerCase());
                        }     
                      }
                    }
                    if (cleanName == this.lastOrder.keys[i]) {
                        orderedusers.push(this.users[o]);
                        this.users.splice(o,1);
                        break;
                    } 
                  }
              }
              this.users = orderedusers;
          },
          // END Filetring Methods
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
          fetchUsers() {
            axios.get('/api/users')
              .then(data => {
                if (data.data.users) {
                  this.users = data.data.users;
                  this.selectAllFilters();
                  this.startFilters();
                  // this.applyUrlFilters();
                  // this.orderColumn('created_at',{order:'desc'});
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
          moment.locale('es');
          this.fetchUsers();
          this.hideIfPage();
        }
    }
</script>
<style type="text/css">
</style>