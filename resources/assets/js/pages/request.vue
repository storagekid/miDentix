<template>
  <div id="requests-info-box">
    <div class="panel panel-default">
      <div class="panel-heading text-center">
        <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>  Mis Solicitudes</h3>
      </div>
      <div class="panel-body">
        <a href="#" class="text-center" style="display: inherit;" @click.prevent="toggleAddRequest">
          <button type="button" :class="addRequest.topButtonClasses">
            <h3><span :class="addRequest.topButtonIcon"></span>{{addRequest.topButtonText}}</h3>
          </button>
        </a>
        <form id="new-request-form" v-if="addRequest.method">
          <div class="form-group">
            <label for="clinic_id">Clínica</label>
            <select class="form-control" id="clinic_id" name="clinic_id" @change="selectClinic" v-model="addRequest.selectedClinicId">
              <option 
                disabled="" 
                value="" 
                :selected="addRequest.selectedClinicId"
                >Selecciona una de tus clínicas
              </option>
              <option 
                v-for="clinic in profileSrc.clinics" 
                :value="clinic.id">
                {{clinic.city}} ({{clinic.address_real_1}})
              </option>
            </select>
          </div>
          <div class="row">
            <div class="form-group col-xs-12">
              <label for="name">¿En qué te podemos ayudar: (selecciona todas las que procedan)</label>
              <div class="checkbox">
                <label v-for="type in types">
                  <input type="radio" name="type" :value="type" @click="selectType">
                  {{type}}
                </label>
              </div>
            </div>
          </div>
          <div class="form-group col-xs-12 col-sm-3" v-if="showDetails == 'Manage'">
            <label for="name">Indícanos el tipo de gestión: <br>(selecciona todas las que procedan)</label>
            <div class="checkbox">
              <label v-for="detail in details">
                <input type="radio" name="detail" :value="detail" @click="selectDetail">
                {{detail}}
              </label>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3" v-if="showDetails == 'Lab'">
            <div class="form-group">
              <label for="lab">Indícanos el laboratorio</label>
              <select 
                class="form-control" 
                id="lab" 
                name="lab" 
                v-model="addRequest.selectedLabId"
                @change="selectLab">
                <option 
                  disabled="" 
                  value="" 
                  :selected="addRequest.selectedLabId"
                  >{{addRequest.selectedLabText}}
                </option>
                <option 
                  v-for="lab in labs" 
                  :value="lab.id">
                  {{lab.name}}
                </option>
              </select>
            </div>
          </div>
          <div :class="descriptionClasses">
            <label for="request_text">Explícanos en detalle (Máximo 500 caracteres)</label>
            <textarea 
              name="request_text" 
              rows="3" 
              maxlength="500" 
              placeholder="" 
              class="form-control"
              required=""
              v-model="addRequest.description" 
              ></textarea>
          </div>
          <button 
            type="submit" 
            class="btn btn-primary btn-block" 
            @click.prevent="sendRequest"
            ><h4>Enviar</h4>
          </button>
        </form>
        <table class="table table-responsive" v-if="!addRequest.method">
          <thead>
            <tr>
              <th>Clínica</th>
              <th class="hidden-xs">Tipo</th>
              <th class="hidden-xs">Detalle</th>
              <th>Fecha</th>
              <th class="hidden-xs">Texto</th>
              <th>Estado</th>
              <th class="buttons-text"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="request in profileSrc.requests">
              <td><strong>{{request.clinic.city}}</strong><br>({{request.clinic.address_real_1}})</td>
              <td class="hidden-xs">{{request.type}}</td>
              <td class="hidden-xs">{{request.type_detail1 ? request.type_detail1 : '-'}}</td>
              <td v-text="requestDate(request.created_at)"></td>
              <td class="hidden-xs">{{request.description.substring(0,50)+'...'}}
              </td>
              <td>
                <div :class="requestClasses(request.closed_at)">{{requestText(request.closed_at)}}</div>
              </td>
              <td>
                <button type="button" class="btn btn-primary">
                  Detalles
                </button>
              </td>
            </tr>
          </tbody>
        </table>
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
    // import schedulePickup from '../components/schedule/schedule-pickup.vue';
    import * as moment from 'moment';
    import 'moment/locale/es';
    export default {
        components: {},
        props: [],
        data() {
            return {
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
              descriptionClasses: 'form-group col-xs-12',
              addRequest: {
                  method: false,
                  topButtonText: 'Nueva Solicitud',
                  topButtonClasses: 'btn btn-sm btn-info',
                  topButtonIcon: 'glyphicon glyphicon-plus-sign',
                  selectedClinicId: '',
                  selectedClinicText: 'Selecciona una clínica',
                  selectedType: '',
                  selectedDetail: '',
                  selectedLabId: '',
                  selectedLabName: '',
                  selectedLabText: 'Selecciona un laboratorio',
                  description: '',
              },
            }
        },
        watch: {
        },
        methods: {
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
              this.addRequest.selectedClinicId = '';
              this.addRequest.selectedType = '';
              this.addRequest.selectedDetail = '';
              this.addRequest.selectedLabId = '';
              this.addRequest.selectedLabName = '';
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
          calculateRatio() {
            for (let request of this.profileSrc.requests) {
              this.profileRequests.total++;
              if (request.closed_at) {
                this.profileRequests.resolved++;
              }
            }
            let ratio = (this.profileRequests.resolved*100)/this.profileRequests.total;
            this.profileRequests.barStyle = 'width: '+ratio+'%';
            this.profileRequests.barText = ratio+'% Resueltas';
          },
          selectClinic(e) {
            this.addRequest.selectedClinicId = e.target.value;
          },
          selectType(e) {
            this.addRequest.selectedType = e.target.value;
            if (e.target.value != 'Gestión de Clínica') {
              this.addRequest.selectedDetail = '';
            }
          },
          selectDetail(e) {
            this.addRequest.selectedDetail = e.target.value;
          },
          selectLab(e) {
            console.log(e);
            this.addRequest.selectedLabId = e.target.value;
            this.addRequest.selectedDetail = e.target.selectedOptions[0].text;
          },
          sendRequest() {
            if (!this.validateForm()) {
              return false;
            }
            axios.post('/requests/'+this.profileSrc.id, {
              'profile_id': this.profileSrc.id,
              'clinic_id': this.addRequest.selectedClinicId,
              'type': this.addRequest.selectedType,
              'type_detail1': this.addRequest.selectedDetail,
              'description': this.addRequest.description,
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
                          message: 'Solicitud enviada.', 
                          label: 'success'
                      });
                      this.toggleAddRequest();
                      this.fetchProfile();
                      // this.profileSrc.requests.push(response.data.request);
                    }
                });
          },
          validateForm() {
            if (!this.addRequest.selectedClinicId) {
              flash({
                  message: 'Debes seleccionar una clínica', 
                  label: 'warning'
              });
              return false;
            }
            if (!this.addRequest.selectedType) {
              flash({
                  message: 'Debes seleccionar un tipo de solicitud', 
                  label: 'warning'
              });
              return false;
            }
            if (this.showDetails == 'Manage' && !this.addRequest.selectedDetail) {
              flash({
                  message: 'Debes seleccionar un modelo de gestión', 
                  label: 'warning'
              });
              return false;
            }
            if (this.showDetails == 'Lab' && !this.addRequest.selectedLabId) {
              flash({
                  message: 'Debes seleccionar un laboratorio', 
                  label: 'warning'
              });
              return false;
            }
            if (!this.addRequest.description) {
              flash({
                  message: 'La explicación no puede estar vacia', 
                  label: 'warning'
              });
              return false;
            }
            if (this.addRequest.description.length < 5) {
              flash({
                  message: 'La explicación debe ser de al menos 5 caracteres.', 
                  label: 'warning'
              });
              return false;
            }
            if (this.addRequest.description.length > 500) {
              flash({
                  message: 'La explicación no puede superar los 500 caracteres.', 
                  label: 'warning'
              });
              return false;
            }
            return true;
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
          showDetails() {
            if (this.addRequest.selectedType == 'Gestión de Clínica') {
              this.descriptionClasses = 'form-group col-xs-12 col-sm-9';
              return 'Manage';
            } else if (this.addRequest.selectedType == 'Laboratorio') {
              this.descriptionClasses = 'form-group col-xs-12 col-sm-9';
              return 'Lab';
            }
            this.descriptionClasses = 'form-group col-xs-12';
            return false;
          },
        },
        created() {
          moment.locale('es');
          this.fetchProfile();
        }
    }
</script>
<style type="text/css">
</style>