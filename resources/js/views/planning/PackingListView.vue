<template>
  <div class="planning-view packing-list">
    <!-- LUJO: Cinematic Hero -->
    <section class="editorial-hero">
      <div class="hero-image-wrap" :style="images.hero_bg ? { backgroundImage: `url(${images.hero_bg})` } : {}"></div>
      <div class="hero-vignette"></div>
      <div class="hero-content">
        <span class="eyebrow" v-reveal>✦ The Safari Wardrobe</span>
        <h1 class="headline">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Packing ', class: 'white' },
            { text: 'Essentials', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="summary" v-reveal>A curated guide to the gear and garments required for a dignified and intentional journey through the Tanzanian wild.</p>
      </div>
    </section>

    <!-- THE CAPSULE ETHOS -->
    <section class="editorial-spread" v-reveal>
      <div class="spread-inner">
        <div class="visual-chapter">
          <img :src="getImage('spread_img', 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?w=1200&q=80')" alt="Safari Gear" class="spread-img" />
          <div class="img-caption"><em>Refining the expedition.</em> Packing as an exercise in restraint and quality.</div>
        </div>
        <div class="narrative-chapter">
          <span class="label-gold">The Philosophy</span>
          <h2>The Art of <em>Being Ready</em></h2>
          <p>Packing for a Ndauwo journey mirrors the safari itself: it is about choosing quality over quantity, and purpose over spectacle. We believe in the "Capsule Ethos"—a collection of versatile, high-performance layers that respect the environment in both color and footprint.</p>
          <div class="ethos-stats">
            <div class="e-stat">
              <strong>Organic</strong>
              <span>Linen & Cotton</span>
            </div>
            <div class="e-stat">
              <strong>Muted</strong>
              <span>The Bush Palette</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CHAPTER I: THE WARDROBE -->
    <section class="chapter-spread alt" v-reveal>
      <div class="chapter-content">
        <span class="chapter-num">Chapter I</span>
        <h2 class="chapter-title">The Field <em>Wardrobe</em></h2>
        <p>Your attire on safari should blend seamlessly with the environment. Muted tones are not just aesthetic; they are functional, preventing the attraction of tsetse flies and allowing you to remain inconspicuous to wildlife.</p>
        <div class="detail-grid">
          <div class="detail-i">
            <h4>The Bush Palette</h4>
            <p>Khaki, olive, sand, and taupe. Avoid deep blues and blacks which attract insects.</p>
          </div>
          <div class="detail-i">
            <h4>Technical Layers</h4>
            <p>Linen shirts for the heat, and a specialized fleece or pashmina for the dawn chill.</p>
          </div>
        </div>
      </div>
      <div class="chapter-visual">
        <img :src="getImage('chapter_img_1', 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=1000&q=80')" alt="Clothes" class="chapter-img" />
      </div>
    </section>

    <!-- CHAPTER II: THE OPTICS -->
    <section class="chapter-cinematic" v-reveal>
      <div class="cinematic-bg" :style="{ backgroundImage: `url(${getImage('cinematic_bg', 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1400&q=80')})` }"></div>
      <div class="cinematic-overlay"></div>
      <div class="cinematic-content">
        <span class="chapter-num">Chapter II</span>
        <h2 class="chapter-title">The <em>Optics</em></h2>
        <p>The tools that diminish the distance between you and the wild. In the bush, quality of glass is the only metric that matters.</p>
        <div class="optics-features">
          <div class="o-feat">
            <div class="icon-ring"><Binoculars class="icon" /></div>
            <h4>Binoculars</h4>
            <p>8x42 magnification is the gold standard for stability and light intake.</p>
          </div>
          <div class="o-feat">
            <div class="icon-ring"><Camera class="icon" /></div>
            <h4>Photography</h4>
            <p>A 100-400mm lens captures the soul of the wild without intrusion.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CHAPTER III: THE LOGISTICS -->
    <section class="chapter-spread" v-reveal>
      <div class="chapter-visual">
        <img :src="getImage('chapter_img_2', 'https://images.unsplash.com/photo-1530521954074-e64f6810b32d?w=1000&q=80')" alt="Planes" class="chapter-img" />
      </div>
      <div class="chapter-content">
        <span class="chapter-num">Chapter III</span>
        <h2 class="chapter-title">Aviation & <em>Logistics</em></h2>
        <p>Small-aircraft travel requires a specific approach to luggage. For safety and balance, strict protocols are observed on all bush flights.</p>
        <div class="logistics-list">
          <div class="l-item">
            <div class="l-label">Weight Limit</div>
            <div class="l-value">15kg (33lbs) Total</div>
          </div>
          <div class="l-item">
            <div class="l-label">Luggage Type</div>
            <div class="l-value">Soft-Sided Bags Only</div>
          </div>
          <div class="l-item">
            <div class="l-label">Exclusion</div>
            <div class="l-value">No Hard Shells or Spining Wheels</div>
          </div>
        </div>
      </div>
    </section>

    <!-- ETIQUETTE ADVISORY -->
    <section class="etiquette-advisory" v-reveal>
      <div class="advisory-inner">
        <span class="label-gold">Legal Notice</span>
        <h2>Notice of <em>Etiquette</em></h2>
        <p>Tanzania maintains strict regulations regarding environment and public conduct. Adherence is essential for a respectful journey.</p>
        <div class="etiquette-grid">
          <div class="e-card">
            <h4>Banned Sustance</h4>
            <p>Plastic carrier bags are strictly prohibited throughout Tanzania. Use fabric or paper alternatives.</p>
          </div>
          <div class="e-card">
            <h4>Restricted Attire</h4>
            <p>Camouflage clothing is reserved strictly for military personnel and is illegal to wear in public.</p>
          </div>
          <div class="e-card">
            <h4>Gratuities</h4>
            <p>Tipping is customary for exceptional service. We suggest $20 per guest, per day for your guide.</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { Shirt, Binoculars, Camera, Backpack, Scale, Zap, Coins, ShieldAlert, BookOpen } from 'lucide-vue-next'
import { usePageImages } from '../../composables/usePageImages'
import { onMounted } from 'vue'

const { images, fetchImages, getImage } = usePageImages('packing_list');

onMounted(() => {
  fetchImages();
});
</script>

<style scoped>
.planning-view {
  background: white;
  min-height: 100vh;
}

/* EDITORIAL HERO */
.editorial-hero {
  height: 90vh;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  overflow: hidden;
}

.hero-image-wrap {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
  transform: scale(1.05);
}

.hero-vignette {
  position: absolute;
  inset: 0;
  background: radial-gradient(circle, transparent 20%, rgba(0,0,0,0.6) 100%),
              linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8));
}

.hero-content {
  position: relative;
  z-index: 2;
  max-width: 800px;
  padding: 0 40px;
}

.eyebrow {
  display: block;
  font-size: 0.8rem;
  letter-spacing: 0.5em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 30px;
}

.headline {
  font-family: 'Playfair Display', serif;
  font-size: clamp(3rem, 8vw, 6rem);
  line-height: 1;
  margin-bottom: 40px;
}

.summary {
  font-size: 1.2rem;
  color: rgba(255,255,255,0.7);
  max-width: 600px;
  margin: 0 auto;
  font-weight: 300;
  line-height: 1.6;
}

/* EDITORIAL SPREAD */
.editorial-spread {
  padding: 140px 10%;
}

.spread-inner {
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 100px;
  align-items: center;
  max-width: 1400px;
  margin: 0 auto;
}

.spread-img {
  width: 100%;
  height: 700px;
  object-fit: cover;
  filter: sepia(0.2) contrast(1.1);
}

.img-caption {
  font-size: 0.85rem;
  color: var(--text-mid);
  margin-top: 20px;
  font-style: italic;
  font-family: 'Playfair Display', serif;
}

.narrative-chapter {
  padding-left: 40px;
}

.label-gold {
  display: block;
  font-size: 0.75rem;
  letter-spacing: 0.4em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 30px;
}

.narrative-chapter h2 {
  font-family: 'Playfair Display', serif;
  font-size: 3.5rem;
  line-height: 1.1;
  margin-bottom: 40px;
  color: var(--ebony);
}

.narrative-chapter h2 em {
  font-style: italic;
  font-weight: 400;
  color: var(--gold);
}

.narrative-chapter p {
  font-size: 1.2rem;
  line-height: 1.9;
  color: var(--text-mid);
  font-weight: 300;
  margin-bottom: 60px;
}

.ethos-stats {
  display: flex;
  gap: 80px;
}

.e-stat {
  display: flex;
  flex-direction: column;
}

.e-stat strong {
  font-family: 'Playfair Display', serif;
  font-size: 2.5rem;
  color: var(--ebony);
  margin-bottom: 10px;
}

.e-stat span {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.2em;
  color: var(--gold);
}

/* CHAPTER SPREADS */
.chapter-spread {
  padding: 100px 10%;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 100px;
  align-items: center;
}

.chapter-spread.alt {
  background: var(--ivory);
}

.chapter-num {
  font-family: 'Playfair Display', serif;
  font-size: 0.9rem;
  font-style: italic;
  color: var(--gold);
  margin-bottom: 20px;
  display: block;
}

.chapter-title {
  font-family: 'Playfair Display', serif;
  font-size: 3.5rem;
  margin-bottom: 30px;
  color: var(--ebony);
}

.chapter-title em {
  font-style: italic;
  font-weight: 400;
  color: var(--gold);
}

.chapter-content p {
  font-size: 1.1rem;
  line-height: 1.8;
  color: var(--text-mid);
  margin-bottom: 50px;
  font-weight: 300;
}

.detail-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
}

.detail-i h4 {
  font-family: 'Playfair Display', serif;
  font-size: 1.3rem;
  margin-bottom: 15px;
  border-bottom: 1px solid var(--gold);
  padding-bottom: 10px;
}

.detail-i p { font-size: 0.95rem; line-height: 1.6; }

.chapter-img {
  width: 100%;
  height: 600px;
  object-fit: cover;
}

/* CINEMATIC CHAPTER */
.chapter-cinematic {
  height: 80vh;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  text-align: center;
}

.cinematic-bg {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
}

.cinematic-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.6);
}

.cinematic-content {
  position: relative;
  z-index: 2;
  max-width: 900px;
}

.optics-features {
  display: flex;
  justify-content: center;
  gap: 100px;
  margin-top: 60px;
}

.o-feat {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}

.icon-ring {
  width: 80px;
  height: 80px;
  border: 1px solid var(--gold);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.icon-ring .icon {
  width: 30px;
  height: 30px;
  color: var(--gold);
}

.o-feat h4 {
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
}

.o-feat p {
  font-size: 0.9rem;
  color: rgba(255,255,255,0.6);
  max-width: 250px;
}

/* LOGISTICS LIST */
.logistics-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.l-item {
  display: flex;
  justify-content: space-between;
  padding: 20px 0;
  border-bottom: 1px solid rgba(0,0,0,0.1);
}

.l-label {
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--gold);
}

.l-value {
  font-family: 'Playfair Display', serif;
  font-size: 1.1rem;
  font-style: italic;
}

/* ETIQUETTE ADVISORY */
.etiquette-advisory {
  padding: 140px 10%;
  background: var(--ebony);
  color: white;
}

.advisory-inner {
  max-width: 1200px;
  margin: 0 auto;
  text-align: center;
}

.advisory-inner h2 {
  font-family: 'Playfair Display', serif;
  font-size: 3.5rem;
  margin-bottom: 30px;
}

.advisory-inner h2 em { font-style: italic; color: var(--gold); font-weight: 400; }

.advisory-inner p {
  color: rgba(255,255,255,0.6);
  font-size: 1.2rem;
  max-width: 700px;
  margin: 0 auto 80px;
  font-weight: 300;
}

.etiquette-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 40px;
}

.e-card {
  padding: 40px;
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.1);
  text-align: left;
}

.e-card h4 {
  font-family: 'Playfair Display', serif;
  font-size: 1.3rem;
  margin-bottom: 20px;
  color: var(--gold);
}

.e-card p {
  font-size: 0.95rem;
  color: rgba(255,255,255,0.5);
  line-height: 1.7;
  margin: 0;
}

@media (max-width: 1024px) {
  .spread-inner { grid-template-columns: 1fr; gap: 60px; }
  .chapter-spread { grid-template-columns: 1fr; gap: 60px; }
  .chapter-visual { order: -1; }
  .optics-features { gap: 40px; flex-direction: column; }
  .etiquette-grid { grid-template-columns: 1fr; }
  .narrative-chapter { padding-left: 0; }
  .spread-img { height: 400px; }
  .chapter-img { height: 400px; }
}
</style>
