<template>
  <div class="safari-index" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">

    <!-- FULL-VIEWPORT HERO -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content" style="max-width: 860px; text-align: left; align-items: flex-start; justify-content: flex-end; padding-bottom: 8vh;">
        <span class="eyebrow">Our Experiences</span>
        <h1>Six Ways to<br>Meet <em>Tanzania</em></h1>
        <p class="hero-sub">Each experience is a different lens on the same extraordinary landscape, calibrated for a different intention, pace, and depth of encounter.</p>
      </div>
      <div class="hero-count">
        <span class="count-num">06</span>
        <span class="count-label">Distinct Experiences</span>
      </div>
    </section>

    <!-- INTRO STRIP -->
    <div class="intro-strip" ref="introRef">
      <p>Tanzania cannot be distilled into a single itinerary. Whether you want to summit Africa's highest peak, watch the great migration from a private balloon, or find yourself sharing a beach with only the Indian Ocean, we have the right experience for you.</p>
      <router-link to="/contact" class="intro-link">Talk to a specialist →</router-link>
    </div>

    <!-- EXPERIENCE GRID -->
    <section class="experiences" id="experiences" ref="gridRef">
      <div class="exp-grid">

        <!-- Card 01: Wide horizontal, photo left, content right -->
        <router-link :to="'/safari-types/' + categories[0].slug" class="exp-card exp-card--hero">
          <div class="exp-card-photo">
            <img :src="categories[0].image" :alt="categories[0].title" loading="lazy">
          </div>
          <div class="exp-card-body">
            <span class="exp-ghost-num">01</span>
            <div class="exp-body-inner">
              <span class="exp-kicker">Experience</span>
              <h2 class="exp-title">{{ categories[0].title }}</h2>
              <p class="exp-sub">{{ categories[0].sub }}</p>
              <div class="exp-cta">
                <span class="exp-line"></span>
                <span class="exp-arrow-text">Explore →</span>
              </div>
            </div>
          </div>
        </router-link>

        <!-- Cards 02–06: Standard stacked photo + info panel -->
        <router-link
          v-for="(cat, i) in categories.slice(1)"
          :key="cat.slug"
          :to="'/safari-types/' + cat.slug"
          class="exp-card exp-card--std"
        >
          <div class="exp-card-photo">
            <img :src="cat.image" :alt="cat.title" loading="lazy">
          </div>
          <div class="exp-card-panel">
            <span class="exp-ghost-num">0{{ i + 2 }}</span>
            <div class="exp-panel-inner">
              <span class="exp-kicker">Experience</span>
              <h2 class="exp-title">{{ cat.title }}</h2>
              <p class="exp-sub">{{ cat.sub }}</p>
              <div class="exp-cta">
                <span class="exp-line"></span>
                <span class="exp-arrow-text">Explore →</span>
              </div>
            </div>
          </div>
        </router-link>

      </div>
    </section>

    <!-- BOTTOM CTA -->
    <section class="bottom-cta" ref="ctaRef">
      <div class="cta-photo" :style="{ backgroundImage: `url(${getImage('cta_bg', '/image-18.jpg')})` }"></div>
      <div class="cta-veil"></div>
      <div class="cta-inner">
        <span class="label-light">Bespoke Experiences</span>
        <h2>Can't Decide?<br><em>We'll Design It For You.</em></h2>
        <p>Tell us your travel window, interests, and budget. We'll craft an itinerary that combines experiences into a single, seamless journey.</p>
        <router-link to="/contact" class="cta-btn">Start a Conversation</router-link>
      </div>
    </section>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { usePageImages } from '../composables/usePageImages'

const { images, fetchImages, getImage } = usePageImages('safari_category_index');

const introRef = ref(null)
const gridRef = ref(null)
const ctaRef = ref(null)

const categories = [
  { slug: 'mountain-hiking',      title: 'Mountain Trekking',        sub: 'Kilimanjaro · Lemosho · Machame · Meru',      image: '/image-18.jpg' },
  { slug: 'cultural-tours',       title: 'Cultural Tours',           sub: 'Maasai · Hadzabe · Swahili Coast',             image: '/image-10.jpg' },
  { slug: 'luxury-safari',        title: 'Luxury & Fly-In Safaris',  sub: 'Private lodges · Light aircraft · Butler service', image: '/image-11.jpg' },
  { slug: 'tailor-made-safari',   title: 'Tailor-Made Safaris',      sub: 'Your pace · Your itinerary · Built from scratch', image: '/image-16.jpg' },
  { slug: 'zanzibar-beach-safari',title: 'Zanzibar Beach Safari',    sub: 'Stone Town · Nungwi · Private Islands',         image: '/image-05.jpg' },
  { slug: 'group-safari',         title: 'Group Safaris',            sub: 'Max 6 · Shared cost · Fixed departures',       image: '/image-18.jpg' },
]

onMounted(() => {
  fetchImages();
  
  const io = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target) } })
  }, { threshold: 0.05 })
  ;[introRef, gridRef, ctaRef].forEach(r => r.value && io.observe(r.value))
})
</script>

<style scoped>
/* ━━━ BASE ━━━ */
.safari-index { background: var(--ivory); font-family:'Jost', sans-serif; overflow-x:hidden; }
em { font-style:italic; color: var(--gold); }
.label-light { display:block; font-size:0.7rem; letter-spacing:0.4em; text-transform:uppercase; color:rgba(255, 255, 255, 0.5); margin-bottom:24px; }

/* ━━━ HERO REMOVED (using global .premium-hero) ━━━ */
.hero-copy { position:relative; z-index:2; max-width:860px; }
.eyebrow {
  display: block;
  font-size: 0.72rem;
  letter-spacing: 0.4em;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.4);
  margin-bottom: 24px;
  animation: fadeUp 1.6s 0.3s cubic-bezier(0.16,1,0.3,1) both;
}
.hero h1 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(4rem, 8vw, 8.5rem);
  font-weight: 400;
  line-height: 0.95;
  color: #FFFFFF;
  margin: 0 0 32px;
  animation: fadeUp 1.6s 0.5s cubic-bezier(0.16,1,0.3,1) both;
}
.hero-sub {
  font-size: 1.1rem;
  line-height: 1.8;
  color: rgba(255, 255, 255, 0.55);
  font-weight: 300;
  max-width: 520px;
  animation: fadeUp 1.6s 0.7s cubic-bezier(0.16,1,0.3,1) both;
}
@keyframes fadeUp { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }

.hero-count {
  position: absolute;
  bottom: 12vh;
  right: 8%;
  z-index: 2;
  text-align: right;
  animation: fadeIn 2s 1.2s both;
}
@keyframes fadeIn { from{opacity:0} to{opacity:1} }
.count-num {
  display: block;
  font-family: 'Playfair Display', serif;
  font-size: 5rem;
  font-weight: 400;
  color: rgba(255, 255, 255, 0.1);
  line-height: 1;
}
.count-label {
  font-size: 0.68rem;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  color: var(--gold);
}

/* ━━━ INTRO STRIP ━━━ */
.intro-strip {
  background: var(--ivory-dark);
  padding: 72px 8%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 60px;
  border-top: 1px solid rgba(226,121,27,0.12);
  border-bottom: 1px solid rgba(226,121,27,0.12);
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 1.2s ease, transform 1.2s cubic-bezier(0.16,1,0.3,1);
}
.intro-strip.in { opacity:1; transform:translateY(0); }
.intro-strip p {
  font-size: 1.1rem;
  line-height: 1.9;
  color: var(--text-mid);
  font-weight: 300;
  max-width: 700px;
  margin: 0;
}
.intro-link {
  flex-shrink: 0;
  font-size: 0.82rem;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: var(--gold);
  text-decoration: none;
  border-bottom: 1px solid var(--gold);
  padding-bottom: 3px;
  white-space: nowrap;
  transition: opacity 0.3s;
}
.intro-link:hover { opacity:0.7; }

/* ━━━ EXPERIENCE GRID ━━━ */
.experiences {
  padding: 80px 5% 100px;
  opacity: 0;
  transform: translateY(40px);
  transition: opacity 1.3s ease, transform 1.3s cubic-bezier(0.16,1,0.3,1);
}
.experiences.in { opacity:1; transform:translateY(0); }

.exp-grid {
  max-width: 1400px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  grid-template-rows: auto auto;
  gap: 3px;
}

/* ── HERO CARD (spans all 5 cols, horizontal) ── */
.exp-card--hero {
  grid-column: 1 / -1;
  display: grid;
  grid-template-columns: 1.4fr 1fr;
  text-decoration: none;
  color: var(--text-dark);
  background: var(--ivory);
  min-height: 480px;
  overflow: hidden;
  position: relative;
}
.exp-card--hero .exp-card-photo {
  overflow: hidden;
  position: relative;
}
.exp-card--hero .exp-card-photo img {
  width: 100%; height: 100%;
  object-fit: cover; display: block;
  transition: transform 1.4s cubic-bezier(0.25,0.46,0.45,0.94);
}
.exp-card--hero:hover .exp-card-photo img { transform: scale(1.05); }

.exp-card-body {
  background: var(--ivory-dark);
  padding: 60px 56px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  position: relative;
  overflow: hidden;
  border-left: 3px solid transparent;
  transition: border-color 0.5s;
}
.exp-card--hero:hover .exp-card-body { border-left-color: var(--gold); }

/* ── STANDARD CARDS (cols 3 each across 5-col grid) ── */
/* 5 cards, place 2 across first row of remaining, then 3 across second */
.exp-card--std {
  display: flex;
  flex-direction: column;
  text-decoration: none;
  color: var(--text-dark);
  background: var(--ivory);
  overflow: hidden;
  position: relative;
}
.exp-card--std .exp-card-photo {
  overflow: hidden;
  flex: 0 0 auto;
}
.exp-card--std .exp-card-photo img {
  width: 100%;
  height: 280px;
  object-fit: cover;
  display: block;
  transition: transform 1.2s cubic-bezier(0.25,0.46,0.45,0.94);
}
.exp-card--std:hover .exp-card-photo img { transform: scale(1.06); }

.exp-card-panel {
  flex: 1;
  background: var(--ivory);
  border-top: 2px solid transparent;
  padding: 32px 32px 36px;
  position: relative;
  overflow: hidden;
  transition: border-top-color 0.4s;
}
.exp-card--std:nth-child(odd) .exp-card-panel { background: var(--ivory-dark); }
.exp-card--std:hover .exp-card-panel { border-top-color: var(--gold); }

/* ── SHARED: ghost number, inner layout ── */
.exp-ghost-num {
  position: absolute;
  top: 16px;
  right: 20px;
  font-family: 'Playfair Display', serif;
  font-size: 6rem;
  font-weight: 400;
  color: rgba(226,121,27,0.07);
  line-height: 1;
  pointer-events: none;
  user-select: none;
}
.exp-card--hero .exp-ghost-num { font-size: 10rem; top: 20px; right: 28px; }

.exp-body-inner, .exp-panel-inner {
  position: relative;
  z-index: 1;
}

.exp-kicker {
  display: block;
  font-size: 0.65rem;
  letter-spacing: 0.35em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 16px;
  font-weight: 500;
}

.exp-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(1.4rem, 1.8vw, 2rem);
  font-weight: 400;
  line-height: 1.15;
  margin: 0 0 10px;
  color: var(--text-dark);
  transition: color 0.3s;
}
.exp-card--hero .exp-title { font-size: clamp(2rem, 3vw, 3rem); }
.exp-card:hover .exp-title { color: var(--rust); }

.exp-sub {
  font-size: 0.82rem;
  letter-spacing: 0.05em;
  color: var(--dust);
  margin: 0 0 28px;
  font-weight: 300;
  line-height: 1.6;
}

/* CTA row: animated gold line + arrow */
.exp-cta {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-top: auto;
}
.exp-line {
  display: block;
  width: 0;
  height: 1px;
  background: var(--gold);
  transition: width 0.5s cubic-bezier(0.16,1,0.3,1);
  flex-shrink: 0;
}
.exp-card:hover .exp-line { width: 36px; }
.exp-arrow-text {
  font-size: 0.75rem;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: var(--gold);
  opacity: 0;
  transform: translateX(-10px);
  transition: opacity 0.4s 0.1s, transform 0.4s 0.1s;
}
.exp-card:hover .exp-arrow-text { opacity:1; transform:translateX(0); }

/* ━━━ BOTTOM CTA ━━━ */
.bottom-cta {
  height: 80vh;
  min-height: 560px;
  position: relative;
  display: flex;
  align-items: center;
  padding: 0 8%;
  opacity: 0;
  transition: opacity 1.4s ease;
}
.bottom-cta.in { opacity:1; }
.cta-photo { position:absolute; inset:0; background-size:cover; background-position:center; }
.cta-veil { position:absolute; inset:0; background:rgba(14,14,14,0.65); }
.cta-inner { position:relative; z-index:2; max-width:620px; }
.cta-inner h2 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 5vw, 5rem);
  font-weight: 400;
  color: #FFFFFF;
  line-height: 1.05;
  margin: 0 0 24px;
}
.cta-inner p {
  font-size: 1rem;
  line-height: 1.8;
  color: rgba(255, 255, 255, 0.55);
  font-weight: 300;
  margin-bottom: 40px;
  max-width: 480px;
}
.cta-btn {
  display: inline-block;
  padding: 18px 52px;
  border: 1px solid var(--gold);
  color: var(--gold);
  text-decoration: none;
  font-size: 0.82rem;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  transition: background 0.4s, color 0.4s;
}
.cta-btn:hover { background: var(--gold); color: var(--ivory); }

/* ━━━ RESPONSIVE ━━━ */
@media(max-width:1200px) {
  .exp-grid { grid-template-columns: repeat(3,1fr); }
  .exp-card--hero { grid-template-columns: 1fr 1fr; min-height:400px; }
  .exp-card--std .exp-card-photo img { height:220px; }
  .intro-strip { flex-direction:column; gap:28px; align-items:flex-start; }
}
@media(max-width:1024px) {
  .hero { padding:0 5% 12vh; }
  .hero h1 { font-size: clamp(2.5rem, 8vw, 4.5rem); }
  .hero p { font-size: 1rem; max-width: 100%; }
  .exp-grid { grid-template-columns: repeat(2,1fr); gap: 20px; }
  .exp-card--hero { grid-column: span 2; }
}
@media(max-width:768px) {
  .hero h1 { font-size: clamp(2rem, 10vw, 3.5rem); }
  .hero { padding:0 5% 10vh; }
  .hero p { font-size: 0.95rem; }
  .experiences { padding:60px 4% 80px; }
  .exp-grid { grid-template-columns:1fr; gap: 16px; }
  .exp-card--hero { grid-column: auto; grid-template-columns:1fr; min-height:auto; }
  .exp-card--hero .exp-card-photo { height: 240px; overflow:hidden; }
  .exp-card--hero .exp-card-photo img { width:100%; height:100%; }
  .exp-card-body { padding:28px 24px; }
  .exp-card--std .exp-card-photo img { height:200px; }
  .exp-card--std .exp-card-body { padding:24px 20px; }
  .card-category { font-size: 0.7rem; letter-spacing: 0.15em; }
  .card-title { font-size: 1.3rem; }
  .card-desc { font-size: 0.95rem; }
  .intro-strip { gap: 20px; }
  .strip-title { font-size: 1.5rem; }
  .strip-desc { font-size: 0.95rem; }
}
@media(max-width:640px) {
  .hero h1 { font-size: 2.5rem; }
  .hero p { font-size: 0.9rem; }
  .experiences { padding: 40px 4% 60px; }
  .exp-card--hero .exp-card-photo { height: 200px; }
  .exp-card--std .exp-card-photo img { height: 180px; }
  .card-title { font-size: 1.1rem; }
  .card-desc { font-size: 0.9rem; }
  .cta-btn { padding: 14px 28px; font-size: 0.75rem; }
}
@media(max-width:480px) {
  .hero { padding: 0 4% 8vh; }
  .hero h1 { font-size: 2rem; }
  .hero p { font-size: 0.85rem; }
  .experiences { padding: 32px 4% 48px; }
  .exp-card-body { padding: 20px 16px; }
  .card-title { font-size: 1rem; }
  .strip-title { font-size: 1.2rem; }
}
@media(max-width:375px) {
  .hero h1 { font-size: 1.6rem; }
  .experiences { padding: 24px 4% 40px; }
  .card-category { font-size: 0.65rem; }
}
</style>
