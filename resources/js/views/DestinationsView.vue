<template>
  <div class="destinations-page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    
    <!-- Premium Hero Section -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label" v-reveal>✦ The East African Landscape</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Iconic ', class: 'white' },
            { text: 'Destinations', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="hero-subtitle" v-reveal>
          From the thundering migration to the silent peaks of Kilimanjaro, discover the most breathtaking corners of Tanzania's untamed wilderness.
        </p>
      </div>
    </section>

    <!-- Main Destinations Content -->
    <section id="destinations-extended">
      <div class="dest-intro">
        <div class="section-header" style="text-align:left;" v-reveal>
          <span class="section-label" style="color:var(--ebony)">Sanctuaries</span>
          <h2 class="section-heading">Wonders of <em>Nature</em></h2>
        </div>
        
        <div class="dest-filter" v-reveal>
          <button 
            v-for="filter in ['All', 'National Parks', 'Mountains', 'Lakes', 'Islands']" 
            :key="filter"
            :class="['filter-btn', { active: activeFilter === filter }]"
            @click="activeFilter = filter"
          >
            {{ filter }}
          </button>
        </div>
      </div>

      <!-- Destinations Grid -->
      <transition-group name="fade" tag="div" class="destinations-grid">
        <div 
          class="dest-card" 
          v-for="dest in filteredDestinations" 
          :key="dest.name"
          v-reveal
        >
          <div class="dest-card-bg" :style="{ backgroundImage: `url(${getImageUrl(dest.image)})` }"></div>
          <div class="dest-card-overlay"></div>
          <div class="dest-info">
            <div class="dest-country">{{ dest.region }} ✦ {{ dest.category }}</div>
            <div class="dest-name">{{ dest.name }}</div>
            <div class="dest-desc">{{ dest.description }}</div>
            <router-link :to="'/destinations/' + dest.slug" class="dest-arrow" style="text-decoration:none;">Discover</router-link>
          </div>
        </div>
      </transition-group>
    </section>

    <!-- Featured Destination Spotlight -->
    <section id="featured-dest">
      <div class="featured-wrapper">
        <div class="featured-img reveal-left" v-reveal>
          <img :src="getImage('featured_img', '/image-12.jpg')" alt="Ruaha National Park">
          <div class="spotlight-badge">Destination of the Month</div>
        </div>
        <div class="featured-content reveal-right" v-reveal>
          <span class="section-label" style="color:var(--gold)">Hidden Gem</span>
          <h2 class="section-heading" style="color:var(--forest)">Ruaha <em>National Park</em></h2>
          <p class="featured-text">
            Tanzania's best-kept secret. Ruaha offers an unparalleled sense of isolation and wilderness. Home to ten percent of the world's lion population and massive elephant herds, its rugged landscapes of ancient baobabs and ancient riverbeds provide the ultimate frontier for true wildlife connoisseurs.
          </p>
          <ul class="featured-highlights">
            <li><span>✦</span> Largest National Park in Tanzania</li>
            <li><span>✦</span> Immense predator concentrations</li>
            <li><span>✦</span> Remote, uncrowded luxury camps</li>
          </ul>
          <router-link to="/contact" class="btn-primary" style="margin-top:30px; display:inline-block;"><span>Plan Your Visit</span></router-link>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import { usePageImages } from '../composables/usePageImages'
import { useSettings, API_BASE_URL } from '../composables/useSettings'

const { images, fetchImages, getImage } = usePageImages('destinations');
const { getImageUrl } = useSettings();

const activeFilter = ref('All')
const destinations = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  fetchImages();
  
  try {
    const response = await axios.get(`${API_BASE_URL}/api/destinations`)
    // Map backend 'type' to frontend 'category' labels for filtering
    destinations.value = response.data.map(d => ({
      ...d,
      category: d.type === 'National Park' || d.type === 'Conservation Area' ? 'National Parks' : 
                d.type === 'Mountain' ? 'Mountains' : 
                d.type === 'Lake' ? 'Lakes' : 
                d.type === 'Island' ? 'Islands' : 'Other'
    }))
  } catch (err) {
    console.error('Error fetching destinations:', err)
    error.value = 'Unable to load destinations.'
  } finally {
    loading.value = false
  }
})

const filteredDestinations = computed(() => {
  if (activeFilter.value === 'All') return destinations.value
  return destinations.value.filter(d => d.category === activeFilter.value)
})
</script>

<style scoped>
/* HERO - Now using Global .premium-hero */

@keyframes destZoomOut {
  from { transform: scale(1.15); }
  to { transform: scale(1); }
}

/* DESTINATIONS EXTENDED SECTION */
#destinations-extended {
  padding: 100px 8%;
  background: var(--forest);
  min-height: 100vh;
}
.dest-intro {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 70px;
  gap: 40px;
}
.dest-filter {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
  flex-wrap: wrap;
}
.filter-btn {
  background: transparent;
  border: 1px solid rgba(10, 10, 10, 0.15);
  color: var(--ebony);
  padding: 10px 24px;
  font-family: var(--f-sans);
  font-size: var(--f-meta);
  letter-spacing: var(--ls-wide);
  text-transform: uppercase;
  cursor: pointer;
  transition: all 0.3s;
}

.filter-btn.active, .filter-btn:hover {
  border-color: var(--gold);
  color: var(--gold);
  background: rgba(201,168,76,0.08);
}

.destinations-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  grid-auto-rows: 320px;
  gap: 20px;
}
/* First card large if enough space, but dynamic filtering makes grid unpredictable. Keeping uniform tiles is safer for filter transitions, or specifically target first child: */
.dest-card:first-child {
  grid-column: span 2;
  grid-row: span 2;
}

/* Base Destination Card Styles reused from original global css, adjusted selectively */
.dest-card {
  position: relative;
  overflow: hidden;
  cursor: pointer;
}
.dest-card-bg {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
  transform: scale(1.05);
  transition: transform 0.7s ease;
}
.dest-card:hover .dest-card-bg { transform: scale(1.12); }

.dest-card-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(14,31,14,0.9) 0%, rgba(14,31,14,0.1) 60%);
  transition: background 0.4s;
}
.dest-card:hover .dest-card-overlay {
  background: linear-gradient(to top, rgba(14,31,14,0.95) 0%, rgba(14,31,14,0.3) 60%);
}

.dest-info {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 30px;
  transform: translateY(10px);
  transition: transform 0.4s;
}
.dest-card:hover .dest-info { transform: translateY(0); }

.dest-country { font-size: var(--f-meta); letter-spacing: var(--ls-wide); text-transform: uppercase; color: var(--ebony); margin-bottom: 8px; }
.dest-name { font-family: var(--f-serif); font-size: var(--f-h3); font-weight: 400; color: var(--ivory); margin-bottom: 8px; }
.dest-card:first-child .dest-name { font-size: var(--f-h2); }
.dest-desc {
  font-size: var(--f-body);
  font-weight: 300;
  color: rgba(245,240,232,0.75);
  line-height: var(--lh-base);
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.5s ease;
}
.dest-card:hover .dest-desc { max-height: 80px; }

.dest-arrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  margin-top: 16px;
  font-size: var(--f-meta);
  letter-spacing: var(--ls-wide);
  text-transform: uppercase;
  color: var(--gold);
  opacity: 0;
  transition: opacity 0.4s 0.1s;
}
.dest-card:hover .dest-arrow { opacity: 1; }
.dest-arrow::after { content: '→'; }

/* Vue List Transition out/in */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.4s ease, transform 0.4s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: scale(0.95);
}

/* FEATURED DESTINATION */
#featured-dest {
  padding: 140px 10%;
  background: var(--ivory);
  color: var(--text-dark);
}
.featured-wrapper {
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 80px;
  align-items: center;
}
.featured-img {
  position: relative;
  height: 600px;
  box-shadow: -30px 30px 0 rgba(201,168,76,0.15);
}
.featured-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.spotlight-badge {
  position: absolute;
  top: 30px;
  right: -30px;
  background: var(--gold);
  color: var(--forest);
  padding: 15px;
  font-family: var(--f-serif);
  font-size: var(--f-h3);
  font-style: italic;
  box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.featured-text {
  font-size: var(--f-body);
  line-height: var(--lh-base);
  color: var(--text-mid);
  margin-bottom: 30px;
}

.featured-highlights {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 16px;
}
.featured-highlights li {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 1rem;
  letter-spacing: 0.05em;
  color: var(--forest);
  font-weight: 500;
  text-transform: uppercase;
}
.featured-highlights span {
  color: var(--gold);
  font-size: 1rem;
}

/* RESPONSIVE */
@media (max-width: 1024px) {
  .dest-intro {
    flex-direction: column;
    align-items: flex-start;
  }
  .featured-wrapper {
    grid-template-columns: 1fr;
    gap: 60px;
  }
  .featured-img {
    height: 450px;
  }
  .spotlight-badge {
    right: 20px;
  }
  .dest-card:first-child {
    grid-column: span 1;
    grid-row: span 1;
  }
  .dest-card:first-child .dest-name {
    font-size: 1.6rem;
  }
  .hero-title { font-size: clamp(3rem, 8vw, 5rem); }
}
@media (max-width: 768px) {
  .hero { min-height: 60vh; }
  .hero-title { font-size: clamp(2.5rem, 10vw, 4rem); }
  .hero-lead { font-size: 1rem; }
  .dest-intro { margin-bottom: 60px; }
  .intro-title { font-size: clamp(1.8rem, 6vw, 2.5rem); }
  .intro-text { font-size: 1rem; line-height: 1.7; }
  .featured-wrapper { gap: 40px; }
  .featured-content { padding: 0; }
  .featured-img { height: 320px; }
  .featured-name { font-size: 1.6rem; }
  .featured-desc { font-size: 0.95rem; }
  .spotlight-badge { right: 16px; bottom: 16px; padding: 12px 20px; }
  .destinations-section { padding: 60px 5%; }
  .destinations-grid { gap: 20px; }
  .dest-card:first-child .dest-name { font-size: 1.4rem; }
  .dest-name { font-size: 1.2rem; }
  .dest-desc { font-size: 0.9rem; }
  .featured-highlights { gap: 16px; }
}
@media (max-width: 640px) {
  .destinations-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }
  .hero-title {
    font-size: 2.5rem;
  }
  .hero { min-height: 55vh; min-height: 420px; }
  .featured-img { height: 260px; }
  .featured-name { font-size: 1.3rem; }
  .destinations-section { padding: 48px 5%; }
  .dest-card { min-height: 200px; }
}
@media (max-width: 480px) {
  .hero-title { font-size: 2rem; }
  .hero { min-height: 50vh; min-height: 360px; }
  .hero-lead { font-size: 0.9rem; }
  .intro-title { font-size: 1.5rem; }
  .intro-text { font-size: 0.9rem; }
  .featured-img { height: 220px; }
  .featured-name { font-size: 1.2rem; }
  .featured-desc { font-size: 0.9rem; }
  .featured-highlights span { font-size: 0.85rem; }
  .spotlight-badge { padding: 10px 16px; }
  .destinations-grid { gap: 12px; }
  .dest-card { min-height: 180px; }
}
@media (max-width: 375px) {
  .hero-title { font-size: 1.6rem; }
  .hero { min-height: 320px; }
  .destinations-section { padding: 32px 4%; }
  .featured-wrapper { gap: 28px; }
  .featured-img { height: 180px; }
  .dest-name { font-size: 1rem; }
}
</style>
