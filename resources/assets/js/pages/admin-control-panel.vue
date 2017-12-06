<template>
  <div>
    <request-graphs></request-graphs>
    <users-graphs></users-graphs>
  </div>
</template>

<script>
    import * as moment from 'moment';
    import 'moment/locale/es';
    import requestGraphs from '../components/control-panel/admin/request-graphs';
    import usersGraphs from '../components/control-panel/admin/users-graphs';
    export default {
        components: {requestGraphs,usersGraphs},
        props: [
        ],
        data() {
            return {
            }
        },
        watch: {
        },
        methods: {
        },
        computed: {
        },
        created() {
          moment.locale('es');
        },
    }
</script>
<style type="text/css">
</style>