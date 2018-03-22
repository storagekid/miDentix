<template>
  <div class="custom-table">
    <div :class="panelClass">
      <button class="btn btn-sm btn-primary" @click.prevent="">Crear Usuario</button>
    </div>
    <div class="panel-footer table-footer">
      <h3>Opciones: <strong>Footer</strong></h3>
    </div>
  </div>
</template>

<script>
    import * as moment from 'moment';
    import 'moment/locale/es';
    export default {
        components: {},
        props: [],
        data() {
            return {
            }
        },
        watch: {
        },
        methods: {
        },
        computed: {
          panelClass() {
            if (this.admin) {
              return 'panel-body-admin';
            } else {
              return 'panel-body';
            }
          },
        },
        created() {
          moment.locale('es');
        },
        mounted() {
        }
    }
</script>
<style type="text/css">

</style>