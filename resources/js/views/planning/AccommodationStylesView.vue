<template>
  <div class="planning-view accommodation-styles">
    <!-- Premium Image Hero -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label" v-reveal>✦ Authentic Sanctuaries</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Safari ', class: 'white' },
            { text: 'Sanctuaries', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="hero-subtitle" v-reveal>Beyond the canvas. A curated collection of Tanzania's most intentional and evocative dwellings.</p>
      </div>
    </section>

    <!-- ETHOS OF STAY -->
    <section class="ethos-stay" v-reveal>
      <div class="ethos-inner">
        <span class="label-gold">Our Philosophy</span>
        <h2>The Art of <em>Being There</em></h2>
        <div class="ethos-grid">
          <div class="ethos-col">
            <p>We don't choose properties based on thread counts alone. We look for sanctuaries that offer <strong>Purity of Location</strong>, places situated in the path of the migration, or tucked into ancient groves where the silence is absolute.</p>
          </div>
          <div class="ethos-col">
            <p>Every partner we represent must demonstrate <strong>Proximity to Impact</strong>. Your stay should contribute directly to the communities that protect these lands and the wildlife that calls them home.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CATEGORY: TENTED CAMPS -->
    <section class="style-section style-tented" v-reveal>
      <div class="style-split">
        <div class="style-photo" :style="{ backgroundImage: `url(${getImage('tented_camps', 'https://images.unsplash.com/photo-1493246507139-91e8bef99c02?w=1200&q=80')})` }"></div>
        <div class="style-card">
          <span class="label-gold">The Quintessential Safari</span>
          <h2 class="style-title">Luxury <em>Tented Camps</em></h2>
          <p class="style-lead">Canvas walls that let the heartbeat of the bush in, while shielding you in absolute luxury.</p>
          <div class="style-details">
            <p>This is the classic safari. Tented camps offer a tactile connection to the wilderness. You wake to the sound of birds and sleep to the distant roar of lions, all while enjoying mahogany floors, brass fixtures, and en-suite facilities that rival any city hotel.</p>
          </div>
          <div class="style-features">
            <span>✦ Immersive Acoustics</span>
            <span>✦ Proximity to Wildlife</span>
            <span>✦ Elevated Design</span>
          </div>
        </div>
      </div>
    </section>

    <!-- CATEGORY: PERMANENT LODGES -->
    <section class="style-section style-lodge" v-reveal>
      <div class="lodge-hero" :style="{ backgroundImage: `url(${getImage('lodge_hero', 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1200&q=80')})` }">
        <div class="lodge-veil"></div>
        <div class="lodge-content">
          <span class="label-gold">Stone Sanctuaries</span>
          <h2 class="style-title">Permanent <em>Safari Lodges</em></h2>
          <p class="lodge-lead">Architectural marvels carved into the landscape, offering a sanctuary of permanence and scale.</p>
          <div class="lodge-features-grid">
            <div class="l-feat">
              <h4>Total Refinement</h4>
              <p>Infinity pools overlooking watering holes, private wine cellars, and world-class spas.</p>
            </div>
            <div class="l-feat">
              <h4>Solid Comfort</h4>
              <p>Thick stone walls and heavy timber provide an anchor of security and complete temperature control.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CATEGORY: FLY CAMPING & BUSH HOMES -->
    <section class="style-section style-alternate" v-reveal>
      <div class="alt-grid">
        <div class="alt-card">
          <div class="alt-photo" :style="{ backgroundImage: `url(${getImage('fly_camping', 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80')})` }"></div>
          <div class="alt-body">
            <span class="label-gold">Exploratory</span>
            <h3>Fly <em>Camping</em></h3>
            <p>For the purist. Setting up temporary camps in remote locations where no permanent structures are allowed. Sleeping under mosquito nets beneath the vast African sky.</p>
          </div>
        </div>
        <div class="alt-card">
          <div class="alt-photo" :style="{ backgroundImage: `url(${getImage('bush_homes', 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=800&q=80')})` }"></div>
          <div class="alt-body">
            <span class="label-gold">Total Privacy</span>
            <h3>Private <em>Bush Homes</em></h3>
            <p>Perfect for families or small groups. Fully staffed villas with private chefs, dedicated guides, and your own private piece of the wild. Home, but wilder.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="spec-grid-section" v-reveal>
      <div class="spec-container">
        <span class="label-gold">Technicalities</span>
        <h2 class="section-title">Comparative <em>Specs</em></h2>
        <div class="spec-grid">
          <div class="spec-card">
            <h4>Atmosphere</h4>
            <div class="spec-row"><span>Tented Camp</span><strong>Immersive & Tactile</strong></div>
            <div class="spec-row"><span>Safari Lodge</span><strong>Grand & Architectural</strong></div>
          </div>
          <div class="spec-card">
            <h4>Structure</h4>
            <div class="spec-row"><span>Tented Camp</span><strong>Canvas & Timber</strong></div>
            <div class="spec-row"><span>Safari Lodge</span><strong>Stone & Glass</strong></div>
          </div>
          <div class="spec-card">
            <h4>Security</h4>
            <div class="spec-row"><span>Tented Camp</span><strong>Maasai Escorted</strong></div>
            <div class="spec-row"><span>Safari Lodge</span><strong>Fully Enclosed</strong></div>
          </div>
          <div class="spec-card">
            <h4>Philosophy</h4>
            <div class="spec-row"><span>Tented Camp</span><strong>Proximity First</strong></div>
            <div class="spec-row"><span>Safari Lodge</span><strong>Comfort First</strong></div>
          </div>
        </div>
      </div>
    </section>

    <section class="eco-ethos" v-reveal>
      <div class="ethos-card">
        <div class="ethos-card-bg"></div>
        <div class="ethos-card-content">
          <span class="label-gold">Sustainability</span>
          <h2 class="section-title">Gentle <em>Footprints</em></h2>
          <p>We partner exclusively with properties that prioritize the preservation of the African ecosystem. Our selected camps operate on 100% solar energy, utilize advanced water recycling systems, and eliminate single-use plastics.</p>
          <div class="eco-icons">
            <div class="eco-i"><Sun class="icon" /><span>Solar Oriented</span></div>
            <div class="eco-i"><Droplets class="icon" /><span>Water Conscious</span></div>
            <div class="eco-i"><Leaf class="icon" /><span>Zero Waste</span></div>
          </div>
        </div>
      </div>
    </section>

    <section class="expectations" v-reveal>
      <div class="expect-inner">
        <div class="expect-header">
          <span class="label-gold">Essentials</span>
          <h2 class="section-title">Expect <em>Excellence</em></h2>
          <p>Beyond the style of dwelling, the standards of Ndauwo remain absolute across every sanctuariy we select.</p>
        </div>
        <div class="expect-details-grid">
          <div class="expect-col">
            <ul class="premium-list">
              <li><strong>Connectivity:</strong> Intermittent Wi-Fi in main areas.</li>
              <li><strong>Laundry:</strong> Same-day service in most camps.</li>
            </ul>
          </div>
          <div class="expect-col">
            <ul class="premium-list">
              <li><strong>Charging:</strong> Full stations in rooms and vehicles.</li>
              <li><strong>Safety:</strong> 24/7 security and expert guiding.</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { Sun, Droplets, Leaf, ShieldCheck } from 'lucide-vue-next'
import { usePageImages } from '../../composables/usePageImages'
import { onMounted } from 'vue'

const { images, fetchImages, getImage } = usePageImages('accommodation_styles');

onMounted(() => {
  fetchImages();
});
</script>

<style scoped>
.planning-view {
  background: var(--ivory);
  min-height: 100vh;
}

/* HERO - Now using Global .premium-hero */

.label-gold {
  display: block;
  font-size: 0.75rem;
  letter-spacing: 0.4em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 24px;
}

.section-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 5vw, 4.5rem);
  color: var(--ebony);
  margin-bottom: 24px;
  line-height: 1.1;
}

.section-title em {
  font-style: italic;
  font-weight: 400;
  color: var(--gold);
}

/* ETHOS STAY */
.ethos-stay {
  padding: 140px 10%;
  background: white;
  border-bottom: 1px solid var(--ivory-dark);
}

.ethos-inner {
  max-width: 1200px;
  margin: 0 auto;
}

.ethos-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  margin-top: 40px;
}

.ethos-col p {
  font-size: 1.15rem;
  line-height: 1.8;
  color: var(--text-mid);
  font-weight: 300;
}

.ethos-col strong {
  color: var(--ebony);
  font-weight: 500;
}

/* TENTED SECTION */
.style-section {
  padding: 140px 0;
}

.style-split {
  display: grid;
  grid-template-columns: 1.1fr 0.9fr;
  min-height: 700px;
}

.style-photo {
  background-size: cover;
  background-position: center;
}

.style-card {
  background: var(--ivory-dark);
  padding: 100px 12%;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.style-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 4vw, 3.5rem);
  color: var(--ebony);
  margin-bottom: 30px;
  line-height: 1.1;
}

.style-title em {
  font-style: italic;
  font-weight: 400;
  color: var(--gold);
}

.style-lead {
  font-size: 1.3rem;
  color: var(--text-dark);
  margin-bottom: 40px;
  font-weight: 400;
  line-height: 1.4;
}

.style-details p {
  font-size: 1.05rem;
  line-height: 1.8;
  color: var(--text-mid);
  margin-bottom: 40px;
  font-weight: 300;
}

.style-features {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.style-features span {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.25em;
  color: var(--gold);
}

/* LODGE HERO */
.lodge-hero {
  position: relative;
  min-height: 800px;
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  display: flex;
  align-items: center;
  padding: 120px 10%;
}

.lodge-veil {
  position: absolute;
  inset: 0;
  background: linear-gradient(to right, rgba(14,14,14,0.9) 30%, rgba(14,14,14,0.3) 100%);
}

.lodge-content {
  position: relative;
  z-index: 2;
  max-width: 800px;
}

.lodge-content .style-title { color: white; }

.lodge-lead {
  font-size: 1.4rem;
  color: rgba(255, 255, 255, 0.8);
  margin-bottom: 60px;
  max-width: 600px;
}

.lodge-features-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
}

.l-feat h4 {
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
  color: white;
  margin-bottom: 15px;
}

.l-feat p {
  font-size: 0.95rem;
  color: rgba(255, 255, 255, 0.6);
  line-height: 1.7;
}

/* ALTERNATE GRID */
.style-alternate {
  padding: 140px 10%;
  background: white;
}

.alt-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
}

.alt-photo {
  height: 500px;
  background-size: cover;
  background-position: center;
  margin-bottom: 40px;
}

.alt-body h3 {
  font-family: 'Playfair Display', serif;
  font-size: 2.2rem;
  color: var(--ebony);
  margin-bottom: 20px;
}

.alt-body h3 em {
  font-style: italic;
  font-weight: 400;
  color: var(--gold);
}

.alt-body p {
  font-size: 1.1rem;
  line-height: 1.8;
  color: var(--text-mid);
  font-weight: 300;
}

/* SPEC GRID */
.spec-grid-section {
  padding: 140px 10%;
  background: var(--ivory-dark);
}

.spec-container {
  max-width: 1200px;
  margin: 0 auto;
}

.spec-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 30px;
  margin-top: 60px;
}

.spec-card {
  background: white;
  padding: 40px;
  border: 1px solid rgba(0,0,0,0.05);
}

.spec-card h4 {
  font-family: 'Playfair Display', serif;
  font-size: 1.4rem;
  color: var(--ebony);
  margin-bottom: 25px;
  border-bottom: 1px solid var(--gold);
  padding-bottom: 15px;
}

.spec-row {
  display: flex;
  flex-direction: column;
  gap: 5px;
  margin-bottom: 20px;
}

.spec-row span {
  font-size: 0.65rem;
  text-transform: uppercase;
  letter-spacing: 0.2em;
  color: var(--text-mid);
}

.spec-row strong {
  font-size: 0.95rem;
  color: var(--text-dark);
}

/* ECO ETHOS */
.eco-ethos {
  padding: 140px 10%;
  background: white;
}

.ethos-card {
  position: relative;
  min-height: 500px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  text-align: center;
}

.ethos-card-bg {
  position: absolute;
  inset: 0;
  background: var(--ebony);
  clip-path: polygon(0 10%, 100% 0, 100% 90%, 0 100%);
}

.ethos-card-content {
  position: relative;
  z-index: 2;
  max-width: 800px;
  padding: 80px 40px;
}

.ethos-card-content .section-title { color: white; }

.eco-icons {
  display: flex;
  justify-content: center;
  gap: 60px;
  margin-top: 60px;
}

.eco-i {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 15px;
}

.eco-i .icon {
  width: 40px;
  height: 40px;
  color: var(--gold);
}

.eco-i span {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.2em;
}

/* EXPECTATIONS */
.expectations {
  padding: 140px 10%;
}

.expect-inner {
  max-width: 1200px;
  margin: 0 auto;
}

.expect-header {
  max-width: 600px;
  margin-bottom: 80px;
}

.expect-header p {
  font-size: 1.2rem;
  line-height: 1.8;
  color: var(--text-mid);
  font-weight: 300;
}

.expect-details-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
}

.premium-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.premium-list li {
  font-size: 1.05rem;
  color: var(--text-dark);
  padding: 20px 0;
  border-top: 1px solid rgba(0,0,0,0.05);
  display: flex;
  gap: 15px;
}

.premium-list li::before {
  content: '✦';
  color: var(--gold);
  font-size: 0.9rem;
}

@media (max-width: 1024px) {
  .style-split { grid-template-columns: 1fr; }
  .style-photo { height: 400px; }
  .lodge-hero { background-attachment: scroll; }
  .alt-grid { grid-template-columns: 1fr; }
  .ethos-grid { grid-template-columns: 1fr; gap: 40px; }
  .expect-details-grid { grid-template-columns: 1fr; gap: 0; }
}

@media (max-width: 768px) {
  .lodge-features-grid { grid-template-columns: 1fr; }
  .eco-icons { flex-direction: column; gap: 40px; }
}
</style>
