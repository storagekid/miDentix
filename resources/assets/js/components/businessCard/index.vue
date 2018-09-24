<template>
  <div id="business-card" class="fx pv-20" v-if="pageReady">
    <template>
      <div class="fx fx-w-100 jf-around mr-10">
        <div class="fx fx-100 fx-col fx-align-center">  
          <div class="panel panel-default">
            <div class="panel-heading text-center">
              <h3 class="panel-title">Tarjetas de visita</h3>
            </div>
            <div class="panel-body">
              <form action="" style="padding:10px">
                  <div class="form-group" v-if="models.profiles && shoppingCart.businessCards">
                    <label><h4>Añadir tarjetas al pedido</h4></label>
                    <div class="fx fx-width-75 fx-center">
                      <div class="fx fx-100 jf-around">
                        <div class="form-group mr-10-all mb-10-all">
                          <button
                            class="btn selectable-rev business-card"
                            :class="{'selected': shoppingCart.businessCards.ids.includes(card.id)}"
                            v-for="(card, index) in models.profiles.items"
                            v-if="mangementJobTypesIds.includes(card.job_type_id)"
                            :key="index"
                            @click.prevent="shoppingCartToggle(card.id, 'businessCards')"
                            >
                            <h4>{{card.name + ' ' + card.lastname1}}</h4>
                            <p>{{card.job_type_name}}</p>
                            <div class="clinic-info">
                              <p>{{clinicSelected.address_real_1}}, {{clinicSelected.postal_code}} {{clinicSelected.city}}</p>
                              <p>{{clinicSelected.phone_real}}</p>
                              <p>{{card.job_type_name}}@dentix.es</p>
                            </div>
                            <p>www.dentix.com</p>
                          </button>
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
            <div class="panel panel-default">
              <div class="panel-heading text-center">
                <h3 class="panel-title">Admin Tools</h3>
              </div>
              <div class="panel-body btrans5">
                <form action="" style="padding:10px">
                  <div class="fx fx-width-100 fx-col">
                    <div class="fx fx-width-100 jf-between fx-col mb-10">
                      <div class="fx fx-100 jf-around fx-col mb-10">
                        <button 
                          class="btn btn-info"
                          v-text="'Regenerar Datos'"
                          :disabled="!$store.state.Scope.clinics.ids.length"
                          @click.prevent="fetchProfiles($store.state.Scope.clinics.ids)"
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
                          :disabled="shoppingCart.businessCards.ids.length == mangementStaff.length"
                          @click.prevent="selectAll()"
                          >
                        </button>
                        <button 
                          class="btn btn-info"
                          v-text="'Borrar Selección'"
                          :disabled="!shoppingCart.businessCards.ids.length"
                          @click.prevent="$store.commit('ShoppingCart/cleanShoppingCart', {categories:['businessCards']})"
                          >
                        </button>
                        <button 
                          class="btn btn-info"
                          v-text="'Descargar'"
                          :disabled="!shoppingCart.businessCards.ids.length"
                          @click.prevent="downloadBusinessCards($event)"
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
    export default {
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              modelsNeeded: [],
              downloading: true,
              selectedClinic: null,
              model: 'profiles',
              mangementJobIds: [5,7],
              mangementJobTypesIds: [5,8],
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
          clinicSelected() {
            return this.$store.state.Model.models['clinics'].items.find(item => item.id == this.$store.state.Model.models.clinics.itemSelected);
          },
          mangementStaff() {
            // let vm = this;
            // return this.models.profiles.items.filter((profile) => this.medicalJobIds.include(profile.job_id));
            let items = [];
            for (let profile of this.models.profiles.items) {
              if (this.mangementJobTypesIds.includes(profile.job_type_id)) {
                items.push(profile);
              }
            }
            return items;
          }
        },
        methods: {
          cleanShoppingCart() {
            this.$store.commit('ShoppingCart/cleanShoppingCart', {categories:['businessCards']});
          },
          shoppingCartToggle(id, category) {
            this.$store.commit('ShoppingCart/shoppingCartToggle', {item: id, 'category': category});
          },
          selectAll() {
            for (let profile of this.mangementStaff) {
              if (!this.shoppingCart.businessCards.ids.includes(profile.id)) {
                this.$store.commit('ShoppingCart/shoppingCartToggle', {item: profile.id, 'category': 'businessCards'});
              }
            }
          },
          fetchProfiles(clinic) {
            let clinics = [];
            if (!Array.isArray(clinic)) {
              clinics.push(clinic);
            } else {
              clinics = clinic;
            }
            this.$store.dispatch('Model/fetchModels', {models: ['profiles'], ids: clinics, groupBy:'job_type_id', refresh:true});
          },
          downloadBusinessCards(e) {
            let classes = Vue.buttonLoaderOnEvent(e);
            if (this.shoppingCart.businessCards) {
              if (this.shoppingCart.businessCards.ids.length) {
                for (let card of this.shoppingCart.businessCards.ids) {
                  axios({
                    url: '/profiles/download-business-cards',
                    method: 'GET',
                    params: {
                      profile: card,
                      clinic: this.$store.state.Scope.clinics.selected,
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
                            // message: error.response.data.message, 
                            label: 'danger'
                        });
                    Vue.buttonLoaderRemove(e, classes);
                  });
                }
              }
            }
          },
        },
        created() {
          if (this.$store.getters['Scope/ready']) {
            this.$store.dispatch('Model/fetchFilteredModels', {models: {'profiles':{}}, refresh: true, scoped: true});
          }
          this.$store.commit('ShoppingCart/setCategory', {name:'businessCards', model: 'profiles', headerText: 'Tarjetas de Visita', itemKey: 'full_name'});
        },
        mounted() {
        },
    }
</script>
<style type="text/css">
</style>