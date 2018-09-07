<template>
  <div id="stationary" class="fx pv-20" v-if="pageReady && $store.state.Model.models.clinics">
    <template>
      <div class="fx fx-w-100 jf-around">
        <div class="fx fx-100 fx-col ph-10">  
          <div class="fx fx-col">
            <stationary-products></stationary-products>
            <div class="panel panel-default fx-100">
              <div class="panel-heading text-center">
                <h3 class="panel-title">Papelería</h3>
              </div>
              <div class="panel-body">
                <vue-table 
                  v-if="models[model].items" 
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
                    <button class="btn btn-primary btn-block" @click.prevent="regenerateStationary">Regenerar Materiales</button>
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
  </div>
</template>

<script>
  import StationaryProducts from './stationary-products';
    export default {
      components: {StationaryProducts},
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              modelsNeeded: ['providers','stationaries'],
              downloading: true,
              selectedClinic: null,
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
          pageReady() {
            for (let model of this.modelsNeeded) {
              if (!this.$store.state.Model.models[model]) {
                return false;
              }
            }
            return true;
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
          regenerateStationary(e) {
            let classes = Vue.buttonLoaderOnEvent(e);
            axios.post('/stationary/regen', {force:true})
            .then((response) => {
              Vue.buttonLoaderRemove(e, classes);
            });
          },
          completeStationary(e) {
            let classes = Vue.buttonLoaderOnEvent(e);
            axios.post('/stationary/complete')
            .then((response) => {
              Vue.buttonLoaderRemove(e, classes);
            });
          }
        },
        created() {
          this.$store.dispatch('Model/fetchModels', {models: this.modelsNeeded});
        },
        mounted() {
        },
    }
</script>
<style type="text/css">
</style>