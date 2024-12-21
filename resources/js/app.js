import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { motionPlugin } from '@oku-ui/motion'
// import { createApp, h } from 'vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import './bootstrap'
import '../css/app.css'
import AOS from 'aos'
import 'aos/dist/aos.css'
import Vue3Marquee from 'vue3-marquee'
import { createSSRApp, h } from 'vue'
import { plugin as FormKitPlugin, defaultConfig } from '@formkit/vue'
import '@formkit/themes/genesis'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
  title: title => `${title} - ${appName}`,
  resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createSSRApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(AOS)
      .use(motionPlugin)
      .use(Vue3Marquee)
      .use(FormKitPlugin, defaultConfig)
      .mount(el)
  },
  progress: {
    color: '#4B5563',
  },
})
