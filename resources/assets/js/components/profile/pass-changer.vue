<template>
  <div>
    <form id="pass-change-form">
      <div class="row"> 
        <div class="form-group col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
          <label for="name">Contraseña actual:</label>
          <input id="oldPass" type="password" class="form-control" v-model="profilePass.old">
        </div>
        <div class="form-group col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
          <label for="newPass">Nueva Contraseña:</label>
          <password
          v-model="profilePass.new"
          :name="'newPass'"
          :placeholder="password.placeholder"
          :secureLength="password.secureLength"
          defaultClass="form-control"
          :errorClass="'label label-danger'"
          :successClass="'label label-success'"
          :user-inputs="[profileSrc.email,profileSrc.name,profileSrc.lastname1,profileSrc.lastname2]"
          :strengthMessages="['Muy débil', 'Débil', 'Medio', 'Segura', 'Muy segura']"
          >
          </password>
        </div>
        <div class="form-group col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
          <label for="newPass2">Confirmar nueva Contraseña:</label>
          <input id="newPass2" type="password" class="form-control" v-model="profilePass.new2">
        </div>
      </div>
    </form>
    <div class="btn-center-box col-xs-12">
      <a href="#" id="image-change-button"  @click.prevent="sendChangePass">
        <button class="btn btn-primary">Confirmar cambio</button>
      </a>
      <a 
        href="#" 
        id="image-change-button"  
        @click.prevent="sendCancel"
        v-if="!tutorial"
        >
        <button class="btn btn-danger">Cancelar</button>
      </a>
    </div>
  </div>
</template>

<script>
    import Password from 'vue-password-strength-meter';
    export default {
        components: {Password},
        props: ['profileSrc','tutorial'],
        data() {
            return {
              profilePass: {
                old: null,
                new: '',
                new2: ''
              },
              password: {
                placeholder: 'Mínimo 8 caractéres',
                secureLength: 8,
              },
            }
        },
        watch: {
        },
        methods: {
          sendCancel() {
            this.$emit('cancel');
          },
          sendChangePass() {
            if (!this.checkPassword()) {
              return false;
            }
            axios.patch('/api/user/passreset', {
              'Contraseña Actual': this.profilePass.old,
              'Nueva Contraseña': this.profilePass.new,
              'Nueva Contraseña_confirmation': this.profilePass.new2
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
                        message: 'Contraseña actualizada correctamente.', 
                        label: 'success'
                    });
                    this.$emit('changed');
                  }
              });
          },
          checkPassword() {
            if (!this.profilePass.old) {
              flash({
                  message: 'Debes introducir la contraseña actual', 
                  label: 'warning'
              });
              return false;
            }
            if (this.profilePass.new.length < this.password.secureLength) {
              flash({
                  message: 'La nueva contraseña debe tener al menos 8 caracteres', 
                  label: 'warning'
              });
              return false;
            }
            if (this.profilePass.new != this.profilePass.new2) {
              flash({
                  message: 'Las nuevas contraseñas no coinciden', 
                  label: 'warning'
              });
              return false;
            }
            return true;
          }
        },
        computed: {
        },
        created() {
        }
    }
</script>
<style type="text/css">
</style>