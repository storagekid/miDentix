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
                  <div class="alert alert-info" v-if="tabSelected">
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
                    :tutorial="true"
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
                      :clickable="true"
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
              profileSrc: {
                masters: [],
                courses: [],
              },
              profileOriginal: {},
              tabs: {
                '1': {
                  name: '1',
                  icon: 'glyphicon glyphicon-lock',
                  header: 'Paso 1:<br>Seguridad',
                  text: 'Por favor, cambia la contraseña temporal.<br>La nueva contraseña debe ser de al menos 8 caracteres y contener una mayúscula, una mnúscula y un número.',
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
                  text: 'Añade las clínicas en las que trabajas, y gestiona tu tiempo.',
                  completed: false,
                },
              },
              forward: {
                ButtonText: this.tabSelected == 4 ? 'Terminar' : 'Siguiente',
                ButtonIcon: 'glyphicon glyphicon-chevron-right',
              },
              tabSelected: null,
              tutorial_completed: false,
            }
        },
        watch: {
          tabSelected() {
            if (this.tabSelected == '4') {
                if (this.profileSrc.clinicsCount) {
                  this.completePhase(4);
                }
              this.forward.ButtonText = 'Terminar';
              this.forward.ButtonIcon = 'glyphicon glyphicon-ok';
            }
          }
        },
        methods: {
          finisTutorial() {
            this.tutorial_completed = true;
            this.updateProfileTutorial(0);
          },
          moveForward() {
            if (this.tabSelected == 4) {
              return this.finisTutorial();
            }
            this.updateProfileTutorial(this.tabSelected+1);
          },
          completePhase(number) {
            // console.log('Completed!!!');
            this.tabs[this.tabSelected].completed = true;
          },
          notifyNoErrors() {
            this.tabs[this.tabSelected].completed = true;
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
          updateProfileTutorial(phase) {
            // console.log("Updating to: "+phase);
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
                        message: 'Paso ' +parseInt(this.tabSelected)+ ' terminado.', 
                        label: 'success'
                    });
                    if (this.tutorial_completed) {
                      flash({
                          message: 'Muchas gracias, ya puedes empezar a usar la plataforma.', 
                          label: 'success'
                      });
                      setTimeout(function() {window.location.href = '/home'}, 3000);
                    } else {
                      this.fetchProfile();
                    }
                  }
              });
          },
          fetchProfile() {
            axios.get('/api/profile')
              .then(data => {
                this.profileSrc = data.data;
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