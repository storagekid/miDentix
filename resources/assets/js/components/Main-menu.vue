<template>
    <ul class="nav navbar-nav">
        <li v-for="menu in items" :class="{ active: menu.link === isActive}">
            <a :href="menu.link"> 
                <span :class="menu.icon"></span> 
                <span class="hidden-sm" v-text="menu.name"></span>
            </a>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['menu','user'],
        data() {
            return {
                items: this.menu,
                userData: this.user,
                isActive: '',
            }
        },
        created() {
            let str = window.location.pathname;
            let index = str.indexOf('/',2);
            if (index != -1) {
                str = str.substring(0,index);
            } 
            this.isActive = str;
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
