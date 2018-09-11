<template>
  <div id="page-loading-container" class="fx fx-100 fx-col fx-center jf-center">
      <h1 class="loader-title" v-if="modelsToLoad.length+tablesToLoad.length">Cargando Página...</h1>
      <div class="progress">
        <div class="progress-bar progress-bar-dentix progress-bar-striped active" 
                role="progressbar" :aria-valuenow="100 - ( ( (this.modelsToLoad.length+this.tablesToLoad.length) * 100 ) / this.modelsCount+this.tablesCount)" 
                aria-valuemin="0" aria-valuemax="100" 
                :style="style"
                >
        </div>
    </div>
  </div>
</template>
<script>
    export default {
        props: ['name'],
        data() {
            return {
            }
        },
        computed: {
            style() {
                let width = String(
                    100 - ( ( (this.modelsToLoad.length + this.tablesToLoad.length) * 100 ) / (this.modelsCount + this.tablesCount)) 
                    );
               return 'width: ' + width + '%';
            },
            modelsCount() {
                if (this.$store.state.Page.pages[this.name].models) {
                    return this.$store.state.Page.pages[this.name].models.length;                    
                } else {
                    return 0;
                }
            },
            modelsToLoad() {
                return this.$store.state.Page.pages[this.name].models.filter(model => {
                    return !this.models[model].items;
                });
            },
            tablesCount() {
                if (this.$store.state.Page.pages[this.name].tables) {
                    return this.$store.state.Page.pages[this.name].tables.length;                    
                } else {
                    return 0;
                }
            },
            tablesToLoad() {
                return this.$store.state.Page.pages[this.name].tables.filter(table => {
                    return !this.tables[table];
                });
            },
            models() {
                return this.$store.state.Model.models;
            },
            tables() {
                return this.$store.state.Table.tables;
            },
        }
    }
</script>
