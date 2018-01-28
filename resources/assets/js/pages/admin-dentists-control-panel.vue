<template>
  <div>
    <request-graphs @ready="requestsReady"></request-graphs>
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
                tests: {
                    requests: false,
                    users: true,
                },
            }
        },
        watch: {
            ready() {
                if (this.ready) {
                    window.events.$emit('loaded');
                }
            }   
        },
        methods: {
            requestsReady() {
                this.tests.requests = true;
            }
        },
        computed: {
            ready() {
                for (let test in this.tests) {
                    if (!this.tests[test]) {
                        return false;
                    }
                }
                return true;
            }   
        },
        beforeCreate() {
            window.events.$emit('loading');
        },
        created() {
            moment.locale('es');
            // window.events.$emit('loading');
        },
        // mounted() {
        //     window.events.$emit('loading');
        // }
    }
</script>
<style type="text/css">
</style>