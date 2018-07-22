<template>
  <div id="model-delete-container">
    <loading v-if="!$store.getters.ready"></loading>
    <div class="fx jf-center" v-else>
      <div class="fx-100 panel panel-default">
            <div class="panel-heading text-center">
              <h3 class="panel-title">Eliminar Registros</h3>
            </div>
            <div class="panel-body">
                <button 
                class="btn btn-warning btn-sm" 
                    @click.prevent="cancelDeleting"
                    >
                    Cancelar
                </button>
                <button 
                class="btn btn-primary btn-sm" 
                    @click.prevent="confirmDeleting"
                    >
                    Eliminar
                </button>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
    export default {
        props: ['model', 'relatedModel', 'ids'],
        computed: {
            modalName() {
                return 'delete-' + this.model + '-model';
            }
        },
        methods: {
          cancelDeleting() {
            this.$store.commit('hideModal',{name: this.modalName});
          },
          confirmDeleting() {
              if (this.relatedModel) {
                this.$store.dispatch('removeRelations', {name: this.relatedModel, relation: this.model, ids: this.$store.state.modals[this.modalName].ids});                  
              } else {
                this.$store.dispatch('removeModels', {name: this.$store.state.modals[this.modalName].model, ids: this.$store.state.modals[this.modalName].ids});                  
              }
          },
        },
    }
</script>
<style type="text/css">
</style>