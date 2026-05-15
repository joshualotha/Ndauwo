<template>
  <div class="luxury-page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    <!-- Premium Global Hero -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label" v-reveal>✦ The Gilded Horizon</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Uncompromised ', class: 'white' },
            { text: 'Luxury', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="hero-subtitle">
          Where the untamed wild meets the pinnacle of human refinement.
        </p>
      </div>
    </section>

    <!-- The Obsidian Philosophy (Dark Contrast Section) -->
    <section class="philosophie-dark" ref="philosophy">
      <div class="container">
        <div class="phil-grid">
          <div class="phil-copy" v-reveal>
            <span class="eyebrow">The Standard</span>
            <h2 class="serif-display">Beyond the <em>Expected</em></h2>
            <p class="lead-text">A luxury safari with Ndauwo transcends the physical comforts of a five-star lodge. It is a seamless choreography of time, access, and absolute privacy.</p>
            <p class="body-text">We connect remote sanctuaries via private light aircraft, bypassing the dust of the road for the clarity of the sky. In the bush, your schedule is an open dialogue—flexible, intuitive, and entirely your own.</p>
          </div>
          <div class="phil-visual" v-reveal>
            <div class="offset-frame">
              <img :src="getImage('photo_break_1', '/image-17.jpg')" alt="Private Sanctuary">
              <div class="frame-label">Private Plunge Pool · Serengeti</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Amenity Carousel (Horizontal Scroll) -->
    <section class="amenity-showcase">
      <div class="showcase-header container" v-reveal>
        <h2 class="serif-title">Signature <em>Indulgences</em></h2>
      </div>
      
      <div class="horizontal-scroller">
        <div class="scroller-track">
          <div v-for="a in amenities" :key="a.name" class="amenity-card">
            <span class="a-icon">{{ a.icon }}</span>
            <h4 class="a-title">{{ a.name }}</h4>
            <div class="a-line"></div>
          </div>
          <!-- Repeat for smooth scroll if needed, but here we just list -->
        </div>
      </div>
    </section>

    <!-- The Signature Stay (Editorial Layout) -->
    <section class="signature-stay" ref="signature">
      <div class="container">
        <div class="editorial-row" v-for="(f, i) in features" :key="i" :class="{ 'row-reverse': i % 2 !== 0 }">
          <div class="ed-image-wrap" v-reveal>
            <div class="img-reveal-wrapper">
              <img :src="f.image" :alt="f.name">
            </div>
          </div>
          <div class="ed-content-wrap" v-reveal>
            <span class="ed-number">V / 0{{ i + 1 }}</span>
            <h3 class="ed-title">{{ f.name }}</h3>
            <p class="ed-desc">{{ f.desc }}</p>
            <div class="ed-line"></div>
          </div>
        </div>
      </div>
    </section>

    <!-- The Infinite Silence (Full Width Parallax) -->
    <section class="parallax-quote" :style="{ backgroundImage: `url(${getImage('photo_break_2', '/image-11.jpg')})` }">
      <div class="quote-overlay"></div>
      <div class="quote-content" v-reveal>
        <blockquote>
          "True luxury is the ability to listen to the silence of the savannah, uninterrupted."
        </blockquote>
        <cite>— The Ndauwo Philosophy</cite>
      </div>
    </section>

    <!-- Elegant CTA -->
    <section class="luxury-cta">
      <div class="container">
        <div class="cta-inner" v-reveal>
          <div class="cta-lines"></div>
          <span class="eyebrow">Begin Your Voyage</span>
          <h2 class="serif-display">Designed Around <em>You</em></h2>
          <router-link to="/contact" class="btn-luxury">
            Request a Private Consultation
            <span class="shimmer"></span>
          </router-link>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { ref, onMounted } from 'vue'
import { usePageImages } from '../../composables/usePageImages'

const { images, fetchImages, getImage } = usePageImages('luxury_safari');

const amenities = [
  { icon: '✈', name: 'Fly-In Transfers' },
  { icon: '⬡', name: 'Private Lodges' },
  { icon: '◈', name: 'Gourmet Dining' },
  { icon: '○', name: 'Private Game Drives' },
  { icon: '△', name: 'Bush Spa & Wellness' },
  { icon: '◇', name: 'Butler Service' },
]

const features = [
  { name: 'Fly-In Convenience', desc: 'Light aircraft transfers between parks. Arrive rested and ready to explore, not dusty and exhausted from a 6-hour road transfer.', image: '/image-10.jpg' },
  { name: 'World-Class Lodges', desc: 'We work with a curated selection of lodges, places where the architecture is thoughtful, the wilderness is right outside your tent, and the service is effortless.', image: '/image-20.jpg' },
  { name: 'Private Everything', desc: 'Your vehicle, your guide, your schedule. No shared departures. If you want to sit with one leopard for six hours, the vehicle doesn\'t move.', image: '/image-19.jpg' },
]

onMounted(() => {
  fetchImages();
});
</script>

<style scoped>
.luxury-page {
  background: #FFF;
  color: #1a1f18;
  overflow-x: hidden;
}

/* PHILOSOPHY DARK */
.philosophie-dark {
  padding: 180px 0;
  background: #0d0f0c;
  color: #fff;
  position: relative;
}

.phil-grid {
  display: grid;
  grid-template-columns: 0.9fr 1.1fr;
  gap: 120px;
  align-items: center;
}

.eyebrow {
  display: block;
  font-size: 0.75rem;
  letter-spacing: 0.5em;
  text-transform: uppercase;
  color: #c5a059;
  margin-bottom: 32px;
  font-weight: 700;
}

.serif-display {
  font-family: 'Playfair Display', serif;
  font-size: clamp(3rem, 6vw, 5.5rem);
  line-height: 1.05;
  margin-bottom: 48px;
}

.serif-display em {
  font-style: italic;
  font-weight: 400;
  color: #c5a059;
}

.lead-text {
  font-size: 1.3rem;
  line-height: 1.8;
  font-weight: 300;
  color: rgba(255,255,255,0.8);
  margin-bottom: 40px;
}

.body-text {
  font-size: 1.05rem;
  line-height: 1.9;
  color: rgba(255,255,255,0.6);
  font-weight: 300;
}

.phil-visual {
  position: relative;
}

.offset-frame {
  position: relative;
  width: 100%;
  padding-bottom: 125%; /* Portrait Aspect */
  overflow: hidden;
  box-shadow: 0 50px 100px rgba(0,0,0,0.3);
}

.offset-frame img {
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 100%;
  object-fit: cover;
  transition: transform 2s ease;
}

.frame-label {
  position: absolute;
  bottom: 40px;
  right: -20px;
  background: #c5a059;
  color: #0d0f0c;
  padding: 12px 32px;
  font-size: 0.7rem;
  font-weight: 700;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  transform: rotate(-90deg);
  transform-origin: right bottom;
}

/* AMENITY SHOWCASE */
.amenity-showcase {
  padding: 140px 0;
  background: #fdfbf7;
}

.serif-title {
  font-family: 'Playfair Display', serif;
  font-size: 3.5rem;
  margin-bottom: 80px;
  text-align: center;
}

.serif-title em { font-style: italic; color: #c5a059; }

.horizontal-scroller {
  overflow-x: auto;
  padding: 20px 5%;
  -webkit-overflow-scrolling: touch;
}

.horizontal-scroller::-webkit-scrollbar { display: none; }

.scroller-track {
  display: flex;
  gap: 60px;
  width: max-content;
}

.amenity-card {
  width: 300px;
  padding: 60px 40px;
  background: #FFF;
  border: 1px solid #eee;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  transition: transform 0.4s ease, border-color 0.4s ease;
}

.amenity-card:hover {
  transform: translateY(-10px);
  border-color: #c5a059;
}

.a-icon {
  font-size: 2.5rem;
  color: #c5a059;
  margin-bottom: 30px;
}

.a-title {
  font-size: 0.8rem;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-weight: 700;
  color: #1a1f18;
}

.a-line {
  width: 40px;
  height: 2px;
  background: #eee;
  margin-top: 30px;
  transition: width 0.4s ease, background 0.4s ease;
}

.amenity-card:hover .a-line {
  width: 80px;
  background: #c5a059;
}

/* SIGNATURE STAY */
.signature-stay {
  padding: 160px 0;
}

.editorial-row {
  display: grid;
  grid-template-columns: 1.2fr 0.8fr;
  gap: 120px;
  align-items: center;
  margin-bottom: 180px;
}

.editorial-row.row-reverse {
  grid-template-columns: 0.8fr 1.2fr;
}

.editorial-row.row-reverse .ed-image-wrap { order: 2; }
.editorial-row.row-reverse .ed-content-wrap { order: 1; }

.img-reveal-wrapper {
  position: relative;
  overflow: hidden;
  height: 80vh;
  box-shadow: 0 40px 80px rgba(0,0,0,0.08);
}

.img-reveal-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 1.5s ease;
}

.editorial-row:hover img {
  transform: scale(1.05);
}

.ed-number {
  font-family: 'Playfair Display', serif;
  font-size: 1.2rem;
  color: #c5a059;
  font-style: italic;
  display: block;
  margin-bottom: 32px;
}

.ed-title {
  font-family: 'Playfair Display', serif;
  font-size: 3rem;
  margin-bottom: 32px;
  line-height: 1.1;
}

.ed-desc {
  font-size: 1.15rem;
  line-height: 1.9;
  color: #555;
  font-weight: 300;
  margin-bottom: 48px;
}

.ed-line {
  width: 100px;
  height: 1px;
  background: #c5a059;
}

/* PARALLAX QUOTE */
.parallax-quote {
  height: 90vh;
  background-attachment: fixed;
  background-size: cover;
  background-position: center;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: #fff;
}

.quote-overlay {
  position: absolute;
  inset: 0;
  background: rgba(13,15,12,0.6);
}

.quote-content {
  position: relative;
  z-index: 2;
  max-width: 900px;
  padding: 0 5%;
}

blockquote {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.2rem, 4vw, 3.8rem);
  font-style: italic;
  line-height: 1.3;
  margin-bottom: 40px;
}

cite {
  font-size: 0.8rem;
  letter-spacing: 0.4em;
  text-transform: uppercase;
  color: #c5a059;
  font-weight: 700;
}

/* LUXURY CTA */
.luxury-cta {
  padding: 160px 0;
  text-align: center;
  background: #fdfbf7;
}

.cta-inner {
  position: relative;
  max-width: 800px;
  margin: 0 auto;
}

.btn-luxury {
  display: inline-block;
  padding: 24px 64px;
  background: #1a1f18;
  color: #c5a059;
  text-decoration: none;
  font-weight: 700;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  font-size: 0.85rem;
  transition: all 0.4s ease;
  border: 1px solid #1a1f18;
}

.btn-luxury:hover {
  background: transparent;
  color: #1a1f18;
  transform: translateY(-5px);
}

/* CONTAINER */
.container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 5%;
}

@media (max-width: 1024px) {
  .phil-grid { grid-template-columns: 1fr; gap: 60px; }
  .editorial-row { grid-template-columns: 1fr; gap: 60px; }
  .editorial-row.row-reverse { grid-template-columns: 1fr; }
  .img-reveal-wrapper { height: 60vh; }
}

@media (max-width: 768px) {
  .serif-display { font-size: 2.8rem; }
  .ed-title { font-size: 2.5rem; }
  .btn-luxury { padding: 20px 40px; width: 100%; box-sizing: border-box; }
}
</style>
