require('./bootstrap')

import Vue from 'vue'
import VueI18n from 'vue-i18n'
import en from '../../lang/en.json'

import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'

import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import AppLayout from '@/Layouts/AppLayout'
import HomeLayout from '@/Layouts/HomeLayout'

library.add(fas)

Vue.use(VueI18n)
Vue.mixin({ methods: { route } })
Vue.component('font-awesome-icon', FontAwesomeIcon)

const i18n = new VueI18n({
  locale: 'en',
  en
})

let pages = ['Index', 'Auth/']

createInertiaApp({
  resolve: name => {
    const page = require(`./Pages/${name}`).default

    if (page.layout === undefined && !pages.some(word => name.startsWith(word))) {
      page.layout = AppLayout
    }

    if (name === 'Index') {
      page.layout = HomeLayout
    }

    return page
  },
  setup({ el, app, props }) {
    new Vue({
      i18n,
      provide: { axios: window.axios, echo: window.Echo },
      render: h => h(app, props)
    }).$mount(el)
  }
})

InertiaProgress.init({
  color: '#FBBF24'
})
