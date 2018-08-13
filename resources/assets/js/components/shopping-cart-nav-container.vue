<template>
    <li id="shopping-cart-nav-item" v-if="$store.state.ShoppingCart.shoppingCart.length">
        <a href="" id="shopping-cart-nav-container" @click.prevent >
            <i class="glyphicon glyphicon-shopping-cart" id="shopping-cart-main-nav-icon">
                <slot></slot>                  
            </i>
            <div class="number-alert"><p>{{$store.state.ShoppingCart.shoppingCart.length}}</p></div>
        </a>
    </li>
</template>

<script>
    export default {
        methods: {}
    }
</script>
