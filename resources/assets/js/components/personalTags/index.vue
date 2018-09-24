<template>
  <page :name="model" :models="modelsNeeded">
    <template slot="page-content">
      <div class="fx fx-w-100 jf-around mr-10">
        <div class="fx fx-100 fx-col fx-align-center">  
          <div class="panel panel-default">
            <div class="panel-heading text-center">
              <h3 class="panel-title">Descarga de Identificadores</h3>
            </div>
            <div class="panel-body">
              <div class="fx fx-75 fx-center jf-center" v-if="!models.clinics.itemSelected"> 
                <h3>Por favor, selecciona una clínica en el menú superior para acceder a las descargas</h3>
              </div>
              <form action="" style="padding:10px" v-else>
                  <div class="form-group fx fx-width-100 fx-col">
                    <label for="clinicId"><h4>Selecciona los Identificadores</h4></label>
                    <div class="fx fx-width-75 fx-center">
                      <div class="fx fx-100 jf-around">
                        <div 
                          class="form-group mr-10-all mb-10-all"
                          v-if="tableItems"
                          >
                          <button
                            class="btn selectable-rev personal-tag"
                            :class="{'selected': profilesSelected.includes(tag.id)}"
                            v-for="(tag, index) in models.profiles.items"
                            :key="index"
                            @click.prevent="toggleProfile(tag.id)"
                            >
                            <hr>
                            <h4>{{tag.name + ' ' + tag.lastname1}}</h4>
                            <p>{{tag.job_type_name}}</p>
                            <hr>
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
            <div class="panel panel-default" v-if="models.clinics.itemSelected">
              <div class="panel-heading text-center">
                <h3 class="panel-title">Acciones</h3>
              </div>
              <div class="panel-body btrans5" v-if="tableItems">
                <form action="" style="padding:10px">
                  <div class="fx fx-width-100 fx-col">
                    <div class="fx fx-width-100 jf-between fx-col mb-10">
                      <div class="fx fx-100 jf-around fx-col mb-10">
                        <button 
                          class="btn btn-info"
                          v-text="'Seleccionar Todos'"
                          :disabled="profilesSelected.length == models.profiles.items.length"
                          @click.prevent="selectAll()"
                          >
                        </button>
                        <button 
                          class="btn btn-info"
                          v-text="'Borrar Selección'"
                          :disabled="!profilesSelected.length"
                          @click.prevent="profilesSelected = []"
                          >
                        </button>
                        <button 
                          class="btn btn-info"
                          v-text="'Descargar'"
                          :disabled="!profilesSelected.length"
                          @click.prevent="downloadTags($event, profilesSelected)"
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
  </page>
</template>

<script>
    export default {
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              modelsNeeded: ['profiles'],
              profilesSelected: [],
              downloading: true,
              selectedClinic: null,
              model: 'profiles',
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
          tableItems() {
            if (this.$store.state.Model.models[this.model]) {
              if (this.$store.state.Model.models[this.model].items) {
                return true;
              }
            }
            return false;
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
        },
        methods: {
          selectAll() {
            this.profilesSelected = [];
            for (let profile of this.models.profiles.items) {
              this.profilesSelected.push(profile.id);
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
          shoppingCartToggle(id) {
            this.$store.commit('ShoppingCart/shoppingCartToggle', {item: id});
          },
          downloadTags(e, ids) {
            let classes = Vue.buttonLoaderOnEvent(e);
            axios({
              url: '/profiles/download-tags',
              method: 'GET',
              params: {
                profiles: ids,
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
          // if (this.$store.getters['Scope/ready']) {
          //   this.$store.dispatch('Model/fetchFilteredModels', {models: {'profiles':{}}, scoped: true});
          // }
        },
        mounted() {
        },
    }
</script>
<style type="text/css">
</style>