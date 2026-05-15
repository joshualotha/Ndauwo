<template>
  <div class="page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">

    <!-- 1. FULL-VIEWPORT HERO (photo stays dark for legibility) -->
    <!-- Premium Hero Section -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label">✦ Above the Clouds</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Mountain ', class: 'white' },
            { text: 'Tours', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="hero-subtitle">
          From the crater of Kilimanjaro to the peaks of Meru. High-altitude expeditions refined.
        </p>
      </div>
    </section>

    <!-- 2. STATEMENT, light bg -->
    <section class="statement" id="intro" ref="s1">
      <div class="statement-inner">
        <span class="label">The Climb</span>
        <h2>Why Climb With<br>Ndauwo Safaris?</h2>
        <p>We invest in the best equipment, ongoing guide training, and the ethical treatment of every porter. We approach Kilimanjaro as a high-altitude expedition, not a walking holiday.</p>
      </div>
    </section>

    <!-- 3. FULL-BLEED PHOTO -->
    <div class="photo-break" ref="pb1">
      <img :src="getImage('photo_break_1', '/image-18.jpg')" alt="Above the clouds">
      <span class="photo-caption">Above the clouds · Kilimanjaro National Park</span>
    </div>

    <!-- 4. ROUTES: Feature rows, warm sections -->
    <section class="features" ref="s2">
      <div class="features-top">
        <span class="label">Popular Routes</span>
        <h2>Choose Your<br>Ascent</h2>
      </div>
      <div class="feature-row" v-for="(r, i) in routes" :key="i" :ref="el => rowRefs[i] = el">
        <div class="feature-photo"><img :src="r.image" :alt="r.name"></div>
        <div class="feature-copy">
          <span class="feature-num">0{{ i + 1 }}</span>
          <h3>{{ r.name }}</h3>
          <p>{{ r.desc }}</p>
          <div class="feature-meta">
            <span>{{ r.days }}</span>
            <span>·</span>
            <span>{{ r.difficulty }}</span>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. PHOTO WITH QUOTE OVERLAY -->
    <div class="photo-break tall" ref="pb2">
      <img :src="getImage('photo_break_2', '/image-01.jpg')" alt="Summit approach">
      <div class="photo-overlay-text">
        <span>"The summit changes you. Everything below suddenly looks small."</span>
      </div>
    </div>

    <!-- 6. STATS STRIP, gold -->
    <div class="stats-strip" ref="ss">
      <div class="stats-strip-inner">
        <div class="stat-block"><span class="stat-n">95%</span><span class="stat-l">Summit Success Rate</span></div>
        <div class="stat-div"></div>
        <div class="stat-block"><span class="stat-n">8–9</span><span class="stat-l">Day Itineraries (recommended)</span></div>
        <div class="stat-div"></div>
        <div class="stat-block"><span class="stat-n">6</span><span class="stat-l">Max Group Size</span></div>
        <div class="stat-div"></div>
        <div class="stat-block"><span class="stat-n">5,895m</span><span class="stat-l">Uhuru Peak Elevation</span></div>
      </div>
    </div>

    <!-- 7. CTA, photo with dark overlay -->
    <section class="cta-section" ref="cta">
      <div class="cta-photo" :style="{ backgroundImage: `url(${getImage('cta_bg', '/image-10.jpg')})` }"></div>
      <div class="cta-veil"></div>
      <div class="cta-copy">
        <span class="label">Start Planning</span>
        <h2>Begin Your<br>Ascent</h2>
        <router-link to="/contact" class="cta-btn">Enquire Now</router-link>
      </div>
    </section>

  </div>
</template>

<script setup>
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { ref, onMounted } from 'vue'
import { usePageImages } from '../../composables/usePageImages'

const { images, fetchImages, getImage } = usePageImages('mountain_hiking');

const s1 = ref(null), pb1 = ref(null), s2 = ref(null), pb2 = ref(null), ss = ref(null), cta = ref(null)
const rowRefs = ref([])
const routes = [
  { name: 'Machame Route', desc: 'The "Whiskey Route", challenging and scenic. Superb acclimatisation profile with a climb-high, sleep-low rhythm that maximises summit success.', days: '7–8 Days', difficulty: 'Challenging', image: '/image-08.jpg' },
  { name: 'Lemosho Route', desc: 'The most beautiful approach. Starts on the quiet western slopes, crosses the Shira Plateau, and joins Machame. Less crowded, breathtaking scenery.', days: '8–9 Days', difficulty: 'Moderate–Challenging', image: '/image-19.jpg' },
  { name: 'Mount Meru', desc: 'At 4,562m, often overlooked. A stunning 3–4 day trek with direct views of Kilimanjaro, the ideal acclimatisation run before the main event.', days: '3–4 Days', difficulty: 'Accessible', image: '/image-10.jpg' },
]
onMounted(() => {
  fetchImages();
  
  const io = new IntersectionObserver(entries => { entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target) } }) }, { threshold: 0.08 })
  ;[s1, pb1, s2, pb2, ss, cta].forEach(r => r.value && io.observe(r.value))
  rowRefs.value.forEach(el => el && io.observe(el))
})
</script>

<style scoped>
/* ═══ BASE ═══ */
.page { background: var(--ivory); color: var(--text-dark); font-family:'Jost',sans-serif; overflow-x:hidden; }
em { font-style:italic; color: var(--gold); }
.label { display:block; font-size:0.7rem; letter-spacing:0.4em; text-transform:uppercase; color: var(--gold); margin-bottom:24px; font-weight:500; }

/* ═══ HERO, photo stays with dark overlay for legibility ═══ */
/* HERO - Now using Global .premium-hero */
@keyframes fadeUp { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }

/* ═══ STATEMENT, light ═══ */
.statement { background: var(--ivory); padding:160px 8%; border-bottom:1px solid var(--ivory-dark); opacity:0; transform:translateY(40px); transition:opacity 1.4s ease, transform 1.4s cubic-bezier(0.16,1,0.3,1); }
.statement.in { opacity:1; transform:translateY(0); }
.statement-inner { max-width:1100px; margin:0 auto; }
.statement h2 { font-family:'Playfair Display',serif; font-size:clamp(3rem,6vw,6rem); font-weight:400; line-height:1.05; margin:0 0 48px; color: var(--text-dark); }
.statement p { font-size:1.2rem; line-height:1.9; color: var(--text-mid); font-weight:300; max-width:650px; }

/* ═══ PHOTO BREAK ═══ */
.photo-break { width:100%; overflow:hidden; position:relative; opacity:0; transition:opacity 1.5s ease; }
.photo-break.in { opacity:1; }
.photo-break img { width:100%; height:80vh; object-fit:cover; object-position:center; display:block; }
.photo-break.tall img { height:90vh; }
.photo-caption { position:absolute; bottom:24px; right:32px; font-size:0.68rem; letter-spacing:0.15em; text-transform:uppercase; color:rgba(255, 255, 255, 0.5); }
.photo-overlay-text { position:absolute; bottom:60px; left:8%; right:30%; }
.photo-overlay-text span { font-family:'Playfair Display',serif; font-style:italic; font-size:clamp(1.5rem,3vw,2.5rem); color:#FFFFFF; line-height:1.4; text-shadow:0 2px 20px rgba(0,0,0,0.4); }

/* ═══ FEATURES, alternating ivory / ivory-dark ═══ */
.features { background: var(--ivory); padding:160px 8%; }
.features-top { margin-bottom:100px; }
.features-top h2 { font-family:'Playfair Display',serif; font-size:clamp(3rem,5vw,5rem); font-weight:400; line-height:1.05; color: var(--text-dark); margin:0; }
.feature-row { display:grid; grid-template-columns:1fr 1fr; gap:0; margin-bottom:2px; opacity:0; transform:translateY(50px); transition:opacity 1.2s ease, transform 1.2s cubic-bezier(0.16,1,0.3,1); }
.feature-row.in { opacity:1; transform:translateY(0); }
.feature-row:nth-child(even) .feature-photo { order:2; }
.feature-row:nth-child(even) .feature-copy { order:1; }
.feature-photo { overflow:hidden; }
.feature-photo img { width:100%; height:100%; min-height:480px; object-fit:cover; display:block; transition:transform 1.2s ease; }
.feature-row:hover .feature-photo img { transform:scale(1.04); }
.feature-copy { background: var(--ivory-dark); padding:80px 60px; display:flex; flex-direction:column; justify-content:center; }
.feature-row:nth-child(odd) .feature-copy { background: var(--ivory); }
.feature-num { font-size:0.65rem; letter-spacing:0.3em; color: var(--gold); font-weight:600; margin-bottom:20px; }
.feature-copy h3 { font-family:'Playfair Display',serif; font-size:clamp(2rem,3vw,3rem); font-weight:400; color: var(--text-dark); margin:0 0 24px; line-height:1.15; }
.feature-copy p { font-size:1.05rem; line-height:1.9; color: var(--text-mid); font-weight:300; margin-bottom:28px; }
.feature-meta { font-size:0.78rem; letter-spacing:0.12em; color: var(--gold); display:flex; gap:10px; }

/* ═══ STATS STRIP, gold bg (same, keeps contrast)  ═══ */
.stats-strip { background: var(--gold); opacity:0; transition:opacity 1.2s ease; }
.stats-strip.in { opacity:1; }
.stats-strip-inner { display:flex; align-items:stretch; }
.stat-block { flex:1; padding:60px 48px; }
.stat-n { display:block; font-family:'Playfair Display',serif; font-size:3.5rem; font-weight:400; color: var(--ivory); line-height:1; margin-bottom:8px; }
.stat-l { font-size:0.75rem; letter-spacing:0.12em; text-transform:uppercase; color:rgba(255, 255, 255, 0.7); font-weight:500; }
.stat-div { width:1px; background:rgba(255, 255, 255, 0.2); }

/* ═══ CTA, photo overlay (dark stays for legibility) ═══ */
.cta-section { height:90vh; min-height:600px; position:relative; display:flex; align-items:center; justify-content:flex-start; padding:0 8%; opacity:0; transition:opacity 1.4s ease; }
.cta-section.in { opacity:1; }
.cta-photo { position:absolute; inset:0; background-size:cover; background-position:center; }
.cta-veil { position:absolute; inset:0; background:rgba(14,14,14,0.6); }
.cta-copy { position:relative; z-index:2; }
.cta-copy h2 { font-family:'Playfair Display',serif; font-size:clamp(3rem,6vw,6rem); font-weight:400; color:#FFFFFF; line-height:1.05; margin:0 0 48px; }
.cta-btn { display:inline-block; padding:18px 52px; border:1px solid var(--gold); color: var(--gold); text-decoration:none; font-size:0.82rem; letter-spacing:0.2em; text-transform:uppercase; transition:background 0.4s, color 0.4s; }
.cta-btn:hover { background: var(--gold); color: var(--ivory); }

@media(max-width:1024px) { .feature-row{grid-template-columns:1fr;} .feature-row:nth-child(even) .feature-photo,.feature-row:nth-child(even) .feature-copy{order:unset;} .stats-strip-inner{flex-direction:column;} .stat-div{width:auto;height:1px;} .feature-photo img{min-height:300px;} }
@media(max-width:768px) { .hero{padding:0 5% 12vh;} .hero h1{font-size:clamp(2.8rem,8vw,3.5rem);} .statement,.features{padding:80px 5%;} .feature-copy{padding:48px 32px;} .stat-block{padding:44px 32px;} }
@media(max-width:480px) { .hero h1{font-size:2.5rem;} .hero-lead{font-size:0.95rem;} .statement h2{font-size:2.2rem;} .cta-copy h2{font-size:2.5rem;} .cta-btn{display:block;text-align:center;padding:18px 20px;} .photo-overlay-text{left:5%;right:5%;} .photo-overlay-text span{font-size:1.4rem;} }
@media(max-width:375px) { .hero h1{font-size:2rem;} .statement,.features{padding:60px 4%;} }
</style>
