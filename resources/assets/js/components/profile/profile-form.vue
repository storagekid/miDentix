<template>
    <div>
      <form id="profile-create-form">
        <div class="row">
          <div class="form-group col-xs-12 col-sm-6">
            <label for="name">Nombre:</label>
            <input id="name" type="text" class="form-control" v-model="profileSrc.name" @blur="checkField">
            <span class="help-block" v-if="formErrors.name">
                <strong>{{formErrors.name}}</strong>
            </span>
          </div>
          <div class="form-group col-xs-12 col-sm-6">
            <div class="row">
              <label class=" col-xs-12" for="name">Apellidos:</label>
              <div class=" col-xs-12 col-sm-6">
                <input id="lastname1" type="text" class="form-control" v-model="profileSrc.lastname1" @blur="checkField">
                <span class="help-block" v-if="formErrors.lastname1">
                    <strong>{{formErrors.lastname1}}</strong>
                </span>
              </div>
              <div class=" col-xs-12 col-sm-6">
                <input id="lastname2" type="text" class="form-control" v-model="profileSrc.lastname2" @blur="checkField">
                <span class="help-block" v-if="formErrors.lastname2">
                    <strong>{{formErrors.lastname2}}</strong>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-xs-12 col-sm-12 col-md-8">
            <label for="name">Correo Electrónico:</label>
            <input id="email" type="email" class="form-control" v-model="profileSrc.email" @blur="checkField">
            <span class="help-block" v-if="formErrors.email">
                <strong>{{formErrors.email}}</strong>
            </span>
          </div>
          <div class="form-group col-xs-12 col-sm-6 col-md-4">
            <label for="name">Teléfono:</label>
            <input id="phone" type="text" class="form-control" v-model="profileSrc.phone" @blur="checkField">
            <span class="help-block" v-if="formErrors.phone">
                <strong>{{formErrors.phone}}</strong>
            </span>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-xs-6 col-sm-6 col-md-2">
            <label for="name">Año de Licenciatura:</label>
            <input id="license_year" type="number" :max="thisYear" class="form-control" v-model="profileSrc.license_year" @blur="checkField"> 
            <span class="help-block" v-if="formErrors.license_year">
                <strong>{{formErrors.license_year}}</strong>
            </span>
          </div>
          <div class="form-group col-xs-6 col-sm-6 col-md-5">
            <label for="name">DNI (o equivalente):</label>
            <input id="personal_id_number" type="text" class="form-control" v-model="profileSrc.personal_id_number" @blur="checkField"> 
            <span class="help-block" v-if="formErrors.personal_id_number">
                <strong>{{formErrors.personal_id_number}}</strong>
            </span>
          </div>
          <div class="form-group col-xs-12 col-sm-6 col-md-5">
            <label for="name">Nº de Colegiado/a:</label>
            <input id="license_number" type="text" class="form-control" v-model="profileSrc.license_number" @blur="checkField"> 
            <span class="help-block" v-if="formErrors.license_number">
                <strong>{{formErrors.license_number}}</strong>
            </span>
          </div>
        </div>
        <div class="row">
<!--           <div class="form-group col-xs-12 col-sm-6">
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
          <div class="form-group col-xs-12 col-sm-6">
            <label for="name">Experiencia profesional: <br>(selecciona todas las que procedan)</label>
            <div class="checkbox">
              <label v-for="experience in experiences">
                <input 
                  type="checkbox" 
                  :value="experience.id" 
                  :checked="checkExperiences(experience.id)"
                  @click="checkFieldBox($event,'experiences',experience.id)"
                  >
                {{experience.name}}
              </label>
            </div>
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-xs-8 col-xs-offset-2 form-group">
          <button 
            type="button" 
            class="btn btn-primary btn-block" 
            @click="updateProfile(profileSrc.id)"
            :disabled="errors == 0 ? false : true" 
            >
            <span :class="updateButton.ButtonIcon"></span>{{updateButton.ButtonText}}
          </button>
        </div>
      </div>
    </div>
</template>

<script>
    import * as moment from 'moment';
    import 'moment/locale/es';
    export default {
        components: {},
        props: ['profileSrc','profileOriginal','tutorial'],
        data() {
            return {
              profileToSave: {
              },
              experiencesToSave: [],
              experiencesToRemove: [],
              especialtiesToSave: [],
              especialtiesToRemove: [],
              experiences: {},
              especialties: {},
              updateButton: {
                  method: false,
                  ButtonText: this.tutorial ? 'Confirmar/Actualizar' : 'Actualizar',
                  ButtonClasses: 'btn btn-primary',
                  ButtonIcon: 'glyphicon glyphicon-pencil',
              },
              formErrors: {
               name: false,
               lastname1: false,
               lastname2: false,
               email: false,
               phone: false,
               license_year: false,
               personal_id_number: false,
               license_number: false,
              },
            }
        },
        watch: {
        },
        methods: {
          checkFormField(e) {
            let field = '';
            if (typeof e === 'string') {
              field = e;
            } else {
              field = e.target.id;
            }
            if (this.profileSrc[field] == "" || this.profileSrc[field] == null) {
              this.formErrors[field] = 'Este campo es obligatorio';
              return false;
            }
            if (field == 'name' || field == 'lastname1' || field == 'lastname2') {
              let nameFormat = /^[a-záàâéèêíìîóòôúùûçA-ZÁÀÂÉÈÊÍÌÎÓÒÔÚÙÛÇ\s']+$/;
              if (!this.profileSrc[field].match(nameFormat)) {
                this.formErrors[field] = 'No se permiten números ni símbolos';
                return false;
              }
              if (this.profileSrc[field].length > 30) {
                this.formErrors[field] = 'Máximo 30 caracteres';
                return false;
              }
            }
            if (field == 'email') {
              if (this.profileSrc[field] == (this.profileSrc.personal_id_number+'@migabinete.com')) {
                this.profileSrc[field] = '';
                return false;
              }
              let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
              if (!this.profileSrc[field].match(mailformat)) {
                this.formErrors[field] = 'Introduce un correo válido, por ejemplo: email@dominio.com';
                return false;
              }
            }
            if (field == 'phone') {
              let phoneFormat = /^[0-9\s]+$/;
              if (!this.profileSrc[field].match(phoneFormat)) {
                this.formErrors[field] = 'Solo se permiten números';
                return false;
              }
              if (this.profileSrc[field].length < 9) {
                this.formErrors[field] = 'Debe tener al menos 9 números';
                return false;
              }
              if (this.profileSrc[field].length > 12) {
                this.formErrors[field] = 'Máximo 12 carateres';
                return false;
              }
            }
            if (field == 'license_year') {
              console.log('LICENSE YEAR!');
              if (this.profileSrc[field] < (this.thisYear-60)) {
                this.formErrors[field] = 'Fecha mínima '+(this.thisYear-60);
                return false;
              }
              if (this.profileSrc[field] > this.thisYear) {
                this.formErrors[field] = 'Fecha máxima ' + this.thisYear;
                return false;
              }
            }
            if (field == 'personal_id_number') {
              let format = /^[0-9A-Za-z\-\s]+$/;
              if (!this.profileSrc[field].match(format)) {
                this.formErrors[field] = 'Solo se permiten letras y números';
                return false;
              }
            }
            if (field == 'license_number') {
              let format = /^[0-9A-Za-z\-\s]+$/;
              if (!this.profileSrc[field].match(format)) {
                this.formErrors[field] = 'Solo se permiten letras y números';
                return false;
              }
            }
            this.formErrors[field] = false;
            return true;
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
                this[objectToSave].push(id);
              }
            } else {
              if (orgValue) {
                this[objectToRemove].push(id);
              } else {
                let i = this[objectToSave].indexOf(id);
                if (i != -1) {
                  this[objectToSave].splice(i,1);
                }
              }
            }
          },
          checkField(e, field=null) {
            console.log('CheckField Passed');
            if (!field) {
              field = e.target.id;
            }
            let origin = this.profileOriginal[field];
            let value = e.target.value == "" ? null : e.target.value;

            console.log('Origin: '+origin);
            if (origin != value && !this.formErrors[field]) {
              this.profileToSave[field] = value;
            } else {
              if (this.profileToSave[field]) {
                delete(this.profileToSave[field]);
              }
            }
          },
          checkEspecialties(id) {
            for (let especialty of this.profileSrc.especialties) {
              if (especialty.id == id) {
                return true;
                break;
              }
            }
            return false;
          },
          checkExperiences(id) {
            for (let experience of this.profileSrc.experiences) {
              if (experience.id == id) {
                return true;
                break;
              }
            }
            return false;
          },
          fetchExperiences() {
            axios.get('/api/experience')
              .then(data => {
                this.experiences = data.data;
              });
          },
          // fetchEspecialties() {
          //   axios.get('/api/especialty')
          //     .then(data => {
          //       this.especialties = data.data;
          //     });
          // },
          updateProfile(id) {
            let keys = Object.keys(this.profileToSave).length;
            if (!this.checkForUpdate(keys) && !this.tutorial) {
              return flash({
                       message:'No has hecho ningún cambio.', 
                       label:'warning'
                   });
            } else {
              let profile = keys ? this.profileSrc : null;
              let especialtiesToSave = this.especialtiesToSave.length ? this.especialtiesToSave : null;
              let especialtiesToRemove = this.especialtiesToRemove.length ? this.especialtiesToRemove : null;
              let experiencesToSave = this.experiencesToSave.length ? this.experiencesToSave : null;
              let experiencesToRemove = this.experiencesToRemove.length ? this.experiencesToRemove : null;
              axios.patch('/profile/'+this.profileSrc.id, {
                'profile': profile,
                'especialtiesToRemove': especialtiesToRemove,
                'especialtiesToSave': especialtiesToSave,
                'experiencesToRemove': experiencesToRemove,
                'experiencesToSave': experiencesToSave,
              }).catch((error) => {
                if (error.response.data.errors) {
                  for (let item in error.response.data.errors) {
                      flash({
                          message: error.response.data.errors[item][0], 
                          label: 'danger'
                      });
                    }
                }
                // flash({
                //     message: error.response.data, 
                //     label: 'danger'
                // });
              }).then(response => {
                if (response.status == 200) {
                    this.$emit('updated');
                    this.cleanUpdates();
                }
              });
            }
          },
          checkForUpdate(keys) {
            if (keys || 
                this.especialtiesToSave.length || 
                this.experiencesToSave.length || 
                this.especialtiesToRemove.length || 
                this.experiencesToRemove.length) {
              return true;
            } else {
              return false;
            }
          },
          cleanUpdates() {
            this.profileToSave = {
            };
            this.experiencesToSave = [];
            this.experiencesToRemove = [];
            this.especialtiesToSave = [];
            this.especialtiesToRemove = [];
          },
        },
        computed: {
          errors() {
            let num = 0;
            for (let error in this.formErrors) {
              if (this.formErrors[error]) {
                num++
              }
            }
            return num;
          },
          licenseYear() {
            if (this.profileSrc.license_year) {
              return moment(this.profileSrc.license_year).format('YYYY');
            }
          },
          thisYear() {
            return moment().format('YYYY');
          },
          lastname() {
            return this.profileSrc.lastname1 + ' ' + this.profileSrc.lastname2
          },
          showEditButton() {
            if (this.tabSelected == 'info' && !this.passChange) {
              return true;
            } else if (this.tabSelected == 'masters') {
              if (this.profileSrc.masters.length) {
                return true;
              }
            }
            return false;
          },
        },
        created() {
          moment.locale('es');
          this.fetchExperiences();
          // this.fetchEspecialties();
        },
        beforeUpdate() {
          for (let field in this.formErrors) {
            this.checkFormField(field);
          }
          // if (!this.errors) {
          //   this.$emit('noErrors');
          // }
        }
    }
</script>
<style type="text/css">
</style>