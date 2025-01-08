// resources/js/app.js

import { createApp } from 'vue';
import App from './App.vue';
import axios from 'axios';
import router from './router';
import Antd from 'ant-design-vue';
import ViewUIPlus from 'view-ui-plus';
import 'view-ui-plus/dist/styles/viewuiplus.css';
import locale from 'view-ui-plus/dist/locale/en-US';
import CKEditor from '@ckeditor/ckeditor5-vue'
// import CKEditor from '@ckeditor/ckeditor5-vue';





import DataTable from 'datatables.net-vue3'

import store from './store';  // Import the store

require('./bootstrap');

const app = createApp(App)
app.config.globalProperties.$axios = axios;
app.use(ViewUIPlus, {locale: locale});
app.use(router);
app.use(DataTable);
app.use(store);
app.use(CKEditor);
app.use(Antd);
app.mount('#app');
