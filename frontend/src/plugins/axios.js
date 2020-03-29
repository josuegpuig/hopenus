"use strict";

import Vue from 'vue';
import axios from "axios";

// Full config:  https://github.com/axios/axios#request-config
// axios.defaults.baseURL = process.env.baseURL || process.env.apiUrl || '';
// axios.defaults.headers.common['Authorization'] = AUTH_TOKEN;
// axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

let config = {
  // baseURL: process.env.baseURL || process.env.apiUrl || ""
  // timeout: 60 * 1000, // Timeout
  // withCredentials: true, // Check cross-site Access-Control
};

const _axios = axios.create(config);

_axios.interceptors.request.use(
  function(config) {
    // Do something before request is sent
    let token = JSON.parse(localStorage.getItem('token')).access_token;
    config.headers.authorization = `Bearer ${token}`;
    return config;
  },
  function(error) {
    // Do something with request error
    return Promise.reject(error);
  }
);

// Add a response interceptor
_axios.interceptors.response.use(
  function(response) {
    // Do something with response data
    return response;
  },
  function(error) {
    // Do something with response error
    if (error.response.status === 400 && error.response.data.error == 'Unauthorized') {
      let token = JSON.parse(localStorage.getItem('token'));
      let expiration = token.expiration;

      if (new Date(expiration) < new Date()) {
        return new Promise(function (resolve, reject) {
          _axios.get('http://localhost:8000/api/auth/refresh').then(response => {
            console.log(response);
            let token = response.data;
            let expiration = new Date();
            expiration.setSeconds(expiration.getSeconds() + token.expires_in);
            let token_data = {
              access_token: token.access_token,
              expiration: expiration
            }
            localStorage.setItem('token', JSON.stringify(token_data));
            error.config.headers.authorization = `Bearer ${token_data.access_token}`;
            resolve(_axios(error.config));
          }).catch(err => {
            reject(err);
          })
        });
        
      }
    }
    return Promise.reject(error);
  }
);

Plugin.install = function(Vue) {
  Vue.axios = _axios;
  window.axios = _axios;
  Object.defineProperties(Vue.prototype, {
    axios: {
      get() {
        return _axios;
      }
    },
    $axios: {
      get() {
        return _axios;
      }
    },
  });
};

Vue.use(Plugin)

export default Plugin;
