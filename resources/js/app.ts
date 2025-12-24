import { createInertiaApp } from '@inertiajs/vue3'
import { createApp, DefineComponent, h, Plugin } from 'vue'
import '../css/app.css'

function setDarkTheme(media: MediaQueryList | MediaQueryListEvent) {
    if (media.matches) {
        window.document.body.setAttribute('data-theme', 'dark')
    } else {
        window.document.body.removeAttribute('data-theme')
    }
}

function darkMode(): Plugin {
    return {
        install() {
            const mediaQueryList = window.matchMedia(
                '(prefers-color-scheme: dark)'
            )
            setDarkTheme(mediaQueryList)
            mediaQueryList.onchange = setDarkTheme
        },
    }
}

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob<DefineComponent>('./Pages/**/*.vue')
        return pages[`./Pages/${name}.vue`]()
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(darkMode())
            .mount(el)
    },
})
