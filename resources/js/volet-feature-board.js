import { defineCustomElement } from 'vue'
import FeatureBoard from './components/FeatureBoard.ce.vue'

const Element = defineCustomElement(FeatureBoard)

customElements.define('feature-board', Element)
