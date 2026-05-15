<template>
  <div class="bespoke-page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    <!-- Premium Global Hero -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label" v-reveal>✦ The Art of the Infinite</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Bespoke ', class: 'white' },
            { text: 'Artistry', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="hero-subtitle">
          For those who seek a journey as unique as their own signature.
        </p>
      </div>
    </section>

    <!-- The Architect Section -->
    <section class="architect-intro" ref="intro">
      <div class="container">
        <div class="intro-grid">
          <div class="intro-visual" v-reveal>
            <div class="main-frame">
              <img :src="getImage('photo_break_1', '/image-17.jpg')" alt="Safari Architecture">
            </div>
            <div class="float-frame parallax-slow">
              <img :src="getImage('photo_break_2', '/image-19.jpg')" alt="Wildlife Detail">
            </div>
          </div>
          <div class="intro-copy" v-reveal>
            <span class="eyebrow">The Philosophy</span>
            <h2 class="editorial-title">Your Private <em>Architects</em></h2>
            <p class="lead-text">At Ndauwo, we don't sell itineraries; we curate experiences. A tailor-made safari is a conversation—a blank page where your curiosities, pace, and passions define the geography of your journey.</p>
            <div class="manifesto-points">
              <div class="m-point">
                <span class="num">01</span>
                <div>
                  <h4>Blank Canvas</h4>
                  <p>Every journey starts from zero. No templates, no pre-set routes.</p>
                </div>
              </div>
              <div class="m-point">
                <span class="num">02</span>
                <div>
                  <h4>The 1% Rule</h4>
                  <p>We obsess over the details that others ignore—the specific camp angle, the exact guide match.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- The Mood Board (Overlapping Parallax) -->
    <section class="mood-board" ref="moodBoard">
      <div class="board-header" v-reveal>
        <h2 class="board-title">A Symphony of <em>Choices</em></h2>
        <p>From the silence of a star-bed to the thunder of the crossing.</p>
      </div>

      <div class="board-grid">
        <div class="board-item v-reveal tall parallax-fast">
          <img src="/image-11.jpg" alt="Culture">
          <div class="item-overlay">
            <span>Living Heritage</span>
          </div>
        </div>
        <div class="board-item v-reveal parallax-slow">
          <img src="/image-15.jpg" alt="Luxury">
          <div class="item-overlay">
            <span>Hidden Sanctuaries</span>
          </div>
        </div>
        <div class="board-item v-reveal">
          <img src="/image-08.jpg" alt="Adventure">
          <div class="item-overlay">
            <span>The Untamed</span>
          </div>
        </div>
        <div class="board-item v-reveal tall parallax-medium">
          <img src="/image-13.jpg" alt="Elegance">
          <div class="item-overlay">
            <span>Refined Comfort</span>
          </div>
        </div>
      </div>
    </section>

    <!-- The Process (Editorial Horizontal) -->
    <section class="editorial-process" ref="process">
      <div class="process-bg-text">CRAFTED</div>
      <div class="container">
        <div class="process-grid">
          <div v-for="(step, i) in steps" :key="i" class="step-card" v-reveal>
            <span class="step-count">IV / {{ i + 1 }}</span>
            <h3 class="step-title">{{ step.title }}</h3>
            <p class="step-desc">{{ step.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Call to Creation -->
    <section class="creation-cta" ref="cta">
      <div class="cta-bg-image" :style="{ backgroundImage: `url(${getImage('cta_bg', '/image-16.jpg')})` }"></div>
      <div class="cta-overlay"></div>
      <div class="container">
        <div class="cta-content" v-reveal>
          <span class="cta-label">The Journey Begins Here</span>
          <h2 class="cta-title">Start Your <em>Conversation</em></h2>
          <p>Collaborate with an expert designer to build your perfect Tanzanian expedition.</p>
          <router-link to="/contact" class="btn-bespoke">
            Initiate Consultation
            <span class="btn-shimmer"></span>
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

const { images, fetchImages, getImage } = usePageImages('tailor_made_safari');

const steps = [
  { title: 'The Inquiry', desc: 'A deep dive into your travel DNA. We listen to what you love, and more importantly, what you don\'t.' },
  { title: 'The Draft', desc: 'A conceptual blueprint of your journey, blending logistics with moments of pure serendipity.' },
  { title: 'The Refinement', desc: 'Fine-tuning the brushstrokes until the itinerary feels like a natural extension of yourself.' },
  { title: 'The Execution', desc: '24/7 concierge support and our most elite guides ensuring every detail is flawlessly realized.' },
]

onMounted(() => {
  fetchImages();
});
</script>

<style scoped>
.bespoke-page {
  background: #0d0f0c; /* Deep obsidian background for true luxury */
  color: #fff;
  overflow-x: hidden;
}

/* ARCHITECT INTRO */
.architect-intro {
  padding: 160px 0;
  background: #FFF; /* Use white for the "Blank Canvas" middle section */
  color: #1a1f18;
  position: relative;
}

.intro-grid {
  display: grid;
  grid-template-columns: 1.1fr 0.9fr;
  gap: 100px;
  align-items: center;
}

.intro-visual {
  position: relative;
}

.main-frame {
  width: 85%;
  height: 70vh;
  overflow: hidden;
  box-shadow: 0 50px 100px rgba(0,0,0,0.1);
}

.main-frame img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.float-frame {
  position: absolute;
  top: 30%;
  right: -5%;
  width: 50%;
  height: 40vh;
  overflow: hidden;
  border: 15px solid #FFF;
  box-shadow: 0 40px 80px rgba(0,0,0,0.15);
}

.float-frame img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.eyebrow {
  display: block;
  font-size: 0.75rem;
  letter-spacing: 0.4em;
  text-transform: uppercase;
  color: #c5a059;
  margin-bottom: 24px;
  font-weight: 600;
}

.editorial-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(3rem, 5vw, 4.5rem);
  line-height: 1.1;
  margin-bottom: 40px;
  color: #1a1f18;
}

.editorial-title em {
  font-style: italic;
  color: #c5a059;
}

.lead-text {
  font-size: 1.2rem;
  line-height: 1.8;
  color: #555;
  font-weight: 300;
  margin-bottom: 60px;
}

.manifesto-points {
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.m-point {
  display: flex;
  gap: 25px;
}

.m-point .num {
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
  color: #c5a059;
  font-style: italic;
}

.m-point h4 {
  font-size: 1.1rem;
  margin-bottom: 8px;
  font-weight: 700;
}

.m-point p {
  font-size: 0.95rem;
  color: #777;
  line-height: 1.6;
}

/* MOOD BOARD */
.mood-board {
  padding: 140px 5%;
  background: #0d0f0c;
}

.board-header {
  text-align: center;
  margin-bottom: 100px;
}

.board-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 4vw, 3.5rem);
  margin-bottom: 20px;
}

.board-title em {
  font-style: italic;
  color: #c5a059;
}

.board-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 30px;
  max-width: 1400px;
  margin: 0 auto;
}

.board-item {
  position: relative;
  overflow: hidden;
  height: 45vh;
  margin-top: 50px;
}

.board-item.tall {
  height: 65vh;
  margin-top: 0;
}

.board-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 1.5s ease;
}

.item-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.3);
  display: flex;
  align-items: flex-end;
  padding: 30px;
  opacity: 0;
  transition: opacity 0.5s ease;
}

.item-overlay span {
  font-size: 0.7rem;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-weight: 600;
}

.board-item:hover .item-overlay {
  opacity: 1;
}

.board-item:hover img {
  transform: scale(1.1);
}

/* EDITORIAL PROCESS */
.editorial-process {
  padding: 160px 0;
  background: #FFF;
  color: #1a1f18;
  position: relative;
}

.process-bg-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 15vw;
  font-weight: 900;
  color: #f8f8f8;
  z-index: 0;
  letter-spacing: 0.1em;
}

.process-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 60px;
  position: relative;
  z-index: 1;
}

.step-card {
  padding-top: 40px;
  border-top: 1px solid #e2e8f0;
}

.step-count {
  display: block;
  font-size: 0.7rem;
  color: #c5a059;
  font-weight: 700;
  margin-bottom: 24px;
}

.step-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.8rem;
  margin-bottom: 20px;
}

.step-desc {
  font-size: 0.95rem;
  line-height: 1.8;
  color: #666;
}

/* CREATION CTA */
.creation-cta {
  height: 100vh;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  overflow: hidden;
}

.cta-bg-image {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
  transform: scale(1.1);
}

.cta-overlay {
  position: absolute;
  inset: 0;
  background: radial-gradient(circle, rgba(13,15,12,0.6) 0%, rgba(13,15,12,0.95) 100%);
}

.cta-content {
  position: relative;
  z-index: 2;
  max-width: 800px;
  margin: 0 auto;
}

.cta-label {
  font-size: 0.8rem;
  letter-spacing: 0.5em;
  text-transform: uppercase;
  color: #c5a059;
  margin-bottom: 30px;
  display: block;
}

.cta-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(3.5rem, 8vw, 7rem);
  margin-bottom: 40px;
  line-height: 1;
}

.cta-title em {
  font-style: italic;
  font-weight: 300;
}

.btn-bespoke {
  display: inline-block;
  padding: 24px 64px;
  background: #c5a059;
  color: #0d0f0c;
  text-decoration: none;
  font-weight: 700;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  font-size: 0.85rem;
  position: relative;
  transition: transform 0.3s ease;
  overflow: hidden;
}

.btn-bespoke:hover {
  transform: translateY(-5px);
}

/* GRID CONTAINER */
.container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 5%;
}

@media (max-width: 1024px) {
  .intro-grid { grid-template-columns: 1fr; gap: 60px; }
  .board-grid { grid-template-columns: 1fr 1fr; }
  .process-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 768px) {
  .board-grid { grid-template-columns: 1fr; }
  .process-grid { grid-template-columns: 1fr; }
  .main-frame { width: 100%; }
}
</style>
