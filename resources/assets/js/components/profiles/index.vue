<template>
  <page :name="model" :models="modelsNeeded" :tables="tablesNeeded">
    <template slot="page-content">
      <div class="fx fx-w-100 jf-around">
        <div class="fx fx-100 fx-col">  
          <div class="panel panel-default">
            <div class="panel panel-default fx-100">
              <div class="panel-heading text-center">
                <h3 class="panel-title">Personal</h3>
              </div>
              <div class="panel-body">
                <vue-table
                  v-if="tableItems" 
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
  </page>
</template>

<script>
    export default {
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              modelsNeeded: ['profiles'],
              tablesNeeded: ['profiles'],
              model: 'profiles',
              //Table
              footer: {
                totalRows: 33,
              },
            }
        },
        watch: {
          scopeKey() {
            let models = {};
            for (let model of this.modelsNeeded) {
              models[model] = {};
            }
            // this.$store.dispatch('Model/fetchFilteredModels', {'models': models, 'scoped': true});
            this.$store.dispatch('Model/fetchFilteredModels', {'models': models, 'refresh': true, 'scoped': true});
          }
        },
        computed: {
          scopeKey() {
            return this.$store.state.Scope.scopeKey;
          },
          models() {
            return this.$store.state.Model.models;
          },
          tableItems() {
            if (this.$store.state.Model.models[this.model]) {
              if (this.$store.state.Model.models[this.model].items) {
                return true;
              }
            }
            return false;
          },
        },
        methods: {
        },
        created() {
        },
        mounted() {
        },
    }
</script>
<style type="text/css">
</style>