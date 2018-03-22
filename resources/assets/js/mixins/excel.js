export default {
	data() {
		return {
		};
	},
	methods: {
		exportExcel() {
            axios({
              url: '/export-excel',
              method: 'POST',
              responseType: 'blob', // important
              data: {
                model:this.options.model, ids:this.filtering.selected
              }
            }).then((response) => {
              const url = window.URL.createObjectURL(new Blob([response.data]));
              const link = document.createElement('a');
              link.href = url;
              link.setAttribute('download', this.options.model+' '+moment().format()+'.xlsx');
              document.body.appendChild(link);
              link.click();
            });
         },
	}
}