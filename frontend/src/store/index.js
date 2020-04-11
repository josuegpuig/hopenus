import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    logged_in: false,
    scope_login: null,
    model_login: {},
    coordinates: {},
    status_coordinates: '',
  },
  getters: {
    loggedIn (state) {
      return state.model_login.connected;
    },
    activeLocation (state) {
      return state.coordinates.status;
    },
    userCoordinates (state) {
      return state.coordinates;
    },
    status_coordinates: state => state.status_coordinates,
  },
  mutations: {
    setScope(state, scope) {
      state.scope_login = scope;
    },
    setModel(state, model) {
      state.model_login = model;
    },
    setStatusCoords(state, status) {
      state.status_coordinates = status;
    },
    setCoords(state, coords) {
      state.coordinates = coords;
      state.status_coordinates = 'Updated';
    }
  },
  actions: {
  },
  modules: {
  }
})
