<template>
  <div class="careers-page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    <!-- Premium Hero Section -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label" v-reveal>✦ Join The Team</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Ndauwo ', class: 'white' },
            { text: 'Careers', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
      </div>
    </section>

    <section class="content-section">
      <div class="content-inner" v-reveal>
        <span class="section-label" style="color:var(--gold)">Working at Ndauwo</span>
        <h2 class="content-heading">A Calling,<br><em>Not a Career</em></h2>
        <p class="intro-text">
          We are always looking for passionate individuals who share our deep respect for the African wilderness and our unyielding commitment to ultra-premium hospitality. Whether in the bush or at headquarters, joining Ndauwo means joining a diverse family dedicated to excellence.
        </p>
      </div>

      <div class="careers-grid" style="text-align:center; padding: 60px 0;">
        <h3 style="font-family:'Playfair Display', serif; font-size:2rem; color:var(--forest);">Current Openings</h3>
        <p style="color:var(--text-mid); margin-top:20px;">We currently have no open positions. However, exceptional talent is always welcome to submit a CV.</p>
        <button class="btn-primary" style="margin-top: 30px;">Submit Spontaneous Application</button>
      </div>
    </section>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { usePageImages } from '../composables/usePageImages'

const { images, fetchImages, getImage } = usePageImages('careers');

onMounted(() => {
  fetchImages();
});
</script>

<style scoped>
/* HERO - Now using Global .premium-hero */

.content-section { padding: 120px 5%; background: var(--ivory); min-height: 60vh;}
.content-inner { max-width: 800px; margin: 0 auto; text-align: center; }
.content-heading { font-family: 'Playfair Display', serif; font-size: 3rem; color: var(--forest); font-weight: 400; margin-bottom: 40px; line-height: 1.2; }
.content-heading em { color: var(--gold); font-style: italic; }
.intro-text { font-size: 1.15rem; line-height: 1.9; color: var(--text-dark); margin-bottom: 25px; font-weight: 300; }
</style>
