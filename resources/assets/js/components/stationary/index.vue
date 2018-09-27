<template>
  <page :name="model" :models="modelsNeeded" :tables="tablesNeeded">
    <template slot="page-content">
      <div class="fx fx-w-100 jf-around">
        <div class="fx fx-100 fx-col ph-10">  
          <div class="fx fx-col">
            <stationary-products v-if="$store.state.Model.models.clinics.itemSelected"></stationary-products>
            <div class="panel panel-default fx-100">
              <div class="panel-heading text-center">
                <h3 class="panel-title">Papelería</h3>
              </div>
              <div class="panel-body">
                <vue-table 
                  v-if="tableItems"
                  :model="model"
                  mode="vuex"
                  >
                </vue-table>
              </div>
            </div>
          </div>
        </div>  
        <div class="fx fx-col"> 
          <div class="panel panel-default">
            <div class="panel-heading text-center">
              <h3 class="panel-title">Admin Tools</h3>
            </div>
            <div class="panel-body">
              <form action="" style="padding:10px" class="mb-10">
                <div class="form-group m-0">
                  <button 
                      class="btn btn-info"
                      v-text="'Regenerar Datos'"
                      :disabled="!$store.state.Scope.clinics.ids.length"
                      @click.prevent="fetchProfiles($store.state.Scope.clinics.ids)"
                      >
                    </button>
                  </div>
                  <div class="form-group m-0">
                    <button class="btn btn-primary btn-block" @click.prevent="completeStationary($event, true)">Regenerar Materiales</button>
                  </div>
                  <div class="form-group m-0">
                    <button class="btn btn-primary btn-block" @click.prevent="completeStationary">Completar Materiales</button>
                  </div>
                  <div class="form-group m-0">
                    <button 
                      class="btn btn-primary btn-block"
                      @click.prevent="getStationary"
                      >
                      Descargar Todo
                    </button>
                  </div>
              </form> 
            </div>
          </div>
          <div class="panel panel-default" v-if="$store.state.Model.models.clinics.itemSelected">
            <div class="panel-heading text-center">
              <h3 class="panel-title">Materiales</h3>
            </div>
            <div class="panel-body btrans5">
              <form action="" style="padding:10px">
                <div class="form-group fx fx-width-100 fx-col">
                  <label for="clinicId"><h4>Descarga</h4></label>
                  <div class="fx fx-width-100 jf-between fx-col mb-10">
                    <div class="fx fx-100 jf-around fx-col mb-10">
                      <button 
                        class="btn btn-info"
                        v-for="(stationary, index) in models.clinics.itemSelected.stationaries"
                        :key="index"
                        v-text="stationary.description"
                        @click.prevent="getFiles(stationary.pivot.id, $event)"
                        >
                      </button>
                    </div>
                    <div class="">
                      <button 
                        class="btn btn-primary btn-block"
                        v-text="'Papelería Completa'"
                        @click.prevent="getClinic(models.clinics.itemSelected.id, $event)"
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
    </template>
  </page>
</template>

<script>
  import StationaryProducts from './stationary-products';
    export default {
      components: {StationaryProducts},
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              modelsNeeded: ['providers','stationaries','clinic_stationaries'],
              tablesNeeded: ['stationaries'],
              model: 'stationaries',
              //Table
              footer: {
                totalRows: 0,
              },
            }
        },
        watch: {
        },
        computed: {
          models() {
            return this.$store.state.Model.models;
          },
          tableItems() {
            if (this.$store.state.Model.models[this.model]) {
              if (this.$store.state.Model.models[this.model].items) {
                return true;
              }
            }
            return false;
          },
        },
        methods: {
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
          getStationary(e) {
            let classes = Vue.buttonLoaderOnEvent(e);
            axios({
              url: '/stationary/download-all',
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
            }).then((response) => {
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
            });;
          },
          completeStationary(e, force=false) {
            let classes = Vue.buttonLoaderOnEvent(e);
            let params = {'force':force};
            if (this.$store.state.Scope.clinics.selected) {
                params['clinic_id'] = this.$store.state.Scope.clinics.selected;
            } else if (this.$store.state.Scope.counties.selected) {
                params['county_id'] = this.$store.state.Scope.counties.selected;
            } else if (this.$store.state.Scope.states.selected) {
                params['state_id'] = this.$store.state.Scope.states.selected;
            } else if (this.$store.state.Scope.countries.selected) {
                params['country_id'] = this.$store.state.Scope.countries.selected;
            } else {
                params['scope'] = false;
            }
            axios({
              url: '/stationary/regen',
              method: 'POST',
              params: params
            })
            .then(({data}) => {
              console.log('Data: ' + data);
              if (data.clinic_stationaries) {
                this.$store.commit('Model/setItemsFetched', {name: 'clinic_stationaries', items: data.clinic_stationaries});
              } else {
                flash({
                  message: data.message, 
                  label: 'success'
                });
              }
              Vue.buttonLoaderRemove(e, classes);
            })
            .catch((error) => {
              flash({
                message: error.response.data.message, 
                label: 'danger'
              });
              Vue.buttonLoaderRemove(e, classes);
            });
          }
        },
        created() {
        },
        mounted() {
        },
    }
</script>
<style type="text/css">
</style>