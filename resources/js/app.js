import './bootstrap';

import { createApp } from 'vue';
import axios from 'axios';

import App from './layouts/App.vue'
import router from './router';
import store from './store'

axios.defaults.baseURL = window.appConfig.apiBaseUrl;

createApp(App)
.use(router)
.use(store)
.mount('#app')