<template>
  <div class="page" @mouseenter="$emit('hover-enter')" @mouseleave="$emit('hover-leave')">
    <!-- Premium Hero Section -->
    <section class="premium-hero">
      <div class="premium-hero-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(10, 10, 10, 0.75) 0%, rgba(10, 10, 10, 0.45) 45%, rgba(10, 10, 10, 0.85) 100%), url(${getImage('hero_bg')})` }"></div>
      <div class="premium-hero-content">
        <span class="hero-label">✦ Living Heritage</span>
        <h1 class="hero-title">
          <HandwrittenTypewriter :phrases="[[
            { text: 'Cultural ', class: 'white' },
            { text: 'Expeditions', class: 'orange' }
          ]]" :startDelay="500" />
        </h1>
        <p class="hero-subtitle">
          Immersion beyond the visual. Authentic connections with the soul of Tanzania.
        </p>
      </div>
    </section>

    <section class="statement" ref="s1">
      <div class="statement-inner">
        <span class="label">The Experience</span>
        <h2>The Real<br>Tanzania</h2>
        <p>Wildlife is only one layer of what Tanzania offers. Our cultural tours place you in direct, honest dialogue with the people who have shaped this land for thousands of years. These are not staged performances, we work from long-standing relationships to offer encounters that feel genuine.</p>
      </div>
    </section>

    <div class="split-section" ref="e1">
      <div class="split-photo"><img :src="getImage('split_photo_1', '/image-17.jpg')" alt="Maasai Boma"></div>
      <div class="split-copy">
        <span class="label">01 · Maasai</span>
        <h2>Boma Visit<br>&amp; Herding Life</h2>
        <p>Visit a traditional Boma in Longido or Ngorongoro. Learn about the pastoral lifestyle, assist with cattle milking, and listen to elders share stories around a fire that has burned for centuries.</p>
        <ul class="tag-list">
          <li>Traditional Dance</li><li>Beadwork Workshops</li><li>Village Walks</li>
        </ul>
      </div>
    </div>

    <div class="quote-photo" ref="qp">
      <img :src="getImage('quote_photo', '/image-06.jpg')" alt="Cultural portrait">
      <div class="quote-veil"></div>
      <div class="quote-text">
        <span class="quote-mark">"</span>
        <p>Some experiences don't translate into photographs. The morning with the Hadzabe was one of them.</p>
        <cite>— David M., Ndauwo traveller</cite>
      </div>
    </div>

    <div class="split-section split-flip" ref="e2">
      <div class="split-photo"><img :src="getImage('split_photo_2', '/image-17.jpg')" alt="Hadzabe hunt"></div>
      <div class="split-copy">
        <span class="label">02 · Hadzabe</span>
        <h2>A Morning<br>Hunt</h2>
        <p>Journey to Lake Eyasi to meet the Hadzabe, one of the last true hunter-gatherer tribes in Africa. Join them before dawn, learn their ancient click language, and share in a way of life unchanged for millennia.</p>
        <ul class="tag-list">
          <li>Bow & Arrow Skills</li><li>Bush Foraging</li><li>Click Language</li>
        </ul>
      </div>
    </div>

    <div class="photo-break" ref="pb">
      <img :src="getImage('photo_break', '/image-15.jpg')" alt="Stone Town">
      <span class="photo-caption">Stone Town · Zanzibar's UNESCO Heritage Quarter</span>
    </div>

    <div class="split-section" ref="e3">
      <div class="split-photo"><img :src="getImage('split_photo_3', '/image-20.jpg')" alt="Swahili coast"></div>
      <div class="split-copy">
        <span class="label">03 · Swahili</span>
        <h2>Coastal<br>Culture</h2>
        <p>Explore the layered history of Zanzibar's Stone Town, walk a working spice plantation, and cook Swahili dishes in a family kitchen. A completely different dimension of Tanzania that most safari travelers miss entirely.</p>
        <ul class="tag-list">
          <li>Spice Farm Tour</li><li>Stone Town Walk</li><li>Cooking Classes</li>
        </ul>
      </div>
    </div>

    <section class="cta-section" ref="cta">
      <div class="cta-photo" :style="{ backgroundImage: `url(${getImage('cta_bg', '/image-13.jpg')})` }"></div>
      <div class="cta-veil"></div>
      <div class="cta-copy">
        <span class="label">Design Your Experience</span>
        <h2>Meet the Real<br><em>Tanzania</em></h2>
        <router-link to="/contact" class="cta-btn">Start a Conversation</router-link>
      </div>
    </section>
  </div>
</template>

<script setup>
import HandwrittenTypewriter from '@/components/HandwrittenTypewriter.vue'
import { ref, onMounted } from 'vue'
import { usePageImages } from '../../composables/usePageImages'

const { images, fetchImages, getImage } = usePageImages('cultural_tours');

const s1 = ref(null), e1 = ref(null), qp = ref(null), e2 = ref(null), pb = ref(null), e3 = ref(null), cta = ref(null)
onMounted(() => {
  fetchImages();
  const io = new IntersectionObserver(entries => { entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target) } }) }, { threshold: 0.06 })
  ;[s1, e1, qp, e2, pb, e3, cta].forEach(r => r.value && io.observe(r.value))
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

.split-section { display:grid; grid-template-columns:1fr 1fr; gap:0; opacity:0; transform:translateY(50px); transition:opacity 1.3s ease,transform 1.3s cubic-bezier(0.16,1,0.3,1); }
.split-section.in { opacity:1; transform:translateY(0); }
.split-flip .split-photo { order:2; }
.split-flip .split-copy { order:1; }
.split-photo { overflow:hidden; }
.split-photo img { width:100%; height:100%; min-height:620px; object-fit:cover; display:block; transition:transform 1.5s ease; }
.split-section:hover .split-photo img { transform:scale(1.04); }
.split-copy { background: var(--ivory-dark); padding:100px 72px; display:flex; flex-direction:column; justify-content:center; }
.split-flip .split-copy { background: var(--ivory); }
.split-copy h2 { font-family:'Playfair Display',serif; font-size:clamp(2.2rem,3.5vw,3.8rem); font-weight:400; color: var(--text-dark); margin:0 0 28px; line-height:1.1; }
.split-copy p { font-size:1.05rem; line-height:1.9; color: var(--text-mid); font-weight:300; margin-bottom:36px; }
.tag-list { list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:12px; }
.tag-list li { font-size:0.78rem; letter-spacing:0.15em; text-transform:uppercase; color: var(--gold); padding-left:20px; position:relative; }
.tag-list li::before { content:''; position:absolute; left:0; top:50%; transform:translateY(-50%); width:8px; height:1px; background: var(--gold); }

.quote-photo { position:relative; overflow:hidden; opacity:0; transition:opacity 1.5s ease; }
.quote-photo.in { opacity:1; }
.quote-photo img { width:100%; height:85vh; object-fit:cover; object-position:center 40%; display:block; }
.quote-veil { position:absolute; inset:0; background:rgba(14,14,14,0.6); }
.quote-text { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:0 12%; }
.quote-mark { font-family:'Playfair Display',serif; font-size:8rem; color: var(--gold); line-height:0.5; margin-bottom:32px; }
.quote-text p { font-family:'Playfair Display',serif; font-style:italic; font-size:clamp(1.8rem,3vw,2.8rem); color:#FFFFFF; line-height:1.4; margin-bottom:28px; }
.quote-text cite { font-size:0.75rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(255, 255, 255, 0.5); }

.photo-break { overflow:hidden; opacity:0; transition:opacity 1.5s ease; position:relative; }
.photo-break.in { opacity:1; }
.photo-break img { width:100%; height:70vh; object-fit:cover; display:block; }
.photo-caption { position:absolute; bottom:24px; right:32px; font-size:0.68rem; letter-spacing:0.15em; color:rgba(255, 255, 255, 0.5); text-transform:uppercase; }

.cta-section { height:90vh; min-height:600px; position:relative; display:flex; align-items:flex-end; padding:0 8% 12vh; opacity:0; transition:opacity 1.4s ease; }
.cta-section.in { opacity:1; }
.cta-photo { position:absolute; inset:0; background-size:cover; background-position:center; }
.cta-veil { position:absolute; inset:0; background:linear-gradient(to top, rgba(14,14,14,0.88) 0%, rgba(14,14,14,0.3) 60%, transparent 100%); }
.cta-copy { position:relative; z-index:2; }
.cta-copy h2 { font-family:'Playfair Display',serif; font-size:clamp(3rem,6vw,6rem); font-weight:400; color:#FFFFFF; line-height:1.0; margin:0 0 48px; }
.cta-btn { display:inline-block; padding:18px 52px; border:1px solid var(--gold); color: var(--gold); text-decoration:none; font-size:0.82rem; letter-spacing:0.2em; text-transform:uppercase; transition:background 0.4s,color 0.4s; }
.cta-btn:hover { background: var(--gold); color: var(--ivory); }

@media(max-width:1024px) { .split-section{grid-template-columns:1fr;} .split-flip .split-photo,.split-flip .split-copy{order:unset;} .split-photo img{min-height:400px;height:50vw;} .split-copy{padding:60px 5%;} }
@media(max-width:768px) { .hero{padding:0 5% 12vh;} .hero h1{font-size:clamp(2.8rem,8vw,3.5rem);} .statement{padding:80px 5%;} .feature-copy{padding:48px 32px;} }
@media(max-width:480px) { .hero h1{font-size:2.5rem;} .hero-lead{font-size:0.95rem;} .statement h2{font-size:2.2rem;} .cta-copy h2{font-size:2.5rem;} .cta-btn{display:block;text-align:center;padding:18px 20px;} .photo-overlay-text{left:5%;right:5%;} .photo-overlay-text span{font-size:1.3rem;} }
@media(max-width:375px) { .hero h1{font-size:2rem;} .statement{padding:60px 4%;} }
</style>
