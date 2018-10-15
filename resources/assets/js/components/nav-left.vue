<template>
    <div>
        <div v-show="leftMenu" class="fx fx-col fx-100 jf-between" id="left-sidebar">
            <span id="close-left-menu" class="glyphicon glyphicon-resize-small" @click="toggleLeftMenu"></span>
            <profile-left></profile-left>
            <main-menu :menu="menu" :user="$store.state.user"></main-menu>
            <div id="left-nav-footer">
                <span class="glyphicon glyphicon-inbox"></span>
                <span class="glyphicon glyphicon-cog"></span>
                <span class="glyphicon glyphicon-off"></span>
            </div>
        </div>
        <div v-show="!leftMenu">
            <span id="left-menu-toggle" class="glyphicon glyphicon-menu-hamburger" @click="toggleLeftMenu"></span>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['menu','user'],
        data() {
            return {
                leftMenu: true,
            }
        },
        methods: {
            toggleLeftMenu() {
                this.leftMenu = !this.leftMenu;
                window.events.$emit('toggleLeftMenu', {data:this.leftMenu});
            }
        },
        created() {
            window.events.$on('requestClosed', this.notifySolved);
            window.events.$on('requestAdded', this.notifyRequestAdded);
            window.events.$on('extratimeAdded', this.notifyExtratimeAdded);
            window.events.$on('extratimeRemoved', this.notifyExtratimeRemoved);
            window.events.$on('extratimeSolved', this.notifyExtratimeRemoved);
        },
        mounted() {
        }
    }
</script>
<style type="text/css">
    #close-left-menu {
        position: absolute;
        right: 5px;
        top: 10px;
        color: #753470;
        font-size: 1.5em;
        cursor: pointer;
        z-index: 99999;
    }
    #left-menu-toggle {
        position: absolute;
        top: 5px;
        left: 0;
        font-size: 1.5em;
        color: #FFF;
        padding: 10px;
        border-radius: 0 20px;
        z-index: 99999;
        cursor: pointer;
    }
</style>