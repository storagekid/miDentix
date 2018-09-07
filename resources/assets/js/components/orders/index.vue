<template>
  <div id="orders" class="fx pv-20" v-if="$store.getters.ready">
    <template>
      <div class="fx fx-w-100 jf-around mr-10">
        <div class="fx fx-100 fx-col fx-align-center"> 
          <div class="panel panel-default">
              <div class="panel-heading text-center">
                <h3 class="panel-title">Pedidos</h3>
              </div>
              <div class="panel-body fx fx-col">
                <vue-table 
                  v-if="models[model].items" 
                  :model="model"
                  mode="vuex"
                  >
                </vue-table>
              </div>
            </div>
        </div>  
        <div class="fx fx-col"> 
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
              modelsNeeded: ['orders'],
              downloading: true,
              selectedClinic: null,
              model: 'orders',
              //Table
              footer: {
                totalRows: 0,
              },
            }
        },
        watch: {
          scopeKey() {
            console.log('Scope Key Changed!!!!');
            this.$store.dispatch('Model/fetchFilteredModels', {models: {'orders':{}}, refresh: true, scoped: true});
          }
        },
        computed: {
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
        },
        methods: {
          getFiles(id,e) {
            let classes = Vue.buttonLoaderOnEvent(e);
            axios({
              url: '/stationary/download',
              method: 'GET',
              params: {
                id: id,
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
            });;
          },
        },
        created() {
          if (this.$store.getters['Scope/ready']) {
            this.$store.dispatch('Model/fetchFilteredModels', {models: {'orders':{}}, scoped: true});
          }
        },
        mounted() {
        },
    }
</script>
<style type="text/css">
</style>