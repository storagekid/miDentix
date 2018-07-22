class Table {
    /**
     * Create a new Form instance.
     *
     * @param {string} name
     */
    constructor({name, options, columns}) {
        this.name = name ? name : 'Dummy';
        // Set default Options if none passed
        if (!options) {
            this.options = this.defaultOptions(this.name);
        } else {
            this.options = options;
        }
        // set One Dummy Column if none passed
        if (!columns) {
            this.columns = [this.dummyColumn()];
        } else {
            this.columns = columns;
        }
        this.filtering = this.tableFiltering();
    }
    // Default Options Setter
    defaultOptions(name=null) {
        return {
            model: name ? name : 'dummies',
            counterColumn: true,
            actions: ['show','edit','delete'],
            showNew: true,
        };
    };
    // Column Constructor
    columnSetter(name, label=null, show=true, linebreak=false, parse=false, boolean=false, linkable=false, object=false, sorting=null, filtering=null)  {
        return {
                name: name,
                label: label ? label : 'Ejemplo',
                show: show,
                linebreak: linebreak ? linebreak : this.lineBreakSetter(),
                parse: parse,
                boolean: boolean,
                linkable: linkable,
                object: object,
                sorting: sorting ? sorting : this.sortingSetter(),
                filtering: filtering ? filtering : this.columnFilteringSetter(),
                width:'',
            };
    }
    // Default Sorting Constructor
    sortingSetter() {
        return {
            active: true,
        };
    }
    // Default Filtering Constructor
    columnFilteringSetter() {
        return {
            active: true,
            key:'dummy',
            options: {
                search:['dummy'],
                noOptions:true
            } 
        };
    }
    // Default LineBreaker Options contructor
    lineBreakSetter() {
        return {
            needles: ['(','esq.'],
            options: {
                small: true
            }
        }
    }
    // Dummy Column Constructor
    dummyColumn()  {
        return [this.columnSetter('Dummy')];
    }

    // Table Filtering data Constructor
    tableFiltering() {
        return {
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
            searches: {},
            keys: [],
            selected: [],
            backup: [],
		};
    }
}

export default Table;