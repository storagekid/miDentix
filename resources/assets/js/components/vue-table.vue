<template>
  <div class="custom-table">
    <div :class="panelClass">
      <div id="filters-info-header" class="row" v-if="Object.keys(filtering.filters).length">
        <div id="filters-info-box">
          <div 
            class="alert alert-info menu-button" 
            v-if="Object.keys(this.filtering.filters).length"
            @click.prevent="clearAllFilters"
            >
            <span class="glyphicon glyphicon-remove"></span>
              Eliminar Filtros
          </div>
          <span class="filter-remover-title">Filtros:</span>
          <div class="filter-remover" v-for="(filter, index) in filtering.filters" v-if="filtering.filters[index].active">
            <span class="glyphicon glyphicon-remove" @click="clearFilter(index)"></span>
            {{filter.label}}
          </div>
        </div>
      </div>
      <table 
        class="table table-responsive" 
        v-if="!this.itemSelected"
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
                    <input class="form-control" type="text" name="search" v-model="filtering.search.string" @keyup="searchString">
                  </div>
                </form>
              </div>
              <ul class="" v-if="!filtering.date.state && filtering.state && filtering.showOptions">
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
            <th v-for="(column, index) in columns" :class="column.name" v-show="column.show" :ref="'column-'+column.name+'-header'" v-bind:style="{width:column.width}">
              <div v-if="(column.filtering || column.sortable) && column.name != 'buttons'">
                  <span v-if="column.sorting.active" :class="orderClasses(column.name)" @click="orderColumn(column.name,column.sorting.options)"></span>
                  <span :class="filterClasses(column.name)" @click="toggleFilterMenu($event,column.filtering.key,column.filtering.options,column.label)"></span>
              </div>
              <span class="column-name">{{column.label}}</span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in items" v-show="checkFilter(item.id)" :class="rowsSelected.indexOf(index) != -1 ? 'selected' : ''" @click="toggleSelectedRow(index)">
            <td v-if="tableOptions.counterColumn" ref="column-counter-row">
              <span class="glyphicon glyphicon-check" :class="rowsSelected.indexOf(index) != -1 ? 'selected' : 'unselected'" @click="toggleSelectedRow(index)"></span>
                <!-- <input type="checkbox" name="" :checked="rowsSelected.indexOf(index) != -1" disabled> -->
            </td>
            <td v-for="(column, index) in columns" v-show="column.show" :ref="'column-'+column.name+'-row'" v-bind:style="{width:column.width}">
              <strong v-if="column.parse" v-html="parseArrayItems(index,column.parse)"></strong>
              <strong v-else-if="column.boolean">{{item[column.object][column.name] ? column.boolean[1] : column.boolean[0]}}</strong>
              <strong v-else-if="column.linkable"><a :href="column.linkable.target + item[column.name]">{{item[column.name]}}</a></strong>
              <strong v-else-if="column.name === 'buttons'">
                <span v-for="action in column.buttons" class="table-column-buttons">
                  <button 
                    type="button" 
                    :class="actionBtnClass(action)">
                    <a :href="'/'+tableOptions.model+'/'+item.id">
                    <span :class="actionIconClass(action)">
                    </span>
                    </a>
                  </button>
                </span>
              </strong>
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
    import tableFiltering from '../mixins/table-filtering.js';
    import tableOrdering from '../mixins/table-ordering.js';
    export default {
        components: {},
        mixins: [tableFiltering,tableOrdering],
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
              loading: true,
              profileitems: {
                resolved: 0,
                total: 0,
                barStyle: '',
                barText: '',
                ratio: 0,
              },
              labs: [],
              types: [],
              details: [],
              addRequest: {
                  method: false,
                  topButtonText: 'Nueva Solicitud',
                  topButtonClasses: 'btn btn-sm btn-info',
                  topButtonIcon: 'glyphicon glyphicon-plus-sign',
              },
              showElement: true,
              itemSelected: false,
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
          checkFilteriTemsStatus(filters) {
            console.log(filters);
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
              console.log("Right Click Menu!!!");
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
            if (this.columns[index].show && (this.columns[index].width == '0px')) {
              setTimeout(this.setColumnWidth, 100, index);
            }
          },
          setColumnWidth(index) {
            let columnHeader = 'column-'+this.columns[index].name+'-header';
            let columnRows = 'column-'+this.columns[index].name+'-row';
            let maxWidth = 0;
            console.log('changing single width');
            console.log(columnHeader);
            if (Array.isArray(this.$refs[columnHeader])) {
                console.log('HERE');
                maxWidth = this.$refs[columnHeader][0].clientWidth;
            } else {
              maxWidth = this.$refs[columnHeader].clientWidth;
            }
            console.log('Original: '+maxWidth);
            for (let [index, value] of this.$refs[columnRows].entries()) {
              if (value.clientWidth > maxWidth) {
                maxWidth = value.clientWidth;
              }
            }
            let finalWidth = maxWidth+'px';
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
              let finalWidth = maxWidth+'px';
              this.columns[index].width = finalWidth;
            }
            if (this.options.counterColumn) {
              this.$refs['column-counter-row'][0].style.width = this.$refs['column-counter-header'].clientWidth+'px';
            }
          },
          setElementWidth(element, width) {
            element.style.width = width;
          },
          setMenu(ref, top, left) {
            let largestHeight = window.innerHeight - this.$refs[ref].offsetHeight - 25;
            let largestWidth = window.innerWidth - this.$refs[ref].offsetWidth - 25;

            if (top > largestHeight) top = largestHeight;
            if (left > largestWidth) left = largestWidth;

            this.theadMenu.top = top + 'px';
            this.theadMenu.left = left + 'px';
          },
          tableAction(id,action) {
            switch(action) {
              case 'show':
                axios('/'+this.tableOptions.model+'/'+id);
                break;
            }
          },
          toggleSelectedRow(index) {
              if (this.rowsSelected.indexOf(index) == -1) {
                  this.rowsSelected.push(index);
              } else {
                  this.rowsSelected.splice(this.rowsSelected.indexOf(index),1);
              }
          },
          selectAllRows() {
              if (this.items.length == this.rowsSelected.length) {
                  this.rowsSelected = [];
                  return;
              }
              for (var i = 0; i < this.items.length; i++) {
                  if (this.rowsSelected.indexOf(i) == -1) {
                      this.rowsSelected.push(i);
                  }
              }
          },
          invertRowSelection() {
              for (var i = 0; i < this.items.length; i++) {
                  if (this.rowsSelected.indexOf(i) == -1) {
                      this.rowsSelected.push(i);
                  } else {
                      this.rowsSelected.splice(this.rowsSelected.indexOf(i),1);
                  }
              }
          },
          exportExcel() {
            axios({
              url: '/export-excel',
              method: 'POST',
              responseType: 'blob', // important
              data: {
                model:'Profile', ids:this.filtering.selected
              }
            }).then((response) => {
              const url = window.URL.createObjectURL(new Blob([response.data]));
              const link = document.createElement('a');
              link.href = url;
              link.setAttribute('download', 'usuarios miGabinete '+moment().format()+'.xlsx');
              document.body.appendChild(link);
              link.click();
            });
          },
          startFilters() {
            if (this.filtering.filters['last_access']) {
              delete(this.filtering.filters['last_access']);
            }
            this.buildFilterColumn('last_access',{object:'item',boolean:['Offline','Online']});
            this.filtering.state = false;
            let empty = true;
            for (let item of this.filtering.filters['last_access'].keys) {
              if (item.label == 'Online') {
                // console.log(item.keys);
                empty = false;
                this.toggleFilterItem(item.keys, 'checked', this.filtering.name);
              }
            }
            if (empty) {
              delete(this.filtering.filters['last_access']);
            }
            this.filtering.name = '';
          },
          applyUrlFilters() {
            // Example with Array
            // ?created_at[0]=2017-12-01&created_at[1]=2017-01-01&closed_at=Pendiente
            let search = getAllUrlParams();
            for (let filter in search) {
              search[filter] = search[filter].replace(/%20/g, " ");
              if (filter == 'created_at') {
                this.buildFilterColumn('created_at',{date:true});
                this.filtering.date.end = search['created_at'][0];
                this.filtering.date.start = search['created_at'][1];
                this.filtering.date.state = true;
                this.filterDates('created_at');
                this.filtering.state = false;
              } else {
                this.buildFilterColumn(filter);
                this.filtering.state = false;
                let ids = [];
                for (let item of this.filtering.filters[filter].keys) {
                  let cleanName = cleanUpSpecialChars(item.label.toLowerCase());
                  if (cleanName != search[filter]) {
                    ids = item.keys;
                    // console.log('Search Filter: '+search[filter]);
                    this.toggleFilterItem(ids, 'checked', filter);
                  }
                }
              }
            }
          },
          closeRequest() {
            axios.patch('/items/'+this.showRequest.request.id, {
              'request': this.showRequest.request,
              }).catch((error) => {
                  if (error.response.data.errors) {
                    for (let item in error.response.data.errors) {
                        flash({
                            message: error.response.data.errors[item][0], 
                            label: 'danger'
                        });
                      }
                  }
                  if (error.response.data.message && error.response.status == 400) {
                    return flash({
                          message: error.response.data.message, 
                          label: 'danger'
                      });
                  }
                }).then(response => {
                    if (response.status == 200) {
                      flash({
                          message: 'Solicitud cerrada.', 
                          label: 'success'
                      });
                      this.notifyClosed(this.showRequest.request.id);
                      window.events.$emit('requestClosed');
                      this.toggleShowRequest();
                    }
                });
          },
          notifyClosed(id) {
            for (let request of this.items) {
              if (request.id == id) {
                request.closed_at = moment().format();
                break;
              }
            }
            this.startFilters();
            this.calculateRatio();
          },
          itemEspecialtiesBuilder() {
            for (let item of this.items) {
              let especialties = [];
              let ids = [];
              for (let schedule of item.schedules) {
                for (let especialty of schedule.especialties) {
                  if (ids.indexOf(especialty.id) == -1) {
                    ids.push(especialty.id);
                    especialties.push(especialty);
                  }
                } 
              }
              item.especialties = especialties;
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
          itemCompleteName(index) {
            let lastname2 = this.items[index].lastname2 ? this.items[index].lastname2 : '';
            let fullname = this.items[index].name+' '+this.items[index].lastname1+' '+lastname2;
            return cleanUpSpecialChars(fullname.toLowerCase());
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
                return 'glyphicon glyphicon-remove';
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
          setColumnsStyle() {
            for (let [index, column] of this.columns.entries()) {
              if (!this.columns[index].width) {
                this.columns[index].width = '1px';
                this.columnsWidth.push('1px');
              }
            }
          },
          columnStyle(index) {
            return 'width: '+this.columns[index].width;
          }
        },
        computed: {
          selectedCount() {
            return this.rowsSelected.length;
          },
          itemLicenseCenter() {
            if (this.itemSelected.university_id) {
              return this.itemSelected.university.name;
            }
            if (this.itemSelected.university_id === 0) {
              return "Otro";
            }
            return "-";
          },
          panelClass() {
            if (this.admin) {
              return 'panel-body-admin';
            } else {
              return 'panel-body';
            }
          },
        },
        created() {
          moment.locale('es');
          this.buildFiltering('items');
          this.buildOrdering('items');
          this.selectAllItems();
          // this.setColumnsStyle();
        },
        mounted() {
          this.setColumnsWidth();
        }
    }
</script>
<style type="text/css">

</style>