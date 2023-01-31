import './bootstrap';

import {createApp} from 'vue'

import App from './loginComponent.vue'
import Confirmation from './confirmationComponent.vue'

createApp(App).mount("#app")
createApp(Confirmation).mount("#confirmationComponent")