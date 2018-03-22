<template>
  <div>
    {{ count }}
    <p>
      <button @click="increment">+1</button>
    </p>
  </div>
</template>

<script>
    export default {
        props: [
        ],
        data() {
            return {
              count: 0,
            }
        },
        watch: {
        },
        methods: {
          increment() {
            this.count++;
          }
        },
        computed: {
        },
        created() {
        },
    }
</script>
<style type="text/css">
</style>