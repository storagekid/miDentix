<template>
    <div id="filterColumn" class="col-xs-4 col-xs-offset-4" v-show="filtering.state">
        <div class="row buttons" v-if="!filtering.date.state && filtering.showOptions">
            <div class="col-xs-6">
                <button class="btn btn-sm btn-block btn-info" @click="selectAllFilters">Todos</button>
            </div>
            <div class="col-xs-6">
                <button class="btn btn-sm btn-block btn-info" @click="invertSelectionFilters">Invertir Selección</button>
            </div>
        </div>
        <div class="row dates" v-if="filtering.date.state">
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
        <div class="row dates" v-if="filtering.search.state">
          <form @submit.prevent="">
            <div class="col-xs-12 form-group">
              <label for="search">Buscar:</label>
              <input class="form-control" type="text" name="search" v-model="filtering.search.string" @keyup="searchString">
            </div>
          </form>
        </div>
        <ul class="list-group" v-if="!filtering.date.state && filtering.state && filtering.showOptions">
            <li v-for="filter in filtering.filters[filtering.name].keys" class="col-xs-6 list-item">
                <input type="checkbox" name="" @click="toggleFilterItem(filter.keys, filter.state, filtering.name)" v-model="filter.state"><span v-text="filter.label"></span>
            </li>
        </ul>
        <button class="btn btn-sm btn-block btn-info" @click="toggleFiltering">Cerrar</button>
    </div>
</template>

<script>
    export default {
        props: [],
        data() {
            return {
            }
        },
        methods: {
        },
        created() {
        },
        mounted() {
        }
    }
</script>
