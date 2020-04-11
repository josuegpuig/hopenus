import Vue from 'vue'
import './plugins/axios'
import App from './App.vue'

import './scss/main.scss'
import { NavbarPlugin, FormInputPlugin, ButtonPlugin, CardPlugin, LayoutPlugin, LinkPlugin, ImagePlugin, AvatarPlugin, FormGroupPlugin, FormTextareaPlugin, SpinnerPlugin, FormCheckboxPlugin } from 'bootstrap-vue'
import i18n from './i18n'
import router from './router'
import store from './store'
import './filters'

Vue.config.productionTip = false

Vue.use(NavbarPlugin);
Vue.use(FormInputPlugin);
Vue.use(ButtonPlugin);
Vue.use(CardPlugin);
Vue.use(LayoutPlugin);
Vue.use(LinkPlugin);
Vue.use(ImagePlugin);
Vue.use(AvatarPlugin);
Vue.use(FormGroupPlugin);
Vue.use(FormTextareaPlugin);
Vue.use(SpinnerPlugin);
Vue.use(FormCheckboxPlugin);

new Vue({
  i18n,
  router,
  store,
  render: h => h(App)
}).$mount('#app')
