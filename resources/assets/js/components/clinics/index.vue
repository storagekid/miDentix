<template>
  <div id="clinics" class="fx pv-20" v-if="pageReady">
    <template>
      <div class="fx fx-w-100 jf-around">
        <div class="fx fx-100 fx-col">  
          <div class="panel panel-default">
            <div class="panel panel-default fx-100">
              <div class="panel-heading text-center">
                <h3 class="panel-title">Clinics</h3>
              </div>
              <div class="panel-body">
                <vue-table 
                  v-if="models[model].items" 
                  :model="model"
                  :scoped="model"
                  mode="vuex"
                  >
                </vue-table>
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
              modelsNeeded: ['clinics'],
              model: 'clinics',
              //Table
              footer: {
                totalRows: 0,
              },
            }
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
        },
        created() {
          this.$store.dispatch('Model/fetchModels',{models: this.modelsNeeded});
        },
        mounted() {
        },
    }
</script>
<style type="text/css">
</style>