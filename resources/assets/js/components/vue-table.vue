<template>
  <div class="custom-table">
    <div :class="panelClass">
      <div id="items-info-header" class="row">
        <span class="table-new-item">
          <button 
            v-if="options.showNew"
            type="button" 
            @click="toggleNew"
            @click.right.prevent="$modal.show('new-clinic')"
            >
            <span class="glyphicon glyphicon-plus">
            </span>
          </button>
        </span>
        <div class="table-header-box-wrapper">
          <div id="items-actions" class="table-header-box">
            <span class="filter-remover-title">Selección:</span>
            <span v-for="action in options.actions" class="table-column-buttons">
              <button 
                type="button" 
                :class="actionBtnClass(action)"
                @click="sendAction(action)"
                :disabled="actionChecker(action)" 
                >
                <span :class="actionIconClass(action)">
                </span>
              </button>
            </span>
          </div>
          <div id="items-filters"  class="table-header-box">
            <span class="filter-remover-title">Filtros:</span>
            <div 
              class="alert alert-info menu-button" 
              v-if="Object.keys(this.filtering.filters).length"
              @click.prevent="clearAllFilters"
              >
              <span class="glyphicon glyphicon-remove"></span>
                Eliminar Filtros
            </div>
            <div class="filter-remover" v-for="(filter, index) in filtering.filters" v-if="filtering.filters[index].active">
              <span class="glyphicon glyphicon-remove" @click="clearFilter(index)"></span>
              {{filter.label}}
            </div>
          </div>
        </div>
      </div>
      <table 
        class="table table-responsive" 
        v-bind:style="{width: tableWidth+'px'}"
        >
        <thead @click.right.prevent="toggleTheadMenu">
          <div id="FilterColumn" ref="theadFilterMenu" tabindex="-2" class="thead-right-click-menu" v-show="filtering.show" v-bind:style="{top:theadMenu.top, left:theadMenu.left}">
              <div class="buttons-row">
                <div class="alert alert-info menu-button" @click="selectAllFilters"><span class="glyphicon glyphicon-asterisk"></span></div>
                <div class="alert alert-info menu-button" @click="invertSelectionFilters"><span class="glyphicon glyphicon-random"></span></div>
                <div class="alert alert-info menu-button" @click="closeFilterMenu(filtering.name)"><span class="glyphicon glyphicon-remove"></span></div>
              </div>
              <hr>
              <div class="searchFilterContainer" v-if="filtering.date.state">
                <form>
                  <div class="col-xs-6 form-group">
                    <label for="start-date">Desde:</label>
                    <input class="form-control" type="date" name="start-date" v-model="filtering.date.start">
                  </div>
                  <div class="col-xs-6 form-group">
                    <label for="end-date">Hasta:</label>
                    <input class="form-control" type="date" name="end-date" v-model="filtering.date.end">
                  </div>
                  <div class="col-xs-12 form-group">
                    <button class="btn btn-sm btn-block btn-primary form-control" @click.prevent="filterDates(filtering.name)">Aplicar</button>
                  </div>
                </form>
              </div>
              <div class="searchFilterContainer" v-if="filtering.search.state">
                <form @submit.prevent="">
                  <div class="col-xs-12 form-group searchFilterBox">
                    <label for="search">Buscar:</label>
                    <input class="form-control" type="text" name="search" v-model="filtering.searches[filtering.name].string" @keyup="searchString">
                  </div>
                </form>
              </div>
              <ul class="" v-if="filtering.state && filtering.showOptions">
                  <li v-for="(filter, index) in filtering.filters[filtering.name].keys" :class="filter.state ? 'selected' : 'unselected'" @click="toggleFilterItem(filter.keys, filter.state, filtering.name, index)">
                    <span :class="menuFilterClasses(filter.state)"></span>
                    {{filter.label}}
                  </li>
              </ul>
          </div>
          <ul class="thead-right-click-menu" ref="theadMenu" tabindex="-1" v-if="theadMenu.show" @blur="toggleTheadMenu" v-bind:style="{top:theadMenu.top, left:theadMenu.left}">
            <li v-for="(column, index) in columns" @click.stop="toggleColumn(index)" :class="column.show ? 'columnSelected' : ''">
              <span class="glyphicon glyphicon-check" :class="column.show ? 'selected' : 'unselected'"></span>
              {{column.label}}
            </li>
          </ul>
          <tr>
            <th v-if="tableOptions.counterColumn" class="count" ref="column-counter-header">
                <div>
                    <span class="glyphicon glyphicon-asterisk" @click="selectAllRows"></span>
                    <span class="glyphicon glyphicon-random" @click="invertRowSelection"></span>
                </div>
                {{selectedCount}}
            </th>
            <th v-for="(column, index) in columns" :class="column.name" v-show="column.show" :ref="'column-'+column.name+'-header'" v-bind:style="{width:column.width+'px'}">
              <div v-if="(column.filtering || column.sortable) && column.name != 'buttons'">
                  <span v-if="column.sorting.active" :class="orderClasses(column.name)" @click="orderColumn(column.name,column.sorting.options)"></span>
                  <span :class="filterClasses(column.label)" @click="toggleFilterMenu($event,column.filtering.key,column.filtering.options,column.label)"></span>
              </div>
              <span class="column-name">{{column.label}}</span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, itemIndex) in items" v-show="checkFilter(item.id)" :class="rowsSelected.indexOf(itemIndex) != -1 ? 'selected' : ''" @click="toggleSelectedRow(itemIndex)">
            <td v-if="tableOptions.counterColumn" ref="column-counter-row">
              <span class="glyphicon glyphicon-check" :class="rowsSelected.indexOf(itemIndex) != -1 ? 'selected' : 'unselected'" @click="toggleSelectedRow(itemIndex)"></span>
            </td>
            <td v-for="(column, columnIndex) in columns" v-show="column.show" :ref="'column-'+column.name+'-row'" v-bind:style="{width:column.width+'px', whiteSpace:item[column.name] && item[column.name].length > 12 ? 'inherit' : 'nowrap'}">
              <strong v-if="column.parse" v-html="parseArrayItems(itemIndex,column.parse)"></strong>
              <strong v-else-if="column.linebreak" v-html="linebreak(item[column.name],column.linebreak.needles,column.linebreak.options)"></strong>
              <strong v-else-if="column.boolean">{{item[column.object][column.name] ? column.boolean[1] : column.boolean[0]}}</strong>
              <strong v-else-if="column.linkable"><a :href="column.linkable.target + item[column.name]">{{item[column.name]}}</a></strong>
              <strong v-else-if="column.object">{{item[column.object][column.name]}}</strong>
              <strong v-else>{{item[column.name]}}</strong>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="panel-footer table-footer">
      <h3>Total: <strong>{{filtering.selected.length}}</strong></h3>
      <button class="btn btn-sm btn-primary" @click.prevent="exportExcel">Exportar Excel</button>
    </div>
  </div>
</template>

<script>
    import * as moment from 'moment';
    import 'moment/locale/es';
    import excel from '../mixins/excel.js';
    import tableFiltering from '../mixins/table-filtering.js';
    import tableOrdering from '../mixins/table-ordering.js';
    export default {
        mixins: [tableFiltering,tableOrdering,excel],
        props: ['tableItems','tableColumns','tableOptions'],
        data() {
            return {
              items: this.tableItems,
              columns: this.tableColumns,
              options: this.tableOptions,
              theadMenu: {
                show: false,
                top: '0px',
                left: '0px'
              },
              rowsSelected: [],
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        watch: {
          'filtering.selected'() {
            if (Object.keys(this.filtering.filters).length) {
              this.checkFilteriTemsStatus(this.filtering.filters);
            }
          }
        },
        methods: {
          toggleNew() {
            // this.$emit('toggleCreateModel');
            this.$modal.show('new-clinic');
          },
          checkFilteriTemsStatus(filters) {
            for (let filter in filters) {
              for (let [index, value] of this.filtering.filters[filter].keys.entries()) {
                if (value.keys.length > 1) {
                  let keysCount = value.keys.length;
                  let selected = 0;
                  for (let [i, key] of value.keys.entries()) {
                    if (this.filtering.selected.indexOf(value.keys[i]) != -1) {
                      selected++;
                    }
                  }
                  if (selected == keysCount) {
                    this.filtering.filters[filter].keys[index].state = 'checked';
                  } else if (selected == 0) {
                    this.filtering.filters[filter].keys[index].state = false;
                  } else {
                    this.filtering.filters[filter].keys[index].state = 'some';
                  }
                } else {
                  if (this.filtering.selected.indexOf(value.keys[0]) == -1) {
                    this.filtering.filters[filter].keys[index].state = false;
                  } else {
                    this.filtering.filters[filter].keys[index].state = 'checked';
                  }
                }
              }
            }
          },
          toggleTheadMenu(e) {
            this.theadMenu.show = !this.theadMenu.show;
            if (this.theadMenu.show) {
              Vue.nextTick(function() {
                this.$refs.theadMenu.focus();
                this.setMenu('theadMenu',e.y, e.x)
                }.bind(this));
                e.preventDefault();
            }
          },
          toggleFilterMenu(e,name,options,columnLabel) {
            if (this.filtering.state) {
                flash({
                    message: 'Cierra la ventana para activar el botón', 
                    label: 'warning'
                });
                return false;
            }
            this.buildFilterColumn(name,options,columnLabel);
            this.filtering.show = true;
            if (this.filtering.show) {
              Vue.nextTick(function() {
                this.$refs.theadFilterMenu.focus();
                this.setMenu('theadFilterMenu',e.y, e.x)
                }.bind(this));
              e.preventDefault();
            }
          },
          closeFilterMenu(filter)  {
            this.filtering.show = false;
            this.checkFilterStatus(filter);
            if (this.filtering.filters[this.filtering.name].active == false) {
              this.$delete(this.filtering.filters,this.filtering.name);          
            }
            this.resetFiltering();
          },
          toggleColumn(index) {
            this.columns[index].show = !this.columns[index].show;
            if (this.columns[index].show && !this.columns[index].width) {
              setTimeout(this.setColumnWidth, 100, index);
            }
          },
          setColumnWidth(index) {
            let columnHeader = 'column-'+this.columns[index].name+'-header';
            let columnRows = 'column-'+this.columns[index].name+'-row';
            let maxWidth = 0;
            if (Array.isArray(this.$refs[columnHeader])) {
                maxWidth = this.$refs[columnHeader][0].clientWidth;
            } else {
              maxWidth = this.$refs[columnHeader].clientWidth;
            }
            for (let [index, value] of this.$refs[columnRows].entries()) {
              if (value.clientWidth > maxWidth) {
                maxWidth = value.clientWidth;
              }
            }
            let finalWidth = maxWidth;
            this.columns[index].width = finalWidth;
          },
          setColumnsWidth() {
            for (let [index, value] of this.columns.entries()) {
              let columnHeader = 'column-'+value.name+'-header';
              let columnRows = 'column-'+value.name+'-row';
              let maxWidth = 0;
              if (Array.isArray(this.$refs[columnHeader])) {
                maxWidth = this.$refs[columnHeader][0].clientWidth;
              } else {
                maxWidth = this.$refs[columnHeader].clientWidth;
              }
              for (let [index, value] of this.$refs[columnRows].entries()) {
                if (value.clientWidth > maxWidth) {
                  maxWidth = value.clientWidth;
                }
              }
              let finalWidth = maxWidth;
              this.columns[index].width = finalWidth;
            }
            if (this.options.counterColumn) {
              this.$refs['column-counter-row'][0].style.width = this.$refs['column-counter-header'].clientWidth+'px';
            }
          },
          setMenu(ref, top, left) {
            let largestHeight = window.innerHeight - this.$refs[ref].offsetHeight - 25;
            let largestWidth = window.innerWidth - this.$refs[ref].offsetWidth - 25;

            if (top > largestHeight) top = largestHeight;
            if (left > largestWidth) left = largestWidth;

            this.theadMenu.top = top + 'px';
            this.theadMenu.left = left + 'px';
          },
          toggleSelectedRow(index) {
              if (this.rowsSelected.indexOf(index) == -1) {
                  this.rowsSelected.push(index);
              } else {
                  this.rowsSelected.splice(this.rowsSelected.indexOf(index),1);
              }
          },
          selectAllRows() {
            if (this.filtering.selected.length == this.rowsSelected.length) {
              this.rowsSelected = [];
              return;
            }
            this.rowsSelected = [];
            for (var i = 0; i < this.items.length; i++) {
                if (this.filtering.selected.indexOf(this.items[i].id) != -1) {
                    this.rowsSelected.push(i);
                }
            }
          },
          invertRowSelection() {
              for (var i = 0; i < this.items.length; i++) {
                if (this.filtering.selected.indexOf(this.items[i].id) != -1) {
                  if (this.rowsSelected.indexOf(i) == -1) {
                      this.rowsSelected.push(i);
                  } else {
                      this.rowsSelected.splice(this.rowsSelected.indexOf(i),1);
                  }
                }
              }
          },
          parseArrayItems(index,[object,string]) {
            if (!this.items[index][object].length) {
              return '-';
            }
            let items = [];
            let glue = '<br>';
            if (string) {glue = ', '}
            for (let item of this.items[index][object]) {
              if (items.indexOf(item.name) == -1) {
                items.push(item.name);
              }
            }
            return items.join(glue);
          },
          actionBtnClass(action) {
            switch(action) {
              case 'show':
                return 'alert alert-info';
                break;
              case 'edit':
                return 'alert alert-warning';
                break;
              case 'delete':
                return 'alert alert-danger';
                break;
              default:
                return 'btn btn-primary btn-sm';
                break;
            }
          },
          actionIconClass(action) {
            switch(action) {
              case 'show':
                return 'glyphicon glyphicon-eye-open';
                break;
              case 'edit':
                return 'glyphicon glyphicon-pencil';
                break;
              case 'delete':
                return 'glyphicon glyphicon-trash';
                break;
              default:
                return 'glyphicon glyphicon-minus';
                break;
            }
          },
          menuFilterClasses(state) {
            switch(state) {
              case 'checked':
                return 'glyphicon glyphicon-check selected';
                break;
              case 'some':
                return 'glyphicon glyphicon-record selected';
                break;
               case false:
                return 'glyphicon glyphicon-unchecked unselected';
                break;
            }
          },
          linebreak(
              string,
              neddles,
              options = {
                small: false,
                removeNeedels: false
              }
            ){
            let parsedString = "";
            let indexes = [];
            let pieces = [];
            for (let neddle of neddles) {
              if (string.indexOf(neddle) != -1) {
                indexes.push(string.indexOf(neddle));
              }
            }
            pieces.push(string.slice(0,indexes[0])+"<br>");
            if (options.small) {
              pieces[0] = pieces[0]+"<small>";
            }
            if (indexes.length == 1) {
              pieces.push(string.slice(indexes[0]));
            }
            else if (indexes.length == 2) {
              pieces.push(string.slice(indexes[0],indexes[1])+"<br>");
              pieces.push(string.slice(indexes[1]));
            }
            else if (indexes.length > 2) {
              for (let i = 1; i < indexes.length; i++) {
                if (i+1 <= indexes.length) {
                  pieces.push(string.slice(i,indexes[i+1])+"<br>")
                }
              }
              pieces.push(string.slice(indexes[indexes.length-1]));
            }
            for (let piece of pieces) {
              parsedString += piece.trim();
            }
            if (options.small) {
              parsedString += "</small>";
            }
            return parsedString;
          },
          actionChecker(action) {
            if ((action == 'show' || action == 'edit') && this.rowsSelected.length == 1) {
              return false;
            } else if (action == 'delete' && this.rowsSelected.length) {
              return false;
            }
            return true;
          },
          sendAction(action) {
            switch(action) {
              case 'show':
                this.toggleShowItem(this.rowsSelected[0]);
                break;
              case 'edit':
                this.toggleEditItem(this.rowsSelected[0]);
                break;
              case 'delete':
                axios.delete('api/'+this.options.model,this.rowsSelected);
            }
          },
        },
        computed: {
          selectedCount() {
            return this.rowsSelected.length;
          },
          panelClass() {
            if (this.admin) {
              return 'panel-body-admin';
            } else {
              return 'panel-body';
            }
          },
          tableWidth() {
            let totalWidth = 0;
            for (let column of this.columns) {
              if (column.show) {
                totalWidth += column.width;
              }
            }
            return totalWidth;
          }
        },
        created() {
          moment.locale('es');
          this.buildFiltering('items');
          this.buildOrdering('items');
          this.selectAllItems();
        },
        mounted() {
          this.setColumnsWidth();
        }
    }
</script>
<style type="text/css">

</style>