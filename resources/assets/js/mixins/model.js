export default {
	data() {
		return {
			model: {
                name: 'clinics',
                items: null,
                state: null,
                creating: {
                	state: false,
                },
                updating: {
                	state: false,
                },
                destroying: {
                	state: false,
                }
            },
		};
	},
	methods: {
	},
}