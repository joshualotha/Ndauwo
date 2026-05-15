<template>
  <div class="gallery-page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    <!-- Premium Hero Section -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label" v-reveal>✦ Visual Journeys</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'The ', class: 'white' },
            { text: 'Gallery', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
      </div>
    </section>
    <section class="gallery-intro" v-reveal>
      <div class="intro-container">
        <span class="intro-label">✦ Captured Expeditions</span>
        <h2 class="intro-heading">Moments Found in the <em>Untamed</em></h2>
        <p class="intro-text">
          Our gallery is more than a collection of images; it is a visual diary of the soul-stirring encounters that define the Ndauwo experience. From the sweeping horizons of the Great Migration to the quiet, intimate details of the Tanzanian bush, we invite you to witness the raw elegance of the wild as seen through our lens.
        </p>
        <div class="intro-divider"></div>
      </div>
    </section>

    <!-- Gallery Grid -->
    <section class="gallery-section">
      <div v-if="loading" class="gallery-loader">
        <div class="spinner"></div>
      </div>
      
      <div v-else-if="items.length === 0" class="no-results" v-reveal>
        <p>No moments found. Exploration continues...</p>
      </div>

      <div v-else class="masonry-grid">
        <div 
          v-for="(item, index) in items" 
          :key="item.id" 
          class="masonry-item"
          v-reveal
          :style="{ transitionDelay: (index % 4) * 0.1 + 's' }"
          @click="openLightbox(item)"
        >
          <div class="card-media">
            <img :src="getImageUrl(item.file_path)" :alt="item.title" loading="lazy" />
            <div class="card-overlay">
              <div class="card-info">
                <h3 class="card-title">{{ item.title }}</h3>
              </div>
              <div class="card-icon">
                <MaximizeIcon class="icon" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Gallery CTA -->
    <section class="gallery-cta" v-reveal>
      <div class="cta-overlay" :style="{ backgroundImage: `url('https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&q=80')` }"></div>
      <div class="cta-content">
        <h2 class="cta-heading">Your Own <em>Expedition</em> Awaits</h2>
        <p class="cta-text">These capture only a glimpse of the majesty that awaits you in Tanzania. Let us craft a journey that transcends the frame.</p>
        <div class="cta-actions">
          <router-link to="/safaris" class="btn-primary"><span>Explore Safari Packages</span></router-link>
          <router-link to="/contact" class="btn-ghost">Start Planning</router-link>
        </div>
      </div>
    </section>

    <!-- Simple Lightbox -->
    <Teleport to="body">
      <div v-if="activeItem" class="lightbox" @click="closeLightbox">
        <button class="lightbox-close" @click="closeLightbox">
          <XIcon />
        </button>
        
        <div class="lightbox-content" @click.stop>
          <img :src="getImageUrl(activeItem.file_path)" :alt="activeItem.title" />
          
          <div class="lightbox-caption">
            <h3>{{ activeItem.title }}</h3>
            <p v-if="activeItem.description">{{ activeItem.description }}</p>
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import {
  Play as PlayIcon,
  Maximize2 as MaximizeIcon,
  X as XIcon
} from 'lucide-vue-next'
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { usePageImages } from '../composables/usePageImages'
import { useSettings, API_BASE_URL } from '../composables/useSettings'

const { images, fetchImages, getImage } = usePageImages('gallery');
const { getImageUrl } = useSettings();

console.log('API_BASE_URL:', API_BASE_URL);

const items = ref([])
const loading = ref(true)
const activeItem = ref(null)

const fetchGallery = async () => {
  try {
    const url = `${API_BASE_URL}/api/gallery`;
    console.log('Fetching from URL:', url);
    const response = await axios.get(url);
    console.log('Response status:', response.status);
    console.log('Response data:', response.data);
    console.log('Is array?', Array.isArray(response.data));
    const filtered = Array.isArray(response.data) ? response.data.filter(item => item.type === 'image') : [];
    console.log('Filtered items:', filtered.length);
    items.value = filtered;
  } catch (error) {
    console.error('Failed to fetch gallery:', error);
    if (error.response) {
      console.error('Error response:', error.response.data);
    }
  } finally {
    loading.value = false
  }
}





const openLightbox = (item) => {
  activeItem.value = item
  document.body.style.overflow = 'hidden'
}

const closeLightbox = () => {
  activeItem.value = null
  document.body.style.overflow = ''
}

onMounted(() => {
  fetchImages();
  fetchGallery();
})
</script>

<style scoped>
.gallery-page {
  background: var(--ivory);
  min-height: 100vh;
}


/* Intro Section */
.gallery-intro {
  padding: 120px 5% 0;
  background: var(--ivory);
  text-align: center;
}

.intro-container {
  max-width: 800px;
  margin: 0 auto;
}

.intro-label {
  font-size: 0.75rem;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 20px;
  display: block;
}

.intro-heading {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 5vw, 3.5rem);
  color: var(--forest);
  margin-bottom: 30px;
  line-height: 1.2;
}

.intro-heading em {
  font-style: italic;
  color: var(--rust);
}

.intro-text {
  font-size: 1.15rem;
  line-height: 1.8;
  color: var(--ebony);
  opacity: 0.8;
  font-family: 'Inter', sans-serif;
}

.intro-divider {
  width: 60px;
  height: 2px;
  background: var(--gold);
  margin: 50px auto 0;
  opacity: 0.3;
}

/* Masonry Grid */
.gallery-section {
  padding: 80px 5% 120px;
}

.masonry-grid {
  column-count: 3;
  column-gap: 30px;
  max-width: 1600px;
  margin: 0 auto;
}

.masonry-item {
  break-inside: avoid;
  margin-bottom: 30px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  border-radius: 4px;
}

.card-media {
  width: 100%;
  position: relative;
  display: block;
}

.card-media img {
  width: 100%;
  display: block;
  object-fit: cover;
  transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.masonry-item:hover img {
  transform: scale(1.08);
}

.card-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 60%);
  opacity: 0;
  transition: opacity 0.4s ease;
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  padding: 30px;
}

.masonry-item:hover .card-overlay {
  opacity: 1;
}

.card-title {
  color: white;
  font-family: 'Playfair Display', serif;
  font-size: 1.4rem;
  font-weight: 400;
}

.card-icon {
  width: 44px;
  height: 44px;
  background: rgba(255,255,255,0.2);
  backdrop-filter: blur(10px);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
}

.icon {
  width: 20px;
  height: 20px;
}

/* Lightbox */
.lightbox {
  position: fixed;
  inset: 0;
  background: rgba(18, 20, 16, 0.98);
  z-index: 10000;
  display: flex;
  align-items: center;
  justify-content: center;
}

.lightbox-close {
  position: absolute;
  top: 30px;
  right: 30px;
  background: none;
  border: none;
  color: white;
  cursor: pointer;
  padding: 10px;
}

.lightbox-content {
  max-width: 90vw;
  max-height: 80vh;
  position: relative;
}

.lightbox-content img {
  max-width: 100%;
  max-height: 80vh;
  object-fit: contain;
}


.lightbox-caption {
  color: white;
  text-align: center;
  margin-top: 30px;
}

.lightbox-caption h3 {
  font-family: 'Playfair Display', serif;
  font-size: 1.8rem;
  margin-bottom: 10px;
}

.lightbox-caption p {
  font-size: 1rem;
  color: rgba(255,255,255,0.7);
  max-width: 600px;
  margin: 0 auto;
}

/* CTA Section */
.gallery-cta {
  position: relative;
  padding: 160px 5%;
  overflow: hidden;
  text-align: center;
  background: var(--forest);
  color: white;
}

.cta-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-size: cover;
  background-position: center;
  opacity: 0.3;
  transform: scale(1.1);
  transition: transform 10s linear;
}

.gallery-cta:hover .cta-overlay {
  transform: scale(1);
}

.cta-content {
  position: relative;
  z-index: 1;
  max-width: 800px;
  margin: 0 auto;
}

.cta-heading {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 5vw, 4rem);
  margin-bottom: 24px;
}

.cta-heading em {
  font-style: italic;
  color: var(--gold);
}

.cta-text {
  font-size: 1.25rem;
  opacity: 0.9;
  margin-bottom: 48px;
  line-height: 1.6;
}

.cta-actions {
  display: flex;
  gap: 20px;
  justify-content: center;
}

.btn-primary {
  background: var(--gold);
  color: var(--forest);
  padding: 18px 40px;
  border-radius: 4px;
  text-decoration: none;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  font-size: 0.9rem;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
}

.btn-primary:hover {
  background: white;
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.btn-ghost {
  border: 1px solid rgba(255,255,255,0.3);
  color: white;
  padding: 18px 40px;
  border-radius: 4px;
  text-decoration: none;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  font-size: 0.9rem;
  transition: all 0.3s ease;
}

.btn-ghost:hover {
  background: rgba(255,255,255,0.1);
  border-color: white;
}

@media (max-width: 768px) {
  .cta-actions {
    flex-direction: column;
  }
}

.gallery-loader, .no-results {
  height: 300px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #999;
  font-family: 'Playfair Display', serif;
  font-style: italic;
  font-size: 1.2rem;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 2px solid rgba(139, 115, 85, 0.2);
  border-top-color: var(--gold);
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

@media (max-width: 1024px) {
  .masonry-grid {
    column-count: 2;
  }
}

@media (max-width: 768px) {
  .masonry-grid {
    column-count: 1;
  }
}
</style>
