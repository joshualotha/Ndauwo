<template>
  <div class="topbar" :class="{ 'topbar--scrolled': isScrolled }">
    <div class="topbar-inner">
      <!-- LEFT: Contact -->
      <div class="topbar-left">
        <a v-if="settings.contact_phone" :href="`tel:${settings.contact_phone.replace(/\s/g, '')}`" class="topbar-contact">
          <Phone :size="13" stroke-width="1.5" />
          <span>{{ settings.contact_phone }}</span>
        </a>
        <span class="topbar-sep" v-if="settings.contact_phone && settings.contact_email"></span>
        <a v-if="settings.contact_email" :href="`mailto:${settings.contact_email}`" class="topbar-contact">
          <Mail :size="13" stroke-width="1.5" />
          <span>{{ settings.contact_email }}</span>
        </a>
      </div>

      <!-- CENTER: Review Badges (Miracle Experience style) -->
      <div class="topbar-reviews">
        <!-- TripAdvisor Badge -->
        <a href="#" class="review-badge" title="TripAdvisor Reviews">
          <div class="review-badge__icon">
            <svg width="18" height="18" viewBox="0 0 48 48" fill="none">
              <circle cx="24" cy="24" r="23" fill="#00AA6C" stroke="#00AA6C" stroke-width="2"/>
              <path d="M24 8C24 8 28 20 28 20C28 20 40 20 40 20C40 20 30 28 30 28C30 28 34 40 34 40C34 40 24 32 24 32C24 32 14 40 14 40C14 40 18 28 18 28C18 28 8 20 8 20C8 20 20 20 20 20C20 20 24 8 24 8Z" fill="white"/>
            </svg>
          </div>
          <span class="review-badge__score">5.0</span>
          <div class="review-badge__stars">
            <svg v-for="i in 5" :key="'ta-'+i" width="11" height="11" viewBox="0 0 24 24" class="star-icon">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="currentColor"/>
            </svg>
          </div>
        </a>

        <span class="review-divider"></span>

        <!-- Google Reviews Badge -->
        <a href="#" class="review-badge" title="Google Reviews">
          <div class="review-badge__icon review-badge__icon--google">
            <svg width="18" height="18" viewBox="0 0 48 48">
              <path d="M43.6 20.1H24v8.4h11.3C34 34.5 29.5 38 24 38c-7.7 0-14-6.3-14-14s6.3-14 14-14c3.4 0 6.5 1.2 8.9 3.4l6.3-6.3C35.3 3.2 29.9 1 24 1 11.3 1 1 11.3 1 24s10.3 23 23 23c11.5 0 21.3-8.6 22.9-20H43.6z" fill="#4285F4"/>
              <path d="M6.3 14.7l7.3 5.6C15.4 15.7 19.4 13 24 13c3.4 0 6.5 1.2 8.9 3.4l6.3-6.3C35.3 3.2 29.9 1 24 1 16 1 9 5.4 5.1 12.1l1.2 2.6z" fill="#EA4335"/>
              <path d="M24 47c6.5 0 12-2.4 16.2-6.3l-7.3-5.6C30.5 37.2 27.4 38 24 38c-5.5 0-10-3.5-11.7-8.5l-7.3 5.6C8 40.6 15.5 47 24 47z" fill="#34A853"/>
              <path d="M43.6 20.1H24v8.4h11.3c-1.2 3.2-3.5 5.8-6.6 7.5l7.3 5.6c5.1-4.7 8-11.6 8-17.6 0-1.4-.1-2.8-.4-4.1l.3.2z" fill="#FBBC05"/>
            </svg>
          </div>
          <span class="review-badge__score">4.9</span>
          <div class="review-badge__stars">
            <svg v-for="i in 5" :key="'g-'+i" width="11" height="11" viewBox="0 0 24 24" class="star-icon">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="currentColor"/>
            </svg>
          </div>
        </a>
      </div>

      <!-- RIGHT: Book CTA -->
      <div class="topbar-right">
        <button class="top-cta" @click="scrollToBooking">Book a Safari</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Phone, Mail } from 'lucide-vue-next'
import { useSettings } from '../composables/useSettings'

const { settings } = useSettings()

const isScrolled = ref(false)

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50
}

const scrollToBooking = () => {
  const el = document.getElementById('booking')
  if (el) el.scrollIntoView({ behavior: 'smooth' })
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true })
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   TOPBAR — Miracle Experience Style: Review-Centric
   Warm copper/gold on dark translucent background
   ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.topbar {
  background: linear-gradient(135deg, #1a1008 0%, #241a10 50%, #1a1008 100%);
  color: rgba(255, 255, 255, 0.85);
  height: 42px;
  display: flex;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 2001;
  transition: all 0.35s ease;
  font-family: var(--f-sans);
  border-bottom: 1px solid rgba(226, 121, 27, 0.15);
}

.topbar--scrolled {
  background: rgba(26, 16, 8, 0.96);
  backdrop-filter: blur(12px);
  border-bottom-color: rgba(226, 121, 27, 0.25);
}

.topbar-inner {
  max-width: 1400px;
  margin: 0 auto;
  width: 100%;
  padding: 0 60px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* ── Left: Contact ─────────────────────────────── */
.topbar-left {
  display: flex;
  align-items: center;
  gap: 0;
  flex: 0 0 auto;
}

.topbar-contact {
  display: flex;
  align-items: center;
  gap: 6px;
  color: rgba(255, 255, 255, 0.5);
  text-decoration: none;
  font-size: 0.68rem;
  font-weight: 400;
  letter-spacing: 0.04em;
  transition: color 0.3s ease;
  white-space: nowrap;
}

.topbar-contact:hover {
  color: var(--gold);
}

.topbar-sep {
  width: 3px;
  height: 3px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.15);
  margin: 0 12px;
}

/* ── Center: Review Badges ─────────────────────── */
.topbar-reviews {
  display: flex;
  align-items: center;
  gap: 0;
  flex: 1;
  justify-content: center;
}

.review-badge {
  display: flex;
  align-items: center;
  gap: 8px;
  text-decoration: none;
  padding: 4px 14px;
  border-radius: 6px;
  transition: background 0.3s ease;
}

.review-badge:hover {
  background: rgba(226, 121, 27, 0.08);
}

.review-badge__icon {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.review-badge__icon--google {
  opacity: 0.9;
}

.review-badge__score {
  font-family: var(--f-serif);
  font-size: 0.85rem;
  font-weight: 600;
  color: #fff;
  letter-spacing: 0.02em;
  line-height: 1;
}

.review-badge__stars {
  display: flex;
  gap: 1px;
  align-items: center;
}

.star-icon {
  color: var(--gold);
  flex-shrink: 0;
}

.review-divider {
  width: 1px;
  height: 18px;
  background: rgba(255, 255, 255, 0.1);
  margin: 0 8px;
}

/* ── Right: CTA ────────────────────────────────── */
.topbar-right {
  display: flex;
  align-items: center;
  flex: 0 0 auto;
}

.top-cta {
  background: transparent;
  color: var(--gold);
  border: 1px solid rgba(226, 121, 27, 0.4);
  padding: 5px 20px;
  font-family: var(--f-sans);
  font-size: 0.68rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  cursor: pointer;
  border-radius: 3px;
  transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
  white-space: nowrap;
}

.top-cta:hover {
  background: var(--gold);
  color: #fff;
  border-color: var(--gold);
  transform: translateY(-1px);
  box-shadow: 0 4px 15px rgba(226, 121, 27, 0.25);
}

/* ── Responsive ────────────────────────────────── */
@media (max-width: 1024px) {
  .topbar-inner { padding: 0 20px; }
  .topbar-left { display: none; }
  .review-divider { margin: 0 4px; }
  .review-badge { padding: 4px 8px; gap: 5px; }
  .review-badge__score { font-size: 0.78rem; }
}
@media (max-width: 768px) {
  .topbar { height: 40px; }
  .topbar-inner { padding: 0 16px; }
  .topbar-reviews { gap: 4px; }
  .review-badge { padding: 4px 6px; gap: 4px; }
  .review-badge__stars { display: none; }
  .review-badge__score { font-size: 0.75rem; }
  .review-divider { margin: 0 2px; height: 14px; }
  .top-cta { padding: 4px 12px; font-size: 0.64rem; letter-spacing: 0.1em; }
}
@media (max-width: 480px) {
  .topbar { height: 36px; }
  .topbar-inner { padding: 0 12px; }
  .review-badge { padding: 3px 4px; gap: 3px; }
  .review-badge__score { font-size: 0.7rem; }
  .review-badge__icon { display: none; }
  .review-divider { margin: 0 1px; height: 12px; }
  .top-cta { padding: 3px 8px; font-size: 0.6rem; letter-spacing: 0.06em; }
}
@media (max-width: 375px) {
  .topbar { height: 34px; }
  .topbar-inner { padding: 0 8px; }
  .review-badge { padding: 2px 3px; gap: 2px; }
  .top-cta { padding: 2px 6px; font-size: 0.55rem; letter-spacing: 0.04em; }
}
</style>
