import { createApp } from 'vue';
import App from './App.vue';
import PrimeVue from 'primevue/config';
import { createPinia } from 'pinia'
import router from './routes';
// import './css/themelaraligth.css';


import ToastService from 'primevue/toastservice';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'primevue/resources/themes/saga-blue/theme.css';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';
import 'primevue/resources/themes/lara-dark-teal/theme.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '/node_modules/primeflex/primeflex.css';





const pinia = createPinia()
const app = createApp(App); // <-- Move this line before app.component

app.use(PrimeVue);
app.use(ToastService);
app.use(pinia);

app.use(router);
app.mount('#app');