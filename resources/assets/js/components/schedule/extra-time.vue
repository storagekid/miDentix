<template>
    <div class="schedule-table">
      <a href="#" class="text-center" style="display: inherit;">
        <button type="button" class="btn btn-sm btn-info">
          <h3><span class="glyphicon glyphicon-plus-sign"></span>Nueva solicitud</h3>
        </button>
      </a>
      <table class="table table-responsive">
        <thead>
          <tr>
            <th>Provincia</th>
            <th>Clínica</th>
            <th class="hidden-xs">Fecha</th>
            <th>Detalles</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Barcelona</td>
            <td>Castelldefels (Av. Santa Maria, 11)</td>
            <td class="hidden-xs">25/11/2017</td>
            <td>
              M: 18:00 - 20:00 <br>
              X: 18:00 - 20:00 <br>
              S: 9:00 - 15:00
            </td>
            <td>
              <div class="label label-danger list-badget">
                <span class="hidden-xs">Denegada</span>
                <span class="glyphicon glyphicon-remove-sign visible-xs-block"></span>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              Barcelona <br>
              Tarragona <br>
              Castellón
            </td>
            <td>Indiferente</td>
            <td class="hidden-xs">12/09/2017</td>
            <td>
              L: 14:00 - 18:00 <br>
              X: 14:00 - 18:00
            </td>
            <td>
              <div class="label label-warning list-badget">
                <span class="hidden-xs">Pendiente</span>
                <span class="glyphicon glyphicon-question-sign visible-xs-block"></span>
              </div>
            </td>
          </tr>
          <tr>
            <td>Indiferente</td>
            <td>Indiferente</td>
            <td class="hidden-xs">27/08/2017</td>
            <td>
              L: 10:00 - 14:00 <br>
              X: 10:00 - 14:00
            </td>
            <td>
              <div class="label label-success list-badget">
                <span class="hidden-xs">Aceptada</span>
                <span class="glyphicon glyphicon-ok-sign visible-xs-block"></span>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
</template>

<script>
    export default {
        props: [
        ],
        data() {
            return {
            }
        },
        watch: {
        },
        methods: {
        },
        computed: {
        },
        created() {
        },
    }
</script>
<style type="text/css">
</style>