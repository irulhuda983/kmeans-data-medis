import './bootstrap';
import { createApp } from "vue";
import router from "./router"
import App from "./App.vue";
import VueApexCharts from "vue3-apexcharts";
import { createPinia } from 'pinia';
import { useAuthStore } from '@/stores/auth';
import Notifications from '@kyvg/vue3-notification';
import VueTailwindDatepicker from 'vue-tailwind-datepicker';

/* Create Vue app */
const app = createApp(App);
app.use(createPinia());
app.use(Notifications);
app.use(VueApexCharts);
app.use(VueTailwindDatepicker);
const { getUser } = useAuthStore();
getUser().then(() => {
    app.use(router)
    app.mount('#app')
});