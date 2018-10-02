export default {
	data() {
		return {
			errors: {
				fieldsWithErrors: [],
				errorsInField:{},
				descriptions: {
				}
			},
		};
	},
	computed: {
		errorsCount() {
			return this.errors.fieldsWithErrors.length;
		}
	},
	methods: {
		errorsHas(field) {
			return this.errors.fieldsWithErrors.includes(field);
		},
		fieldHasError(field, rule) {
			return this.errors.errorsInField[field].includes(rule);
		},
		descriptionBuilder(field, rule, param) {
			if (!this.errors.descriptions[field]) {
				this.errors.descriptions[field] = {};
			}
			switch(rule) {
				case 'required':
					this.errors.descriptions[field][rule] = 'Campo obligatorio.';
					break;
				case 'min':
					this.errors.descriptions[field][rule] = 'Longitud mínima '+param+' caracteres.';
					break;
				case 'max':
					this.errors.descriptions[field][rule] = 'Longitud máxima '+param+' caracteres.';
					break;
			}
		},
		fieldErrorRemover(field, rule) {
			let i = this.errors.errorsInField[field].indexOf(rule);
			this.errors.errorsInField[field].splice(i, 1);
		},
		requiredDescription() {
			return 'Campo obligatorio.';
		},
		minDescription(param = null) {
			return 'Longitud mínima...';
		},
		maxDescription(param = null) {
			return 'Longitud máxima...';
		}
	}
}