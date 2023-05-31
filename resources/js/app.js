//import './bootstrap';

import { createApp, h } from "vue";
import { createInertiaApp, router } from "@inertiajs/vue3";

import NProgress from "nprogress";

import vuetify from "@/plugins/vuetify/vuetify";
import { loadFonts } from "@/plugins/googlefonts/webfontloader";
import "vue-advanced-cropper/dist/style.css";
router.on("start", () => NProgress.start());
router.on("finish", () => NProgress.done());
loadFonts();

createInertiaApp({
    progress: {
        showSpinner: true,
        color: "#2196f3" ,
    },
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .mount(el);
    },
});
