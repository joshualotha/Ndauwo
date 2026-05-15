<template>
  <div class="page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    <!-- Premium Hero Section -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label">✦ The Turquoise Coast</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Zanzibar ', class: 'white' },
            { text: 'Retreats', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="hero-subtitle">
          Azure waters, spice-scented air, and the ultimate post-safari sanctuary.
        </p>
      </div>
    </section>

    <section class="statement" ref="s1">
      <div class="statement-inner">
        <span class="label">The Island</span>
        <h2>Beyond the<br>Safari</h2>
        <p>The perfect end to any Tanzania safari. Zanzibar operates at a slower pace, dhow sailing, limestone alleyways, cold drinks on white sand, offering a completely different and deeply layered dimension of the country. We find the Zanzibar that fits your rhythm.</p>
      </div>
    </section>

    <div class="coasts" ref="cs">
      <div class="coast-item" v-for="c in coasts" :key="c.name">
        <img :src="c.image" :alt="c.name">
        <div class="coast-veil"></div>
        <div class="coast-copy">
          <span class="label">{{ c.label }}</span>
          <h3>{{ c.name }}</h3>
          <p>{{ c.desc }}</p>
        </div>
      </div>
    </div>

    <div class="photo-break" ref="pb1">
      <img :src="getImage('photo_break', '/image-08.jpg')" alt="Zanzibar beach">
      <div class="photo-text-overlay">
        <span class="label">The East Coast</span>
        <h3>White sand, turquoise water,<br>and the kind of silence<br>you travel to find.</h3>
      </div>
    </div>

    <section class="features" ref="s2">
      <div class="features-top">
        <span class="label">What to Do</span>
        <h2>Island<br>Experiences</h2>
      </div>
      <div class="feature-row" v-for="(f, i) in experiences" :key="i" :ref="el => rowRefs[i] = el">
        <div class="feature-photo"><img :src="f.image" :alt="f.name"></div>
        <div class="feature-copy">
          <span class="feature-num">0{{ i + 1 }}</span>
          <h3>{{ f.name }}</h3>
          <p>{{ f.desc }}</p>
        </div>
      </div>
    </section>

    <section class="cta-section" ref="cta">
      <div class="cta-photo" :style="{ backgroundImage: `url(${getImage('cta_bg', '/image-10.jpg')})` }"></div>
      <div class="cta-veil"></div>
      <div class="cta-copy">
        <span class="label">Plan Your Island Escape</span>
        <h2>Find Your<br><em>Zanzibar</em></h2>
        <router-link to="/contact" class="cta-btn">Enquire Now</router-link>
      </div>
    </section>
  </div>
</template>

<script setup>
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { ref, onMounted } from 'vue'
import { usePageImages } from '../../composables/usePageImages'

const { images, fetchImages, getImage } = usePageImages('zanzibar_beach');

const s1 = ref(null), cs = ref(null), pb1 = ref(null), s2 = ref(null), cta = ref(null)
const rowRefs = ref([])
const coasts = [
  { label: 'North Coast', name: 'Nungwi & Kendwa', desc: 'Vibrant, social, and excellent for swimming at all tides. Great sunsets and the most active beach scene on the island.', image: '/image-07.jpg' },
  { label: 'East Coast', name: 'Matemwe & Paje', desc: 'Quieter, wind-swept tidal flats and powder-white sand. Good kite-surfing and a genuinely relaxed, barefoot pace.', image: '/image-18.jpg' },
  { label: 'Private Islands', name: 'Mnemba & Thanda', desc: 'Absolute seclusion. Pristine coral reefs and intimate lodge settings for those who want Zanzibar without any crowds.', image: '/image-03.jpg' },
]
const experiences = [
  { name: 'Spice Farm Heritage', desc: 'Walk a working plantation and discover exactly how Zanzibar earned its name. Cloves, cardamom, vanilla, and pepper grow in shaded groves alongside banana, jackfruit, and ylang-ylang.', image: '/image-11.jpg' },
  { name: 'Stone Town Walking Tour', desc: 'Narrow limestone alleys, carved wooden doors, the House of Wonders, and the site of the last open slave market in the world. One of East Africa\'s most compelling urban experiences.', image: '/image-06.jpg' },
  { name: 'Dhow Sunset Cruise', desc: 'Sail out on a traditional wooden dhow as the sun drops toward the horizon. Cold drinks, calm water, and a sky that turns impossible shades of orange and violet.', image: '/image-16.jpg' },
]
onMounted(() => {
  fetchImages();
  const io = new IntersectionObserver(entries => { entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target) } }) }, { threshold: 0.06 })
  ;[s1, cs, pb1, s2, cta].forEach(r => r.value && io.observe(r.value))
  rowRefs.value.forEach(el => el && io.observe(el))
})
</script>

<style scoped>
.page { background: var(--ivory); color: var(--text-dark); font-family:'Jost',sans-serif; overflow-x:hidden; }
em { font-style:italic; color: var(--gold); }
.label { display:block; font-size:0.7rem; letter-spacing:0.4em; text-transform:uppercase; color: var(--gold); margin-bottom:24px; font-weight:500; }

/* HERO - Now using Global .premium-hero */

.statement { background: var(--ivory); padding:160px 8%; border-bottom:1px solid var(--ivory-dark); opacity:0; transform:translateY(40px); transition:opacity 1.4s ease,transform 1.4s cubic-bezier(0.16,1,0.3,1); }
.statement.in { opacity:1; transform:translateY(0); }
.statement-inner { max-width:1100px; margin:0 auto; }
.statement h2 { font-family:'Playfair Display',serif; font-size:clamp(3rem,6vw,6rem); font-weight:400; line-height:1.05; color: var(--text-dark); margin:0 0 48px; }
.statement p { font-size:1.15rem; line-height:1.9; color: var(--text-mid); font-weight:300; max-width:680px; }

.coasts { display:grid; grid-template-columns:repeat(3,1fr); gap:2px; opacity:0; transition:opacity 1.4s ease; }
.coasts.in { opacity:1; }
.coast-item { position:relative; overflow:hidden; }
.coast-item img { width:100%; height:85vh; object-fit:cover; display:block; transition:transform 1.5s ease; }
.coast-item:hover img { transform:scale(1.05); }
.coast-veil { position:absolute; inset:0; background:linear-gradient(to top, rgba(14,14,14,0.92) 0%, rgba(14,14,14,0.3) 50%, transparent 100%); }
.coast-copy { position:absolute; bottom:0; left:0; right:0; padding:40px 32px; }
.coast-copy h3 { font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:400; color:#FFFFFF; margin:0 0 12px; }
.coast-copy p { font-size:0.88rem; line-height:1.7; color:rgba(255, 255, 255, 0.6); font-weight:300; margin:0; }

.photo-break { overflow:hidden; position:relative; opacity:0; transition:opacity 1.5s ease; }
.photo-break.in { opacity:1; }
.photo-break img { width:100%; height:80vh; object-fit:cover; display:block; }
.photo-text-overlay { position:absolute; inset:0; display:flex; flex-direction:column; justify-content:flex-end; padding:80px 8%; background:linear-gradient(to top, rgba(14,14,14,0.85) 30%, transparent 70%); }
.photo-text-overlay h3 { font-family:'Playfair Display',serif; font-size:clamp(2rem,3.5vw,3.5rem); font-weight:400; color:#FFFFFF; line-height:1.3; margin:0; }

.features { background: var(--ivory); padding:160px 8%; }
.features-top { margin-bottom:100px; }
.features-top h2 { font-family:'Playfair Display',serif; font-size:clamp(3rem,5vw,5rem); font-weight:400; line-height:1.05; color: var(--text-dark); margin:0; }
.feature-row { display:grid; grid-template-columns:1fr 1fr; gap:0; margin-bottom:2px; opacity:0; transform:translateY(50px); transition:opacity 1.2s ease,transform 1.2s cubic-bezier(0.16,1,0.3,1); }
.feature-row.in { opacity:1; transform:translateY(0); }
.feature-row:nth-child(even) .feature-photo { order:2; }
.feature-row:nth-child(even) .feature-copy { order:1; }
.feature-photo { overflow:hidden; }
.feature-photo img { width:100%; height:100%; min-height:480px; object-fit:cover; display:block; transition:transform 1.2s ease; }
.feature-row:hover .feature-photo img { transform:scale(1.04); }
.feature-copy { background: var(--ivory-dark); padding:80px 60px; display:flex; flex-direction:column; justify-content:center; }
.feature-row:nth-child(odd) .feature-copy { background: var(--ivory); }
.feature-num { font-size:0.65rem; letter-spacing:0.3em; color: var(--gold); margin-bottom:20px; font-weight:600; }
.feature-copy h3 { font-family:'Playfair Display',serif; font-size:clamp(2rem,3vw,3rem); font-weight:400; color: var(--text-dark); margin:0 0 24px; line-height:1.15; }
.feature-copy p { font-size:1.05rem; line-height:1.9; color: var(--text-mid); font-weight:300; }

.cta-section { height:90vh; min-height:600px; position:relative; display:flex; align-items:flex-end; padding:0 8% 12vh; opacity:0; transition:opacity 1.4s ease; }
.cta-section.in { opacity:1; }
.cta-photo { position:absolute; inset:0; background-size:cover; background-position:center; }
.cta-veil { position:absolute; inset:0; background:linear-gradient(to top, rgba(14,14,14,0.88) 0%, rgba(14,14,14,0.3) 55%, transparent 100%); }
.cta-copy { position:relative; z-index:2; }
.cta-copy h2 { font-family:'Playfair Display',serif; font-size:clamp(3rem,6vw,6rem); font-weight:400; color:#FFFFFF; line-height:1.0; margin:0 0 48px; }
.cta-btn { display:inline-block; padding:18px 52px; border:1px solid var(--gold); color: var(--gold); text-decoration:none; font-size:0.82rem; letter-spacing:0.2em; text-transform:uppercase; transition:background 0.4s,color 0.4s; }
.cta-btn:hover { background: var(--gold); color: var(--ivory); }

@media(max-width:1024px) { .coasts{grid-template-columns:1fr;} .coast-item img{height:60vh;} .feature-row{grid-template-columns:1fr;} .feature-row:nth-child(even) .feature-photo,.feature-row:nth-child(even) .feature-copy{order:unset;} .feature-photo img{min-height:350px;} .feature-copy{padding:60px 5%;} }
@media(max-width:768px) { .hero h1{font-size:clamp(2.8rem,8vw,3.8rem);} .statement{padding:80px 5%;} .features{padding:80px 5%;} }
@media(max-width:480px) { .hero h1{font-size:2.5rem;} .hero-lead{font-size:0.95rem;} .statement h2{font-size:2.2rem;} .cta-copy h2{font-size:2.5rem;} .cta-btn{display:block;text-align:center;padding:18px 20px;} }
@media(max-width:375px) { .hero h1{font-size:2.1rem;} .statement,.features{padding:60px 4%;} }
</style>
