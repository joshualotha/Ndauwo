import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'

// CSS is now injected via Laravel Vite as a separate entry point

// Configure Axios Interceptor for Admin Token
axios.interceptors.request.use((config) => {
  const token = localStorage.getItem('admin_token');
  if (token && config.url.includes('/api/')) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, (error) => {
  return Promise.reject(error);
});

const app = createApp(App)

// Global custom directive for scroll reveals
app.directive('reveal', {
    mounted(el) {
        // Check if the element is inside a hero section
        const isHero = el.closest('#hero, .premium-hero, .hero-content, [class*="hero"]');

        if (!isHero) {
            // Instant visibility for non-hero elements
            el.classList.add('visible');
            return;
        }

        // Create an intersection observer for the element
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible')
                    observer.unobserve(e.target)
                }
            })
        }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' })

        observer.observe(el)
    }
})

app.use(router)
app.mount('#app')
