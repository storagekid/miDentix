<template>
    <modal :name="'new-' + model + '-model'" height="auto" width="1000px" maxWidht="80%">
      <model-new-form
          :model="model"
          :modelNewFormOptions="modelNewFormDataOptions"
          >
          <h3 slot="header" class="panel-title">Nuevo Material</h3>
      </model-new-form>
    </modal>
</template>

<script>
    import modelNewForm from '../../components/model/model-new-form.vue';
    export default {
        components: {modelNewForm},
        data() {
            return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              modelNewFormDataOptions: {
                checkSourceData: true,
                hasFiles: false,
              },
              model: 'stationaries',
            }
        },
    }
</script>
<style type="text/css">
</style>