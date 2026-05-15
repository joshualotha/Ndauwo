<template>
  <AdminLayout>
    <div class="page-images-management">
      <div class="header-section">
        <div>
          <h1>Site Assets & Imagry</h1>
          <p>Manage static background and content images across the website</p>
        </div>
      </div>

      <div class="alert-info">
        <i-info class="alert-icon" />
        <p>Select a page below to view and update its associated imagery. We recommend uploading compressed, high-quality WebP or JPEG images under 1MB.</p>
      </div>

      <!-- Loading State -->
      <div v-if="isLoading" class="loading-state">
        <div class="spinner"></div>
        <p>Loading page assets...</p>
      </div>

      <!-- Content State -->
      <div v-else class="content-wrapper">
        <!-- Sidebar Navigation for Pages -->
        <div class="page-navigation">
          <h3>Manage Pages</h3>
          <ul class="page-list">
            <li 
              v-for="(images, pageName) in groupedImages" 
              :key="pageName"
              :class="{ active: activePage === pageName }"
              @click="activePage = pageName"
            >
              <div class="page-name">{{ formatPageName(pageName) }}</div>
              <div class="image-count">{{ images.length }} assets</div>
            </li>
          </ul>
        </div>

        <!-- Main Content for Selected Page -->
        <div class="images-display">
          <div class="display-header">
            <h2>{{ formatPageName(activePage) }} Assets</h2>
          </div>
          
          <div v-if="activePage && groupedImages[activePage]" class="images-grid">
            <div v-for="img in groupedImages[activePage]" :key="img.id" class="image-card">
              <div class="thumbnail-preview">
                <img :src="previews[`${img.page}_${img.section}`] || getImageUrl(img.image_path)" :alt="img.description" :class="{ 'preview-mode': previews[`${img.page}_${img.section}`] }" />
                <div class="image-overlay">
                  <span class="section-badge">{{ img.section }}</span>
                </div>
              </div>
              <div class="card-body">
                <h4>{{ img.description }}</h4>
                <p class="file-path truncate" :title="img.image_path">{{ img.image_path }}</p>
                
                <div class="upload-controls">
                  <input 
                    type="file" 
                    :ref="el => fileInputs[`${img.page}_${img.section}`] = el" 
                    accept="image/jpeg,image/png,image/webp" 
                    class="hidden"
                    @change="e => handleFileSelect(e, img)"
                  />
                  <button class="upload-btn" @click="triggerUpload(img.page, img.section)" :disabled="isUploading === img.id">
                    <i-upload v-if="isUploading !== img.id" class="btn-icon" />
                    <span v-if="isUploading === img.id" class="spinner-small"></span>
                    {{ isUploading === img.id ? 'Uploading...' : 'Replace Image' }}
                  </button>
                  <span v-if="selectedFiles[`${img.page}_${img.section}`]" class="file-selected">
                    1 file selected
                  </span>
                  
                  <div v-if="uploadStatuses[`${img.page}_${img.section}`]" :class="['upload-status', uploadStatuses[`${img.page}_${img.section}`].type]">
                    {{ uploadStatuses[`${img.page}_${img.section}`].msg }}
                  </div>
                </div>
                <!-- Action Buttons if a file is selected -->
                <div v-if="selectedFiles[`${img.page}_${img.section}`]" class="confirm-actions">
                  <button class="save-btn" @click="uploadImage(img)">Save Replacement</button>
                  <button class="cancel-btn" @click="clearSelection(img.page, img.section)">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { useSettings, API_BASE_URL } from '../composables/useSettings';
const { getImageUrl } = useSettings();
import AdminLayout from '../components/AdminLayout.vue';
import { 
  Info as IInfo,
  Upload as IUpload
} from 'lucide-vue-next';

// State
const groupedImages = ref({});
const activePage = ref('');
const isLoading = ref(true);
const isUploading = ref(null);
const fileInputs = ref({});
const selectedFiles = ref({});
const previews = ref({});
const uploadStatuses = ref({}); // { 'page_section': { type: 'success'|'error', msg: '' } }

// Fetch Data
const fetchImages = async () => {
  isLoading.value = true;
  try {
    const response = await axios.get(`${API_BASE_URL}/api/page-images/all`);
    groupedImages.value = response.data;
    
    // Set initial active tab
    const pages = Object.keys(response.data);
    if (pages.length > 0 && !activePage.value) {
      activePage.value = pages[0];
    }
  } catch (error) {
    console.error('Failed to fetch page images:', error);
    alert('Failed to load assets. Please try again.');
  } finally {
    isLoading.value = false;
  }
};

// File Selection
const triggerUpload = (page, section) => {
  const el = fileInputs.value[`${page}_${section}`];
  if (el) el.click();
};

const handleFileSelect = (event, img) => {
  const file = event.target.files[0];
  if (file) {
    if (file.size > 5 * 1024 * 1024) {
      alert('File size exceeds 5MB limit.');
      clearSelection(img.page, img.section);
      return;
    }
    const key = `${img.page}_${img.section}`;
    selectedFiles.value[key] = file;
    
    // Create preview
    const reader = new FileReader();
    reader.onload = (e) => {
      previews.value[key] = e.target.result;
    };
    reader.readAsDataURL(file);
    
    // Clear status
    delete uploadStatuses.value[key];
  }
};

const clearSelection = (page, section) => {
  const key = `${page}_${section}`;
  delete selectedFiles.value[key];
  delete previews.value[key];
  const el = fileInputs.value[key];
  if (el) el.value = '';
};

// Upload
const uploadImage = async (img) => {
  const key = `${img.page}_${img.section}`;
  const file = selectedFiles.value[key];
  if (!file) return;

  isUploading.value = img.id;
  delete uploadStatuses.value[key];
  
  const formData = new FormData();
  formData.append('page', img.page);
  formData.append('section', img.section);
  formData.append('image', file);

  try {
    const token = localStorage.getItem('admin_token');
    const response = await axios.post(`${API_BASE_URL}/api/admin/page-images`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        'Authorization': `Bearer ${token}`
      }
    });
    
    // Update local state
    const storedIndex = groupedImages.value[img.page].findIndex(i => i.id === img.id);
    if (storedIndex !== -1) {
      groupedImages.value[img.page][storedIndex] = response.data.image;
    }
    
    uploadStatuses.value[key] = { type: 'success', msg: 'Updated successfully!' };
    clearSelection(img.page, img.section);
  } catch (error) {
    console.error('Upload failed:', error);
    uploadStatuses.value[key] = { type: 'error', msg: 'Upload failed. Try again.' };
  } finally {
    isUploading.value = null;
  }
};

// Helpers
const formatPageName = (str) => {
  if (!str) return '';
  if (str.toLowerCase() === 'blog') return 'Journal';
  return str.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
};



onMounted(fetchImages);
</script>

<style scoped>
.page-images-management {
  display: flex;
  flex-direction: column;
  gap: 32px;
}

.header-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

h1 { font-size: 24px; font-weight: 700; color: #1e293b; }
p { color: #64748b; font-size: 14px; margin-top: 4px; }

.alert-info {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  background: #f0fdf4;
  border: 1px solid #bbf7d0;
  padding: 16px;
  border-radius: 12px;
  color: #166534;
}

.alert-icon { width: 20px; height: 20px; flex-shrink: 0; margin-top: 2px; }
.alert-info p { margin: 0; color: inherit; font-size: 13.5px; line-height: 1.5; }

.content-wrapper {
  display: flex;
  gap: 32px;
  align-items: flex-start;
}

/* Sidebar */
.page-navigation {
  width: 250px;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
  padding: 24px;
  flex-shrink: 0;
  position: sticky;
  top: 100px;
}

.page-navigation h3 {
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: #c5a059;
  margin-bottom: 20px;
  font-weight: 700;
}

.page-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.page-list li {
  padding: 12px 16px;
  border-radius: 10px;
  cursor: pointer;
  border: 1px solid transparent;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: #475569;
}

.page-list li:hover {
  background: #f8fafc;
  color: #1e293b;
}

.page-list li.active {
  background: #1a1f18;
  color: #fff;
}

.page-name { font-weight: 600; font-size: 14px; }
.image-count { font-size: 11px; opacity: 0.7; font-weight: 500; }

/* Display Area */
.images-display {
  flex: 1;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
  padding: 32px;
}

.display-header {
  margin-bottom: 32px;
  padding-bottom: 16px;
  border-bottom: 1px solid #e2e8f0;
}

.display-header h2 {
  font-size: 20px;
  color: #1a1f18;
}

.images-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 24px;
}

.image-card {
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  overflow: hidden;
  background: #fff;
  display: flex;
  flex-direction: column;
}

.thumbnail-preview {
  height: 180px;
  position: relative;
  background: #f1f5f9;
}

.thumbnail-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.image-overlay {
  position: absolute;
  top: 12px;
  right: 12px;
}

.section-badge {
  background: rgba(26, 31, 24, 0.85);
  color: #fff;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.05em;
  backdrop-filter: blur(4px);
}

.card-body {
  padding: 20px;
  display: flex;
  flex-direction: column;
  flex: 1;
}

.card-body h4 {
  font-size: 15px;
  color: #1e293b;
  margin-bottom: 6px;
}

.file-path {
  font-size: 11px;
  color: #94a3b8;
  margin-bottom: 20px;
  font-family: monospace;
}

.truncate {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.upload-controls {
  margin-top: auto;
  display: flex;
  flex-direction: column;
  gap: 10px;
  align-items: flex-start;
}

.thumbnail-preview img.preview-mode {
  border: 2px solid var(--gold);
  padding: 4px;
  background: rgba(201, 168, 76, 0.1);
}

.upload-status {
  font-size: 0.85rem;
  margin-top: 8px;
  padding: 6px 12px;
  border-radius: 4px;
  font-weight: 500;
}

.upload-status.success {
  background: rgba(46, 125, 50, 0.1);
  color: #2e7d32;
  border-left: 3px solid #2e7d32;
}

.upload-status.error {
  background: rgba(211, 47, 47, 0.1);
  color: #d32f2f;
  border-left: 3px solid #d32f2f;
}

.save-btn {
  background: var(--gold);
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 600;
  transition: all 0.3s;
}

.save-btn:hover {
  background: var(--gold-dark);
  transform: translateY(-1px);
}

.cancel-btn {
  background: transparent;
  color: #666;
  border: 1px solid #ccc;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.3s;
}

.cancel-btn:hover {
  background: #f5f5f5;
}

.confirm-actions {
  display: flex;
  gap: 10px;
  margin-top: 15px;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(5px); }
  to { opacity: 1; transform: translateY(0); }
}

.hidden { display: none; }

.upload-btn {
  background: #f8fafc;
  border: 1px solid #cbd5e1;
  color: #334155;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 6px;
}

.upload-btn:hover:not(:disabled) {
  background: #f1f5f9;
  border-color: #94a3b8;
}

.upload-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-icon { width: 14px; height: 14px; }

.file-selected {
  font-size: 12px;
  color: #c5a059;
  font-weight: 600;
}

.confirm-actions {
  display: flex;
  gap: 10px;
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px dashed #e2e8f0;
}

.save-btn {
  flex: 1;
  background: #10b981;
  color: #fff;
  border: none;
  padding: 8px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
}

.save-btn:hover { background: #059669; }

.cancel-btn {
  flex: 1;
  background: #f1f5f9;
  color: #64748b;
  border: none;
  padding: 8px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
}

.cancel-btn:hover { background: #e2e8f0; }

.loading-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 100px 0;
  color: #94a3b8;
  gap: 16px;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 3px solid #f1f5f9;
  border-top-color: #c5a059;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

.spinner-small {
  width: 14px;
  height: 14px;
  border: 2px solid rgba(51, 65, 85, 0.3);
  border-top-color: #334155;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  display: inline-block;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

@media (max-width: 1024px) {
  .content-wrapper {
    flex-direction: column;
  }
  .page-navigation {
    width: 100%;
    position: static;
  }
}
</style>
