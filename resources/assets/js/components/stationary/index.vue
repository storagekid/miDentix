<template>
  <div id="stationery">
    <div class="">
      <div class="fx fx-w-100 jf-around">
        <div class="fx fx-75 fx-col">  
          <div class="panel panel-default">
            <div class="panel-heading text-center" v-if="admin">
              <h3 class="panel-title">Papelería</h3>
            </div>
            <div class="panel-body" v-if="!loading">
              <form action="" style="padding:10px">
                  <div class="form-group">
                    <label for="clinicId"><h4>Selecciona una clínica</h4></label>
                    <select class="form-control" name="clinic" id="clnic-selector" v-model="models.clinics.idSelected" @change="selectModel('clinics',models.clinics.idSelected)">
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
                    <label for="clinicId"><h4>Haz un pedido</h4></label>
                    <div class="fx fx-width-100 jf-between">
                      <div class="fx fx-100 jf-around">
                        <div class="form-group mr-10">
                          <button
                            class="btn"
                            :class="{'btn-success': shoppingCart.includes(stationary.pivot.id)}"
                            v-for="(stationary, index) in models.clinics.itemSelected.stationaries"
                            :key="index"
                            v-text="stationary.description"
                            @click.prevent="shoppingCartToggle(stationary.pivot.id)"
                            >
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
              </form> 
            </div>
          </div>
          <div v-if="modelsReady">
            <div class="panel panel-default" v-if="models.clinics.idSelected">
              <div class="panel-heading text-center">
                <h3 class="panel-title">Materiales</h3>
              </div>
              <div class="panel-body">
                <form action="" style="padding:10px">
                  <div class="form-group fx fx-width-100 fx-col">
                    <label for="clinicId"><h4>Descarga</h4></label>
                    <div class="fx fx-width-100 jf-between">
                      <div class="fx fx-100 jf-around">
                        <button 
                          class="btn btn-info"
                          v-for="(stationary, index) in models.clinics.itemSelected.stationaries"
                          :key="index"
                          v-text="stationary.description"
                          @click.prevent="getFiles(stationary.pivot.id, $event)"
                          >
                        </button>
                      </div>
                      <div class="fx fx-50 jf-end">
                        <button 
                          class="btn btn-primary"
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
        <div class="fx fx-col">  
          <div class="panel panel-default" v-if="shoppingCart.length">
            <div class="panel-heading text-center" v-if="admin">
              <h3 class="panel-title">Pedido</h3>
            </div>
            <div class="panel-body" v-show="!loading">
              <div id="filterColumn">
                <h3>{{ models.clinics.itemSelected.city}} </h3>
                <h6>{{ models.clinics.itemSelected.address_real_1 }}</h6>
                <hr>
                <ul>
                  <li
                    v-for="(item, index) in stationariesSelected"
                    :key="index"
                    >
                    {{ item.description }}
                  </li>
                </ul>
                <hr>
                <div class="form-group">
                  <button
                    class="btn btn-primary"
                    @click="setOrder"
                    >
                    Hacer Pedido
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading text-center" v-if="admin">
              <h3 class="panel-title">Admin Tools</h3>
            </div>
            <div class="panel-body" v-show="!loading">
              <form action="" style="padding:10px" class="mb-10">
                  <div class="form-group m-0">
                    <button class="btn btn-primary btn-block" @click.prevent="regenerateStationary">Regenerar Materiales</button>
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
    </div>
  </div>
</template>

<script>
    import * as moment from 'moment';
    import model from '../../mixins/model.js';
    import 'moment/locale/es';
    export default {
        components: {},
        mixins: [model],
        props: ['admin'],
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              loading: true,
              downloading: true,
              selectedClinic: null,
              shoppingCart: [],
            }
        },
        watch: {
          'models.clinics.itemSelected'() {
            this.shoppingCart = [];
          }
        },
        computed: {
          stationariesSelected() {
            let vm = this;
            let selected = this.models.clinics.itemSelected.stationaries.filter(function(item) {
              if (vm.shoppingCart.includes(item.pivot.id)) {
                return item;
              }
            });
            return selected;
          },
          patata() {
            return 2+2;
          }
        },
        methods: {
          // fetchModel() {
          //   axios.get('/api/'+this.model.name)
          //     .then(data => {
          //       if (data.data.model) {
          //         this.model.items = data.data.model;
          //         this.loading = false;
          //         window.events.$emit('loaded');
          //       }
          //     });
          // },
          shoppingCartToggle(id) {
            if (this.shoppingCart.includes(id)) {
              this.shoppingCart.splice(this.shoppingCart.indexOf(id),1);
            } else {
              this.shoppingCart.push(id);
            }
          },
          setOrder() {
            axios.post('/order/'+this.models.clinics.itemSelected.id, {items: this.shoppingCart})
              .then((response) => {
                this.selectModel(null);
                flash({
                    message: 'Pedido enviado. Muchas gracias', 
                    label: 'success'
                });
              }).catch((error) => {
                flash({
                    message: error.response.data, 
                    label: 'danger'
                });
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
              console.log(name);
              const url = window.URL.createObjectURL(new Blob([response.data]));
              const link = document.createElement('a');
              link.href = url;
              link.setAttribute('download', name); //or any other extension
              document.body.appendChild(link);
              link.click();
            }).then((response) => {
              Vue.buttonLoaderRemove(e, classes);
            });
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
              console.log(name);
              const url = window.URL.createObjectURL(new Blob([response.data]));
              const link = document.createElement('a');
              link.href = url;
              link.setAttribute('download', name); //or any other extension
              document.body.appendChild(link);
              link.click();
              Vue.buttonLoaderRemove(e, classes);
            });
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
              console.log(name);
              const url = window.URL.createObjectURL(new Blob([response.data]));
              const link = document.createElement('a');
              link.href = url;
              link.setAttribute('download', name); //or any other extension
              document.body.appendChild(link);
              link.click();
              Vue.buttonLoaderRemove(e, classes);
            });
          },
          regenerateStationary(e) {
            let classes = Vue.buttonLoaderOnEvent(e);
            axios.post('/stationary')
            .then((response) => {
              Vue.buttonLoaderRemove(e, classes);
            });
          }
        },
        created() {
          window.events.$emit('loading')
          this.fetchModels(['clinics','provincias']);
        },
        mounted() {
          moment.locale('es');
          // this.fetchModel();
        }
    }
</script>
<style type="text/css">
</style>