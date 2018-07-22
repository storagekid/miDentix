import ModelClass from '../classes/modelClass';

export default {
	data() {
		return {
            // model: new ModelClass('clinics'),
            models: {
            },
            modelsReady: false,
		};
    },
	methods: {
        fetchModels(models) {
            for(let model of models) {
                axios.get('/api/'+model)
                    .then(data => {
                        if (data.data.model) {
                            this.$set(this.models, model, {});
                            let temp = new ModelClass(model);
                            for (let prop in temp) {
                                this.$set(this.models[model], prop, temp[prop]);
                            }
                            this.models[model].items = data.data.model;
                            this.loading = false;
                            window.events.$emit('loaded');
                        }
                        if (Object.keys(this.models).length === models.length) {
                            this.modelsReady = true;
                        }
                    });
            }
          },
        selectModel(model,id) {
            console.log(id);
            if (id == 'null') {
                this.models[model].itemSelected = null;
                this.models[model].idSelected = null;
                return false;
            }
            this.models[model].itemSelected = this.models[model].items.find(item => item.id === id);
        }
	},
}