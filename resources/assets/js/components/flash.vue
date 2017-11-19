<template>
    <div class="flash-container" v-if="flashEvent">
        <div :class="alert.label" role="alert" v-for="(alert, index) in alerts"> 
          {{ alert.body }}
        </div>
    </div>
</template>

<script>

    export default {

        props: ['message','sessionLabel'],
        
        data() {

            return {
                alerts: [],
                body: '',
                label: '',
                flashEvent: false,
            };
        },
        computed: {
            classes() {
                return 'alert-flash alert alert-' + this.label;
            }
        },
        created() {
            if (this.message) {
                let data = {};
                data.message = this.message;
                data.label = this.sessionLabel != '' ? this.sessionLabel : 'info';
                this.showFlash(data);
            }
            window.events.$on('flash', data => {
                this.showFlash(data);
            })
        },

        methods: {

            showFlash(data) {
                let flash = {}
                let id = 0;
                if (this.alerts.length > 0) {
                    id = this.alerts.length;
                }
               flash.body = data.message;
               flash.label = 'alert-flash alert alert-'+data.label;
               this.label = data.label;
               flash.id = id;
                this.alerts.push(flash);
               this.flashEvent = true;   
               this.hideFlash(id);  

            },
            hideFlash(id) {
                setTimeout(()=> {
                    for (let i = 0; i < this.alerts.length;i++) {
                        if (this.alerts[i].id == id) {
                            this.alerts.splice(i,1);
                        }
                    }
                    if (this.alerts.length < 1) {
                        this.flashEvent = false;   
                    }
                }, 5000);
            }
        }
    };

</script>

<style>
    .flash-container {
        display: block;
        padding: 15px;
        position: fixed;
        width: 300px;
        top: 50px;
        right: 10px;
        height: auto;
        max-height: 90vh;
        overflow-y: auto;
        background: rgba(255,255,255,.30);
        padding-bottom: 5px;
    }
    .alert-flash{
        display: inline-block;
        float: right;
        width: 100%;
        clear: both;
        margin-bottom: 10px;
    }

</style>