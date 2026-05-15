<template>
  <div class="planning-view visa-entry">
    <!-- Premium Image Hero -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label" v-reveal>✦ Seamless Arrivals</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Entry ', class: 'white' },
            { text: 'Protocols', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="hero-subtitle" v-reveal>Your gateway to the African wilderness. Essential guidance for a dignified and effortless arrival.</p>
      </div>
    </section>

    <!-- ARRIVAL ETHOS -->
    <section class="arrival-ethos" v-reveal>
      <div class="ethos-inner">
        <div class="ethos-text">
          <span class="label-gold">The Ndauwo Touchdown</span>
          <h2>The Art of <em>Landing</em></h2>
          <p>We believe your safari begins the moment you step off the plane. Our arrival protocol is designed to strip away the friction of international travel, replacing it with the warmth and efficiency of Tanzanian hospitality.</p>
        </div>
        <div class="ethos-stats">
          <div class="stat-item">
            <strong>24/7</strong>
            <span>Meet & Greet</span>
          </div>
          <div class="stat-item">
            <strong>100%</strong>
            <span>Private Transfers</span>
          </div>
        </div>
      </div>
    </section>

    <!-- PRIORITY REQUIREMENTS -->
    <section class="priority-requirements">
      <div class="req-grid">
        <div class="req-card" v-reveal>
          <div class="req-icon-wrap"><ScrollText class="req-icon" /></div>
          <div class="req-body">
            <h3>Electronic <em>Visa</em></h3>
            <p>Tanzania strongly recommends E-Visas. Apply via the official portal at least 3 weeks prior to departure.</p>
            <a href="https://eservices.immigration.go.tz/visa/" target="_blank" class="text-gold-link">Official Portal →</a>
          </div>
        </div>

        <div class="req-card" v-reveal>
          <div class="req-icon-wrap"><BookOpen class="req-icon" /></div>
          <div class="req-body">
            <h3>Passport <em>Validity</em></h3>
            <p>Must be valid for 6 months post-entry with 2+ blank pages. Emergency passports may face restrictions.</p>
          </div>
        </div>

        <div class="req-card" v-reveal>
          <div class="req-icon-wrap"><MapPin class="req-icon" /></div>
          <div class="req-body">
            <h3>Entry <em>Gateways</em></h3>
            <p>Most guests arrive through JRO (Kilimanjaro) or DAR (Dar es Salaam) for immediate bush connections.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- JOURNEY ROADMAP -->
    <section class="journey-roadmap" v-reveal>
      <div class="roadmap-container">
        <span class="label-gold">Procedure</span>
        <h2 class="section-title">The Arrival <em>Journey</em></h2>
        <div class="roadmap-grid">
          <div class="roadmap-step">
            <span class="step-label">01</span>
            <div class="step-content">
              <h4>Immigration Control</h4>
              <p>Follow signs to E-Visa or Visa on Arrival counters. Have your documents ready for swift processing.</p>
            </div>
          </div>
          <div class="roadmap-step">
            <span class="step-label">02</span>
            <div class="step-content">
              <h4>The Meet & Greet</h4>
              <p>Once through customs, look for the Ndauwo sign. Your private driver will take charge of your luggage immediately.</p>
            </div>
          </div>
          <div class="roadmap-step">
            <span class="step-label">03</span>
            <div class="step-content">
              <h4>The First Transfer</h4>
              <p>Cool towels and chilled water await in your private vehicle as we transfer you to your first sanctuary.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- VISA CATEGORIES & FEES -->
    <section class="visa-fees" v-reveal>
      <div class="fees-container">
        <span class="label-gold">Official Rates</span>
        <h2 class="section-title">Visa <em>Categories</em></h2>
        <div class="fees-grid">
          <div class="fee-card">
            <div class="fee-header">
              <h4>Ordinary Visa</h4>
              <span class="price">$50</span>
            </div>
            <p>Single entry for tourism and leisure. Valid for up to 90 days.</p>
            <ul class="fee-details">
              <li>Standard tourism</li>
              <li>Health treatment</li>
              <li>Short-term study</li>
            </ul>
          </div>
          <div class="fee-card highlighted">
            <div class="fee-header">
              <h4>Multiple Entry</h4>
              <span class="price">$100</span>
            </div>
            <p>For frequent travelers or US Citizens (Mandatory for US nationals).</p>
            <ul class="fee-details">
              <li>Valid for 12 months</li>
              <li>Max 90 days per stay</li>
              <li>Multiple entries allowed</li>
            </ul>
          </div>
          <div class="fee-card">
            <div class="fee-header">
              <h4>Business Visa</h4>
              <span class="price">$250</span>
            </div>
            <p>For professionals attending meetings or short-term work.</p>
            <ul class="fee-details">
              <li>Max 90 days</li>
              <li>Professional consulting</li>
              <li>Special missions</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- OFFICIAL RESOURCES -->
    <section class="official-resources" v-reveal>
      <div class="resources-inner">
        <div class="resource-text">
          <span class="label-gold">Authoritative Links</span>
          <h3>Migration <em>Portals</em></h3>
          <p>Access the official United Republic of Tanzania migration resources for the most up-to-date documentation requirements.</p>
        </div>
        <div class="resource-links">
          <a href="https://eservices.immigration.go.tz/visa/" target="_blank" class="resource-btn">
            <ExternalLink class="icon" />
            <span>Official E-Visa Portal</span>
          </a>
          <a href="https://www.immigration.go.tz/" target="_blank" class="resource-btn secondary">
            <LinkIcon class="icon" />
            <span>Tanzania Migration Dept.</span>
          </a>
        </div>
      </div>
    </section>

    <!-- CUSTOMS & PROHIBITIONS -->
    <section class="customs-ethos" v-reveal>
      <div class="ethos-card">
        <div class="ethos-card-bg"></div>
        <div class="ethos-card-content">
          <span class="label-gold">Regulations</span>
          <h2 class="section-title">Gentle <em>Landings</em></h2>
          <p>Tanzania maintains strict environmental and safety regulations. Adherence ensures the preservation of the landscape you've come to witness.</p>
          <div class="reg-icons">
            <div class="reg-i"><Ban class="reg-icon" /><span>No Plastic Bags</span></div>
            <div class="reg-i"><ShieldAlert class="reg-icon" /><span>Wildlife Trophies</span></div>
            <div class="reg-i"><Plane class="reg-icon" /><span>Drone Permits Req.</span></div>
          </div>
        </div>
      </div>
    </section>

    <!-- PRACTICALITIES -->
    <section class="practicalities" v-reveal>
      <div class="prac-inner">
        <div class="prac-header">
          <span class="label-gold">Daily Life</span>
          <h2 class="section-title">Practical <em>Essentials</em></h2>
          <p>Navigating the local economy with ease and grace during your stay.</p>
        </div>
        <div class="prac-grid">
          <div class="prac-item">
            <div class="prac-icon-wrap"><Coins class="icon" /></div>
            <h4>Currency</h4>
            <p>TZS is official, but USD (2006+) is king for tips and luxury items. Exchange at JRO or Arusha.</p>
          </div>
          <div class="prac-item">
            <div class="prac-icon-wrap"><CreditCard class="icon" /></div>
            <h4>Payments</h4>
            <p>Visa/Mastercard accepted at lodges with 3-5% surge. Cash is essential for local markets.</p>
          </div>
          <div class="prac-item">
            <div class="prac-icon-wrap"><Wifi class="icon" /></div>
            <h4>Connectivity</h4>
            <p>Local SIM cards (Vodacom) available at airports. Wi-Fi is standard but intermittent at lodges.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="visa-notice-section" v-reveal>
      <div class="notice-card">
        <p><strong>ADVISORY:</strong> Visa regulations are subject to diplomatic shifts. Always verify latest protocols with the Tanzanian Ministry of Home Affairs or your local consulate.</p>
      </div>
    </section>
  </div>
</template>

<script setup>
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { ScrollText, BookOpen, MapPin, Ban, ShieldAlert, Plane, Coins, CreditCard, Wifi, ExternalLink, Link as LinkIcon } from 'lucide-vue-next'
import { usePageImages } from '../../composables/usePageImages'
import { onMounted } from 'vue'

const { images, fetchImages, getImage } = usePageImages('visa_entry');

onMounted(() => {
  fetchImages();
});
</script>

<style scoped>
.planning-view {
  background: white;
  min-height: 100vh;
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
  font-size: clamp(2.5rem, 5vw, 4rem);
  color: var(--ebony);
  margin-bottom: 24px;
  line-height: 1.1;
}

.section-title em {
  font-style: italic;
  font-weight: 400;
  color: var(--gold);
}

/* ARRIVAL ETHOS */
.arrival-ethos {
  padding: 140px 10%;
  border-bottom: 1px solid var(--ivory-dark);
}

.ethos-inner {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 0.4fr;
  gap: 100px;
  align-items: center;
}

.ethos-text h2 {
  font-family: 'Playfair Display', serif;
  font-size: 3.5rem;
  margin-bottom: 30px;
}

.ethos-text p {
  font-size: 1.2rem;
  line-height: 1.8;
  color: var(--text-mid);
  font-weight: 300;
}

.ethos-stats {
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.stat-item {
  display: flex;
  flex-direction: column;
}

.stat-item strong {
  font-family: 'Playfair Display', serif;
  font-size: 3.5rem;
  color: var(--gold);
  line-height: 1;
}

.stat-item span {
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.2em;
  color: var(--ebony);
  margin-top: 10px;
}

/* PRIORITY REQUIREMENTS */
.priority-requirements {
  padding: 100px 10%;
  background: var(--ivory);
}

.req-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 40px;
}

.req-card {
  background: white;
  padding: 50px 40px;
  border: 1px solid rgba(0,0,0,0.05);
  display: flex;
  flex-direction: column;
  gap: 25px;
  transition: transform 0.3s ease;
}

.req-card:hover {
  transform: translateY(-5px);
}

.req-icon {
  width: 40px;
  height: 40px;
  color: var(--gold);
}

.req-body h3 {
  font-family: 'Playfair Display', serif;
  font-size: 1.8rem;
  margin-bottom: 15px;
  color: var(--ebony);
}

.req-body h3 em {
  font-style: italic;
  font-weight: 400;
}

.req-body p {
  font-size: 0.95rem;
  line-height: 1.7;
  color: var(--text-mid);
  margin-bottom: 20px;
}

.text-gold-link {
  color: var(--gold);
  text-decoration: none;
  font-size: 0.75rem;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  font-weight: 600;
}

/* JOURNEY ROADMAP */
.journey-roadmap {
  padding: 140px 10%;
  border-bottom: 1px solid var(--ivory-dark);
}

.roadmap-container {
  max-width: 1200px;
  margin: 0 auto;
}

.roadmap-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 0;
  margin-top: 80px;
  border-top: 1px solid var(--gold);
}

.roadmap-step {
  padding-top: 40px;
  padding-right: 40px;
  border-right: 1px solid rgba(0,0,0,0.05);
}

.roadmap-step:last-child {
  border-right: none;
}

.step-label {
  font-family: 'Playfair Display', serif;
  font-size: 1rem;
  color: var(--gold);
  margin-bottom: 20px;
  display: block;
}

.step-content h4 {
  font-family: 'Playfair Display', serif;
  font-size: 1.6rem;
  margin-bottom: 20px;
  color: var(--ebony);
}

.step-content p {
  font-size: 1rem;
  line-height: 1.8;
  color: var(--text-mid);
  font-weight: 300;
}

/* VISA FEES */
.visa-fees {
  padding: 140px 10%;
  background: white;
}

.fees-container {
  max-width: 1200px;
  margin: 0 auto;
}

.fees-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 30px;
  margin-top: 60px;
}

.fee-card {
  background: var(--ivory);
  padding: 50px 40px;
  display: flex;
  flex-direction: column;
  border: 1px solid transparent;
  transition: all 0.4s ease;
}

.fee-card.highlighted {
  background: var(--ebony);
  border-color: var(--gold);
  color: white;
}

.fee-card.highlighted h4 { color: white; }
.fee-card.highlighted p { color: rgba(255,255,255,0.6); }

.fee-header {
  display: flex;
  justify-content: space-between;
  align-items: baseline;
  margin-bottom: 25px;
  border-bottom: 1px solid rgba(0,0,0,0.05);
  padding-bottom: 20px;
}

.fee-card.highlighted .fee-header {
  border-color: rgba(255,255,255,0.1);
}

.fee-header h4 {
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
  color: var(--ebony);
}

.price {
  font-family: 'Playfair Display', serif;
  font-size: 2rem;
  color: var(--gold);
}

.fee-card p {
  font-size: 0.95rem;
  line-height: 1.6;
  color: var(--text-mid);
  margin-bottom: 30px;
  min-height: 60px;
}

.fee-details {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.fee-details li {
  font-size: 0.85rem;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  display: flex;
  align-items: center;
  gap: 10px;
}

.fee-details li::before {
  content: '✦';
  color: var(--gold);
  font-size: 0.7rem;
}

/* OFFICIAL RESOURCES */
.official-resources {
  padding: 100px 10%;
  background: var(--ebony);
  color: white;
}

.resources-inner {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 80px;
}

.resource-text {
  max-width: 500px;
}

.resource-text h3 {
  font-family: 'Playfair Display', serif;
  font-size: 2.8rem;
  margin-bottom: 20px;
}

.resource-text h3 em {
  font-style: italic;
  color: var(--gold);
}

.resource-text p {
  color: rgba(255,255,255,0.6);
  line-height: 1.7;
}

.resource-links {
  display: flex;
  gap: 20px;
}

.resource-btn {
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 20px 30px;
  background: var(--gold);
  color: var(--ebony);
  text-decoration: none;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  font-weight: 600;
  white-space: nowrap;
}

.resource-btn.secondary {
  background: transparent;
  border: 1px solid rgba(255,255,255,0.2);
  color: white;
}

.resource-btn .icon {
  width: 18px;
  height: 18px;
}

/* CUSTOMS ETHOS */
.customs-ethos {
  padding: 120px 10%;
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
  clip-path: polygon(0 0, 100% 10%, 100% 100%, 0 90%);
}

.ethos-card-content {
  position: relative;
  z-index: 2;
  max-width: 800px;
  padding: 80px 40px;
}

.ethos-card-content .section-title { color: white; }

.reg-icons {
  display: flex;
  justify-content: center;
  gap: 60px;
  margin-top: 60px;
}

.reg-i {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 15px;
}

.reg-icon {
  width: 40px;
  height: 40px;
  color: var(--gold);
}

.reg-i span {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.2em;
}

/* PRACTICALITIES */
.practicalities {
  padding: 140px 10%;
  background: var(--ivory-dark);
}

.prac-inner {
  max-width: 1200px;
  margin: 0 auto;
}

.prac-header {
  margin-bottom: 80px;
  max-width: 600px;
}

.prac-header p {
  font-size: 1.2rem;
  color: var(--text-mid);
  font-weight: 300;
}

.prac-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 60px;
}

.prac-icon-wrap {
  width: 60px;
  height: 60px;
  background: white;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 30px;
}

.prac-icon-wrap .icon {
  width: 25px;
  height: 25px;
  color: var(--gold);
}

.prac-item h4 {
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
  margin-bottom: 15px;
  color: var(--ebony);
}

.prac-item p {
  font-size: 0.95rem;
  line-height: 1.7;
  color: var(--text-mid);
  font-weight: 300;
}

.visa-notice-section {
  padding: 100px 10%;
  text-align: center;
}

.notice-card {
  max-width: 800px;
  margin: 0 auto;
  padding: 40px;
  background: white;
  border: 1px solid var(--ivory-dark);
  font-size: 0.85rem;
  letter-spacing: 0.05em;
  color: var(--text-mid);
  text-transform: uppercase;
}

@media (max-width: 1024px) {
  .ethos-inner { grid-template-columns: 1fr; gap: 60px; text-align: center; }
  .ethos-stats { flex-direction: row; justify-content: center; gap: 60px; }
  .req-grid { grid-template-columns: 1fr; }
  .roadmap-grid { grid-template-columns: 1fr; border-top: none; }
  .roadmap-step { border-right: none; border-top: 1px solid var(--gold); padding: 40px 0; }
  .prac-grid { grid-template-columns: 1fr; gap: 40px; }
  .reg-icons { flex-direction: column; gap: 40px; }
}
</style>
