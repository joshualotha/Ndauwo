<template>
  <nav id="navbar" :class="{ scrolled: isScrolled, 'menu-open': mobileMenuOpen }">
    <div class="nav-container">
      <ul :class="['nav-links', 'nav-left', { active: mobileMenuOpen }]">
        <li><router-link to="/about" @click="closeMenu">About</router-link></li>
        <li><router-link to="/gallery" @click="closeMenu">Gallery</router-link></li>
        <li class="nav-item-dropdown" @mouseenter="showPlanning = true" @mouseleave="showPlanning = false">
          <a href="#" @click.prevent="togglePlanningMobile" :class="{ active: showPlanning }">Planning Tips <ChevronDownIcon class="dropdown-icon" /></a>
          <ul class="dropdown-menu" :class="{ visible: showPlanning }">
            <li><router-link to="/planning/accommodation-styles" @click="closeMenu">Accommodation Styles</router-link></li>
            <li><router-link to="/planning/visa-entry" @click="closeMenu">Visa & Entry</router-link></li>
            <li><router-link to="/planning/health-safety" @click="closeMenu">Health & Safety</router-link></li>
            <li><router-link to="/planning/packing-list" @click="closeMenu">Packing List</router-link></li>
            <li><router-link to="/planning/cultural-etiquette" @click="closeMenu">Cultural Etiquette</router-link></li>
          </ul>
        </li>
        <li><router-link to="/destinations" @click="closeMenu">Destinations</router-link></li>
      </ul>

      <router-link to="/" class="nav-logo" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
        <img v-if="settings.site_logo_dark" :src="getImageUrl(settings.site_logo_dark)" alt="Ndauwo Safari Co." class="brand-logo" />
        <img v-else src="@/assets/ndauwologo.png" alt="Ndauwo Safari Co." class="brand-logo" />
      </router-link>

      <ul :class="['nav-links', 'nav-right', { active: mobileMenuOpen }]">
        <li><router-link to="/safaris" @click="closeMenu">Safaris</router-link></li>
        <li class="nav-item-dropdown" @mouseenter="showSafariTypes = true" @mouseleave="showSafariTypes = false">
          <a href="#" @click.prevent="toggleSafariTypesMobile" :class="{ active: showSafariTypes }">Experiences <ChevronDownIcon class="dropdown-icon" /></a>
          <ul class="dropdown-menu" :class="{ visible: showSafariTypes }">
            <li><router-link to="/safari-types/tailor-made-safari" @click="closeMenu">Tailor-Made Safaris</router-link></li>
            <li><router-link to="/safari-types/luxury-safari" @click="closeMenu">Luxury Expeditions</router-link></li>
            <li><router-link to="/safari-types/cultural-tours" @click="closeMenu">Cultural Expeditions</router-link></li>
            <li><router-link to="/safari-types/group-safari" @click="closeMenu">Group Departures</router-link></li>
            <li><router-link to="/safari-types/mountain-hiking" @click="closeMenu">Mountain Hiking</router-link></li>
            <li><router-link to="/safari-types/zanzibar-beach-safari" @click="closeMenu">Zanzibar Retreats</router-link></li>
          </ul>
        </li>
        <li><router-link to="/journal" @click="closeMenu">Journal</router-link></li>
        <li><router-link to="/contact" @click="closeMenu">Contact</router-link></li>
      </ul>

      <button
        class="hamburger"
        :class="{ open: mobileMenuOpen }"
        @click="toggleMenu"
        aria-label="Toggle navigation"
        :aria-expanded="mobileMenuOpen.toString()"
      >
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>
  <!-- Mobile drawer -->
  <div class="mobile-drawer" :class="{ visible: mobileMenuOpen }">
    <ul class="mobile-nav-list">
      <li><router-link to="/about" @click="closeMenu">About</router-link></li>
      <li><router-link to="/gallery" @click="closeMenu">Gallery</router-link></li>
      <li class="mobile-dropdown">
        <button @click="togglePlanningMobile" class="mobile-dropdown-btn">
          Planning Tips <ChevronDownIcon :class="['dropdown-icon', { rotate: showPlanning }]" />
        </button>
        <ul class="mobile-sub-menu" :class="{ open: showPlanning }">
          <li><router-link to="/planning/accommodation-styles" @click="closeMenu">Accommodation Styles</router-link></li>
          <li><router-link to="/planning/visa-entry" @click="closeMenu">Visa & Entry</router-link></li>
          <li><router-link to="/planning/health-safety" @click="closeMenu">Health & Safety</router-link></li>
          <li><router-link to="/planning/packing-list" @click="closeMenu">Packing List</router-link></li>
          <li><router-link to="/planning/cultural-etiquette" @click="closeMenu">Cultural Etiquette</router-link></li>
        </ul>
      </li>
      <li><router-link to="/destinations" @click="closeMenu">Destinations</router-link></li>
      <li><router-link to="/safaris" @click="closeMenu">Safaris</router-link></li>
      <li class="mobile-dropdown">
        <button @click="toggleSafariTypesMobile" class="mobile-dropdown-btn">
          Experiences <ChevronDownIcon :class="['dropdown-icon', { rotate: showSafariTypes }]" />
        </button>
        <ul class="mobile-sub-menu" :class="{ open: showSafariTypes }">
          <li><router-link to="/safari-types/tailor-made-safari" @click="closeMenu">Tailor-Made Safaris</router-link></li>
          <li><router-link to="/safari-types/luxury-safari" @click="closeMenu">Luxury Expeditions</router-link></li>
          <li><router-link to="/safari-types/cultural-tours" @click="closeMenu">Cultural Expeditions</router-link></li>
          <li><router-link to="/safari-types/group-safari" @click="closeMenu">Group Departures</router-link></li>
          <li><router-link to="/safari-types/mountain-hiking" @click="closeMenu">Mountain Hiking</router-link></li>
          <li><router-link to="/safari-types/zanzibar-beach-safari" @click="closeMenu">Zanzibar Retreats</router-link></li>
        </ul>
      </li>
      <li><router-link to="/journal" @click="closeMenu">Journal</router-link></li>
      <li><router-link to="/contact" @click="closeMenu">Contact</router-link></li>
      <li><router-link to="/contact" @click="closeMenu" class="mobile-cta">Book a Safari →</router-link></li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { ChevronDown as ChevronDownIcon } from 'lucide-vue-next'
import { useSettings } from '../composables/useSettings'

const { settings, getImageUrl } = useSettings()
const isScrolled = ref(false)
const mobileMenuOpen = ref(false)
const showPlanning = ref(false)
const showSafariTypes = ref(false)

const handleScroll = () => {
  isScrolled.value = window.scrollY > 80
}

const toggleMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value
  document.body.style.overflow = mobileMenuOpen.value ? 'hidden' : ''
  if (!mobileMenuOpen.value) {
    showPlanning.value = false
    showSafariTypes.value = false
  }
}

const closeMenu = () => {
  mobileMenuOpen.value = false
  showPlanning.value = false
  showSafariTypes.value = false
  document.body.style.overflow = ''
}

const togglePlanningMobile = () => {
  if (window.innerWidth <= 1024) {
    showPlanning.value = !showPlanning.value
    if (showPlanning.value) showSafariTypes.value = false
  }
}

const toggleSafariTypesMobile = () => {
  if (window.innerWidth <= 1024) {
    showSafariTypes.value = !showSafariTypes.value
    if (showSafariTypes.value) showPlanning.value = false
  }
}

const handleResize = () => {
  if (window.innerWidth > 1024) closeMenu()
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
  window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  window.removeEventListener('resize', handleResize)
  document.body.style.overflow = ''
})
</script>

<style scoped>
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   NAVBAR — Asilia-Inspired Elegance
   Transparent → white on scroll with subtle backdrop blur
   ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.nav-container {
  max-width: 1400px;
  margin: 0 auto;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1.25rem 60px;
  position: relative;
}

.nav-links {
  display: flex;
  gap: 32px;
  list-style: none;
  width: 40%;
  align-items: center;
}

#navbar.menu-open {
  z-index: 5002 !important;
}
.nav-left { justify-content: flex-end; }
.nav-right { justify-content: flex-start; }

/* Nav links — Jost, refined, lighter weight */
.nav-links > li > a,
.nav-links > li > router-link {
  font-family: var(--f-sans);
  font-size: 0.8rem;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--ivory);
  text-decoration: none;
  font-weight: 400;
  white-space: nowrap;
  transition: color 0.35s ease;
  position: relative;
}

nav.scrolled .nav-links > li > a,
nav.scrolled .nav-links > li > router-link {
  color: var(--text-dark);
}

/* Subtle underline on hover — gold line grows from center */
.nav-links > li > a::after,
.nav-links > li > router-link::after {
  content: '';
  position: absolute;
  bottom: -6px;
  left: 50%;
  transform: translateX(-50%);
  width: 0;
  height: 1px;
  background: var(--gold);
  transition: width 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}

.nav-links > li > a:hover,
.nav-links > li > router-link:hover {
  color: var(--gold);
}

.nav-links > li > a:hover::after,
.nav-links > li > router-link:hover::after {
  width: 70%;
}

/* ── DROPDOWN ── */
.nav-item-dropdown {
  position: relative;
}

.nav-item-dropdown > a {
  display: flex;
  align-items: center;
  gap: 5px;
  text-decoration: none;
  font-family: var(--f-sans);
  font-size: 0.8rem;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--ivory);
  white-space: nowrap;
  transition: color 0.35s ease;
  font-weight: 400;
}

nav.scrolled .nav-item-dropdown > a {
  color: var(--text-dark);
}

.nav-item-dropdown > a:hover {
  color: var(--gold);
}

.dropdown-icon {
  width: 14px;
  height: 14px;
  transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
  opacity: 0.7;
}

.dropdown-menu {
  position: absolute;
  top: calc(100% + 12px);
  left: 50%;
  transform: translateX(-50%) translateY(8px);
  background: var(--ivory);
  min-width: 240px;
  list-style: none;
  padding: 12px 0;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
  opacity: 0;
  visibility: hidden;
  transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
  border-radius: 2px;
  border: 1px solid rgba(0, 0, 0, 0.04);
}

.dropdown-menu.visible {
  opacity: 1;
  visibility: visible;
  transform: translateX(-50%) translateY(0);
}

.dropdown-menu li a {
  display: block;
  padding: 12px 28px;
  color: var(--text-dark) !important;
  font-family: var(--f-sans) !important;
  font-size: 0.82rem !important;
  letter-spacing: 0.08em !important;
  text-transform: none;
  text-decoration: none;
  transition: all 0.25s ease;
  white-space: nowrap;
  font-weight: 400 !important;
}

.dropdown-menu li a:hover {
  background: rgba(226, 121, 27, 0.06);
  color: var(--gold) !important;
  padding-left: 34px;
}

.dropdown-menu li a::after { display: none; }

/* ── MOBILE DROPDOWN ── */
.mobile-dropdown {
  width: 100%;
}

.mobile-dropdown-btn {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 22px 0;
  background: none;
  border: none;
  font-family: var(--f-serif);
  font-size: clamp(1.8rem, 5vw, 2.5rem);
  color: var(--text-dark);
  cursor: pointer;
  text-align: left;
  font-weight: 400;
}

.mobile-sub-menu {
  list-style: none;
  padding: 0;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  background: rgba(18, 20, 16, 0.03);
  margin: 0 -8%;
  padding: 0 8%;
}

.mobile-sub-menu.open {
  max-height: 500px;
  padding-bottom: 20px;
}

.mobile-sub-menu li a {
  font-family: var(--f-sans);
  font-size: 1.05rem;
  padding: 12px 0;
  letter-spacing: 0.04em;
  text-transform: none;
  font-weight: 400;
}

.rotate {
  transform: rotate(180deg);
}

/* ── LOGO (centered) ── */
.nav-logo {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 24%;
  position: relative;
  z-index: 1001;
}

.brand-logo {
  height: 50px;
  width: auto;
  object-fit: contain;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  margin-top: -3px;
  margin-bottom: -3px;
  filter: brightness(0) invert(1);
}
.brand-logo:hover { opacity: 0.85; transform: scale(1.04); }

/* Scrolled: logo dark */
nav.scrolled .brand-logo {
  height: 44px;
  margin-top: 1px;
  margin-bottom: 1px;
  filter: brightness(1) invert(0);
}
nav.scrolled .nav-container { padding: 0.75rem 60px; }

/* ── HAMBURGER ── */
.hamburger {
  display: none;
  flex-direction: column;
  gap: 5px;
  cursor: pointer;
  z-index: 5003;
  background: none;
  border: none;
  padding: 8px;
  min-width: 44px;
  min-height: 44px;
  align-items: center;
  justify-content: center;
}
.hamburger span {
  width: 26px;
  height: 1.5px;
  background: var(--ivory);
  transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
  display: block;
  border-radius: 1px;
}
nav.scrolled .hamburger span { background: var(--ebony); }
nav.menu-open .hamburger span { background: var(--ebony); }

/* Animate to X */
.hamburger.open span { background: var(--ebony); }
.hamburger.open span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
.hamburger.open span:nth-child(2) { opacity: 0; transform: translateX(-8px); }
.hamburger.open span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }

/* ── MOBILE DRAWER ── */
.mobile-drawer {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: var(--ivory);
  z-index: 5000;
  padding: 120px 8% 60px;
  transform: translateX(100%);
  transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
  overflow-y: auto;
}
.mobile-drawer.visible { transform: translateX(0); }

.mobile-nav-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0;
}
.mobile-nav-list li {
  border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}
.mobile-nav-list a {
  display: block;
  padding: 22px 0;
  font-family: var(--f-serif);
  font-size: clamp(1.8rem, 5vw, 2.5rem);
  font-weight: 400;
  color: var(--text-dark);
  text-decoration: none;
  transition: color 0.3s, padding-left 0.3s;
}
.mobile-nav-list a:hover { color: var(--gold); padding-left: 12px; }
.mobile-cta {
  font-family: var(--f-sans) !important;
  font-size: 1rem !important;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--gold) !important;
  margin-top: 16px;
  font-weight: 500 !important;
}

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
  .nav-container { padding: 1rem 24px; }
  nav.scrolled .nav-container { padding: 0.6rem 24px; }
  .nav-links { display: none; }
  .nav-logo { width: auto; flex: 1; justify-content: flex-start; }
  .brand-logo { height: 42px; margin-top: 0; margin-bottom: 0; }
  nav.scrolled .brand-logo { height: 38px; margin-top: 0; margin-bottom: 0; }
  .hamburger { display: flex; }
  .mobile-drawer { display: block; }
}
@media (max-width: 480px) {
  .nav-container { padding: 0.8rem 16px; }
  nav.scrolled .nav-container { padding: 0.5rem 16px; }
  .brand-logo { height: 38px; }
  nav.scrolled .brand-logo { height: 34px; }
}
</style>
