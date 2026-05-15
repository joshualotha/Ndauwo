<template>
  <div class="safaris-page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    
    <!-- Premium Hero Section -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      
      <div class="premium-hero-content">
        <span class="hero-label">✦ Curated Expeditions</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Unforgettable ', class: 'white' },
            { text: 'Journeys', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="hero-subtitle">
          From the thundering migration to the silent peaks of Kilimanjaro, discover a portfolio of safaris designed for the discerning explorer.
        </p>
      </div>
    </section>

    <!-- Interactive Tours Grid with Filtering -->
    <section id="tours-extended">
      <div class="tours-intro">
        <div class="section-header" style="text-align:left;" v-reveal>
          <span class="section-label" style="color:var(--ebony)">Our Offerings</span>
          <h2 class="section-heading" style="color:var(--ebony)">Signature <em>Safari</em> Packages</h2>
        </div>
        
        <div class="tours-filter" v-reveal>
          <button 
            v-for="filter in ['All Safaris', 'Signature Route', 'Mountain Trek', 'Beach Safari', 'Cultural Tour', 'Luxury Fly-In', 'Family Special']" 
            :key="filter"
            :class="['filter-btn', { active: activeFilter === filter }]"
            @click="activeFilter = filter"
          >
            {{ filter }}
          </button>
        </div>
      </div>

      <!-- Tours Grid -->
      <transition-group name="fade" tag="div" class="tours-grid">
        <div class="tour-card" v-for="tour in filteredTours" :key="tour.name" v-reveal>
          <div class="tour-img" :style="{ backgroundImage: `url(${getImageUrl(tour.image)})` }">
            <div class="tour-badge" v-if="tour.badge">{{ tour.badge }}</div>
          </div>
          <div class="tour-body">
            <div class="tour-duration">⏱ {{ tour.duration }}</div>
            <h3 class="tour-name">{{ tour.name }}</h3>
            <p class="tour-desc">{{ tour.description }}</p>
            <div class="tour-footer">
              <div><div class="tour-price-from">From</div><div class="tour-price">{{ tour.price }}</div></div>
              <div class="tour-includes">
                <div class="inc-dot" v-for="(icon, idx) in tour.icons" :key="idx"><component :is="icon" :size="16" stroke-width="1.5" /></div>
              </div>
            </div>
            <!-- Expanded Details button specifically for dedicated page -->
            <router-link :to="'/safaris/' + (tour.slug || tour.name.toLowerCase().replace(/[^a-z0-9]+/g, '-'))" class="btn-ghost" style="width:100%; margin-top: 20px; font-size: 1rem; border-color: rgba(10,10,10,0.3); color: var(--ebony); display: block; text-align: center;">View Itinerary</router-link>
          </div>
        </div>
      </transition-group>
    </section>

    <!-- NEW SECTION: The Safari Experience (Why it's luxury) -->
    <section class="safari-experience">
      <div class="experience-visual reveal-left" v-reveal>
        <img src="/image-12.jpg" alt="Luxury Safari Tent">
      </div>
      <div class="experience-text reveal-right" v-reveal>
        <span class="section-label" style="color:var(--gold)">The Ndauwo Standard</span>
        <h2 class="section-heading" style="color:var(--ebony)">Untamed Wilderness,<br><em>Uncompromising Comfort</em></h2>
        <p class="experience-p">
          We believe that a true safari is an immersion, not an observation. Our itineraries are engineered to place you in the heart of the action while maintaining absolute luxury. 
        </p>
        <div class="experience-pillars">
          <div class="pillar">
            <div class="pillar-icon"><Tent :size="32" stroke-width="1.5" color="var(--gold)" /></div>
            <h4>Exclusive Camps</h4>
            <p>From mobile migration camps to permanent luxury lodges, carefully selected for location and intimacy.</p>
          </div>
          <div class="pillar">
            <div class="pillar-icon"><Compass :size="32" stroke-width="1.5" color="var(--gold)" /></div>
            <h4>Custom Vehicles</h4>
            <p>Open-sided, custom-fitted 4x4 Land Cruisers offering unimpeded, 360-degree photographic views.</p>
          </div>
          <div class="pillar">
            <div class="pillar-icon"><Wine :size="32" stroke-width="1.5" color="var(--gold)" /></div>
            <h4>Bush Dining</h4>
            <p>Gourmet meals served under the acacia trees, paired with fine South African wines.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- NEW SECTION: Bespoke Call to Action -->
    <section class="bespoke-cta" v-reveal>
      <div class="cta-content">
        <h2 class="cta-title">Looking for something <em>unique?</em></h2>
        <p class="cta-text">
          Our Safari Designers specialize in creating entirely bespoke itineraries tailored to your exact pace, interests, and milestones.
        </p>
        <router-link to="/contact" class="btn-primary"><span>Design Your Custom Safari</span></router-link>
      </div>
    </section>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { Tent, Utensils, Mountain, PawPrint, Waves, Camera, Compass, Sunrise, Target, Wine, Footprints } from 'lucide-vue-next'
import { usePageImages } from '../composables/usePageImages'
import { useSettings, API_BASE_URL } from '../composables/useSettings'

const { images, fetchImages, getImage } = usePageImages('safaris');
const { getImageUrl } = useSettings();

const activeFilter = ref('All Safaris')
const tours = ref([])
const loading = ref(true)

const iconMap = {
  Tent, Utensils, Mountain, PawPrint, Waves, Camera, Compass, Sunrise, Target, Wine, Footprints
}

onMounted(async () => {
  fetchImages();
  
  try {
    const response = await axios.get(`${API_BASE_URL}/api/packages`)
    tours.value = response.data.map(t => ({
      ...t,
      name: t.title, 
      duration: t.duration_label || `${t.duration_days} Days`,
      price: '$' + Number(t.price).toLocaleString(),
      icons: (t.feature_icons || []).map(iconName => iconMap[iconName] || PawPrint),
      category: t.type,
      image: t.image
    }))
  } catch (error) {
    console.error('Error fetching tours:', error)
  } finally {
    loading.value = false
  }
})

const filteredTours = computed(() => {
  if (activeFilter.value === 'All Safaris') return tours.value
  return tours.value.filter(t => t.category === activeFilter.value)
})
</script>

<style scoped>
/* HERO - Now using Global .premium-hero */

@keyframes destZoomOut {
  from { transform: scale(1.15); }
  to { transform: scale(1); }
}


/* TOURS EXTENDED */
#tours-extended {
  padding: 100px 8%;
  background: var(--forest-mid);
}
.tours-intro {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 70px;
  gap: 40px;
  text-align: left;
}
.tours-filter {
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
  font-family: 'Jost', sans-serif;
  font-size: 1rem;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  cursor: pointer;
  transition: all 0.3s;
}
.filter-btn.active, .filter-btn:hover {
  border-color: var(--gold);
  color: var(--gold);
  background: rgba(201,168,76,0.08);
}

.tours-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 30px;
}
/* Transitions for grid */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.4s ease, transform 0.4s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: scale(0.95) translateY(20px);
}

/* Base Tour Card Styles imported */
.tour-card {
  background: white;
  border: 1px solid rgba(10, 10, 10, 0.08);
  display: flex;
  flex-direction: column;
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  box-shadow: 0 10px 30px rgba(10, 10, 10, 0.04);
}
.tour-card:hover { transform: translateY(-10px); box-shadow: 0 40px 80px rgba(10, 10, 10, 0.12); }
.tour-img { height: 260px; background-size: cover; background-position: center; position: relative; }
.tour-badge { position: absolute; top: 15px; right: 15px; background: var(--gold); color: #0A0A0A; font-family: 'Playfair Display', serif; font-size: 1rem; font-style: italic; padding: 6px 16px; font-weight: 600; z-index: 2; }
.tour-body { padding: 30px; flex: 1; display: flex; flex-direction: column; }
.tour-duration { font-size: 1rem; color: var(--gold); letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 12px; }
.tour-name { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: var(--ebony); font-weight: 400; margin-bottom: 15px; }
.tour-desc { font-size: 1rem; color: var(--text-mid); line-height: 1.7; margin-bottom: 30px; flex: 1; }
.tour-footer { display: flex; justify-content: space-between; align-items: flex-end; padding-top: 20px; border-top: 1px solid rgba(10,10,10,0.08); }
.tour-price-from { font-size: 1rem; color: var(--text-mid); text-transform: uppercase; letter-spacing: 0.1em; }
.tour-price { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: var(--ebony); }
.tour-includes { display: flex; gap: 8px; }
.inc-dot { width: 32px; height: 32px; border-radius: 50%; background: rgba(10,10,10,0.05); display: flex; align-items: center; justify-content: center; font-size: 1rem; border: 1px solid rgba(10,10,10,0.1); color: var(--ebony); transition: border-color 0.3s; }
.tour-card:hover .inc-dot { border-color: var(--gold); }


/* SECTION: THE EXPERIENCE */
.safari-experience {
  display: grid;
  grid-template-columns: 1fr 1fr;
  align-items: center;
  background: var(--ivory);
}
.experience-visual {
  height: 100%;
  min-height: 700px;
}
.experience-visual img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.experience-text {
  padding: 100px 10%;
}
.experience-p {
  font-size: 1rem;
  line-height: 1.8;
  color: var(--text-mid);
  margin-bottom: 50px;
}
.experience-pillars {
  display: flex;
  flex-direction: column;
  gap: 30px;
}
.pillar {
  display: flex;
  flex-direction: column;
}
.pillar-icon {
  font-size: 1.8rem;
  margin-bottom: 10px;
}
.pillar h4 {
  font-family: 'Playfair Display', serif;
  font-size: 1.3rem;
  color: var(--forest);
  margin-bottom: 8px;
}
.pillar p {
  font-size: 1rem;
  line-height: 1.6;
  color: var(--text-mid);
}

/* BESPOKE CTA */
.bespoke-cta {
  padding: 120px 5%;
  background: linear-gradient(rgba(14,31,14,0.85), rgba(14,31,14,0.85)), url('/image-13.jpg') center/cover;
  text-align: center;
  display: flex;
  justify-content: center;
}
.cta-content {
  max-width: 600px;
  background: rgba(14,31,14,0.6);
  backdrop-filter: blur(10px);
  padding: 60px 40px;
  border: 1px solid rgba(201,168,76,0.3);
}
.cta-title {
  font-family: 'Playfair Display', serif;
  font-size: 2.5rem;
  color: var(--ivory);
  font-weight: 400;
  margin-bottom: 20px;
}
.cta-title em {
  font-style: italic;
  color: var(--gold);
}
.cta-text {
  font-size: 1rem;
  color: rgba(245,240,232,0.8);
  line-height: 1.7;
  margin-bottom: 40px;
}


/* RESPONSIVE */
@media (max-width: 1200px) {
  .tours-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 1024px) {
  .tours-intro { flex-direction: column; align-items: flex-start; }
  .safari-experience { grid-template-columns: 1fr; }
  .experience-visual { min-height: 500px; height: 500px; }
  .experience-text { padding: 80px 5%; }
}
@media (max-width: 640px) {
  .tours-grid { grid-template-columns: 1fr; }
  .subhero-title { font-size: 3.5rem; }
}
</style>
