<template>
  <AdminLayout>
    <div v-if="isLoading" class="loader-container">
      <div class="spinner"></div>
      <p>Loading package data...</p>
    </div>

    <form v-else @submit.prevent="handleSave" class="package-editor">
      <!-- Header -->
      <div class="editor-header">
        <div class="left">
          <button type="button" @click="$router.push('/admin/packages')" class="back-btn">
            <i-arrow-left class="icon" />
            Cancel
          </button>
          <h1>{{ isEditMode ? 'Edit Safari Package' : 'New Safari Package' }}</h1>
        </div>
        <div class="actions">
          <button type="submit" class="save-btn" :disabled="isProcessing">
            <i-save class="icon" />
            {{ isProcessing ? 'Saving...' : 'Save Package' }}
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
              <label>Package Title</label>
              <input type="text" v-model="form.title" required placeholder="e.g. 7-Day Classic Serengeti Safari">
            </div>
            <div class="form-group full">
              <label>Location Summary</label>
              <input type="text" v-model="form.location_summary" placeholder="e.g. Serengeti, Ngorongoro & Manyara">
            </div>
            <div class="form-group">
              <label>Duration Label</label>
              <input type="text" v-model="form.duration_label" placeholder="e.g. 7 Days · 6 Nights">
            </div>
            <div class="form-group">
              <label>Group Size</label>
              <input type="text" v-model="form.group_size" placeholder="e.g. 2 - 8 Guests">
            </div>
            <div class="form-group">
              <label>Safari Type</label>
              <select v-model="form.type">
                <option value="wildlife">Wildlife Safari</option>
                <option value="mountain">Mountain Trek</option>
                <option value="beach">Beach Holiday</option>
                <option value="cultural">Cultural Tour</option>
              </select>
            </div>
            <div class="form-group">
              <label>Difficulty Level</label>
              <select v-model="form.difficulty_level">
                <option value="Easy">Easy</option>
                <option value="Moderate">Moderate</option>
                <option value="Strenuous">Strenuous</option>
              </select>
            </div>
            <div class="form-group">
              <label>Duration (Days)</label>
              <input type="number" v-model="form.duration_days" min="1">
            </div>
            <div class="form-group">
              <label>Base Price ($)</label>
              <input type="number" v-model="form.price" step="0.01">
            </div>
            <div class="form-group full">
              <label>Main Description</label>
              <textarea v-model="form.description" rows="6"></textarea>
            </div>
          </div>
        </div>

        <!-- Itinerary Builder -->
        <div v-show="activeTab === 1" class="tab-panel">
          <div class="section-header">
            <h3>Day-by-Day Itinerary</h3>
            <button type="button" @click="addItineraryDay" class="add-btn">
              <i-plus class="icon" /> Add Day
            </button>
          </div>
          <div class="itinerary-list">
            <div v-for="(day, idx) in form.daily_itinerary" :key="idx" class="itinerary-item">
              <div class="day-num">Day {{ idx + 1 }}</div>
              <div class="itinerary-fields">
                <input type="text" v-model="day.title" placeholder="Daily Title (e.g. Arrival in Arusha)">
                <input type="text" v-model="day.accommodation" placeholder="Accommodation (e.g. Gran Melia Arusha)">
                <textarea v-model="day.description" rows="3" placeholder="Describe the day's activities..."></textarea>
              </div>
              <button type="button" @click="removeItineraryDay(idx)" class="remove-btn">
                <i-trash class="icon" />
              </button>
            </div>
          </div>
        </div>

        <!-- Lists & Features -->
        <div v-show="activeTab === 2" class="tab-panel">
          <div class="list-grid">
            <div class="list-manager">
              <h3>Highlights</h3>
              <div v-for="(h, idx) in form.highlights" :key="idx" class="list-item">
                <input type="text" v-model="form.highlights[idx]">
                <button type="button" @click="removeItem('highlights', idx)">×</button>
              </div>
              <button type="button" @click="addItem('highlights')" class="add-link">+ Add Highlight</button>
            </div>

            <div class="list-manager">
              <h3>Inclusions</h3>
              <div v-for="(h, idx) in form.inclusions" :key="idx" class="list-item">
                <input type="text" v-model="form.inclusions[idx]">
                <button type="button" @click="removeItem('inclusions', idx)">×</button>
              </div>
              <button type="button" @click="addItem('inclusions')" class="add-link">+ Add Inclusion</button>
            </div>

            <div class="list-manager">
              <h3>Exclusions</h3>
              <div v-for="(h, idx) in form.exclusions" :key="idx" class="list-item">
                <input type="text" v-model="form.exclusions[idx]">
                <button type="button" @click="removeItem('exclusions', idx)">×</button>
              </div>
              <button type="button" @click="addItem('exclusions')" class="add-link">+ Add Exclusion</button>
            </div>
          </div>
        </div>

        <!-- Media -->
        <div v-show="activeTab === 3" class="tab-panel">
          <div class="media-grid">
            <div class="media-card">
              <label>Featured Image</label>
              <div class="image-preview" v-if="previews.image || form.image">
                <img :src="previews.image || 'http://127.0.0.1:8000/storage/' + form.image">
                <button type="button" @click="clearImage" class="clear-btn">Remove</button>
              </div>
              <div class="upload-box" v-else @click="$refs.imageInput.click()">
                <i-upload class="icon" />
                <span>Upload Image</span>
                <input type="file" ref="imageInput" hidden @change="handleImageUpload" accept="image/*">
              </div>
            </div>

            <div class="media-card full">
              <label>Gallery</label>
              <div class="gallery-grid">
                <div v-for="(img, idx) in combinedGallery" :key="idx" class="gallery-item">
                  <img :src="img.url">
                  <button type="button" @click="removeGalleryItem(img)" class="remove-btn">×</button>
                </div>
                <div class="upload-box mini" @click="$refs.galleryInput.click()">
                  <i-plus class="icon" />
                  <input type="file" ref="galleryInput" hidden multiple @change="handleGalleryUpload" accept="image/*">
                </div>
              </div>
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
import { 
  ArrowLeft as IArrowLeft,
  Save as ISave,
  Plus as IPlus,
  Trash2 as ITrash,
  Upload as IUpload
} from 'lucide-vue-next';

const route = useRoute();
const router = useRouter();
const isEditMode = computed(() => !!route.params.id);
const isLoading = ref(false);
const isProcessing = ref(false);
const activeTab = ref(0);
const tabs = ['General Info', 'Itinerary', 'Highlights & Lists', 'Media'];

const form = reactive({
  title: '',
  hero_label: '',
  location_summary: '',
  duration_label: '',
  group_size: '',
  type: 'wildlife',
  difficulty_level: 'Moderate',
  duration_days: 1,
  price: 0,
  description: '',
  highlights: [],
  inclusions: [],
  exclusions: [],
  daily_itinerary: [],
  image: null,
  gallery: [],
  existing_gallery: [],
  active: true,
  featured: false
});

const previews = reactive({
  image: null,
  gallery: []
});

const combinedGallery = computed(() => {
  const existing = form.existing_gallery.map(path => ({ url: 'http://127.0.0.1:8000/storage/' + path, path, type: 'existing' }));
  const news = previews.gallery.map(p => ({ url: p.url, file: p.file, type: 'new' }));
  return [...existing, ...news];
});

const fetchPackage = async () => {
  if (!isEditMode.value) return;
  isLoading.value = true;
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/packages/${route.params.id}`);
    const data = response.data;
    
    Object.keys(form).forEach(key => {
        if (data.hasOwnProperty(key)) {
            if (['highlights', 'inclusions', 'exclusions', 'daily_itinerary', 'gallery'].includes(key)) {
                form[key] = data[key] || [];
            } else {
                form[key] = data[key];
            }
        }
    });
    form.existing_gallery = Array.isArray(data.gallery) ? data.gallery : [];
  } catch (error) {
    console.error('Failed to fetch package:', error);
    alert('Error loading package.');
    router.push('/admin/packages');
  } finally {
    isLoading.value = false;
  }
};

const addItineraryDay = () => form.daily_itinerary.push({ title: '', description: '', accommodation: '' });
const removeItineraryDay = (idx) => form.daily_itinerary.splice(idx, 1);

const addItem = (list) => form[list].push('');
const removeItem = (list, idx) => form[list].splice(idx, 1);

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
  
  Object.keys(form).forEach(key => {
    if (['highlights', 'inclusions', 'exclusions', 'daily_itinerary', 'gallery', 'existing_gallery', 'image', 'new_image'].includes(key)) return;
    if (form[key] !== null && form[key] !== undefined) formData.append(key, form[key]);
  });

  formData.append('highlights', JSON.stringify(form.highlights));
  formData.append('inclusions', JSON.stringify(form.inclusions));
  formData.append('exclusions', JSON.stringify(form.exclusions));
  formData.append('daily_itinerary', JSON.stringify(form.daily_itinerary));
  form.existing_gallery.forEach(p => formData.append('existing_gallery[]', p));

  if (form.new_image) formData.append('image', form.new_image);
  previews.gallery.forEach(p => formData.append('gallery[]', p.file));

  if (isEditMode.value) formData.append('_method', 'PUT');

  try {
    const url = isEditMode.value 
      ? `http://127.0.0.1:8000/api/packages/${route.params.id}`
      : `http://127.0.0.1:8000/api/packages`;
    
    await axios.post(url, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    
    alert('Package saved successfully!');
    router.push('/admin/packages');
  } catch (error) {
    if (error.response && error.response.status === 422) {
      console.error('Validation Error:', error.response.data);
      const errors = error.response.data.errors || {};
      const errorMsg = Object.values(errors).flat().join('\n');
      alert(`Validation Failed:\n${errorMsg}`);
    } else {
      console.error('Save failed:', error);
      alert('Failed to save package.');
    }
  } finally {
    isProcessing.value = false;
  }
};

onMounted(fetchPackage);
</script>

<style scoped>
.package-editor {
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

input, select, textarea {
  width: 100%;
  padding: 14px;
  background: #f8fafc !important;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  font-size: 15px;
  color: #000000 !important;
}

/* Itinerary */
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
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 6px;
}

.itinerary-list { display: flex; flex-direction: column; gap: 24px; }

.itinerary-item {
  display: grid;
  grid-template-columns: 80px 1fr 40px;
  gap: 24px;
  background: #f8fafc;
  padding: 24px;
  border-radius: 20px;
  align-items: start;
}

.day-num {
  font-size: 18px;
  font-weight: 800;
  color: #c5a059;
}

.itinerary-fields { display: flex; flex-direction: column; gap: 16px; }

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

/* Lists */
.list-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 32px;
}

.list-manager h3 {
  font-size: 14px;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 16px;
}

.list-item {
  display: flex;
  gap: 8px;
  margin-bottom: 8px;
}

.list-item input { padding: 8px 12px; font-size: 13px; }

.list-item button {
  background: transparent;
  border: none;
  color: #94a3b8;
  cursor: pointer;
  font-size: 18px;
}

.add-link {
  background: transparent;
  border: none;
  color: #c5a059;
  font-weight: 700;
  font-size: 13px;
  cursor: pointer;
  margin-top: 8px;
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

.image-preview img { width: 100%; height: 100%; object-fit: cover; }

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

.gallery-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
  gap: 16px;
}

.gallery-item {
  position: relative;
  aspect-ratio: 1;
  border-radius: 12px;
  overflow: hidden;
}

.gallery-item img { width: 100%; height: 100%; object-fit: cover; }

.upload-box.mini { aspect-ratio: 1; height: auto; }

@media (max-width: 1024px) {
  .list-grid { grid-template-columns: 1fr; }
  .itinerary-item { grid-template-columns: 1fr; }
  .media-grid { grid-template-columns: 1fr; }
}
</style>
