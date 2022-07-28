import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue'
import routes from './routes/routes.js'

const app = createApp(App)
app.use(routes)
app.mount('#app')