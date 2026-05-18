<template>
  <div class="journal-page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    
    <!-- 1. CINEMATIC JOURNAL HERO -->
    <section class="journal-hero">
      <div class="hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(14, 20, 14, 0.7) 0%, rgba(14, 20, 14, 0.4) 50%, rgba(20, 24, 20, 1) 100%), url(${getImage('hero_bg', '/image-03.jpg')})` }"></div>
      <div class="hero-overlay-texture"></div>
      
      <div class="hero-content">
        <div class="hero-meta" v-reveal>
          <span class="meta-dot"></span>
          <span class="meta-label">The Ndauwo Chronicle</span>
        </div>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Into the ', class: 'white' },
            { text: 'Wilderness', class: 'orange' }
          ]]" :startDelay="600" />
        </h1>
        <p class="hero-subtitle" v-reveal>
          A collection of field notes, seasonal observations, and stories from the heart of East Africa's most remote territories.
        </p>
        
        <div class="scroll-indicator" v-reveal>
          <span class="scroll-line"></span>
          <span class="scroll-text">Explore Dispatches</span>
        </div>
      </div>
    </section>

    <!-- 2. FEATURED DISPATCH SPOTLIGHT -->
    <section class="featured-section">
      <div class="featured-container">
        <div class="featured-heading" v-reveal>
          <span class="label">Featured Dispatch</span>
          <h2 class="featured-title-main">From the <em>Frontiers</em></h2>
        </div>
        
        <router-link :to="featuredPost.slug" class="featured-dispatch-card" v-reveal>
          <div class="featured-img-frame">
            <img :src="featuredPost.image" :alt="featuredPost.title">
            <div class="img-overlay-light"></div>
            <div class="post-cat-badge">{{ featuredPost.category }}</div>
          </div>
          
          <div class="featured-text-content">
            <div class="post-meta">
              <span class="post-date">{{ featuredPost.date }}</span>
              <span class="post-dot"></span>
              <span class="post-author">By {{ featuredPost.author }}</span>
            </div>
            <h2 class="post-display-title">{{ featuredPost.title }} <em>{{ featuredPost.italicTitle }}</em></h2>
            <p class="post-excerpt">{{ featuredPost.excerpt }}</p>
            
            <div class="dispatch-footer">
              <div class="read-dispatch-btn">
                <span>View Full Dispatch</span>
                <span class="btn-arrow">→</span>
              </div>
            </div>
          </div>
        </router-link>
      </div>
    </section>

    <!-- 3. EDITORIAL ARCHIVE GRID -->
    <section class="archive-section">
      <div class="archive-header" v-reveal>
        <div class="header-left">
          <span class="label">Archive</span>
          <h2 class="archive-heading">Field <em>Observations</em></h2>
        </div>
        <div class="archive-filters">
          <button v-for="cat in categories" :key="cat" 
                  :class="['filter-pill', { active: activeCategory === cat }]"
                  @click="activeCategory = cat">
            {{ cat }}
          </button>
        </div>
      </div>

      <div class="editorial-grid">
        <router-link 
          v-for="(post, idx) in filteredPosts" 
          :key="post.id"
          :to="post.slug"
          class="archive-card"
          :class="['card-size-' + (idx % 3)]"
          v-reveal
        >
          <div class="archive-img-wrap">
            <img :src="post.image" :alt="post.title">
            <div class="card-overlay"></div>
          </div>
          <div class="archive-card-body">
            <div class="card-meta">
              <span class="card-cat">{{ post.category }}</span>
              <span class="card-date">{{ post.date }}</span>
            </div>
            <h3 class="card-title">{{ post.title }} <em>{{ post.italicTitle }}</em></h3>
            <p class="card-excerpt">{{ post.excerpt }}</p>
            <div class="card-footer">
              <span class="read-link">Discover →</span>
              <span class="read-time">{{ post.readTime }}</span>
            </div>
          </div>
        </router-link>
      </div>

      <div class="pagination-footer" v-reveal>
        <div class="pag-line"></div>
        <button class="load-more-btn">
          <span class="btn-inner">Load More Archive</span>
        </button>
      </div>
    </section>

    <!-- 4. NEWSLETTER DISPATCH -->
    <section class="newsletter-dispatch" v-reveal>
      <div class="newsletter-wrap">
        <div class="newsletter-content">
          <span class="label">Stay Informed</span>
          <h2 class="news-h">Join the <em>Inner Circle</em></h2>
          <p class="news-p">Quarterly dispatches on conservation, exclusive safari opportunities, and notes from the Serengeti workshop.</p>
          <form class="news-form" @submit.prevent>
            <input type="email" placeholder="Your coordinates (Email)...">
            <button type="submit">Subscribe</button>
          </form>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import HandwrittenTypewriter from '../components/HandwrittenTypewriter.vue'
import { usePageImages } from '../composables/usePageImages'
import { API_BASE_URL } from '../composables/useSettings'

const { images, fetchImages, getImage } = usePageImages('blog');

const activeCategory = ref('All')
const categories = ['All', 'Wildlife', 'Expeditions', 'Culture', 'Conservation']

// Mock data (replace with API call later)
const featuredPost = {
  id: 1,
  slug: '/journal/the-silence-before-the-crossing',
  title: 'The Silence Before ',
  italicTitle: 'the Crossing',
  category: 'Expeditions',
  date: 'October 14, 2025',
  excerpt: 'Waiting for the herds at the Mara River is an exercise in profound tension. The air thickens with dust, the crocodiles slip silently into the current, and time seems to compress. Our lead guide recounts the hours leading up to the largest crossing of the season.',
  author: 'Daniel Maro',
  authorImage: '/image-20.jpg',
  image: '/image-03.jpg'
}

const posts = ref([
  {
    id: 2,
    slug: '/journal/anatomy-of-the-sprint',
    title: 'Anatomy of ',
    italicTitle: 'the Sprint',
    category: 'Wildlife',
    date: 'Sept 28, 2025',
    readTime: '5 Min Read',
    image: '/image-06.jpg',
    excerpt: 'Deconstructing the biomechanics and hunting strategies of the Serengeti\'s fastest apex predator during the dry season.'
  },
  {
    id: 3,
    slug: '/journal/echoes-of-the-rift-valley',
    title: 'Echoes of ',
    italicTitle: 'the Rift Valley',
    category: 'Culture',
    date: 'Sept 12, 2025',
    readTime: '8 Min Read',
    image: '/image-19.jpg',
    excerpt: 'An intimate conversation with the elders of the Ngorongoro highlands regarding ancient pastoral traditions.'
  },
  {
    id: 4,
    slug: '/journal/guardians-of-the-selous',
    title: 'Guardians of ',
    italicTitle: 'the Selous',
    category: 'Conservation',
    date: 'August 15, 2025',
    readTime: '6 Min Read',
    image: '/image-03.jpg',
    excerpt: 'How local communities are lead-funding the protection of Africa\'s largest pristine wilderness reserve.'
  },
  {
    id: 5,
    slug: '/journal/shadows-in-the-baobabs',
    title: 'Shadows in ',
    italicTitle: 'the Baobabs',
    category: 'Wildlife',
    date: 'July 30, 2025',
    readTime: '4 Min Read',
    image: '/image-14.jpg',
    excerpt: 'Night-vision observations from our Tarangire camp, revealing the secret lives of the park\'s nocturnal specialists.'
  }
])

const filteredPosts = computed(() => {
  if (activeCategory.value === 'All') return posts.value
  return posts.value.filter(p => p.category === activeCategory.value)
})

onMounted(async () => {
  fetchImages()
  // Try to load posts from API if available
  try {
    const response = await axios.get(`${API_BASE_URL}/api/posts`)
    if (response.data && response.data.length > 0) {
      // Logic to merge real posts with our premium display structure
    }
  } catch (err) {
    console.warn('API posts not available, using premium defaults.')
  }
})
</script>

<style scoped>
.journal-page {
  background: #141814; /* Deep Jungle/Ebony */
  color: var(--ivory);
  min-height: 100vh;
  overflow-x: hidden;
}

em {
  font-style: italic;
  font-family: 'Playfair Display', serif;
  color: var(--gold);
}

.label {
  display: block;
  font-size: 0.7rem;
  letter-spacing: 0.4em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 24px;
  font-weight: 500;
}

/* ━━━ HERO SECTION ━━━ */
.journal-hero {
  position: relative;
  height: 100vh;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  overflow: hidden;
}

.hero-bg {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
  transform: scale(1.05);
  animation: slowZoom 20s ease-out infinite alternate;
}

@keyframes slowZoom {
  from { transform: scale(1.05); }
  to { transform: scale(1.15); }
}

.hero-overlay-texture {
  position: absolute;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3 Forts%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
  opacity: 0.03;
  pointer-events: none;
}

.hero-content {
  position: relative;
  z-index: 5;
  max-width: 900px;
  padding: 0 5%;
}

.hero-meta {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 30px;
}

.meta-dot {
  width: 6px; height: 6px;
  background: var(--gold);
  border-radius: 50%;
}

.meta-label {
  font-size: 0.8rem;
  letter-spacing: 0.5em;
  text-transform: uppercase;
  color: #FFF;
  font-weight: 300;
}

.hero-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(3.5rem, 8vw, 7.5rem);
  line-height: 1;
  margin-bottom: 30px;
  color: #FFF;
}

.hero-subtitle {
  font-size: clamp(1rem, 2vw, 1.25rem);
  line-height: 1.8;
  color: rgba(255,255,255,0.7);
  max-width: 650px;
  margin: 0 auto 40px;
  font-weight: 300;
}

.scroll-indicator {
  position: absolute;
  bottom: 60px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 15px;
}

.scroll-line {
  width: 1px;
  height: 60px;
  background: linear-gradient(to bottom, transparent, var(--gold), transparent);
  position: relative;
  overflow: hidden;
}

.scroll-line::after {
  content: '';
  position: absolute;
  top: -60px; left: 0;
  width: 100%;
  height: 100%;
  background: #FFF;
  animation: scrollLineMove 2s infinite cubic-bezier(0.7, 0, 0.3, 1);
}

@keyframes scrollLineMove {
  0% { transform: translateY(0); }
  100% { transform: translateY(120px); }
}

.scroll-text {
  font-size: 0.65rem;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  color: rgba(255,255,255,0.4);
}

/* ━━━ FEATURED SECTION (LIGHT THEME) ━━━ */
.featured-section {
  padding: 140px 8%;
  background: var(--ivory); /* Light Ivory Background */
  position: relative;
}

.featured-container {
  max-width: 1300px;
  margin: 0 auto;
}

.featured-heading {
  margin-bottom: 80px;
  text-align: left;
}

.featured-title-main {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2rem, 3.5vw, 3rem);
  color: #1a1a1a;
  margin: 0;
  line-height: 1.1;
}

.featured-dispatch-card {
  display: grid;
  grid-template-columns: 1.3fr 1fr;
  align-items: center;
  gap: 0;
  text-decoration: none;
  color: inherit;
  position: relative;
}

.featured-img-frame {
  position: relative;
  height: 650px;
  overflow: hidden;
  z-index: 1;
  box-shadow: 20px 40px 80px rgba(0,0,0,0.08);
}

.featured-img-frame img {
  width: 100%; height: 100%;
  object-fit: cover;
  transition: transform 1.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.featured-dispatch-card:hover .featured-img-frame img {
  transform: scale(1.05);
}

.img-overlay-light {
  position: absolute;
  inset: 0;
  background: linear-gradient(to right, rgba(245, 240, 232, 0.4), transparent);
  pointer-events: none;
}

.post-cat-badge {
  position: absolute;
  top: 40px; left: 40px;
  background: #1a1a1a;
  color: #FFF;
  padding: 10px 20px;
  font-size: 0.7rem;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-weight: 600;
  z-index: 2;
}

.featured-text-content {
  background: #FFF;
  padding: 100px 80px;
  margin-left: -160px; /* Deeper Overlap */
  position: relative;
  z-index: 2;
  box-shadow: 40px 60px 100px rgba(0,0,0,0.03);
  border: 1px solid rgba(0,0,0,0.03);
}

/* Decorative corner for the text block */
.featured-text-content::before {
  content: '';
  position: absolute;
  top: 40px; right: 40px;
  width: 100px; height: 100px;
  border-top: 1px solid var(--gold);
  border-right: 1px solid var(--gold);
  opacity: 0.3;
  pointer-events: none;
}


.post-meta {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 25px;
  font-size: 0.75rem;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: #888;
}

.post-dot {
  width: 4px; height: 4px;
  background: var(--gold);
  border-radius: 50%;
}

.post-display-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2rem, 4vw, 3.8rem);
  line-height: 1.1;
  color: #1a1a1a;
  margin-bottom: 30px;
}

.post-excerpt {
  font-size: 1.1rem;
  line-height: 1.9;
  color: #555;
  font-weight: 300;
  margin-bottom: 45px;
}

.dispatch-footer {
  padding-top: 35px;
  border-top: 1px solid rgba(0,0,0,0.06);
}

.read-dispatch-btn {
  display: inline-flex;
  align-items: center;
  gap: 15px;
  font-size: 0.85rem;
  letter-spacing: 0.25em;
  text-transform: uppercase;
  color: #1a1a1a;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}

.btn-arrow {
  color: var(--gold);
  font-size: 1.2rem;
  transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.featured-dispatch-card:hover .btn-arrow {
  transform: translateX(8px);
}


/* ━━━ ARCHIVE SECTION ━━━ */
.archive-section {
  padding: 120px 8% 180px;
  background: var(--ivory);
  color: var(--text-dark);
}

.archive-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 80px;
  gap: 40px;
}

.archive-heading {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 4vw, 4rem);
  color: #1a1a1a;
  margin: 0;
  line-height: 1;
}

.archive-filters {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.filter-pill {
  background: transparent;
  border: 1px solid rgba(0,0,0,0.1);
  padding: 8px 24px;
  border-radius: 30px;
  font-size: 0.75rem;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.filter-pill.active, .filter-pill:hover {
  background: #1a1a1a;
  color: #FFF;
  border-color: #1a1a1a;
}

.editorial-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 60px 40px;
}

.archive-card {
  text-decoration: none;
  color: inherit;
  display: flex;
  flex-direction: column;
}

.archive-img-wrap {
  position: relative;
  height: 480px;
  overflow: hidden;
  margin-bottom: 30px;
  border-radius: 2px;
}

.archive-img-wrap img {
  width: 100%; height: 100%;
  object-fit: cover;
  transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.archive-card:hover .archive-img-wrap img {
  transform: scale(1.08);
}

.card-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.2) 0%, transparent 40%);
  opacity: 0;
  transition: opacity 0.4s;
}

.archive-card:hover .card-overlay { opacity: 1; }

.card-meta {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
}

.card-cat {
  font-size: 0.7rem;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  color: var(--gold);
  font-weight: 600;
}

.card-date {
  font-size: 0.7rem;
  color: #888;
  letter-spacing: 0.1em;
}

.card-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.8rem;
  line-height: 1.2;
  margin-bottom: 15px;
  color: #1a1a1a;
  transition: color 0.3s;
}

.archive-card:hover .card-title { color: var(--gold); }

.card-excerpt {
  font-size: 0.95rem;
  line-height: 1.8;
  color: #555;
  margin-bottom: 25px;
  font-weight: 300;
  
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.card-footer {
  margin-top: auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 20px;
  border-top: 1px solid rgba(0,0,0,0.05);
}

.read-link {
  font-size: 0.75rem;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: #1a1a1a;
  font-weight: 600;
}

.read-time {
  font-size: 0.7rem;
  color: #888;
  font-style: italic;
}

/* Asymmetrical Heights */
.card-size-1 .archive-img-wrap { height: 600px; }
.card-size-2 .archive-img-wrap { height: 420px; }

/* ━━━ PAGINATION ━━━ */
.pagination-footer {
  margin-top: 120px;
  text-align: center;
  position: relative;
}

.pag-line {
  height: 1px;
  width: 100%;
  background: rgba(0,0,0,0.05);
  position: absolute;
  top: 50%; left: 0;
  z-index: 1;
}

.load-more-btn {
  position: relative;
  z-index: 2;
  background: var(--ivory);
  border: 1px solid #1a1a1a;
  padding: 20px 50px;
  color: #1a1a1a;
  text-transform: uppercase;
  letter-spacing: 0.3em;
  font-size: 0.8rem;
  cursor: pointer;
  transition: all 0.3s;
}

.load-more-btn:hover {
  background: #1a1a1a;
  color: #FFF;
}

/* ━━━ NEWSLETTER SECTION ━━━ */
.newsletter-dispatch {
  padding: 140px 8%;
  background: #1B2B1B; /* Dark Safari Green */
  color: #FFF;
}

.newsletter-wrap {
  max-width: 800px;
  margin: 0 auto;
  text-align: center;
}

.news-h {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 5vw, 4.5rem);
  line-height: 1.1;
  margin: 0 0 30px;
}

.news-p {
  font-size: 1.1rem;
  color: rgba(255,255,255,0.6);
  line-height: 1.8;
  margin-bottom: 50px;
}

.news-form {
  display: flex;
  border-bottom: 2px solid rgba(255,255,255,0.1);
  padding-bottom: 10px;
}

.news-form input {
  flex: 1;
  background: transparent;
  border: none;
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
  color: #FFF;
  padding: 10px 0;
}

.news-form input::placeholder { color: rgba(255,255,255,0.2); font-style: italic; }
.news-form input:focus { outline: none; }

.news-form button {
  background: transparent;
  border: none;
  color: var(--gold);
  text-transform: uppercase;
  letter-spacing: 0.3em;
  font-weight: 600;
  cursor: pointer;
  padding: 0 20px;
}

/* ━━━ RESPONSIVE ━━━ */
@media (max-width: 1200px) {
  .featured-dispatch-card { grid-template-columns: 1fr; gap: 60px; }
  .featured-text-content { padding-right: 0; }
  .featured-img-frame { height: 500px; }
  .editorial-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 1024px) {
  .journal-hero { height: 80vh; }
  .hero-title { font-size: clamp(3rem, 8vw, 5rem); }
  .featured-section, .archive-section, .newsletter-dispatch { padding: 80px 5%; }
  .featured-img-frame { height: 400px; }
  .archive-header { flex-direction: column; align-items: flex-start; gap: 20px; }
  .archive-filters { flex-wrap: wrap; }
  .card-size-1 .archive-img-wrap, .card-size-2 .archive-img-wrap { height: 300px; }
}

@media (max-width: 768px) {
  .journal-hero { height: 70vh; min-height: 500px; }
  .hero-content { padding: 0 6%; }
  .hero-title { font-size: clamp(2.5rem, 10vw, 4rem); }
  .hero-subtitle { font-size: 1rem; }
  .featured-section, .archive-section, .newsletter-dispatch { padding: 60px 5%; }
  .featured-dispatch-card { gap: 40px; }
  .featured-img-frame { height: 300px; }
  .featured-text-content { padding: 0; }
  .featured-heading { margin-bottom: 40px; }
  .post-display-title { font-size: 1.6rem; }
  .post-excerpt { font-size: 1rem; }
  .editorial-grid { grid-template-columns: 1fr; gap: 30px; }
  .card-size-0 .archive-img-wrap, .card-size-1 .archive-img-wrap, .card-size-2 .archive-img-wrap { height: 250px; }
  .archive-card-body { padding: 20px; }
  .card-title { font-size: 1.2rem; }
  .filter-pill { padding: 6px 16px; font-size: 0.75rem; }
  .news-h { font-size: clamp(1.8rem, 6vw, 2.5rem); }
  .news-form { flex-direction: column; gap: 16px; border-bottom: none; }
  .news-form input { font-size: 1.2rem; border-bottom: 2px solid rgba(255,255,255,0.1); }
  .news-form button { padding: 12px 20px; }
  .load-more-btn { padding: 16px 36px; font-size: 0.75rem; }
}

@media (max-width: 640px) {
  .journal-hero { height: 65vh; min-height: 420px; }
  .hero-title { font-size: clamp(2rem, 10vw, 3rem); }
  .hero-subtitle { font-size: 0.9rem; }
  .featured-section, .archive-section, .newsletter-dispatch { padding: 40px 5%; }
  .featured-img-frame { height: 220px; }
  .post-display-title { font-size: 1.3rem; }
  .post-excerpt { font-size: 0.9rem; }
  .card-size-0 .archive-img-wrap, .card-size-1 .archive-img-wrap, .card-size-2 .archive-img-wrap { height: 200px; }
  .archive-card-body { padding: 16px; }
  .card-title { font-size: 1.1rem; }
  .card-date, .card-cat { font-size: 0.75rem; }
  .news-p { font-size: 0.95rem; }
  .newsletter-dispatch { padding: 40px 5%; }
}

@media (max-width: 480px) {
  .journal-hero { min-height: 380px; }
  .hero-title { font-size: clamp(1.8rem, 10vw, 2.5rem); }
  .featured-img-frame { height: 180px; }
  .post-display-title { font-size: 1.1rem; }
  .post-excerpt { font-size: 0.85rem; }
  .archive-card-body { padding: 14px; }
  .card-title { font-size: 1rem; }
  .card-size-0 .archive-img-wrap, .card-size-1 .archive-img-wrap, .card-size-2 .archive-img-wrap { height: 180px; }
  .news-h { font-size: 1.5rem; }
  .filter-pill { padding: 4px 12px; font-size: 0.7rem; letter-spacing: 0.15em; }
  .scroll-indicator { display: none; }
}

@media (max-width: 375px) {
  .journal-hero { min-height: 340px; }
  .hero-title { font-size: 1.6rem; }
  .featured-section, .archive-section { padding: 32px 4%; }
  .featured-img-frame { height: 160px; }
  .card-size-0 .archive-img-wrap, .card-size-1 .archive-img-wrap, .card-size-2 .archive-img-wrap { height: 160px; }
  .newsletter-dispatch { padding: 32px 4%; }
  .post-display-title { font-size: 1rem; }
}
</style>

