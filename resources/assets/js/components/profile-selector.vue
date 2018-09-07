<template>
    <div id="profile-selector" class="fx fx-w-100 jf-around">
        <div class="fx fx-100 fx-col ph-10">  
            <div class="fx fx-col">
                <div class="panel panel-default fx-100">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title">Selecciona un perfil de Usuario</h3>
                    </div>
                    <div class="panel-body">
                        <form class="form">
                            <div class="form-group">
                                <label for="country_id">Perfil</label>
                                <select 
                                    name="profile_id" 
                                    >
                                    <option
                                        :value='null'
                                        v-text="'Selecciona un País'"
                                        >
                                    </option>
                                    <option
                                        v-for="(item, index) in $store.state.User.user.profiles"
                                        :key="index"
                                        v-text="item.full_name" 
                                        :value="item.id"
                                        >
                                    </option>
                                </select>
                            </div>
                            <button @click.prevent="selectProfile">Confirmar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                modelsNeeded: ['clinics','countries','states','counties'],
            }
        },
        watch: {
            countries() {
                if ( this.$store.getters['Scope/ready']) {
                    this.selectModel(null,'states');
                }
            },
            states() {
                if ( this.$store.getters['Scope/ready']) {
                    this.selectModel(null,'counties');
                }
            },
            counties() {
                if ( this.$store.getters['Scope/ready']) {
                    this.selectModel(null,'clinics');
                }
            },
            clinics() {
                if (this.$store.getters['ShoppingCart/itemsInCart'] != 0) {
                    this.$store.commit('ShoppingCart/cleanShoppingCart', {categories:null});
                }
            },
        },
        computed: {
            countries() {
                return this.$store.state.Scope.countries.selected;
            },
            counties() {
                return this.$store.state.Scope.counties.selected;
            },
            states() {
                return this.$store.state.Scope.states.selected;
            },
            clinics() {
                return this.$store.state.Scope.clinics.selected;
            },
            countriesModel() {
                if (this.$store.state.Model.models.countries) {
                    return this.$store.state.Model.models.countries.items;
                }
            },
            statesModel() {
                if (this.$store.state.Model.models.states) {
                    return this.$store.state.Model.models.states.items;
                }
            },
            countiesModel() {
                if (this.$store.state.Model.models.counties) {
                    return this.$store.state.Model.models.counties.items;
                }
            },
            clinicsModel() {
                if (this.$store.state.Model.models.clinics) {
                    return this.$store.state.Model.models.clinics.items;
                }
            }
        },
        methods: {
            selectModel(e, model) {
                let id = e ? e.target.value : null;
                this.$store.commit('Scope/selectModel', {'model': model, 'id': id})
                this.$store.commit('Model/selectModel', {'model': model, 'id': id})
                // this[model] = e.target.value;
            },
        },
        created() {            
        },
        mounted() {
        }
    }
</script>
