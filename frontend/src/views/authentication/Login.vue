<template>
  <el-row :gutter="20" style="padding: 10px">

    <loading
      :show="show"
      :label="label"/>

    <el-col :span="10" :offset="7">
      <el-card class="box-card">
        <el-row
          type="flex"
          class="row-bg"
          justify="center"
          style="border-bottom: 1px solid teal; margin-top: 0px;margin: 20px;">
          <p
            class="text-center font-weight-bold"
            style="/*! border-bottom: 1px solid teal; */ margin-bottom: 6px; margin-top: 0px;font-size: 35px;font-variant: all-petite-caps;color: teal;font-weight: bold;margin-bottom: 5px">
          <router-link to="/"> {{ app.title }}</router-link></p>
        </el-row>

        <el-form
          ref="dataForm"
          :rules="rules"
          :model="loginForm"
          label-position="left"
          label-width="100px"
          style="width: 400px; margin-left:50px;">
          <el-form-item label="Email" prop="email">
            <el-input
              v-model="loginForm.email"
              type="email"
              placeholder="Email"
              aria-required="true"/>

          </el-form-item>
          <el-form-item label="Password" prop="password">
            <el-input
              v-model="loginForm.password"
              type="password"
              placeholder="Password"
              aria-required="true"/>
          </el-form-item>

          <el-form-item>
            <el-button style="background-color: teal ; color: white" class="float-right" @click="login()">
              Login
            </el-button>

          </el-form-item>

        </el-form>

      </el-card>
    </el-col>
  </el-row>

</template>

<script>
import loading from 'vue-full-loading'
import { mapGetters } from 'vuex'
import Vue from 'vue'

export default {
  components: {
    loading
  },

  data() {
    return {
      loginForm: {
        email: '',
        password: ''
      },
      show: false,
      label: 'Authenticating...',
      rules: {
        email: [{ type: 'email', required: true, message: 'email is required', trigger: 'change' }],
        password: [{ required: true, message: 'password is required', trigger: 'change' }]

      }

    }
  },
  computed: {
    ...mapGetters([
      'app'
    ])
  },

  methods: {
    login() {
      this.show = true

      this.$store.dispatch('Login', this.loginForm).then(response => {
        if (response.access_token) {
          this.$store.dispatch('GetUserInfo').then(() => {
            this.show = false
              if(this.$store.getters.userrole.name === 'admin'){
                  this.$router.push({ path: '/dashboard' })

              }else{
                  this.$router.push({ path: '/' })

              }
          }).catch((err) => {
            this.show = false
          })
        } else {
          this.show = false
        }
      }).catch((err) => {
        this.show = false
      })
    },
  }
}

</script>
<style>

    .el-card__header {
        background-color: teal !important;
    }

    .btn {
        background: #42b983;
        color: white;
    }

    h2 {
        color: #42b983;
        text-transform: capitalize;
        font-weight: bolder;

    }

    .login-form {
        width: 340px;
        margin: 50px auto;
    }

    .login-form form {
        margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }

    .login-form h2 {
        margin: 0 0 15px;
    }

    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }

    .btn {
        font-size: 15px;
        font-weight: bold;
    }

    .g-signin-button {
        /* This is where you control how the button looks. Be creative! */
        display: inline-block;
        padding: 4px 8px;
        border-radius: 3px;
        background-color: #3c82f7;
        color: #fff;
        box-shadow: 0 3px 0 #0f69ff;
    }
</style>
