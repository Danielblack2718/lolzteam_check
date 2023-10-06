// main.js
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import './assets/css/style.css';
import VueCookies from 'vue-cookies';
import axios from 'axios';

const app = createApp(App);

app.use(router);
app.use(VueCookies);
app.config.globalProperties.$axios = axios;

app.mount('#app');
