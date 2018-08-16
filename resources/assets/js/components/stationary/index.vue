<template>
  <div id="orders" class="fx pv-20" v-if="pageReady">
    <template>
      <div class="fx fx-w-100 jf-around">
        <div class="fx fx-75 fx-col">  
          <div class="fx fx-col">
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
        </div>
      </div>
    </template>
  </div>
</template>

<script>
    export default {
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              modelsNeeded: ['clinics','providers','stationaries'],
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
          'models.clinics.itemSelected'() {
            this.$store.commit('ShoppingCart/cleanShoppingCart');
          }
        },
        computed: {
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
        },
        methods: {
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
            axios.post('/stationary')
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
          this.$store.dispatch('Model/fetchModels',this.modelsNeeded);
        },
        mounted() {
        },
    }
</script>
<style type="text/css">
</style>