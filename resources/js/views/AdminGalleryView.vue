<template>
  <AdminLayout>
    <div class="gallery-management">
      <div class="header-section">
        <div>
          <h1>Gallery Management</h1>
          <p>Organize and manage visual assets across the platform</p>
        </div>
        <div class="actions">
          <button @click="$refs.fileInput.click()" class="upload-btn">
            <i-upload class="icon" />
            Upload Assets
            <input type="file" ref="fileInput" hidden multiple @change="handleUpload" accept="image/*">
          </button>
        </div>
      </div>

      <div class="stats-row">
        <div class="stat-card">
          <span class="label">Total Images</span>
          <span class="value">{{ images.length }}</span>
        </div>
        <div class="stat-card">
          <span class="label">Recent Uploads (7d)</span>
          <span class="value">{{ recentCount }}</span>
        </div>
      </div>

      <div class="gallery-container card">
        <div v-if="isLoading" class="loader">
          <div class="spinner"></div>
          <p>Fetching assets...</p>
        </div>

        <div v-else-if="images.length === 0" class="empty-state">
          <i-image class="empty-icon" />
          <h3>No Assets Found</h3>
          <p>Start by uploading some beautiful safari photos.</p>
        </div>

        <div v-else class="assets-grid">
          <div v-for="img in images" :key="img.id" class="asset-card">
            <div class="image-wrapper">
              <img :src="getImageUrl(img.file_path || img.path)" :alt="img.title || img.name">
              <div class="overlay">
                <button @click="deleteImage(img.id)" class="delete-btn">
                  <i-trash class="icon" />
                </button>
              </div>
            </div>
            <div class="asset-info">
              <span class="name">{{ img.title || img.name || (img.file_path ? img.file_path.split('/').pop() : 'Unknown') }}</span>
              <span class="meta">{{ formatDate(img.created_at) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { useSettings, API_BASE_URL } from '../composables/useSettings';
const { getImageUrl } = useSettings();
import AdminLayout from '../components/AdminLayout.vue';
import {
  Upload as IUpload,
  Image as IImage,
  Trash2 as ITrash
} from 'lucide-vue-next';

const images = ref([]);
const isLoading = ref(true);

const fetchImages = async () => {
  isLoading.value = true;
  try {
    const response = await axios.get(`${API_BASE_URL}/api/gallery`);
    images.value = Array.isArray(response.data) ? response.data : [];
  } catch (error) {
    console.error('Failed to fetch gallery:', error);
  } finally {
    isLoading.value = false;
  }
};

const handleUpload = async (e) => {
  const files = Array.from(e.target.files);
  if (files.length === 0) return;

  const formData = new FormData();
  files.forEach(file => formData.append('images[]', file));

  try {
    await axios.post(`${API_BASE_URL}/api/gallery/upload`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    fetchImages();
    alert('Upload successful!');
  } catch (error) {
    console.error('Upload failed:', error);
    alert('Upload failed.');
  }
};

const deleteImage = async (id) => {
  if (!confirm('Are you sure?')) return;
  try {
    await axios.delete(`${API_BASE_URL}/api/gallery/${id}`);
    fetchImages();
  } catch (error) {
    console.error('Delete failed:', error);
    alert('Delete failed.');
  }
};

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric'
  });
};

const recentCount = computed(() => {
  const sevenDaysAgo = new Date();
  sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 7);
  return images.value.filter(img => new Date(img.created_at) > sevenDaysAgo).length;
});

onMounted(fetchImages);
</script>

<style scoped>
.gallery-management {
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

.upload-btn {
  background: #c5a059;
  color: #1a1f18;
  border: none;
  padding: 12px 24px;
  border-radius: 12px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
}

.upload-btn:hover { background: #b08d4a; transform: translateY(-2px); }

.stats-row {
  display: flex;
  gap: 24px;
}

.stat-card {
  background: #fff;
  padding: 24px;
  border-radius: 16px;
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 4px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.stat-card .label { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; }
.stat-card .value { font-size: 28px; font-weight: 800; color: #1e293b; }

.card {
  background: #fff;
  border-radius: 20px;
  padding: 32px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
  min-height: 400px;
}

.assets-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 24px;
}

.asset-card {
  background: #f8fafc;
  border-radius: 16px;
  overflow: hidden;
  border: 1px solid #f1f5f9;
}

.image-wrapper {
  position: relative;
  aspect-ratio: 1;
}

.image-wrapper img { width: 100%; height: 100%; object-fit: cover; }

.overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
}

.asset-card:hover .overlay { opacity: 1; }

.delete-btn {
  background: #fee2e2;
  color: #ef4444;
  border: none;
  width: 44px;
  height: 44px;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.asset-info { padding: 12px; display: flex; flex-direction: column; gap: 2px; }
.asset-info .name { font-size: 13px; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.asset-info .meta { font-size: 11px; color: #94a3b8; }

.loader, .empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 100px 0;
  color: #94a3b8;
}

.spinner { width: 40px; height: 40px; border: 4px solid #f1f5f9; border-top-color: #c5a059; border-radius: 50%; animation: spin 0.8s linear infinite; margin-bottom: 16px; }
@keyframes spin { to { transform: rotate(360deg); } }

.empty-icon { width: 48px; height: 48px; color: #e2e8f0; margin-bottom: 16px; }
</style>
