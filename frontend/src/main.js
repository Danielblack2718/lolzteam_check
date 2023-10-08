// main.js
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import './assets/css/style.css';
import VueCookies from 'vue-cookies';
import axios from 'axios';
import VueSweetAlertPlugin from './plugins/sweet-alert-plugin'
import VueQuill from 'vue3-quill';

const app = createApp(App);

app.use(VueSweetAlertPlugin)
app.use(router);
app.use(VueCookies);
app.config.globalProperties.$axios = axios;
app.component('quill-editor', VueQuill.QuillEditor);
app.mount('#app');
