/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
window.Vue = require("vue");
import VueRouter from "vue-router";
import BootstrapVue from "bootstrap-vue";

Vue.use(VueRouter);
Vue.use(BootstrapVue);

import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faPlus,
    faWindowClose,
    faDatabase,
    faEye,
    faUserSecret,
    faCalendar,
    faPen,
    faPencilAlt,
    faUsers,
    faTrash,
    faFileAlt,
    faSearch,
    faDownload,
    faTimes,
    faFilter
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(
    faPlus,
    faWindowClose,
    faDatabase,
    faEye,
    faUserSecret,
    faCalendar,
    faPen,
    faPencilAlt,
    faUsers,
    faTrash,
    faFileAlt,
    faSearch,
    faDownload,
    faTimes,
    faFilter
);

Vue.component("font-awesome-icon", FontAwesomeIcon);

const routes = require("./routes.js").default;
const router = new VueRouter({
    routes
});

import addGlobalServices from "./di/index";
Vue.use(addGlobalServices);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component(
    "passport-clients",
    require("./components/passport/Clients.vue").default
);
Vue.component(
    "passport-authorized-clients",
    require("./components/passport/AuthorizedClients.vue").default
);
Vue.component(
    "passport-personal-access-tokens",
    require("./components/passport/PersonalAccessTokens.vue").default
);
Vue.component("app", require("./components/App.vue").default);
import Loading from "vue-loading-overlay";
Vue.use(Loading);
Vue.component("Loading", Loading);

const app = new Vue({
    router,
    el: "#app"
});
