import Vue from 'vue'
import './plugins/axios'
import App from './App.vue'

import './scss/main.scss'
import { NavbarPlugin, FormInputPlugin, ButtonPlugin, CardPlugin, LayoutPlugin } from 'bootstrap-vue'
import i18n from './i18n'

Vue.config.productionTip = false

Vue.use(NavbarPlugin);
Vue.use(FormInputPlugin);
Vue.use(ButtonPlugin);
Vue.use(CardPlugin);
Vue.use(LayoutPlugin);

new Vue({
  i18n,
  render: h => h(App)
}).$mount('#app')
