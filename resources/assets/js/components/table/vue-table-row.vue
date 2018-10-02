<template>
    <tr
        :ref="model+item.id" 
        :id="model+item.id"
        v-show="checkFilter(item.id)" 
        :class="[rowsSelected.indexOf(item.id) != -1 ? 'selected' : '', animationClassesGetter(item.id)]"           
        @click="toggleSelectedRow(item.id)">
        <td v-if="options.counterColumn" ref="column-counter-row">
        <span class="glyphicon glyphicon-check" :class="rowsSelected.indexOf(item.id) != -1 ? 'selected' : 'unselected'" @click="toggleSelectedRow(item.id)"></span>
        </td>
        <td v-for="(column, columnIndex) in columns" :key="columnIndex" v-show="column.show" :ref="'column-'+column.name+'-row'" v-bind:style="{width:column.width+'px', whiteSpace:item[column.name] && item[column.name].length > 12 ? 'inherit' : 'nowrap'}">
        <strong v-if="column.parse" v-html="parseArrayItems(itemIndex,column.name)"></strong>
        <strong v-else-if="column.linebreak" v-html="linebreak(item[column.name],column.linebreak.needles,column.linebreak.options)"></strong>
        <strong v-else-if="column.boolean">{{item[column.name] ? column.boolean[0] : column.boolean[1]}}</strong>
        <strong v-else-if="column.linkable"><a :href="column.linkable.target + item[column.name]">{{item[column.name]}}</a></strong>
        <strong v-else-if="column.object">{{item[column.object][column.name]}}</strong>
        <strong v-else>{{item[column.name]}}</strong>
        </td>
    </tr>
</template>

<script>
    import tableFiltering from "../../mixins/table-filtering.js";
    export default {
        mixins: [tableFiltering],
        props: ['item', 'columns', 'model', 'options'],
        data() {
            return {
                rowsSelected: [],
            }
        },
        methods: {
            animationClassesGetter(id) {
                return {
                    "glitter-dentix":
                    this.animationClasses["glitter-dentix"].indexOf(id) != -1
                };
            },
            toggleSelectedRow(index) {
                if (this.rowsSelected.indexOf(index) == -1) {
                    this.rowsSelected.push(index);
                } else {
                    this.rowsSelected.splice(this.rowsSelected.indexOf(index), 1);
                }
            },
        },
        computed: {
            animationClasses() {
                return this.$store.state.Model.animationClasses;
            },
        }
    }
</script>
