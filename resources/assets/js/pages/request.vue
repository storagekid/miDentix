<template>
  <div id="requests-info-box">
    <div class="panel panel-default">
      <div class="panel-heading text-center">
        <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>  Mis Solicitudes</h3>
      </div>
      <div class="panel-body">
        <a href="#" 
          class="text-center" 
          style="display: inherit;" 
          v-if="!showRequest.method"
          @click.prevent="toggleAddRequest">
          <button type="button" :class="addRequest.topButtonClasses">
            <h3><span :class="addRequest.topButtonIcon"></span>{{addRequest.topButtonText}}</h3>
          </button>
        </a>
        <new-request
          :newRequest="addRequest.method"
          :clinics="profileSrc.clinics"
          :types="types" 
          :details="details"
          :labs="labs"
          :profileId="profileSrc.id"
          :request="showRequest.request"
          @added="notifyAdded"
          v-if="addRequest.method || showRequest.method"
          >
        </new-request>
        <table 
          class="table table-responsive" 
          v-if="!addRequest.method && !showRequest.method"
          >
          <thead>
            <tr>
              <th class="clinic">Clínica</th>
              <th class="hidden-xs">Tipo</th>
              <th>Detalle</th>
              <th class="hidden-xs">Fecha</th>
              <th class="hidden-xs">Texto</th>
              <th class="icons">Estado</th>
              <th class="buttons-text icons"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="request in profileSrc.requests">
              <td><strong>{{request.clinic.city}}</strong><br>({{request.clinic.address_real_1}})</td>
              <td>{{request.type}}</td>
              <td class="hidden-xs">{{request.type_detail1 ? request.type_detail1 : '-'}}</td>
              <td class="hidden-xs" v-text="requestDate(request.created_at)"></td>
              <td class="hidden-xs">{{request.description.substring(0,50)+'...'}}
              </td>
              <td>
                <div :class="requestClasses(request.closed_at)">
                  <span class="hidden-xs" v-text="requestText(request.closed_at)">
                  </span>
                  <span :class="requestIcon(request.closed_at)"></span>
                </div>
              </td>
              <td>
                <button 
                  type="button" 
                  class="btn btn-primary"
                  @click="toggleShowRequest(request)"
                  >
                  <span class="hidden-xs">Detalles
                  </span>
                  <span class="glyphicon glyphicon-arrow-right visible-xs-block"></span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <button 
          type="submit" 
          class="btn btn-sm btn-info btn-block" 
          v-if="showRequest.method"
          @click.prevent="toggleShowRequest"
          ><h4>Volver</h4>
        </button>
      </div>
      <div class="panel-footer">
        <div class="progress">
          <div class="progress-bar progress-bar-primary progress-bar-striped" :style="profileRequests.barStyle">
            <span>{{profileRequests.barText}}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import * as moment from 'moment';
    import 'moment/locale/es';
    export default {
        components: {},
        props: [],
        data() {
            return {
              showRequest: {
                method: false,
                request: {},
              },
              profileSrc: {},
              profileRequests: {
                resolved: 0,
                total: 0,
                barStyle: '',
                barText: '',
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
            }
        },
        watch: {
        },
        methods: {
          toggleShowRequest(request) {
            if (this.showRequest.method) {
              this.showRequest.method = false;
              this.showRequest.request = {};
            } else {
              this.showRequest.request = request;
              this.showRequest.method = true;
            }
          },
          toggleAddRequest() {
            if (!this.addRequest.method) {
              this.addRequest.method = true;
              this.addRequest.topButtonText = 'Cancelar';
              this.addRequest.topButtonClasses = 'btn btn-sm btn-danger';
              this.addRequest.topButtonIcon = 'glyphicon glyphicon-remove';
            } else {
              this.addRequest.method = false;
              this.addRequest.topButtonText = 'Nueva Solicitud';
              this.addRequest.topButtonClasses = 'btn btn-sm btn-info';
              this.addRequest.topButtonIcon = 'glyphicon glyphicon-plus-sign';
            }
          },
          requestDate(orgDate) {
            let date = moment(orgDate).format('L');
            return date;
          },
          requestClasses(closeDate) {
            if (!closeDate) {
              return 'label label-warning list-badget';
            }
            return 'label label-success list-badget';
          },
          requestText(closeDate) {
            if (!closeDate) {
              return 'Pendiente';
            }
            return 'Resuelta';
          },
          requestIcon(closeDate) {
            if (!closeDate) {
              return 'glyphicon glyphicon-question-sign visible-xs-block';
            }
            return 'glyphicon glyphicon-ok-sign visible-xs-block';
          },
          calculateRatio() {
            for (let request of this.profileSrc.requests) {
              this.profileRequests.total++;
              if (request.closed_at) {
                this.profileRequests.resolved++;
              }
            }
            let ratio = Math.floor((this.profileRequests.resolved*100)/this.profileRequests.total);
            this.profileRequests.barStyle = 'width: '+ratio+'%';
            this.profileRequests.barText = ratio+'% Resueltas';
          },
          notifyAdded() {
            flash({
                message: 'Solicitud enviada.', 
                label: 'success'
            });
            this.toggleAddRequest();
            this.fetchProfile();
          },
          fetchProfile() {
            axios.get('/api/requests')
              .then(data => {
                console.log(data.data);
                this.profileSrc = data.data.profile;
                this.types = data.data.types;
                this.details = data.data.details;
                this.labs = data.data.labs;
                this.calculateRatio();
              });
          },
        },
        computed: {
        },
        created() {
          moment.locale('es');
          this.fetchProfile();
        }
    }
</script>
<style type="text/css">
</style>