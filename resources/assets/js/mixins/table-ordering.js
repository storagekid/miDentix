export default {

	data() {
		return {
			lastOrder: {
				source: '',
			    name: '',
			    keys: [],
			    type: 'desc',
			},
		};
	},

	methods: {
		buildOrdering(source) {
			this.lastOrder.source = source;
		},
		orderColumn(name, options={object:null,date:false,order:false,integer:false}) {
			// console.log(source);
		    if (this.lastOrder.name != name) {
		        this.lastOrder.name = name;
		        this.lastOrder.keys = [];
		        for (var i = 0; i < this[this.lastOrder.source].length; i++) {
		          if (options.object) {
		            if (this[this.lastOrder.source][i][options.object][name] == null) {
		              this.lastOrder.keys.push('-');
		            } else {
		              if (options.integer) {
		                this.lastOrder.keys.push(this[this.lastOrder.source][i][options.object][name]);
		              } else {
		                this.lastOrder.keys.push(cleanUpSpecialChars(this[this.lastOrder.source][i][options.object][name].toLowerCase()));
		              }
		            }
		          } else {
		            if (this[this.lastOrder.source][i][name] == null) {
		              this.lastOrder.keys.push('-');
		            } else {
		              if (options.integer) {
		                this.lastOrder.keys.push(this[this.lastOrder.source][i][name]);
		              } else {
		                this.lastOrder.keys.push(cleanUpSpecialChars(this[this.lastOrder.source][i][name].toLowerCase()));
		              }
		            }
		          }
		        }
		        if (options.order) {
		          if (options.order == 'asc') {
		            this.lastOrder.type = 'asc'
		            this.lastOrder.keys.sort();
		          } else {
		            this.lastOrder.keys.sort();
		            this.lastOrder.keys.reverse();
		            this.lastOrder.type = 'desc';
		          }
		        } else {
		          this.lastOrder.keys.sort();
		          this.lastOrder.type = 'asc';
		        }
		    } else {
		        if (this.lastOrder.type == 'desc') {
		            this.lastOrder.type = 'asc'
		            this.lastOrder.keys.sort();
		        } else {
		            this.lastOrder.type = 'desc';
		            this.lastOrder.keys.sort();
		            this.lastOrder.keys.reverse();
		        }
		    }
		    var orderedItems = [];
		    var cleanName = '';
		    for (var i = 0; i < this.lastOrder.keys.length; i++) {
		        for (var o = 0; o < this[this.lastOrder.source].length; o++) {
		          if (options.object) {
		            if (this[this.lastOrder.source][o][options.object][name] == null) {
		              var cleanName = '-';
		            } else {
		              if (options.integer) {
		                var cleanName = this[this.lastOrder.source][o][options.object][name];
		              } else {
		                var cleanName = cleanUpSpecialChars(this[this.lastOrder.source][o][options.object][name].toLowerCase());
		              }            
		            }
		          } else {
		            if (this[this.lastOrder.source][o][name] == null) {
		              var cleanName = '-';
		            } else {
		              if (options.integer) {
		                var cleanName = this[this.lastOrder.source][o][name];
		              } else {
		                var cleanName = cleanUpSpecialChars(this[this.lastOrder.source][o][name].toLowerCase());
		              }     
		            }
		          }
		          if (cleanName == this.lastOrder.keys[i]) {
		              orderedItems.push(this[this.lastOrder.source][o]);
		              this[this.lastOrder.source].splice(o,1);
		              break;
		          } 
		        }
		    }
		    this[this.lastOrder.source] = orderedItems;
		},
		orderClasses(object) {
		  if (this.lastOrder.name == object && this.lastOrder.type == 'asc') {
		    return 'glyphicon glyphicon-triangle-top selected';
		  } else if (this.lastOrder.name == object && this.lastOrder.type == 'desc') {
		    return 'glyphicon glyphicon-triangle-bottom selected';
		  }
		  return 'glyphicon glyphicon-triangle-bottom';
		},
	}
}