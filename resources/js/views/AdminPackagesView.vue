<template>
  <AdminLayout>
    <div class="package-management">
      <div class="header-section">
        <div>
          <h1>Safari Packages</h1>
          <p>Manage itineraries, inclusions, and pricing</p>
        </div>
        <div class="actions">
          <router-link to="/admin/packages/create" class="add-btn">
            <i-plus class="icon" />
            Create New Package
          </router-link>
        </div>
      </div>

      <div class="table-card">
        <div v-if="isLoading" class="loader">
          <div class="spinner"></div>
        </div>

        <table v-else>
          <thead>
            <tr>
              <th>Image</th>
              <th>Package Title</th>
              <th>Category</th>
              <th>Duration</th>
              <th>Price</th>
              <th>Status</th>
              <th class="actions-col"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="pkg in packages" :key="pkg.id">
              <td class="img-col">
                <img :src="getImageUrl(pkg.image)" :alt="pkg.title">
              </td>
              <td>
                <div class="title-info">
                  <span class="title">{{ pkg.title }}</span>
                  <span class="slug">{{ pkg.slug }}</span>
                </div>
              </td>
              <td>{{ pkg.category }}</td>
              <td>{{ pkg.duration_days }} Days</td>
              <td>${{ pkg.price?.toLocaleString() }}</td>
              <td>
                <span class="status-badge" :class="pkg.is_active ? 'active' : 'inactive'">
                  {{ pkg.is_active ? 'Active' : 'Draft' }}
                </span>
              </td>
              <td class="actions-col">
                <div class="row-actions">
                  <router-link :to="`/admin/packages/edit/${pkg.id}`" class="edit-btn">Edit</router-link>
                  <button @click="deletePackage(pkg.id)" class="delete-btn" title="Delete Package"><i-trash /></button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
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
  MoreHorizontal as IMore,
  Trash2 as ITrash
} from 'lucide-vue-next';

const packages = ref([]);
const isLoading = ref(true);

const fetchPackages = async () => {
  isLoading.value = true;
  try {
    const response = await axios.get(`${API_BASE_URL}/api/packages`);
    packages.value = response.data;
  } catch (error) {
    console.error('Failed to fetch packages:', error);
  } finally {
    isLoading.value = false;
  }
};

const deletePackage = async (id) => {
  if (!confirm('Are you sure you want to delete this package?')) return;
  try {
    await axios.delete(`${API_BASE_URL}/api/packages/${id}`);
    fetchPackages();
  } catch (error) {
    console.error('Failed to delete package:', error);
    alert('Failed to delete package.');
  }
};

onMounted(fetchPackages);
</script>

<style scoped>
.package-management {
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
  background: #c5a059;
  color: #1a1f18;
  border: none;
  padding: 10px 20px;
  border-radius: 12px;
  font-weight: 700;
  cursor: pointer;
}

.table-card {
  background: #fff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

table { width: 100%; border-collapse: collapse; }

th {
  text-align: left;
  padding: 16px 24px;
  background: #f8fafc;
  font-size: 12px;
  font-weight: 700;
  color: #64748b;
  border-bottom: 1px solid #e2e8f0;
}

td { padding: 16px 24px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }

.img-col img { width: 80px; height: 50px; object-fit: cover; border-radius: 8px; }

.title-info { display: flex; flex-direction: column; }
.title-info .title { font-weight: 600; font-size: 14px; }
.title-info .slug { font-size: 11px; color: #94a3b8; font-family: monospace; }

.status-badge {
  display: inline-flex;
  padding: 4px 10px;
  border-radius: 100px;
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
}

.status-badge.active { background: #dcfce7; color: #16a34a; }
.status-badge.inactive { background: #f1f5f9; color: #64748b; }

.actions-col { text-align: right; }
.row-actions { display: flex; align-items: center; justify-content: flex-end; gap: 8px; }

.edit-btn {
  background: #f1f5f9;
  border: none;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
}

.delete-btn {
  background: #fee2e2;
  border: none;
  color: #ef4444;
  cursor: pointer;
  border-radius: 6px;
  padding: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: opacity 0.3s;
}

.delete-btn:hover {
  opacity: 0.8;
}

.delete-btn svg {
  width: 16px;
  height: 16px;
}

.loader { padding: 80px; text-align: center; }
.spinner { width: 32px; height: 32px; border: 3px solid #f1f5f9; border-top-color: #c5a059; border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto; }
@keyframes spin { to { transform: rotate(360deg); } }
</style>
