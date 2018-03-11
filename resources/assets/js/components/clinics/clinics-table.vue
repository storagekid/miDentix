<template>
    <div class="panel panel-default">
        <div id="filterColumn" class="col-xs-4 col-xs-offset-4" v-show="filtering.state">
            <div class="row buttons">
                <div class="col-xs-6">
                    <button class="btn btn-sm btn-block btn-info" @click="selectAllFilters">Todos</button>
                </div>
                <div class="col-xs-6">
                    <button class="btn btn-sm btn-block btn-info" @click="invertSelectionFilters">Invertir Selección</button>
                </div>
            </div>
            <ul class="list-group">
                <li v-for="filter in filtering.keys" class="col-xs-6 list-item">
                    <input type="checkbox" name="" @click="toggleFilterItem(filter.keys, filtering.name)" v-model="filter.state"><span v-text="filter.label"></span>
                </li>
            </ul>
            <button class="btn btn-sm btn-block btn-primary" @click="filtering.state=false">Cerrar</button>
        </div>
        <div class="panel-heading text-center">
            <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>Clínicas</h3>
        </div>
        <div class="panel-body">
            <a href="#'">
                <button type="button" class="btn btn-sm btn-info btn-block">
                    <h3>Nueva Clínica</h3>
                </button>
            </a>
            <form class="">
                <table class="table" id="clinics-table">
                    <thead>
                        <tr>
                            <th class="count">{{selectedCount}} 
                                <p>
                                    <span class="glyphicon glyphicon-asterisk" @click="selectAll"></span>
                                    <span class="glyphicon glyphicon-random" @click="invertSelection"></span>
                                </p>
                            </th>
                            <th class="col-xs-12">
                                Clínica
                            </th>
                            <th class="col-xs-12">
                                Ciudad
                                <p>
                                    <span class="glyphicon glyphicon-triangle-bottom" @click="orderColumn('city')"></span>
                                    <span class="glyphicon glyphicon-filter" @click="filterColumn('city')"></span>
                                </p>
                            </th>
                            <th class="col-xs-12">Dir. Real</th>
                            <th class="col-xs-12">Dir. Comercial</th>
                            <th class="col-xs-12">
                                CP
                                <span class="glyphicon glyphicon-triangle-bottom" @click="orderColumn('postal_code')"></span>
                                <span class="glyphicon glyphicon-filter" @click="filterColumn('postal_code')"></span>
                            </th>
                            <th class="col-xs-12 noWrap">Tel. Real</th>
                            <th class="col-xs-12">Tel. Virtual</th>
                            <th class="col-xs-12">Email Ext.</th>
                            <th class="col-xs-12">Código S.</th>
                            <th class="col-xs-12">Provincia</th>
                            <th class="col-xs-12">CCAA</th>
                            <th class="col-xs-12">País</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                          <tr v-for="(clinic, index) in clinics" v-show="checkFilter(clinic.id)">
                            <td>
                                <input type="checkbox" name="" @click="toggleSelected(index)" :checked="selected.indexOf(index) != -1">
                            </td>
                            <td>
                                <strong><span v-html="clinicFullName(index)"></span></strong>
                            </td>
                            <td>
                                <input v-if="editable==clinic.id" type="text" name="city" v-model="clinic.city" class="col-xs-12">
                                <span v-else v-text="clinic.city"></span>
                            </td>
                            <td class="hidden-xs">
                                <input v-if="editable==clinic.id" type="text" name="address_real_1" v-model="clinic.address_real_1" class="col-xs-12">
                                <input v-if="editable==clinic.id" type="text" name="address_real_2" v-model="clinic.address_real_2" class="col-xs-12">
                                <span v-else v-text="clinic.address_real_1 + ' ' + clinic.address_real_2"></span>
                            </td>
                            <td class="hidden-xs">
                                <input v-if="editable==clinic.id" type="text" name="address_adv_1" v-model="clinic.address_adv_1" class="col-xs-12">
                                <input v-if="editable==clinic.id" type="text" name="address_adv_2" v-model="clinic.address_adv_2" class="col-xs-12">
                                <span v-else v-text="clinic.address_adv_1 + ' ' + clinic.address_adv_2"></span>
                            </td>
                            <td>
                                <input v-if="editable==clinic.id" type="text" name="postal_code" v-model="clinic.postal_code" class="col-xs-12">
                                <span v-else v-text="clinic.postal_code"></span>
                            </td>
                            <td class="hidden-xs noWrap">
                                <input v-if="editable==clinic.id" type="text" name="phone_real" v-model="clinic.phone_real" class="col-xs-12">
                                <span v-else v-text="clinic.phone_real"></span>
                            </td>
                            <td class="noWrap">
                                <input v-if="editable==clinic.id" type="text" name="phone_adv" v-model="clinic.phone_adv" class="col-xs-12">
                                <span v-else v-text="clinic.phone_adv"></span>
                            </td>
                            <td>
                                <input v-if="editable==clinic.id" type="text" name="email_ext" v-model="clinic.email_ext" class="col-xs-12">
                                <span v-else v-text="clinic.email_ext"></span>
                            </td>
                            <td>
                                <input v-if="editable==clinic.id" type="text" name="sanitary_code" v-model="clinic.sanitary_code" class="col-xs-12">
                                <span v-else v-text="clinic.sanitary_code"></span>
                            </td>
                            <td>
                                <select v-if="editable==clinic.id" class="col-xs-12" v-model="clinic.provincia_id" @change="provinciaChanged($event, index)">
                                    <option v-for="(provincia, index) in provincias" v-text="provincia.nombre" :value="provincia.id"></option>
                                </select>
                                <span v-else v-text="clinic.provincia.nombre"></span>
                            </td>
                            <td>
                                <input v-if="editable==clinic.id" type="text" name="provincia.state.name" v-model="clinic.provincia.state.name" class="col-xs-12">
                                <span v-else v-text="clinic.provincia.state.name"></span>
                            </td>
                            <td>
                                <input v-if="editable==clinic.id" type="text" name="provincia.state.country.name" v-model="clinic.provincia.state.country.name" class="col-xs-12">
                                <span v-else v-text="clinic.provincia.state.country.name"></span>
                            </td>
                            <td class="buttons">
                                <button v-if="editable==''" type="button" class="btn btn-warning" @click="makeEditable(clinic, index)">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </button>
                                <button v-if="editable==clinic.id" type="button" class="btn btn-success" @click="update(index)">
                                    <span class="glyphicon glyphicon-ok"></span>
                                </button>
                                <button v-if="editable==clinic.id" type="button" class="btn btn-danger" @click="cancelEditable(index)">
                                    <span class="glyphicon glyphicon-ban-circle"></span>
                                </button>
                                <button v-if="editable==''" type="button" class="btn btn-danger" @click="remove(clinic.id)">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
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
            selectAllFilters() {
                if (this.clinics.length == this.filtering.selected.length) {
                    this.filtering.selected = [];
                    for (var i = 0; i < this.filtering.keys.length; i++) {
                        this.filtering.keys[i].state = false;
                    }
                    return;
                }
                for (var i = 0; i < this.clinics.length; i++) {
                    if (this.filtering.selected.indexOf(this.clinics[i].id) == -1) {
                        this.filtering.selected.push(this.clinics[i].id);
                    }
                }
                for (var i = 0; i < this.filtering.keys.length; i++) {
                    this.filtering.keys[i].state = true;
                }
            },
            invertSelectionFilters() {
                var selected = '';
                for (var i = 0; i < this.clinics.length; i++) {
                    if (this.filtering.selected.indexOf(this.clinics[i].id) == -1) {
                        this.filtering.selected.push(this.clinics[i].id);
                        selected = true;
                    } else {
                        this.filtering.selected.splice(this.filtering.selected.indexOf(this.clinics[i].id),1);
                        selected = false;
                    }
                    // var cleanName = cleanUpSpecialChars(this.clinics[i][name].toLowerCase());
                    for (var o = 0; o < this.filtering.keys.length; o++) {
                        if (this.filtering.keys[o].keys.indexOf(this.clinics[i].id) != -1) {
                            this.filtering.keys[o].state = selected;
                        }
                    }
                }
            },
            filterColumn(name) {
                if (this.filtering.name != name) {
                    this.filtering.name = name;
                    this.filtering.keys = [];
                    this.filtering.state = true;
                    var labels = [];
                    var keys =[];
                    for (var i = 0; i < this.clinics.length; i++) {
                        var cleanName = cleanUpSpecialChars(this.clinics[i][name].toLowerCase());
                        var id = this.clinics[i].id;
                        // var clinicObject = {keys: key};
                        if (labels.indexOf(cleanName) == -1) {
                            labels.push(cleanName);
                            var key = {label: cleanName, keys: [id], state: 'checked'};
                            keys.push(key);
                        } else {
                            for (var o = 0; o < keys.length; o++) {
                                if (keys[o].label == cleanName) {
                                    keys[o].keys.push(id);
                                }
                            }
                        }
                    }
                    this.filtering.keys = keys;
                    // this.filtering.keys.sort();
                } else {
                    this.filtering.state = true;
                }
            },
            checkFilter(id) {
                return this.filtering.selected.indexOf(id) == -1 ? false : true;
            },
            toggleFilterItem(ids, name) {
                if (ids.length > 1) {
                    for (var i = 0; i < ids.length; i++) {
                        if (this.filtering.selected.indexOf(ids[i]) == -1) {
                            this.filtering.selected.push(ids[i]);
                        } else {
                            this.filtering.selected.splice(this.filtering.selected.indexOf(ids[i]),1);
                        }
                    }
                } else {
                    if (this.filtering.selected.indexOf(ids[0]) == -1) {
                        this.filtering.selected.push(ids[0]);
                    } else {
                        this.filtering.selected.splice(this.filtering.selected.indexOf(ids[0]),1);
                    }
                }
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
            clinicFullName(index) {
                var clinic = this.clinics[index];
                return clinic.city + ' <br><small>(' + clinic.address_real_1 + ' ' + clinic.address_real_2 + ')</small>';
            }
        },
        computed: {
            selectedCount() {
                return this.selected.length;
            },
        },
        created() {
            window.events.$on('provinciaUpdated', this.changename);
            for (var i = 0; i < this.clinics.length; i++) {
                this.filtering.selected.push(this.clinics[i].id);
            }
        },
    }
</script>
<style type="text/css">
    #filterColumn {
        position: absolute;
        margin-top: 50px;
        padding: 20px;
        background: rgba(255,255,255,0.95);
        z-index: 10;
        border: 1px solid #753470;
    }
    #filterColumn ul {
        margin: 20px 0;
        padding: 20px;
        max-height: 70vh;
        overflow: auto;
    }
    #filterColumn ul li {
        list-style: none;
        font-weight: bolder;
    }
    form {
        overflow: auto;
        height: 80vh;
    }
    table {
        font-size: 0.9em;
    }
    table th.count {
/*        min-width: 3vw;
*/    }
    table td.buttons {
        width: 100px;
        display: block;
    }
    #clinics-table > tbody > tr > td {
        line-height: 1.1;
    }
    table td input.col-xs-12 {
        padding: 0;
    }
    table td.noWrap {
        white-space: nowrap;
    }
</style>