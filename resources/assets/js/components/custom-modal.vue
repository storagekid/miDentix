<template>
    <modal 
        :name="name" 
        height="auto" 
        :width="width" 
        maxWidht="80%"
        @closed="destroyModal"
        >
        <slot></slot>
    </modal>
</template>

<script>
    export default {
        props: ['name', 'width'],
        methods: {
            destroyModal() {
                this.$store.commit('Modal/hideModal', {name: this.name});
                this.$store.commit('Modal/destroyModal', {name: this.name});
            }
        },
    }
</script>
