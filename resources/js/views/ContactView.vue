<template>
  <div class="contact-page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    
    <!-- Premium Hero Section -->
    <!-- Premium Hero Section -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label" v-reveal>✦ Concierge Service</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Start ', class: 'white' },
            { text: 'Planning', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="hero-subtitle" v-reveal>
          Whether you are ready to book or simply exploring ideas, our safari designers are at your absolute disposal.
        </p>
      </div>
    </section>

    <!-- Contact Methods Grid -->
    <section class="contact-methods">
      <div class="methods-grid">
        
        <div class="method-card reveal" v-reveal>
          <div class="method-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
          </div>
          <h3 class="method-title">Email Us</h3>
          <p class="method-desc">For general inquiries and detailed itinerary planning.</p>
          <a v-if="settings.contact_email" :href="`mailto:${settings.contact_email}`" class="method-link">{{ settings.contact_email }}</a>
        </div>

        <div class="method-card reveal reveal-delay-1" v-reveal>
          <div class="method-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.48-4.18-7.076-7.076l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
          </div>
          <h3 class="method-title">Call Us</h3>
          <p class="method-desc">Speak directly with a Safari Designer. Available 24/7.</p>
          <a v-if="settings.contact_phone" :href="`tel:${settings.contact_phone.replace(/\s/g, '')}`" class="method-link">{{ settings.contact_phone }}</a>
        </div>

        <div class="method-card reveal reveal-delay-2" v-reveal>
          <div class="method-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
          </div>
          <h3 class="method-title">Visit Us</h3>
          <p class="method-desc">Our headquarters in the safari capital of the world.</p>
          <div v-if="settings.office_address" class="method-text" v-html="settings.office_address.replace(/\n/g, '<br>')"></div>
          <div v-else class="method-text">Arusha Safari Centre<br>Plot 42, Arusha, TZ</div>
        </div>

      </div>
    </section>

    <!-- Split Form Section -->
    <section class="inquiry-section">
      <div class="inquiry-visual reveal-left" v-reveal>
        <div class="visual-img" :style="{ backgroundImage: `url(${getImage('office_image', '/image-15.jpg')})` }"></div>
        <div class="visual-badge">
          <span>Tailor-Made</span>
          <em>Journeys</em>
        </div>
      </div>
      
      <div class="inquiry-form-container reveal-right" v-reveal>
        <div class="section-header" style="text-align:left; margin-bottom: 40px;">
          <span class="section-label" style="color:var(--gold)">Bespoke Requests</span>
          <h2 class="section-heading" style="color:var(--forest)">Design Your <em>Dream</em></h2>
        </div>
        
        <form class="premium-form" @submit.prevent>
          <div class="form-row">
            <div class="input-container">
              <input type="text" id="fname" required placeholder=" " />
              <label for="fname">First Name</label>
              <div class="input-line"></div>
            </div>
            <div class="input-container">
              <input type="text" id="lname" required placeholder=" " />
              <label for="lname">Last Name</label>
              <div class="input-line"></div>
            </div>
          </div>
          
          <div class="input-container">
            <input type="email" id="email" required placeholder=" " />
            <label for="email">Email Address</label>
            <div class="input-line"></div>
          </div>
          
          <div class="form-row">
            <div class="input-container">
              <select id="travelers" required>
                <option value="" disabled selected></option>
                <option value="1">1 Traveler</option>
                <option value="2">2 Travelers</option>
                <option value="3-4">3-4 Travelers</option>
                <option value="5+">5+ Travelers</option>
              </select>
              <label for="travelers" class="select-label">Party Size</label>
              <div class="input-line"></div>
            </div>
            <div class="input-container">
              <input type="text" id="date" required placeholder=" " onfocus="(this.type='month')" onblur="(this.type='text')" />
              <label for="date">Est. Travel Month</label>
              <div class="input-line"></div>
            </div>
          </div>

          <div class="input-container">
            <textarea id="message" required placeholder=" " rows="4"></textarea>
            <label for="message">Tell us about your ideal safari experience...</label>
            <div class="input-line"></div>
          </div>
          
          <button type="submit" class="submit-btn hover-sweep">
            <span>Send Inquiry</span>
            <span class="btn-arrow">→</span>
          </button>
        </form>
      </div>
    </section>

    <!-- Premium Map Section -->
    <section class="map-section reveal" v-reveal>
      <div class="map-overlay">
        <h3>Ndauwo Headquarters</h3>
        <p>Arusha, Tanzania</p>
      </div>
      <div class="map-container">
        <!-- Using an iframe for Google Maps with CSS filters for a premium dark/sepia look -->
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127547.46505779085!2d36.60803923010775!3d-3.373406606869403!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x18371c88f23ef739%3A0x1d58dcc234dbb937!2sArusha%2C%20Tanzania!5e0!3m2!1sen!2sus!4v1709545000000!5m2!1sen!2sus" 
          width="100%" 
          height="100%" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </section>

  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { usePageImages } from '../composables/usePageImages'
import { useSettings } from '../composables/useSettings'

const { images, fetchImages, getImage } = usePageImages('contact');
const { settings } = useSettings();

onMounted(() => {
  fetchImages();
});
// Interactive premium contact form logic
</script>

<style scoped>
/* HERO */
/* HERO - Now using Global .premium-hero */

@keyframes slowZoomOut {
  from { transform: scale(1.15); }
  to { transform: scale(1); }
}

/* METHODS GRID */
.contact-methods {
  padding: 0 10%;
  margin-top: -80px;
  position: relative;
  z-index: 10;
}
.methods-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 30px;
}
.method-card {
  background: var(--ivory);
  padding: 50px 40px;
  text-align: center;
  border: 1px solid rgba(201,168,76,0.2);
  box-shadow: 0 20px 40px rgba(0,0,0,0.1);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  position: relative;
  overflow: hidden;
}
.method-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: var(--gold);
  transform: scaleX(0);
  transition: transform 0.4s ease;
}
.method-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 30px 60px rgba(0,0,0,0.15);
}
.method-card:hover::before {
  transform: scaleX(1);
}
.method-icon {
  width: 64px;
  height: 64px;
  margin: 0 auto 30px;
  color: var(--gold);
}
.method-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.6rem;
  font-weight: 400;
  color: var(--forest);
  margin-bottom: 16px;
}
.method-desc {
  font-size: 1rem;
  line-height: 1.7;
  color: var(--text-mid);
  margin-bottom: 24px;
}
.method-link, .method-text {
  font-family: 'Jost', sans-serif;
  font-size: 1rem;
  letter-spacing: 0.1em;
  color: var(--rust);
  text-decoration: none;
  font-weight: 500;
  transition: color 0.3s;
}
.method-link:hover {
  color: var(--forest);
}

/* SPLIT FORM SECTION */
.inquiry-section {
  display: grid;
  grid-template-columns: 1fr 1.2fr;
  padding: 140px 0 140px 10%;
  background: var(--ivory);
  align-items: center;
  gap: 80px;
}
.inquiry-visual {
  position: relative;
  height: 700px;
}
.visual-img {
  position: absolute;
  inset: 0;
  background-position: center;
  background-size: cover;
  box-shadow: -30px 30px 0 rgba(201,168,76,0.15);
}
.visual-badge {
  position: absolute;
  bottom: 40px;
  right: -40px;
  width: 160px;
  height: 160px;
  background: var(--forest);
  border-radius: 50%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: var(--ivory);
  text-align: center;
  border: 4px solid var(--ivory);
  box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}
.visual-badge span {
  font-size: 1rem;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  color: var(--gold);
}
.visual-badge em {
  font-family: 'Playfair Display', serif;
  font-size: 1.8rem;
  line-height: 1.2;
}

.inquiry-form-container {
  padding-right: 15%;
}

/* PREMIUM FORM STYLES */
.premium-form {
  display: flex;
  flex-direction: column;
  gap: 30px;
}
.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 30px;
}
.input-container {
  position: relative;
  width: 100%;
}
.input-container input,
.input-container select,
.input-container textarea {
  width: 100%;
  background: transparent;
  border: none;
  border-bottom: 1px solid rgba(26,31,26,0.2);
  padding: 16px 0 8px;
  font-family: 'Jost', sans-serif;
  font-size: 1rem;
  color: var(--text-dark);
  outline: none;
  transition: border-color 0.3s;
}
.input-container select {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  cursor: pointer;
  background: transparent;
}
.input-container textarea {
  resize: vertical;
  min-height: 100px;
}

/* Floating Label Logic */
.input-container label {
  position: absolute;
  top: 16px;
  left: 0;
  font-size: 1rem;
  color: var(--text-mid);
  transition: all 0.3s ease;
  pointer-events: none;
  text-transform: uppercase;
  letter-spacing: 0.1em;
}
.input-container input:focus ~ label,
.input-container input:not(:placeholder-shown) ~ label,
.input-container textarea:focus ~ label,
.input-container textarea:not(:placeholder-shown) ~ label,
.select-label {
  top: -10px;
  font-size: 1rem;
  color: var(--gold);
  font-weight: 500;
}

.input-line {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 2px;
  background: var(--gold);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.4s ease;
}
.input-container input:focus ~ .input-line,
.input-container select:focus ~ .input-line,
.input-container textarea:focus ~ .input-line {
  transform: scaleX(1);
}

.submit-btn {
  margin-top: 20px;
  align-self: flex-start;
  background: var(--forest);
  color: var(--gold);
  border: none;
  padding: 18px 40px;
  font-family: 'Jost', sans-serif;
  font-size: 1rem;
  letter-spacing: 0.25em;
  text-transform: uppercase;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 16px;
  position: relative;
  overflow: hidden;
  transition: all 0.4s;
}
.submit-btn::before {
  content: '';
  position: absolute;
  inset: 0;
  background: var(--gold);
  transform: translateX(-100%);
  transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  z-index: 1;
}
.submit-btn:hover::before {
  transform: translateX(0);
}
.submit-btn:hover {
  color: var(--forest);
}
.submit-btn span {
  position: relative;
  z-index: 2;
  transition: color 0.4s;
}
.btn-arrow {
  font-size: 1.2rem;
  transition: transform 0.4s;
}
.submit-btn:hover .btn-arrow {
  transform: translateX(5px);
}


/* MAP SECTION */
.map-section {
  position: relative;
  width: 100%;
  height: 60vh;
  min-height: 500px;
  background: var(--forest);
}
.map-container {
  width: 100%;
  height: 100%;
  filter: grayscale(80%) sepia(30%) hue-rotate(70deg) contrast(1.1) brightness(0.6);
  transition: filter 0.8s ease;
}
.map-section:hover .map-container {
  filter: grayscale(40%) sepia(20%) hue-rotate(70deg) contrast(1.1) brightness(0.8);
}
.map-overlay {
  position: absolute;
  top: 50%;
  left: 10%;
  transform: translateY(-50%);
  background: rgba(14,31,14,0.95);
  padding: 50px;
  border-left: 3px solid var(--gold);
  z-index: 2;
  backdrop-filter: blur(10px);
  max-width: 400px;
}
.map-overlay h3 {
  font-family: 'Playfair Display', serif;
  font-size: 2rem;
  font-weight: 400;
  color: var(--ivory);
  margin-bottom: 12px;
}
.map-overlay p {
  font-size: 1rem;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: var(--gold);
}


/* RESPONSIVE */
@media (max-width: 1024px) {
  .methods-grid {
    grid-template-columns: 1fr;
    gap: 20px;
  }
  .inquiry-section {
    grid-template-columns: 1fr;
    padding: 100px 5%;
  }
  .inquiry-visual {
    height: 400px;
    margin-bottom: 40px;
  }
  .visual-img {
    box-shadow: none;
  }
  .inquiry-form-container {
    padding-right: 0;
  }
  .map-overlay {
    bottom: 5%;
    top: auto;
    left: 5%;
    right: 5%;
    transform: none;
    max-width: none;
  }
}
@media (max-width: 640px) {
  .form-row {
    grid-template-columns: 1fr;
  }
  .hero-title {
    font-size: 3rem;
  }
}
</style>
