export default {
	data() {
		return {
            validationMethods: {
                required: this.required,
                min: this.minLength,
                max: this.maxLength,
            }
		};
	},

	methods: {
        validateField(field,input,rules) {
            if (!rules.includes('required') && (!input || input == '')) {
                if (this.errorsHas(field)) {
                    this.$delete(this.errors.errorsInField, field);
                    this.errors.fieldsWithErrors.splice(this.errors.fieldsWithErrors.indexOf(field),1);
                }
                return true;
            }
            for (let rule of rules) {
                let params = '';
                if (rule.indexOf(':') != -1) {
                    let i = rule.indexOf(':');
                    params = rule.slice(i+1);
                    rule = rule.slice(0,i);
                };
                this.descriptionBuilder(field, rule, params);
                if (!this.validationMethods[rule](input,params)) {
                    if (!this.errorsHas(field)) {
                        this.errors.fieldsWithErrors.push(field);
                        this.$set(this.errors.errorsInField,field,[]);
                    }
                    if (!this.fieldHasError(field, rule)) {
                        this.errors.errorsInField[field].push(rule); 
                    }
                } else {
                    if (this.errorsHas(field)) {
                        if (this.fieldHasError(field, rule)) {
                            this.fieldErrorRemover(field, rule);
                        }
                        if (!Object.keys(this.errors.errorsInField[field]).length) {
                            this.$delete(this.errors.errorsInField, field);
                            this.errors.fieldsWithErrors.splice(this.errors.fieldsWithErrors.indexOf(field),1);
                        }
                    }
                }
            }
        },
        required(input) {
            if (!input) return false;
            return true;
        },
        minLength(input, param) {
            if (input && input.length >= param) return true;
            return false;
        },
        maxLength(input, param) {
            if (input && param >= input.length) return true;
            return false;
        }
	}
}