<template>
  <div class="editorial-conservation" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    
    <!-- Premium Hero Section -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      
      <div class="premium-hero-content">
        <span class="hero-label" v-reveal>✦ A Legacy of Protection</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Preserving the ', class: 'white' },
            { text: 'Sanctuary', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="hero-subtitle" v-reveal>
          Conservation is not a department at Ndauwo; it is our foundation. Explore our commitment to the land, the wildlife, and the communities of Tanzania.
        </p>
      </div>
    </section>

    <!-- 2. The Mission Statement -->
    <section class="editorial-mission">
      <div class="mission-inner" v-reveal>
        <span class="section-label">01. Our Mission</span>
        <h2 class="mission-statement">
          Ndauwo Safari Co. is irrevocably tied to the survival of the East African ecosystem. True luxury cannot be extracted from a dying landscape; it must participate in its protection. We do not just operate within these habitats—we actively fund, engineer, and enforce their preservation.
        </h2>
      </div>
    </section>

    <!-- 3. Impact by Numbers (Structured Data) -->
    <section class="editorial-impact">
      <div class="impact-inner">
        <div class="impact-header" v-reveal>
          <span class="section-label">02. Data Integration</span>
          <h2 class="section-title">Measurable <em>Returns</em></h2>
        </div>
        
        <div class="impact-grid">
          <div class="impact-stat" v-reveal>
            <div class="stat-val">100<span class="percent">%</span></div>
            <h3 class="stat-title">Solar Dominance</h3>
            <p class="stat-desc">Complete eradication of generators across our mobile operations in favor of high-yield solar arrays.</p>
          </div>
          
          <div class="impact-stat" v-reveal style="transition-delay: 0.1s">
            <div class="stat-val">Zero</div>
            <h3 class="stat-title">Trace Protocol</h3>
            <p class="stat-desc">Our camps leave no permanent physical mark upon departure, preserving the integrity of migratory routes.</p>
          </div>
          
          <div class="impact-stat" v-reveal style="transition-delay: 0.2s">
            <div class="stat-val">14<span class="percent">K</span></div>
            <h3 class="stat-title">Acres Protected</h3>
            <p class="stat-desc">Direct funding secured to maintain crucial buffer zones preventing human-wildlife conflict.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. The Initiatives (Editorial Split-Screen) -->
    <section class="editorial-initiatives">
      <div class="initiatives-header" v-reveal>
        <span class="section-label">03. Active Operations</span>
        <h2 class="section-title">Frontline <em>Initiatives</em></h2>
      </div>

      <!-- Initiative 1 -->
      <div class="init-spread">
        <div class="init-image" v-reveal>
          <img :src="getImage('initiative_1', '/image-04.jpg')" alt="Anti-Poaching Vanguard">
        </div>
        <div class="init-content" v-reveal>
          <span class="init-tag">Deployment 01</span>
          <h3 class="init-title">Anti-Poaching<br><em>Vanguard</em></h3>
          <p class="init-p">
            We partner directly with localized Ranger units operating in critical edge-habitats (Tarangire and the severe Ruaha sectors). A percentage of every expedition drafted by Ndauwo directly funds upgraded telemetry equipment, aerial drone surveillance, and K9 tracking units necessary to deter organized poaching rings.
          </p>
        </div>
      </div>

      <!-- Initiative 2 (Reversed) -->
      <div class="init-spread reverse">
        <div class="init-content" v-reveal>
          <span class="init-tag">Deployment 02</span>
          <h3 class="init-title">The Arusha<br><em>ScholarsFund</em></h3>
          <p class="init-p">
            Conservation is impossible without the absolute enfranchisement of the indigenous population. We fully sponsor twenty local students annually through comprehensive wildlife management and hospitality degrees. This ensures the future command of the ecosystem remains entirely in Tanzanian hands.
          </p>
        </div>
        <div class="init-image" v-reveal>
          <img :src="getImage('initiative_2', '/image-08.jpg')" alt="Maasai Scholarship">
        </div>
      </div>

      <!-- Initiative 3 -->
      <div class="init-spread">
        <div class="init-image" v-reveal>
          <img :src="getImage('initiative_3', '/image-10.jpg')" alt="Zero-Trace Camp">
        </div>
        <div class="init-content" v-reveal>
          <span class="init-tag">Deployment 03</span>
          <h3 class="init-title">Zero-Trace<br><em>Engineering</em></h3>
          <p class="init-p">
            Traditional monolithic lodges interrupt breeding grounds and require devastating infrastructure. We have completely rejected this model. Our operations utilize rapid-deployment infrastructure engineered in Arusha—offering uncompromised luxury that can be struck down within hours, leaving only footprints in the dust.
          </p>
        </div>
      </div>

    </section>

    <!-- 5. Clean The Pledge -->
    <section class="editorial-pledge">
      <div class="pledge-inner" v-reveal>
        <h2 class="pledge-quote">"To experience the wild is a privilege. To protect it is an <em>obligation.</em>"</h2>
        <div class="pledge-sig">
          <span class="sig-name">Ndauwo Impact Division</span>
          <span class="sig-loc">Tanzania, East Africa</span>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { usePageImages } from '../composables/usePageImages'

const { images, fetchImages, getImage } = usePageImages('conservation');

onMounted(() => {
  fetchImages();
});
</script>

<style scoped>
/* 
  EDITORIAL SYSTEM 
  Prioritizing: Whitespace, Symmetry, Playfair Display (Serif), Jost (Sans), Ivory/Forest Palette 
*/
.editorial-conservation {
  background-color: var(--ivory);
  color: var(--text-dark);
  font-family: 'Jost', sans-serif;
  overflow-x: hidden;
}

em {
  font-style: italic;
  font-weight: 400;
  color: var(--gold);
}

.section-label {
  font-size: 0.8rem;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  color: var(--gold);
  display: block;
  margin-bottom: 20px;
  font-weight: 500;
}

.section-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(3rem, 5vw, 4.5rem);
  color: var(--forest);
  line-height: 1.15;
  font-weight: 400;
}

/* 2. THE MISSION (Centered Whitespace) */
.editorial-mission {
  padding: 200px 5%;
  background: var(--ivory);
  text-align: center;
}
.mission-inner {
  max-width: 1000px;
  margin: 0 auto;
}
.mission-statement {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2rem, 3.5vw, 2.5rem);
  color: var(--forest);
  line-height: 1.6;
  font-weight: 400;
  margin-top: 40px;
}

/* 3. IMPACT BY NUMBERS */
.editorial-impact {
  padding: 150px 5%;
  background: #FFF; /* Pure white for structured data */
  border-top: 1px solid #EAEAEA;
  border-bottom: 1px solid #EAEAEA;
}
.impact-inner {
  max-width: 1400px;
  margin: 0 auto;
}
.impact-header {
  text-align: center;
  margin-bottom: 100px;
}
.impact-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 60px;
  text-align: center;
}
.impact-stat {
  padding: 0 40px;
}
.stat-val {
  font-family: 'Playfair Display', serif;
  font-size: clamp(4rem, 6vw, 6rem);
  color: var(--forest);
  line-height: 1;
  margin-bottom: 20px;
}
.stat-val .percent {
  font-size: 0.5em;
  color: var(--gold);
}
.stat-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.8rem;
  color: var(--forest);
  margin-bottom: 20px;
}
.stat-desc {
  font-size: 1.1rem;
  line-height: 1.8;
  color: var(--text-mid);
  font-weight: 300;
}

/* 4. THE INITIATIVES (Editorial Spreads) */
.editorial-initiatives {
  padding: 200px 5% 100px;
  background: var(--ivory);
}
.initiatives-header {
  text-align: center;
  margin-bottom: 150px;
}
.init-spread {
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  align-items: center;
  gap: 120px;
  max-width: 1400px;
  margin: 0 auto 200px;
}
.init-spread.reverse {
  grid-template-columns: 1fr 1.2fr;
}
.init-image {
  width: 100%;
  aspect-ratio: 4/3;
  overflow: hidden;
}
.init-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 1.2s ease;
  filter: sepia(5%);
}
.init-spread:hover .init-image img {
  transform: scale(1.03);
}
.init-content {
  padding-right: 40px;
}
.init-spread.reverse .init-content {
  padding-right: 0;
  padding-left: 40px;
}
.init-tag {
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.2em;
  color: var(--gold);
  display: block;
  margin-bottom: 20px;
  border-bottom: 1px solid var(--gold);
  padding-bottom: 5px;
  width: max-content;
}
.init-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 4vw, 3.5rem);
  color: var(--forest);
  line-height: 1.1;
  margin-bottom: 30px;
}
.init-p {
  font-size: 1.15rem;
  line-height: 2;
  color: var(--text-dark);
  font-weight: 300;
}

/* 5. THE PLEDGE */
.editorial-pledge {
  padding: 150px 5%;
  background: #FFF;
  text-align: center;
}
.pledge-inner {
  max-width: 1000px;
  margin: 0 auto;
}
.pledge-quote {
  font-family: 'Playfair Display', serif;
  font-size: clamp(3rem, 5vw, 4rem);
  color: var(--forest);
  line-height: 1.2;
  margin-bottom: 60px;
}
.pledge-sig {
  display: flex;
  flex-direction: column;
  align-items: center;
  border-top: 1px solid #EAEAEA;
  padding-top: 40px;
  margin-top: 40px;
}
.sig-name {
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
  color: var(--forest);
}
.sig-loc {
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.2em;
  color: var(--gold);
  margin-top: 5px;
}

/* RESPONSIVE */
@media (max-width: 1200px) {
  .init-spread { gap: 80px; }
}

@media (max-width: 1024px) {
  .impact-grid { grid-template-columns: 1fr; gap: 80px; }
  .init-spread, .init-spread.reverse { grid-template-columns: 1fr; gap: 60px; margin-bottom: 120px; }
  .init-content, .init-spread.reverse .init-content { padding: 0 5%; }
  .init-image { aspect-ratio: 16/9; }
}

@media (max-width: 768px) {
  .section-title { font-size: 2.5rem; }
  .stat-val { font-size: 4rem; }
  .editorial-mission { padding: 120px 5%; }
  .pledge-quote { font-size: 2rem; }
}
</style>
