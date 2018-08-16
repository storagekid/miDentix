<template>
  <div id="medical-chart" class="fx pv-20" v-if="pageReady">
    <template>
      <div class="fx fx-w-100 jf-around mr-10">
        <div class="fx fx-100 fx-col fx-align-center">  
          <div class="">
            <div class="panel-heading text-center">
              <h3 class="panel-title">Hacer Pedido</h3>
            </div>
            <div class="panel-body">
              <form action="" style="padding:10px">
                  <div class="form-group">
                    <label for="clinicId"><h4>Selecciona una clínica</h4></label>
                    <select class="form-control" name="clinic" id="clnic-selector" v-model="models.clinics.idSelected" @change="$store.commit('Model/selectModel',{model:'clinics',id:models.clinics.idSelected})">
                        <option 
                            value="null"
                            v-text="'-'"
                            >
                        </option>
                        <option 
                            :value="clinic.id"
                            v-for="(clinic, index) in models.clinics.items"
                            :key="index"
                            v-text="clinic.fullName"
                            :selected="models.clinics.idSelected === clinic.id"
                            >
                        </option>
                    </select>
                  </div>
                  <div class="form-group fx fx-width-100 fx-col" v-if="models.clinics.itemSelected">
                    <label for="clinicId"><h4>Materiales Personalizados</h4></label>
                    <div class="fx fx-width-100 jf-between">
                      <div class="fx fx-100 jf-around">
                        <div class="form-group mr-10-all mb-10-all">
                          <button
                            class="btn selectable"
                            :class="{'selected': shoppingCart.includes(worker.id)}"
                            v-for="(worker, index) in models.clinics.itemSelected.workers"
                            :key="index"
                            @click.prevent="shoppingCartToggle(worker.id)"
                            >
                            <img :src="worker.pivot.thumbnail" alt="">
                            <p>{{worker.description}}</p>
                          </button>
                        </div>
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
    export default {
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              modelsNeeded: ['clinics','workers'],
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
          'models.clinics.itemSelected'() {
            this.$store.commit('ShoppingCart/cleanShoppingCart');
          }
        },
        computed: {
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
          shoppingCartToggle(id) {
            this.$store.commit('ShoppingCart/shoppingCartToggle', {item: id});
          },
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
          this.$store.dispatch('Model/fetchModels',this.modelsNeeded);
        },
        mounted() {
        },
    }
</script>
<style type="text/css">
</style>