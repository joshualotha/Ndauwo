<template>
  <div id="app-wrapper">
    <!-- Global Shutter Transition -->
    <div class="shutter-container" :class="{ active: isPageTransitioning, exit: isPageExiting }">
      <div class="shutter"></div>
      <div class="shutter"></div>
      <div class="shutter"></div>
      <div class="shutter"></div>
      <div class="shutter-logo">NDAUWO</div>
    </div>

    <!-- Global Loader (Initial Load Only) -->
    <div id="loader" :class="{ hidden: !showLoader }">
      <div class="loader-logo">NDAUWO</div>
      <div class="loader-line"></div>
      <div class="loader-sub">Tanzania Luxury Safaris</div>
    </div>
    
    <!-- Floating WhatsApp -->
    <a 
      v-if="settings.contact_whatsapp" 
      class="whatsapp-float" 
      :href="`https://wa.me/${settings.contact_whatsapp.replace(/[^0-9]/g, '')}`" 
      target="_blank"
    >💬</a>

    <!-- GTranslate -->
    <div class="gtranslate_wrapper"></div>

    <AppTopbar v-if="!$route.meta.hideNavbar" />
    <AppNavbar v-if="!$route.meta.hideNavbar" />
    
    <main>
      <router-view />
    </main>

    <AppFooter v-if="!$route.meta.hideFooter" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import AppNavbar from './components/AppNavbar.vue'
import AppTopbar from './components/AppTopbar.vue'
import AppFooter from './components/AppFooter.vue'
import { useSettingsProvider } from './composables/useSettings'

const { settings, fetchSettings } = useSettingsProvider()

const showLoader = ref(true)
const isPageTransitioning = ref(false)
const isPageExiting = ref(false)
const router = useRouter()

// Clean up old hooks if HMR runs
if (window.__beforeEachHook) window.__beforeEachHook();
if (window.__afterEachHook) window.__afterEachHook();

// Premium Page Transition Logic
window.__beforeEachHook = router.beforeEach(async (to, from) => {
  const isAdmin = to.path.startsWith('/admin') || from.path.startsWith('/admin');
  
  if (to.path !== from.path && !isAdmin) {
    isPageTransitioning.value = true
    isPageExiting.value = false
    
    // Allow curtain to close before changing route
    await new Promise(resolve => setTimeout(resolve, 800))
  }
})

window.__afterEachHook = router.afterEach((to) => {
  const isAdmin = to.path.startsWith('/admin');
  if (isAdmin) return;

  // Briefly stay closed to mask content loading
  setTimeout(() => {
    isPageTransitioning.value = false
    isPageExiting.value = true
    
    // Reset after animation completes
    setTimeout(() => {
      isPageExiting.value = false
    }, 800)
  }, 400)
})

onMounted(() => {
  fetchSettings()
  const isAdmin = window.location.pathname.startsWith('/admin');
  setTimeout(() => {
    showLoader.value = false
  }, isAdmin ? 300 : 2200)

  // GTranslate Settings
  window.gtranslateSettings = {
    "default_language": "en",
    "languages": ["en", "fr", "it", "es", "sv", "pl", "zh-CN", "de"],
    "wrapper_selector": ".gtranslate_wrapper"
  }

  // Load GTranslate Script
  const script = document.createElement('script')
  script.src = "https://cdn.gtranslate.net/widgets/latest/float.js"
  script.defer = true
  document.head.appendChild(script)
})
</script>
