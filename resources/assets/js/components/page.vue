<template>
  <div>
    <page-loading v-if="!pageReady" :name="name"></page-loading>
    <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
      <div :id="name" class="fx pv-20" v-show="pageReady">
        <slot name="page-content"></slot>
      </div>
    </transition>
  </div>
</template>

<script>
    export default {
      props: ['name','models','tables'],
        data() {
            return {
            }
        },
        watch: {
          pageReady() {
            if (this.pageReady) {
              this.$store.commit('Page/setReady', {name: this.name});
            }
          }
        },
        computed: {
          pageReady() {
            let models = false;
            let tables = false;
            if (this.models) {
              for (let model of this.models) {
                if (this.$store.state.Model.models[model]) {
                  if (this.$store.state.Model.models[model].items) {
                    models = true;
                  }
                }
              }
            } else {
              models = true;
            }
            if (this.tables) {
              for (let table of this.tables) {
                if (this.$store.state.Table.tables[table]) {
                  tables = true;
                }
              }
             } else {
              tables = true;
            }
            return (models && tables);
          },
        },
        methods: {
          fetchModels() {
            let models = {};
            for (let model of this.models) {
              models[model] = {};
            }
            this.$store.dispatch('Model/fetchFilteredModels', {'models': models, 'scoped': true});
          }
        },
        created() {
          this.$store.commit('Page/setPage', {name: this.name, models: this.models, tables: this.tables});
          this.fetchModels();
          // this.$store.dispatch('Model/fetchFilteredModels', {models: {'orders':{}}, scoped: true});
        },
        mounted() {
        },
    }
</script>
<style type="text/css">
</style>