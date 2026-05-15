<template>
  <AdminLayout>
    <div class="destination-management">
      <div class="header-section">
        <div>
          <h1>Destinations</h1>
          <p>Manage safari locations and park details</p>
        </div>
        <div class="actions">
          <router-link to="/admin/destinations/create" class="add-btn">
            <i-plus class="icon" />
            Add Destination
          </router-link>
        </div>
      </div>

      <div class="grid-card">
        <div v-if="isLoading" class="loader">
          <div class="spinner"></div>
        </div>

        <div v-else class="destinations-grid">
          <div v-for="dest in destinations" :key="dest.id" class="dest-card">
            <div class="image-wrapper">
              <img :src="getImageUrl(dest.image)" :alt="dest.name">
              <div class="badge">{{ dest.type }}</div>
            </div>
            <div class="card-content">
              <h3>{{ dest.name }}</h3>
              <p class="slug">{{ dest.slug }}</p>
              <div class="meta">
                <span>{{ dest.highlights?.length || 0 }} Highlights</span>
                <span>•</span>
                <span>{{ dest.packages_count || 0 }} Packages</span>
              </div>
              <div class="card-actions">
                <router-link :to="`/admin/destinations/edit/${dest.id}`" class="edit-btn">Edit Details</router-link>
                <button @click="deleteDestination(dest.id)" class="delete-btn"><i-trash /></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useSettings, API_BASE_URL } from '../composables/useSettings';
const { getImageUrl } = useSettings();
import AdminLayout from '../components/AdminLayout.vue';
import { 
  Plus as IPlus, 
  Trash2 as ITrash
} from 'lucide-vue-next';

const destinations = ref([]);
const isLoading = ref(true);

const fetchDestinations = async () => {
  isLoading.value = true;
  try {
    const response = await axios.get(`${API_BASE_URL}/api/destinations`);
    destinations.value = response.data;
  } catch (error) {
    console.error('Failed to fetch destinations:', error);
  } finally {
    isLoading.value = false;
  }
};

const deleteDestination = async (id) => {
  if (!confirm('Are you sure you want to delete this destination?')) return;
  try {
    await axios.delete(`${API_BASE_URL}/api/destinations/${id}`);
    fetchDestinations();
  } catch (error) {
    console.error('Failed to delete:', error);
    alert('Delete failed.');
  }
};

onMounted(fetchDestinations);
</script>

<style scoped>
.destination-management {
  display: flex;
  flex-direction: column;
  gap: 32px;
}

.header-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

h1 { font-size: 24px; font-weight: 700; }

.add-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #1a1f18;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 12px;
  font-weight: 600;
  cursor: pointer;
}

.add-btn:hover { background: #2d3629; transform: translateY(-2px); }

.destinations-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 24px;
}

.dest-card {
  background: #fff;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.dest-card:hover { transform: translateY(-4px); }

.image-wrapper {
  position: relative;
  height: 180px;
}

.image-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.badge {
  position: absolute;
  top: 16px;
  right: 16px;
  background: rgba(26, 31, 24, 0.8);
  backdrop-filter: blur(4px);
  color: #fff;
  padding: 4px 12px;
  border-radius: 100px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
}

.card-content {
  padding: 24px;
}

h3 { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
.slug { font-size: 12px; color: #94a3b8; font-family: monospace; margin-bottom: 12px; }

.meta {
  display: flex;
  gap: 8px;
  font-size: 13px;
  color: #64748b;
  margin-bottom: 20px;
}

.card-actions {
  display: flex;
  gap: 12px;
}

.edit-btn {
  flex: 1;
  background: #f1f5f9;
  border: none;
  padding: 10px;
  border-radius: 10px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
}

.delete-btn {
  width: 40px;
  background: #fee2e2;
  color: #ef4444;
  border: none;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.loader { padding: 80px; text-align: center; }
.spinner { width: 40px; height: 40px; border: 4px solid #f1f5f9; border-top-color: #c5a059; border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto; }
@keyframes spin { to { transform: rotate(360deg); } }
</style>
