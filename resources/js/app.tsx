import {createInertiaApp} from '@inertiajs/react';
import { createRoot } from 'react-dom/client'

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob<{ default: React.ComponentType }>('./Pages/**/*.tsx', { eager: true })
    return pages[`./Pages/${name}.tsx`]
  },
  setup({ el, App, props }) {
    if (!el) return
    createRoot(el).render(<App {...props} />)
  },
})