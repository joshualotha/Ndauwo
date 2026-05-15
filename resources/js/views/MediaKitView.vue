<template>
  <div class="media-page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    <!-- Premium Hero Section -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label" v-reveal>✦ Press & Assets</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Media ', class: 'white' },
            { text: 'Kit', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
      </div>
    </section>

    <!-- Intro -->
    <section class="content-section">
      <div class="content-inner" v-reveal>
        <span class="section-label" style="color:var(--gold); display:block; margin-bottom: 20px; font-weight: 500; letter-spacing: 0.3em; font-size: 0.85rem; text-transform: uppercase;">Journalist Resources</span>
        <h2 class="content-heading">The Ndauwo <em>Archive</em></h2>
        <p class="intro-text">
          Access our curated repository of high-resolution imagery, brand guidelines, and official press releases. For bespoke editorial requests, long-form interviews with our Founders, or embedded press trips, please contact our international media desk directly.
        </p>
      </div>
    </section>

    <!-- Asset Portal -->
    <section class="asset-portal">
      <div class="portal-grid">
        <!-- Asset Column 1 -->
        <div class="asset-column" v-reveal>
          <h3 class="column-title">Digital Assets</h3>
          <div class="asset-list">
            <a href="#" class="asset-link">
              <span class="asset-name">Brand Identity Guidelines</span>
              <span class="asset-meta">PDF / 12MB</span>
            </a>
            <a href="#" class="asset-link">
              <span class="asset-name">Master Logo Pack (Dark/Light)</span>
              <span class="asset-meta">ZIP / 45MB</span>
            </a>
            <a href="#" class="asset-link">
              <span class="asset-name">Typography Suite</span>
              <span class="asset-meta">ZIP / 8MB</span>
            </a>
          </div>
        </div>
        
        <!-- Asset Column 2 -->
        <div class="asset-column" v-reveal style="transition-delay: 0.1s">
          <h3 class="column-title">Photography & Film</h3>
          <div class="asset-list">
            <a href="#" class="asset-link">
              <span class="asset-name">High-Res Camp Interiors</span>
              <span class="asset-meta">Gallery Link</span>
            </a>
            <a href="#" class="asset-link">
              <span class="asset-name">Wildlife & Expedition B-Roll</span>
              <span class="asset-meta">4K MP4 / 1.2GB</span>
            </a>
            <a href="#" class="asset-link">
              <span class="asset-name">Founders Portrait Series</span>
              <span class="asset-meta">ZIP / 85MB</span>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Fact Sheet & Contact -->
    <section class="fact-sheet-contact">
      <div class="fact-sheet-wrap" v-reveal>
        <div class="fact-sheet">
          <h3 class="section-title">Corporate <em>Fact Sheet</em></h3>
          <ul class="fact-list">
            <li><strong>Founded:</strong> 2012 by indigenous Tanzanian field chiefs.</li>
            <li><strong>Headquarters:</strong> Arusha, Tanzania (with satellite logistics in Seronera).</li>
            <li><strong>Operational Zones:</strong> Serengeti, Ngorongoro, Tarangire, Ruaha.</li>
            <li><strong>Fleet:</strong> 18 Custom-Modified, Silent-Approach Land Cruisers.</li>
            <li><strong>Sustainability:</strong> 100% solar operational footprint; zero single-use plastics.</li>
          </ul>
        </div>
        
        <div class="press-contact">
          <h3 class="section-title">Press <em>Contact</em></h3>
          <div class="contact-card">
            <p class="contact-name">Elena Rostova</p>
            <p class="contact-role">Global Director of Communications</p>
            <div v-if="settings.contact_email" class="contact-link"><a :href="`mailto:${settings.contact_email}`">{{ settings.contact_email }}</a></div>
            <div v-if="settings.contact_phone" class="contact-link"><a :href="`tel:${settings.contact_phone.replace(/\s/g, '')}`">{{ settings.contact_phone }}</a></div>
          </div>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { usePageImages } from '../composables/usePageImages'
import { useSettings } from '../composables/useSettings'

const { images, fetchImages, getImage } = usePageImages('media_kit');
const { settings } = useSettings();

onMounted(() => {
  fetchImages();
});
</script>

<style scoped>
.media-page {
  background: var(--ivory);
  overflow-x: hidden;
}

/* HERO - Now using Global .premium-hero */

/* Intro Section */
.content-section { 
  padding: 120px 5% 50px; 
  background: var(--ivory); 
}
.content-inner { 
  max-width: 900px; 
  margin: 0 auto; 
  text-align: center; 
}
.content-heading { 
  font-family: 'Playfair Display', serif; 
  font-size: clamp(2.5rem, 5vw, 4rem); 
  color: var(--forest); 
  font-weight: 400; 
  margin-bottom: 40px; 
  line-height: 1.1; 
}
.content-heading em { 
  color: var(--gold); 
  font-style: italic; 
}
.intro-text { 
  font-size: 1.25rem; 
  line-height: 2.1; 
  color: var(--text-dark); 
  font-weight: 300; 
}

/* Asset Portal */
.asset-portal {
  padding: 80px 5% 150px;
  background: var(--ivory);
}
.portal-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  max-width: 1200px;
  margin: 0 auto;
}
.column-title {
  font-family: 'Playfair Display', serif;
  font-size: 2.2rem;
  color: var(--forest);
  margin-bottom: 40px;
  border-bottom: 1px solid #EAEAEA;
  padding-bottom: 20px;
}
.asset-list {
  display: flex;
  flex-direction: column;
}
.asset-link {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 25px 0;
  border-bottom: 1px solid #EAEAEA;
  text-decoration: none;
  transition: all 0.3s;
}
.asset-link:hover {
  border-bottom-color: var(--gold);
}
.asset-name {
  font-size: 1.05rem;
  color: var(--forest);
  transition: color 0.3s;
}
.asset-link:hover .asset-name {
  color: var(--gold);
}
.asset-meta {
  font-size: 0.75rem;
  color: #999;
  text-transform: uppercase;
  letter-spacing: 0.15em;
}

/* Fact Sheet & Contact */
.fact-sheet-contact {
  background-color: #1A1A1A; /* Premium Dark */
  color: #FFF;
  padding: 150px 5%;
}
.fact-sheet-wrap {
  display: grid;
  grid-template-columns: 1.5fr 1fr;
  gap: 100px;
  max-width: 1400px;
  margin: 0 auto;
}
.section-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 4vw, 3rem);
  color: #FFF;
  margin-bottom: 50px;
  font-weight: 400;
}
.section-title em {
  font-style: italic;
  color: var(--gold);
}

.fact-list {
  list-style: none;
  padding: 0;
  margin: 0;
}
.fact-list li {
  font-size: 1.15rem;
  line-height: 2;
  color: rgba(255,255,255,0.7);
  margin-bottom: 25px;
  padding-bottom: 25px;
  border-bottom: 1px solid rgba(255,255,255,0.1);
  font-weight: 300;
}
.fact-list strong {
  color: var(--gold);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  font-size: 0.85rem;
  margin-right: 15px;
  display: inline-block;
  min-width: 140px;
}

.contact-card {
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.1);
  padding: 50px 40px;
}
.contact-name {
  font-family: 'Playfair Display', serif;
  font-size: 1.8rem;
  color: #FFF;
  margin-bottom: 5px;
}
.contact-role {
  font-size: 0.85rem;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: #888;
  margin-bottom: 40px;
}
.contact-link {
  margin-bottom: 15px;
}
.contact-link a {
  color: var(--gold);
  text-decoration: none;
  font-size: 1.1rem;
  transition: opacity 0.3s;
}
.contact-link a:hover {
  opacity: 0.7;
}

/* Responsive */
@media (max-width: 1024px) {
  .fact-sheet-wrap {
    grid-template-columns: 1fr;
    gap: 80px;
  }
}
@media (max-width: 900px) {
  .portal-grid {
    grid-template-columns: 1fr;
    gap: 60px;
  }
}
@media (max-width: 600px) {
  .asset-link {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }
  .fact-list strong {
    display: block;
    margin-bottom: 5px;
  }
  .contact-card {
    padding: 30px 20px;
  }
}
</style>
