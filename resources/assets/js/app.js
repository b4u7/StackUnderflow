require('./bootstrap')

import Vue from 'vue'

import VueI18n from 'vue-i18n'
import en from '../../lang/en.json'

import VueCroppie from 'vue-croppie'

import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'

import {
  faAngleDown,
  faAngleUp,
  faArrowCircleDown,
  faArrowCircleUp,
  faArrowRight,
  faBuilding,
  faCheck,
  faCommentAlt,
  faEnvelope,
  faEnvelopeOpen,
  faEye,
  faInbox,
  faLink,
  faLongArrowAltRight,
  faPenToSquare,
  faPencilAlt,
  faPlus,
  faSort,
  faTrashCan,
  faXmark,
} from '@fortawesome/free-solid-svg-icons'

import { faBookmark } from '@fortawesome/free-regular-svg-icons'

import AppLayout from '@/Layouts/AppLayout'
import HomeLayout from '@/Layouts/HomeLayout'

Vue.use(VueI18n)
Vue.use(VueCroppie)

Vue.mixin({ methods: { route } })

library.add(
  faAngleDown,
  faAngleUp,
  faArrowCircleDown,
  faArrowCircleUp,
  faArrowRight,
  faBookmark,
  faBuilding,
  faCheck,
  faCommentAlt,
  faEnvelope,
  faEnvelopeOpen,
  faEye,
  faInbox,
  faLink,
  faLongArrowAltRight,
  faPenToSquare,
  faPencilAlt,
  faPlus,
  faSort,
  faTrashCan,
  faXmark
)

Vue.component('font-awesome-icon', FontAwesomeIcon)

const i18n = new VueI18n({
  locale: 'en',
  en,
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
      render: h => h(app, props),
    }).$mount(el)
  },
})

InertiaProgress.init({
  color: '#FBBF24',
})
