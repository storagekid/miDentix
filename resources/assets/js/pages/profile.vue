<template>
    <div id="profile-info-box">
      <div class="panel panel-default panel-tabbed">
        <div class="panel-heading text-center">
          <h3 class="panel-title">
            <ul class="nav nav-tabs">
              <li :class="{'active': tabSelected == key}" v-for="(tab, key) in tabs">
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
              <div v-if="tabSelected == 'info'">
                <div class="profile-box-picture" v-if="!passChange">
                  <div class="profile-pic-round text-center">
                    <a href="/profile" class="thumbnail center-block">
                      <img src="/img/profile.jpg" alt="...">
                    </a>
                  </div>
                  <div class="btn-center-box col-xs-12">
                    <a href="#" id="image-change-button">
                      <button class="btn btn-info">Cambiar Imagen</button>
                    </a>
                    <a href="#" id="image-change-button"  @click.prevent="toggleChangePass">
                      <button class="btn btn-warning">Cambiar Contraseña</button>
                    </a>
                  </div>
                </div>
                <div class="profile-box-picture" v-if="passChange">
                  <form id="profile-create-form">
                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-8 col-sm-offset-2">
                        <label for="name">Contraseña actual:</label>
                        <input id="oldPass" type="password" class="form-control" v-model="profilePass.old">
                      </div>
                      <div class="form-group col-xs-12 col-sm-8 col-sm-offset-2">
                        <label for="newPass">Nueva Contraseña:</label>
                        <password
                        v-model="profilePass.new"
                        :name="'newPass'"
                        :placeholder="password.placeholder"
                        :secureLength="password.secureLength"
                        defaultClass="form-control"
                        :errorClass="'label label-danger'"
                        :successClass="'label label-success'"
                        :user-inputs="[profileSrc.email,profileSrc.name,profileSrc.lastname1,profileSrc.lastname2]"
                        :strengthMessages="['Muy débil', 'Débil', 'Medio', 'Segura', 'Muy segura']"
                        >
                        </password>
                      </div>
                      <div class="form-group col-xs-12 col-sm-8 col-sm-offset-2">
                        <label for="newPass2">Confirmar nueva Contraseña:</label>
                        <input id="newPass2" type="password" class="form-control" v-model="profilePass.new2">
                      </div>
                    </div>
                  </form>
                  <div class="btn-center-box col-xs-12">
                    <a href="#" id="image-change-button"  @click.prevent="sendChangePass">
                      <button class="btn btn-primary">Confirmar cambio</button>
                    </a>
                    <a href="#" id="image-change-button"  @click.prevent="toggleChangePass">
                      <button class="btn btn-danger">Cancelar</button>
                    </a>
                  </div>
                </div>
                <div id="profile-box-table">
                  <form id="profile-create-form">
                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6">
                        <label for="name">Nombre:</label>
                        <input id="name" type="text" class="form-control" :value="profileSrc.name" @blur="checkField">
                      </div>
                      <div class="form-group col-xs-12 col-sm-6">
                        <div class="row">
                          <label class=" col-xs-12" for="name">Apellidos:</label>
                          <div class=" col-xs-12 col-sm-6">
                            <input id="lastname1" type="text" class="form-control" :value="profileSrc.lastname1" @blur="checkField">
                          </div>
                          <div class=" col-xs-12 col-sm-6">
                            <input id="lastname2" type="text" class="form-control" :value="profileSrc.lastname2" @blur="checkField">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-12 col-md-8">
                        <label for="name">Correo Electrónico:</label>
                        <input id="email" type="email" class="form-control" :value="profileSrc.email" @blur="checkField">
                      </div>
                      <div class="form-group col-xs-6 col-sm-6 col-md-4">
                        <label for="name">Teléfono:</label>
                        <input id="phone" type="text" class="form-control" :value="profileSrc.phone" @blur="checkField">
                      </div>
                      <div class="form-group col-xs-6 col-sm-6 col-md-2">
                        <label for="name">Año de Licenciatura:</label>
                        <input id="license_year" type="number" :max="thisYear" class="form-control" :value="licenseYear" @blur="checkField($event,'licenseYear')"> 
                      </div>
                      <div class="form-group col-xs-6 col-sm-6 col-md-5">
                        <label for="name">DNI (o equivalente):</label>
                        <input id="personal_id_number" type="text" class="form-control" :value="profileSrc.personal_id_number" @blur="checkField"> 
                      </div>
                      <div class="form-group col-xs-6 col-sm-6 col-md-5">
                        <label for="name">Nº de Colegiado/a:</label>
                        <input id="license_number" type="text" class="form-control" :value="profileSrc.license_number" @blur="checkField"> 
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6">
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
                      </div>
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
                </div>
              </div>
              <masters 
                v-if="tabSelected == 'masters'"
                :updateMethod="updateButton.method"
                @added="notifyAdded"
                @deleted="notifyDeleted"
                >
              </masters>
            </div>
          </div>
          <div class="panel-footer">
            <div id="profile-info-footer">
              <h3>
                <span class="glyphicon glyphicon-calendar" v-if="updatedDate"></span><span v-if="updatedDate" v-text="updatedDate"></span>
              </h3>
              <button 
                type="button" 
                :class="updateButton.ButtonClasses" 
                @click="editButtonMethod()"
                v-if="showEditButton"
                >
                <span :class="updateButton.ButtonIcon"></span>{{updateButton.ButtonText}}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    // import schedulePickup from '../components/schedule/schedule-pickup.vue';
    import masters from '../components/profile/masters.vue';
    import Password from 'vue-password-strength-meter';
    import * as moment from 'moment';
    import 'moment/locale/es';
    export default {
        components: {masters,Password},
        props: [],
        data() {
            return {
              passChange: false,
              profilePass: {
                old: null,
                new: '',
                new2: ''
              },
              password: {
                placeholder: 'Mínimo 8 caractéres',
                secureLength: 8,
              },
              profileToSave: {
              },
              experiencesToSave: [],
              experiencesToRemove: [],
              especialtiesToSave: [],
              especialtiesToRemove: [],
              profileSrc: {},
              experiences: {},
              especialties: {},
              updatedDate: false,
              updateButton: {
                  method: false,
                  ButtonText: 'Actualizar',
                  ButtonClasses: 'btn btn-primary',
                  ButtonIcon: 'glyphicon glyphicon-pencil',
              },
              tabs: {
                info: {
                  name: 'Datos Personales',
                  icon: 'glyphicon glyphicon-user',
                },
                masters: {
                  name: 'Masters',
                  icon: 'glyphicon glyphicon-education',
                },
              },
              tabSelected: 'info',
            }
        },
        watch: {
          // updatedDate() {
          //   this.updateDate();
          // }
        },
        methods: {
          toggleChangePass() {
            if (!this.passChange) {
              this.passChange = true;
            } else {
              this.passChange = false;
              this.profilePass.old = '';
              this.profilePass.new = '';
              this.profilePass.new2 = '';
            }
          },
          editButtonMethod() {
            if (this.tabSelected == 'info') {
              this.updateProfile();
            } else if (this.tabSelected == 'masters') {
              this.toggleUpdate();
            }
          },
          toggleUpdate() {
            if (!this.updateButton.method) {
              this.updateButton.method = true;
              this.updateButton.ButtonText = 'Cancelar';
              this.updateButton.ButtonClasses = 'btn btn-danger';
              this.updateButton.ButtonIcon = 'glyphicon glyphicon-remove';
            } else {
              this.updateButton.method = false;
              this.updateButton.ButtonText = 'Modificar';
              this.updateButton.ButtonClasses = 'btn btn-primary';
              this.updateButton.ButtonIcon = 'glyphicon glyphicon-pencil';
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
          toggleTab(tab) {
            if (this.tabSelected == tab) {
              return;
            }
            // if (
            //   this.addClinic.topButtonClasses.indexOf('danger') != -1 ||
            //   this.updateSchedules.ButtonClasses.indexOf('danger') != -1
            //   ) {
            //   return flash({
            //            message:'Cancela cualquier acción antes de cambiar de pestaña.', 
            //            label:'warning'
            //        });
            // }
            this.tabSelected = tab;
            if (tab == 'info') {
              this.updateButton.ButtonText = 'Actualizar';
            } else if (tab == 'masters') {
              this.passChange = false;
              this.updateButton.ButtonText = 'Modificar';
            }
          },
          fetchProfile() {
            axios.get('/api/profile')
              .then(data => {
                this.profileSrc = data.data;
                this.updateDate();
              });
          },
          fetchExperiences() {
            axios.get('/api/experience')
              .then(data => {
                this.experiences = data.data;
              });
          },
          fetchEspecialties() {
            axios.get('/api/especialty')
              .then(data => {
                this.especialties = data.data;
              });
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
          updateDate() {
            if (this.profileSrc.updated_at > this.profileSrc.created_at) {
              this.updatedDate = 'Actualizado el: '+moment(this.profileSrc.updated_at).format('L');
            }
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
            let origin = '';
            let value = e.target.value;
            if (field) {
              if (field == 'licenseYear') {
                origin = moment(this.profileSrc.license_year).format('YYYY');
              }
            } else {
              origin = this.profileSrc[e.target.id];
            }
            if (origin != value) {
              this.profileToSave[e.target.id] = value;
            } else {
              if (this.profileToSave[e.target.id]) {
                delete(this.profileToSave[e.target.id]);
              }
            }
          },
          notifyAdded() {
            flash({
                 message:'Master añadido.', 
                 label:'success'
             });
            this.fetchProfile();
          },
          notifyDeleted() {
            flash({
                 message:'Master elimindao.', 
                 label:'success'
             });
            this.fetchProfile();
          },
          updateProfile(id) {
            let keys = Object.keys(this.profileToSave).length;
            if (!this.checkForUpdate(keys)) {
              return flash({
                       message:'No has hecho ningún cambio.', 
                       label:'warning'
                   });
            } else {
              let profile = keys ? this.profileToSave : null;
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
                flash({
                    message: error.response.data, 
                    label: 'danger'
                });
              }).then(response => {
                this.fetchProfile();
                this.cleanUpdates();
                flash({
                    message: 'Perfil actualizado', 
                    label: 'success'
                });
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
          sendChangePass() {
            if (!this.checkPassword()) {
              return false;
            }
            axios.patch('/api/user/passreset', {
              'Contraseña Actual': this.profilePass.old,
              'Nueva Contraseña': this.profilePass.new,
              'Nueva Contraseña_confirmation': this.profilePass.new2
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
                        message: 'Contraseña actualizada correctamente.', 
                        label: 'success'
                    });
                    this.toggleChangePass();
                  }
              });
          },
          checkPassword() {
            if (!this.profilePass.old) {
              flash({
                  message: 'Debes introducir la contraseña actual', 
                  label: 'warning'
              });
              return false;
            }
            if (this.profilePass.new.length < this.password.secureLength) {
              flash({
                  message: 'La nueva contraseña debe tener al menos 8 caracteres', 
                  label: 'warning'
              });
              return false;
            }
            if (this.profilePass.new != this.profilePass.new2) {
              flash({
                  message: 'Las nuevas contraseñas no coinciden', 
                  label: 'warning'
              });
              return false;
            }
            return true;
          }
        },
        computed: {
          thisYear() {
            return moment().format('YYYY');
          },
          lastname() {
            return this.profileSrc.lastname1 + ' ' + this.profileSrc.lastname2
          },
          licenseYear() {
            return moment(this.profileSrc.license_year).format('YYYY');
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
          }
        },
        created() {
          moment.locale('es');
          this.fetchProfile();
          this.fetchExperiences();
          this.fetchEspecialties();
        }
    }
</script>
<style type="text/css">
</style>