<template>
  <div class="panel panel-default" v-if="$store.state.Model.models.clinics.itemSelected">
    <div class="panel-heading text-center">
      <h3 class="panel-title">Hacer Pedido</h3>
    </div>
    <div class="panel-body">
      <form action="" style="padding:10px">
          <div class="form-group fx fx-width-100 fx-col" v-if="">
            <label for="clinicId"><h4>Materiales Personalizados</h4></label>
            <div class="fx fx-width-100 jf-between">
              <div class="fx fx-100 jf-around">
                <div class="form-group mr-10-all mb-10-all">
                  <button
                    class="btn selectable"
                    :class="{'selected': shoppingCart['stationaries'].ids.includes(stationary.id)}"
                    v-for="(stationary, index) in models.clinics.itemSelected.stationaries"
                    :key="index"
                    @click.prevent="shoppingCartToggle(stationary.id, 'stationaries')"
                    >
                    <img :src="stationary.pivot.thumbnail" alt="">
                    <p>{{stationary.description}}</p>
                  </button>
                </div>
              </div>
            </div>
            <label for="clinicId"><h4>Materiales Genéricos</h4></label>
            <div class="fx fx-width-75 fx-center">
              <div class="fx fx-75 jf-around">
                <div class="form-group mr-10-all mb-10-all">
                  <button
                    class="btn selectable-rev"
                    :class="{'selected': shoppingCart['stationaries'].ids.includes(stationary.id)}"
                    v-for="(stationary, index) in models.stationaries.items"
                    v-if="!stationary.customizable"
                    :key="index"
                    v-text="stationary.description"
                    @click.prevent="shoppingCartToggle(stationary.id, 'stationaries')"
                    >
                  </button>
                </div>
              </div>
            </div>
          </div>
      </form> 
    </div>
  </div>
</template>

<script>
    export default {
        data() {
            return {};
        },
        watch: {
        },
        computed: {
            shoppingCart() {
            return this.$store.state.ShoppingCart.shoppingCart;
            },
            models() {
                return this.$store.state.Model.models;
            },
        },
        methods: {
            shoppingCartToggle(id, category) {
                this.$store.commit('ShoppingCart/shoppingCartToggle', {item: id, 'category':category});
            },
        },
        created() {
            this.$store.commit('ShoppingCart/setCategory', {name:'stationaries', model: 'stationaries', headerText: 'Papelería Corporativa', itemKey: 'description'});
        },
        mounted() {
        },
    }
</script>
<style type="text/css">
</style>