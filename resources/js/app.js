// resources/js/app.js

import { createApp } from 'vue';
import App from './App.vue';
import Antd from 'ant-design-vue';
import router from './router/index.js';

const app = createApp(App)
app.use(router)
app.use(Antd)
app.mount('#app');
