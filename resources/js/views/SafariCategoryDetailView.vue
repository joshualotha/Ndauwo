<template>
  <div class="safari-detail" v-if="cat" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">

    <!-- 1. Photo Hero, full-width, minimal overlay -->
    <header class="detail-hero premium-hero" style="height: 72vh; min-height: 520px;">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.55) 0%, rgba(10, 10, 10, 0.35) 45%, rgba(10, 10, 10, 0.75) 100%), url(${getImage('hero_bg', cat.heroImage)})` }"></div>
      <div class="hero-caption-bar">
        <span class="kicker">{{ cat.kicker }}</span>
        <h1 class="hero-title" v-html="cat.title"></h1>
      </div>
    </header>

    <!-- 2. Introduction / Ethos -->
    <section class="detail-ethos" v-reveal>
      <div class="ethos-inner">
        <div class="ethos-label">
          <span class="section-num">01</span>
          <span class="section-name">The Experience</span>
        </div>
        <div class="ethos-body">
          <h2 class="ethos-headline" v-html="cat.philosophyHeadline"></h2>
          <p v-for="(p, i) in cat.philosophyText" :key="i" class="ethos-text">{{ p }}</p>
        </div>
      </div>
    </section>

    <!-- 3. Inline Gallery (two photos, offset) -->
    <section class="detail-gallery" v-if="cat.galleryImages">
      <div class="gallery-inner">
        <figure class="gallery-fig fig-left" v-reveal>
          <img :src="cat.galleryImages[0]" :alt="cat.title + ' landscape'">
          <figcaption>Tanzania · Photography by Ndauwo</figcaption>
        </figure>
        <figure class="gallery-fig fig-right" v-reveal style="transition-delay:0.15s">
          <img :src="cat.galleryImages[1]" :alt="cat.title + ' detail'">
          <figcaption>In the field · Ndauwo Safari Co.</figcaption>
        </figure>
      </div>
    </section>

    <!-- 4. Hallmarks, Numbered editorial list -->
    <section class="detail-hallmarks">
      <div class="hallmarks-inner">
        <div class="hallmarks-head" v-reveal>
          <span class="section-num">02</span>
          <span class="section-name">What Sets This Apart</span>
          <div class="head-rule"></div>
        </div>

        <div
          class="hallmark-item"
          v-for="(h, i) in cat.hallmarks"
          :key="i"
          v-reveal
          :style="{ transitionDelay: `${i * 0.1}s` }"
        >
          <div class="hallmark-photo">
            <img :src="h.image" :alt="h.title" loading="lazy">
          </div>
          <div class="hallmark-text-block">
            <div class="hallmark-head-row">
              <span class="hallmark-num">{{ String(i + 1).padStart(2, '0') }}</span>
              <h3 class="hallmark-title">{{ h.title }}</h3>
            </div>
            <p class="hallmark-desc">{{ h.desc }}</p>
          </div>
          <div class="hallmark-rule" v-if="i < cat.hallmarks.length - 1"></div>
        </div>
      </div>
    </section>

    <!-- 5. CTA -->
    <section class="detail-cta" v-reveal>
      <div class="cta-inner">
        <div class="cta-rule"></div>
        <p class="cta-label">Ready to begin?</p>
        <h2 class="cta-title">Build Your <em>Itinerary</em></h2>
        <p class="cta-sub">Speak with an Ndauwo expedition planner to shape this experience around your travel dates, interests, and pace.</p>
        <router-link to="/contact" class="cta-btn">Start a Conversation →</router-link>
      </div>
    </section>

  </div>

  <!-- Not found -->
  <div v-else class="not-found-page">
    <p>Experience not found.</p>
    <router-link to="/safari-types">← All Safari Types</router-link>
  </div>
</template>

<script setup>
import { computed, watch, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { usePageImages } from '../composables/usePageImages'

const route = useRoute()

const { fetchImages, getImage } = usePageImages(route.params.slug);

watch(() => route.params.slug, (newSlug) => {
  if (newSlug) {
    // Re-initialize or re-fetch for the new slug when route changes
    const newPageImages = usePageImages(newSlug);
    newPageImages.fetchImages();
  }
});

onMounted(() => {
  fetchImages();
});

const categoryDatabase = {
  'mountain-hiking': {
    kicker: 'Mountain Trekking',
    title: 'Kilimanjaro &<br><em>Mount Meru</em>',
    heroImage: '/image-14.jpg',
    philosophyHeadline: 'Why Climb With <em>Elysora?</em>',
    philosophyText: [
      "Your safety and success are our top priorities. We invest in the best equipment, regular training, and ethical treatment of our porters.",
      "The summit of Kilimanjaro is a genuine physical undertaking. We approach it as an expedition, prioritizing acclimatization above speed, and comfort above cutting corners."
    ],
    galleryImages: [
      '/image-06.jpg',
      '/image-17.jpg'
    ],
    hallmarks: [
      {
        title: 'Machame Route',
        desc: 'Known as the "Whiskey Route," Machame offers scenic variety and a superb climb-high, sleep-low acclimatization profile. It is challenging, beautiful, and among the most rewarding ways to reach Uhuru Peak.',
        image: '/image-04.jpg'
      },
      {
        title: 'Lemosho Route',
        desc: 'Considered the most beautiful approach on Kilimanjaro. Starting on the quieter western slopes and crossing the Shira Plateau, Lemosho offers solitude in the early days and a high summit success rate.',
        image: '/image-08.jpg'
      },
      {
        title: 'Mount Meru, The Warm-Up',
        desc: 'At 4,562m, Mount Meru is often overlooked. This 3–4 day trek rewards climbers with spectacular views of Kilimanjaro and is the ideal acclimatization run before attempting Africa\'s highest summit.',
        image: '/image-09.jpg'
      }
    ]
  },
  'cultural-tours': {
    kicker: 'Cultural Tours',
    title: 'More Than<br><em>Just Wildlife</em>',
    heroImage: '/image-14.jpg',
    philosophyHeadline: 'The Real <em>Tanzania</em>',
    philosophyText: [
      "Wildlife is only one layer of what Tanzania offers. Our cultural tours place you in direct, honest dialogue with the people who have shaped this land for thousands of years.",
      "These are not staged performances. We work from long-standing relationships with the Maasai, the Hadzabe, and Swahili coastal communities to offer encounters that feel genuine and leave a lasting impression."
    ],
    galleryImages: [
      '/image-14.jpg',
      '/image-09.jpg'
    ],
    hallmarks: [
      {
        title: 'Maasai Boma Visit',
        desc: 'Visit a traditional Boma in Longido or Ngorongoro. Learn about the pastoral lifestyle, assist with cattle milking, and listen to elders share stories around the fire. Traditional dances, beadwork workshops, and village walks included.',
        image: '/image-15.jpg'
      },
      {
        title: 'Hadzabe Hunting',
        desc: 'Journey to Lake Eyasi to meet the Hadzabe, one of the last true hunter-gatherer tribes in Africa. Join a morning hunt, learn their unique click language, and practice bow and arrow skills alongside bush food foraging.',
        image: '/image-16.jpg'
      },
      {
        title: 'Swahili Coastal Culture',
        desc: 'Explore the rich cultural mix of Zanzibar\'s Stone Town, take a spice plantation tour, and cook Swahili dishes in a family kitchen. It rounds off any safari with a completely different, deeply layered Tanzanian perspective.',
        image: '/image-17.jpg'
      }
    ]
  },
  'luxury-safari': {
    kicker: 'Luxury & Fly-In Safaris',
    title: 'Uncompromising<br><em>Comfort in the Wild</em>',
    heroImage: '/image-02.jpg',
    philosophyHeadline: 'A Luxury Safari Is About<br><em>More Than the Lodge</em>',
    philosophyText: [
      "A luxury safari isn't just about premium accommodation, it's about seamless service, exclusive access, and making the most of every hour you spend in the bush.",
      "Fly-in safaris connect remote parks by light aircraft, saving hours on dusty roads and arriving fresh at lodges where every detail, from the ice in your drink to the timing of your game drive, is curated."
    ],
    galleryImages: [
      '/image-05.jpg',
      '/image-17.jpg'
    ],
    hallmarks: [
      {
        title: 'Fly-In Convenience',
        desc: 'Maximize your game viewing by moving between parks via light aircraft. You arrive rested, oriented, and ready, rather than spending hours on corrugated roads.',
        image: '/image-17.jpg'
      },
      {
        title: 'Exclusive Lodges',
        desc: 'We work with a curated selection of lodges offering private plunge pools, dedicated butler service, and genuine bush immersion, places where the design is thoughtful and the wilderness is right outside your tent.',
        image: '/image-09.jpg'
      },
      {
        title: 'Gourmet Dining in the Field',
        desc: 'Bush breakfasts, sundowners on a kopje, candlelit dinners under the stars. Fine food and wine are part of the experience, not an afterthought.',
        image: '/image-17.jpg'
      }
    ]
  },
  'tailor-made-safari': {
    kicker: 'Tailor-Made Safaris',
    title: 'Defined<br><em>by You</em>',
    heroImage: '/image-01.jpg',
    philosophyHeadline: 'No Two<br><em>Travelers Are the Same</em>',
    philosophyText: [
      "Our tailor-made safaris are built entirely around you, your travel dates, your pace, your curiosity, and your group. We start from a blank page every time.",
      "A consultation, a proposal, a refinement, and then a flawless departure. You are in control of the narrative from start to finish."
    ],
    galleryImages: [
      '/image-14.jpg',
      '/image-03.jpg'
    ],
    hallmarks: [
      {
        title: 'For Photographers',
        desc: 'Extended time at individual sightings, specialist vehicles with bean bags and unobstructed angles, and guides with a genuine eye for light and behavior.',
        image: '/image-12.jpg'
      },
      {
        title: 'For Honeymooners',
        desc: 'Complete privacy, surprise sundowners, star-bed nights, and the freedom to do nothing at all if that\'s what the moment calls for.',
        image: '/image-03.jpg'
      },
      {
        title: 'For Families',
        desc: 'Anchored in one location for several nights, with bush walks scaled to young legs, shorter drives, and private camp access so children can set the pace.',
        image: '/image-07.jpg'
      }
    ]
  },
  'zanzibar-beach-safari': {
    kicker: 'Zanzibar Beach Safari',
    title: 'The Spice<br><em>Island</em>',
    heroImage: '/image-13.jpg',
    philosophyHeadline: 'Where the Scent of Cloves<br><em>Fills the Air</em>',
    philosophyText: [
      "The perfect end to any Tanzania safari. Zanzibar operates at a slower pace, dhow sailing, stone town wandering, cold drinks on white sand, and it offers an entirely different dimension of the country.",
      "From the lively north to the tranquil east coast to private island retreats, we find the Zanzibar that fits your rhythm."
    ],
    galleryImages: [
      '/image-19.jpg',
      '/image-06.jpg'
    ],
    hallmarks: [
      {
        title: 'Choose Your Coast',
        desc: 'Nungwi and Kendwa offer vibrant sunsets and good snorkeling; Matemwe and Paje offer quieter, wind-swept beaches; Mnemba and Thanda Island offer complete seclusion.',
        image: '/image-14.jpg'
      },
      {
        title: 'Spice Farm & History',
        desc: 'A spice farm tour reveals exactly how Zanzibar earned its name, cloves, cardamom, vanilla, and pepper grown in shaded groves. Pair it with a walking tour of Stone Town\'s UNESCO-listed streets.',
        image: '/image-03.jpg'
      },
      {
        title: 'Stone Town Walking Tour',
        desc: 'Narrow limestone alleys, carved wooden doors, bustling markets, and a layered history of Arab, Indian, and African influence. One of East Africa\'s most compelling urban experiences.',
        image: '/image-15.jpg'
      }
    ]
  },
  'group-safari': {
    kicker: 'Group Safaris',
    title: 'Shared<br><em>Journeys</em>',
    heroImage: '/image-01.jpg',
    philosophyHeadline: 'The Best Value Way<br><em>to See Tanzania</em>',
    philosophyText: [
      "Our group safaris are designed for solo travelers, couples on a budget, and anyone who enjoys the energy of a small group. By sharing vehicle and guide costs, you get a genuinely premium experience at a fraction of the private price.",
      "We limit every vehicle to six people, so it never feels crowded, and everyone gets a window seat."
    ],
    galleryImages: [
      '/image-19.jpg',
      '/image-16.jpg'
    ],
    hallmarks: [
      {
        title: 'Maximum Six Per Vehicle',
        desc: 'Everyone gets a window seat, access to the pop-up roof for open-air game viewing, and space for camera bags. A small group feels personal.',
        image: '/image-06.jpg'
      },
      {
        title: 'Save Up to 40%',
        desc: 'Shared logistics mean private-standard guides and vehicles at a significantly lower cost than booking independently. Fixed departure dates also make travel planning simple.',
        image: '/image-07.jpg'
      },
      {
        title: 'Meet the World',
        desc: 'Our group safaris bring together travelers from across the globe. The shared sightings, campfire evenings, and long drives have a way of creating lasting friendships.',
        image: '/image-10.jpg'
      }
    ]
  }
}

const cat = computed(() => categoryDatabase[route.params.slug])
</script>

<style scoped>
/* === BASE === */
.safari-detail {
  background: var(--ivory);
  min-height: 100vh;
  font-family: 'Jost', sans-serif;
  color: #1A1A1A;
  overflow-x: hidden;
}

/* === 1. HERO === */
.detail-hero {
  position: relative;
  height: 72vh;
  min-height: 520px;
}
.hero-photo-removed {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
}
.hero-caption-bar {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background: var(--ivory);
  padding: 32px 7%;
  display: flex;
  align-items: baseline;
  gap: 40px;
}
.kicker {
  font-size: 0.72rem;
  letter-spacing: 0.35em;
  text-transform: uppercase;
  color: #B5633A;
  font-weight: 500;
  white-space: nowrap;
  flex-shrink: 0;
}
.hero-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.2rem, 4.5vw, 4rem);
  font-weight: 400;
  color: #1A1A1A;
  line-height: 1.1;
  margin: 0;
}
:deep(.hero-title em) {
  font-style: italic;
  color: #B5633A;
}

/* === 2. ETHOS === */
.detail-ethos {
  padding: 100px 7%;
  border-bottom: 1px solid #D9CFC0;
}
.ethos-inner {
  max-width: 1280px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 180px 1fr;
  gap: 80px;
  align-items: flex-start;
}
.ethos-label {
  display: flex;
  flex-direction: column;
  gap: 8px;
  padding-top: 6px;
}
.section-num {
  font-size: 0.65rem;
  letter-spacing: 0.25em;
  color: #B5633A;
  font-weight: 600;
}
.section-name {
  font-size: 0.7rem;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: #7A8C6E;
  font-weight: 500;
}
.ethos-headline {
  font-family: 'Playfair Display', serif;
  font-size: clamp(1.8rem, 3vw, 2.8rem);
  font-weight: 400;
  color: #1A1A1A;
  line-height: 1.25;
  margin: 0 0 36px;
}
:deep(.ethos-headline em) {
  font-style: italic;
  color: #B5633A;
}
.ethos-text {
  font-size: 1.15rem;
  line-height: 1.9;
  color: #3A3A3A;
  font-weight: 300;
  margin-bottom: 24px;
}
.ethos-text:last-child { margin-bottom: 0; }

/* === 3. GALLERY === */
.detail-gallery {
  padding: 0 7% 100px;
  background: var(--ivory);
}
.gallery-inner {
  max-width: 1280px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 32px;
  align-items: flex-start;
}
.gallery-fig {
  margin: 0;
}
.fig-right {
  margin-top: 80px;
}
.gallery-fig img {
  width: 100%;
  display: block;
  object-fit: cover;
}
.fig-left img {
  aspect-ratio: 3/4;
}
.fig-right img {
  aspect-ratio: 4/3;
}
.gallery-fig figcaption {
  font-size: 0.72rem;
  letter-spacing: 0.1em;
  color: #9A9080;
  padding-top: 10px;
  border-top: 1px solid #D9CFC0;
  margin-top: 12px;
  font-weight: 400;
}

/* === 4. HALLMARKS === */
.detail-hallmarks {
  background: #EDE8DE;
  padding: 100px 7%;
}
.hallmarks-inner {
  max-width: 1280px;
  margin: 0 auto;
}
.hallmarks-head {
  display: flex;
  align-items: center;
  gap: 24px;
  margin-bottom: 80px;
}
.head-rule {
  flex: 1;
  height: 1px;
  background: #D9CFC0;
}

/* Each hallmark */
.hallmark-item {
  display: grid;
  grid-template-columns: 420px 1fr;
  gap: 60px;
  margin-bottom: 80px;
  align-items: flex-start;
  position: relative;
}
.hallmark-photo {
  width: 100%;
  aspect-ratio: 4/3;
  overflow: hidden;
}
.hallmark-photo img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.8s ease;
}
.hallmark-item:hover .hallmark-photo img {
  transform: scale(1.03);
}
.hallmark-text-block {
  padding-top: 12px;
}
.hallmark-head-row {
  display: flex;
  align-items: flex-start;
  gap: 20px;
  margin-bottom: 20px;
}
.hallmark-num {
  font-size: 0.65rem;
  letter-spacing: 0.2em;
  color: #B5633A;
  font-weight: 600;
  padding-top: 8px;
  flex-shrink: 0;
}
.hallmark-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(1.6rem, 2.5vw, 2.2rem);
  font-weight: 400;
  line-height: 1.2;
  color: #1A1A1A;
  margin: 0;
}
.hallmark-desc {
  font-size: 1.1rem;
  line-height: 1.9;
  color: #3A3A3A;
  font-weight: 300;
  margin: 0;
}
.hallmark-rule {
  grid-column: 1 / -1;
  height: 1px;
  background: #D9CFC0;
  margin-bottom: 80px;
  margin-top: -20px;
}

/* === 5. CTA === */
.detail-cta {
  padding: 120px 7%;
  background: var(--ivory);
  text-align: center;
}
.cta-inner {
  max-width: 640px;
  margin: 0 auto;
}
.cta-rule {
  width: 40px;
  height: 1px;
  background: #B5633A;
  margin: 0 auto 32px;
}
.cta-label {
  font-size: 0.72rem;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  color: #7A8C6E;
  margin-bottom: 16px;
  font-weight: 500;
}
.cta-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.2rem, 4vw, 3.2rem);
  font-weight: 400;
  color: #1A1A1A;
  margin: 0 0 24px;
  line-height: 1.15;
}
.cta-title em { font-style: italic; color: #B5633A; }
.cta-sub {
  font-size: 1.05rem;
  line-height: 1.8;
  color: #4A4A4A;
  font-weight: 300;
  margin-bottom: 40px;
}
.cta-btn {
  display: inline-block;
  padding: 16px 40px;
  border: 1px solid #1A1A1A;
  color: #1A1A1A;
  text-decoration: none;
  font-size: 0.82rem;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  font-weight: 500;
  transition: background 0.3s, color 0.3s;
}
.cta-btn:hover {
  background: #1A1A1A;
  color: var(--ivory);
}

/* === NOT FOUND === */
.not-found-page {
  height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: var(--ivory);
  gap: 20px;
  font-family: 'Jost', sans-serif;
}

/* === RESPONSIVE === */
@media (max-width: 1024px) {
  .ethos-inner { grid-template-columns: 1fr; gap: 40px; }
  .hallmark-item { grid-template-columns: 1fr; }
  .hallmark-rule { margin-top: 0; }
  .gallery-inner { grid-template-columns: 1fr; }
  .fig-right { margin-top: 0; }
  .fig-right img { aspect-ratio: 3/2; }
  .detail-hero { height: 60vh; }
  .hero-caption-bar { padding: 28px 5%; }
}
@media (max-width: 768px) {
  .detail-hero { height: 55vh; min-height: 380px; }
  .hero-caption-bar { flex-direction: column; gap: 10px; padding: 24px 5%; }
  .detail-ethos, .detail-gallery, .detail-cta { padding: 60px 5%; }
  .detail-hallmarks { padding: 60px 5%; }
  .ethos-title { font-size: 1.8rem; }
  .ethos-body { font-size: 1rem; }
  .hallmark-item { padding: 24px 0; }
  .h-body p { font-size: 0.95rem; }
  .gal-caption { font-size: 0.95rem; }
  .cta-title { font-size: clamp(1.8rem, 6vw, 2.5rem); }
  .cta-sub { font-size: 1rem; }
}
@media (max-width: 640px) {
  .detail-hero { min-height: 340px; }
  .hero-title { font-size: clamp(2rem, 10vw, 3.5rem); }
  .detail-ethos, .detail-gallery, .detail-cta { padding: 40px 5%; }
  .detail-hallmarks { padding: 40px 5%; }
  .ethos-title { font-size: 1.5rem; }
  .ethos-body { font-size: 0.95rem; line-height: 1.7; }
  .hallmark-num { font-size: 1.5rem; }
  .hallmark-name { font-size: 1.2rem; }
  .gallery-inner { gap: 20px; }
  .fig-right img { aspect-ratio: 4/3; }
  .cta-btn { display: block; text-align: center; padding: 14px 28px; font-size: 0.75rem; }
}
@media (max-width: 480px) {
  .detail-hero { min-height: 300px; }
  .hero-title { font-size: 2rem; }
  .hero-caption-bar { padding: 20px 4%; }
  .hero-caption { font-size: 0.8rem; }
  .detail-ethos, .detail-gallery, .detail-cta { padding: 32px 4%; }
  .detail-hallmarks { padding: 32px 4%; }
  .ethos-title { font-size: 1.3rem; }
  .hallmark-name { font-size: 1.1rem; }
  .cta-title { font-size: 1.5rem; }
}
@media (max-width: 375px) {
  .detail-hero { min-height: 280px; }
  .detail-ethos, .detail-gallery, .detail-cta { padding: 24px 4%; }
  .detail-hallmarks { padding: 24px 4%; }
  .ethos-title { font-size: 1.1rem; }
}
</style>
