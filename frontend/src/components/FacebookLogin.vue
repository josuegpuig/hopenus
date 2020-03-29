<template>
  <div>
    <v-facebook-login app-id="223948805642359" v-model="model" @sdk-init="handleSdkInit" @login="handleLogin"/>
    <button v-if="scope.logout && model.connected" @click="scope.logout">
      Logout
    </button>
  </div>
</template>

<script>
  import VFacebookLogin from 'vue-facebook-login-component';

  export default {
    components: {
      VFacebookLogin
    },
    data: () => ({
      FB: {},
      model: {},
      scope: {}
    }),
    methods: {
      handleSdkInit({ FB, scope }) {
        this.FB = FB
        this.scope = scope
      },
      handleLogin(res) {
        if (res === 'connected') {
          this.FB.api('/me', { fields: 'id, first_name, last_name, email, picture.type(large)' }, res => {
            console.log(res);
            this.$axios.post('http://localhost:8000/api/auth/login-oauth', {
              first_name: res.first_name,
              last_name: res.last_name,
              email: res.email,
              picture: res.picture.data.url,
              provider: 'facebook',
              id_oauth: res.id,
            }).then(token => {
              token = token.data;
              let expiration = new Date();
              expiration.setSeconds(expiration.getSeconds() + token.expires_in);
              let token_data = {
                access_token: token.access_token,
                expiration: expiration
              }
              localStorage.setItem('token', JSON.stringify(token_data));
            })
          })
        }
      }
    }
  }
</script>