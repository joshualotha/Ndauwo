<template>
  <div class="safari-detail-page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    
    <!-- Hero Section -->
    <!-- Premium Hero Section -->
    <section class="premium-hero" v-if="tour">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.55) 0%, rgba(10, 10, 10, 0.35) 45%, rgba(10, 10, 10, 0.75) 100%), url(${getImage('hero_bg', tour.image)})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label">✦ {{ tour.hero_label || 'Signature Route' }}</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: tour.title, class: 'white' }
          ]]" :startDelay="500" />
        </h1>
        <div class="hero-meta" v-reveal>
          <div class="meta-item"><Clock :size="16"/> {{ tour.duration_label || tour.duration_days + ' Days' }}</div>
          <div class="meta-item"><MapPin :size="16"/> {{ tour.location_summary }}</div>
          <div class="meta-item"><Activity :size="16"/> {{ tour.difficulty || 'Expert Led' }}</div>
        </div>
      </div>
    </section>

    <!-- Quick Overview Bar -->
    <div class="overview-bar" v-if="tour">
      <div class="overview-inner">
        <div class="overview-stat">
          <span class="stat-label">From</span>
          <span class="stat-val">${{ Number(tour.price).toLocaleString() }} <small>pp</small></span>
        </div>
        <div class="overview-stat">
          <span class="stat-label">Group Size</span>
          <span class="stat-val">{{ tour.group_size || 'Private' }}</span>
        </div>
        <div class="overview-stat">
          <span class="stat-label">Signature Experience</span>
          <span class="stat-val">{{ tour.signature_experience || 'Wilderness Exploration' }}</span>
        </div>
        <div class="overview-cta" v-reveal>
          <router-link to="/contact" class="btn-primary"><span>Inquire Now</span></router-link>
        </div>
      </div>
    </div>

    <!-- Main Content Grid -->
    <section class="content-section">
      <div class="content-grid">
        
        <!-- Left: Itinerary & Details -->
        <div class="main-content" v-if="tour">
          <h2 class="content-heading" v-reveal>The <em>Experience</em></h2>
          <p class="intro-text" v-reveal>
            {{ tour.pull_quote || tour.description }}
          </p>

          <div class="highlights-box" v-if="tour.highlights && tour.highlights.length" v-reveal>
            <h3 class="subsection-title">Key Highlights</h3>
            <ul class="highlights-list">
              <li v-for="(hl, idx) in tour.highlights" :key="idx">
                <span class="hl-bullet">✦</span> {{ hl }}
              </li>
            </ul>
          </div>

          <div class="itinerary" v-reveal>
            <h3 class="subsection-title">Day-by-Day Itinerary</h3>

            <div class="day-card" v-for="(day, idx) in tour.daily_itinerary" :key="idx">
              <div class="day-number">{{ day.day }}</div>
              <div class="day-content">
                <h4 class="day-title">{{ day.title }}</h4>
                <p>{{ day.content }}</p>
                <div class="day-lodge" v-if="day.accommodation"><Tent :size="14"/> {{ day.accommodation }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right: Sidebar (Inclusions/Map) -->
        <aside class="sidebar" v-if="tour">
          <div class="sidebar-widget" v-show="tour.inclusions && tour.inclusions.length" v-reveal>
            <h3>What's Included</h3>
            <ul class="check-list">
              <li v-for="(inc, idx) in tour.inclusions" :key="idx">
                <Check :size="16" class="check-icon"/> {{ inc }}
              </li>
            </ul>
          </div>

          <div class="sidebar-widget" v-show="tour.exclusions && tour.exclusions.length" v-reveal>
            <h3>Not Included</h3>
            <ul class="cross-list">
              <li v-for="(exc, idx) in tour.exclusions" :key="idx">
                <X :size="16" class="cross-icon"/> {{ exc }}
              </li>
            </ul>
          </div>
        </aside>

      </div>
    </section>

    <!-- Gallery Strip -->
    <section class="gallery-strip">
      <div class="strip-img" :style="{ backgroundImage: `url(${getImage('gallery_1', '/image-11.jpg')})` }"></div>
      <div class="strip-img" :style="{ backgroundImage: `url(${getImage('gallery_2', '/image-10.jpg')})` }"></div>
      <div class="strip-img" :style="{ backgroundImage: `url(${getImage('gallery_3', '/image-16.jpg')})` }"></div>
    </section>

  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import { Clock, MapPin, Activity, Check, X, Tent } from 'lucide-vue-next'
import HandwrittenTypewriter from '../components/HandwrittenTypewriter.vue'
import { usePageImages } from '../composables/usePageImages'
import { useSettings, API_BASE_URL } from '../composables/useSettings'

const route = useRoute()
const tour = ref(null)
const loading = ref(true)

const { fetchImages, getImage } = usePageImages('safari_detail');
const { getImageUrl } = useSettings();

const fetchTour = async () => {
  loading.value = true
  try {
    const slug = route.params.slug || route.params.id
    console.log('Fetching safari detail for:', slug)
    const response = await axios.get(`${API_BASE_URL}/api/packages/${slug}`)
    tour.value = response.data
    // Path resolution is now handled by getImageUrl helper in template/composables
    console.log('Successfully fetched safari:', tour.value?.title)
  } catch (error) {
    console.error('Error fetching safari tour:', error)
    tour.value = null
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchImages();
  fetchTour();
})

watch(() => route.params.slug, fetchTour)
</script>

<style scoped>
/* HERO - Now using Global .premium-hero */
.hero-meta {
  display: flex; gap: 30px; justify-content: center; color: var(--ivory); font-family: 'Jost', sans-serif; font-weight: 300; letter-spacing: 0.1em; text-transform: uppercase; font-size: 1rem;
}
.meta-item { display: flex; align-items: center; gap: 8px; }

/* OVERVIEW BAR */
.overview-bar {
  background: var(--ivory);
  border-bottom: 1px solid rgba(201,168,76,0.2);
  position: relative;
  z-index: 10;
}
.overview-inner {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 30px 5%;
}
.overview-stat { display: flex; flex-direction: column; }
.stat-label { font-size: 1rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-mid); margin-bottom: 5px; }
.stat-val { font-family: 'Playfair Display', serif; font-size: 1.4rem; color: var(--forest); }
.stat-val small { font-size: 1rem; font-family: 'Jost', sans-serif; }

/* CONTENT GRID */
.content-section {
  background: var(--ivory);
  padding: 80px 5% 120px;
}
.content-grid {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 80px;
}
.content-heading { font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--forest); font-weight: 400; margin-bottom: 30px; }
.content-heading em { color: var(--gold); font-style: italic; }
.intro-text { font-size: 1.25rem; line-height: 1.9; color: var(--text-dark); margin-bottom: 60px; font-weight: 300; }

.subsection-title { font-family: 'Jost', sans-serif; font-size: 1rem; text-transform: uppercase; letter-spacing: 0.2em; color: var(--gold); margin-bottom: 40px; border-bottom: 1px solid rgba(201,168,76,0.3); padding-bottom: 15px; }

.day-card { display: grid; grid-template-columns: 80px 1fr; gap: 30px; margin-bottom: 40px; }
.day-number { font-family: 'Playfair Display', serif; font-size: 1.4rem; color: var(--gold); font-style: italic; padding-top: 5px; }
.day-title { font-family: 'Jost', sans-serif; font-size: 1.2rem; color: var(--forest); margin-bottom: 15px; font-weight: 500;}
.day-content p { font-size: 1.1rem; line-height: 1.7; color: var(--text-mid); margin-bottom: 15px; }
.day-lodge { display: inline-flex; align-items: center; gap: 8px; font-size: 1rem; letter-spacing: 0.05em; color: var(--forest); background: rgba(201,168,76,0.1); padding: 6px 16px; border-radius: 20px; }

/* HIGHLIGHTS BOX */
.highlights-box { margin-bottom: 60px; padding: 30px; background: rgba(201,168,76,0.05); border-left: 2px solid var(--gold); }
.highlights-list { list-style: none; padding: 0; display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
.highlights-list li { display: flex; gap: 10px; font-size: 1.05rem; color: var(--text-dark); }
.hl-bullet { color: var(--gold); }
@media (max-width: 640px) { .highlights-list { grid-template-columns: 1fr; } }

/* SIDEBAR */
.sidebar { margin-top: 20px; }
.sidebar-widget { background: white; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid rgba(201,168,76,0.1); margin-bottom: 30px; }
.sidebar-widget h3 { font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--forest); margin-bottom: 25px; }
.check-list, .cross-list { list-style: none; display: flex; flex-direction: column; gap: 15px; }
.check-list li, .cross-list li { display: flex; align-items: flex-start; gap: 12px; font-size: 1rem; color: var(--text-mid); line-height: 1.5; }
.check-icon { color: var(--forest); flex-shrink: 0; }
.cross-icon { color: #d36e5f; flex-shrink: 0; }

/* GALLERY STRIP */
.gallery-strip { display: grid; grid-template-columns: repeat(3, 1fr); height: 400px; }
.strip-img { background-size: cover; background-position: center; filter: grayscale(20%); transition: filter 0.4s; }
.strip-img:hover { filter: grayscale(0%); }

@media (max-width: 1024px) {
  .content-grid { grid-template-columns: 1fr; gap: 60px; }
  .overview-inner { flex-wrap: wrap; gap: 20px; justify-content: flex-start; }
  .overview-cta { width: 100%; margin-top: 10px; }
}
@media (max-width: 640px) {
  .day-card { grid-template-columns: 1fr; gap: 10px; border-left: 2px solid var(--gold); padding-left: 20px; }
  .hero-meta { flex-direction: column; gap: 10px; align-items: center; }
  .gallery-strip { grid-template-columns: 1fr; height: 600px; }
}
</style>
