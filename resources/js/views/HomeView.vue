<template>
  <div class="home-view" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    <!-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
         HERO — Asilia-Inspired Editorial Hero
         ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ -->
    <section id="hero">
      <div
        class="hero-bg"
        :style="{
          backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.25) 0%, rgba(10, 10, 10, 0.08) 48%, rgba(10, 10, 10, 0.40) 100%), url(${getImage('hero_bg', 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=1920&q=80')})`,
          backgroundSize: 'cover',
          backgroundPosition: 'center center'
        }"
      ></div>
      <div class="hero-content">
        <p class="hero-eyebrow">Tanzania's Premier Safari Experience</p>
        <h1 class="hero-title" v-reveal>
          <div class="title-line-1">
            <HandwrittenTypewriter
              :phrases="[[
                { text: 'Where the ', class: 'white' },
                { text: 'Wilderness', class: 'em' }
              ]]"
              :startDelay="1500"
            />
          </div>
          <div class="title-line-2">
            <HandwrittenTypewriter
              :phrases="[[
                { text: 'Awaits You', class: 'white' }
              ]]"
              :startDelay="3200"
            />
          </div>
        </h1>
        <p class="hero-subtitle">
          Immerse yourself in the untamed beauty of East Africa. From the sweeping plains of the Serengeti to the summit of Kilimanjaro, curated journeys that transcend the ordinary.
        </p>
        <div class="hero-actions" v-reveal>
          <button class="btn-primary" @click="scrollTo('tours')"><span>Explore Safaris</span></button>
          <button class="btn-ghost" @click="scrollTo('about')">Our Story</button>
        </div>
      </div>

      <div class="hero-stats" v-reveal>
        <div class="stat"><div class="stat-num">15+</div><div class="stat-label">Years of Excellence</div></div>
        <div class="stat"><div class="stat-num">2,800+</div><div class="stat-label">Happy Travellers</div></div>
        <div class="stat"><div class="stat-num">98%</div><div class="stat-label">Satisfaction Rate</div></div>
      </div>
    </section>

    <!-- MARQUEE RIBBON -->
    <div class="marquee-ribbon">
      <div class="marquee-track">
        <span>Serengeti Migration</span><span class="dot">◆</span>
        <span>Ngorongoro Crater</span><span class="dot">◆</span>
        <span>Kilimanjaro Climbs</span><span class="dot">◆</span>
        <span>Zanzibar Retreats</span><span class="dot">◆</span>
        <span>Selous Game Reserve</span><span class="dot">◆</span>
        <span>Ruaha National Park</span><span class="dot">◆</span>
        <span>Tarangire Elephants</span><span class="dot">◆</span>
        <span>Lake Manyara</span><span class="dot">◆</span>
      </div>
    </div>

    <!-- ABOUT -->
    <section id="about">
      <div class="about-text reveal-left" v-reveal>
        <span class="about-label" style="color:var(--ebony)">✦ Our Heritage</span>
        <h2 class="about-heading" style="color:var(--ebony)">Born from the <em>Heart</em> of Tanzania</h2>
        <p class="about-body">Ndauwo was born from a deep love of the African wilderness. Founded in Arusha, the gateway to Tanzania's greatest wonders, we have spent over 15 years crafting journeys that honour both the magnificence of the land and the people who call it home.</p>
        <p class="about-body">Every safari we design is a collaboration between your dreams and our expertise. Our seasoned field teams, deep local knowledge, and passion for conservation ensure experiences that are as responsible as they are extraordinary.</p>
        <div class="about-signature">Ndauwo Safari Co.</div>
      </div>
      <div class="about-images reveal-right" v-reveal>
        <div class="about-img-main" :style="{ backgroundImage: `url(${getImage('about_primary', 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&q=80')})` }"></div>
        <div class="about-img-accent" :style="{ backgroundImage: `url(${getImage('about_secondary', 'https://images.unsplash.com/photo-1504432842672-1a79f78e4084?w=600&q=80')})` }"></div>
        <div class="about-badge">
          <span class="badge-num">15</span>
          <span class="badge-text">Years of<br>Excellence</span>
        </div>
      </div>
    </section>

    <!-- DESTINATIONS -->
    <section id="destinations">
      <div class="section-header reveal" v-reveal>
        <span class="section-label">Explore Tanzania</span>
        <h2 class="section-heading">Iconic <em>Destinations</em></h2>
      </div>
      <div v-if="loadingDestinations" class="loading-state">Loading destinations...</div>
      <div v-else class="destinations-grid">
        <div 
          v-for="(dest, index) in dests.slice(0, 5)" 
          :key="dest.id"
          class="dest-card reveal" 
          v-reveal
          :style="{ transitionDelay: `${index * 0.1}s` }"
        >
          <div class="dest-card-bg" :style="{ backgroundImage: `url(${getImageUrl(dest.image)})` }"></div>
          <div class="dest-card-overlay"></div>
          <div class="dest-info">
            <div class="dest-country">{{ dest.region || 'Tanzania' }}</div>
            <div class="dest-name">{{ dest.name }}</div>
            <div class="dest-desc">{{ (dest.description || '').substring(0, 120) }}...</div>
            <router-link :to="`/destinations/${dest.slug}`" class="dest-arrow" style="text-decoration:none;">Discover More</router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- EXPERIENCES -->
    <section id="experiences">
      <div class="section-header reveal" v-reveal>
        <span class="section-label" style="color:var(--ebony)">How We Journey</span>
        <h2 class="section-heading">Curated <em style="color:var(--rust)">Experiences</em></h2>
      </div>
      <div class="experiences-grid">
        <div class="exp-card reveal" v-reveal>
          <div class="exp-number">01</div><span class="exp-icon"><Sun :size="28" stroke-width="1.5" /></span>
          <h3 class="exp-title">Sunrise Game Drives</h3>
          <p class="exp-desc">Greet dawn on the savannah. Our expert field teams take you into the wild as Africa awakens, tracking the Big Five in golden morning light.</p>
        </div>
        <div class="exp-card reveal reveal-delay-1" v-reveal>
          <div class="exp-number">02</div><span class="exp-icon"><Compass :size="28" stroke-width="1.5" /></span>
          <h3 class="exp-title">Hot Air Balloon Safaris</h3>
          <p class="exp-desc">Float silently above the Serengeti at sunrise. A once-in-a-lifetime perspective of the plains stretching endlessly below you.</p>
        </div>
        <div class="exp-card reveal reveal-delay-2" v-reveal>
          <div class="exp-number">03</div><span class="exp-icon"><Tent :size="28" stroke-width="1.5" /></span>
          <h3 class="exp-title">Luxury Camp Stays</h3>
          <p class="exp-desc">Sleep under the stars in world-class mobile and permanent tented camps. Indulgence and wilderness in perfect harmony.</p>
        </div>
        <div class="exp-card reveal reveal-delay-3" v-reveal>
          <div class="exp-number">04</div><span class="exp-icon"><Mountain :size="28" stroke-width="1.5" /></span>
          <h3 class="exp-title">Kilimanjaro Summits</h3>
          <p class="exp-desc">Guided ascents via multiple routes. Our certified mountain teams ensure your safety and success on Africa's highest peak.</p>
        </div>
        <div class="exp-card reveal reveal-delay-4" v-reveal>
          <div class="exp-number">05</div><span class="exp-icon"><Footprints :size="28" stroke-width="1.5" /></span>
          <h3 class="exp-title">Walking Safaris</h3>
          <p class="exp-desc">Experience the bush on foot. Track animals through their environment in an intimate, immersive connection with nature.</p>
        </div>
        <div class="exp-card reveal reveal-delay-5" v-reveal>
          <div class="exp-number">06</div><span class="exp-icon"><Waves :size="28" stroke-width="1.5" /></span>
          <h3 class="exp-title">Zanzibar Escapes</h3>
          <p class="exp-desc">Combine your safari with a beach retreat. Spice tours, dhow sunset cruises, and pristine Indian Ocean shores await.</p>
        </div>
      </div>
    </section>

    <!-- TOURS -->
    <section id="tours">
      <div class="tours-intro">
        <div class="section-header reveal" v-reveal><span class="section-label">Our Offerings</span><h2 class="section-heading">Signature <em>Safari</em> Packages</h2></div>
        <div class="tours-filter reveal" v-reveal>
          <button class="filter-btn active">All Safaris</button>
          <button class="filter-btn">Wildlife</button><button class="filter-btn">Trekking</button><button class="filter-btn">Beach + Safari</button>
        </div>
      </div>
      <div v-if="loadingTours" class="loading-state">Loading safaris...</div>
      <div v-else class="tours-grid">
        <div 
          v-for="(tour, index) in tours.slice(0, 3)" 
          :key="tour.id"
          class="tour-card reveal" 
          v-reveal
          :style="{ transitionDelay: `${index * 0.1}s` }"
        >
          <div class="tour-img" :style="{ backgroundImage: `url(${getImageUrl(tour.featured_image)})` }">
            <div class="tour-badge" v-if="index === 0">Best Seller</div>
            <div class="tour-badge" v-else-if="index === 1">Popular</div>
            <div class="tour-badge" v-else>Luxury</div>
          </div>
          <div class="tour-body">
            <div class="tour-duration">⏱ {{ tour.duration }}</div>
            <h3 class="tour-name">{{ tour.title }}</h3>
            <p class="tour-desc">{{ (tour.description || '').substring(0, 100) }}...</p>
            <div class="tour-footer">
              <div>
                <div class="tour-price-from">From</div>
                <div class="tour-price">${{ formatPrice(tour.price) }}</div>
              </div>
              <router-link :to="`/safaris/${tour.id}`" class="tour-details-link">View Details →</router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="gallery">
      <div class="section-header reveal" v-reveal style="padding: 0 8%;"><span class="section-label">Visual Diary</span><h2 class="section-heading">Through Our <em>Lens</em></h2></div>
      
      <div v-if="loadingGallery" class="loading-state">Loading gallery...</div>
      <div v-else class="gallery-marquee">
        <div class="marquee-track">
          <!-- Duplicated items for seamless loop -->
          <template v-for="i in 2" :key="i">
            <div 
              v-for="(item, index) in galleryItems" 
              :key="item.id + '-' + i"
              class="gallery-item"
            >
              <img :src="getImageUrl(item.file_path)" :alt="item.title" class="gallery-image" />
              <div class="gallery-overlay"><span>{{ item.title }}</span></div>
            </div>
          </template>
        </div>
      </div>
    </section>

    <!-- TESTIMONIALS -->
    <section id="testimonials">
      <div class="section-header reveal" v-reveal>
        <span class="section-label" style="color:var(--ebony)">Guest Stories</span><h2 class="section-heading">Words From Our <em style="color:var(--rust)">Travellers</em></h2>
      </div>
      <div class="testimonials-carousel reveal" v-reveal>
        <div id="testimonialsTrack" class="testimonials-track">
          <div class="testimonial-card">
            <p class="testimonial-text">"Ndauwo didn't just plan our safari, they orchestrated a symphony of experiences. Every detail was considered, every surprise perfectly timed."</p>
            <div class="testimonial-author"><div class="author-avatar" :style="{ backgroundImage: `url(${getImage('testimonial_1', '/image-02.jpg')})` }"></div><div><div class="author-name">James & Sarah Mitchell</div><div class="author-origin">London, UK</div></div></div>
          </div>
          <div class="testimonial-card">
            <p class="testimonial-text">"The sunrise balloon ride over the Serengeti was transcendent. Ndauwo made everything seamless from landing to departure."</p>
            <div class="testimonial-author"><div class="author-avatar" :style="{ backgroundImage: `url(${getImage('testimonial_2', '/image-11.jpg')})` }"></div><div><div class="author-name">Emma van der Berg</div><div class="author-origin">Amsterdam</div></div></div>
          </div>
        </div>
        <div class="carousel-controls">
          <button class="carousel-btn" @click="slideCarousel(-1)">←</button>
          <button class="carousel-btn" @click="slideCarousel(1)">→</button>
        </div>
      </div>
    </section>

    <!-- WHY US -->
    <section id="why-us">
      <div class="why-grid">
        <div class="why-content">
          <div class="section-header" v-reveal><span class="section-label">Why Ndauwo</span><h2 class="section-heading">The Ndauwo <em>Difference</em></h2></div>
          <div class="why-list">
            <div class="why-item" v-reveal><div class="why-icon"><Compass :size="32" stroke-width="1.5" /></div><div><div class="why-text-title">Authentic Knowledge</div><div class="why-text-desc">Our field partners are born of this land. With naturalist expertise and decades of bush insight, they see what others miss.</div></div></div>
            <div class="why-item" v-reveal><div class="why-icon"><Shield :size="32" stroke-width="1.5" /></div><div><div class="why-text-title">Full Journey Support</div><div class="why-text-desc">From your first enquiry to your final farewell, a dedicated safari consultant is available 24/7 throughout your journey.</div></div></div>
            <div class="why-item" v-reveal><div class="why-icon"><Leaf :size="32" stroke-width="1.5" /></div><div><div class="why-text-title">Responsible Tourism</div><div class="why-text-desc">We are committed to conservation. A portion of every booking funds local wildlife initiatives.</div></div></div>
          </div>
        </div>
        <div class="why-visual" v-reveal>
          <div class="why-big-img" :style="{ backgroundImage: `url(${getImage('hero_overlay', '/image-06.jpg')})` }"></div>
          <div class="why-counter-bar">
            <div class="counter-item"><div class="counter-num" data-target="2800">0</div><div class="counter-label">Happy Guests</div></div>
            <div class="counter-item"><div class="counter-num" data-target="15">0</div><div class="counter-label">Years of Hub</div></div>
            <div class="counter-item"><div class="counter-num" data-target="98">0</div><div class="counter-label">% Satisfaction</div></div>
          </div>
        </div>
      </div>
    </section>

    <!-- CONTACT & BOOKING -->
    <section id="booking">
      <div class="booking-wrapper">
        <div class="booking-form" v-reveal>
          <h3 class="form-title">Begin Your Journey</h3>
          <div class="form-row"><div class="form-group"><label>First Name</label><input type="text" placeholder="John"/></div><div class="form-group"><label>Last Name</label><input type="text" placeholder="Smith"/></div></div>
          <div class="form-group"><label>Email Address</label><input type="email" placeholder="john@example.com"/></div>
          <button class="booking-submit">Send Safari Enquiry →</button>
        </div>
        <div class="booking-info" v-reveal>
          <div class="section-header" style="text-align:left;margin-bottom:30px;"><span class="section-label" style="color:var(--gold)">Start Planning</span><h2 class="section-heading" style="color:var(--forest)">Your Dream<br><em style="color:var(--rust)">Safari Awaits</em></h2></div>
          <p style="font-size: 1rem;color:var(--text-mid);margin-bottom:40px;">Fill in the enquiry form and your dedicated safari consultant will be in touch within 24 hours.</p>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import HandwrittenTypewriter from '../components/HandwrittenTypewriter.vue'
import { Sun, Compass, Tent, Mountain, Footprints, Waves, Utensils, PawPrint, Shield, Leaf } from 'lucide-vue-next'
import { usePageImages } from '../composables/usePageImages'
import { useSettings, API_BASE_URL } from '../composables/useSettings'

const { images, fetchImages, getImage } = usePageImages('home');
const { getImageUrl } = useSettings();

const dests = ref([])
const tours = ref([])
const galleryItems = ref([])
const loadingDestinations = ref(false)
const loadingTours = ref(false)
const loadingGallery = ref(false)

const scrollTo = (id) => {
  const el = document.getElementById(id)
  if (el) el.scrollIntoView({ behavior: 'smooth' })
}

const carouselIdx = ref(0)
const slideCarousel = (dir) => {
  const track = document.getElementById('testimonialsTrack')
  if(!track) return;
  const cards = track.querySelectorAll('.testimonial-card')
  if(!cards.length) return;
  const maxIdx = Math.max(0, cards.length - 1)
  carouselIdx.value = Math.max(0, Math.min(carouselIdx.value + dir, maxIdx))
  const cardW = cards[0].offsetWidth + 30
  track.style.transform = `translateX(-${carouselIdx.value * cardW}px)`
}

const formatPrice = (price) => {
  if (!price) return '0'
  return parseFloat(price).toLocaleString()
}

const fetchData = async () => {
  loadingDestinations.value = true
  loadingTours.value = true
  loadingGallery.value = true
  try {
    const [destRes, tourRes, galleryRes] = await Promise.all([
      axios.get(`${API_BASE_URL}/api/destinations`),
      axios.get(`${API_BASE_URL}/api/packages`),
      axios.get(`${API_BASE_URL}/api/gallery`)
    ])
    dests.value = destRes.data
    tours.value = tourRes.data
    galleryItems.value = galleryRes.data.filter(item => item.type === 'image')
  } catch (err) {
    console.error('Error fetching home data', err)
  } finally {
    loadingDestinations.value = false
    loadingTours.value = false
    loadingGallery.value = false
  }
}

const animateCounter = (el, target) => {
  let current = 0
  const step = target / 80
  const timer = setInterval(() => {
    current = Math.min(current + step, target)
    el.textContent = Math.floor(current).toLocaleString()
    if (current >= target) clearInterval(timer)
  }, 20)
}

onMounted(() => {
  fetchImages();
  fetchData();
  
  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        const els = document.querySelectorAll('.counter-num[data-target]')
        els.forEach(el => animateCounter(el, +el.dataset.target))
        counterObserver.disconnect()
      }
    })
  }, { threshold: 0.5 })
  const counterSection = document.querySelector('.why-counter-bar')
  if (counterSection) counterObserver.observe(counterSection)
  
  const btns = document.querySelectorAll('.filter-btn')
  btns.forEach(btn => {
    btn.addEventListener('click', () => {
      btns.forEach(b => b.classList.remove('active'))
      btn.classList.add('active')
    })
  })
})
</script>
