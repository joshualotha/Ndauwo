<template>
  <div class="planning-view">
    <!-- Premium Image Hero -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label" v-reveal>✦ Your Well-being</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Health & ', class: 'white' },
            { text: 'Safety', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="page-subtitle">Expert guidance for a secure and healthy expedition in the Tanzanian bush.</p>
      </div>
    </section>

    <section class="health-grid">
      <div class="health-item" v-reveal>
        <div class="icon-wrap"><ShieldCheck class="icon" /></div>
        <h3>Medical Preparations</h3>
        <p>Tanzania is a malaria-prone area. Please consult your travel clinic for the most appropriate prophylaxis. Yellow fever vaccination is required if traveling from an endemic country.</p>
      </div>

      <div class="health-item" v-reveal>
        <div class="icon-wrap"><HeartPulse class="icon" /></div>
        <h3>Flying Doctors</h3>
        <p>All our guests are automatically enrolled in AMREF Flying Doctors for emergency evacuation. This provides piece of mind for even the most remote safari locations.</p>
      </div>

      <div class="health-item" v-reveal>
        <div class="icon-wrap"><Activity class="icon" /></div>
        <h3>On Safari Safety</h3>
        <p>Our field teams are trained in First Aid and safety protocols. We maintain constant radio contact and carry well-stocked medical kits in all vehicles.</p>
      </div>
    </section>

    <section class="wildlife-conduct">
      <div class="conduct-hero" :style="{ backgroundImage: `url(${getImage('wildlife_conduct', '/image-19.jpg')})` }">
        <div class="conduct-veil"></div>
        <div class="conduct-content">
          <div class="conduct-header" v-reveal>
            <span class="label-gold">Field Protocols</span>
            <h2 class="section-title">Wildlife <em>Conduct</em></h2>
            <p class="section-lead">Safety is rooted in respect. Our protocols are designed to protect both the integrity of the wilderness and the wellbeing of our guests.</p>
          </div>
          
          <div class="rules-grid">
            <div class="rule-card" v-reveal>
              <div class="rule-icon"><ShieldCheck class="icon" /></div>
              <div class="rule-text">
                <h4>Respect the Space</h4>
                <p>Always stay inside the vehicle unless your guide explicitly authorizes an exit. Silencing devices and maintaining low tones preserves the natural behavior of the animals.</p>
              </div>
            </div>
            
            <div class="rule-card" v-reveal>
              <div class="rule-icon"><Bell class="icon" /></div>
              <div class="rule-text">
                <h4>No Interference</h4>
                <p>Feeding or attempting to attract wildlife is strictly prohibited. It creates dangerous dependencies and can lead to aggressive encounters with future travelers.</p>
              </div>
            </div>
            
            <div class="rule-card" v-reveal>
              <div class="rule-icon"><MapPin class="icon" /></div>
              <div class="rule-text">
                <h4>Camp Vigilance</h4>
                <p>In unfenced camps, never walk alone after dusk. Our experienced Maasai sentries are available 24/7 to provide escorts to and from your tent.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="fitness-food-split">
      <div class="split-row" v-reveal>
        <div class="split-image" :style="{ backgroundImage: `url(${getImage('split_image_1', '/image-08.jpg')})` }"></div>
        <div class="split-text">
          <span class="label-gold">Preparation</span>
          <h3>Physical <em>Fitness</em></h3>
          <p>While most safaris are not physically demanding, a basic level of fitness enhances your experience. If you are planning a Kilimanjaro or Mt. Meru climb, a dedicated training regimen is essential.</p>
          <ul class="premium-list">
            <li><strong>Game Drives:</strong> Minimal effort, but long hours on bumpy roads.</li>
            <li><strong>Walking Safaris:</strong> Moderate activity; requires comfortable walking shoes.</li>
            <li><strong>Trekking:</strong> High physical demand; specialized preparation required.</li>
          </ul>
        </div>
      </div>

      <div class="split-row row-reverse" v-reveal>
        <div class="split-image" :style="{ backgroundImage: `url(${getImage('split_image_2', '/image-20.jpg')})` }"></div>
        <div class="split-text">
          <span class="label-gold">Provision</span>
          <h3>Food & <em>Water</em></h3>
          <p>We take food hygiene very seriously. All produce is washed in purified water, and our chefs are trained in international standards.</p>
          <ul class="premium-list">
            <li><strong>Water:</strong> Always drink bottled or filtered water provided in the vehicles and at camps.</li>
            <li><strong>Ice:</strong> Provided ice is always made from purified water.</li>
            <li><strong>Dietary:</strong> We cater to all dietary requirements with prior notice.</li>
          </ul>
        </div>
      </div>
    </section>

    <section class="insurance-seal" v-reveal>
      <div class="seal-container">
        <div class="seal-inner">
          <div class="seal-header">
            <ShieldCheck class="seal-icon" />
            <h3>Insurance <em>Essentials</em></h3>
          </div>
          <div class="seal-content">
            <p>Comprehensive travel insurance is a mandatory requirement for traveling with Ndauwo Safari Co. Your policy should cover medical expenses, personal accident, trip cancellation, and loss of personal effects.</p>
            <div class="seal-notice">
              <strong>Mandatory Protocol:</strong> While we provide AMREF emergency evacuation, this is not a substitute for full medical insurance.
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="health-cta" v-reveal>
      <div class="cta-inner">
        <h2>Expert Advice</h2>
        <p>Have specific health concerns? Our safari planners are here to discuss your requirements in detail.</p>
        <router-link to="/contact" class="btn-primary">Speak to an Expert</router-link>
      </div>
    </section>
  </div>
</template>

<script setup>
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { ShieldCheck, HeartPulse, Activity, Bell, MapPin } from 'lucide-vue-next'
import { usePageImages } from '../../composables/usePageImages'
import { onMounted } from 'vue'

const { images, fetchImages, getImage } = usePageImages('health_safety');

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

.page-subtitle {
  font-size: 1.2rem;
  color: var(--text-mid);
  max-width: 600px;
  margin: 0 auto;
}

.health-grid {
  padding: 100px 10%;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 60px;
}

.health-item {
  text-align: center;
  padding: 40px;
  background: white;
  border-radius: 4px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.icon-wrap {
  width: 80px;
  height: 80px;
  background: var(--sky);
  color: var(--gold);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 30px;
}

.icon {
  width: 40px;
  height: 40px;
}

.health-item h3 {
  font-family: 'Playfair Display', serif;
  font-size: 1.6rem;
  margin-bottom: 20px;
  color: var(--ebony);
}

.health-item p {
  font-size: 1rem;
  line-height: 1.7;
  color: var(--text-mid);
}

/* WILDLIFE CONDUCT - REDESIGN */
.wildlife-conduct {
  margin: 120px 0;
}

.conduct-hero {
  position: relative;
  min-height: 800px;
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  display: flex;
  align-items: center;
  padding: 120px 8%;
}

.conduct-veil {
  position: absolute;
  inset: 0;
  background: linear-gradient(to right, rgba(14,14,14,0.9) 30%, rgba(14,14,14,0.4) 100%);
}

.conduct-content {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 1400px;
  margin: 0 auto;
}

.conduct-header {
  max-width: 600px;
  margin-bottom: 80px;
}

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
  color: white;
  margin-bottom: 24px;
  line-height: 1.1;
}

.section-title em {
  font-style: italic;
  font-weight: 400;
  color: var(--gold);
}

.section-lead {
  font-size: 1.15rem;
  line-height: 1.8;
  color: rgba(255, 255, 255, 0.7);
  font-weight: 300;
}

.rules-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 30px;
}

.rule-card {
  background: rgba(255, 255, 255, 0.03);
  backdrop-filter: blur(15px);
  -webkit-backdrop-filter: blur(15px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  padding: 40px;
  display: flex;
  gap: 24px;
  transition: transform 0.4s ease, border-color 0.4s ease;
}

.rule-card:hover {
  transform: translateY(-5px);
  border-color: var(--gold);
  background: rgba(255, 255, 255, 0.06);
}

.rule-icon {
  flex-shrink: 0;
}

.rule-icon .icon {
  width: 32px;
  height: 32px;
  color: var(--gold);
}

.rule-text h4 {
  font-family: 'Playfair Display', serif;
  font-size: 1.4rem;
  color: white;
  margin-bottom: 15px;
  font-weight: 400;
}

.rule-text p {
  font-size: 0.95rem;
  line-height: 1.7;
  color: rgba(255, 255, 255, 0.6);
  font-weight: 300;
  margin: 0;
}

/* FITNESS & FOOD SPLIT */
.fitness-food-split {
  margin: 120px 0;
}

.split-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: 600px;
}

.split-image {
  background-size: cover;
  background-position: center;
}

.split-text {
  padding: 100px 12%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  background: white;
}

.split-text h3 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 4vw, 3.5rem);
  color: var(--ebony);
  margin-bottom: 24px;
  line-height: 1.1;
}

.split-text h3 em {
  font-style: italic;
  font-weight: 400;
  color: var(--gold);
}

.split-text p {
  font-size: 1.1rem;
  line-height: 1.8;
  color: var(--text-mid);
  margin-bottom: 32px;
  font-weight: 300;
}

.premium-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.premium-list li {
  font-size: 0.95rem;
  color: var(--text-dark);
  padding: 12px 0;
  border-top: 1px solid rgba(0,0,0,0.05);
  display: flex;
  gap: 12px;
}

.premium-list li::before {
  content: '✦';
  color: var(--gold);
  font-size: 0.8rem;
}

.row-reverse .split-image { order: 2; }
.row-reverse .split-text { order: 1; }

/* INSURANCE SEAL */
.insurance-seal {
  padding: 120px 8%;
  background: var(--ivory-dark);
}

.seal-container {
  max-width: 1000px;
  margin: 0 auto;
}

.seal-inner {
  background: var(--ebony);
  border: 1px solid var(--gold);
  padding: 60px;
  display: flex;
  gap: 60px;
  align-items: center;
  position: relative;
}

.seal-icon {
  width: 80px;
  height: 80px;
  color: var(--gold);
  flex-shrink: 0;
}

.seal-header h3 {
  font-family: 'Playfair Display', serif;
  font-size: 2.2rem;
  color: white;
  margin-top: 20px;
}

.seal-header h3 em {
  font-style: italic;
  color: var(--gold);
}

.seal-content p {
  font-size: 1.1rem;
  line-height: 1.8;
  color: rgba(255, 255, 255, 0.7);
  margin-bottom: 24px;
  font-weight: 300;
}

.seal-notice {
  font-size: 0.85rem;
  letter-spacing: 0.05em;
  color: var(--gold);
  text-transform: uppercase;
  border-left: 2px solid var(--gold);
  padding-left: 20px;
}

/* OTHER SECTIONS */
.health-cta {
  padding: 100px 10%;
}

@media (max-width: 1024px) {
  .split-row { grid-template-columns: 1fr; }
  .split-image { min-height: 400px; }
  .row-reverse .split-image { order: 0; }
  .row-reverse .split-text { order: 0; }
  .seal-inner { flex-direction: column; text-align: center; gap: 40px; padding: 40px; }
  .seal-notice { border-left: none; border-top: 1px solid var(--gold); padding: 20px 0 0 0; }
}

@media (max-width: 768px) {
  .conduct-hero {
    padding: 100px 5%;
    background-attachment: scroll;
  }
  .conduct-veil {
    background: rgba(14,14,14,0.85);
  }
  .rule-card {
    padding: 30px;
  }
}

.cta-inner {
  background: var(--ebony);
  padding: 80px;
  text-align: center;
  border-radius: 4px;
}

.cta-inner h2 {
  font-family: 'Playfair Display', serif;
  font-size: 2.5rem;
  color: var(--ivory);
  margin-bottom: 30px;
}

.cta-inner p {
  color: rgba(245,240,232,0.6);
  margin-bottom: 40px;
  max-width: 500px;
  margin-left: auto;
  margin-right: auto;
}
</style>
