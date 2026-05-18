<template>
  <footer>
    <!-- THE HORIZON SILHOUETTE (SVG) — preserved unique brand element -->
    <div class="footer-horizon">
      <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="horizon-svg">
        <path d="M0 120H1440V60C1400 65 1360 72 1320 68C1280 64 1240 50 1200 45C1160 40 1120 45 1080 52C1040 59 1000 68 960 70C920 72 880 65 840 58C800 51 760 42 720 40C680 38 640 42 600 48C560 54 520 62 480 65C440 68 400 65 360 58C320 51 280 40 240 35C200 30 160 32 120 38C80 44 40 52 0 60V120Z" fill="currentColor"/>
        <g class="acacia-group" transform="translate(1100, 35) scale(0.6)">
          <path d="M20 50C20 50 5 45 0 35C0 25 20 20 50 20C80 20 100 25 100 35C95 45 80 50 80 50L55 80L45 80L20 50Z" fill="currentColor"/>
          <rect x="47" y="50" width="6" height="40" fill="currentColor"/>
        </g>
        <g class="acacia-group" transform="translate(300, 50) scale(0.4)">
          <path d="M20 50C20 50 5 45 0 35C0 25 20 20 50 20C80 20 100 25 100 35C95 45 80 50 80 50L55 80L45 80L20 50Z" fill="currentColor"/>
          <rect x="47" y="50" width="6" height="40" fill="currentColor"/>
        </g>
      </svg>
    </div>

    <!-- TOPOGRAPHIC OVERLAY — preserved -->
    <div class="topo-bg"></div>

    <!-- BADGES / ACCREDITATION ROW (Miracle Experience style) -->
    <div class="footer-badges">
      <div class="badges-inner">
        <div class="badge-group">
          <span class="badge-label">Member of</span>
          <div class="badge-items">
            <span class="badge-item">TTB</span>
            <span class="badge-sep"></span>
            <span class="badge-item">TATO</span>
            <span class="badge-sep"></span>
            <span class="badge-item">TANAPA</span>
            <span class="badge-sep"></span>
            <span class="badge-item">TCAA</span>
          </div>
        </div>
        <div class="badge-divider"></div>
        <div class="badge-group">
          <span class="badge-label">Recognized by</span>
          <div class="badge-items">
            <span class="badge-item">TripAdvisor</span>
            <span class="badge-sep"></span>
            <span class="badge-item">SafariBookings</span>
            <span class="badge-sep"></span>
            <span class="badge-item">Google</span>
          </div>
        </div>
      </div>
    </div>

    <!-- MAIN FOOTER GRID (Miracle Experience column layout) -->
    <div class="footer-main">
      <!-- COLUMN 1: BRAND -->
      <div class="footer-col footer-col--brand">
        <div class="footer-logo">
          <img v-if="settings.site_logo_light" :src="getImageUrl(settings.site_logo_light)" alt="Ndauwo Safari Co." class="footer-logo-img" />
          <img v-else src="@/assets/ndauwologo.png" alt="Ndauwo Safari Co." class="footer-logo-img" />
        </div>
        <p class="brand-desc">
          Expeditions designed for the discerning explorer. We navigate the wilderness with precision, respect, and a commitment to the preservation of the African soul.
        </p>
        <div class="footer-coords">
          <div class="coord-line">
            <span class="coord-dot"></span>
            <span class="coord-text">HQ · ARUSHA — {{ settings.gps_hq || '3.3869° S, 36.6830° E' }}</span>
          </div>
          <div class="coord-line">
            <span class="coord-dot"></span>
            <span class="coord-text">BASE · SERENGETI — {{ settings.gps_serengeti || '2.3333° S, 34.8333° E' }}</span>
          </div>
        </div>
      </div>

      <!-- COLUMN 2: COMPANY -->
      <div class="footer-col">
        <h4 class="footer-col-title">COMPANY</h4>
        <ul class="footer-links">
          <li><router-link to="/about">About Us</router-link></li>
          <li><router-link to="/journal">Bush Stories</router-link></li>
          <li><router-link to="/gallery">Gallery</router-link></li>
          <li><router-link to="/reviews">Reviews</router-link></li>
          <li><router-link to="/contact">Contact</router-link></li>
          <li><router-link to="/careers">Careers</router-link></li>
          <li><router-link to="/press">Media Kit</router-link></li>
        </ul>
      </div>

      <!-- COLUMN 3: SAFARIS -->
      <div class="footer-col">
        <h4 class="footer-col-title">SAFARIS</h4>
        <ul class="footer-links">
          <li><router-link to="/safaris">All Safaris</router-link></li>
          <li><router-link to="/destinations">Destinations</router-link></li>
          <li><router-link to="/safari-types/luxury-safari">Luxury Safaris</router-link></li>
          <li><router-link to="/safari-types/tailor-made-safari">Tailor-Made</router-link></li>
          <li><router-link to="/safari-types/mountain-hiking">Kilimanjaro</router-link></li>
          <li><router-link to="/conservation">Conservation</router-link></li>
        </ul>
      </div>

      <!-- COLUMN 4: PLANNING -->
      <div class="footer-col">
        <h4 class="footer-col-title">PLANNING</h4>
        <ul class="footer-links">
          <li><router-link to="/planning/packing-list">Packing List</router-link></li>
          <li><router-link to="/planning/health-safety">Health & Safety</router-link></li>
          <li><router-link to="/planning/visa-entry">Visa & Entry</router-link></li>
          <li><router-link to="/planning/cultural-etiquette">Cultural Etiquette</router-link></li>
          <li><router-link to="/planning/accommodation-styles">Accommodation</router-link></li>
          <li>
            <a href="https://visa.immigration.go.tz/" target="_blank" rel="noopener" class="footer-link--external">
              Tanzania Visa Portal
              <ExternalLink :size="12" class="ext-icon" />
            </a>
          </li>
        </ul>
      </div>

      <!-- COLUMN 5: NEWSLETTER + SOCIAL (Miracle Experience style) -->
      <div class="footer-col footer-col--newsletter">
        <h4 class="footer-col-title">NEWSLETTER</h4>
        <p class="newsletter-desc">Receive seasonal dispatches, conservation reports, and priority access to limited-edition safari collections.</p>
        <div class="newsletter-form">
          <input type="email" placeholder="Email Address" class="newsletter-input" />
          <button class="newsletter-btn">Submit</button>
        </div>

        <!-- JOIN US -->
        <div class="footer-social-section">
          <span class="footer-subtitle">JOIN US</span>
          <div class="footer-social-icons">
            <a v-if="settings.social_instagram" :href="settings.social_instagram" target="_blank" rel="noopener" class="footer-social-link" aria-label="Instagram">
              <Instagram :size="16" stroke-width="1.5" />
            </a>
            <a v-if="settings.social_facebook" :href="settings.social_facebook" target="_blank" rel="noopener" class="footer-social-link" aria-label="Facebook">
              <Facebook :size="16" stroke-width="1.5" />
            </a>
            <a v-if="settings.contact_email" :href="`mailto:${settings.contact_email}`" class="footer-social-link" aria-label="Email">
              <Mail :size="16" stroke-width="1.5" />
            </a>
          </div>
        </div>

        <!-- REVIEW US -->
        <div class="footer-social-section">
          <span class="footer-subtitle">REVIEW US</span>
          <div class="footer-social-icons">
            <a href="#" class="footer-social-link" aria-label="TripAdvisor">
              <svg width="16" height="16" viewBox="0 0 48 48" fill="none">
                <circle cx="24" cy="24" r="23" fill="#00AA6C" stroke="#00AA6C" stroke-width="2"/>
                <path d="M24 8C24 8 28 20 28 20C28 20 40 20 40 20C40 20 30 28 30 28C30 28 34 40 34 40C34 40 24 32 24 32C24 32 14 40 14 40C14 40 18 28 18 28C18 28 8 20 8 20C8 20 20 20 20 20C20 20 24 8 24 8Z" fill="white"/>
              </svg>
            </a>
            <a href="#" class="footer-social-link" aria-label="Google Reviews">
              <svg width="16" height="16" viewBox="0 0 48 48">
                <path d="M43.6 20.1H24v8.4h11.3C34 34.5 29.5 38 24 38c-7.7 0-14-6.3-14-14s6.3-14 14-14c3.4 0 6.5 1.2 8.9 3.4l6.3-6.3C35.3 3.2 29.9 1 24 1 11.3 1 1 11.3 1 24s10.3 23 23 23c11.5 0 21.3-8.6 22.9-20H43.6z" fill="#4285F4"/>
                <path d="M6.3 14.7l7.3 5.6C15.4 15.7 19.4 13 24 13c3.4 0 6.5 1.2 8.9 3.4l6.3-6.3C35.3 3.2 29.9 1 24 1 16 1 9 5.4 5.1 12.1l1.2 2.6z" fill="#EA4335"/>
                <path d="M24 47c6.5 0 12-2.4 16.2-6.3l-7.3-5.6C30.5 37.2 27.4 38 24 38c-5.5 0-10-3.5-11.7-8.5l-7.3 5.6C8 40.6 15.5 47 24 47z" fill="#34A853"/>
                <path d="M43.6 20.1H24v8.4h11.3c-1.2 3.2-3.5 5.8-6.6 7.5l7.3 5.6c5.1-4.7 8-11.6 8-17.6 0-1.4-.1-2.8-.4-4.1l.3.2z" fill="#FBBC05"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- BOTTOM BAR -->
    <div class="footer-bottom">
      <div class="footer-bottom-inner">
        <div class="footer-meta">
          <span class="meta-item">EST. 2010 · ARUSHA, TANZANIA</span>
          <span class="meta-sep">|</span>
          <span class="meta-item">LICENSED TTB · TATO PLATINUM MEMBER</span>
        </div>
        <div class="footer-legal">
          <router-link to="/privacy">Privacy Policy</router-link>
          <router-link to="/terms">Terms of Service</router-link>
          <router-link to="/booking">Booking Terms</router-link>
          <span class="copyright">© {{ new Date().getFullYear() }} Ndauwo Safari Co.</span>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { Instagram, Facebook, Mail, ExternalLink } from 'lucide-vue-next'
import { useSettings } from '../composables/useSettings'

const { settings, getImageUrl } = useSettings()
</script>

<style scoped>
footer {
  background: var(--ebony);
  color: var(--ivory);
  position: relative;
  overflow: hidden;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   HORIZON SILHOUETTE — preserved unique brand element
   ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.footer-horizon {
  width: 100%;
  height: 120px;
  background: transparent;
  color: var(--ebony);
  margin-top: -1px;
}

.horizon-svg {
  width: 100%;
  height: 100%;
  display: block;
  transform: translateY(1px);
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   TOPOGRAPHIC OVERLAY — preserved
   ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.topo-bg {
  position: absolute;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg width='800' height='800' viewBox='0 0 800 800' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M100 100C150 150 250 150 300 100S450 50 500 100S650 150 700 100M100 200C150 250 250 250 300 200S450 150 500 200S650 250 700 200M100 300C150 350 250 350 300 300S450 250 500 300S650 350 700 300' stroke='rgba(226, 121, 27, 0.05)' fill='none' stroke-width='1'/%3E%3C/svg%3E");
  background-size: 800px;
  opacity: 0.3;
  pointer-events: none;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   BADGES ROW — Miracle Experience style accreditations
   ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.footer-badges {
  position: relative;
  z-index: 2;
  border-top: 1px solid rgba(226, 121, 27, 0.1);
  border-bottom: 1px solid rgba(226, 121, 27, 0.1);
  padding: 24px 8%;
  background: rgba(0, 0, 0, 0.15);
}

.badges-inner {
  max-width: 1400px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 40px;
}

.badge-group {
  display: flex;
  align-items: center;
  gap: 16px;
}

.badge-label {
  font-size: 0.62rem;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.3);
  white-space: nowrap;
}

.badge-items {
  display: flex;
  align-items: center;
  gap: 0;
}

.badge-item {
  font-family: var(--f-serif);
  font-size: 0.85rem;
  font-weight: 500;
  color: rgba(255, 255, 255, 0.5);
  letter-spacing: 0.04em;
  padding: 2px 12px;
}

.badge-sep {
  width: 1px;
  height: 14px;
  background: rgba(255, 255, 255, 0.08);
}

.badge-divider {
  width: 1px;
  height: 28px;
  background: rgba(255, 255, 255, 0.06);
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   MAIN FOOTER GRID
   ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.footer-main {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1fr 1.5fr;
  gap: 60px;
  padding: 80px 8% 70px;
  max-width: 1400px;
  margin: 0 auto;
  position: relative;
  z-index: 2;
}

.footer-col {
  display: flex;
  flex-direction: column;
}

/* Brand column */
.footer-col--brand {
  padding-right: 20px;
}

.footer-logo-img {
  height: 42px;
  width: auto;
  margin-bottom: 28px;
  filter: brightness(0) invert(1);
  opacity: 0.9;
}

.brand-desc {
  font-size: 0.85rem;
  line-height: 1.8;
  color: rgba(255, 255, 255, 0.35);
  font-weight: 300;
  margin-bottom: 28px;
}

.footer-coords {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.coord-line {
  display: flex;
  align-items: center;
  gap: 10px;
}

.coord-dot {
  width: 4px;
  height: 4px;
  border-radius: 50%;
  background: var(--gold);
  flex-shrink: 0;
}

.coord-text {
  font-family: var(--f-sans);
  font-size: 0.7rem;
  color: rgba(255, 255, 255, 0.35);
  letter-spacing: 0.04em;
}

/* Column titles */
.footer-col-title {
  font-size: 0.7rem;
  letter-spacing: 0.35em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 32px;
  font-weight: 500;
}

/* Link lists */
.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 14px;
}

.footer-links a {
  color: rgba(255, 255, 255, 0.45);
  text-decoration: none;
  font-size: 0.85rem;
  font-weight: 300;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.footer-links a:hover {
  color: var(--gold);
}

.footer-link--external {
  color: rgba(255, 255, 255, 0.6) !important;
}

.ext-icon {
  opacity: 0.5;
}

/* Newsletter column */
.footer-col--newsletter {
  gap: 0;
}

.newsletter-desc {
  font-size: 0.82rem;
  color: rgba(255, 255, 255, 0.4);
  line-height: 1.6;
  margin-bottom: 20px;
  font-weight: 300;
}

.newsletter-form {
  display: flex;
  gap: 0;
  margin-bottom: 36px;
}

.newsletter-input {
  flex: 1;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-right: none;
  padding: 10px 14px;
  color: var(--ivory);
  font-family: var(--f-sans);
  font-size: 0.82rem;
  border-radius: 3px 0 0 3px;
  outline: none;
  transition: border-color 0.3s ease;
}

.newsletter-input::placeholder {
  color: rgba(255, 255, 255, 0.2);
}

.newsletter-input:focus {
  border-color: rgba(226, 121, 27, 0.4);
}

.newsletter-btn {
  background: var(--gold);
  color: #fff;
  border: 1px solid var(--gold);
  padding: 10px 18px;
  font-family: var(--f-sans);
  font-size: 0.72rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  cursor: pointer;
  border-radius: 0 3px 3px 0;
  transition: all 0.3s ease;
  white-space: nowrap;
}

.newsletter-btn:hover {
  background: #c96817;
  border-color: #c96817;
}

/* Social sections */
.footer-social-section {
  margin-bottom: 20px;
}

.footer-subtitle {
  display: block;
  font-size: 0.62rem;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.25);
  margin-bottom: 12px;
}

.footer-social-icons {
  display: flex;
  gap: 14px;
  align-items: center;
}

.footer-social-link {
  color: rgba(255, 255, 255, 0.3);
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.04);
}

.footer-social-link:hover {
  color: var(--gold);
  background: rgba(226, 121, 27, 0.12);
  transform: translateY(-2px);
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   BOTTOM BAR
   ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.footer-bottom {
  background: rgba(0, 0, 0, 0.35);
  padding: 28px 8%;
  border-top: 1px solid rgba(255, 255, 255, 0.04);
  position: relative;
  z-index: 2;
}

.footer-bottom-inner {
  max-width: 1400px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.footer-meta {
  display: flex;
  align-items: center;
  gap: 0;
}

.meta-item {
  font-size: 0.62rem;
  letter-spacing: 0.18em;
  color: rgba(255, 255, 255, 0.2);
  text-transform: uppercase;
}

.meta-sep {
  color: rgba(255, 255, 255, 0.08);
  margin: 0 16px;
  font-size: 0.62rem;
}

.footer-legal {
  display: flex;
  gap: 22px;
  align-items: center;
}

.footer-legal a {
  font-size: 0.72rem;
  color: rgba(255, 255, 255, 0.25);
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer-legal a:hover {
  color: var(--gold);
}

.copyright {
  font-size: 0.72rem;
  color: rgba(255, 255, 255, 0.15);
  margin-left: 10px;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   RESPONSIVE
   ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
@media (max-width: 1200px) {
  .footer-main {
    grid-template-columns: 1fr 1fr 1fr;
    gap: 50px;
  }
  .footer-col--brand { grid-column: 1 / -1; padding-right: 0; }
  .footer-col--newsletter { grid-column: span 2; }
  .badges-inner { flex-direction: column; gap: 16px; }
  .badge-divider { width: 100%; height: 1px; }
}

@media (max-width: 1024px) {
  .footer-main { gap: 40px; padding: 60px 6% 50px; }
  .footer-col--brand { max-width: 600px; }
  .footer-bottom { padding: 24px 6%; }
  .footer-bottom-inner { gap: 12px; }
}

@media (max-width: 768px) {
  .footer-horizon { height: 60px; }
  .footer-badges { padding: 16px 6%; }
  .badge-group { flex-direction: column; gap: 8px; align-items: flex-start; }
  .badge-items { flex-wrap: wrap; gap: 4px; }
  .badge-sep { display: none; }
  .badge-item { padding: 2px 8px; font-size: 0.78rem; }
  .footer-main {
    grid-template-columns: 1fr 1fr;
    gap: 36px;
    padding: 40px 6%;
  }
  .footer-col--newsletter { grid-column: 1 / -1; }
  .footer-col-title { margin-bottom: 24px; }
  .footer-links { gap: 12px; }
  .footer-links a { font-size: 0.8rem; }
  .brand-desc { font-size: 0.8rem; }
  .footer-logo-img { height: 36px; margin-bottom: 20px; }
  .newsletter-desc { font-size: 0.78rem; }
  .newsletter-input { font-size: 0.78rem; padding: 8px 12px; }
  .newsletter-btn { font-size: 0.68rem; padding: 8px 14px; }
  .footer-bottom { padding: 20px 6%; }
  .footer-bottom-inner { flex-direction: column; gap: 16px; align-items: flex-start; }
  .footer-meta { flex-direction: column; align-items: flex-start; gap: 6px; }
  .meta-sep { display: none; }
  .footer-legal { flex-wrap: wrap; gap: 12px; }
  .footer-legal a { font-size: 0.68rem; }
  .copyright { font-size: 0.68rem; }
}

@media (max-width: 640px) {
  .footer-main { padding: 36px 5%; gap: 28px; }
  .brand-desc { font-size: 0.78rem; }
  .footer-links a { font-size: 0.78rem; }
  .footer-col-title { font-size: 0.65rem; margin-bottom: 20px; }
  .footer-bottom { padding: 16px 5%; }
  .footer-bottom-inner { gap: 12px; }
  .footer-legal { gap: 10px; }
  .footer-social-link { width: 28px; height: 28px; }
}

@media (max-width: 480px) {
  .footer-horizon { height: 40px; }
  .footer-badges { padding: 14px 5%; }
  .badge-label { font-size: 0.55rem; }
  .badge-item { font-size: 0.7rem; padding: 2px 6px; }
  .footer-main { grid-template-columns: 1fr; gap: 32px; padding: 32px 5%; }
  .footer-col--newsletter { grid-column: 1; }
  .newsletter-form { flex-direction: column; gap: 8px; }
  .newsletter-input { border-right: 1px solid rgba(255,255,255,0.08); border-radius: 3px; font-size: 16px !important; }
  .newsletter-btn { border-radius: 3px; padding: 12px 14px; }
  .footer-logo-img { height: 32px; }
  .coord-text { font-size: 0.62rem; }
  .footer-bottom { padding: 16px 5%; }
  .footer-meta .meta-item { font-size: 0.55rem; }
  .footer-legal { flex-direction: column; align-items: flex-start; gap: 6px; }
  .footer-legal a, .copyright { font-size: 0.65rem; }
}

@media (max-width: 375px) {
  .footer-main { padding: 24px 4%; gap: 24px; }
  .footer-logo-img { height: 28px; margin-bottom: 16px; }
  .brand-desc { font-size: 0.75rem; }
  .footer-links a { font-size: 0.75rem; }
  .footer-links { gap: 10px; }
  .newsletter-input { font-size: 16px !important; padding: 10px 10px; }
  .footer-bottom { padding: 14px 4%; }
  .footer-legal a, .copyright { font-size: 0.6rem; }
}
</style>
