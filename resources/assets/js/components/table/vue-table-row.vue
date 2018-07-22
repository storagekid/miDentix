<template>
    <tr>
        <td v-if="tableOptions.counterColumn" ref="column-counter-row">
            <span class="glyphicon glyphicon-check" :class="rowsSelected.indexOf(item.id) != -1 ? 'selected' : 'unselected'" @click="toggleSelectedRow(item.id)"></span>
        </td>
        <td v-for="(column, columnIndex) in columns" :key="columnIndex" v-show="column.show" :ref="'column-'+column.name+'-row'" v-bind:style="{width:column.width+'px', whiteSpace:item[column.name] && item[column.name].length > 12 ? 'inherit' : 'nowrap'}">
            <strong v-if="column.parse" v-html="parseArrayItems(itemIndex,column.parse)"></strong>
            <strong v-else-if="column.linebreak" v-html="linebreak(item[column.name],column.linebreak.needles,column.linebreak.options)"></strong>
            <strong v-else-if="column.boolean">{{item[column.object][column.name] ? column.boolean[1] : column.boolean[0]}}</strong>
            <strong v-else-if="column.linkable"><a :href="column.linkable.target + item[column.name]">{{item[column.name]}}</a></strong>
            <strong v-else-if="column.object">{{item[column.object][column.name]}}</strong>
            <strong v-else>{{item[column.name]}}</strong>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['data'],
        data() {
            return {

            }
        }
    }
</script>
