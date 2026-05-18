<template>
  <div class="dest-page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">

    <!-- NOT FOUND -->
    <div v-if="!dest" class="not-found">
      <h1>Destination not found</h1>
      <router-link to="/destinations">← All Destinations</router-link>
    </div>

    <template v-else>

      <!-- 1. FULL-VIEWPORT HERO -->
      <section class="premium-hero">
        <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url('${getImage('hero_bg', dest.image)}')` }"></div>
        <div class="premium-hero-content">
          <span class="hero-label">{{ dest.label }}</span>
          <h1 class="hero-title">
            <HandwrittenTypewriter :phrases="[[
              { text: dest.name, class: 'white' }
            ]]" :startDelay="500" />
          </h1>
          <div class="hero-quick-facts">
            <div class="quick-fact">
              <span class="qf-label">Best Time</span>
              <span class="qf-value">{{ dest.best_time_to_visit }}</span>
            </div>
            <div class="qf-divider"></div>
            <div class="quick-fact">
              <span class="qf-label">Area / Elevation</span>
              <span class="qf-value">{{ dest.area }}</span>
            </div>
            <div class="qf-divider"></div>
            <div class="quick-fact">
              <span class="qf-label">Signature Experience</span>
              <span class="qf-value">{{ dest.signature_experience }}</span>
            </div>
          </div>
        </div>
      </section>

      <!-- 2. INTRO TEXT, light section -->
      <section class="intro-section" v-reveal>
        <div class="intro-inner">
          <div class="intro-text">
            <span class="label">The Destination</span>
            <p class="intro-lead" v-if="Array.isArray(dest.intro)">{{ dest.intro.join(' ') }}</p>
            <p class="intro-lead" v-else>{{ dest.intro }}</p>
          </div>
          <div class="intro-meta">
            <div class="meta-block">
              <span class="meta-label">Best Time</span>
              <span class="meta-val">{{ dest.best_time_to_visit }}</span>
            </div>
            <div class="meta-block">
              <span class="meta-label">Area / Elevation</span>
              <span class="meta-val">{{ dest.area }}</span>
            </div>
            <div class="meta-block">
              <span class="meta-label">Signature Experience</span>
              <span class="meta-val">{{ dest.signature_experience }}</span>
            </div>
          </div>
        </div>
      </section>

      <!-- 4. GEOGRAPHY + ECOLOGY, clean text focus -->
      <section class="geo-section" v-reveal>
        <div class="geo-text-block">
          <div class="geo-content">
            <span class="label">Geography</span>
            <h2 class="geo-h">The Landscape</h2>
            <p>{{ dest.geography }}</p>
          </div>
        </div>
        <div class="geo-text-block dark">
          <div class="geo-content">
            <span class="label">Ecology</span>
            <h2 class="geo-h">The Wildlife</h2>
            <p>{{ dest.ecology }}</p>
          </div>
        </div>
      </section>

      <!-- 5. HIGHLIGHTS, numbered list on dark bg -->
      <section class="highlights-section" v-reveal>
        <div class="hl-inner">
          <div class="hl-head">
            <span class="label label-light">Why Visit</span>
            <h2>What Defines<br><em>{{ dest.name }}</em></h2>
          </div>
          <div class="hl-grid">
            <div class="hl-item" v-for="(h, i) in dest.highlights" :key="i">
              <span class="hl-num">0{{ i + 1 }}</span>
              <div class="hl-body">
                <h3>{{ h.title }}</h3>
                <p>{{ h.desc }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- 6. SEASONS, strip -->
      <section class="seasons-section" v-reveal>
        <div class="seasons-inner">
          <span class="label">When to Go</span>
          <h2 class="seas-h">Seasons at <em>a Glance</em></h2>
          <div class="seasons-grid">
            <div class="season-block" v-for="(s, i) in dest.seasonal_data" :key="i">
              <span class="season-period">{{ s.period }}</span>
              <h3 class="season-title">{{ s.title }}</h3>
              <p class="season-desc">{{ s.desc }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- 7. CAMPS / ROUTES, dark strip -->
      <section class="camps-section" v-reveal>
        <div class="camps-inner">
          <span class="label label-light">Where to Stay</span>
          <h2>Recommended<br><em>Camps & Lodges</em></h2>
          <div class="camps-list">
            <div class="camp-item" v-for="(c, i) in dest.accommodation_details" :key="i">
              <span class="camp-num">0{{ i + 1 }}</span>
              <div class="camp-body">
                <h3>{{ c.name }}</h3>
                <div class="camp-meta">
                  <span>{{ c.region }}</span>
                  <span class="camp-dot" v-if="c.type">·</span>
                  <span v-if="c.type">{{ c.type }}</span>
                </div>
              </div>
              <div class="camp-rule"></div>
            </div>
          </div>
        </div>
      </section>

      <!-- 8. GALLERY -->
      <section class="gallery-section" v-reveal>
        <div class="gallery-inner">
          <div class="gallery-header">
            <span class="label">Gallery</span>
            <h2>Captured <em>Moments</em></h2>
            <div class="header-line"></div>
          </div>
          <div class="luxury-gallery">
            <div v-for="(img, idx) in dest.gallery" :key="idx" 
                 class="luxury-item" :class="'item-' + (idx % 7)">
              <div class="img-wrapper">
                <img :src="getImageUrl(img)" :alt="dest.name + ' gallery ' + (idx + 1)">
                <div class="img-overlay">
                  <span class="img-index">0{{ idx + 1 }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- 9. CTA -->
      <section class="cta-section" v-reveal>
        <div class="cta-copy">
          <span class="label label-light">Plan Your Visit</span>
          <h2>Ready to Visit<br><em>{{ dest.name }}?</em></h2>
          <p>Tell us when you want to travel and we will build a complete itinerary around this destination.</p>
          <div class="cta-actions">
            <router-link to="/contact" class="cta-btn-primary">Start Planning</router-link>
            <router-link to="/destinations" class="cta-btn-ghost">All Destinations</router-link>
          </div>
        </div>
      </section>

    </template>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import HandwrittenTypewriter from '../components/HandwrittenTypewriter.vue'
import { usePageImages } from '../composables/usePageImages'
import { useSettings, API_BASE_URL } from '../composables/useSettings'

const route = useRoute()
const dest = ref(null)
const loading = ref(true)

const { fetchImages, getImage } = usePageImages('destination_detail');
const { getImageUrl } = useSettings();

const fetchDestination = async () => {
  loading.value = true
  try {
    const slug = route.params.slug || route.params.id
    console.log('Fetching destination for slug:', slug)
    const response = await axios.get(`${API_BASE_URL}/api/destinations/${slug}`)
    dest.value = response.data
    console.log('Successfully fetched destination:', dest.value.name)
  } catch (error) {
    console.error('Error fetching destination:', error)
    dest.value = null
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchImages();
  fetchDestination();
})

watch(() => route.params.slug, fetchDestination)

const formatKey = (key) => {
  const map = { bestTime: 'Best Time', area: 'Area / Elevation', highlight: 'Signature Experience' }
  return map[key] || key
}

const introRef = ref(null), pb1Ref = ref(null), geoRef = ref(null)
// Manual refs removed in favor of v-reveal

</script>

<style scoped>
/* ━━━ BASE ━━━ */
.dest-page { background: var(--ivory); color: var(--text-dark); font-family:'Jost',sans-serif; overflow-x:hidden; }
em { font-style:italic; color: var(--gold); }
.label { display:block; font-size:0.7rem; letter-spacing:0.4em; text-transform:uppercase; color: var(--gold); margin-bottom:24px; font-weight:500; }
.label-light { color: rgba(255, 255, 255, 0.6); }

/* ━━━ NOT FOUND ━━━ */
.not-found { min-height:70vh; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:24px; }
.not-found h1 { font-family:'Playfair Display',serif; font-size:3rem; }
.not-found a { color: var(--gold); text-decoration:none; font-size:0.9rem; letter-spacing:0.2em; text-transform:uppercase; }

/* ━━━ HERO ━━━ */
/* HERO - Now using Global .premium-hero */
/* Quick facts bar below the title, above fold */
.hero-quick-facts { position:relative; z-index:2; display:flex; align-items:stretch; background:rgba(14,14,14,0.4); backdrop-filter:blur(8px); border-top:1px solid rgba(255, 255, 255, 0.1); margin-top: 40px; }
@keyframes fadeIn { from{opacity:0} to{opacity:1} }
.quick-fact { flex:1; padding:28px 40px; }
.qf-label { display:block; font-size:0.65rem; letter-spacing:0.3em; text-transform:uppercase; color: var(--gold); margin-bottom:8px; }
.qf-value { font-family:'Playfair Display',serif; font-size:1.3rem; color:#FFFFFF; font-weight:400; }
.qf-divider { width:1px; background:rgba(255, 255, 255, 0.1); }

/* ━━━ INTRO ━━━ */
.intro-section { padding:140px 8%; border-bottom:1px solid var(--ivory-dark); opacity:0; transform:translateY(40px); transition:opacity 1.4s ease,transform 1.4s cubic-bezier(0.16,1,0.3,1); }
.intro-section.visible { opacity:1; transform:translateY(0); }
.intro-inner { max-width:1300px; margin:0 auto; display:grid; grid-template-columns:1fr 340px; gap:100px; align-items:start; }
.intro-lead { font-family:'Playfair Display',serif; font-size:clamp(1.5rem,2.5vw,2rem); font-weight:400; line-height:1.5; color: var(--text-dark); margin-bottom:28px; }
.intro-body { font-size:1.1rem; line-height:1.9; color: var(--text-mid); font-weight:300; }
.intro-meta { border-left:2px solid var(--ivory-dark); padding-left:40px; display:flex; flex-direction:column; gap:0; }
.meta-block { padding:24px 0; border-bottom:1px solid var(--ivory-dark); }
.meta-block:last-child { border-bottom:none; }
.meta-label { display:block; font-size:0.65rem; letter-spacing:0.3em; text-transform:uppercase; color: var(--gold); margin-bottom:8px; font-weight:500; }
.meta-val { font-family:'Playfair Display',serif; font-size:1.15rem; color: var(--text-dark); }

/* ━━━ PHOTO BREAK ━━━ */
.photo-break { overflow:hidden; position:relative; opacity:0; transition:opacity 1.5s ease; }
.photo-break.visible { opacity:1; }
.photo-break img { width:100%; height:85vh; object-fit:cover; display:block; }
.photo-quote-overlay { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; background:rgba(14,14,14,0.5); padding:0 12%; text-align:center; }
.pq-text { font-family:'Playfair Display',serif; font-style:italic; font-size:clamp(1.6rem,3vw,2.8rem); color:#FFFFFF; line-height:1.5; max-width:900px; }

/* ━━━ GEO / ECOLOGY ━━━ */
.geo-section { opacity:0; transform:translateY(40px); transition:opacity 1.3s ease,transform 1.3s cubic-bezier(0.16,1,0.3,1); }
.geo-section.visible { opacity:1; transform:translateY(0); }
.geo-text-block { background: var(--ivory); padding:120px 8%; text-align:center; display:flex; justify-content:center; }
.geo-text-block.dark { background: var(--ivory-dark); }
.geo-content { max-width:800px; }
.geo-h { font-family:'Playfair Display',serif; font-size:clamp(2.5rem,4vw,4rem); font-weight:400; line-height:1.1; color: var(--text-dark); margin:0 0 28px; }
.geo-content p { font-size:1.1rem; line-height:1.9; color: var(--text-mid); font-weight:300; }

/* ━━━ HIGHLIGHTS, dark bg ━━━ */
.highlights-section { background:#1A1512; padding:160px 8%; opacity:0; transform:translateY(40px); transition:opacity 1.3s ease,transform 1.3s cubic-bezier(0.16,1,0.3,1); }
.highlights-section.visible { opacity:1; transform:translateY(0); }
.hl-inner { max-width:1300px; margin:0 auto; }
.hl-head { margin-bottom:80px; }
.hl-head h2 { font-family:'Playfair Display',serif; font-size:clamp(3rem,5vw,5rem); font-weight:400; line-height:1.05; color:#FFFFFF; margin:0; }
.hl-grid { display:grid; grid-template-columns:1fr 1fr; gap:2px; }
.hl-item { background:rgba(255,255,255,0.04); padding:60px 52px; display:grid; grid-template-columns:60px 1fr; gap:28px; align-items:start; transition:background 0.3s; }
.hl-item:hover { background:rgba(255,255,255,0.07); }
.hl-num { font-family:'Playfair Display',serif; font-size:2.5rem; color: var(--gold); font-weight:400; line-height:1; }
.hl-body h3 { font-family:'Playfair Display',serif; font-size:1.6rem; font-weight:400; color:#FFFFFF; margin:0 0 16px; line-height:1.2; }
.hl-body p { font-size:1rem; line-height:1.8; color:rgba(255, 255, 255, 0.5); font-weight:300; margin:0; }

/* ━━━ SEASONS ━━━ */
.seasons-section { padding:140px 8%; background: var(--ivory-dark); opacity:0; transform:translateY(40px); transition:opacity 1.3s ease,transform 1.3s cubic-bezier(0.16,1,0.3,1); }
.seasons-section.visible { opacity:1; transform:translateY(0); }
.seasons-inner { max-width:1300px; margin:0 auto; }
.seas-h { font-family:'Playfair Display',serif; font-size:clamp(2.5rem,4vw,4rem); font-weight:400; color: var(--text-dark); margin:0 0 72px; line-height:1.05; }
.seasons-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:2px; }
.season-block { background: var(--ivory); padding:52px 44px; border-left:3px solid var(--gold); }
.season-period { display:block; font-size:0.72rem; letter-spacing:0.3em; text-transform:uppercase; color: var(--gold); margin-bottom:16px; font-weight:600; }
.season-title { font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:400; color: var(--text-dark); margin:0 0 16px; }
.season-desc { font-size:0.98rem; line-height:1.8; color: var(--text-mid); font-weight:300; margin:0; }

/* ━━━ CAMPS, warm dark ━━━ */
.camps-section { background:#1A1512; padding:140px 8%; opacity:0; transform:translateY(40px); transition:opacity 1.3s ease,transform 1.3s cubic-bezier(0.16,1,0.3,1); }
.camps-section.visible { opacity:1; transform:translateY(0); }
.camps-inner { max-width:900px; margin:0 auto; }
.camps-inner h2 { font-family:'Playfair Display',serif; font-size:clamp(2.5rem,4vw,4rem); font-weight:400; color:#FFFFFF; margin:0 0 72px; line-height:1.05; }
.camps-list { display:flex; flex-direction:column; }
.camp-item { display:grid; grid-template-columns:60px 1fr; gap:28px; align-items:start; padding:32px 0; position:relative; }
.camp-rule { position:absolute; bottom:0; left:60px; right:0; height:1px; background:rgba(255, 255, 255, 0.08); }
.camp-num { font-family:'Playfair Display',serif; font-size:2rem; color: var(--gold); opacity:0.5; font-weight:400; line-height:1; }
.camp-body h3 { font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:400; color:#FFFFFF; margin:0 0 10px; }
.camp-meta { font-size:0.78rem; letter-spacing:0.1em; color:rgba(255, 255, 255, 0.4); display:flex; gap:8px; }
.camp-dot { color: var(--gold); opacity:0.5; }

/* ━━━ GALLERY ━━━ */
.gallery-section { padding:160px 8%; background: var(--ivory); }
.gallery-inner { max-width:1400px; margin:0 auto; }
.gallery-header { margin-bottom:80px; position:relative; }
.gallery-header h2 { font-family:'Playfair Display',serif; font-size:clamp(3rem,5vw,5.5rem); font-weight:400; color: var(--text-dark); margin:0; line-height:1; }
.header-line { width:80px; height:2px; background: var(--gold); margin-top:32px; }

.luxury-gallery { 
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-auto-rows: 200px;
  gap: 24px;
}

.luxury-item { position:relative; overflow:hidden; border-radius:4px; }
.img-wrapper { width:100%; height:100%; position:relative; overflow:hidden; cursor:pointer; }
.luxury-item img { width:100%; height:100%; object-fit:cover; transition:transform 1.2s cubic-bezier(0.16,1,0.3,1); }

.img-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.3);
  opacity: 0;
  transition: opacity 0.6s ease;
  display: flex;
  align-items: flex-end;
  padding: 30px;
}

.img-index {
  color: #fff;
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
  letter-spacing: 0.1em;
  transform: translateY(10px);
  transition: transform 0.6s cubic-bezier(0.16,1,0.3,1);
}

.luxury-item:hover img { transform: scale(1.1); }
.luxury-item:hover .img-overlay { opacity: 1; }
.luxury-item:hover .img-index { transform: translateY(0); }

/* Asymmetrical Grid Patterns */
.item-0 { grid-column: span 2; grid-row: span 3; }
.item-1 { grid-column: span 1; grid-row: span 2; }
.item-2 { grid-column: span 1; grid-row: span 2; }
.item-3 { grid-column: span 1; grid-row: span 2; }
.item-4 { grid-column: span 1; grid-row: span 1; }
.item-5 { grid-column: span 2; grid-row: span 2; }
.item-6 { grid-column: span 1; grid-row: span 2; }

@media(max-width:1024px) {
  .luxury-gallery { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 220px; }
  .item-0, .item-1, .item-2, .item-3, .item-4, .item-5, .item-6 { grid-column: span 1; grid-row: span 1; }
  .item-0, .item-5 { grid-column: span 2; }
}

@media(max-width:768px) {
  .luxury-gallery { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 180px; gap: 12px; }
  .item-0, .item-5 { grid-column: span 2; }
  .intro-section { padding: 80px 5%; }
  .geo-text-block { padding: 80px 5%; }
  .highlights-section { padding: 80px 5%; }
  .seasons-section { padding: 80px 5%; }
  .camps-section { padding: 80px 5%; }
  .gallery-section { padding: 80px 5%; }
  .cta-section { padding: 60px 5%; min-height: auto; }
  .hl-item { padding: 36px 28px; }
  .hl-head h2 { font-size: clamp(2rem, 6vw, 3.5rem); }
  .intro-lead { font-size: clamp(1.2rem, 3vw, 1.5rem); }
  .hero-quick-facts { flex-direction: column; }
  .qf-divider { width: auto; height: 1px; }
  .quick-fact { padding: 16px 24px; }
  .qf-value { font-size: 1.1rem; }
  .cta-copy h2 { font-size: clamp(2rem, 7vw, 3.5rem); }
  .cta-actions { flex-direction: column; gap: 12px; }

  /* CTA buttons full-width on mobile */
  .cta-btn-primary, .cta-btn-ghost { display: block; text-align: center; padding: 16px 36px; }
}

@media(max-width:640px) {
  .luxury-gallery { grid-auto-rows: 140px; gap: 8px; }
  .intro-section { padding: 60px 5%; }
  .geo-text-block { padding: 60px 5%; }
  .highlights-section { padding: 60px 5%; }
  .seasons-section { padding: 60px 5%; }
  .camps-section { padding: 60px 5%; }
  .gallery-section { padding: 60px 5%; }
  .hl-item { padding: 28px 20px; }
  .season-block { padding: 24px 20px; }
  .camp-item { padding: 20px 0; }
}

@media(max-width:480px) {
  .luxury-gallery { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 120px; gap: 6px; }
  .intro-section { padding: 40px 4%; }
  .geo-text-block { padding: 40px 4%; }
  .highlights-section { padding: 40px 4%; }
  .seasons-section { padding: 40px 4%; }
  .camps-section { padding: 40px 4%; }
  .gallery-section { padding: 40px 4%; }
  .hl-item { padding: 24px 16px; grid-template-columns: 36px 1fr; gap: 12px; }
  .hl-num { font-size: 1.5rem; }
  .hl-body h3 { font-size: 1.1rem; }
  .quick-fact { padding: 12px 20px; }
  .intro-lead { font-size: 1rem; }
  .cta-copy h2 { font-size: clamp(1.8rem, 6vw, 2.5rem); }
  .cta-btn-primary, .cta-btn-ghost { padding: 14px 24px; font-size: 0.75rem; }
}

@media(max-width:375px) {
  .luxury-gallery { grid-auto-rows: 100px; gap: 4px; }
  .quick-fact { padding: 10px 16px; }
  .qf-value { font-size: 1rem; }
  .hl-item { padding: 20px 14px; }
  .gallery-header h2 { font-size: clamp(1.4rem, 6vw, 2rem); }
}

/* ━━━ CTA ━━━ */
.cta-section { min-height:60vh; background:#1A1512; position:relative; display:flex; align-items:center; padding:100px 8%; opacity:0; transition:opacity 1.4s ease; border-top: 1px solid rgba(255, 255, 255, 0.05); }
.cta-section.visible { opacity:1; }
.cta-copy { position:relative; z-index:2; max-width:700px; }
.cta-copy h2 { font-family:'Playfair Display',serif; font-size:clamp(3rem,6vw,6rem); font-weight:400; color:#FFFFFF; line-height:1.0; margin:0 0 24px; }
.cta-copy p { font-size:1rem; line-height:1.8; color:rgba(255, 255, 255, 0.55); font-weight:300; margin-bottom:40px; max-width:500px; }
.cta-actions { display:flex; gap:16px; flex-wrap:wrap; }
.cta-btn-primary { display:inline-block; padding:18px 52px; background: var(--gold); color: var(--ivory); text-decoration:none; font-size:0.82rem; letter-spacing:0.2em; text-transform:uppercase; transition:background 0.3s; }
.cta-btn-primary:hover { background: var(--gold-light); }
.cta-btn-ghost { display:inline-block; padding:18px 40px; border:1px solid rgba(255, 255, 255, 0.3); color:rgba(255, 255, 255, 0.6); text-decoration:none; font-size:0.82rem; letter-spacing:0.2em; text-transform:uppercase; transition:border-color 0.3s,color 0.3s; }
.cta-btn-ghost:hover { border-color:#FFFFFF; color:#FFFFFF; }

/* ━━━ RESPONSIVE ━━━ */
@media(max-width:1200px) { .intro-inner{grid-template-columns:1fr;gap:60px;} .intro-meta{border-left:none;border-top:2px solid var(--ivory-dark);padding-left:0;padding-top:40px;flex-direction:row;flex-wrap:wrap;} .meta-block{flex:1;min-width:200px;} }
@media(max-width:1024px) { .split-row{grid-template-columns:1fr;} .split-flip .split-text,.split-flip .split-right-img{order:unset;} .split-right-img img{min-height:350px;height:55vw;} .split-text{padding:60px 5%;} .hl-grid{grid-template-columns:1fr;} .hero-quick-facts{flex-direction:column;} .qf-divider{width:auto;height:1px;} }
@media(max-width:768px) { .hero h1{font-size:clamp(2.8rem,8vw,3.5rem);} .intro-section,.highlights-section,.seasons-section,.camps-section{padding:80px 5%;} .hl-item{grid-template-columns:44px 1fr;gap:16px;padding:40px 28px;} .quick-fact{padding:20px 24px;} .seasons-grid{grid-template-columns:1fr;} .cta-section{padding:0 5% 10vh;} }
@media(max-width:480px) { .hero h1{font-size:2.5rem;} .cta-copy h2{font-size:2.5rem;} .cta-btn-primary,.cta-btn-ghost{display:block;text-align:center;padding:18px 20px;} .cta-actions{flex-direction:column;} .hl-head h2{font-size:2.5rem;} .seasons-section,.camps-section,.intro-section,.highlights-section{padding:64px 4%;} }
@media(max-width:375px) { .hero h1{font-size:2rem;} .split-text{padding:48px 4%;} }
</style>
