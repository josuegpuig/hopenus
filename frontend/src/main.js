import Vue from 'vue'
import './plugins/axios'
import App from './App.vue'

import './scss/main.scss'
import { NavbarPlugin, FormInputPlugin, ButtonPlugin, CardPlugin, LayoutPlugin, LinkPlugin, ImagePlugin, AvatarPlugin, FormGroupPlugin, FormTextareaPlugin } from 'bootstrap-vue'
import i18n from './i18n'
import router from './router'

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

new Vue({
  i18n,
  router,
  render: h => h(App)
}).$mount('#app')
