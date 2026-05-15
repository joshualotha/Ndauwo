<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'

const props = defineProps({
  phrases: {
    type: Array,
    required: true
  },
  minTypeSpeed: {
    type: Number,
    default: 80
  },
  maxTypeSpeed: {
    type: Number,
    default: 120
  },
  wordDelay: {
    type: Number,
    default: 5000
  },
  deleteSpeed: {
    type: Number,
    default: 60
  },
  startDelay: {
    type: Number,
    default: 0
  }
})

const currentPhraseIndex = ref(0)
const isDeleting = ref(false)
const displayText = ref('')
let timer = null

const currentPhrase = computed(() => props.phrases[currentPhraseIndex.value])
const totalPhraseText = computed(() => currentPhrase.value.map(s => s.text).join(''))

const visibleSegments = computed(() => {
  let remaining = displayText.value.length
  const result = []
  
  for (const segment of currentPhrase.value) {
    if (remaining <= 0) break
    const segmentText = segment.text
    const visibleInSegment = segmentText.substring(0, Math.min(segmentText.length, remaining))
    const isComplete = visibleInSegment.length === segmentText.length
    
    result.push({
      ...segment,
      visibleText: visibleInSegment,
      chars: visibleInSegment.split(''),
      isComplete
    })
    remaining -= segmentText.length
  }
  return result
})

const getCharKey = (segIdx, charIdx) => `${currentPhraseIndex.value}-${segIdx}-${charIdx}`

const type = () => {
  const fullText = totalPhraseText.value
  
  if (isDeleting.value) {
    displayText.value = fullText.substring(0, displayText.value.length - 1)
  } else {
    displayText.value = fullText.substring(0, displayText.value.length + 1)
  }

  let delay = isDeleting.value ? props.deleteSpeed : Math.floor(Math.random() * (props.maxTypeSpeed - props.minTypeSpeed) + props.minTypeSpeed)

  if (!isDeleting.value && displayText.value === fullText) {
    delay = props.wordDelay
    if (props.phrases.length > 1) isDeleting.value = true
  } else if (isDeleting.value && displayText.value === '') {
    isDeleting.value = false
    currentPhraseIndex.value = (currentPhraseIndex.value + 1) % props.phrases.length
    delay = 1000
  }

  timer = setTimeout(type, delay)
}

const containerRef = ref(null)

onMounted(() => {
  // Check if component is inside a hero section
  const isHero = containerRef.value?.closest('#hero, .premium-hero, .hero-content, [class*="hero"]')
  
  if (!isHero) {
    // Show full text immediately for non-hero sections
    displayText.value = totalPhraseText.value
    return
  }

  setTimeout(() => {
    type()
  }, props.startDelay)
})

onUnmounted(() => {
  if (timer) clearTimeout(timer)
})
</script>

<template>
  <span ref="containerRef" class="handwritten-container">
    <span class="chars-list">
      <template v-for="(segment, sIdx) in visibleSegments" :key="sIdx">
        <span :class="['segment', segment.class, { 'segment-complete': segment.isComplete }]">
          <!-- The Foundation layer: Rock solid base color -->
          <TransitionGroup name="char-fade" tag="span" class="foundation-layer">
            <template v-for="(char, cIdx) in segment.chars" :key="getCharKey(sIdx, cIdx)">
              <br v-if="char === '\n'" />
              <span v-else class="char">
                <template v-if="char === ' '">&nbsp;</template>
                <template v-else>{{ char }}</template>
              </span>
            </template>
          </TransitionGroup>

          <!-- The Glowing Ripple: High Intensity additive shine & pulse -->
          <span v-if="segment.class.includes('text-shimmer')" class="shimmer-wave">
            <template v-for="(char, cIdx) in segment.chars" :key="'shimmer-' + getCharKey(sIdx, cIdx)">
              <br v-if="char === '\n'" />
              <span v-else class="char">
                <template v-if="char === ' '">&nbsp;</template>
                <template v-else>{{ char }}</template>
              </span>
            </template>
          </span>
        </span>
      </template>
    </span>
  </span>
</template>

<style scoped>
.handwritten-container {
  display: inline-block;
  vertical-align: bottom;
  position: relative;
}

.segment {
  display: inline-block;
  position: relative;
}

.char {
  display: inline-block;
  font-family: inherit;
  font-weight: 700;
  transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
  will-change: transform, opacity;
  color: inherit;
}

/* Coloring - Foundation Layer (Rock Solid) */
.segment.white .foundation-layer .char { color: var(--ivory, #fff) !important; }
.segment.orange .foundation-layer .char { color: var(--gold, #E2791B) !important; }

/* Script accent — Dancing Script, gold, for "Wilderness" keyword (Asilia style) */
.segment.em .foundation-layer .char {
  font-family: var(--f-script, 'Dancing Script', cursive) !important;
  font-weight: 400 !important;
  font-size: 1.3em !important;
  color: var(--gold, #E2791B) !important;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5) !important;
}

/* The Glowing Ripple - High Intensity Additive Shine */
.shimmer-wave {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  opacity: 0;
  transition: opacity 0.8s ease-in-out;
  mix-blend-mode: screen; /* Makes the shine truly glow */
  
  /* High-Contrast White-Gold Wave */
  background: linear-gradient(
    90deg,
    rgba(226, 121, 27, 0) 0%,
    rgba(226, 121, 27, 0) 40%,
    rgba(255, 255, 255, 1) 50%,
    rgba(255, 255, 255, 1) 52%,
    rgba(18, 20, 16, 0) 65%
  );
  background-size: 200% auto;
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent !important;
  -webkit-text-fill-color: transparent !important;
  animation: rippleMotion 3s cubic-bezier(0.4, 0, 0.2, 1) infinite;
  
  /* Add a subtle drop-shadow glow pulse to the ripple */
  filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0));
}

@keyframes rippleMotion {
  0% { 
    background-position: -200% center;
    filter: drop-shadow(0 0 2px rgba(255, 255, 255, 0.2));
  }
  50% { 
    filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.8));
  }
  100% { 
    background-position: 200% center;
    filter: drop-shadow(0 0 2px rgba(255, 255, 255, 0.2));
  }
}

/* Show shimmer ripple once typing is finished */
.segment-complete .shimmer-wave {
  opacity: 1;
}

/* Transitions */
.char-fade-enter-active {
  transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
}

.char-fade-enter-from {
  opacity: 0;
  transform: translateY(4px) scale(0.9);
}
</style>
