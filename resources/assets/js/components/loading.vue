<template>
  <div class="row">
      <div class="loader-box" v-if="loading">
        <i class="fa fa-spinner fa-spin loading-box"></i>
      </div>
  </div>
</template>

<script>
    export default {
        data() {
            return {
              loading: false,
              }
        },
        watch: {
        },
        methods: {
        },
        computed: {
        },
        created() {
          window.events.$on('loaded', function() {
            this.loading = false;
            console.log('loaded Catched');
          }.bind(this));
          window.events.$on('loading', function() {
            this.loading = true;
            console.log('loading Catched');
          }.bind(this));
        }
    }
</script>
<style type="text/css">
</style>