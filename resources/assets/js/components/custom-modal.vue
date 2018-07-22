<template>
    <modal 
        :name="name" height="auto" width="1000px" maxWidht="80%"
        @closed="destroyModal"
        >
        <slot></slot>
    </modal>
</template>

<script>
    export default {
        props: ['name'],
        methods: {
            destroyModal() {
                this.$store.commit('hideModal', {name: this.name});
                this.$store.commit('destroyModal', {name: this.name});
            }
        },
    }
</script>
