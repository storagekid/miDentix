<template>
    <div id="schedule-info-box">
      <div class="panel panel-default panel-tabbed">
        <div class="panel-heading text-center">
          <h3 class="panel-title">
            <ul class="nav nav-tabs" role="tablist" id="profile-tabs">
              <li role="presentation" class="active">
                <a href="#profile-clinics" aria-controls="profile-clinics" role="tab" data-toggle="tab">
                  <span class="glyphicon glyphicon-home"></span>Clínicas
                </a>
              </li>
              <li role="presentation">
                <a href="#schedule-extra-time" aria-controls="schedule-extra-time" role="tab" data-toggle="tab">
                  <span class="glyphicon glyphicon-time"></span>Bolsa de Horas
                </a>
              </li>
            </ul>
          </h3>
        </div>
        <div class="panel-body">
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="profile-clinics">
              <div class="btn-new text-center">
                <button type="button" :class="addClinic.topButtonClasses" @click="toggleAddClinic">
                  <h3><span :class="addClinic.topButtonIcon"></span>{{addClinic.topButtonText}}</h3>
                </button>
                <form id="new-clinic-form" v-show="addClinic.method">
                    <div class="form-group col-xs-12 col-md-4">
                        <label for="clinic_id">CCAA</label>
                        <select class="form-control" id="state_id" name="state_id" @change="selectState">
                          <option disabled="" selected>Selecciona una CCAA</option>
                            <option v-for="state in statesSrc" :value="state['id']">{{state['name']}}</option>
                        </select>
                    </div>
                    <div class="form-group col-xs-12 col-md-4">
                        <label for="clinic_id">Provincia</label>
                        <select class="form-control" id="provincia_id" name="provincia_id" @change="selectProvincia" :disabled="addClinic.provinciaSelectDisabled">
                          <option selected>Selecciona una Provincia</option>
                            <option 
                                v-for="provincia in provinciasSrc" 
                                :value="provincia['id']" 
                                v-if="checkState(provincia['state_id'])"
                                >
                                {{provincia['nombre']}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-xs-12 col-md-4">
                        <label for="clinic_id">Clínica</label>
                        <select class="form-control" id="clinic_id" name="clinic_id" @change="selectClinic" :disabled="addClinic.clinicSelectDisabled">
                          <option selected>Selecciona una clínica</option>
                            <option 
                                v-for="clinic in clinicsSrc" 
                                :value="clinic['id']"
                                v-if="checkProvincia(clinic['provincia_id'],clinic['id'])"
                                >
                                {{clinic['city']}} ({{clinic['address_real_1']}})
                            </option>
                        </select>
                    </div>
                </form>
              </div>
              <ul class="list-group">
                <div class="row">
                  <div class="col-xs-12">
                    <schedule-pickup 
                      :profile-src="profileSrc" 
                      :addingId="addClinic.selectedClinicId"
                      :schedules="schedules"
                      :days="days"
                      :dayHours="dayHours"
                      :dayLabels="dayLabels"
                      :clinicHours="clinicHours"
                      :daysCount="daysCount"
                      :updateMode="updateSchedules.method"
                      @added="notifyAdding"
                      @deleted="notifyRemoving"
                      @toggleDay="checkDay"
                      ></schedule-pickup>
                  </div>
                </div>
              </ul>
            </div>
            <div role="tabpanel" class="tab-pane" id="schedule-extra-time">
              <div class="schedule-table">
                <a href="/schedule/id/extratime/create" class="text-center" style="display: inherit;">
                  <button type="button" class="btn btn-sm btn-info">
                    <h3><span class="glyphicon glyphicon-plus-sign"></span>Nueva solicitud</h3>
                  </button>
                </a>
                <table class="table table-responsive">
                  <thead>
                    <tr>
                      <th>Provincia</th>
                      <th>Clínica</th>
                      <th class="hidden-xs">Fecha</th>
                      <th>Detalles</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Barcelona</td>
                      <td>Castelldefels (Av. Santa Maria, 11)</td>
                      <td class="hidden-xs">25/11/2017</td>
                      <td>
                        M: 18:00 - 20:00 <br>
                        X: 18:00 - 20:00 <br>
                        S: 9:00 - 15:00
                      </td>
                      <td>
                        <div class="label label-danger list-badget">
                          <span class="hidden-xs">Denegada</span>
                          <span class="glyphicon glyphicon-remove-sign visible-xs-block"></span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Barcelona <br>
                        Tarragona <br>
                        Castellón
                      </td>
                      <td>Indiferente</td>
                      <td class="hidden-xs">12/09/2017</td>
                      <td>
                        L: 14:00 - 18:00 <br>
                        X: 14:00 - 18:00
                      </td>
                      <td>
                        <div class="label label-warning list-badget">
                          <span class="hidden-xs">Pendiente</span>
                          <span class="glyphicon glyphicon-question-sign visible-xs-block"></span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Indiferente</td>
                      <td>Indiferente</td>
                      <td class="hidden-xs">27/08/2017</td>
                      <td>
                        L: 10:00 - 14:00 <br>
                        X: 10:00 - 14:00
                      </td>
                      <td>
                        <div class="label label-success list-badget">
                          <span class="hidden-xs">Aceptada</span>
                          <span class="glyphicon glyphicon-ok-sign visible-xs-block"></span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="panel-footer">
            <div id="profile-info-footer">
              <h3>
                <span class="glyphicon glyphicon-time"></span>Total Horas: {{totalHours}}
              </h3>
              <button type="button" :class="updateSchedules.ButtonClasses" @click="toggleUpdate">
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
    export default {
        components: {schedulePickup},
        props: ['clinicsSrc', 'provinciasSrc', 'statesSrc'],
        data() {
            return {
              profileSrc: null,
              schedules: {},
              clinicHours: {},
              days: {},
              daysCount: 7,
              totalHours: 0,
              dayLabels: {
                    'es-ES': {'01':'L','02':'M','03':'X','04':'J','05':'V','06':'S','07':'D'}
                },
              dayHours: ['9','10','11','12','13','14','15','16','17','18','19','20'],
              addClinic: {
                  method: false,
                  provinciaSelectDisabled: true,
                  clinicSelectDisabled: true,
                  topButtonText: 'Añadir Clinica',
                  topButtonClasses: 'btn btn-sm btn-info',
                  topButtonIcon: 'glyphicon glyphicon-plus-sign',
                  selectedStateId: false,
                  selectedProvinciaId: false,
                  selectedClinicId: false,
              },
              updateSchedules: {
                  method: false,
                  provinciaSelectDisabled: true,
                  clinicSelectDisabled: true,
                  ButtonText: 'Modificar',
                  ButtonClasses: 'btn btn-primary',
                  ButtonIcon: 'glyphicon glyphicon-pencil',
                  selectedStateId: false,
                  selectedProvinciaId: false,
                  selectedClinicId: false,
              }
            }
        },
        watch: {
        },
        methods: {
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
                this.removeProfileClinic(id);
              }
              this.doHours();
            },
            toggleAddClinic() {
                if (!this.addClinic.method) {
                  if (this.profileSrc.clinics.length > 3) {
                    flash({message:'Número máximo de clínicas alcanzado. Si necesitas añadir más ponte en contacto con el equipo médico.', label:'warning'});
                    return;
                  }
                  this.addClinic.method = 'add';
                  this.addClinic.topButtonText = 'Cancelar';
                  this.addClinic.topButtonClasses = 'btn btn-sm btn-danger';
                  this.addClinic.topButtonIcon = 'glyphicon glyphicon-remove';
                } else {
                  this.addClinic.method = false;
                  this.addClinic.topButtonText = 'Añadir Clinica';
                  this.addClinic.topButtonClasses = 'btn btn-sm btn-info';
                  this.addClinic.topButtonIcon = 'glyphicon glyphicon-plus-sign';
                  this.addClinic.selectedProvinciaId = false;
                  this.addClinic.selectedStateId = false;
                  this.addClinic.selectedClinicId = false;
                }
            },
            toggleUpdate() {
                if (!this.updateSchedules.method) {
                  this.updateSchedules.method = 'update';
                  this.updateSchedules.ButtonText = 'Cancelar';
                  this.updateSchedules.ButtonClasses = 'btn btn-sm btn-danger';
                  this.updateSchedules.ButtonIcon = 'glyphicon glyphicon-remove';
                } else {
                  this.updateSchedules.method = false;
                  this.updateSchedules.ButtonText = 'Modificar';
                  this.updateSchedules.ButtonClasses = 'btn btn-primary';
                  this.updateSchedules.ButtonIcon = 'glyphicon glyphicon-pencil';
                }
            },
            selectState(e) {
                this.addClinic.selectedStateId = e.target.value;
                this.addClinic.provinciaSelectDisabled = false;
                this.addClinic.clinicSelectDisabled = true;
                this.addClinic.selectedClinicId = false;

            },
            checkState(id) {
                return this.addClinic.selectedStateId == id;
            },
            selectProvincia(e) {
                this.addClinic.selectedProvinciaId = e.target.value;
                this.addClinic.clinicSelectDisabled = false;
                this.addClinic.selectedClinicId = false;
            },
            checkProvincia(id, clinicId) {
              for (let i = 0; i < this.profileSrc.clinics.length; i++) {
                if (this.profileSrc.clinics[i].id == clinicId) {
                  return false;
                }
              }
              if (this.addClinic.selectedProvinciaId != id) {
                return false;
              }
              return true;
            },
            selectClinic(e) {
                this.addClinic.selectedClinicId = e.target.value;
            },
            fetch() {
              console.log('FETCHING');
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
            },
            notifyAdding(id) {
              flash({
                  message: 'Nueva Clínica añadida correctamente', 
                  label: 'success'
              });
              this.scheduleAdd(id);
              this.toggleAddClinic();
            },
            notifyRemoving(data) {
              flash({
                  message: 'Clínica eliminada correctamente', 
                  label: 'success'
              });
              this.removeProfileClinic(data.clinicId);
              this.doHours();
              // this.fetch();
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
            scheduleRemove(id) {
              delete(this.schedules[id]);
              this.daysCleaner(id);
            },
            removeProfileClinic(id) {
              for (let i = 0; i < this.profileSrc.clinics.length; i++) {
                  if (this.profileSrc.clinics[i].id == id) {
                    this.profileSrc.clinics.splice(i,1);
                    break;
                  }
              }
              delete(this.clinicHours[id]);
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
            doHours() {
              let total = 0; 
              for (let clinic in this.clinicHours) {
                total += this.clinicHours[clinic];
              }
              this.totalHours = total; 
            },
        },
        computed: {
        },
        created() {
          this.fetch();
        }
    }
</script>
<style type="text/css">
</style>