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
                    <div class="col-xs-9 col-xs-offset-2" v-show="addingId">
                        <button type="submit" :class="buttonClasses" @click.prevent="addClinic"><h4>{{buttonText}}</h4></button>
                    </div>
                </div>
                <div class="schedule-day-row">
                    <div class="schedule-frames-row legend">
                        <legend></legend>
                        <div class="col-xs-12 col-md-6" v-for="clinic in clinics">
                            <div 
                            :class="frameClasses(clinic['id'])"
                            v-bind:style="frameStyle"  
                            >
                            <p></p>
                            </div>
                                <p>{{add = clinic['address_real_1'].substring(0,12)+'...'}}. 
                                    <strong>{{clinic['city']}} - 
                                        <span class="badge">{{clinicHours[clinic['id']]}} Horas</span>
                                    </strong>
                                    <button 
                                        class="btn btn-sm btn-danger delete-Schedule"
                                        @click="deleteSchedule(clinic['id'])"
                                        v-show="updateMode"
                                        >
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </button>
                                </p>
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
            'addingId', 
            'schedules', 
            'days', 
            'dayHours', 
            'dayLabels', 
            'clinicHours', 
            'daysCount',
            'updateMode'
        ],
        data() {
            return {
                clinicHoursDef: this.clinicHours,
                scheduleToSave: {},
                scheduleToRestore: {},
                idToRestore: null,
                clinics: this.profileSrc.clinics,
                frameStyle: {},
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
                if (this.updateMode) {
                    if (this.idToRestore) {
                        this.rollBackUpdate(this.idToRestore);
                    }
                    if (this.addingId) {
                        this.getScheduleToRestore(this.addingId);
                        this.idToRestore = this.addingId;
                    } else {
                        this.idToRestore = false;
                        this.scheduleToRestore = {};
                    }
                } else if (this.idToRestore) {
                    this.rollBackUpdate(this.idToRestore);
                    this.idToRestore = false;
                }
            },
        },
        methods: {
            rollBackUpdate(id) {
                for (let day in this.scheduleToRestore) {
                    for (let hour in this.scheduleToRestore[day]) {
                        let value = this.scheduleToRestore[day][hour];
                        this.$emit('rollback', {day,id,hour,value});
                        this.schedules[id][day][hour] = this.scheduleToRestore[day][hour];
                        if (this.daysDef[day][hour] == id || this.daysDef[day][hour] == null) {
                            this.daysDef[day][hour] = this.scheduleToRestore[day][hour];
                        }
                    }
                }
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
                        console.log('FOUIND');
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
            },
            frameStyleMaker() {
                this.frameStyle.width = (100/this.dayHours.length)+'%';
            },
            toggleActive(day, hour, clinic) {
                if (this.addingId) {
                    let clinic = this.addingId;
                    if (!this.jarClasses[this.addingId]) {
                        let index = Object.keys(this.jarClasses).length+1;
                        this.jarClasses[this.addingId] = 'schedule-frame '+'clinic'+(index);
                    } 
                    if (!this.daysDef[day][hour]) {
                        this.daysDef[day][hour] = this.addingId;
                        this.scheduleToSave[day][hour] = this.addingId;
                        this.$emit('toggleDay',{day,hour,clinic});
                    } else if (this.daysDef[day][hour] == this.addingId) {
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
            addClinic() {
                axios[this.callMethod](this.url, 
                    { 
                        clinic_id: this.addingId, 
                        profile_id: this.profileSrc.id,
                        schedule: JSON.stringify(this.scheduleToSave),
                    }).catch((error) => {
                        flash(error.response.data, 'danger');
                    }).then(response => {
                        if (this.updateMode) {
                            this.scheduleToRestore = {};
                            this.$emit('updated', this.addingId);
                        } else {
                            this.$emit('added', this.addingId);
                            this.emptyScheduleMaker();
                        }
                    });
            },
            deleteSchedule_Old(clinicId) {
                this.getScheduleId(clinicId);
                this.daysCleaner(clinicId);
                delete(this.jarClasses[clinicId]);
                axios.delete('/schedule/'+scheduleId)
                    .catch((error) => {
                        flash(error.response.data, 'danger')})
                    .then(response => {
                        this.$emit('deleted', {clinicId});
                    });
            },
            deleteSchedule(clinicId) {
                axios.delete('/clinic_profile/'+clinicId+'/'+this.profileSrc.id)
                    .catch((error) => {
                        flash(error.response.data, 'danger')})
                    .then(response => {
                        if(response.status == 200) {
                            this.$emit('deleted', {clinicId});
                            this.daysCleaner(clinicId);
                            delete(this.jarClasses[clinicId]);
                        }
                    });
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
                if (this.updateMode) {
                    let id = this.getScheduleId(this.addingId);
                    return '/schedule/'+id;
                } else {
                    return '/schedule';
                }
            },
            callMethod() {
                if (this.updateMode) {
                    return 'patch';
                } else {
                    return 'post';
                }
            }
        },
        created() {
            this.classes();
            this.frameStyleMaker();
            // this.daysMaker();
            this.emptyScheduleMaker();
            this.dayMaker();
        },
    }
</script>
<style type="text/css">
</style>