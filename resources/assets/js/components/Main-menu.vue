<template>
    <ul class="nav navbar-nav">
        <li v-for="menu in items" :class="{ active: menu.link === isActive}">
            <a :href="menu.link"> 
                <span :class="menu.icon"></span> 
                <span class="hidden-sm" v-text="menu.name"></span>
                <span class="badge badge-menu" v-if="menu.name == 'Necesidades' && admin.requestsUnsolved">{{admin.requestsUnsolved}}</span>
                <span class="badge badge-menu" v-if="menu.name == 'Usuarios' && admin.deadUsers">{{admin.deadUsers}}</span>
                <span class="badge badge-menu" v-if="(menu.name == 'Bolsa de Horas' || menu.name == 'Jornada') && admin.extratimesUnsolved > 0">{{admin.extratimesUnsolved}}</span>
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
                admin: {
                    requests: [],
                    profiles: [],
                    extratimes: [],
                    requestsUnsolved: 0,
                    extratimesUnsolved: 0,
                    deadUsers: 0,
                }
            }
        },
        methods: {
            getActive() {
                let str = window.location.pathname;
                let index = str.indexOf('/',2);
                if (index != -1) {
                    str = str.substring(0,index);
                } 
                this.isActive = str;
            },
            countUnsolved() {
                for (let request of this.admin.requests) {
                    if (!request.closed_at) {
                        this.admin.requestsUnsolved++;
                    }
                }
                for (let extratime of this.admin.extratimes) {
                    if (extratime.state == 1) {
                        this.admin.extratimesUnsolved++;
                    }
                }
            },
            countDeadUsers() {
                for (let profile of this.admin.profiles) {
                    if (!profile.user.last_access) {
                        this.admin.deadUsers++;
                    }
                }
            },
            notifySolved() {
                this.admin.requestsUnsolved--;
            },
            notifyRequestAdded() {
                this.admin.requestsUnsolved++;
            },
            notifyExtratimeAdded() {
                this.admin.extratimesUnsolved++;
            },
            notifyExtratimeRemoved() {
                this.admin.extratimesUnsolved--;
            },
            fetchMenuData() {
                axios.get('/api/menu')
                    .then(data => {
                      this.admin.requests = data.data.requests;
                      this.admin.extratimes = data.data.extratimes;
                      this.countUnsolved();
                      if (this.user.role == 'admin') {
                        this.admin.profiles = data.data.profiles;
                        this.countDeadUsers();
                      }
                    });
            }
        },
        created() {
            window.events.$on('requestClosed', this.notifySolved);
            window.events.$on('requestAdded', this.notifyRequestAdded);
            window.events.$on('extratimeAdded', this.notifyExtratimeAdded);
            window.events.$on('extratimeRemoved', this.notifyExtratimeRemoved);
            window.events.$on('extratimeSolved', this.notifyExtratimeRemoved);
            this.getActive();
            this.fetchMenuData();
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
