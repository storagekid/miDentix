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
              <div v-if="tabSelected == 'info'" class="text-center">
                <div class="row">
                  <div class="col-xs-12 col-md-4 vcenter" v-if="!passChange">
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
                  <div class="col-xs-8 col-md-4 vcenter"  v-if="passChange">
                    <pass-changer 
                      :profileSrc="profileSrc"
                      @cancel="toggleChangePass"
                      @changed="toggleChangePass"
                     >
                    </pass-changer>
                  </div>
                  <div class="col-xs-12 col-md-8 vcenter">
                    <profile-form
                      :profileSrc="profileSrc"
                      :profileOriginal="profileOriginal"
                      @updated="notifyUpdated"
                      >
                    </profile-form>
                  </div>
                </div>
              </div>
              <div class="row" v-if="tabSelected == 'masters'">
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                  <masters 
                    :updateMethod="updateButton.method"
                    @added="notifyAdded"
                    @deleted="notifyDeleted"
                    >
                  </masters>
                </div>
              </div>
            </div>
          </div>
          <div class="panel-footer" v-if="!tutorial">
            <div id="profile-info-footer">
              <h3>
                <span class="glyphicon glyphicon-calendar" v-if="updatedDate"></span><span v-if="updatedDate" v-text="updatedDate"></span>
              </h3>
<!--               <button 
                type="button" 
                :class="updateButton.ButtonClasses" 
                @click="editButtonMethod()"
                v-if="showEditButton"
                >
                <span :class="updateButton.ButtonIcon"></span>{{updateButton.ButtonText}}
              </button> -->
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    import masters from '../components/profile/masters.vue';
    // import Password from 'vue-password-strength-meter';
    import * as moment from 'moment';
    import 'moment/locale/es';
    export default {
        components: {masters},
        props: ['tutorial'],
        data() {
            return {
              passChange: false,
              profileOriginal: {},
              profileSrc: {},
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
        },
        methods: {
          toggleChangePass() {
            if (!this.passChange) {
              this.passChange = true;
            } else {
              this.passChange = false;
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
          toggleTab(tab) {
            if (this.tabSelected == tab) {
              return;
            }
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
                this.copyProfile();
              });
          },
          updateDate() {
            if (this.profileSrc.updated_at > this.profileSrc.created_at) {
              this.updatedDate = 'Actualizado el: '+moment(this.profileSrc.updated_at).format('L');
            }
          },
          notifyAdded() {
            flash({
                 message:'Master añadido.', 
                 label:'success'
             });
            this.fetchProfile();
          },
          notifyUpdated() {
            flash({
                message: 'Perfil actualizado', 
                label: 'success'
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
          copyProfile() {
            for (let prop in this.profileSrc) {
              this.profileOriginal[prop] = this.profileSrc[prop];
            }
          }
        },
        computed: {
        },
        created() {
          moment.locale('es');
          this.fetchProfile();
        }
    }
</script>
<style type="text/css">
</style>