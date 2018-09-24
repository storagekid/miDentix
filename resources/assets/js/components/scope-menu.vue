<template>
    <div id="scope-menu-container" v-if="$store.getters['Scope/ready']">
        <form class="form form-inline mr-10">
            <div class="form-group">
                <label for="country_id">País</label>
                <select 
                    name="country_id" 
                    id=""
                    @change="selectModel($event,'countries')"
                    :disabled="($store.state.Scope.countries.ids.length == 1 && countries)"
                    >
                    <option
                        :value='null'
                        :selected="!countries"
                        v-text="'Selecciona un País'"
                        >
                    </option>
                    <option
                        v-for="(item, index) in countriesModel"
                        :key="index"
                        v-if="$store.state.Scope.countries.ids.includes(item.id)"
                        v-text="item.name" 
                        :value="item.id"
                        :selected="item.id == $store.state.Scope.countries.selected"
                        >
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="state_id">CCAA</label>
                <select 
                    name="state_id" 
                    id=""
                    @change="selectModel($event,'states')"
                    :disabled="($store.state.Scope.states.ids.length == 1 && states) || !countries"
                    >
                    <option
                        :value="null"
                        :selected="!states"
                        v-text="'Selecciona una CCAA'"
                        >
                    </option>
                    <option
                        v-for="(item, index) in statesModel"
                        v-if="$store.state.Scope.states.ids.includes(item.id) && (item.country_id == $store.state.Scope.countries.selected)"
                        :key="index"
                        v-text="item.name" 
                        :value="item.id"
                        :selected="item.id == $store.state.Scope.states.selected"
                        >
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="county_id">Provincia</label>
                <select 
                    name="county_id" 
                    id=""
                    @change="selectModel($event,'counties')"
                    :disabled="($store.state.Scope.counties.ids.length == 1 && counties) || !states"
                    >
                    <option
                        :value="null"
                        :selected="!counties"
                        v-text="'Selecciona una Provincia'"
                        >
                    </option>
                    <option
                        v-for="(item, index) in countiesModel"
                        v-if="$store.state.Scope.counties.ids.includes(item.id) && (item.state_id == $store.state.Scope.states.selected)"
                        :key="index"
                        v-text="item.name" 
                        :value="item.id"
                        :selected="item.id == $store.state.Scope.counties.selected"
                        >
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="clinic_id">Clínica</label>
                <select 
                    name="clinic_id" 
                    id=""
                    @change="selectModel($event,'clinics')"
                    :disabled="($store.state.Scope.clinics.ids.length == 1 && clinics) || !counties"
                    >
                    <option
                        :value="null"
                        :selected="!clinics"
                        v-text="'Selecciona una Clínica'"
                        >
                    </option>
                    <option
                        v-for="(item, index) in clinicsModel"
                        v-if="$store.state.Scope.clinics.ids.includes(item.id) && (item.county_id == $store.state.Scope.counties.selected)"
                        :key="index"
                        v-text="item.cleanName" 
                        :value="item.id"
                        :selected="item.id == $store.state.Scope.clinics.selected"
                        >
                    </option>
                </select>
            </div>
            <div class="form-group dots-left">
                <button
                    class="btn btn-xs selectable"
                    v-if="$store.state.Scope.clinics.ids.length > 1"
                    v-text="'Seleccionar Área'"
                    @click.prevent="setScope"
                    >
                </button>
            </div>
        </form>
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
            setScope() {
                this.$store.commit('Scope/setScopeKey');
                this.$cookies.set(this.$store.state.User.user.email + '-scope', this.$store.state.Scope.scopeKey);
            },
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
