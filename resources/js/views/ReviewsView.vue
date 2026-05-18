<template>
  <div class="reviews-page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    <!-- Premium Hero Section -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label" v-reveal>✦ Guest Experiences</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Guest ', class: 'white' },
            { text: 'Reviews', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
      </div>
    </section>

    <section class="content-section">
      <div class="content-inner" v-reveal>
        <span class="section-label" style="color:var(--gold); display:block; margin-bottom: 20px; font-weight: 500; letter-spacing: 0.3em; font-size: 0.85rem; text-transform: uppercase;">The Verdict</span>
        <h2 class="content-heading">Words from our<br><em>Travelers</em></h2>
        <p class="intro-text">
          Don't just take our word for it. Read what our guests have to say about their transformative journeys across Tanzania with Ndauwo Safaris. We measure our success not in bookings, but in the silences our guests experience when standing before the untamed.
        </p>
      </div>
      
      <!-- Testimonial Grid -->
      <div class="reviews-grid" v-if="!loading">
        <article 
          v-for="(review, index) in reviews" 
          :key="review.id"
          class="review-card"
          :class="{ 'offset-card': index % 2 !== 0 }"
          v-reveal
          :style="{ transitionDelay: (index * 0.1) + 's' }"
        >
          <div class="review-rating">
            <span class="star" v-for="n in review.rating" :key="n">★</span>
          </div>
          <p class="review-quote">{{ review.content }}</p>
          <div class="review-meta">
            <div class="meta-main">
              <span class="guest-name">{{ review.name }}</span>
              <span class="guest-loc">{{ review.location || 'Explorer' }}</span>
            </div>
            <span class="trip-context">{{ review.safari_type }}</span>
          </div>
        </article>
      </div>
      <div v-else class="loading-state">
        <p>Loading guest experiences...</p>
      </div>
    </section>

    <!-- Trust Banner -->
    <section class="trust-banner" v-reveal>
      <div class="trust-wrap">
        <h2>Recognized for <em>Excellence</em></h2>
        <div class="trust-logos">
          <!-- Mock Logos (Text) -->
          <div class="logo-item">TripAdvisor<br><span class="small">Travelers' Choice 2025</span></div>
          <div class="logo-item" style="border-left: 1px solid rgba(201,168,76,0.2); border-right: 1px solid rgba(201,168,76,0.2);">Condé Nast<br><span class="small">Top Specialist</span></div>
          <div class="logo-item">TATO<br><span class="small">Verified Member</span></div>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { usePageImages } from '../composables/usePageImages'

const { images, fetchImages } = usePageImages('reviews');

const reviews = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  fetchImages();
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/reviews')
    reviews.value = response.data
  } catch (err) {
    console.error('Error fetching reviews:', err)
    error.value = 'Unable to load reviews at this time.'
  } finally {
    loading.value = false
  }
})
</script>

<style scoped>
.reviews-page {
  background: var(--ivory);
  overflow-x: hidden;
}

/* HERO - Now using Global .premium-hero */

.content-section { 
  padding: 120px 5% 150px; 
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
  margin-bottom: 80px;
}

/* Review Grid */
.reviews-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
  max-width: 1200px;
  margin: 0 auto;
}

.review-card {
  background: #FFF;
  padding: 60px;
  border: 1px solid #EAEAEA;
  box-shadow: 0 20px 40px rgba(0,0,0,0.02);
}
.offset-card {
  transform: translateY(60px);
}

.review-rating {
  margin-bottom: 30px;
}
.star {
  color: var(--gold);
  font-size: 1.2rem;
  margin-right: 2px;
}

.review-quote {
  font-family: 'Playfair Display', serif;
  font-size: 1.25rem;
  line-height: 1.9;
  color: var(--forest);
  margin-bottom: 40px;
  font-style: italic;
}

.review-meta {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  border-top: 1px solid #EAEAEA;
  padding-top: 25px;
}
.meta-main {
  display: flex;
  flex-direction: column;
}
.guest-name {
  font-size: 1rem;
  color: var(--forest);
  font-weight: 600;
  margin-bottom: 5px;
}
.guest-loc {
  font-size: 0.8rem;
  color: #888;
  text-transform: uppercase;
  letter-spacing: 0.1em;
}
.trip-context {
  font-size: 0.75rem;
  color: var(--gold);
  text-transform: uppercase;
  letter-spacing: 0.15em;
  font-weight: 600;
}

/* Trust Banner */
.trust-banner {
  background-color: var(--forest);
  color: #FFF;
  padding: 100px 5%;
  text-align: center;
}
.trust-wrap {
  max-width: 1000px;
  margin: 0 auto;
}
.trust-wrap h2 {
  font-family: 'Playfair Display', serif;
  font-size: 3rem;
  font-weight: 400;
  margin-bottom: 60px;
}
.trust-wrap em {
  color: var(--gold);
  font-style: italic;
}
.trust-logos {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  align-items: center;
}
.logo-item {
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
  color: var(--gold);
  line-height: 1.2;
}
.logo-item .small {
  font-family: 'Jost', sans-serif;
  font-size: 0.75rem;
  color: rgba(255,255,255,0.6);
  text-transform: uppercase;
  letter-spacing: 0.2em;
  font-weight: 400;
  display: block;
  margin-top: 10px;
}

/* Responsive */
@media (max-width: 992px) {
  .reviews-grid {
    grid-template-columns: 1fr;
    gap: 30px;
  }
  .offset-card {
    transform: translateY(0);
  }
  .review-meta {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
  }
  .content-section { padding: 100px 5% 120px; }
}

@media (max-width: 768px) {
  .content-section { padding: 80px 5% 100px; }
  .content-heading { font-size: clamp(1.8rem, 5vw, 2.5rem); }
  .intro-text { font-size: 1.05rem; margin-bottom: 60px; }
  .reviews-grid { gap: 24px; }
  .review-card { padding: 40px 30px; }
  .review-quote { font-size: 1.1rem; }
  .trust-banner { padding: 80px 5%; }
  .trust-wrap h2 { font-size: 2.2rem; }
  .trust-logos { grid-template-columns: 1fr; gap: 30px; }
  .logo-item[style] {
    border-left: none !important;
    border-right: none !important;
    border-top: 1px solid rgba(201,168,76,0.2);
    border-bottom: 1px solid rgba(201,168,76,0.2);
    padding: 24px 0;
  }
  .logo-item { font-size: 1.3rem; }
}

@media (max-width: 640px) {
  .content-section { padding: 60px 4%; }
  .content-heading { font-size: 1.5rem; }
  .intro-text { font-size: 0.95rem; margin-bottom: 40px; line-height: 1.8; }
  .review-card { padding: 32px 24px; }
  .review-rating { margin-bottom: 20px; }
  .star { font-size: 1rem; }
  .review-quote { font-size: 1rem; line-height: 1.7; margin-bottom: 28px; }
  .guest-name { font-size: 0.9rem; }
  .guest-loc { font-size: 0.7rem; }
  .trust-banner { padding: 60px 4%; }
  .trust-wrap h2 { font-size: 1.8rem; margin-bottom: 40px; }
  .logo-item { font-size: 1.1rem; }
  .logo-item .small { font-size: 0.65rem; }
}

@media (max-width: 480px) {
  .content-section { padding: 48px 4% 60px; }
  .content-heading { font-size: 1.3rem; }
  .intro-text { font-size: 0.9rem; margin-bottom: 32px; }
  .review-card { padding: 28px 20px; }
  .review-quote { font-size: 0.9rem; }
  .trust-banner { padding: 48px 4%; }
  .trust-wrap h2 { font-size: 1.5rem; }
}

@media (max-width: 375px) {
  .content-section { padding: 40px 4% 48px; }
  .content-heading { font-size: 1.1rem; }
  .review-card { padding: 24px 16px; }
  .trip-context { font-size: 0.65rem; }
  .trust-wrap h2 { font-size: 1.3rem; }
}
</style>
