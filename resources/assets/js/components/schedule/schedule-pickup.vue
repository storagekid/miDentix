<template>
    <div>
        <div class="form-group col-xs-12 text-center" v-if="addingId || newExtraTime">
          <label for="name"><h3>Especialidades ejercidas en esta clínica:</h3>(selecciona todas las que procedan)</label>
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
        </div>
        <div class="col-xs-12 col-sm-12" id="schedule-container">
            <div id="schedule-outer-frame">
                <div id="schedule-inner-frame" class="panel panel-default">
                <div id="schedule-body">     
                    <div class="schedule-time-row">
                        <div class="schedule-hours-row">
                            <div 
                                class="schedule-hour text-center" 
                                v-bind:style="frameStyle"
                                v-for="hour in dayHours">
                            <span>{{hour}} <span class="hidden-xs">h</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="schedule-day-row" v-for="(day, key) in days">
                        <div class="schedule-day-name-box">
                            <span class="schedule-day-name">{{dayLabels['es-ES'][key]}}</span>   
                        </div>
                        <div class="schedule-frames-row">
                            <div 
                                v-bind:style="frameStyle"  
                                v-for="(clinic, hour) in day"
                                class="schedule-frame"
                                :class="checkClass(key,hour,clinic)"
                                @click="toggleActive(key,hour,clinic)"
                                >
                              <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="row rowBtn">
                        <div class="col-xs-9 col-xs-offset-2" v-show="addingId || newExtraTime">
                            <button type="submit" :class="buttonClasses" @click.prevent="addClinic"><h4>{{buttonText}}</h4></button>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="">
                <div class="schedule-frames-row legend">
                    <legend></legend>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table">
                                <tbody>
                                    <tr v-for="clinic in clinics">
                                        <td><p :class="frameClasses(clinic['id'],true)">
                                            </p>
                                        </td>
                                        <td class="hidden-xs" v-show="tdShowing">{{clinic.city}}</td>
                                        <td><strong>{{clinic.address_real_1}}</strong></td>
                                        <td><strong v-html="getSpecialties(clinic.id)"></strong></td>
                                        <td class="hidden-xs" v-show="tdShowing"><strong v-html="scheduleReader(getSchedule(clinic.id))"></strong></td>
                                        <td><span class="badge">{{clinicHours[clinic['id']]}} H</span></td>
                                        <td>
                                            <button 
                                                class="btn btn-sm btn-danger delete-Schedule"
                                                @click="deleteSchedule(clinic['id'])"
                                                v-show="updateMode"
                                                >
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
<!--                             <div class="row">
                        <div class="col-xs-12 col-sm-6" v-for="clinic in clinics">
                            <div>
                                <div class="col-xs-1">
                                <button 
                                    class="btn btn-sm btn-danger delete-Schedule"
                                    @click="deleteSchedule(clinic['id'])"
                                    v-show="updateMode"
                                    >
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                                </div>
                                <div class=" col-xs-11">
                                    <p :class="frameClasses(clinic['id'])"
                                    v-bind:style="frameLegendStyle">
                                    </p>
                                    <div class="col-xs-11">
                                        <p class="col-xs-7 col-sm-11 col-md-6">{{add = clinic['address_real_1']}}
                                        </p> 
                                        <strong class="col-xs-5 col-sm-12 col-md-6">{{clinic['city']}} - 
                                            <span class="badge">{{clinicHours[clinic['id']]}} H</span>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'clickable',
            'profileSrc',
            'addingCA', 
            'addingPro', 
            'addingId', 
            'schedules', 
            'days', 
            'dayHours', 
            'dayLabels', 
            'clinicHours', 
            'daysCount',
            'updateMode',
            'restoreMethod',
            'newExtraTime'
        ],
        data() {
            return {
                clinicHoursDef: this.clinicHours,
                especialties: [],
                especialtiesToSave: [],
                especialtiesToRemove: [],
                scheduleToSave: {},
                scheduleToRestore: {},
                selectedSchedule: {especialties:[]},
                idToRestore: null,
                updateEmpty: false,
                clinics: this.profileSrc.clinics,
                frameStyle: {},
                frameLegendStyle: {},
                jarClasses: {},
                patata: true,
                daysDef: {
                    '01': {
                        '9': false,'10': false,'11': false,'12': false,'13': false,'14': false,'15': false,'16': false,'17': false,'18': false,'19': false,'20': false,
                    },
                    '02': {
                        '9': false,'10': false,'11': false,'12': false,'13': false,'14': false,'15': false,'16': false,'17': false,'18': false,'19': false,'20': false,
                    },
                    '03': {
                        '9': false,'10': false,'11': false,'12': false,'13': false,'14': false,'15': false,'16': false,'17': false,'18': false,'19': false,'20': false,
                    },
                    '04': {
                        '9': false,'10': false,'11': false,'12': false,'13': false,'14': false,'15': false,'16': false,'17': false,'18': false,'19': false,'20': false,
                    },
                    '05': {
                        '9': false,'10': false,'11': false,'12': false,'13': false,'14': false,'15': false,'16': false,'17': false,'18': false,'19': false,'20': false,
                    },
                    '06': {
                        '9': false,'10': false,'11': false,'12': false,'13': false,'14': false,'15': false,'16': false,'17': false,'18': false,'19': false,'20': false,
                    },
                    '07': {
                        '9': false,'10': false,'11': false,'12': false,'13': false,'14': false,'15': false,'16': false,'17': false,'18': false,'19': false,'20': false,
                    },
                },
            }
        },
        watch: {
            addingId() {
                if (this.idToRestore) {
                    if (this.restoreMethod == 'update') {
                        this.rollBackUpdate(this.idToRestore);
                        this.scheduleToRestore = {};
                        if (this.updateEmpty) {
                            delete(this.schedules[this.idToRestore]);
                            this.idToRestore = null;
                            this.updateEmpty = false;
                        }
                    } else {
                        this.rollBackCreate(this.idToRestore);
                    }
                    this.idToRestore = false;
                }
                if (this.addingId) {
                    if (!this.schedules[this.addingId]) {
                        if (this.updateMode) {
                            this.updateEmpty = true;
                        }
                        this.schedules[this.addingId] = this.emptyScheduleMaker();
                    }
                    this.getScheduleToRestore(this.addingId);
                    this.idToRestore = this.addingId;
                }
                if (!this.addingId) {
                    this.selectedSchedule = {especialties:[]};
                    this.especialtiesToSave = [];
                    this.especialtiesToRemove = [];
                    return;
                }
                  for (let schedule of this.profileSrc.schedules) {
                    if (schedule.clinic_id == this.addingId) {
                      this.selectedSchedule = schedule;
                      break;
                    }
                }
                console.log(this.selectedScheduleId);
            },
            profileSrc() {
                this.clinics = this.profileSrc.clinics;
                this.classes();
                this.dayMaker();
            }
        },
        methods: {
            rollBackUpdate(id) {
                for (let day in this.scheduleToRestore) {
                    for (let hour in this.scheduleToRestore[day]) {
                        let value = this.scheduleToRestore[day][hour];
                        this.schedules[id][day][hour] = this.scheduleToRestore[day][hour];
                        if (this.daysDef[day][hour] == id || this.daysDef[day][hour] == null) {
                            this.daysDef[day][hour] = this.scheduleToRestore[day][hour];
                        }
                        this.$emit('rollback', {day,id,hour,value});
                    }
                }
            },
            rollBackCreate(id) {
                this.daysCleaner(id);
                this.emptyScheduleMaker();
                delete(this.jarClasses[id]);
                this.$emit('rollback', {day:null,id,hour:null,value:null});
            },
            checkClass(day,hour,clinic) {
                if (this.daysDef[day][hour]) {
                    return this.getClass(clinic);
                } 
            },
            getClass(id,legend) {
                let index = 1;
                for (let key in this.jarClasses) {
                    if (key == id) {
                        // console.log('FOUIND');
                        if (!legend) {
                            return 'schedule-frame clinic'+index;
                        } else {
                            return 'schedule-legend clinic'+index;
                        }
                    } else {
                        index++;
                    }
                }
            },
            emptyScheduleMaker() {
                this.scheduleToSave = {};
                for (let i = 1; i <= this.daysCount; i++) {
                   let name = '0'+i;
                   let day = {};
                   for (let o = 0; o < this.dayHours.length; o++) {
                        day[this.dayHours[o]] = null;
                    }
                    this.scheduleToSave[name] = day;
               }
               return this.scheduleToSave;
            },
            frameStyleMaker() {
                this.frameStyle.width = (100/this.dayHours.length)+'%';
            },
            frameLegendStyleMaker() {
                this.frameLegendStyle.width = (100/this.dayHours.length)+'%';
                this.frameLegendStyle.height = '20px';
            },
            toggleActive(day, hour, clinic) {
                if (!this.clickable) {
                    return;
                }
                if (this.addingId || this.newExtraTime) {
                    let clinic = this.newExtraTime ? 'extra' : this.addingId;
                    if (!this.jarClasses[clinic]) {
                        let index = Object.keys(this.jarClasses).length+1;
                        this.jarClasses[clinic] = 'schedule-frame '+'clinic'+(index);
                    } 
                    if (!this.daysDef[day][hour]) {
                        this.daysDef[day][hour] = clinic;
                        this.scheduleToSave[day][hour] = clinic;
                        this.$emit('toggleDay',{day,hour,clinic});
                    } else if (this.daysDef[day][hour] == clinic) {
                        if (this.clinicHoursDef[clinic] == 1) {
                            if (this.updateMode) {
                            flash({message:'No pude haber menos de 1 hora por clínica. Si deseas eliminarla pulsa el boton en la parte inferior.', label:'warning'});
                            } else {
                                flash({message:'No pude haber menos de 1 hora por clínica. Si no quieres añadirla pulsa cancelar.', label:'warning'});
                            }
                            return;
                        }
                        this.daysDef[day][hour] = null;
                        this.scheduleToSave[day][hour] = null;
                        this.$emit('toggleDay',{day,hour,clinic});
                    } else {
                        flash({message:'Ya has añadido esa hora a otra clínica', label:'warning'});
                    }
                } else {
                    flash({message:'Primero debes seleccionar una clínica', label:'warning'});
                }
            },
            frameBackGround() {
                color = [];
                for (let o = 0; o < this.days.length; o++) {
                    for (let i = 0; i < this.days[o].length; i++) {
                        // console.log(this.days[o][i]);
                        color.push(this.days[o][i]);
                    }
                }
            },
            frameClasses(clinic,legend=null) {
                return this.getClass(clinic,legend);
            },
            classes() {
                for (var i = 0; i < this.clinics.length; i++) {
                    this.jarClasses[this.clinics[i].id] = 'schedule-frame '+'clinic'+(i+1);
                }
            },
            daysCleaner(id) {
              for (let day in this.daysDef) {
                  for (let hour in this.daysDef[day]) {
                    if (this.daysDef[day][hour] == id) {
                      this.daysDef[day][hour] = null;
                    }
                  }
              }
            },
            getScheduleId(clinicId) {
                for (let schedule of this.profileSrc.schedules) {
                    if (schedule.clinic_id == clinicId) {
                        return schedule.id;
                        break;
                    }
                }
            },
            addExtraTime() {
                console.log('Adding Extra Time Request');
                axios[this.callMethod](this.url, 
                    { 
                        profile_id: this.profileSrc.id,
                        clinic_id: this.addingId, 
                        provincia_id: this.addingPro,
                        state_id: this.addingCA,
                        schedule: JSON.stringify(this.scheduleToSave),
                        'especialtiesToSave': this.especialtiesToSave,
                    }).catch((error) => {
                        flash({
                            message: error.response.data, 
                            label: 'danger'
                        });
                    }).then(response => {
                        // console.log(response.data);
                        this.$emit('addextra', {
                            clinic_id: this.addingId,
                            extratime: response.data.extratime,
                        });
                        window.events.$emit('extratimeAdded');
                        this.emptyScheduleMaker();
                    });
            },
            addClinic() {
                if (!this.newExtraTime) {
                    if (!this.checkBeforeSending()) {
                        return false;
                    }
                    let especialtiesToSave = this.especialtiesToSave.length ? this.especialtiesToSave : null;
                    let especialtiesToRemove = this.especialtiesToRemove.length ? this.especialtiesToRemove : null;
                    let especialtiesToSaveObjects = [];
                    if (especialtiesToSave) {
                        for (let item of this.especialties) {
                            if (especialtiesToSave.indexOf(item.id) != -1) {
                                especialtiesToSaveObjects.push(item);
                            }
                        }
                    }
                    this.idToRestore = null;
                    axios[this.callMethod](this.url, 
                        { 
                            'especialtiesToRemove': especialtiesToRemove,
                            'especialtiesToSave': especialtiesToSave,
                            clinic_id: this.addingId, 
                            profile_id: this.profileSrc.id,
                            schedule: JSON.stringify(this.scheduleToSave),
                            clinic_profile: this.updateEmpty,
                        }).catch((error) => {
                            flash({
                                message: error.response.data, 
                                label: 'danger'
                            });
                        }).then(response => {
                            if (this.updateMode) {
                                if (!this.updateEmpty) {
                                    this.scheduleToRestore = {};
                                    this.$emit('updated', {
                                        clinic_id: this.addingId,
                                        especialtiesToSave: especialtiesToSave,
                                        especialtiesToSaveObjects: especialtiesToSaveObjects,
                                        especialtiesToRemove: especialtiesToRemove,
                                    });
                                } else {
                                    this.scheduleToRestore = {};
                                    this.$emit('updated', {
                                    clinic_id: this.addingId,
                                    schedule: response.data.schedule,
                                    });
                                }
                                this.updateEmpty = false;
                            } else {
                                // console.log(response.data);
                                this.$emit('added', {
                                    clinic_id: this.addingId,
                                    schedule: response.data.schedule,
                                });
                                this.emptyScheduleMaker();
                            }
                        });
                } else {
                    if (!this.checkBeforeSendingExtra()) {
                        return false;
                    }
                    this.addExtraTime();
                }
            },
            deleteSchedule(clinicId) {
                axios.delete('/clinic_profile/'+clinicId+'/'+this.profileSrc.id)
                    .catch((error) => {
                        flash({
                            message: error.response.data, 
                            label: 'danger'
                        });
                    }).then(response => {
                        if(response.status == 200) {
                            this.$emit('deleted', {clinicId});
                            this.daysCleaner(clinicId);
                            delete(this.jarClasses[clinicId]);
                        }
                    });
            },
            checkBeforeSending() {
                if (!this.clinicHoursDef[this.addingId]) {
                    flash({
                        message:'Debes seleccionar al menos una hora.', 
                        label:'warning'
                    });
                    return false;
                }
                if (!this.updateMode && !this.especialtiesToSave.length ) {
                    flash({
                        message:'Debes seleccionar al menos una especialidad.', 
                        label:'warning'
                    });
                    return false;
                }
                if (this.updateMode && 
                        (this.selectedSchedule.especialties.length + (this.especialtiesToSave.length - this.especialtiesToRemove.length)) <= 0) {
                    flash({
                        message:'Debes seleccionar al menos una especialidad.', 
                        label:'warning'
                    });
                    return false;
                }
                if (
                    JSON.stringify(this.scheduleToRestore) === JSON.stringify(this.scheduleToSave)
                    && !this.especialtiesToRemove.length && !this.especialtiesToSave.length) {
                   flash({
                       message:'No has hecho ningún cambio.', 
                       label:'warning'
                   });
                   return false; 
                }
                return true;
            },
            checkBeforeSendingExtra() {
                if (!this.clinicHoursDef['extra']) {
                    flash({
                        message:'Debes seleccionar al menos una hora.', 
                        label:'warning'
                    });
                    return false;
                }
                if (!this.updateMode && !this.especialtiesToSave.length ) {
                    flash({
                        message:'Debes seleccionar al menos una especialidad.', 
                        label:'warning'
                    });
                    return false;
                }
                if (
                    JSON.stringify(this.scheduleToRestore) === JSON.stringify(this.scheduleToSave)
                    ) {
                   flash({
                       message:'No has hecho ningún cambio.', 
                       label:'warning'
                   });
                   return false; 
                }
                return true;
            },
            dayMaker() {
                for (let day in this.days) {
                    for (let hour in this.days[day]) {
                        this.daysDef[day][hour] = this.days[day][hour];
                    }
                }
            },
            getScheduleToRestore(id) {
                for (let day in this.schedules[id]) {
                    this.scheduleToRestore[day] = {};
                    for (let hour in this.schedules[id][day]) {
                        this.scheduleToRestore[day][hour] = this.schedules[id][day][hour];
                    }
                }
                this.scheduleToSave = this.schedules[id];
            },
            checkFieldBox(e,field,id) {
              let check = function(id) {
                  if (field == "especialties") {
                     return this.checkEspecialties(id);      
                  } else {
                    return this.checkExperiences(id); 
                  }
              }.bind(this);
              let orgValue = check(id);
              let objectToSave = field+'ToSave';
              let objectToRemove = field+'ToRemove';
              if (e.target.checked) {
                if (orgValue) {
                  let i = this[objectToRemove].indexOf(id);
                  if (i != -1) {
                    this[objectToRemove].splice(i,1);
                  }
                } else {
                    if (this.userEspecialties.indexOf(id) == -1) {
                        this[objectToSave].push(id);
                    }
                    let i = this[objectToRemove].indexOf(id);
                    if (i != -1) {
                      this[objectToRemove].splice(i,1);
                    }
                }
              } else {
                if (orgValue) {
                    console.log('here');
                    if (this.userEspecialties.indexOf(id) != -1) {
                        this[objectToRemove].push(id);
                    }
                    let i = this[objectToSave].indexOf(id);
                    if (i != -1) {
                        this[objectToSave].splice(i,1);
                    }
                } else {
                  let i = this[objectToSave].indexOf(id);
                  if (i != -1) {
                    this[objectToSave].splice(i,1);
                  }
                }
              }
            },
            checkEspecialties(id) {
              if (this.selectedSchedule.id) {
                for (let especialty of this.selectedSchedule.especialties) {
                  if (especialty.id == id && (this.especialtiesToRemove.indexOf(id) == -1)) {
                    return true;
                    break;
                  }
                  if (this.especialtiesToSave.indexOf(id) != -1) {
                    return true;
                    break;
                  }
                }
                return false;
              } else {
                console.log("New Clinic");
                  if (this.especialtiesToSave.indexOf(id) != -1) {
                    return true;
                  }
                return false;
              }
            },
            fetchEspecialties() {
              axios.get('/api/especialty')
                .then(data => {
                  this.especialties = data.data;
                });
            },
            getSpecialties(clinicId) {
                let especialties = [];
                for (let schedule of this.profileSrc.schedules) {
                    if (schedule.clinic_id == clinicId) {
                        for (let especialty of schedule.especialties) {
                            if (especialties.indexOf(especialty.name) == -1) {
                                especialties.push(especialty.name);
                            }
                        }
                    }
                }
                return especialties.join('<br>');
            },
            getSchedule(clinicId) {
                for (let schedule of this.profileSrc.schedules) {
                    if (schedule.clinic_id == clinicId) {
                        return schedule.schedule;
                    }
                }
            },
            scheduleReader(schedule, inline=false) {
                // console.log(schedule);
                if (!schedule) {
                    return '-';
                }
                if (inline) {
                  return scheduleToHumans(schedule).replace('<br>',' | ');
                }
                return scheduleToHumans(schedule);
          },
        },
        computed: {
            tdShowing() {
                if (App.page == 'home') {
                    return false;
                }
                return true;
            },
            userEspecialties() {
              let response = []
              for (let especialty of this.selectedSchedule.especialties) {
                response.push(especialty.id);
              }
              return response;
            },
            buttonText() {
                return this.updateMode == 'update' ? 'Modificar' : 'Añadir';
            },
            buttonClasses() {
                return this.updateMode == 'update' ? 'btn btn-warning btn-block' : 'btn btn-primary btn-block';
            },
            url() {
                if (this.updateMode && !this.updateEmpty) {
                    let id = this.getScheduleId(this.addingId);
                    return '/schedule/'+id;
                } else if (this.newExtraTime) {
                    return '/extratime';
                } else {
                    return '/schedule';
                }
            },
            callMethod() {
                if (this.updateMode && !this.updateEmpty) {
                    return 'patch';
                } else {
                    return 'post';
                }
            },
        },
        created() {
            this.fetchEspecialties();
            this.classes();
            this.frameStyleMaker();
            this.frameLegendStyleMaker();
            // this.daysMaker();
            this.emptyScheduleMaker();
            this.dayMaker();
        },
    }
</script>
<style type="text/css">
</style>