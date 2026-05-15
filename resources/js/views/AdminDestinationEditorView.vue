<template>
  <AdminLayout>
    <div v-if="isLoading" class="loader-container">
      <div class="spinner"></div>
      <p>Loading destination data...</p>
    </div>

    <form v-else @submit.prevent="handleSave" class="destination-editor">
      <!-- Header -->
      <div class="editor-header">
        <div class="left">
          <button type="button" @click="$router.push('/admin/destinations')" class="back-btn">
            <i-arrow-left class="icon" />
            Cancel
          </button>
          <h1>{{ isEditMode ? 'Edit Destination' : 'New Destination' }}</h1>
        </div>
        <div class="actions">
          <button type="submit" class="save-btn" :disabled="isProcessing">
            <i-save class="icon" />
            {{ isProcessing ? 'Saving...' : 'Save Destination' }}
          </button>
        </div>
      </div>

      <!-- Tab Navigation -->
      <div class="tabs-nav">
        <button 
          v-for="(tab, index) in tabs" 
          :key="index"
          type="button"
          class="tab-link"
          :class="{ active: activeTab === index }"
          @click="activeTab = index"
        >
          {{ tab }}
        </button>
      </div>

      <!-- Tab Content Area -->
      <div class="tab-content card">
        <!-- General Info -->
        <div v-show="activeTab === 0" class="tab-panel">
          <div class="form-grid">
            <div class="form-group full">
              <label>Destination Name</label>
              <input type="text" v-model="form.name" required placeholder="e.g. Serengeti National Park">
            </div>
            <div class="form-group full">
              <label>Display Label / Subtitle</label>
              <input type="text" v-model="form.label" placeholder="e.g. Northern Circuit · Tanzania">
            </div>
            <div class="form-group">
              <label>Destination Type</label>
              <select v-model="form.type">
                <option value="park">National Park</option>
                <option value="mountain">Mountain</option>
                <option value="island">Island / Beach</option>
                <option value="region">Region / City</option>
              </select>
            </div>
            <div class="form-group">
              <label>Area / Elevation</label>
              <input type="text" v-model="form.area" placeholder="e.g. 14,750 km²">
            </div>
            <div class="form-group">
              <label>Best Time to Visit</label>
              <input type="text" v-model="form.best_time_to_visit" placeholder="e.g. June to October">
            </div>
            <div class="form-group">
              <label>Signature Experience</label>
              <input type="text" v-model="form.signature_experience" placeholder="e.g. The Great Migration">
            </div>
            <div class="form-group full">
              <label>Introductory Description</label>
              <textarea v-model="form.description" rows="6" required></textarea>
            </div>
          </div>

          <div class="highlights-section">
            <div class="section-header">
              <h3>Key Highlights</h3>
              <button type="button" @click="addHighlight" class="add-btn">
                <i-plus class="icon" /> Add Highlight
              </button>
            </div>
            <div class="highlights-list">
              <div v-for="(h, idx) in form.highlights" :key="idx" class="highlight-item">
                <input type="text" v-model="h.title" placeholder="Highlight Title" class="h-title">
                <textarea v-model="h.desc" placeholder="Brief description..." rows="2"></textarea>
                <button type="button" @click="removeHighlight(idx)" class="remove-btn">
                  <i-trash class="icon" />
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Landscape & Ecology -->
        <div v-show="activeTab === 1" class="tab-panel">
          <div class="form-grid">
            <div class="form-group full">
              <label>Pull Quote (Hero Text Overlay)</label>
              <textarea v-model="form.pull_quote" rows="3" placeholder="A short, evocative quote about the destination..."></textarea>
            </div>
            <div class="form-group full">
              <label>The Landscape (Geography)</label>
              <textarea v-model="form.geography" rows="8" placeholder="Detailed description of the landscape and environment..."></textarea>
            </div>
            <div class="form-group full">
              <label>The Wildlife (Ecology)</label>
              <textarea v-model="form.ecology" rows="8" placeholder="Overview of the ecosystem and primary species..."></textarea>
            </div>
          </div>
        </div>

        <!-- Media -->
        <div v-show="activeTab === 2" class="tab-panel">
          <div class="media-grid">
            <!-- Featured Image -->
            <div class="media-card">
              <label>Featured Hero Image</label>
              <div class="image-preview" v-if="previews.image || form.image">
                <img :src="getImageUrl(form.image)">
                <button type="button" @click="clearImage" class="clear-btn">Remove</button>
              </div>
              <div class="upload-box" v-else @click="$refs.imageInput.click()">
                <i-upload class="icon" />
                <span>Upload Featured Image</span>
                <input type="file" ref="imageInput" hidden @change="handleImageUpload" accept="image/*">
              </div>
            </div>

            <!-- Gallery Images -->
            <div class="media-card full">
              <div class="card-header-flex">
                <label>Gallery Assets</label>
                <button type="button" @click="$refs.galleryInput.click()" class="add-asset-btn">
                  <i-plus class="icon" /> Add New Photos
                </button>
              </div>
              
              <div class="asset-manager">
                <div v-for="(img, idx) in combinedGallery" :key="idx" 
                     class="asset-card" :class="img.type">
                  <div class="asset-preview">
                    <img :src="img.url">
                    <div class="asset-badge">{{ img.type === 'existing' ? 'Server' : 'New' }}</div>
                    <button type="button" @click="removeGalleryItem(img)" class="asset-remove" title="Remove Asset">
                      <i-trash class="icon" />
                    </button>
                  </div>
                  <div class="asset-info" v-if="img.path">
                    <span class="asset-filename">{{ img.path.split('/').pop() }}</span>
                  </div>
                  <div class="asset-info" v-else-if="img.file">
                    <span class="asset-filename">{{ img.file.name }}</span>
                    <span class="asset-size">{{ (img.file.size / 1024 / 1024).toFixed(2) }} MB</span>
                  </div>
                </div>

                <div class="asset-upload-placeholder" @click="$refs.galleryInput.click()">
                  <i-plus class="icon" />
                  <input type="file" ref="galleryInput" hidden multiple @change="handleGalleryUpload" accept="image/*">
                </div>
              </div>
            </div>

            <div class="form-group full">
              <label>Map Embed URL (Google Maps Iframe source)</label>
              <input type="text" v-model="form.map_embed_url" placeholder="https://www.google.com/maps/embed?...">
            </div>
          </div>
        </div>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import AdminLayout from '../components/AdminLayout.vue';
import { useSettings, API_BASE_URL } from '../composables/useSettings';
import {
  ArrowLeft as IArrowLeft,
  Save as ISave,
  Plus as IPlus,
  Trash2 as ITrash,
  Upload as IUpload
} from 'lucide-vue-next';

const { getImageUrl } = useSettings();

const route = useRoute();
const router = useRouter();
const isEditMode = computed(() => !!route.params.id);
const isLoading = ref(false);
const isProcessing = ref(false);
const activeTab = ref(0);
const tabs = ['General Info', 'Landscape & Ecology', 'Media & Gallery'];

const form = reactive({
  name: '',
  label: '',
  type: 'park',
  area: '',
  best_time_to_visit: '',
  signature_experience: '',
  description: '',
  highlights: [],
  pull_quote: '',
  geography: '',
  ecology: '',
  image: null,
  new_image: null,
  gallery: [], // Files to upload
  existing_gallery: [], // Paths from server
  map_embed_url: ''
});

const previews = reactive({
  image: null,
  gallery: [] // Array of { file, url }
});

const combinedGallery = computed(() => {
  const existing = form.existing_gallery.map(path => ({ url: getImageUrl(path), path, type: 'existing' }));
  const news = previews.gallery.map(p => ({ url: p.url, file: p.file, type: 'new' }));
  return [...existing, ...news];
});

const fetchDestination = async () => {
  if (!isEditMode.value) return;
  isLoading.value = true;
  try {
    const response = await axios.get(`${API_BASE_URL}/api/destinations/${route.params.id}`);
    const data = response.data;

    form.name = data.name || '';
    form.label = data.label || '';
    form.type = data.type || 'park';
    form.area = data.area || '';
    form.best_time_to_visit = data.best_time_to_visit || '';
    form.signature_experience = data.signature_experience || '';
    form.description = data.description || '';
    form.highlights = Array.isArray(data.highlights) ? data.highlights : [];
    form.pull_quote = data.pull_quote || '';
    form.geography = data.geography || '';
    form.ecology = data.ecology || '';
    form.image = data.image || null;
    form.existing_gallery = Array.isArray(data.gallery) ? data.gallery : [];
    form.map_embed_url = data.map_embed_url || '';
  } catch (error) {
    console.error('Failed to fetch destination:', error);
    alert('Error loading destination.');
    router.push('/admin/destinations');
  } finally {
    isLoading.value = false;
  }
};

const addHighlight = () => form.highlights.push({ title: '', desc: '' });
const removeHighlight = (idx) => form.highlights.splice(idx, 1);

const handleImageUpload = (e) => {
  const file = e.target.files[0];
  if (!file) return;
  form.new_image = file;
  previews.image = URL.createObjectURL(file);
};

const clearImage = () => {
  form.new_image = null;
  form.image = null;
  previews.image = null;
};

const handleGalleryUpload = (e) => {
  const files = Array.from(e.target.files);
  files.forEach(file => {
    previews.gallery.push({ file, url: URL.createObjectURL(file) });
  });
};

const removeGalleryItem = (item) => {
  if (item.type === 'existing') {
    form.existing_gallery = form.existing_gallery.filter(p => p !== item.path);
  } else {
    previews.gallery = previews.gallery.filter(p => p.file !== item.file);
  }
};

const handleSave = async () => {
  isProcessing.value = true;
  const formData = new FormData();

  // Append basic fields
  Object.keys(form).forEach(key => {
    if (['highlights', 'gallery', 'existing_gallery', 'new_image', 'image'].includes(key)) return;
    if (form[key] !== null && form[key] !== '') formData.append(key, form[key]);
  });

  // Append highlights as proper array format for Laravel
  form.highlights.forEach((h, idx) => {
    formData.append(`highlights[${idx}][title]`, h.title || '');
    formData.append(`highlights[${idx}][desc]`, h.desc || '');
  });

  // Append existing gallery paths
  form.existing_gallery.forEach(p => formData.append('existing_gallery[]', p));

  // Append new image if selected
  if (form.new_image) formData.append('image', form.new_image);
  
  // Append new gallery files
  previews.gallery.forEach(p => formData.append('gallery[]', p.file));

  if (isEditMode.value) {
    formData.append('_method', 'PUT');
  }

  try {
    const url = isEditMode.value
      ? `${API_BASE_URL}/api/destinations/${route.params.id}`
      : `${API_BASE_URL}/api/destinations`;

    await axios.post(url, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });

    alert('Destination saved successfully!');
    router.push('/admin/destinations');
  } catch (error) {
    console.error('Save failed:', error);
    if (error.response?.data?.errors) {
      console.error('Validation errors:', error.response.data.errors);
      const messages = Object.values(error.response.data.errors).flat().join('\n');
      alert('Validation errors:\n' + messages);
    } else {
      alert('Failed to save destination. Check console for details.');
    }
  } finally {
    isProcessing.value = false;
  }
};

onMounted(fetchDestination);
</script>

<style scoped>
.destination-editor {
  display: flex;
  flex-direction: column;
  gap: 32px;
  max-width: 1200px;
  margin: 0 auto;
}

.loader-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 100px;
  gap: 16px;
  color: #64748b;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #e2e8f0;
  border-top-color: #c5a059;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin { to { transform: rotate(360deg); } }

/* Header */
.editor-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
}

.back-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  background: transparent;
  border: none;
  color: #64748b;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  margin-bottom: 12px;
  padding: 0;
}

h1 {
  font-size: 32px;
  font-weight: 800;
  color: #1e293b;
}

.save-btn {
  background: #1a1f18;
  color: #fff;
  border: none;
  padding: 12px 32px;
  border-radius: 12px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  box-shadow: 0 4px 12px rgba(26, 31, 24, 0.2);
}

.save-btn:disabled { opacity: 0.7; }

/* Tabs */
.tabs-nav {
  display: flex;
  gap: 32px;
  border-bottom: 1px solid #e2e8f0;
}

.tab-link {
  background: transparent;
  border: none;
  padding: 16px 0;
  font-size: 14px;
  font-weight: 700;
  color: #64748b;
  cursor: pointer;
  position: relative;
}

.tab-link.active { color: #c5a059; }
.tab-link.active::after {
  content: '';
  position: absolute;
  bottom: -1px;
  left: 0;
  right: 0;
  height: 2px;
  background: #c5a059;
}

/* Card & Forms */
.card {
  background: #fff;
  padding: 40px;
  border-radius: 24px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
}

.form-group.full { grid-column: span 2; }

label {
  display: block;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  color: #94a3b8;
  margin-bottom: 8px;
}

.destination-editor input, 
.destination-editor select, 
.destination-editor textarea {
  width: 100%;
  padding: 14px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  font-size: 15px;
  color: #000000 !important;
}

.destination-editor input:focus, 
.destination-editor select:focus, 
.destination-editor textarea:focus {
  outline: none;
  border-color: #c5a059;
  background: #fff;
}

/* Highlights */
.highlights-section {
  margin-top: 40px;
  padding-top: 40px;
  border-top: 1px solid #f1f5f9;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.add-btn {
  background: #f1f5f9;
  border: none;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 700;
  color: #1a1f18;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 6px;
}

.highlights-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.highlight-item {
  display: grid;
  grid-template-columns: 240px 1fr 40px;
  gap: 16px;
  background: #f8fafc;
  padding: 20px;
  border-radius: 16px;
  align-items: start;
}

.h-title { font-weight: 700; }

.remove-btn {
  height: 40px;
  width: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fee2e2;
  color: #ef4444;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}

/* Media */
.media-grid {
  display: grid;
  grid-template-columns: 340px 1fr;
  gap: 40px;
}

.media-card.full { grid-column: span 2; }

.image-preview {
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  height: 240px;
}

.image-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.clear-btn {
  position: absolute;
  top: 12px;
  right: 12px;
  background: rgba(0,0,0,0.6);
  color: #fff;
  border: none;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 12px;
  cursor: pointer;
  backdrop-filter: blur(4px);
}

.upload-box {
  height: 240px;
  border: 2px dashed #e2e8f0;
  border-radius: 16px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 12px;
  color: #94a3b8;
  cursor: pointer;
}

.upload-box:hover {
  border-color: #c5a059;
  color: #c5a059;
  background: #fffaf0;
}

/* Asset Manager */
.card-header-flex { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
.add-asset-btn { background:#c5a059; color:#fff; border:none; padding:8px 16px; border-radius:8px; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:8px; font-size:12px; transition: 0.2s; }
.add-asset-btn:hover { background:#b08d4a; transform: translateY(-1px); }

.asset-manager { display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:24px; background:#f8fafc; padding:24px; border-radius:16px; border:1px solid #e2e8f0; }

.asset-card { background:#fff; border-radius:12px; overflow:hidden; border:1px solid #e2e8f0; transition:0.3s; position:relative; }
.asset-card:hover { transform:translateY(-4px); box-shadow:0 12px 24px rgba(0,0,0,0.08); border-color:#c5a059; }

.asset-preview { position:relative; height:150px; overflow:hidden; }
.asset-preview img { width:100%; height:100%; object-fit:cover; }

.asset-badge { position:absolute; top:8px; left:8px; background:rgba(26,31,24,0.8); color:#fff; padding:2px 8px; border-radius:4px; font-size:10px; font-weight:700; text-transform:uppercase; backdrop-filter:blur(4px); }
.asset-card.new .asset-badge { background:rgba(197,160,89,0.9); }

.asset-remove { position:absolute; top:8px; right:8px; background:rgba(239,68,68,0.9); color:#fff; border:none; width:28px; height:28px; border-radius:6px; cursor:pointer; display:flex; align-items:center; justify-content:center; opacity:0; transition:0.2s; }
.asset-card:hover .asset-remove { opacity:1; }
.asset-remove .icon { width:14px; height:14px; }

.asset-info { padding:12px; display:flex; flex-direction:column; gap:4px; }
.asset-filename { font-size:11px; font-weight:700; color:#1e293b; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.asset-size { font-size:10px; color:#64748b; font-weight:500; }

.asset-upload-placeholder { border:2px dashed #e2e8f0; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#94a3b8; cursor:pointer; height:auto; aspect-ratio:1.2; transition:0.2s; }
.asset-upload-placeholder:hover { border-color:#c5a059; color:#c5a059; background:#fff; }
.asset-upload-placeholder .icon { width:24px; height:24px; }

@media (max-width: 768px) {
  .form-grid { grid-template-columns: 1fr; }
  .highlight-item { grid-template-columns: 1fr; }
  .media-grid { grid-template-columns: 1fr; }
  .asset-manager { grid-template-columns: repeat(2, 1fr); gap:16px; padding:16px; }
}
</style>
