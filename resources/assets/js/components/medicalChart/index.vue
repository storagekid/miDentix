<template>
  <div @keyup.esc="closePlayer" tabindex="0" id="medical-chart" class="fx pv-20" v-if="pageReady">
    <medical-chart-player v-if="player" :license="licenseSwitch"></medical-chart-player>
    <template>
      <div class="fx fx-w-100 jf-around mr-10">
        <div class="fx fx-100 fx-col fx-align-center">  
          <div class="panel panel-default">
            <div class="panel-heading text-center">
              <h3 class="panel-title">Directorio Médico</h3>
            </div>
            <div class="panel-body">
              <form action="" style="padding:10px">
                  <div class="form-group" v-if="$store.state.Scope.clinics.selected && shoppingCart.medicalCharts">
                    <label><h4>Añadir tiras al pedido</h4></label>
                    <div class="">
                      <div class="">
                        <div class="fx fx-100 fx-wrap mr-10-all mb-10-all">
                          <div
                            class="group-container"
                            v-for="(jobType, index) in models.job_types.items"
                            v-if="jobInClinic(jobType.id)"
                            :key="index"
                            >
                            <div
                              class="fx fx-col"
                              >
                              <button
                                class="btn selectable-rev medical-chart-header"
                                :class="{'selected': shoppingCart.medicalChartJobs.ids.includes(jobType.id)}"
                                @click.prevent="shoppingCartToggle(jobType.id, 'medicalChartJobs')"
                                >
                                  <h4>{{jobType.name}}</h4>
                              </button>
                              <button
                              class="btn selectable-rev personal-chart fx jf-between fx-align-center"
                              :class="{'selected': shoppingCart.medicalCharts.ids.includes(profile.id), 'fx-col': !shoppingCart.medicalCharts.ids.includes(profile.id)}"
                              v-for="(profile, index) in models.profiles.items"
                              v-if="profile.job_type_id == jobType.id"
                              :key="index"
                              >
                                <i class="glyphicon glyphicon-minus-sign fx jf-around fx-align-center" 
                                  v-if="shoppingCart.medicalCharts.ids.includes(profile.id)"
                                  @click.prevent="shoppingCartRemove(profile.id, 'medicalCharts')"
                                ></i>
                                <h4
                                  :disabled="shoppingCart.medicalCharts.ids.includes(profile.id)"
                                  @click.prevent="shoppingCartToggle(profile.id, 'medicalCharts')"
                                >{{profile.name + ' ' + profile.lastname1}}
                                  <i class="chart-counter" v-if="shoppingCart.medicalCharts.ids.includes(profile.id)"> {{ chartCounter(profile.id) }} </i>
                                </h4>
                                <i class="glyphicon glyphicon-plus-sign fx jf-around fx-align-center" 
                                  v-if="shoppingCart.medicalCharts.ids.includes(profile.id)"
                                  @click.prevent="shoppingCartAdd(profile.id, 'medicalCharts')"
                                ></i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </form> 
            </div>
          </div>
        </div>  
        <div class="fx fx-col"> 
          <div>
            <div class="panel panel-default" v-if="models.profiles">
              <div class="panel-heading text-center">
                <h3 class="panel-title">Acciones</h3>
              </div>
              <div class="panel-body btrans5">
                <form action="" style="padding:10px" v-if="models.profiles.items">
                  <div class="fx fx-width-100 fx-col">
                    <div class="fx fx-width-100 jf-between fx-col mb-10">
                      <div class="fx fx-100 jf-around fx-col mb-10">
                        <button 
                          class="btn btn-info"
                          v-text="'Seleccionar Todo'"
                          :disabled="(shoppingCart.medicalCharts.ids.length + shoppingCart.medicalChartJobs.ids.length) == (medicalStaff.length + clinicJobs.length)"
                          @click.prevent="selectAll(true, true)"
                          >
                        </button>
                        <button 
                          class="btn btn-info"
                          v-text="'Todos los Nombres'"
                          :disabled="shoppingCart.medicalCharts.ids.length == medicalStaff.length"
                          @click.prevent="selectAll(true, false)"
                          >
                        </button>
                        <button 
                          class="btn btn-info"
                          v-text="'Todas las Especialidades'"
                          :disabled="shoppingCart.medicalChartJobs.ids.length == clinicJobs.length"
                          @click.prevent="selectAll(false, true)"
                          >
                        </button>
                        <button 
                          class="btn btn-info"
                          v-text="'Borrar Selección'"
                          :disabled="!(shoppingCart.medicalCharts.ids.length + shoppingCart.medicalChartJobs.ids.length)"
                          @click.prevent="$store.commit('ShoppingCart/cleanShoppingCart', {categories:['medicalCharts', 'medicalChartJobs']})"
                          >
                        </button>
                        <button 
                          class="btn btn-info"
                          v-text="'Descargar'"
                          :disabled="!(shoppingCart.medicalCharts.ids.length + shoppingCart.medicalChartJobs.ids.length)"
                          @click.prevent="downloadCharts($event)"
                          >
                        </button>
                      </div>
                    </div>
                  </div>
                </form> 
              </div>
            </div>
            <div class="panel panel-default" v-if="models.profiles">
              <div class="panel-heading text-center">
                <h3 class="panel-title">Proyector</h3>
              </div>
              <div class="panel-body btrans5">
                <form action="" style="padding:10px" v-if="models.profiles.items">
                  <div class="fx fx-width-100 fx-col">
                    <div class="fx fx-width-100 jf-between fx-col mb-10">
                      <div class="fx fx-100 jf-around fx-col mb-10">
                        <form action="" class="form">
                          <h6>Mostrar Nº de Licencia</h6>
                          <div class="form-group">
                            <input type="checkbox" v-model="licenseSwitch">
                          </div>
                        </form>
                        <button 
                          class="btn btn-info"
                          v-text="'Lanzar Proyector'"
                          @click.prevent="player = true"
                          >
                        </button>
                      </div>
                    </div>
                  </div>
                </form> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
import medicalChartPlayer from './medical-chart-player';
export default {
  components: {medicalChartPlayer},
    data() {
        return {
          csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          modelsNeeded: ['jobs','job_types'],
          // profilesSelected: [],
          downloading: true,
          selectedClinic: null,
          model: 'profiles',
          medicalJobIds: [1,2,4,6,8],
          medicalJobTypesIds: [1,2,4,6,7,9,11,12],
          screenWidth : window.innerWidth,
          screenHeight : window.innerHeight,
          licenseSwitch: false,
          player: false,
          //Table
          footer: {
            totalRows: 0,
          },
        }
    },
    watch: {
      scopeKey() {
        // console.log('Scope Key Changed!!!!');
        this.$store.dispatch('Model/fetchFilteredModels', {models: {'profiles':{}}, refresh: true, scoped: true});
      }
    },
    computed: {
      playerPages() {
        return Math.ceil(((this.clinicJobs.length + this.medicalStaff.length) * 100) / this.screenHeight);
      },
      playerRows() {
        return this.clinicJobs.length + this.medicalStaff.length;
      },
      scopeKey() {
        return this.$store.state.Scope.scopeKey;
      },
      shoppingCart() {
        return this.$store.state.ShoppingCart.shoppingCart;
      },
      pageReady() {
        for (let model of this.modelsNeeded) {
          if (!this.$store.state.Model.models[model]) {
            return false;
          }
        }
        return true;
      },
      models() {
        return this.$store.state.Model.models;
      },
      clinicJobs() {
        let items = [];
        for (let profile of this.models.profiles.items) {
          if (this.medicalJobTypesIds.includes(profile.job_type_id)) {
            if (!items.includes(profile.job_type_id)) {
              items.push(profile.job_type_id);
            }
          }
        }
        return items;
      },
      medicalStaff() {
        // let vm = this;
        // return this.models.profiles.items.filter((profile) => this.medicalJobIds.include(profile.job_id));
        let items = [];
        for (let profile of this.models.profiles.items) {
          if (this.medicalJobIds.includes(profile.job_id)) {
            items.push(profile);
          }
        }
        return items;
      }
    },
    methods: {
      chartCounter (id) {
        return this.shoppingCart.medicalCharts.ids.filter(profile => profile === id).length
      },
      closePlayer() {
        // console.log("closing player");
        this.player = false;
      },
      jobInClinic(id) {
        if (this.$store.state.Model.models.profiles) {
          if (this.$store.state.Model.models.profiles.items) {
            for (let profile of this.$store.state.Model.models.profiles.items) {
              if (profile.job_type_id == id && this.medicalJobTypesIds.includes(id)) {
                return true;
              }
            }
          }
        }
  
        return false;
      },
      cleanShoppingCart() {
        this.$store.commit('ShoppingCart/cleanShoppingCart', {categories:['medicalCharts', 'medicalChartJobs']});
      },
      shoppingCartToggle(id, category) {
        if (!this.shoppingCart.medicalCharts.ids.includes(id)) {
          this.$store.commit('ShoppingCart/shoppingCartAdd', {item: id, 'category': category});
        }
        // this.$store.commit('ShoppingCart/shoppingCartToggle', {item: id, 'category': category});
      },
      shoppingCartAdd(id, category) {
        this.$store.commit('ShoppingCart/shoppingCartAdd', {item: id, 'category': category});
      },
      shoppingCartRemove(id, category) {
        this.$store.commit('ShoppingCart/shoppingCartRemove', {item: id, 'category': category});
      },
      selectAll(names=false, jobs=false) {
        if (names) {
          for (let profile of this.medicalStaff) {
            if (!this.shoppingCart.medicalCharts.ids.includes(profile.id)) {
              this.$store.commit('ShoppingCart/shoppingCartToggle', {item: profile.id, 'category': 'medicalCharts'});
            }
          }
        }
        if (jobs) {
          for (let job of this.clinicJobs) {
            if (!this.shoppingCart.medicalChartJobs.ids.includes(job)) {
              this.$store.commit('ShoppingCart/shoppingCartToggle', {item: job, 'category': 'medicalChartJobs'});
            }
          }
        }
      },
      toggleProfile(id) {
        this.profilesSelected.includes(id) ? this.profilesSelected.splice(this.profilesSelected.indexOf(id), 1) : this.profilesSelected.push(id);
      },
      fetchProfiles(clinic) {
        this.profilesSelected = [];
        this.$store.dispatch('Model/fetchModels', {models: ['profiles'], ids: [clinic], groupBy:'job_type_id', refresh:true});
        // this.$store.commit('Model/selectModel',{model:'clinics',id:clinic})
      },
      downloadCharts(e) {
        let classes = Vue.buttonLoaderOnEvent(e);
        if (this.shoppingCart.medicalCharts) {
          if (this.shoppingCart.medicalCharts.ids.length) {
            axios({
              url: '/profiles/download-charts',
              method: 'GET',
              params: {
                profiles: this.shoppingCart.medicalCharts.ids,
                clinic: this.$store.state.Scope.clinics.selected,
                license: this.licenseSwitch,
              },
              responseType: 'blob', // important
            }).then((response) => {
              let headers = response.headers['content-disposition'].split(';');
              let badname = headers[1].split('=');
              let name = badname[1].slice(1,-1);
              const url = window.URL.createObjectURL(new Blob([response.data]));
              const link = document.createElement('a');
              link.href = url;
              link.setAttribute('download', name); //or any other extension
              document.body.appendChild(link);
              link.click();
              flash({
                      // message: error.response.data, 
                      message: 'Descarga completada.', 
                      label: 'success'
                  });
              Vue.buttonLoaderRemove(e, classes);
            }).catch((error) => {
              flash({
                      // message: error.response.data, 
                      message: 'Error en el servidor.<br>Por favor, contacte con el administrador de la plataforma', 
                      label: 'danger'
                  });
              Vue.buttonLoaderRemove(e, classes);
            });
          }
        }
        if (this.shoppingCart.medicalChartJobs) {
          if (this.shoppingCart.medicalChartJobs.ids.length) {
            console.log('JobCharts');
            for (let job of this.shoppingCart.medicalChartJobs.ids) {
              axios({
                url: '/profiles/download-jobcharts',
                method: 'GET',
                params: {
                  'job': job,
                },
                responseType: 'blob', // important
              }).then((response) => {
                let headers = response.headers['content-disposition'].split(';');
                let badname = headers[1].split('=');
                let name = badname[1].slice(1,-1);
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', name); //or any other extension
                document.body.appendChild(link);
                link.click();
                flash({
                        // message: error.response.data, 
                        message: 'Descarga completada.', 
                        label: 'success'
                    });
                Vue.buttonLoaderRemove(e, classes);
              }).catch((error) => {
                flash({
                        // message: error.response.data, 
                        message: 'Error en el servidor.<br>Por favor, contacte con el administrador de la plataforma', 
                        label: 'danger'
                    });
                Vue.buttonLoaderRemove(e, classes);
              });
            }
          }
        }
      },
      getClinic(id, e) {
        let classes = Vue.buttonLoaderOnEvent(e);
        axios({
          url: '/stationary/download/'+id,
          method: 'GET',
          responseType: 'blob', // important
        }).then((response) => {
          let headers = response.headers['content-disposition'].split(';');
          let badname = headers[1].split('=');
          let name = badname[1].slice(1,-1);
          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', name); //or any other extension
          document.body.appendChild(link);
          link.click();
          flash({
                  // message: error.response.data, 
                  message: 'Descarga completada.', 
                  label: 'success'
              });
          Vue.buttonLoaderRemove(e, classes);
        }).catch((error) => {
          flash({
                  // message: error.response.data, 
                  message: 'Error en el servidor.<br>Por favor, contacte con el administrador de la plataforma', 
                  label: 'danger'
              });
          Vue.buttonLoaderRemove(e, classes);
        });
      },
    },
    created() {
      if (this.$store.getters['Scope/ready']) {
        this.$store.dispatch('Model/fetchFilteredModels', {models: {'profiles':{}}, scoped: true});
      }
      this.$store.dispatch('Model/fetchModels',{models: this.modelsNeeded});
      this.$store.commit('ShoppingCart/setCategory', {name:'medicalCharts', model: 'profiles', headerText: 'Tiras de Doctores', itemKey: 'full_name'});
      this.$store.commit('ShoppingCart/setCategory', {name:'medicalChartJobs', model: 'job_types', headerText: 'Tiras de Especialidades', itemKey: 'name'});
    },
    mounted() {
      // document.addEventListener('keydown', this.closePlayer);
    },
}
</script>
<style type="text/css">
  .chart-counter {
      padding: 2px 8px 3px 6px;
      display: inline-block;
      background-color: white;
      font-weight: 900;
      margin-left: 5px;
      color: #753470;
      font-size: 1.3em;
      border-radius: 50%;
  }
</style>