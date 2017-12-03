<template>
    <div id="profile-info-box">
      <div class="panel panel-default panel-tabbed">
        <div class="panel-heading text-center">
          <h3 class="panel-title">
            <ul class="nav nav-tabs">
              <li :class="{'active': tabSelected == key}" v-for="(tab, key) in tabs">
                <a class="tutorial-tab-number">
                  <span>{{tab['name']}}</span> <span :class="tab['icon']"></span>
                </a>
              </li>
            </ul>
          </h3>
        </div>
        <div class="panel-body">
          <div class="tab-content">
            <div 
              role="tabpanel" 
              class="tab-pane active text-center" 
              >
              <div class="row">
                <div class="col-xs-12 col-md-3 tutorial-prompt vcenter">
                  <div class="alert alert-info">
                    <h3 v-html="tabs[tabSelected].header"></h3>
                    <div class="form-group">
                      <p v-html="tabs[tabSelected].text"></p>
                    </div>
                    <div class="form-group">
                      <button 
                        :disabled="!tabs[tabSelected].completed" 
                        type="button" 
                        class="btn btn-primary btn-block" 
                        @click="moveForward()"
                        >
                        <span :class="forward.ButtonIcon"></span>{{forward.ButtonText}}
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 col-md-6 vcenter" v-if="tabSelected == '1'">
                  <pass-changer 
                    :profileSrc="profileSrc"
                    :tutorial="true"
                    @changed="completePhase(1)"
                   >
                  </pass-changer>
                </div>
                <div class="col-xs-12 col-md-9 vcenter" v-if="tabSelected == '2'">
                  <profile-form
                    :profileSrc="profileSrc"
                    :profileOriginal="profileOriginal"
                    @updated="completePhase(2)"
                    @noErrors="notifyNoErrors"
                    >
                  </profile-form>
                </div>
                <div class="col-xs-12 col-md-9 vcenter" v-if="tabSelected == '3'">
                  <masters 
                    v-if="tabSelected == '3'"
                    :updateMethod="true"
                    >
                  </masters>
                </div>
                <div id="tutorial-schedule" class="col-xs-12 col-md-9 vcenter" v-if="tabSelected == '4'">
                    <schedule
                      :page="'tutorial'"
                      @completed="completePhase(4)"
                      >
                    </schedule>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="panel-footer">
            <div id="profile-info-footer">
              <h3>
              </h3>
              <button 
                >
              </button>
            </div>
          </div> -->
        </div>
      </div>
    </div>
</template>

<script>
    export default {
        components: {},
        props: [],
        data() {
            return {
              profileSrc: {},
              profileOriginal: {},
              tabs: {
                '1': {
                  name: '1',
                  icon: 'glyphicon glyphicon-lock',
                  header: 'Paso 1:<br>Seguridad',
                  text: 'Por favor, cambia la contraseña temporal.<br>Debe contener al menos una mayúscula, una mnúscula, un número y un símbolo ("#","$","%","&"...)',
                  completed: false,
                },
                '2': {
                  name: '2',
                  icon: 'glyphicon glyphicon-user',
                  header: 'Paso 2:<br>Tus datos',
                  text: 'Comprueba que los datos que tenemos son correctos y completa los campos vacios.',
                  completed: false,
                },
                '3': {
                  name: '3',
                  icon: 'glyphicon glyphicon-education',
                  header: 'Paso 3:<br>Formación',
                  text: 'Dinos qué masters has realizado.<br>Si no has hecho ningún master o no aparece en la lista puedes avanzar al siguiente paso.',
                  completed: true,
                },
                '4': {
                  name: '4',
                  icon: 'glyphicon glyphicon-home',
                  header: 'Paso 4:<br>Clínicas',
                  text: 'Añade las clínicas en las que trabajas, y...',
                  completed: false,
                },
              },
              forward: {
                ButtonText: this.tabSelected == 4 ? 'Terminar' : 'Siguiente',
                ButtonIcon: 'glyphicon glyphicon-chevron-right',
              },
              tabSelected: '1',
            }
        },
        watch: {
          tabSelected() {
            if (this.tabSelected == '4') {
              this.forward.ButtonText = 'Terminar';
              this.forward.ButtonIcon = 'glyphicon glyphicon-ok';
            }
          }
        },
        methods: {
          finisTutorial() {
            this.updateProfileTutorial(0);
            window.location.href = '/home';
          },
          moveForward() {
            if (this.tabSelected == 4) {
              return this.finisTutorial();
            }
            this.tabSelected++;
            this.updateProfileTutorial(this.tabSelected);
          },
          completePhase(number) {
            if (this.tabSelected == 2) {
              flash({
                  message: 'Perfil actualizado', 
                  label: 'success'
              });
              this.fetchProfile();
            }
            console.log('Completed!!!');
            this.tabs[this.tabSelected].completed = true;
            // this.tabSelected = number + 1;
          },
          notifyNoErrors() {
            this.tabs[this.tabSelected].completed = true;
          },
          toggleTab(tab) {
            if (this.tabSelected == tab) {
              console.log('Equal');
              return;
            }
            if (this.profileSrc.tutorial_completed > tab) {
              flash({
                   message:'Ya has completado este paso.', 
                   label:'warning'
               });
              return false;
            }
            if (!this.checkSteps()) {
              console.log('Check');
              return false;
            }
            this.tabSelected = tab;
            if (tab == 'pass') {

            } else if (tab == 'info') {

            } else if (tab == 'masters') {

            } else if (tab == 'clinics') {

            }
          },
          checkSteps() {

            if (!this.tabs['1'].completed) {
              flash({
                   message:'Debes cambiar la contraseña antes de poder avanzar.', 
                   label:'warning'
               });
              return false;
            }
            return true;
          },
          tabCompletion() {
            let userPhase = this.profileSrc.tutorial_completed;
            for (let tab in this.tabs) {
              if (userPhase > tab) {
                this.tabs[tab].completed = true;
              }
            }
          },
          updateProfileTutorial(phase) {
            axios.patch('/tutorial/'+this.profileSrc.id, {
              'tutorial_completed': phase,
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
                        message: 'Paso ' +parseInt((phase-1))+ ' terminado.', 
                        label: 'success'
                    });
                  }
              });
          },
          fetchProfile() {
            axios.get('/api/profile')
              .then(data => {
                this.profileSrc = data.data;
                this.tabCompletion();
                this.tabSelected = this.profileSrc.tutorial_completed;
                this.copyProfile();
              });
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
          this.fetchProfile();
        }
    }
</script>
<style type="text/css">
</style>