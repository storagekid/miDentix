<template>
    <div id="side-profile" v-if="user.email">
      <div class="profile-pic-round">
        <a href="/profile" class="thumbnail center-block">
          <img src="/img/profile-male.jpg" alt="...">
        </a>
      </div>
      <div class="col-xs-10 col-xs-offset-1 profile-info text-center">
        <p id="profile-name" v-text="user.profile.name"></p>
        <p id="profile-job" v-text="user.profile.job_type_name"></p>
      </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                
            }
        },
        methods: {
        },
        computed: {
            user() {
                return this.$store.state.User.user;
            }
        },
        created() {
        },
        mounted() {
        }
    }
</script>
