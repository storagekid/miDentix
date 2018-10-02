<template>
    <input 
        type="text" 
        :name="data.name"
        class="form-control"
        v-model="modelToSave[data.name]"
        @blur="validateField(data.name,modelToSave[data.name],data.rules)"
        :required="data.rules.includes('required')"
    >
</template>
<script>
    import errors from '../../../../mixins/errors.js';
    import validations from '../../../../mixins/validations.js';
    export default {
        mixins: [errors,validations],
        props: ['data', 'model'],
        data() {
            return {}
        },
        methods: {
        },
        computed: {
            modelToSave() {
                return this.$store.state.Model.models[this.model].modelToSave;
            }
        }
    }
</script>

