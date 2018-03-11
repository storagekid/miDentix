<template>
    <div id="side-profile">
      <div class="profile-pic-round">
        <a href="/profile" class="thumbnail center-block">
          <img src="/img/profile-male.jpg" alt="...">
        </a>
      </div>
      <div class="col-xs-10 col-xs-offset-1 profile-info text-center">
        <p id="profile-name" v-text="user.profile.name"></p>
        <p v-if="user.role == 'user'">Odontólog@</p>
        <p v-else>Administrador</p>
      </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                
            }
        },
        methods: {
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
