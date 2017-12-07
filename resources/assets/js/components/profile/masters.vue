<template>
  <div>
    <div class="btn-new text-center">
      <button type="button" :class="addMaster.topButtonClasses" @click="toggleAddMaster">
        <h3><span :class="addMaster.topButtonIcon"></span>{{addMaster.topButtonText}}</h3>
      </button>
      <form id="new-clinic-form" v-show="addMaster.method">
        <div class="row">
          <div class="form-group col-xs-12 col-md-6">
              <label for="university_id">Universidad</label>
              <select class="form-control" id="university_id" name="university_id" @change="selectUniversity" v-model="addMaster.selectedUniId">
                <option 
                  disabled="" 
                  :selected="addMaster.selectedStateId"
                  value=""
                  >{{addMaster.selectedUniText}}
                </option>
                <option 
                  value="other"
                  >Otro Centro de Formación
                </option>
                <option 
                  v-for="university in universities" 
                  :value="university['id']"
                  v-if="checkUniversity(university['id'])"
                  >{{university['name']}}
                </option>
              </select>
          </div>
          <div class="form-group col-xs-12 col-md-6">
              <label for="master_id">Master</label>
              <select 
                class="form-control" 
                id="master_id" 
                name="master_id" 
                @change="selectMaster" 
                :disabled="addMaster.masterSelectDisabled"
                v-model="addMaster.selectedMasterId"
                >
                <option 
                  disabled="" 
                  :selected="addMaster.selectedMasterId"
                  value=""
                >{{addMaster.selectedMasterText}}</option>
                  <option 
                      v-for="master in masters" 
                      :value="master['id']" 
                      v-if="checkMaster(master.pivot.university_id,master.id)"
                      >
                      {{master['name']}}
                  </option>
              </select>
          </div>
        </div>
        <div class="row" v-if="addMaster.selectedUniId == 'other'">
          <div class="form-group col-xs-12 col-sm-6">
            <label for="school">Indícanos el centro</label>
            <input 
              type="text" 
              name="school" 
              class="form-control"
              v-model="addMaster.selectedOtherSchool"
            >
          </div>
          <div class="form-group col-xs-12 col-sm-6">
            <label for="course">Nombre del curso</label>
            <input 
              type="text" 
              name="course" 
              class="form-control"
              v-model="addMaster.selectedOtherCourse"
            >
          </div>
        </div>
      </form>
      <div 
        class="row rowBtn" 
        v-show="addMaster.selectedMasterId || checkOther()"
        >
          <div class="col-xs-10 col-xs-offset-1">
              <button type="submit" :class="buttonClasses" @click.prevent="recordMaster"><h4>{{buttonText}}</h4></button>
          </div>
      </div>
    </div>
    <div class="table">
      <div class="alert alert-info text-center">
        <h4>Masters Registrados</h4>
      </div>
      <table class="table table-responsive" v-if="profileSrc.masters.length">
        <thead>
          <tr>
            <th>Universidad</th>
            <th>Master</th>
            <th class="buttons-text icons"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="master in profileSrc.masters">
            <td>{{master.university.name}}</td>
            <td>{{master.master.name}}</td>
            <td>
              <button 
                  class="btn btn-sm btn-danger delete-Schedule"
                  @click="deleteMaster(master.id)"
                  >
                  <span class="glyphicon glyphicon-remove"></span>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="text-center" v-else>
        <h3 class="empty">No has añadido ningún master</h3>
      </div>
    </div>
    <div class="table">
      <div class="alert alert-info text-center">
        <h4>Otros Cursos</h4>
      </div>
      <table class="table table-responsive" v-if="profileSrc.courses.length">
        <thead>
          <tr>
            <th>Centro</th>
            <th>Curso</th>
            <th class="buttons-text icons"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="course in profileSrc.courses">
            <td>{{course.school}}</td>
            <td>{{course.course}}</td>
            <td>
              <button 
                  class="btn btn-sm btn-danger delete-Schedule"
                  @click="deleteCourse(course.id)"
                  >
                  <span class="glyphicon glyphicon-remove"></span>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="text-center" v-else>
        <h3 class="empty">No has añadido ningún curso</h3>
      </div>
    </div>
  </div>
</template>

<script>
    import * as moment from 'moment';
    import 'moment/locale/es';
    export default {
        props: ['updateMethod'],
        data() {
            return {
              profileSrc: {
                masters: [],
                courses: [],
              },
              universities: {},
              masters: [],
              profileUniversities: {},
              updateMasters: this.updateMethod,
              addMaster: {
                method:false,
                masterSelectDisabled: true,
                topButtonText: 'Añadir Máster',
                topButtonClasses: 'btn btn-sm btn-info',
                topButtonIcon: 'glyphicon glyphicon-plus-sign',
                selectedUniId: '',
                selectedUniText: 'Selecciona una Universidad',
                selectedMasterId: '',
                selectedMasterText: 'Selecciona un Master',
                selectedOtherSchool: '',
                selectedOtherCourse: '',
              },
              buttonText: 'Añadir',
              buttonClasses: 'btn btn-primary btn-block',
          };
        },
        watch: {
          updateMethod() {
            this.updateMasters = this.updateMethod;
          }
        },
        methods: {
          checkOther() {
            if (this.addMaster.selectedOtherSchool.length > 5 
              && this.addMaster.selectedOtherCourse.length > 5) {
              return true;
            }
            return false;
          },
          checkUniversity(id) {
            if (this.profileUniversities[id]) {
              for (let university of this.universities) {
                if (university.id == id) {
                  if (this.profileUniversities[id]) {
                    if (university.masters.length == this.profileUniversities[id].length) {
                    return false;
                    }
                  }
                }
              }
            }
            return true;
          },
          checkMaster(universityId,masterId) {
            if (this.profileUniversities[universityId]) {
              if (this.profileUniversities[universityId].indexOf(masterId) != -1) {
                return false;
              }
            }
            return true;
          },
          toggleAddMaster() {
            if (!this.addMaster.method) {
              this.addMaster.method = true;
              this.addMaster.topButtonText = 'Cancelar';
              this.addMaster.topButtonClasses = 'btn btn-sm btn-danger';
              this.addMaster.topButtonIcon = 'glyphicon glyphicon-remove';
            } else {
              this.addMaster.method = false;
              this.addMaster.topButtonText = 'Añadir Máster';
              this.addMaster.topButtonClasses = 'btn btn-sm btn-info';
              this.addMaster.topButtonIcon = 'glyphicon glyphicon-plus-sign';
              this.addMaster.selectedUniId = '';
              this.addMaster.masterSelectDisabled = true;
              this.addMaster.selectedMasterId = '';
              this.masters = [];
              this.addMaster.selectedOtherCourse = '';
              this.addMaster.selectedOtherSchool = '';
            }
          },
          selectUniversity(e) {
            this.addMaster.selectedUniId = e.target.value;
            if (this.addMaster.selectedUniId != 'other') {
              this.addMaster.masterSelectDisabled = false;
              this.addMaster.selectedOtherSchool = '';
              this.addMaster.selectedOtherCourse = '';
              this.addMaster.selectedMasterId = '';
              for (let university of this.universities) {
                if (university.id == this.addMaster.selectedUniId) {
                  this.masters = university.masters;
                  break;
                }
              }
            } else {
              this.addMaster.masterSelectDisabled = true;
              this.addMaster.selectedMasterId = '';
              this.masters = [];
            }
          },
          selectMaster(e) {
            this.addMaster.selectedMasterId = e.target.value;
          },
          deleteMaster(id) {
            axios.delete('/masters/'+id)
              .catch((error) => {
                  flash({
                      message: error.response.data, 
                      label: 'danger'
                  });
              }).then(response => {
                  if(response.status == 200) {
                    this.fetchProfile();
                    this.$emit('deleted', {id});
                  }
              });
          },
          deleteCourse(id) {
            axios.delete('/courses/'+id)
              .catch((error) => {
                  flash({
                      message: error.response.data, 
                      label: 'danger'
                  });
              }).then(response => {
                  if(response.status == 200) {
                    this.fetchProfile();
                    this.$emit('courseDeleted', {id});
                  }
              });
          },
          fetchProfile() {
            axios.get('/api/profile')
              .then(data => {
                this.profileSrc = data.data;
                this.collectUniversities();
              });
          },
          fetchUniversities() {
            axios.get('/api/universities')
              .then(data => {
                this.universities = data.data;
              });
          },
          collectUniversities() {
            this.profileUniversities = {};
            for (let master of this.profileSrc.masters) {
              if (!this.profileUniversities[master.university_id]) {
                this.profileUniversities[master.university_id] = [master.master_id];
              } else {
                this.profileUniversities[master.university_id].push(master.master_id);
              }
            }
          },
          recordMaster() {
            let master_id, university_id, school, course;
            if (this.addMaster.selectedOtherCourse != '') {
              master_id = null;
              university_id = null;
              school = this.addMaster.selectedOtherSchool;
              course = this.addMaster.selectedOtherCourse;
            } else {
              master_id = this.addMaster.selectedMasterId;
              university_id = this.addMaster.selectedUniId;
              school = null;
              course = null;
            }
            axios.post('/masters/'+this.profileSrc.id, {
              'master_id': master_id,
              'university_id': university_id,
              'school': school,
              'course': course,
            }).catch((error) => {
              flash({
                  message: error.response.data, 
                  label: 'danger'
              });
            }).then(response => {
              this.fetchProfile();
              this.toggleAddMaster();
              this.$emit('added');
            });
          },
        },
        computed: {
        },
        created() {
          this.fetchProfile();
          this.fetchUniversities();
          moment.locale('es');
        },
    }
</script>
<style type="text/css">
</style>