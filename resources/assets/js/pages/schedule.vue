<template>
    <div id="schedule-info-box">
      <div class="panel panel-default panel-tabbed">
        <div class="panel-heading text-center" v-if="showTabs === true">
          <h3 class="panel-title">
            <ul class="nav nav-tabs">
              <li 
                :class="{'active': tabSelected == key}" 
                v-for="(tab, key) in tabs"
                v-if="showTab(key)"
                >
                <a href="#" @click="toggleTab(key)">
                  <span :class="tab['icon']"></span>{{tab['name']}}
                </a>
              </li>
            </ul>
          </h3>
        </div>
        <div class="panel-body">
          <div class="tab-content">
            <div 
              role="tabpanel" 
              class="tab-pane active" 
              id="profile-clinics" 
              >
              <div class="btn-new text-center"  v-if="showTabs === true">
                <button type="button" :class="addClinic.topButtonClasses" @click="toggleAddClinic">
                  <h3><span :class="addClinic.topButtonIcon"></span>{{addClinic.topButtonText}}</h3>
                </button>
                <form id="new-clinic-form" v-show="addClinic.method">
                  <div class="row">
                    <div class="form-group col-xs-12 col-md-4">
                        <label for="clinic_id">CCAA</label>
                        <select class="form-control" id="state_id" name="state_id" @change="selectState" v-model="addClinic.selectedStateId">
                          <option 
                            disabled="" 
                            :selected="addClinic.selectedStateId"
                            value=""
                            >{{addClinic.selectedStateText}}</option>
                            <option v-for="state in statesSrc" :value="state['id']">{{state['name']}}</option>
                        </select>
                    </div>
                    <div class="form-group col-xs-12 col-md-4">
                        <label for="clinic_id">Provincia</label>
                        <select 
                          class="form-control" 
                          id="county_id" 
                          name="county_id" 
                          @change="selectCounty" 
                          :disabled="addClinic.countySelectDisabled"
                          v-model="addClinic.selectedCountyId"
                          >
                          <option 
                            disabled="" 
                            :selected="addClinic.selectedCountyId"
                            value=""
                          >{{addClinic.selectedCountyText}}</option>
                            <option 
                                v-for="county in countiesSrc" 
                                :value="county['id']" 
                                v-if="checkState(county['state_id'])"
                                >
                                {{county['nombre']}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-xs-12 col-md-4">
                        <label for="clinic_id">Clínica</label>
                        <select 
                          class="form-control" 
                          id="clinic_id" 
                          name="clinic_id" 
                          @change="selectClinic" 
                          :disabled="addClinic.clinicSelectDisabled" 
                          v-model="addClinic.selectedClinicId"
                          >
                          <option 
                            disabled="" 
                            :selected="addClinic.selectedClinicId"
                            value=""
                            >{{addClinic.selectedClinicText}}</option>
                            <option 
                                v-for="clinic in clinicsSrc" 
                                :value="clinic['id']"
                                v-if="checkCounty(clinic['county_id'],clinic['id']) && !clinic['closed']"
                                >
                                <!-- {{clinic['city']}} ({{clinic['address_real_1']}}) -->
                                {{clinic['cost_center']['name']}}
                            </option>
                        </select>
                    </div>
                  </div>
                </form>
                <form id="edit-clinic-form" v-show="updateSchedules.method">
                    <div class="form-group col-xs-12">
                        <label for="clinic_id">Clínica</label>
                        <select 
                          class="form-control" 
                          id="clinic_id" 
                          name="clinic_id" 
                          @change="selectClinic" 
                          v-model="updateSchedules.selectedClinicId"
                          >
                          <option 
                            disabled="" 
                            value="" 
                            :selected="updateSchedules.selectedClinicId"
                            >Selecciona una de tus clínicas</option>
                            <option 
                                v-for="clinic in profileSrc.clinics" 
                                :value="clinic['id']"
                                >
                                {{clinic['city']}} ({{clinic['address_real_1']}})
                            </option>
                        </select>
                    </div>
                </form>
                <!-- <div class="form-group col-xs-12" v-if="addClinic.selectedClinicId || updateSchedules.selectedClinicId">
                  <label for="name">Especialidades: <br>(selecciona todas las que procedan)</label>
                  <div class="checkbox">
                    <label v-for="especialty in especialties">
                      <input 
                        type="checkbox" 
                        :value="especialty.id" 
                        :checked="checkEspecialties(especialty.id)"
                        @click="checkFieldBox($event,'especialties',especialty.id)"
                        >
                      {{especialty.name}}
                    </label>
                  </div>
                </div> -->
              </div>
              <ul class="list-group" v-if="picker">
                <div class="row">
                  <div class="col-xs-12">
                    <schedule-pickup 
                      :clickable="clickable"
                      :profile-src="profileSrc" 
                      :addingCA="addClinic.selectedStateId"
                      :addingPro="addClinic.selectedCountyId"
                      :addingId="addClinic.selectedClinicId"
                      :schedules="schedules"
                      :days="days"
                      :dayHours="dayHours"
                      :dayLabels="dayLabels"
                      :clinicHours="clinicHours"
                      :daysCount="daysCount"
                      :updateMode="updateSchedules.method"
                      :restoreMethod="restoreMethod"
                      :newExtraTime="newExtraTime"
                      @added="notifyAdding"
                      @updated="notifyUpdating"
                      @deleted="notifyRemoving"
                      @toggleDay="checkDay"
                      @rollback="rollback"
                      @rollbackExtra="rollbackExtra"
                      @addextra="notifyExtra"
                      ></schedule-pickup>
                  </div>
                </div>
              </ul>
              <extra-time
              v-if="tabSelected == 'extraTime' && !newExtraTime"
              :updateExtratimes="updateExtratimes"
              @deleted="notifyExtraRemoved"
              >
              </extra-time>
            </div>
          </div>
          <div class="panel-footer">
            <div id="profile-info-footer" v-if="profileSrc.clinics.length">
              <h3>
                <span class="glyphicon glyphicon-home"></span>{{clinicNumber}} -
                <span class="glyphicon glyphicon-time"></span>Total Horas: {{totalHours}}
              </h3>
              <button 
                type="button" 
                :class="updateSchedules.ButtonClasses" 
                @click="toggleUpdate" 
                v-if="showEditButton && showTabs">
                <span :class="updateSchedules.ButtonIcon"></span>{{updateSchedules.ButtonText}}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    import schedulePickup from '../components/schedule/schedule-pickup.vue';
    // import extraTime from '../components/schedule/extra-time.vue';
    export default {
        components: {schedulePickup},
        props: ['page','admin','profileSelected','clickable'],
        data() {
            return {
              profileSrc: {
                clinics: [],
              },
              clinicsSrc: [],
              countiesSrc: [],
              statesSrc: [],
              // especialties: [],
              schedules: {},
              clinicHours: {},
              days: {},
              daysCount: 7,
              totalHours: 0,
              restoreMethod: null,
              dayLabels: {
                    'es-ES': {'01':'L','02':'M','03':'X','04':'J','05':'V','06':'S','07':'D'}
                },
              dayHours: ['9','10','11','12','13','14','15','16','17','18','19','20'],
              addClinic: {
                  method: false,
                  countySelectDisabled: true,
                  clinicSelectDisabled: true,
                  topButtonText: 'Añadir Clinica',
                  topButtonClasses: 'btn btn-sm btn-info',
                  topButtonIcon: 'glyphicon glyphicon-plus-sign',
                  selectedStateId: '',
                  selectedStateText: 'Selecciona una CCAA',
                  selectedCountyId: '',
                  selectedCountyText: 'Selecciona una Provincia',
                  selectedClinicId: '',
                  selectedClinicText: 'Selecciona una clínica',
              },
              updateSchedules: {
                  method: false,
                  countySelectDisabled: true,
                  clinicSelectDisabled: true,
                  ButtonText: 'Modificar',
                  ButtonClasses: 'btn btn-primary',
                  ButtonIcon: 'glyphicon glyphicon-pencil',
                  selectedStateId: '',
                  selectedCountyId: '',
                  selectedClinicId: '',
              },
              tabs: {
                clinics: {
                  name: 'Clínicas',
                  icon: 'glyphicon glyphicon-home',
                },
                extraTime: {
                  name: 'Ampliar horario',
                  icon: 'glyphicon glyphicon-time',
                },
              },
              tabSelected: 'clinics',
              picker: true,
              newExtraTime: false,
              updateExtratimes: false,
              showTabs: true,
            }
        },
        watch: {
          page() {
            if (this.page == 'home') {
              this.showTabs = false;
            }
          },
          admin() {
            if (this.admin) {
              this.showTabs = false;
            }
          },
        },
        methods: {
          hideTabs() {
            if (this.page == 'home' || this.admin) {
              this.showTabs = false;
            }
          },
          showTab(key) {
            if (this.page == 'tutorial' || this.admin) {
                return false;
            }
            return true;
          },
          doExtraTime() {
            // this.togglePicker();
            this.newExtraTime = true;
            this.picker = true;
          },
          toggleTab(tab) {
            if (this.tabSelected == tab) {
              return;
            }
            if (
              this.addClinic.topButtonClasses.indexOf('danger') != -1 ||
              this.updateSchedules.ButtonClasses.indexOf('danger') != -1
              ) {
              return flash({
                       message:'Cancela cualquier acción antes de cambiar de pestaña.', 
                       label:'warning'
                   });
            }
            this.tabSelected = tab;
            this.newExtraTime = false;
            if (tab == 'extraTime') {
              this.picker = false;
              this.addClinic.topButtonText = 'Nueva Solicitud';
              this.addClinic.selectedStateText = 'Cualquier CA';
              this.addClinic.selectedCountyText = 'Cualquier Provincia';
              this.addClinic.selectedClinicText = 'Cualquier Clínica';
            } else if (tab == 'clinics') {
              this.picker = true;
              this.addClinic.topButtonText = 'Añadir Clínca';
              this.addClinic.selectedStateText = 'Selecciona una CA';
              this.addClinic.selectedCountyText = 'Selecciona una Provincia';
              this.addClinic.selectedClinicText = 'Selecciona una Clínica';
            }
          },
          togglePicker() {
            this.picker ? this.picker = false : this.picker = true;
          },
            scheduleParse() {
                for (let i = 0; i < this.profileSrc.schedules.length; i++) {
                    this.schedules[this.profileSrc.schedules[i].clinic_id] = JSON.parse(this.profileSrc.schedules[i].schedule);
                }
            },
            daysMaker() {
                if (Object.keys(this.schedules).length > 0) {
                  for (let clinic in this.schedules) {
                      for (let o = 0; o < Object.keys(this.dayLabels['es-ES']).length; o++ ) {
                          let index = '0'+(o+1);
                          for (let u = 0; u < this.dayHours.length; u++ ) {
                              if (this.schedules[clinic][index][this.dayHours[u]] != null) {
                                  let id = this.schedules[clinic][index][this.dayHours[u]];
                                  this.days[index][this.dayHours[u]] = id;
                                  this.incrementClinicHours(id);
                              }
                          }
                      }
                  }
                } 
            },
            emptyDaysMaker() {
                this.days = {};
                for (let i = 1; i <= this.daysCount; i++) {
                   let name = '0'+i;
                   let day = {};
                   for (let o = 0; o < this.dayHours.length; o++) {
                        day[this.dayHours[o]] = null;
                    }
                    this.days[name] = day;
               }
            },
            incrementClinicHours(id) {
              if (!this.clinicHours[id]) {
                this.clinicHours[id] = 0;
              }
              this.clinicHours[id]++;
              this.doHours();
            },
            decrementClinicHours(id) {
              this.clinicHours[id]--;
              if (this.clinicHours[id] == 0) {
                this.clinicHours[id] = '0';
              }
              if (this.clinicHours[id] == 0 && !this.restoreMethod) {
                this.removeProfileClinic(id);
              }
              this.doHours();
            },
            toggleAddClinic() {
              if (this.profileSrc.clinics.length > 9 && !this.addClinic.method) {
                flash({message:'Número máximo de clínicas alcanzado. Si necesitas añadir más ponte en contacto con el equipo médico.', label:'warning'});
                return;
              }
              if (this.tabSelected == 'extraTime') {
                if (this.updateExtratimes) {
                  return flash({message:'Debes cancelar la modificación antes de poder añadir.', label:'warning'});
                }
                if (!this.newExtraTime) {
                  this.newExtraTime = true;
                  this.picker = true;
                  this.addClinic.method = 'extraTime';
                  // this.addClinic.selectedClinicId = 'extraTime';
                  this.addClinic.topButtonText = 'Cancelar';
                  this.addClinic.topButtonClasses = 'btn btn-sm btn-danger';
                  this.addClinic.topButtonIcon = 'glyphicon glyphicon-remove';
                } else {
                  this.newExtraTime = false;
                  this.picker = false;
                  this.addClinic.method = null;
                  this.addClinic.selectedClinicId = '';
                  this.addClinic.selectedStateId = '';
                  this.addClinic.selectedCountyId = '';
                  this.addClinic.topButtonText = 'Nueva Solicitud';
                  this.addClinic.topButtonClasses = 'btn btn-sm btn-info';
                  this.addClinic.topButtonIcon = 'glyphicon glyphicon-plus-sign';
                  this.rollbackExtra(this.addClinic.selectedClinicId);
                }
                return;
              }
              if (this.updateSchedules.method) {
                return flash({message:'Debes cancelar la modificación antes de poder añadir.', label:'warning'});
              }
                if (!this.addClinic.method) {
                  this.addClinic.method = 'add';
                  this.addClinic.topButtonText = 'Cancelar';
                  this.addClinic.topButtonClasses = 'btn btn-sm btn-danger';
                  this.addClinic.topButtonIcon = 'glyphicon glyphicon-remove';
                  this.restoreMethod = null;
                } else {
                  this.addClinic.method = false;
                  this.addClinic.topButtonText = 'Añadir Clinica';
                  this.addClinic.topButtonClasses = 'btn btn-sm btn-info';
                  this.addClinic.topButtonIcon = 'glyphicon glyphicon-plus-sign';
                  this.addClinic.selectedCountyId = '';
                  this.addClinic.selectedStateId = '';
                  this.addClinic.selectedClinicId = '';
                }
            },
            toggleUpdate() {
              if (this.tabSelected == 'extraTime') {
                if (this.newExtraTime) {
                  return flash({message:'Debes cancelar el modo añadir antes de poder modificar.', label:'warning'});
                }
                if (!this.updateExtratimes) {
                  this.updateExtratimes = true;
                  this.updateSchedules.ButtonText = 'Cancelar';
                  this.updateSchedules.ButtonClasses = 'btn btn-sm btn-danger';
                  this.updateSchedules.ButtonIcon = 'glyphicon glyphicon-remove';
                } else {
                  this.updateExtratimes = false;
                  this.updateSchedules.ButtonText = 'Modificar';
                  this.updateSchedules.ButtonClasses = 'btn btn-primary';
                  this.updateSchedules.ButtonIcon = 'glyphicon glyphicon-pencil';
                }
              } else if (this.tabSelected == 'clinics') {
                if (this.addClinic.method) {
                  return flash({message:'Debes cancelar el modo añadir antes de poder modificar.', label:'warning'});
                }
                if (!this.updateSchedules.method) {
                  this.updateSchedules.method = 'update';
                  this.updateSchedules.ButtonText = 'Cancelar';
                  this.updateSchedules.ButtonClasses = 'btn btn-sm btn-danger';
                  this.updateSchedules.ButtonIcon = 'glyphicon glyphicon-remove';
                  this.restoreMethod = 'update';
                } else {
                  this.updateSchedules.method = false;
                  // this.restoreMethod = false;
                  this.updateSchedules.selectedClinicId = '';
                  this.addClinic.selectedClinicId = '';
                  this.updateSchedules.ButtonText = 'Modificar';
                  this.updateSchedules.ButtonClasses = 'btn btn-primary';
                  this.updateSchedules.ButtonIcon = 'glyphicon glyphicon-pencil';
                }
              }
            },
            selectState(e) {
                this.addClinic.selectedStateId = e.target.value;
                this.addClinic.countySelectDisabled = false;
                this.addClinic.clinicSelectDisabled = true;
                this.addClinic.selectedClinicId = '';
                this.addClinic.selectedCountyId = '';

            },
            checkState(id) {
                return this.addClinic.selectedStateId == id;
            },
            selectCounty(e) {
                this.addClinic.selectedCountyId = e.target.value;
                this.addClinic.clinicSelectDisabled = false;
                this.addClinic.selectedClinicId = '';
            },
            checkCounty(id, clinicId) {
              for (let i = 0; i < this.profileSrc.clinics.length; i++) {
                if (this.profileSrc.clinics[i].id == clinicId
                    && this.addClinic.selectedClinicId != clinicId
                    && this.addClinic.method != 'extraTime') {
                  return false;
                }
              }
              if (this.addClinic.selectedCountyId != id) {
                return false;
              }
              return true;
            },
            selectClinic(e) {
                this.addClinic.selectedClinicId = e.target.value;
                if (e.target.value == "") {
                  this.addClinic.selectedClinicId = false;
                }
            },
            notifyAdding(data) {
              // console.log('ADDING ID: '+data.clinic_id);
              // console.log('SCHEDULE: '+data.schedule);
              flash({
                  message: 'Nueva Clínica añadida correctamente', 
                  label: 'success'
              });
              this.insertSchedule(data.schedule);
              this.toggleAddClinic();
              if (this.page == 'tutorial') {
                this.$emit('completed');
              }
            },
            notifyExtra(data) {
              flash({
                  message: 'Solicitud enviada.', 
                  label: 'success'
              });
              this.insertExtra(data.extratime);
              this.toggleAddClinic();
            },
            notifyUpdating(data) {
              flash({
                  message: 'Horario actualizado correctamente', 
                  label: 'success'
              });
              // console.log(data);
              if (data.especialtiesToSave || data.especialtiesToRemove) {
                this.updateEspecialties(data);
              }
              if (data.schedule) {
                this.scheduleAdd(data.clinic_id);
                this.insertSchedule(data.schedule);
              }
              this.toggleUpdate();
            },
            updateEspecialties(data) {
              for (let schedule of this.profileSrc.schedules) {
                if (schedule.clinic_id == data.clinic_id) {
                  if (data.especialtiesToSave) {
                    // console.log(data.especialtiesToSaveObjects);
                    for (let especialty of data.especialtiesToSaveObjects) {
                      schedule.especialties.push(especialty);
                    }
                  }
                  if (data.especialtiesToRemove) {
                    for (let id of data.especialtiesToRemove) {
                      for (let i = 0; i < schedule.especialties.length; i++) {
                        if (schedule.especialties[i].id == id)
                        schedule.especialties.splice(i,1);
                      }
                    }
                  }
                }
              }
            },
            notifyRemoving(data) {
              flash({
                  message: 'Clínica eliminada correctamente', 
                  label: 'success'
              });
              this.removeProfileClinic(data.clinicId);
              this.doHours();
              if (!this.profileSrc.clinics.length) {
                this.toggleUpdate();
              }
              // this.fetch();
            },
            notifyExtraRemoved(data) {
              flash({
                  message: 'Solicitud eliminada correctamente', 
                  label: 'success'
              });
              // this.removeProfileExtratime(data.id);
              if (!this.profileSrc.extratimes.length) {
                this.toggleUpdate();
              }
            },
            daysCleaner(id) {
              for (let day in this.days) {
                  for (let hour in this.days[day]) {
                    if (this.days[day][hour] == id) {
                      this.days[day][hour] = null;
                    }
                  }
              }
            },
            scheduleAdd(id) {
              let temp = {};
              for (let day in this.days) {
                temp[day] = {};
                  for (let hour in this.days[day]) {
                    if (this.days[day][hour] == id) {
                      temp[day][hour] = id;
                    } else {
                      temp[day][hour] = null;
                    }
                  }
              }
              this.schedules[id] = temp;
            },
            insertSchedule(schedule) {
              this.profileSrc.schedules.push(schedule);
            },
            scheduleRemove(id) {
              delete(this.schedules[id]);
              this.daysCleaner(id);
            },
            insertExtra(extratime) {
              this.profileSrc.extratimes.push(extratime);
            },
            removeProfileClinic(id) {
              for (let i = 0; i < this.profileSrc.clinics.length; i++) {
                  if (this.profileSrc.clinics[i].id == id) {
                    this.profileSrc.clinics.splice(i,1);
                    break;
                  }
              }
              for (let i = 0; i < this.profileSrc.schedules.length; i++) {
                  if (this.profileSrc.schedules[i].clinic_id == id) {
                    this.profileSrc.schedules.splice(i,1);
                    break;
                  }
              }
              delete(this.clinicHours[id]);
              this.doHours();
              this.scheduleRemove(id);
            },
            checkDay(data) {
              if (!this.clinicHours[data.clinic]) {
                this.clinicHours[data.clinic] = 0;
                for (let i = 0; i < this.clinicsSrc.length; i++) {
                  if (this.clinicsSrc[i].id == data.clinic) {
                    this.profileSrc.clinics.push(this.clinicsSrc[i]);
                    break;
                  }
                }
              }
              if (this.days[data.day][data.hour] == null) {
                this.days[data.day][data.hour] = data.clinic;
                this.incrementClinicHours(data.clinic);
              } else if (this.days[data.day][data.hour] == data.clinic) {
                this.days[data.day][data.hour] = null;
                this.decrementClinicHours(data.clinic);
              }
            },
            rollback(data) {
              // console.log(data);
              if (!data.day) {
                this.daysCleaner(data.id);
                this.removeProfileClinic(data.id);
                return;
              }
              if (this.days[data.day][data.hour] == null || this.days[data.day][data.hour] == data.id) {
                if (!data.value && this.days[data.day][data.hour]) {
                  this.decrementClinicHours(data.id);
                } else if (!this.days[data.day][data.hour] && data.value) {
                  this.incrementClinicHours(data.id);
                }
                this.days[data.day][data.hour] = data.value;
              }
            },
            doHours() {
              let total = 0; 
              for (let clinic in this.clinicHours) {
                total += parseInt(this.clinicHours[clinic]);
              }
              this.totalHours = total; 
            },
            checkProfileClinics() {
              if (this.profileSrc.clinics.length > 0) {
                for (let i = 0; i < this.profileSrc.clinics.length; i++) {
                  if (!this.clinicHours[this.profileSrc.clinics[i].id]) {
                    this.clinicHours[this.profileSrc.clinics[i].id] = '0';
                  }
                }
              }
            },
            fetch() {
              // console.log('FETCHING');
              axios.get('/api/schedule')
                .then(data => {
                  this.refresh(data.data);
                });
            },
            refresh(data) {
              this.profileSrc = data;
              this.scheduleParse();
              this.emptyDaysMaker();
              this.daysMaker();
              this.checkProfileClinics();
            },
            fetchClinics() {
              axios.get('/api/clinics')
                .then(data => {
                  this.clinicsSrc = data.data;
                });
            },
            fetchCounties() {
              axios.get('/api/counties')
                .then(data => {
                  this.countiesSrc = data.data;
                });
            },
            fetchStates() {
              axios.get('/api/states')
                .then(data => {
                  this.statesSrc = data.data;
                });
            },
            rollbackExtra(id) {
              delete(this.schedules[id]);
              this.daysCleaner('extra');
              delete(this.clinicHours['extra']);
              this.doHours();
            }
        },
        computed: {
          clinicNumber() {
            let number = this.profileSrc.clinics.length;
            if (number == 1) {
              return "1 Clínica";
            } else if (number > 1) {
              return number+" Clínicas";
            }
          },
          showEditButton() {
            if (this.tabSelected == 'clinics') {
              if (this.profileSrc.clinics.length) {
                return true;
              }
            } else if (this.tabSelected == 'extraTime') {
              if (this.profileSrc.extratimes.length) {
                return true;
              }
            }
            return false;
          }
        },
        created() {
          if (!this.admin) {
            this.fetch();
            // this.fetchEspecialties();
          } else {
            this.refresh(this.profileSelected);
            // this.profileSrc = this.profileSelected;
          }
          this.fetchClinics();
          this.fetchCounties();
          this.fetchStates();
          this.hideTabs();
        }
    }
</script>
<style type="text/css">
</style>