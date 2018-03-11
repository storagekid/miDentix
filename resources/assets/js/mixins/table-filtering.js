import * as moment from 'moment';
import 'moment/locale/es';
export default {

	data() {
		return {
			filtering: {
			  source: '',
			  filters: {},
			  filtersOrder: [],
			  name: '',
			  state: false,
			  show: false,
			  showOptions: true,
			  date: {
			    state: false,
			    start: null,
			    end: null,
			  },
			  search: {
			    state: false,
			    string: null,
			    target: [],
			  },
			  keys: [],
			  selected: [],
			  backup: [],
			},
		};
	},

	methods: {
		buildFiltering(source) {
			this.filtering.source = source;
		},
		buildFilterColumn(
			name, 
			options={
				object:null,
				nullName: null,
				date:false,
				number:false,
				numeric:false,
				integer:false,
				boolean:false,
				search:false,
				noOptions:false
				},
			columnName) 
			{
			if (options.noOptions) {
	            this.filtering.showOptions = false;
	        }
	        if (options.search) {
	        	// this.selectAllItems();
	            this.filtering.search.state = true;
	            let target = [];
	            if (options.object) {
	            	for (let item of this[this.filtering.source]) {
	            		let id = item.id;
	            		// console.log(id);
		            	if (this.filtering.selected.indexOf(id) != -1) {
		            	    let fullstring = '';
		            	    if (!item[options.object]) {
		            	    	fullstring = options.nullName;
		            	    	// console.log('NullName: '+options.nullName);
		            	    } else {
		            	    	for (let field of options.search) {
		            	    		if (item[options.object][field]) {
		            	    			let temp = item[options.object][field];
		            	    	  		fullstring += temp+' ';
		            	    		}
		            	    	}
		            	    }
	            	    	target.push([id,cleanUpSpecialChars(fullstring.toLowerCase())]);
	            	  	}
	            	}
	            } else {
	            	for (let item of this[this.filtering.source]) {
	            	  if (this.filtering.selected.indexOf(item.id) != -1) {
	            	    let fullstring = '';
	            	    for (let field of options.search) {
	            	      	if (item[field]) {
	            	      		let temp = item[field];
	            	        		fullstring += temp+' ';
	            	      	}
	            	    }
	            	    fullstring = fullstring;
	            	    target.push([item.id,cleanUpSpecialChars(fullstring.toLowerCase())]);
	            	  }
	            	}
	            }
	            this.filtering.search.target = target;
	        }
			if (options.date) {
			    this.filtering.date.state = true;
			} else {
			    this.filtering.date.state = false;
			}
			this.filtering.name = name;
			this.filtering.state = true;

			if (!this.filtering.filters[name]) {
				this.filtering.filters[name] = {};
				this.filtering.filters[name].name = name;
				this.filtering.filters[name].label = columnName;
				this.filtering.filters[name].active = false;
				this.filtering.filters[name].keys = [];
				this.filtering.filters[name].filteredKeys = [];
				this.filtering.filtersOrder.push(name);
				var labels = [];
				var keys =[];
				let cleanName = '';
				let fullName = '';
				let source = this.filtering.source;
				for (var i = 0; i < this[source].length; i++) {
					let base = this[source][i];
					if (options.object) {
						base = base[options.object];
					}
					let keysDone = false;
				  	var id = this[this.filtering.source][i].id;

			      	if (options.number) {
				        fullName = options.number[base[name]];
				        cleanName = cleanUpSpecialChars(fullName.toLowerCase());
			      	} else if (options.numeric) {
				      	fullName = base[name];
				      	cleanName = fullName;
					} else if (options.boolean) {
				      	if (!base || base[name] == null) {
				      		fullName = options.boolean[0];
				      		cleanName = options.boolean[0].toLowerCase();
				      	} else {
				      		fullName = options.boolean[1];
				      		cleanName = options.boolean[1].toLowerCase();
				      	}
		            } else if (Array.isArray(base)) {
		            	keysDone = true;
		            	for (let item of base) {
		            		fullName = item[name];
		            		cleanName = cleanUpSpecialChars(fullName.toLowerCase());
		            		let state = false;
		            		if (labels.indexOf(cleanName) == -1) {
		            		    labels.push(cleanName);
		            		    var key = {label: fullName, keys: [id], state: state};
		            		    keys.push(key);
		            		} else {
		            		  for (var o = 0; o < keys.length; o++) {
		            		    if (keys[o].label == fullName) {
		            		        keys[o].keys.push(id);
		            		    }
		            		  }
		            		}
		            	}
		            } else if (!base || base[name] == null) {
		              cleanName = '-';
		              fullName = options.nullName;
		            } else {
			        	fullName = base[name];
		            	if (options.integer) {
		              		cleanName = fullName;
		            	} else {
		              		cleanName = cleanUpSpecialChars(base[name].toLowerCase());
		            	}
			      	}

		            if (!keysDone) {
		            	let state = false;
		            	if (labels.indexOf(cleanName) == -1) {
		            	    labels.push(cleanName);
		            	    var key = {label: fullName, keys: [id], state: state};
		            	    keys.push(key);
		            	} else {
		            	  for (var o = 0; o < keys.length; o++) {
		            	    if (keys[o].label == fullName) {
		            	        keys[o].keys.push(id);
		            	    }
		            	  }
		            	}
		            }
				}
				this.filtering.filters[name].keys = keys;
				let filters = {};
				filters[name] = this.filtering.filters[name];
				this.checkFilteriTemsStatus(filters);
			}
			this.filtering.state = true;
		},
		checkFilter(id) {
		    return this.filtering.selected.indexOf(id) == -1 ? false : true;
		},
		clearFilter(index) {
			this.$delete(this.filtering.filters,index);
			for (let i in this.filtering.filtersOrder) {
				if (this.filtering.filtersOrder[i] == index) {
					console.log(index);
					this.filtering.filtersOrder.splice(i,1);
				}
			}
		},	
		filterDates(object) {
		  console.log('Start Date: '+moment(this.filtering.date.start).format('x'));
		  console.log('End Date: '+moment(this.filtering.date.end).format('x'));
		  let startDate = moment(this.filtering.date.start).format('x');
		  let endDate = moment(this.filtering.date.end).format('x');
		  for (let date of this.filtering.filters[object].keys) {
		    if (moment(date.label).format('x') > startDate && moment(date.label).format('x') < endDate) {
		      for (let key of date.keys) {
		        if (this.filtering.selected.indexOf(key) == -1) {
		            this.filtering.selected.push(key);
		        } 
		      }
		    } else {
		      for (let key of date.keys) {
		        if (this.filtering.selected.indexOf(key) != -1) {
		            this.filtering.selected.splice(this.filtering.selected.indexOf(key),1);
		        }
		      }
		    }
		  }
		},
		toggleFilterItem(ids, state, name, index) {
		    if (ids.length > 1) {
		        for (var i = 0; i < ids.length; i++) {
		            if (this.filtering.selected.indexOf(ids[i]) == -1 && !state) {
		                this.filtering.selected.push(ids[i]);
		                // this.filtering.filters[this.filtering.name].keys[index].state = 'checked';
		                this.filtering.filters[this.filtering.name].filteredKeys.splice(this.filtering.filters[this.filtering.name].filteredKeys.indexOf(ids[i]),1);
		            } else if (this.filtering.selected.indexOf(ids[i]) != -1 && state) {
		                this.filtering.selected.splice(this.filtering.selected.indexOf(ids[i]),1);
		                // this.filtering.filters[this.filtering.name].keys[index].state = '';
		                this.filtering.filters[this.filtering.name].filteredKeys.push(ids[i]);
		            }
		        }
		    } else {
		        if (this.filtering.selected.indexOf(ids[0]) == -1 && !state) {
		            this.filtering.selected.push(ids[0]);
		            // this.filtering.filters[this.filtering.name].keys[index].state = 'checked';
		            this.filtering.filters[this.filtering.name].filteredKeys.splice(this.filtering.filters[this.filtering.name].filteredKeys.indexOf(ids[0]),1);
		        } else if (this.filtering.selected.indexOf(ids[0]) != -1 && state) {
		            this.filtering.selected.splice(this.filtering.selected.indexOf(ids[0]),1);
		            // this.filtering.filters[this.filtering.name].keys[index].state = '';
		            this.filtering.filters[this.filtering.name].filteredKeys.push(ids[0]);
		        }
		    }
		    this.checkFilterStatus(this.filtering.name);
		},
		checkFilterStatus(filter) {
			if (this.filtering.filters[this.filtering.name].filteredKeys.length) {
				this.filtering.filters[this.filtering.name].active = true; 
			} else {
				this.filtering.filters[this.filtering.name].active = false;
			}
		},
		searchString() {
		  console.log('searching');
		  this.filtering.selected = [];
		  for (let string of this.filtering.search.target) {
		    if (string[1].indexOf(this.filtering.search.string.toLowerCase()) != -1) {
		      this.filtering.selected.push(string[0]);
		    }
		  }
		},
		invertSelectionFilters() {
		    var selected = '';
		    for (var i = 0; i < this[this.filtering.source].length; i++) {
		        if (this.filtering.selected.indexOf(this[this.filtering.source][i].id) == -1) {
		            this.filtering.selected.push(this[this.filtering.source][i].id);
		            selected = true;
		        } else {
		            this.filtering.selected.splice(this.filtering.selected.indexOf(this[this.filtering.source][i].id),1);
		            selected = false;
		        }
		        // var cleanName = cleanUpSpecialChars(this[this.filtering.source][i][name].toLowerCase());
		        for (var o = 0; o < this.filtering.filters[this.filtering.name].keys.length; o++) {
		            if (this.filtering.filters[this.filtering.name].keys[o].keys.indexOf(this[this.filtering.source][i].id) != -1) {
		                this.filtering.filters[this.filtering.name].keys[o].state = selected;
		            }
		        }
		    }
		},
		selectAllItems() {
		  for (var i = 0; i < this[this.filtering.source].length; i++) {
		      if (this.filtering.selected.indexOf(this[this.filtering.source][i].id) == -1) {
		          this.filtering.selected.push(this[this.filtering.source][i].id);
		      }
		  }
		},
		selectAllFilters() {
		    if (this[this.filtering.source].length == this.filtering.selected.length) {
		        this.filtering.selected = [];
		        for (var i = 0; i < this.filtering.filters[this.filtering.name].keys.length; i++) {
		            this.filtering.filters[this.filtering.name].keys[i].state = false;
		        }
		        return;
		    }
		    for (var i = 0; i < this[this.filtering.source].length; i++) {
		        if (this.filtering.selected.indexOf(this[this.filtering.source][i].id) == -1) {
		            this.filtering.selected.push(this[this.filtering.source][i].id);
		        }
		    }
		    for (var i = 0; i < this.filtering.filters[this.filtering.name].keys.length; i++) {
		        this.filtering.filters[this.filtering.name].keys[i].state = true;
		    }
		},
		clearFilters(filter) {
		  for (let item of this.filtering.filters[filter].keys) {
		    for (let key of item.keys) {
		      if (this.filtering.selected.indexOf(key) == -1) {
		        this.filtering.selected.push(key);
		      }
		    }
		  }
		  delete(this.filtering.filters[filter]);
		  if (filter == 'created_at') {
		    this.filtering.date = {};
		  }
		},
		clearAllFilters() {
		  if (this.filtering.state) {
		    flash({
		        message: 'Cierra la ventana para activar el botón', 
		        label: 'warning'
		    });
		    return false;
		  }
		  this.selectAllItems();
		  this.filtering.filters = {};
		},
		toggleFiltering() {
		    if (this[this.filtering.source].length == this.filtering.selected.length) {
			    delete(this.filtering.filters[this.filtering.name]);
				}
			this.resetFiltering();
		},
		resetFiltering() {
			this.filtering.name = '';
			this.filtering.state = false;
			this.filtering.showOptions = true;
			this.filtering.date.state = false;
			this.filtering.date.start = null;
			this.filtering.date.end = null;
			this.filtering.search.state = false;
			// this.filtering.search.string = null;
			// this.filtering.search.target = [];
		},
		filterClasses(object) {
		  if (this.filtering.filters[object]) {
		    if (this.filtering.filters[object].active) {
		    	return 'glyphicon glyphicon-filter selected';
		    }
		  }
		  return 'glyphicon glyphicon-filter';
		},
		startFilters(filters) {
		  if (this.filtering.filters['closed_at']) {
		    delete(this.filtering.filters['closed_at']);
		  }
		  for (let filter in filters) {

		  }
		  this.buildFilterColumn('closed_at',{nullName:'Pendiente',boolean:['Pendiente','Resuelta']},'Estado');
		  this.filtering.state = false;
		  let empty = true;
		  for (let [index,item] of this.filtering.filters['closed_at'].keys.entries()) {
		    if (item.label == 'Resuelta') {
		      // console.log(item.keys);
		      empty = false;
		      this.toggleFilterItem(item.keys, 'checked', this.filtering.name, index);
		    }
		  }
		  if (empty) {
		    delete(this.filtering.filters['closed_at']);
		  }
		  this.filtering.name = '';
		},
	}
}