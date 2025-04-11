import { createApp } from 'vue'
import App from "./App.vue";

import './vendor/mydnic/volet/resources/css/volet.css'
import './resources/css/volet-feature-board.css'

const app = createApp(App)


app.mount('#volet')
