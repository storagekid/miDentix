<template>
    <div class="col-xs-12" style="margin-top: 20px" id="requests-graphs">
      <div class="panel panel-default">
        <div class="panel-heading text-center">
          <h3 class="panel-title">Evolución Solicitudes</h3>
        </div>
        <div class="panel-body">
          <h4 class="panel-title text-center">
            <a class="col-xs-12" style="margin-bottom: 10px" @click="toggleFilters">
              <span :class="filtersButtonClasses"></span>Filtros
            </a>
          </h4>
          <div class="panel-body" style="padding: 0" v-show="filters.show">
            <form class="form-inline">
              <div class="form-group col-xs-6 col-sm-3">
                <label for="exampleInputName2">Tramo</label>
                <p>Desde: <input type="date" name="start-date"></p>
                <p>Hasta: <input type="date" name="end-date"></p>
              </div>
              <div class="form-group col-xs-6 col-sm-3">
                <label for="exampleInputName2">CCAA</label>
                <p>
                  <select class="form-control">
                    <option value="" selected="">Todas</option>
                    <option value="">Comunidad 1</option>
                    <option value="">Comunidad 1</option>
                    <option value="">Comunidad 1</option>
                    <option value="">Comunidad 1</option>
                    <option value="">Comunidad 1</option>
                    <option value="">Comunidad 1</option>
                    <option value="">Comunidad 1</option>
                    <option value="">Comunidad 1</option>
                    <option value="">Comunidad 1</option>
                  </select>
                </p>
              </div>
              <div class="form-group col-xs-6 col-sm-3">
                <label for="exampleInputName2">Provincia</label>
                <p>
                  <select class="form-control">
                    <option value="" selected="">Todas</option>
                    <option value="">Provincia 1</option>
                    <option value="">Provincia 1</option>
                    <option value="">Provincia 1</option>
                    <option value="">Provincia 1</option>
                    <option value="">Provincia 1</option>
                    <option value="">Provincia 1</option>
                    <option value="">Provincia 1</option>
                    <option value="">Provincia 1</option>
                    <option value="">Provincia 1</option>
                  </select>
                </p>
              </div>
              <div class="col-xs-6 col-sm-3">
                <label for="exampleInputName2">Estado</label>
                  <p><input type="checkbox" checked=""> Resueltas</p>
                  <p><input type="checkbox" checked=""> Pendientes</p>
              </div>
            </form>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-4">
              <canvas ref="graphLine" height="150"></canvas>
            </div>
            <div class="col-xs-12 col-sm-4">
              <canvas id="graph-pie" height="150"></canvas>
            </div>
            <div class="col-xs-12 col-sm-4">
              <canvas id="graph-bar" height="150"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    // import Chart from 'chart.js';
    import * as moment from 'moment';
    import 'moment/locale/es';
    export default {
        props: [
        ],
        data() {
            return {
              filters: {
                show: false,
              },
              requests: {},
              requestByYear: {},
              requestByState: {
                pendientes: 0,
                resueltas: 0,
              },
              requestByType: {},
              labels: [],
            }
        },
        watch: {
        },
        methods: {
          requestNumberGraph() {
            var options = [];
            var colors = {
              main: '#753470',
              main10: '#f1eaf0',
              mainO10: 'rgba(117,52,112,.1)',
              mainO25: 'rgba(117,52,112,.25)',
              mainO35: 'rgba(117,52,112,.35)',
              mainO50: 'rgba(117,52,112,.5)',
              mainO65: 'rgba(117,52,112,.65)',
              mainO85: 'rgba(117,52,112,.85)'
            };
            let labels = [];
            // console.log(this.requestByYear);
            for (let year in this.requestByYear) {
              console.log(this.requestByYear[year]);
              for (let month in this.requestByYear[year]) {
                this.labels.push(this.requestByYear[year][month].name);
                console.log(month);
              }
            }
            // console.log(labels);
            var contextLine = this.$refs.graphLine.getContext('2d');
            var data = {
              labels: ['Enero','Febrero','Marzo','Abril'],
              datasets: [
                {
                  data: [20, 50,122,90],
                  label: "Nº de Solicitudes",
                  backgroundColor: colors.mainO10,
                  borderColor: colors.main,
                }
              ],
            };
            var myLineChart = new Chart(contextLine, {
                type: 'line',
                data: data,
                options: options
            });
          },
          toggleFilters() {
            if (this.filters.show) {
              this.filters.show = false;
            } else {
              this.filters.show = true;
            }
          },
          splitByYear() {
            for (let request of this.requests) {
              // console.log(moment(request.created_at).format('YYYY'));
              // console.log(moment(request.created_at).format('MM'));
              let year = moment(request.created_at).format('YYYY');
              let month = moment(request.created_at).format('MM');
              let monthName = moment(request.created_at).format('MMMM');

              if (!this.requestByYear[year]) {
                this.requestByYear[year] = {};
              }
              if (!this.requestByYear[year][month]) {
                this.requestByYear[year][month] = {};
                this.requestByYear[year][month].name = monthName;
              }
              if (!request.closed_at) {
                this.requestByState['pendientes']++;
                if (!this.requestByYear[year][month]['pendientes']) {
                  this.requestByYear[year][month]['pendientes'] = [];
                }
                this.requestByYear[year][month]['pendientes'].push(request.id);
              } else {
                this.requestByState['resueltas']++;
                if (!this.requestByYear[year][month]['resueltas']) {
                  this.requestByYear[year][month]['resueltas'] = [];
                }
                this.requestByYear[year][month]['resueltas'].push(request.id);
              }
              if (!this.requestByType[request.type]) {
                this.requestByType[request.type] = [];
              }
              this.requestByType[request.type].push(request.id);
            }
            for (let year in this.requestByYear) {
              let temp = {};
              let org = this.requestByYear[year];
              Object.keys(org).sort().forEach(function(key) {
                temp[key] = org[key];
              });
              this.requestByYear[year] = temp;
            }
            // console.log(org);
            // console.log(temp);
          },
          fetchProfile() {
            axios.get('/api/requests')
              .then(data => {
                this.profileSrc = data.data.profile;
                this.types = data.data.types;
                this.details = data.data.details;
                this.labs = data.data.labs;
                if (data.data.requests) {
                  this.requests = data.data.requests;
                  this.splitByYear();
                }
                this.requestNumberGraph();
                this.$emit('ready');
              });
          },
        },
        computed: {
          filtersButtonClasses() {
            if (this.filters.show) {
              return 'glyphicon glyphicon-triangle-bottom';
            }
            return 'glyphicon glyphicon-triangle-top'
          }
        },
        created() {
          moment.locale('es');
          // this.requestNumberGraph();
        },
        mounted() {
          this.fetchProfile();
          // console.log(this.$refs.graphLine);
          // console.log(this.requestByYear);
        }
    }
</script>
<style type="text/css">
</style>