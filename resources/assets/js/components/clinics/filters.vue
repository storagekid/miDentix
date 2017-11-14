<template>
    <div id="filterColumn" v-show="filtering.state">
        <ul class="list-group" @close-filters"filtering.state = false">
            <li v-for="filter in filtering.keys" class="col-xs-6 list-item">
                <input type="checkbox" name="" @click="toggleFilterItem(filter, filtering.name)"><span v-text="filter"></span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['data','provincias-src'],
        data() {
            return {
                clinics: this.data,
                provincias: this.provinciasSrc,
                selected: [],
                editable: '',
                options: this.$refs,
                clinicIndex: '',
                oldClinic: '',
                lastOrder: {
                    name: '',
                    keys: [],
                    type: 'desc',
                },
                filtering: {
                    name: '',
                    state: false,
                    keys: [],
                    selected: [],
                    backup: [],
                }
            }
        },
        watch: {

        },
        methods: {
            selectAll() {
                if (this.clinics.length == this.selected.length) {
                    this.selected = [];
                    return;
                }
                for (var i = 0; i < this.clinics.length; i++) {
                    if (this.selected.indexOf(i) == -1) {
                        this.selected.push(i);
                    }
                }
            },
            invertSelection() {
                for (var i = 0; i < this.clinics.length; i++) {
                    if (this.selected.indexOf(i) == -1) {
                        this.selected.push(i);
                    } else {
                        this.selected.splice(this.selected.indexOf(i),1);
                    }
                }
            },
            filterColumn(name) {
                if (this.filtering.name != name) {
                    this.filtering.name = name;
                    this.filtering.keys = [];
                    this.filtering.state = true;
                    for (var i = 0; i < this.clinics.length; i++) {
                        var cleanName = cleanUpSpecialChars(this.clinics[i][name].toLowerCase());
                        if (this.filtering.keys.indexOf(cleanName) == -1) {
                            this.filtering.keys.push(cleanName);
                        }
                    }
                    this.filtering.keys.sort();
                } else {
                    this.filtering.state = true;
                }
            },
            toggleFilterItem(index, name) {
                if (this.filtering.selected.indexOf(index) == -1) {
                    this.filtering.selected.push(index);
                } else {
                    this.filtering.selected.splice(this.filtering.selected.indexOf(index),1);
                }
                this.filterClinics(name);
            },
            filterClinics(name) {
                var filteredClinics = [];
                for (var i = 0; i < this.filtering.selected.length; i++) {
                    for (var o = 0; o < this.clinics.length; o++) {
                        var cleanName = cleanUpSpecialChars(this.clinics[o][name].toLowerCase());
                        // console.log('clinic: '+cleanName);
                        // console.log('key: '+this.filtering.selected[i]);
                        if (cleanName == this.filtering.selected[i]) {
                            // console.log('Found: '+cleanName+'-'+this.filtering.selected[i]); 
                            filteredClinics.push(this.clinics[o]);
                            this.clinics.splice(o,1);
                            // break;
                        } 
                    }
                }
                console.log(filteredClinics);
                this.clinics = filteredClinics;
            },
            orderColumn(name) {
                if (this.lastOrder.name != name) {
                    this.lastOrder.name = name;
                    this.lastOrder.keys = [];
                    this.lastOrder.type = 'desc';
                    for (var i = 0; i < this.clinics.length; i++) {
                        this.lastOrder.keys.push(cleanUpSpecialChars(this.clinics[i][name].toLowerCase()));
                    }
                    this.lastOrder.keys.sort();
                } else {
                    if (this.lastOrder.type == 'desc') {
                        this.lastOrder.type = 'asc'
                        this.lastOrder.keys.reverse();
                    } else {
                        this.lastOrder.type = 'desc';
                        this.lastOrder.keys.sort();
                    }
                }
                // console.log(this.lastOrder.keys.length);
                // console.log(this.clinics.length);
                // Ordering the clinics array
                var orderedClinics = [];
                for (var i = 0; i < this.lastOrder.keys.length; i++) {
                    for (var o = 0; o < this.clinics.length; o++) {
                        var cleanName = cleanUpSpecialChars(this.clinics[o][name].toLowerCase());
                        // console.log('clinic: '+cleanName);
                        // console.log('key: '+this.lastOrder.keys[i]);
                        if (cleanName == this.lastOrder.keys[i]) {
                            // console.log('Found: '+cleanName+'-'+this.lastOrder.keys[i]); 
                            orderedClinics.push(this.clinics[o]);
                            this.clinics.splice(o,1);
                            break;
                        } 
                    }
                }
                this.clinics = orderedClinics;
            },
            toggleSelected(index) {
                if (this.selected.indexOf(index) == -1) {
                    this.selected.push(index);
                } else {
                    this.selected.splice(this.selected.indexOf(index),1);
                }
            },
            makeEditable(clinic, index) {
                this.editable = clinic.id;
                this.oldClinic = Object.assign({},clinic);
                this.oldClinic.provincia = Object.assign({},clinic.provincia);
                this.oldClinic.provincia.state = Object.assign({},clinic.provincia.state);
                window.flash('Estas en modo edición');
            },
            cancelEditable(index) {
                console.log(index);
                this.editable = '';
                this.clinics[index] = this.oldClinic;
                this.oldClinic = '';
                window.flash('Edición cancelada');
            },
            provinciaChanged(event, clinicIndex) {
                this.clinicIndex = clinicIndex;
                window.events.$emit('provinciaUpdated',event);
            },
            changename(event) {
                this.clinics[this.clinicIndex].provincia_id = event.target.value;
                this.clinics[this.clinicIndex].provincia.state.name = this.provincias[event.target.selectedIndex].state.name;
            },
            update(index) {
                var updateData = {};
                for (var data in this.clinics[index]) {
                    if (
                        this.clinics[index][data] != this.oldClinic[data]
                        && typeof this.clinics[index][data] !== 'object'
                        ) {
                        updateData[data] = this.clinics[index][data];
                    }
                }
                if (Object.keys(updateData).length == 0) {
                    window.flash('Nada que actualizar');
                    return;
                }

                axios.patch('/clinics/'+this.clinics[index].id, {
                    updateData
                }).then(response => {
                    console.log(response);
                    if (response.status == 200) {
                        window.flash('Clínica actualizada con éxito.');
                        this.editable = '';
                    }
                });

                // this.editing = false;
                // this.editButtonText = 'Edit Reply';
                // flash('The reply has been updated!!')
            },
        },
        computed: {
            selectedCount() {
                return this.selected.length;
            }
        },
        created() {
            window.events.$on('provinciaUpdated', this.changename);
        },
    }
</script>
<style type="text/css">
    #filterColumn {
        position: absolute;
        width: 100%;
    }
    #filterColumn ul {
        position: relative;
        display: block;
        margin: 50px auto 0 auto;
        padding: 20px;
        width: 30%;
        max-height: 80vh;
        background: rgba(255,255,255,0.95);
        z-index: 10;
        border: 1px solid #753470;
        overflow: auto;
    }
/*    #filterColumn ul li:nth-child(even) {
        background-color: #eee;
    }*/
    #filterColumn ul li {
        list-style: none;
        font-weight: bolder;
    }
    form {
        overflow: auto;
        height: 80vh;
    }
    table th.count {
        min-width: 5vw;
    }
    table th.buttons {
        min-width: 4vw;
    }
    table td input.col-xs-12 {
        padding: 0;
    }
    table td.noWrap {
        white-space: nowrap;
    }
</style>