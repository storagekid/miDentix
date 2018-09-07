<template>
  <div id="profiles" class="fx pv-20" v-if="pageReady">
    <template>
      <div class="fx fx-w-100 jf-around">
        <div class="fx fx-100 fx-col">  
          <div class="panel panel-default">
            <div class="panel panel-default fx-100">
              <div class="panel-heading text-center">
                <h3 class="panel-title">Personal</h3>
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
      </div>
    </template>
  </div>
</template>

<script>
    export default {
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              modelsNeeded: ['profiles'],
              model: 'profiles',
              //Table
              footer: {
                totalRows: 0,
              },
            }
        },
        watch: {
          scopeKey() {
            console.log('Scope Key Changed!!!!');
            this.$store.dispatch('Model/fetchFilteredModels', {models: {'profiles':{}}, refresh: true, scoped: true});
          }
        },
        computed: {
          scopeKey() {
            return this.$store.state.Scope.scopeKey;
          },
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
          if (this.$store.getters['Scope/ready']) {
            if (this.$store.state.Scope.counties.selected) {
              this.$store.dispatch('Model/fetchFilteredModels', {models: {'profiles':{}}, scoped: true});
            }
            else {
              flash({
                message: 'Debe seleccionar una provincia', 
                label: 'danger'
              });
            }
          }
        },
        mounted() {
        },
    }
</script>
<style type="text/css">
</style>