class ShoppingCartCategory {
    /**
     * Create a new Form instance.
     *
     * @param {string} name
     */
    constructor({name, model, headerText, itemKey=null}) {
        this.name = name ? name : 'Dummy';
        this.model = model ? model : 'dummieModel',
        this.shoppingCartHeaderText = headerText ? headerText : this.name + ' en pedido',
        this.shoppingCartItemKey = itemKey ? itemKey : 'id',
        this.ids = [];
        // Set default Options if none passed
        // if (!options) {
        //     this.options = this.defaultOptions(this.name);
        // } else {
        //     this.options = options;
        // }
    }
    // Default Options Setter
    defaultOptions(name=null) {
        return {
            // model: name ? name : 'dummieModel',
            // shoppingCartHeaderText: name + ' en pedido',
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
}

export default ShoppingCartCategory;