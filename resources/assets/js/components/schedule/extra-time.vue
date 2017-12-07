<template>
    <div class="schedule-table">
      <div class="panel panel-default">
        <div class="panel-heading text-center" v-if="admin">
          <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>Bolsa de Horas</h3>
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
        <div class="row" v-if="!profileSelected">
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
          <table class="table table-responsive" v-if="profileSrc.extratimes.length && !admin">
            <thead>
              <tr>
                <th>CA</th>
                <th>Provincia</th>
                <th>Clínica</th>
                <th class="hidden-xs">Fecha</th>
                <th>Detalles</th>
                <th>Estado</th>
                <th v-if="updateExtratimes"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="extraTime in profileSrc.extratimes">
                <td>{{extraTime.state_id ? extraTime.states.name : 'Indiferente'}}</td>
                <td>{{extraTime.provincia_id ? extraTime.provincia.nombre : 'Indiferente'}}</td>
                <td>{{extraTime.clinic_id ? 
                  extraTime.clinic.city+' ('+extraTime.clinic.address_real_1+')' : 
                  'Indiferente'}}</td>
                <td class="hidden-xs" v-text="extraDate(extraTime.created_at)"></td>
                <td v-html="scheduleReader(extraTime.schedule)"></td>
                <td>
                  <div :class="doStateBadge(extraTime.state).classes">
                    <span class="hidden-xs" v-text="doStateBadge(extraTime.state).text"></span>
                    <span :class="doStateBadge(extraTime.state).icon"></span>
                  </div>
                </td>
                <td v-if="updateExtratimes">
                  <button 
                      class="btn btn-sm btn-danger delete-Schedule"
                      @click="deleteExtratime(extraTime['id'])"
                      >
                      <span class="glyphicon glyphicon-remove"></span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="text-center" v-if="!profileSrc.extratimes.length && !admin">
            <h3 class="empty">No has hecho ninguna solicitud</h3>
          </div>
          <div class="panel-body" v-if="admin && !profileSelected">
            <table class="table table-responsive">
              <thead>
                <tr>
                  <th class="clinic">
                    Usuario
                    <p>
                        <span :class="orderClasses('lastname1')" @click="orderColumn('lastname1',{object:'profile'})"></span>
                        <span :class="filterClasses('lastname1')" @click="filterColumn('lastname1',{object:'profile'})"></span>
                    </p>
                  </th>
                  <th>
                    CA
                    <p>
                        <span :class="orderClasses('name')" @click="orderColumn('name',{object:'states'})"></span>
                        <span :class="filterClasses('name')" @click="filterColumn('name',{object:'states'})"></span>
                    </p>
                  </th>
                  <th>
                    Provincia
                    <p>
                        <span :class="orderClasses('nombre')" @click="orderColumn('nombre',{object:'provincia'})"></span>
                        <span :class="filterClasses('nombre')" @click="filterColumn('nombre',{object:'provincia'})"></span>
                    </p>
                  </th>
                  <th>
                    Clínica
                    <p>
                        <span :class="orderClasses('city')" @click="orderColumn('city',{object:'clinic'})"></span>
                        <span :class="filterClasses('city')" @click="filterColumn('city',{object:'clinic'})"></span>
                    </p>
                  </th>
                  <th class="hidden-xs">
                    Fecha
                    <p>
                        <span :class="orderClasses('created_at')" @click="orderColumn('created_at')"></span>
                        <span :class="filterClasses('created_at')" @click="filterColumn('created_at',{date:true})"></span>
                    </p>
                  </th>
                  <th>Detalles</th>
                  <th class="icons">
                  Estado
                  <p>
                      <span :class="orderClasses('state')" @click="orderColumn('state',{number:['Denegada','Pendiente','Aceptada']})"></span>
                      <span :class="filterClasses('state')" @click="filterColumn('state',{number:['Denegada','Pendiente','Aceptada']})"></span>
                  </p>
                </th>
                  <th class="buttons-text icons"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="extraTime in extratimes" v-show="checkFilter(extraTime.id)">
                  <td><strong>{{extraTime.profile.lastname1}} {{extraTime.profile.lastname2}}, {{extraTime.profile.name}}</strong></td>
                  <td>{{extraTime.state_id ? extraTime.states.name : 'Indiferente'}}</td>
                  <td>{{extraTime.provincia_id ? extraTime.provincia.nombre : 'Indiferente'}}</td>
                  <td>{{extraTime.clinic_id ? 
                    extraTime.clinic.city+' ('+extraTime.clinic.address_real_1+')' : 
                    'Indiferente'}}</td>
                  <td class="hidden-xs" v-text="extraDate(extraTime.created_at)"></td>
                  <td v-html="scheduleReader(extraTime.schedule)"></td>
                  <td>
                    <div :class="doStateBadge(extraTime.state).classes">
                      <span class="hidden-xs" v-text="doStateBadge(extraTime.state).text"></span>
                      <span :class="doStateBadge(extraTime.state).icon"></span>
                    </div>
                  </td>
                  <td>
                    <button 
                      type="button" 
                      class="btn btn-primary btn-sm"
                      @click="toggleShowDetails(extraTime.profile_id, extraTime)"
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
          <div id="noextratime" v-if="!extratimes.length" class=" text-center empty">
            <div  class="col-xs-10 col-xs-offset-1 alert alert-info">
              <div>
                <h3>Aún no se han mandado solicitudes.</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="row" v-if="this.admin && this.profileSelected">
          <div class="col-xs-12 col-md-10 col-md-offset-1">
            <div class="col-xs-12 col-sm-4 vcenter">
              <div class="alert alert-info form-group">
                <p><strong>{{extratimeSelected.profile.name}} {{extratimeSelected.profile.lastname1}}</strong></p>
                <p>CA: <strong>{{extratimeSelected.state_id ? extratimeSelected.states.name : 'Indiferente'}}</strong></p>
                <p>Provincia: <strong>{{extratimeSelected.provincia_id ? extratimeSelected.provincia.nombre : 'Indiferente'}}</strong></p>
                <p>Clínica: <strong>{{extratimeSelected.clinic_id ? extratimeSelected.clinic.city : 'Indiferente'}}</strong></p>
                <p>Fecha: <strong>{{extraDate(extratimeSelected.created_at)}}</strong></p>
                <p>Estado: <strong>{{extratimeSelected.closed_at ? extratimeSelected.clinic.city : 'Pendiente'}}</strong></p>
                <p>Horario: <strong v-html="scheduleReader(extratimeSelected.schedule,'inline')"></strong></p>
              </div>
              <div class="row" v-if="extratimeSelected.state == 1">
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
              </div>
              <div class="row">
                <div class="form-group col-xs-12">
                  <button class="btn btn-info btn-block btn-sm" @click="toggleShowDetails">Volver</button>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-8 tutorial-prompt vcenter">
              <schedule
                :profileSelected="profileSelected"
                :admin="true"
                >
              </schedule>
            </div>
          </div>
        </div>
        <div class="panel-footer" v-if="admin">
          <div class="progress">
            <div>
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
        props: [
          'admin',
          'updateExtratimes',
        ],
        data() {
            return {
              profileSelected: false,
              extratimeSelected: false,
              profileSrc: {extratimes:{}},
              extratimes: [],
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
            if (this.extratimes.length == this.filtering.selected.length) {
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
            for (var i = 0; i < this.extratimes.length; i++) {
                if (this.filtering.selected.indexOf(this.extratimes[i].id) == -1) {
                    this.filtering.selected.push(this.extratimes[i].id);
                }
            }
          },
          selectAllFilters() {
              if (this.extratimes.length == this.filtering.selected.length) {
                  this.filtering.selected = [];
                  for (var i = 0; i < this.filtering.filters[this.filtering.name].keys.length; i++) {
                      this.filtering.filters[this.filtering.name].keys[i].state = false;
                  }
                  return;
              }
              for (var i = 0; i < this.extratimes.length; i++) {
                  if (this.filtering.selected.indexOf(this.extratimes[i].id) == -1) {
                      this.filtering.selected.push(this.extratimes[i].id);
                  }
              }
          },
          invertSelectionFilters() {
              var selected = '';
              for (var i = 0; i < this.extratimes.length; i++) {
                  if (this.filtering.selected.indexOf(this.extratimes[i].id) == -1) {
                      this.filtering.selected.push(this.extratimes[i].id);
                      selected = true;
                  } else {
                      this.filtering.selected.splice(this.filtering.selected.indexOf(this.extratimes[i].id),1);
                      selected = false;
                  }
                  // var cleanName = cleanUpSpecialChars(this.extratimes[i][name].toLowerCase());
                  for (var o = 0; o < this.filtering.filters[this.filtering.name].keys.length; o++) {
                      if (this.filtering.filters[this.filtering.name].keys[o].keys.indexOf(this.extratimes[i].id) != -1) {
                          this.filtering.filters[this.filtering.name].keys[o].state = selected;
                      }
                  }
              }
          },
          startFilters() {
            if (this.filtering.filters['state']) {
              delete(this.filtering.filters['state']);
            }
            this.filterColumn('state',{number:['Denegada','Pendiente','Aceptada']})
            this.filtering.state = false;
            let empty = true;
            for (let item of this.filtering.filters['state'].keys) {
              if (item.label == 'Aceptada' || item.label == 'Denegada') {
                console.log(item.keys);
                empty = false;
                this.toggleFilterItem(item.keys, 'checked', this.filtering.name);
              }
            }
            if (empty) {
              delete(this.filtering.filters['state']);
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
          filterColumn(name, options={object:null,date:false,number:false}) {
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
            for (var i = 0; i < this.extratimes.length; i++) {
              if (!options.object) {
                if (options.number) {
                  fullName = options.number[this.extratimes[i][name]];
                  cleanName = cleanUpSpecialChars(fullName.toLowerCase());
                } else if (this.extratimes[i][name] == null) {
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
                    cleanName = cleanUpSpecialChars(this.extratimes[i][name].toLowerCase());
                    fullName = this.extratimes[i][name];
                  }
                }
              } else {
                if (!this.extratimes[i][options.object] || this.extratimes[i][options.object][name] == null) {
                  cleanName = 'indiferente';
                  fullName = 'Indiferente';
                } else {
                  cleanName = cleanUpSpecialChars(this.extratimes[i][options.object][name].toLowerCase());
                  fullName = this.extratimes[i][options.object][name];
                }
              }
              var id = this.extratimes[i].id;
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
                  for (var i = 0; i < this.extratimes.length; i++) {
                    if (options.object) {
                      if (!this.extratimes[i][options.object] || this.extratimes[i][options.object][name] == null) {
                        this.lastOrder.keys.push('indiferente');
                      } else {
                        this.lastOrder.keys.push(cleanUpSpecialChars(this.extratimes[i][options.object][name].toLowerCase()));
                        // console.log(cleanUpSpecialChars(this.extratimes[i][options.object][name].toLowerCase()));
                      }
                    } else {
                      if (this.extratimes[i][name] == null) {
                        this.lastOrder.keys.push('-');
                      } else {
                        this.lastOrder.keys.push(cleanUpSpecialChars(this.extratimes[i][name].toLowerCase()));
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
              var orderedextratimes = [];
              var cleanName = '';
              for (var i = 0; i < this.lastOrder.keys.length; i++) {
                  for (var o = 0; o < this.extratimes.length; o++) {
                    if (options.object) {
                      if (!this.extratimes[o][options.object] || this.extratimes[o][options.object][name] == null) {
                        var cleanName = 'indiferente';
                      } else {
                        var cleanName = cleanUpSpecialChars(this.extratimes[o][options.object][name].toLowerCase());
                      }
                    } else {
                      if (this.extratimes[o][name] == null) {
                        var cleanName = '-';
                      } else {
                        var cleanName = cleanUpSpecialChars(this.extratimes[o][name].toLowerCase());
                      }
                    }
                    if (cleanName == this.lastOrder.keys[i]) {
                        orderedextratimes.push(this.extratimes[o]);
                        this.extratimes.splice(o,1);
                        break;
                    } 
                  }
              }
              this.extratimes = orderedextratimes;
          },
          // END Filetring Methods
          extraDate(orgDate) {
            let date = moment(orgDate).format('L');
            return date;
          },
          doStateBadge(state) {
            let props = {
              classes: 'label label-warning list-badget',
              text: 'Pendiente',
              icon: 'glyphicon glyphicon-question-sign visible-xs-block'
            };
            if (!state) {
              props.classes = 'label label-danger list-badget';
              props.text = 'Denegada';
              props.icon = 'glyphicon glyphicon-remove-sign visible-xs-block'
            }
            if (state == 2) {
              props.classes = 'label label-success list-badget';
              props.text = 'Aceptada';
              props.icon = 'glyphicon glyphicon-ok-sign visible-xs-block'
            }
            return props;
          },
          scheduleReader(schedule, inline=false) {
            if (inline) {
              return scheduleToHumans(schedule).replace('<br>',' | ');
            }
            return scheduleToHumans(schedule);
          },
          removeProfileExtratime(id) {
            for (let i = 0; i < this.profileSrc.extratimes.length; i++) {
                if (this.profileSrc.extratimes[i].id == id) {
                  this.profileSrc.extratimes.splice(i,1);
                  break;
                }
            }
          },
          notifyClosed(id,state) {
            for (let extratime of this.extratimes) {
              if (extratime.id == id) {
                extratime.state = state;
                break;
              }
            }
          },
          deleteExtratime(id) {
            axios.delete('/extratime/'+id)
              .catch((error) => {
                  flash({
                      message: error.response.data, 
                      label: 'danger'
                  });
              }).then(response => {
                  if (response.status == 200) {
                      this.$emit('deleted', {id});
                      window.events.$emit('extratimeRemoved');
                      this.removeProfileExtratime(id);
                  }
              });
          },
          closeExtratime(id,state) {
            axios.patch('/extratime/'+id, {
              'state':state,
              }).catch((error) => {
                  flash({
                      message: error.response.data, 
                      label: 'danger'
                  });
              }).then(response => {
                  if(response.status == 200) {
                      this.$emit('closed', {id,state});
                      window.events.$emit('extratimeSolved');
                      this.notifyClosed(id,state);
                      this.toggleShowDetails();
                  }
              });
          },
          toggleShowDetails(id=null, extratime=null) {
            if (this.extratimeSelected) {
              console.log('Toggleling')
              this.profileSelected = false;
              this.extratimeSelected = false;
            } else {
              this.fetchProfileId(id);
              this.extratimeSelected = extratime;
            }
          },
          fetchProfileId(id) {
            axios.get('/api/schedule/'+id)
              .then(data => {
                console.log('HERE!!!');
                this.profileSelected = data.data;
              });
          },
          fetchProfile() {
            axios.get('/api/schedule')
              .then(data => {
                if (!this.admin) {
                  this.profileSrc = data.data;
                } else {
                  console.log(data.data);
                  this.extratimes = data.data.extratimes;
                  this.selectAllItems();
                  this.startFilters();
                  this.applyUrlFilters();
                  this.orderColumn('created_at',{order:'desc'});
                }
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
        },
    }
</script>
<style type="text/css">
</style>