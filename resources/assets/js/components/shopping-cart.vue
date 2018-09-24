<template>
    <div id="shopping-cart" class="panel panel-default">
        <div class="panel-heading text-center">
            <h3 class="panel-title">Pedido</h3>
        </div>
        <div class="panel-body">
            <h3>{{ modelSelected.city}} </h3>
            <h6>{{ modelSelected.address_real_1 }}</h6>
            <hr>
            <div class="mb-10">
                <ul 
                    v-for="(category, name) in shoppingCart"
                    v-if="shoppingCart[name].ids.length"
                    :key="name"
                    >
                    <h4>{{category.shoppingCartHeaderText}}</h4>
                    <li
                    v-for="(item, index) in modelsSelected[name]"
                    :key="index"
                    >
                    {{ item[category.shoppingCartItemKey] }}
                    </li>
                </ul>
            </div>
            <hr>
            <div class="form-group">
                <button
                class="btn btn-primary"
                @click="setOrder"
                >
                Hacer Pedido
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [],
        data() {
            return {
            };
        },
        computed: {
            modelSelected() {
                return this.$store.state.Model.models.clinics.itemSelected;
            },
            shoppingCart() {
                return this.$store.state.ShoppingCart.shoppingCart;
            },
            modelsSelected() {
                let models = {};
                let vm = this;
                for (let category in this.$store.state.ShoppingCart.shoppingCart) {
                    let modelName = this.shoppingCart[category].model;
                    if (this.$store.state.Model.models[modelName]) {
                        if (this.$store.state.Model.models[modelName].items) {
                            models[category] = [];
                            for (let item of this.$store.state.Model.models[modelName].items) {
                                if (vm.shoppingCart[category].ids.includes(item.id)) {
                                    models[category].push(item);
                                }
                            }
                        }
                        // let selected = this.$store.state.Model.models[modelName].items.filter(function(item) {
                        //     if (vm.shoppingCart[category].ids.includes(item.id)) {
                        //         return item;
                        //     }
                        // });
                    } else {
                        models[category] = [];
                    }
                }
                return models;
            },
            stationariesSelected() {
                let vm = this;
                let selected = this.$store.state.Model.models.stationaries.items.filter(function(item) {
                if (vm.shoppingCart.stationaries.ids.includes(item.id)) {
                    return item;
                }
                });
                return selected;
            },
            medicalCharts() {
                let vm = this;
                let selected = this.$store.state.Model.models.profiles.items.filter(function(item) {
                if (vm.shoppingCart.medicalCharts.ids.includes(item.id)) {
                    return item;
                }
                });
                return selected;
            },
        },
        methods: {
            setOrder(e) {
                let classes = Vue.buttonLoaderOnEvent(e);
                this.$store.dispatch('ShoppingCart/setOrder', {clinic: this.$store.state.Model.models.clinics.itemSelected, e:e, classes: classes});
            },
        }
    };
</script>