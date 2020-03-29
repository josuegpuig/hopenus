import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    logged_in: false,
  },
  mutations: {
    loginState (state) {
      state.logged_in = !state.logged_in;
    }
  },
  actions: {
  },
  modules: {
  }
})
