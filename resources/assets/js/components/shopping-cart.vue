<template>
    <div id="shopping-cart" class="panel panel-default" v-if="shoppingCart.length">
        <div class="panel-heading text-center">
            <h3 class="panel-title">Pedido</h3>
        </div>
        <div class="panel-body">
            <h3>{{ modelSelected.city}} </h3>
            <h6>{{ modelSelected.address_real_1 }}</h6>
            <hr>
            <ul>
                <li
                v-for="(item, index) in stationariesSelected"
                :key="index"
                >
                {{ item.description }}
                </li>
            </ul>
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
            stationariesSelected() {
            let vm = this;
            let selected = this.$store.state.Model.models.stationaries.items.filter(function(item) {
              if (vm.shoppingCart.includes(item.id)) {
                return item;
              }
            });
            return selected;
          },
        },
        methods: {
            setOrder(e) {
            let classes = Vue.buttonLoaderOnEvent(e);
            axios.post('/order/'+this.$store.state.Model.models.clinics.itemSelected.id, {items: this.shoppingCart})
              .then((response) => {
                this.$store.commit('Model/selectModel',{model:'clinics',id:'null'});
                flash({
                    message: 'Pedido enviado. Muchas gracias', 
                    label: 'success'
                });
              }).catch((error) => {
                flash({
                        // message: error.response.data, 
                        message: 'Error en el servidor.<br>Por favor, contacte con el administrador de la plataforma', 
                        label: 'danger'
                    });
                Vue.buttonLoaderRemove(e, classes);
              });
            },
        }
    };
</script>