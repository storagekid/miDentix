<template>
    <div class="schedule-table">
      <table class="table table-responsive" v-if="profileSrc.extratimes.length">
        <thead>
          <tr>
            <th>CA</th>
            <th>Provincia</th>
            <th>Clínica</th>
            <th class="hidden-xs">Fecha</th>
            <th>Detalles</th>
            <th>Estado</th>
            <th v-if="updateExtratimes"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="extraTime in profileSrc.extratimes">
            <td>{{extraTime.state_id ? extraTime.states.name : 'Indiferente'}}</td>
            <td>{{extraTime.provincia_id ? extraTime.provincia.nombre : 'Indiferente'}}</td>
            <td>{{extraTime.clinic_id ? 
              extraTime.clinic.city+' ('+extraTime.clinic.address_real_1+')' : 
              'Indiferente'}}</td>
            <td class="hidden-xs" v-text="extraDate(extraTime.created_at)"></td>
            <td v-html="scheduleReader(extraTime.schedule)"></td>
            <td>
              <div :class="doStateBadge(extraTime.state).classes">
                <span class="hidden-xs" v-text="doStateBadge(extraTime.state).text"></span>
                <span :class="doStateBadge(extraTime.state).icon"></span>
              </div>
            </td>
            <td v-if="updateExtratimes">
              <button 
                  class="btn btn-sm btn-danger delete-Schedule"
                  @click="deleteExtratime(extraTime['id'])"
                  >
                  <span class="glyphicon glyphicon-remove"></span>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="text-center" v-else>
        <h3 class="empty">No has hecho ninguna solicitud</h3>
      </div>
    </div>
</template>

<script>
    import * as moment from 'moment';
    import 'moment/locale/es';
    export default {
        props: [
          'profileSrc',
          'updateExtratimes',
        ],
        data() {
            return {
            }
        },
        watch: {
        },
        methods: {
          extraDate(orgDate) {
            let date = moment(orgDate).format('L');
            return date;
          },
          doStateBadge(state) {
            let props = {
              classes: 'label label-warning list-badget',
              text: 'Pendiente',
              icon: 'glyphicon glyphicon-question-sign visible-xs-block'
            };
            if (!state) {
              props.classes = 'label label-danger list-badget';
              props.text = 'Denegada';
              props.icon = 'glyphicon glyphicon-remove-sign visible-xs-block'
            }
            if (state == 2) {
              props.classes = 'label label-success list-badget';
              props.text = 'Aceptada';
              props.icon = 'glyphicon glyphicon-ok-sign visible-xs-block'
            }
            return props;
          },
          scheduleReader(schedule) {
            return scheduleToHumans(schedule);
          },
          deleteExtratime(id) {
            axios.delete('/extratime/'+id)
              .catch((error) => {
                  flash({
                      message: error.response.data, 
                      label: 'danger'
                  });
              }).then(response => {
                  if(response.status == 200) {
                      this.$emit('deleted', {id});
                  }
              });
          },
        },
        computed: {
        },
        created() {
          moment.locale('es');
        },
    }
</script>
<style type="text/css">
</style>