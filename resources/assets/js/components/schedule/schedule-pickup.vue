<template>
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
                <div class="schedule-day-row">
                    <div class="schedule-frames-row legend">
                        <legend></legend>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6" v-for="clinic in clinics">
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
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</template>

<script>
    export default {
        props: [
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
                scheduleToSave: {},
                scheduleToRestore: {},
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
            getClass(id) {
                let index = 1;
                for (let key in this.jarClasses) {
                    if (key == id) {
                        // console.log('FOUIND');
                       return 'schedule-frame clinic'+index;
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
            frameClasses(clinic) {
                return this.getClass(clinic);
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
                        this.emptyScheduleMaker();
                    });
            },
            addClinic() {
                if (!this.newExtraTime) {
                    if (!this.checkBeforeSending()) {
                        return false;
                    }
                    this.idToRestore = null;
                    axios[this.callMethod](this.url, 
                        { 
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
                                    this.$emit('updated', this.addingId);
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
            checkBeforeSendingExtra() {
                if (!this.clinicHoursDef['extra']) {
                    flash({
                        message:'Debes seleccionar al menos una hora.', 
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
            }
        },
        computed: {
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
            }
        },
        created() {
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