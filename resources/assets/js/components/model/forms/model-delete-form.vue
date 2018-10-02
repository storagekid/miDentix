<template>
  <div id="model-delete-container">
    <loading v-if="!$store.getters.ready"></loading>
    <div class="fx fx-col jf-center" v-else>
      <div class="modal-heading text-center">
          <h3 class="panel-title">Eliminar Registros</h3>
      </div>
      <div class="modal-body">
        <div class="panel-default fx-100">
            <div class="panel-body text-center">
                <h4>¿Estas seguro de que deseas eliminar los registros</h4>
            </div>
        </div>
      </div>
      <div class="modal-footer fx mr-10">
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
            this.$store.commit('Modal/hideModal',{name: this.modalName});
          },
          confirmDeleting() {
              if (this.relatedModel) {
                this.$store.dispatch('Model/removeRelations', {name: this.relatedModel, relation: this.model, ids: this.$store.state.Modal.modals[this.modalName].ids});                  
              } else {
                this.$store.dispatch('Model/removeModels', {name: this.$store.state.Modal.modals[this.modalName].model, ids: this.$store.state.Modal.modals[this.modalName].ids});                  
              }
          },
        },
    }
</script>
<style type="text/css">
</style>