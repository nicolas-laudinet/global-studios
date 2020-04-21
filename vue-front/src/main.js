import Vue from 'vue'
import App from './App.vue'
import router from './router'
import mixin from './mixin'

Vue.config.productionTip = false

new Vue({
  mixins: {
    mixin
  },
  router,
  render: h => h(App)
}).$mount('#app')
