import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    logged_in: false,
    scope_login: null,
    model_login: {},
  },
  getters: {
    loggedIn (state) {
      return state.model_login.connected;
    }
  },
  mutations: {
    setScope(state, scope) {
      state.scope_login = scope;
    },
    setModel(state, model) {
      state.model_login = model;
    }
  },
  actions: {
  },
  modules: {
  }
})
