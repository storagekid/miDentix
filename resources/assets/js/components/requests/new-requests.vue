<template>
  <form id="new-request-form">
    <div v-if="request.id">
      <div class="text-center">
        <h4>Solicitud enviada el {{requestDate}} por:</h4>
        <h3>{{request.profile.name}} {{request.profile.lastname1}}</h3>
      </div>
      <div :class="requestClasses" v-if="showMode && showHeader">
        <h4>Estado: <strong>{{requestStateText}}</strong></h4>
      </div>
    </div>
    <div class="form-group">
      <label for="clinic_id">Clínica</label>
      <select 
        class="form-control" 
        id="clinic_id" 
        name="clinic_id" 
        @change="selectClinic" 
        v-model="addRequest.selectedClinicId"
        :disabled="showMode" 
        >
        <option 
          disabled="" 
          value="" 
          :selected="addRequest.selectedClinicId"
          >Selecciona una de tus clínicas
        </option>
        <option 
          v-for="clinic in clinics" 
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
            <input 
              type="radio" 
              name="type" 
              :value="type" 
              :disabled="showMode" 
              :checked="addRequest.selectedType == type ? true : false"
              @click="selectType">
            {{type}}
          </label>
        </div>
      </div>
    </div>
    <div class="form-group col-xs-12 col-sm-3" v-if="showDetails == 'Manage'">
      <label for="name">Indícanos el tipo de gestión: <br>(selecciona todas las que procedan)</label>
      <div class="checkbox">
        <label v-for="detail in details">
          <input 
            type="radio" 
            name="detail" 
            :value="detail" 
            :disabled="showMode" 
            :checked="addRequest.selectedDetail == detail ? true : false"
            @click="selectDetail">
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
          v-model="addRequest.selectedLabName"
          :disabled="showMode" 
          @change="selectLab">
          <option 
            disabled="" 
            value="" 
            :selected="addRequest.selectedLabName"
            >{{addRequest.selectedLabText}}
          </option>
          <option 
            v-for="lab in labs" 
            :value="lab.name"
            >
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
        :disabled="showMode" 
        v-model="addRequest.description" 
        ></textarea>
    </div>
    <button 
      type="submit" 
      class="btn btn-primary btn-block" 
      v-if="!showMode"
      @click.prevent="sendRequest"
      ><h4>Enviar</h4>
    </button>
  </form>
</template>

<script>
    import * as moment from 'moment';
    import 'moment/locale/es';
    export default {
        components: {},
        props: [
          'newRequest',
          'clinics',
          'types',
          'details',
          'labs',
          'profileId',
          'request'
        ], 
        data() {
            return {
              addRequest: {
                selectedClinicId: '',
                selectedClinicText: 'Selecciona una clínica',
                selectedType: '',
                selectedDetail: '',
                selectedLabId: '',
                selectedLabName: '',
                selectedLabText: 'Selecciona un laboratorio',
                description: '',
                descriptionClasses: 'form-group col-xs-12',
              },
              requestDate: '',
              adminProfile: null,
            }
        },
        watch: {
          newRequest() {
            this.toggleAddRequest();
          }
        },
        methods: {
          toggleAddRequest() {
            this.addRequest.selectedClinicId = '';
            this.addRequest.selectedType = '';
            this.addRequest.selectedDetail = '';
            this.addRequest.selectedLabId = '';
            this.addRequest.selectedLabName = '';
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
            axios.post('/requests/'+this.profileId, {
              'profile_id': this.profileId,
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
                      this.$emit('added');
                      window.events.$emit('requestAdded');
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
          fetchAdminProfile() {
            axios.get('/api/profile/'+this.request.closed_by)
              .then(data => {
                this.adminProfile = data.data;
              });
          },
        },
        computed: {
          showHeader() {
                if (App.role == 'user') {
                    return false;
                }
                return true;
            },
          showMode() {
            let keys = Object.keys(this.request).length;
            if (!keys) {
              return false;
              console.log('request empty');
            } else {
              this.addRequest.selectedClinicId = this.request.clinic.id;
              this.addRequest.selectedType = this.request.type;
              this.addRequest.selectedDetail = this.request.type_detail1;
              this.addRequest.selectedLabName = this.request.type_detail1;
              this.addRequest.description = this.request.description;
              this.requestDate = moment(this.request.created_at).format('L');
              return true;
              console.log('request found!!!');
            }
          },
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
          requestClasses() {
            if (this.request.closed_at) {
              return 'alert alert-success text-center request-state'
            } else {
              return 'alert alert-warning text-center request-state'
            }
          },
          requestStateText() {
            if (this.request.closed_at && this.adminProfile) {
              return 'Resuelta por '+this.adminProfile.name+' '+this.adminProfile.lastname1+' el '+moment(this.request.closed_at).format('L');
            } else {
              return 'Pendiente';
            }
          },
        },
        created() {
          moment.locale('es');
          if (this.request.closed_by) {
            this.fetchAdminProfile();
          }
        }
    }
</script>
<style type="text/css">
</style>