<template>
  <div class="page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    <!-- Premium Hero Section -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label">✦ Shared Discovery</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Group ', class: 'white' },
            { text: 'Departures', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="hero-subtitle">
          Collective wonder on pre-set dates. Uncompromised luxury, shared with like-minded explorers.
        </p>
      </div>
    </section>

    <section class="statement" ref="s1">
      <div class="statement-inner">
        <span class="label">Why Group?</span>
        <h2>The Best Value Way<br>to See Tanzania</h2>
        <p>Group safaris are designed for solo travelers, couples on a budget, and anyone who loves meeting people from around the world. By sharing vehicle and guide costs, you get a genuinely premium experience at a fraction of the private price. We limit every vehicle to six, so it never feels crowded, and everyone gets a window seat.</p>
      </div>
    </section>

    <div class="stats-bar" ref="sb">
      <div class="stat-block"><span class="stat-n">06</span><span class="stat-l">Maximum per vehicle</span></div>
      <div class="stat-div"></div>
      <div class="stat-block"><span class="stat-n">40%</span><span class="stat-l">Average savings vs private</span></div>
      <div class="stat-div"></div>
      <div class="stat-block"><span class="stat-n">360°</span><span class="stat-l">Open-roof game viewing</span></div>
      <div class="stat-div"></div>
      <div class="stat-block"><span class="stat-n">All year</span><span class="stat-l">Fixed departures available</span></div>
    </div>

    <div class="photo-break" ref="pb1">
      <img :src="getImage('photo_break', '/image-02.jpg')" alt="Safari vehicle">
      <div class="photo-text-overlay">
        <span class="label">Maximum Six</span>
        <h3>Everyone gets a window.<br>Everyone gets the shot.</h3>
      </div>
    </div>

    <section class="features" ref="s2">
      <div class="features-top">
        <span class="label">The Small Group Guarantee</span>
        <h2>What You<br>Can Expect</h2>
      </div>
      <div class="feature-row" v-for="(f, i) in features" :key="i" :ref="el => rowRefs[i] = el">
        <div class="feature-photo"><img :src="f.image" :alt="f.name"></div>
        <div class="feature-copy">
          <span class="feature-num">0{{ i + 1 }}</span>
          <h3>{{ f.name }}</h3>
          <p>{{ f.desc }}</p>
        </div>
      </div>
    </section>

    <div class="who-photo" ref="wp">
      <img :src="getImage('who_photo', '/image-08.jpg')" alt="Group safari">
      <div class="who-veil"></div>
      <div class="who-copy">
        <span class="label">Who Joins Our Groups?</span>
        <h2>Solo Travelers. Adventurous Couples.<br>First-Time Africa.</h2>
        <div class="who-tags">
          <span v-for="t in tags" :key="t">{{ t }}</span>
        </div>
      </div>
    </div>

    <section class="cta-section" ref="cta">
      <div class="cta-photo" :style="{ backgroundImage: `url(${getImage('cta_bg', '/image-15.jpg')})` }"></div>
      <div class="cta-veil"></div>
      <div class="cta-copy">
        <span class="label">Find Your Dates</span>
        <h2>Join a<br><em>Group Safari</em></h2>
        <router-link to="/contact" class="cta-btn">Check Availability</router-link>
      </div>
    </section>
  </div>
</template>

<script setup>
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { ref, onMounted } from 'vue'
import { usePageImages } from '../../composables/usePageImages'

const { images, fetchImages, getImage } = usePageImages('group_safari');

const s1 = ref(null), sb = ref(null), pb1 = ref(null), s2 = ref(null), wp = ref(null), cta = ref(null)
const rowRefs = ref([])
const features = [
  { name: 'Window Seat Guarantee', desc: 'Six passengers in a 7-seat vehicle means real space, for camera bags, day packs, jackets, and unobstructed sightlines during every game drive.', image: '/image-06.jpg' },
  { name: 'Expert Naturalist Guides', desc: 'The same specialist naturalist guides as our private safaris. Shared cost doesn\'t mean a reduced team, it means exactly the same standard for less investment.', image: '/image-04.jpg' },
  { name: 'Fixed Departures', desc: 'Book your flights around confirmed dates. No custom departure scheduling, just choose the window that works for you and join a small group of travelers doing the same.', image: '/image-18.jpg' },
]
const tags = ['Solo Travelers', 'Budget-Conscious Couples', 'Young Professionals', 'Gap Year Adventurers', 'Photography Enthusiasts', 'First-Time Africa Visitors']
onMounted(() => {
  fetchImages();
  const io = new IntersectionObserver(entries => { entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target) } }) }, { threshold: 0.06 })
  ;[s1, sb, pb1, s2, wp, cta].forEach(r => r.value && io.observe(r.value))
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

/* STATS BAR, gold bg */
.stats-bar { background: var(--gold); display:flex; align-items:stretch; opacity:0; transition:opacity 1.2s ease; }
.stats-bar.in { opacity:1; }
.stat-block { flex:1; padding:60px 48px; }
.stat-n { display:block; font-family:'Playfair Display',serif; font-size:clamp(3rem,4vw,4.5rem); font-weight:400; color: var(--ivory); line-height:1; margin-bottom:8px; }
.stat-l { font-size:0.72rem; letter-spacing:0.12em; text-transform:uppercase; color:rgba(255, 255, 255, 0.7); font-weight:500; }
.stat-div { width:1px; background:rgba(255, 255, 255, 0.25); }

.photo-break { overflow:hidden; position:relative; opacity:0; transition:opacity 1.5s ease; }
.photo-break.in { opacity:1; }
.photo-break img { width:100%; height:80vh; object-fit:cover; display:block; }
.photo-text-overlay { position:absolute; inset:0; display:flex; flex-direction:column; justify-content:flex-end; padding:80px 8%; background:linear-gradient(to top, rgba(14,14,14,0.88) 30%, transparent 70%); }
.photo-text-overlay h3 { font-family:'Playfair Display',serif; font-size:clamp(2rem,3.5vw,3.5rem); font-weight:400; color:#FFFFFF; line-height:1.3; margin:0; }

.features { background: var(--ivory); padding:160px 8%; }
.features-top { margin-bottom:100px; }
.features-top h2 { font-family:'Playfair Display',serif; font-size:clamp(3rem,5vw,5rem); font-weight:400; line-height:1.05; color: var(--text-dark); margin:0; }
.feature-row { display:grid; grid-template-columns:1fr 1fr; gap:0; margin-bottom:2px; opacity:0; transform:translateY(50px); transition:opacity 1.2s ease,transform 1.2s cubic-bezier(0.16,1,0.3,1); }
.feature-row.in { opacity:1; transform:translateY(0); }
.feature-row:nth-child(even) .feature-photo { order:2; }
.feature-row:nth-child(even) .feature-copy { order:1; }
.feature-photo { overflow:hidden; }
.feature-photo img { width:100%; height:100%; min-height:460px; object-fit:cover; display:block; transition:transform 1.2s ease; }
.feature-row:hover .feature-photo img { transform:scale(1.04); }
.feature-copy { background: var(--ivory-dark); padding:80px 60px; display:flex; flex-direction:column; justify-content:center; }
.feature-row:nth-child(odd) .feature-copy { background: var(--ivory); }
.feature-num { font-size:0.65rem; letter-spacing:0.3em; color: var(--gold); margin-bottom:20px; font-weight:600; }
.feature-copy h3 { font-family:'Playfair Display',serif; font-size:clamp(2rem,3vw,3rem); font-weight:400; color: var(--text-dark); margin:0 0 24px; line-height:1.15; }
.feature-copy p { font-size:1.05rem; line-height:1.9; color: var(--text-mid); font-weight:300; }

.who-photo { position:relative; overflow:hidden; opacity:0; transition:opacity 1.5s ease; }
.who-photo.in { opacity:1; }
.who-photo img { width:100%; height:90vh; object-fit:cover; display:block; }
.who-veil { position:absolute; inset:0; background:rgba(14,14,14,0.65); }
.who-copy { position:absolute; inset:0; display:flex; flex-direction:column; justify-content:center; padding:0 8%; }
.who-copy h2 { font-family:'Playfair Display',serif; font-size:clamp(2rem,4.5vw,5rem); font-weight:400; color:#FFFFFF; line-height:1.1; margin:0 0 48px; max-width:900px; }
.who-tags { display:flex; flex-wrap:wrap; gap:12px; }
.who-tags span { font-size:0.72rem; letter-spacing:0.15em; text-transform:uppercase; border:1px solid rgba(226,121,27,0.5); padding:8px 16px; color:rgba(255, 255, 255, 0.7); }

.cta-section { height:90vh; min-height:600px; position:relative; display:flex; align-items:flex-end; padding:0 8% 12vh; opacity:0; transition:opacity 1.4s ease; }
.cta-section.in { opacity:1; }
.cta-photo { position:absolute; inset:0; background-size:cover; background-position:center; }
.cta-veil { position:absolute; inset:0; background:linear-gradient(to top, rgba(14,14,14,0.88) 0%, rgba(14,14,14,0.3) 55%, transparent 100%); }
.cta-copy { position:relative; z-index:2; }
.cta-copy h2 { font-family:'Playfair Display',serif; font-size:clamp(3rem,6vw,6rem); font-weight:400; color:#FFFFFF; line-height:1.0; margin:0 0 48px; }
.cta-btn { display:inline-block; padding:18px 52px; border:1px solid var(--gold); color: var(--gold); text-decoration:none; font-size:0.82rem; letter-spacing:0.2em; text-transform:uppercase; transition:background 0.4s,color 0.4s; }
.cta-btn:hover { background: var(--gold); color: var(--ivory); }

@media(max-width:1024px) { .stats-bar{flex-direction:column;} .stat-div{width:auto;height:1px;} .feature-row{grid-template-columns:1fr;} .feature-row:nth-child(even) .feature-photo,.feature-row:nth-child(even) .feature-copy{order:unset;} .feature-photo img{min-height:350px;} .feature-copy{padding:60px 5%;} }
@media(max-width:768px) { .hero h1{font-size:clamp(2.8rem,8vw,3.5rem);} .statement{padding:80px 5%;} .features{padding:80px 5%;} .stat-block{padding:40px 28px;} .feature-copy{padding:48px 32px;} }
@media(max-width:480px) { .hero h1{font-size:2.5rem;} .hero-lead{font-size:0.95rem;} .statement h2{font-size:2.2rem;} .cta-copy h2{font-size:2.5rem;} .cta-btn{display:block;text-align:center;padding:18px 20px;} }
@media(max-width:375px) { .hero h1{font-size:2rem;} .statement,.features{padding:60px 4%;} }
</style>
