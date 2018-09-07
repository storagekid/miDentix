<template>
    <transition enter-active-class="animated tada" leave-active-class="animated tada">
        <li id="shopping-cart-nav-item"  v-if="$store.getters['ShoppingCart/itemsInCart'] != 0 && $store.state.Model.models.clinics">
            <a href="" id="shopping-cart-nav-container" @click.prevent >
                <transition enter-active-class="animated tada">
                    <div :key="$store.getters['ShoppingCart/itemsInCart']" class="badge-container fx fx-col fx-center">
                        <span class="">{{$store.getters['ShoppingCart/itemsInCart']}}</span>
                    </div>
                </transition>
                <i class="glyphicon glyphicon-shopping-cart" id="shopping-cart-main-nav-icon">
                    <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
                        <slot></slot>        
                    </transition>          
                </i>
                <!-- <div class="number-alert"><p>{{$store.getters['ShoppingCart/itemsInCart']}}</p></div> -->
            </a>
        </li>
    </transition>
</template>

<script>
    export default {
        methods: {}
    }
</script>
