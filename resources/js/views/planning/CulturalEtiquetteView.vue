<template>
  <div class="planning-view cultural-etiquette">
    <!-- LUJO: Cinematic Heritage Hero -->
    <section class="editorial-hero">
      <div class="hero-image-wrap" :style="images.hero_bg ? { backgroundImage: `url(${images.hero_bg})` } : {}"></div>
      <div class="hero-vignette"></div>
      <div class="hero-content">
        <span class="eyebrow" v-reveal>✦ Heritage & Harmony</span>
        <h1 class="headline">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Cultural ', class: 'white' },
            { text: 'Etiquette', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="summary" v-reveal>Navigating the rich tapestry of Tanzanian culture with grace, deep respect, and understanding.</p>
      </div>
    </section>

    <!-- THE SOUL OF SAFARI -->
    <section class="editorial-spread" v-reveal>
      <div class="spread-inner">
        <div class="visual-chapter">
          <img :src="getImage('spread_img', 'https://images.unsplash.com/photo-1489440543286-a69330151c0b?w=1200&q=80')" alt="Maasai Heritage" class="spread-img" />
          <div class="img-caption"><em>The spirit of togetherness.</em> Embracing the local philosophy of Ubuntu.</div>
        </div>
        <div class="narrative-chapter">
          <span class="label-gold">The Philosophy</span>
          <h2>The Spirit of <em>Ubuntu</em></h2>
          <p>In Tanzania, we believe in "Ubuntu"—the idea that "I am because we are." Your journey through this land is more than a spectacle of wildlife; it is a shared experience with the people who call it home. We invite you to move through these landscapes with a spirit of humility and open-heartedness.</p>
          <div class="ethos-stats">
            <div class="e-stat">
              <strong>120+</strong>
              <span>Ethnic Tribes</span>
            </div>
            <div class="e-stat">
              <strong>Swahili</strong>
              <span>The Language of Peace</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CHAPTER I: THE HUMAN LANDSCAPE -->
    <section class="chapter-spread alt" v-reveal>
      <div class="chapter-content">
        <span class="chapter-num">Chapter I</span>
        <h2 class="chapter-title">The Human <em>Landscape</em></h2>
        <p>The Tanzanian people are defined by their warmth and a deep sense of communal respect. When visiting local communities—be it a Maasai Boma or an artisan market—approaching with humility ensures a meaningful connection.</p>
        <div class="detail-grid">
          <div class="detail-i">
            <h4>Photography Ethics</h4>
            <p>Always seek verbal permission before capturing portraits. A simple request reflects deep respect for ownership of identity.</p>
          </div>
          <div class="detail-i">
            <h4>Sustainable Giving</h4>
            <p>We discourage giving money or sweets to children. Instead, consider donating books or supplies to local schools through your guide.</p>
          </div>
        </div>
      </div>
      <div class="chapter-visual">
        <img :src="getImage('chapter_img_1', 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=1000&q=80')" alt="Local Community" class="chapter-img" />
      </div>
    </section>

    <!-- CHAPTER II: COASTAL GRACE -->
    <section class="chapter-cinematic" v-reveal>
      <div class="cinematic-bg" :style="{ backgroundImage: `url(${getImage('cinematic_bg', 'https://images.unsplash.com/photo-1502476659129-ca01d9f8045a?w=1400&q=80')})` }"></div>
      <div class="cinematic-overlay"></div>
      <div class="cinematic-content">
        <span class="chapter-num">Chapter II</span>
        <h2 class="chapter-title">Coastal <em>Grace</em></h2>
        <p>The Swahili Coast and Zanzibar are steeped in Islamic heritage. Modesty in dress and behavior is a mark of high culture and respect for local tradition.</p>
        <div class="optics-features">
          <div class="o-feat">
            <div class="icon-ring"><Shirt class="icon" /></div>
            <h4>Conservative Dress</h4>
            <p>Knees and shoulders should be covered when exploring Stone Town or local villages.</p>
          </div>
          <div class="o-feat">
            <div class="icon-ring"><BookOpen class="icon" /></div>
            <h4>Ramadan</h4>
            <p>During the holy month, please avoid eating or drinking in public during daylight hours.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CHAPTER III: THE LEXICON -->
    <section class="chapter-spread" v-reveal>
      <div class="chapter-visual">
        <img :src="getImage('chapter_img_2', 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1000&q=80')" alt="Safari Scene" class="chapter-img" />
      </div>
      <div class="chapter-content">
        <span class="chapter-num">Chapter III</span>
        <h2 class="chapter-title">The Swahili <em>Lexicon</em></h2>
        <p>While English is widely spoken, a command of basic Swahili phrases is seen as a sign of sincere effort and respect for the host culture.</p>
        <div class="lexicon-grid">
          <div class="lex-item">
            <span class="sw">Hujambo</span>
            <span class="en">How are you?</span>
          </div>
          <div class="lex-item">
            <span class="sw">Asante Sana</span>
            <span class="en">Thank you very much</span>
          </div>
          <div class="lex-item">
            <span class="sw">Karibu</span>
            <span class="en">Welcome</span>
          </div>
          <div class="lex-item">
            <span class="sw">Lala Salama</span>
            <span class="en">Sleep well</span>
          </div>
        </div>
      </div>
    </section>

    <!-- APPRECIATION ADVISORY -->
    <section class="etiquette-advisory" v-reveal>
      <div class="advisory-inner">
        <span class="label-gold">Gratefulness</span>
        <h2>The Art of <em>Appreciation</em></h2>
        <p>Tipping is a customary way to acknowledge the exceptional care provided by your safari team. These guidelines reflect the standard for high-end expeditions.</p>
        <div class="etiquette-grid">
          <div class="e-card">
            <h4>The Safari Guide</h4>
            <p>$20 - $30 per guest, per day. Usually presented at the conclusion of your journey.</p>
          </div>
          <div class="e-card">
            <h4>The Camp Team</h4>
            <p>$15 - $20 per guest, per day. Most camps utilize a communal tip box for shared distribution.</p>
          </div>
          <div class="e-card">
            <h4>Specialist Trackers</h4>
            <p>$10 - $15 per group, per day, for dedicated tracking or fly-camping personnel.</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { Shirt, BookOpen, Binoculars, Camera, Backpack, Scale, Zap, Coins, ShieldAlert } from 'lucide-vue-next'
import { usePageImages } from '../../composables/usePageImages'
import { onMounted } from 'vue'

const { images, fetchImages, getImage } = usePageImages('cultural_etiquette');

onMounted(() => {
  fetchImages();
});
</script>

<style scoped>
.planning-view {
  background: white;
  min-height: 100vh;
}

/* EDITORIAL HERO */
.editorial-hero {
  height: 90vh;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  overflow: hidden;
}

.hero-image-wrap {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
  transform: scale(1.05);
}

.hero-vignette {
  position: absolute;
  inset: 0;
  background: radial-gradient(circle, transparent 20%, rgba(0,0,0,0.6) 100%),
              linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8));
}

.hero-content {
  position: relative;
  z-index: 2;
  max-width: 800px;
  padding: 0 40px;
}

.eyebrow {
  display: block;
  font-size: 0.8rem;
  letter-spacing: 0.5em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 30px;
}

.headline {
  font-family: 'Playfair Display', serif;
  font-size: clamp(3rem, 8vw, 6rem);
  line-height: 1;
  margin-bottom: 40px;
}

.summary {
  font-size: 1.2rem;
  color: rgba(255,255,255,0.7);
  max-width: 600px;
  margin: 0 auto;
  font-weight: 300;
  line-height: 1.6;
}

/* EDITORIAL SPREAD */
.editorial-spread {
  padding: 140px 10%;
}

.spread-inner {
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 100px;
  align-items: center;
  max-width: 1400px;
  margin: 0 auto;
}

.spread-img {
  width: 100%;
  height: 700px;
  object-fit: cover;
  filter: sepia(0.2) contrast(1.1);
}

.img-caption {
  font-size: 0.85rem;
  color: var(--text-mid);
  margin-top: 20px;
  font-style: italic;
  font-family: 'Playfair Display', serif;
}

.narrative-chapter {
  padding-left: 40px;
}

.label-gold {
  display: block;
  font-size: 0.75rem;
  letter-spacing: 0.4em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 30px;
}

.narrative-chapter h2 {
  font-family: 'Playfair Display', serif;
  font-size: 3.5rem;
  line-height: 1.1;
  margin-bottom: 40px;
  color: var(--ebony);
}

.narrative-chapter h2 em {
  font-style: italic;
  font-weight: 400;
  color: var(--gold);
}

.narrative-chapter p {
  font-size: 1.2rem;
  line-height: 1.9;
  color: var(--text-mid);
  font-weight: 300;
  margin-bottom: 60px;
}

.ethos-stats {
  display: flex;
  gap: 80px;
}

.e-stat {
  display: flex;
  flex-direction: column;
}

.e-stat strong {
  font-family: 'Playfair Display', serif;
  font-size: 2.5rem;
  color: var(--ebony);
  margin-bottom: 10px;
}

.e-stat span {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.2em;
  color: var(--gold);
}

/* CHAPTER SPREADS */
.chapter-spread {
  padding: 100px 10%;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 100px;
  align-items: center;
}

.chapter-spread.alt {
  background: var(--ivory);
}

.chapter-num {
  font-family: 'Playfair Display', serif;
  font-size: 0.9rem;
  font-style: italic;
  color: var(--gold);
  margin-bottom: 20px;
  display: block;
}

.chapter-title {
  font-family: 'Playfair Display', serif;
  font-size: 3.5rem;
  margin-bottom: 30px;
  color: var(--ebony);
}

.chapter-title em {
  font-style: italic;
  font-weight: 400;
  color: var(--gold);
}

.chapter-content p {
  font-size: 1.1rem;
  line-height: 1.8;
  color: var(--text-mid);
  margin-bottom: 50px;
  font-weight: 300;
}

.detail-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
}

.detail-i h4 {
  font-family: 'Playfair Display', serif;
  font-size: 1.3rem;
  margin-bottom: 15px;
  border-bottom: 1px solid var(--gold);
  padding-bottom: 10px;
}

.detail-i p { font-size: 0.95rem; line-height: 1.6; }

.chapter-img {
  width: 100%;
  height: 600px;
  object-fit: cover;
}

/* CINEMATIC CHAPTER */
.chapter-cinematic {
  height: 80vh;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  text-align: center;
}

.cinematic-bg {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
}

.cinematic-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.6);
}

.cinematic-content {
  position: relative;
  z-index: 2;
  max-width: 900px;
}

.optics-features {
  display: flex;
  justify-content: center;
  gap: 100px;
  margin-top: 60px;
}

.o-feat {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}

.icon-ring {
  width: 80px;
  height: 80px;
  border: 1px solid var(--gold);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.icon-ring .icon {
  width: 30px;
  height: 30px;
  color: var(--gold);
}

.o-feat h4 {
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
}

.o-feat p {
  font-size: 0.9rem;
  color: rgba(255,255,255,0.6);
  max-width: 250px;
}

/* LEXICON GRID */
.lexicon-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 30px;
}

.lex-item {
  display: flex;
  flex-direction: column;
  padding: 20px 0;
  border-bottom: 1px solid rgba(0,0,0,0.1);
}

.sw {
  font-family: 'Playfair Display', serif;
  font-size: 1.4rem;
  color: var(--gold);
  font-style: italic;
  margin-bottom: 5px;
}

.en {
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--text-mid);
}

/* ETIQUETTE ADVISORY */
.etiquette-advisory {
  padding: 140px 10%;
  background: var(--ebony);
  color: white;
}

.advisory-inner {
  max-width: 1200px;
  margin: 0 auto;
  text-align: center;
}

.advisory-inner h2 {
  font-family: 'Playfair Display', serif;
  font-size: 3.5rem;
  margin-bottom: 30px;
}

.advisory-inner h2 em { font-style: italic; color: var(--gold); font-weight: 400; }

.advisory-inner p {
  color: rgba(255,255,255,0.6);
  font-size: 1.2rem;
  max-width: 700px;
  margin: 0 auto 80px;
  font-weight: 300;
}

.etiquette-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 40px;
}

.e-card {
  padding: 40px;
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.1);
  text-align: left;
}

.e-card h4 {
  font-family: 'Playfair Display', serif;
  font-size: 1.3rem;
  margin-bottom: 20px;
  color: var(--gold);
}

.e-card p {
  font-size: 0.95rem;
  color: rgba(255,255,255,0.5);
  line-height: 1.7;
  margin: 0;
}

@media (max-width: 1024px) {
  .spread-inner { grid-template-columns: 1fr; gap: 60px; }
  .chapter-spread { grid-template-columns: 1fr; gap: 60px; }
  .chapter-visual { order: -1; }
  .optics-features { gap: 40px; flex-direction: column; }
  .etiquette-grid { grid-template-columns: 1fr; }
  .narrative-chapter { padding-left: 0; }
  .spread-img { height: 400px; }
  .chapter-img { height: 400px; }
  .lexicon-grid { grid-template-columns: 1fr; }
}
</style>
