<template>
  <div class="journal-detail-page" v-if="post">
    
    <!-- 1. CINEMATIC CHAPTER HEADER -->
    <header class="chapter-header">
      <div class="header-bg" :style="{ backgroundImage: `linear-gradient(to bottom, rgba(14, 20, 14, 0.4) 0%, rgba(14, 20, 14, 0.2) 60%, rgba(20, 24, 20, 1) 100%), url(${getImage('hero_bg', post.heroImage)})` }"></div>
      <div class="header-overlay-texture"></div>
      
      <div class="header-content" v-reveal>
        <div class="breadcrumb">
          <router-link to="/journal">Journal</router-link>
          <span class="sep">/</span>
          <span class="curr">{{ post.category }}</span>
        </div>
        
        <h1 class="chapter-title" v-html="post.title"></h1>
        
        <div class="header-meta">
          <div class="meta-item">
            <span class="m-label">Expedition Date</span>
            <span class="m-val">{{ post.date }}</span>
          </div>
          <div class="meta-sep"></div>
          <div class="meta-item">
            <span class="m-label">Reading Time</span>
            <span class="m-val">{{ post.readTime }}</span>
          </div>
        </div>
      </div>

      <div class="scroll-prompt">
        <span class="prompt-text">Begin Reading</span>
        <div class="prompt-line"></div>
      </div>
    </header>

    <!-- 2. THE READING SANCTUARY -->
    <main class="reading-sanctuary">
      <div class="sanctuary-container">
        
        <!-- Field Summary Sidebar (Desktop) -->
        <aside class="field-summary" v-reveal>
          <div class="summary-block">
            <span class="s-label">The Narrator</span>
            <div class="narrator-profile">
              <div class="narrator-av" :style="{ backgroundImage: `url(${getImage('author_bg', '/image-01.jpg')})` }"></div>
              <div class="narrator-info">
                <span class="n-name">{{ post.author }}</span>
                <span class="n-role">{{ post.role }}</span>
              </div>
            </div>
          </div>
          
          <div class="summary-block">
            <span class="s-label">Location</span>
            <span class="s-val">Serengeti, Tanzania</span>
            <span class="s-coord">2.3333° S, 34.8333° E</span>
          </div>

          <div class="summary-block">
            <span class="s-label">Key Species</span>
            <div class="species-list">
              <span class="species-tag" v-for="tag in ['Panthera leo', 'Crocuta crocuta', 'Equus quagga']" :key="tag">
                ✦ {{ tag }}
              </span>
            </div>
          </div>

          <div class="summary-block share-block">
            <span class="s-label">Share Dispatch</span>
            <div class="share-links">
              <span>𝕏</span>
              <span>In</span>
              <span>Fb</span>
            </div>
          </div>
        </aside>

        <!-- Main Narrative Column -->
        <article class="narrative-column" v-reveal>
          <!-- Lead Section with Drop Cap (Handled in V-HTML) -->
          <div class="article-content" v-html="post.content"></div>
          
          <!-- Dispatch Divider -->
          <div class="dispatch-divider">
            <span class="div-line"></span>
            <span class="div-mark">✦</span>
            <span class="div-line"></span>
          </div>

          <!-- Closing Signature -->
          <div class="dispatch-signature">
            <p>Respectfully recorded from the field,</p>
            <span class="sig-name">{{ post.author }}</span>
          </div>
        </article>
      </div>
    </main>
    
    <!-- 3. EXPLORE FURTHER FOOTER -->
    <section class="explore-further" v-reveal>
      <div class="explore-bg"></div>
      <div class="explore-content">
        <span class="label">Next Dispatch</span>
        <h2 class="explore-h">Echoes of the <em>Rift Valley</em></h2>
        <div class="explore-actions">
          <router-link to="/journal/echoes-of-the-rift-valley" class="btn-primary">View Next Story</router-link>
          <router-link to="/journal" class="btn-ghost">Journal Archive</router-link>
        </div>
      </div>
    </section>

  </div>
  
  <!-- NOT FOUND STATE -->
  <div v-else class="post-missing">
    <div class="missing-inner">
      <span class="m-code">404</span>
      <h1>Dispatch Misplaced</h1>
      <p>The field note you are looking for has been moved or archived.</p>
      <router-link to="/journal" class="btn-outline">Return to the Journal</router-link>
    </div>
  </div>
</template>

<script setup>
import { computed, watch, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { usePageImages } from '../composables/usePageImages'

const route = useRoute()
const { fetchImages, getImage } = usePageImages('blog_post');

watch(() => route.params.slug, (newSlug) => {
  if (newSlug) {
    fetchImages();
  }
});

onMounted(() => {
  fetchImages();
  window.scrollTo(0, 0);
});

// Post Database (Enhanced with more metadata)
const posts = {
  'the-silence-before-the-crossing': {
    title: "The Silence Before <br><em>the Crossing</em>",
    category: "Field Notes",
    date: "Oct 14, 2025",
    readTime: "7 Min Read",
    author: "Daniel Maro",
    role: "Mobile Camp Leader",
    heroImage: "/image-05.jpg",
    content: `
      <p class="drop-cap focus-text">Waiting for the herds at the Mara River is an exercise in profound, almost unbearable tension. One does not simply 'watch' a crossing; one absorbs it through the skin.</p>
      
      <p>There is a specific vibration in the earth right before two million wildebeest decide to commit to the current. It’s not something you hear; it’s something that hums in your teeth—the collective pulse of a logic-defying mass of life. The migration doesn't just pass through the Serengeti; it defines it.</p>
      
      <div class="in-post-image full" v-reveal>
        <img src="/image-03.jpg" alt="The River Crossing">
        <span class="img-caption">Mara River crossing, Sector 4. High predator concentration observed.</span>
      </div>

      <blockquote>"You don't guide a crossing. You merely secure a front-row seat to the most chaotic physics equation in the natural world."</blockquote>
      
      <p>The crocodiles, many exceeding five meters, have waited a year for this moment. They don't swim; they simply detach from the mud like prehistoric logs, floating with a terrible, silent intentionality. Their efficiency is calculated in generations, not seconds.</p>
      
      <p>By noon, the dust cloud created by 40,000 hooves is impenetrable. The nervous energy of the herd becomes physical—a low-frequency static in the air. We cut the engine of our cruiser. In the deep bush, silence is the only way to truly listen to what the landscape is telling you.</p>

      <div class="in-post-grid">
         <img src="/image-12.jpg" alt="Wildlife Detail">
         <p>Field observation often reveals that the most critical moments happen in the margins. A yearling's hesitation can trigger a massive redirection of the entire herd, changing the day's narrative in an instant.</p>
      </div>
      
      <p>When the first animal finally leaps, the silence shatters. It is a cacophony of absolute survival. Dust, brown water, and the raw vocalizations of a species fighting for every meter of progress. It is brutal, it is beautiful, and it is entirely honest.</p>
    `
  },
  'anatomy-of-the-sprint': {
    title: "Anatomy of <br><em>the Sprint</em>",
    category: "Wildlife Behavior",
    date: "Sept 28, 2025",
    readTime: "5 Min Read",
    author: "Sarah Jenkins",
    role: "Apex Predator Specialist",
    heroImage: "/image-15.jpg",
    content: `
      <p class="drop-cap focus-text">Deconstructing the biomechanics of a cheetah chase is a lesson in extreme physical limits. This is nature pushed to the edge of what a silhouette of bone and muscle can endure.</p>
      
      <p>A cheetah’s acceleration outpaces any machine we've ever built for speed. From absolute stillness to sixty miles per hour in under three seconds, the sprint is less about running and more about a series of controlled explosions.</p>
      
      <blockquote>"The sprint is what the cameras catch, but the stalk is where the hunt is actually won or lost."</blockquote>
      
      <p>During the peak heat of the dry season, the stakes are lethal. A sprint lasting more than forty seconds raises the cheetah's core temperature to life-threatening levels. If the hunt fails, it isn't just a missed meal—it's a critical physiological depletion that takes days to reset.</p>
      
      <p>We tracked the Namiri coalition through the tall grasses of the Eastern Plains. The patience was agonizing, the strike was over before I could check my focus. The silence that followed, as they struggled to regain breath under the limited shade of a thorn bush, spoke far more of their life than the chase ever did.</p>
    `
  }
}

const post = computed(() => posts[route.params.slug])
</script>

<style scoped>
.journal-detail-page {
  background: #141814;
  color: var(--ivory);
  min-height: 100vh;
  overflow-x: hidden;
}

/* ━━━ CINEMATIC CHAPTER HEADER ━━━ */
.chapter-header {
  position: relative;
  height: 90vh;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 0 8%;
}

.header-bg {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
  z-index: 1;
}

.header-overlay-texture {
  position: absolute;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
  opacity: 0.05;
  pointer-events: none;
  z-index: 2;
}

.header-content {
  position: relative;
  z-index: 10;
  max-width: 1100px;
}

.breadcrumb {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  font-size: var(--f-meta);
  letter-spacing: var(--ls-wide);
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 40px;
}

.chapter-title {
  font-family: var(--f-serif);
  font-size: var(--f-display);
  line-height: var(--lh-tight);
  color: #FFF;
  margin-bottom: 50px;
}

.meta-item { display: flex; flex-direction: column; gap: 8px; }
.m-label { font-size: var(--f-meta); letter-spacing: var(--ls-normal); text-transform: uppercase; color: rgba(255,255,255,0.4); }
.m-val { font-family: var(--f-serif); font-size: var(--f-h3); color: #FFF; }

.scroll-prompt {
  position: absolute;
  bottom: 50px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}

.prompt-text { font-size: 0.6rem; letter-spacing: 0.4em; text-transform: uppercase; color: rgba(255,255,255,0.3); }
.prompt-line { width: 1px; height: 40px; background: rgba(255,255,255,0.2); }

/* ━━━ THE READING SANCTUARY ━━━ */
.reading-sanctuary {
  padding: 140px 8%;
  background: var(--ivory);
  color: var(--text-dark);
}

.sanctuary-container {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 320px 1fr;
  gap: 120px;
  align-items: start;
}

/* Field Summary Sidebar */
.field-summary {
  position: sticky;
  top: 140px;
  display: flex;
  flex-direction: column;
  gap: 60px;
}

.summary-block { display: flex; flex-direction: column; }
.s-label { font-size: 0.65rem; letter-spacing: 0.3em; text-transform: uppercase; color: var(--gold); margin-bottom: 25px; font-weight: 600; }

.narrator-profile { display: flex; align-items: center; gap: 20px; }
.narrator-av { width: 60px; height: 60px; border-radius: 50%; background-size: cover; background-position: center; border: 1px solid rgba(0,0,0,0.05); }
.narrator-info { display: flex; flex-direction: column; gap: 4px; }
.n-name { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; color: #1a1a1a; }
.n-role { font-size: 0.75rem; color: #888; letter-spacing: 0.05em; }

.s-val { font-family: 'Playfair Display', serif; font-size: 1.4rem; color: #1a1a1a; margin-bottom: 8px; }
.s-coord { font-size: 0.8rem; color: #888; font-style: italic; }

.species-list { display: flex; flex-direction: column; gap: 12px; }
.species-tag { font-size: 0.85rem; font-style: italic; color: var(--forest); }

.share-links { display: flex; gap: 25px; font-family: 'Playfair Display', serif; font-style: italic; color: #888; font-size: 1.1rem; cursor: pointer; }

/* Main Narrative Column */
.narrative-column { max-width: 780px; }

:deep(.article-content p) {
  font-size: 1.2rem;
  line-height: 2.1;
  color: #3a3a3a;
  margin-bottom: 45px;
  font-weight: 300;
}

:deep(.article-content .focus-text) {
  font-size: 1.5rem;
  line-height: 1.8;
  color: #1a1a1a;
  font-family: 'Playfair Display', serif;
  font-style: italic;
}

:deep(.article-content .drop-cap::first-letter) {
  font-family: 'Playfair Display', serif;
  font-size: 6rem;
  line-height: 0.8;
  float: left;
  margin-right: 20px;
  margin-top: 5px;
  color: var(--forest);
}

:deep(.article-content blockquote) {
  margin: 100px 0;
  text-align: center;
  position: relative;
}

:deep(.article-content blockquote p) {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2rem, 3.5vw, 2.8rem);
  color: var(--forest);
  line-height: 1.3;
  font-style: italic;
  margin: 0;
}

:deep(.in-post-image) { margin: 80px 0; }
:deep(.in-post-image img) { width: 100%; height: auto; border-radius: 2px; box-shadow: 0 30px 60px rgba(0,0,0,0.05); }
:deep(.img-caption) { display: block; margin-top: 20px; font-size: 0.8rem; color: #888; text-transform: uppercase; letter-spacing: 0.2em; text-align: center; }

:deep(.in-post-grid) {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
  align-items: center;
  margin: 80px 0;
}

.dispatch-divider {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 30px;
  margin: 100px 0;
}

.div-line { flex: 1; height: 1px; background: rgba(0,0,0,0.08); }
.div-mark { color: var(--gold); font-size: 1.2rem; }

.dispatch-signature { margin-top: 80px; }
.dispatch-signature p { font-style: italic; color: #888; font-size: 1.1rem; margin-bottom: 12px; }
.sig-name { font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--forest); }

/* ━━━ EXPLORE FURTHER ━━━ */
.explore-further {
  padding: 160px 8%;
  background: #1a1a1a;
  text-align: center;
  position: relative;
  overflow: hidden;
}

.explore-h {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 5vw, 5rem);
  color: #FFF;
  margin: 30px 0 60px;
}

.explore-h em { font-style: italic; color: var(--gold); }

.explore-actions { display: flex; gap: 20px; justify-content: center; }

.btn-primary {
  background: var(--gold);
  color: #FFF;
  padding: 20px 50px;
  text-transform: uppercase;
  letter-spacing: 0.3em;
  font-size: 0.8rem;
  text-decoration: none;
}

.btn-ghost {
  border: 1px solid rgba(255,255,255,0.2);
  color: #FFF;
  padding: 20px 40px;
  text-transform: uppercase;
  letter-spacing: 0.3em;
  font-size: 0.8rem;
  text-decoration: none;
}

/* MISSING STATE */
.post-missing {
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--ivory);
  text-align: center;
}

.m-code { font-family: 'Playfair Display', serif; font-size: 8rem; color: rgba(0,0,0,0.05); line-height: 1; }
.post-missing h1 { font-family: 'Playfair Display', serif; font-size: 3.5rem; color: var(--forest); margin: -20px 0 20px; }

/* RESPONSIVE */
@media (max-width: 1024px) {
  .sanctuary-container { grid-template-columns: 1fr; gap: 80px; }
  .field-summary { position: static; flex-direction: row; flex-wrap: wrap; gap: 40px; }
  .summary-block { flex: 1; min-width: 200px; }
}

@media (max-width: 768px) {
  .chapter-header { height: 70vh; }
  .header-meta { flex-direction: column; gap: 30px; }
  .header-meta .meta-item { text-align: center; }
  .reading-sanctuary { padding: 100px 6%; }
  :deep(.in-post-grid) { grid-template-columns: 1fr; }
  .explore-actions { flex-direction: column; }
}
</style>

