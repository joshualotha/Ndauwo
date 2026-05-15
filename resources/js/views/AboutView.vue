<template>
  <div class="editorial-about" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    
    <!-- 1. The Cinematic Window (Hero) -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      
      <div class="premium-hero-content">
        <span class="hero-label" v-reveal>✦ The Ndauwo Standard</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Precision in the ', class: 'white' },
            { text: 'Wilderness', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
      </div>
    </section>

    <!-- 2. The Philosophy (Generous Whitespace, 2-Column) -->
    <section class="editorial-philosophy">
      <div class="philosophy-inner">
        <div class="phil-intro" v-reveal>
          <span class="section-label">01. Our Philosophy</span>
          <h2 class="section-title">We do not curate vacations.<br>We engineer <em>encounters</em>.</h2>
        </div>
        
        <div class="phil-columns" v-reveal>
          <div class="phil-col">
            <p>
              Ndauwo was born from the violent beauty of the rift valley. We exist at the absolute frontier of high-end hospitality and raw, uncompromised nature. Our expeditions are defined entirely by what we exclude: the noise, the crowds, the expected.
            </p>
          </div>
          <div class="phil-col">
            <p>
              To travel with us is to strip away the insulation of standard tourism. We place you at the bleeding edge of the ecosystem, where true luxury is found in absolute isolation and flawless execution.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. The Curated Grid (Symmetrical Imagery) -->
    <section class="editorial-gallery">
      <div class="gallery-inner">
        <div class="gallery-header" v-reveal>
          <span class="section-label">02. The Archive</span>
          <h2 class="section-title">Moments of <em>Clarity</em></h2>
        </div>
        
        <div class="gallery-grid">
          <div class="grid-item" v-reveal>
            <div class="image-wrap">
              <img src="/image-09.jpg" alt="Elephant Herd">
            </div>
            <div class="item-meta">
              <span class="item-title">Tarangire Convergence</span>
              <span class="item-sub">Dry Season</span>
            </div>
          </div>
          <div class="grid-item" v-reveal style="transition-delay: 0.1s">
            <div class="image-wrap">
              <img src="/image-09.jpg" alt="Leopard">
            </div>
            <div class="item-meta">
              <span class="item-title">Apex Observation</span>
              <span class="item-sub">Serengeti Plains</span>
            </div>
          </div>
          <div class="grid-item" v-reveal>
            <div class="image-wrap">
              <img src="/image-19.jpg" alt="Tribe">
            </div>
            <div class="item-meta">
              <span class="item-title">Cultural Exchange</span>
              <span class="item-sub">Ngorongoro Highlands</span>
            </div>
          </div>
          <div class="grid-item" v-reveal style="transition-delay: 0.1s">
            <div class="image-wrap">
              <img src="/image-06.jpg" alt="Camp">
            </div>
            <div class="item-meta">
              <span class="item-title">Mobile Logistics</span>
              <span class="item-sub">Mara River Crossing</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. The Core Pillars (Structured Features) -->
    <section class="editorial-pillars">
      <div class="pillars-inner">
        <div class="pillar" v-reveal>
          <span class="pillar-num">I</span>
          <h3 class="pillar-title">Deploy<br><em>Anywhere</em></h3>
          <p class="pillar-desc">Our mobile camps move with the herds. No fixed coordinates. Only tactical response to the rhythm of the landscape.</p>
        </div>
        <div class="pillar" v-reveal style="transition-delay: 0.1s">
          <span class="pillar-num">II</span>
          <h3 class="pillar-title">Silent<br><em>Approach</em></h3>
          <p class="pillar-desc">A fleet of customized, low-emission Land Cruisers engineered for zero-trace entry into the most hostile environments.</p>
        </div>
        <div class="pillar" v-reveal style="transition-delay: 0.2s">
          <span class="pillar-num">III</span>
          <h3 class="pillar-title">Customized<br><em>Expeditions</em></h3>
          <p class="pillar-desc">Unique journey designs that don't just follow trails, but possess the flexibility to react to the vibration of a hunt before it begins.</p>
        </div>
      </div>
    </section>

    <!-- 5. The Architects (Founders Section - Split Screen) -->
    <section class="editorial-architects">
      <div class="architects-inner">
        <div class="arch-image" v-reveal>
           <img :src="getImage('founder_portrait', '/image-13.jpg')" alt="Ndauwo Heritage">
        </div>
        <div class="arch-content" v-reveal>
          <span class="section-label">03. The Founders</span>
          <h2 class="arch-quote">"In the wild, there is no substitute for <em>truth.</em>"</h2>
          <p class="arch-body">
            Ndauwo was born from a lineage of Tanzanian field chiefs. We didn't learn the bush from books; we learned it from the vibration of the earth and the shifting scents of the acacia winds.
          </p>
          <p class="arch-body">
            Today, Ndauwo remains fiercely independent. We answer only to the land and to the guests who seek its most authentic encounters.
          </p>
          <div class="arch-sig">
            <span class="sig-name">Ndauwo Safari Co.</span>
            <span class="sig-loc">Arusha, Tanzania</span>
          </div>
        </div>
      </div>
    </section>

    <!-- 6. Clean Call to Action -->
    <section class="editorial-cta">
      <div class="cta-inner" v-reveal>
        <span class="section-label">Private Access</span>
        <h2 class="section-title">Request the <em>Extraordinary</em></h2>
        <router-link to="/contact" class="btn-primary-elegant">Initiate Inquiry</router-link>
      </div>
    </section>

  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { usePageImages } from '../composables/usePageImages'

const { images, fetchImages, getImage } = usePageImages('about');

onMounted(() => {
  fetchImages();
});
</script>

<style scoped>
/* 
  EDITORIAL SYSTEM 
  Prioritizing: Whitespace, Symmetry, Playfair Display (Serif), Jost (Sans), Ivory/Forest Palette 
*/
.editorial-about {
  background-color: var(--ivory);
  color: var(--text-dark);
  font-family: 'Jost', sans-serif;
  overflow-x: hidden;
}

em {
  font-style: italic;
  font-weight: 400;
  color: var(--gold);
}

.section-label {
  font-size: 0.8rem;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  color: var(--gold);
  display: block;
  margin-bottom: 20px;
  font-weight: 500;
}

.section-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(3rem, 5vw, 4.5rem);
  color: var(--forest);
  line-height: 1.15;
  font-weight: 400;
}

/* 2. PHILOSOPHY */
.editorial-philosophy {
  padding: 150px 5%;
  background: var(--ivory);
}
.philosophy-inner {
  max-width: 1200px;
  margin: 0 auto;
}
.phil-intro {
  margin-bottom: 80px;
  max-width: 900px;
}
.phil-columns {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
}
.phil-col p {
  font-size: 1.25rem;
  line-height: 2;
  color: var(--text-dark);
  font-weight: 300;
  margin-bottom: 0;
}

/* 3. CURATED GRID */
.editorial-gallery {
  padding: 100px 5% 150px;
  background: #FFF; /* Pure white for gallery contrast */
}
.gallery-inner {
  max-width: 1400px;
  margin: 0 auto;
}
.gallery-header {
  text-align: center;
  margin-bottom: 80px;
}
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 40px;
}
.grid-item {
  display: flex;
  flex-direction: column;
}
.image-wrap {
  width: 100%;
  aspect-ratio: 4/3;
  overflow: hidden;
  margin-bottom: 25px;
  background: #f5f5f5;
}
.image-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 1.2s ease;
}
.grid-item:hover .image-wrap img {
  transform: scale(1.03);
}
.item-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
  color: var(--forest);
  display: block;
  margin-bottom: 5px;
}
.item-sub {
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.15em;
  color: #888;
}

/* 4. CORE PILLARS */
.editorial-pillars {
  padding: 150px 5%;
  background: var(--ivory);
  border-top: 1px solid #EAEAEA;
}
.pillars-inner {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 60px;
  max-width: 1400px;
  margin: 0 auto;
}
.pillar {
  padding-right: 40px;
}
.pillar-num {
  font-family: 'Playfair Display', serif;
  font-size: 2rem;
  color: var(--gold);
  display: block;
  margin-bottom: 30px;
}
.pillar-title {
  font-family: 'Playfair Display', serif;
  font-size: 2.5rem;
  color: var(--forest);
  line-height: 1.1;
  margin-bottom: 25px;
}
.pillar-desc {
  font-size: 1.1rem;
  line-height: 1.9;
  color: var(--text-mid);
  font-weight: 300;
}

/* 5. THE ARCHITECTS (Founder Split) */
.editorial-architects {
  padding: 150px 5%;
  background: #FFF;
}
.architects-inner {
  display: grid;
  grid-template-columns: 1fr 1fr;
  align-items: center;
  gap: 100px;
  max-width: 1200px;
  margin: 0 auto;
}
.arch-image {
  width: 100%;
  aspect-ratio: 3/4;
  overflow: hidden;
}
.arch-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  filter: grayscale(100%);
}
.arch-quote {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 4vw, 3.5rem);
  color: var(--forest);
  line-height: 1.2;
  margin-bottom: 40px;
}
.arch-body {
  font-size: 1.15rem;
  line-height: 2;
  color: var(--text-dark);
  font-weight: 300;
  margin-bottom: 25px;
}
.arch-sig {
  margin-top: 50px;
  padding-top: 30px;
  border-top: 1px solid #EAEAEA;
  display: flex;
  flex-direction: column;
}
.sig-name {
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
  color: var(--forest);
}
.sig-loc {
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.2em;
  color: var(--gold);
  margin-top: 5px;
}

/* 6. CTA */
.editorial-cta {
  padding: 200px 5%;
  background: var(--ivory);
  text-align: center;
}
.cta-inner {
  max-width: 800px;
  margin: 0 auto;
}
.editorial-cta .section-title {
  margin-bottom: 60px;
}
.btn-primary-elegant {
  display: inline-block;
  padding: 1.5rem 4rem;
  background: var(--forest);
  color: #FFF;
  text-transform: uppercase;
  letter-spacing: 0.3em;
  font-size: 0.85rem;
  text-decoration: none;
  transition: all 0.4s ease;
  border: 1px solid var(--forest);
}
.btn-primary-elegant:hover {
  background: transparent;
  color: var(--forest);
}

/* RESPONSIVE */
@media (max-width: 1024px) {
  .phil-columns { grid-template-columns: 1fr; gap: 40px; }
  .pillars-inner { grid-template-columns: 1fr; gap: 80px; }
  .pillar { padding-right: 0; }
  .architects-inner { grid-template-columns: 1fr; gap: 60px; }
  .arch-image { aspect-ratio: 16/9; }
}

@media (max-width: 768px) {
  .gallery-grid { grid-template-columns: 1fr; }
  .section-title { font-size: 2.5rem; }
  .btn-primary-elegant { width: 100%; max-width: 300px; padding: 1.5rem 0;}
}
</style>

