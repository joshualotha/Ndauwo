<template>
  <AdminLayout>
    <div class="reviews-management">
      <div class="header-section">
        <div>
          <h1>Review & Testimonials</h1>
          <p>Moderate traveler feedback and choose what to display on the site</p>
        </div>
      </div>

      <div class="table-card">
        <div v-if="isLoading" class="loader">
          <div class="spinner"></div>
          <p>Loading reviews...</p>
        </div>

        <table v-else>
          <thead>
            <tr>
              <th>Author</th>
              <th>Rating</th>
              <th>Content</th>
              <th>Status</th>
              <th>Date</th>
              <th class="actions-col"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="review in reviews" :key="review.id">
              <td>
                <div class="author-info">
                  <span class="name">{{ review.name }}</span>
                  <span class="location">{{ review.location }}</span>
                </div>
              </td>
              <td class="rating-col">
                <div class="stars">
                  <i-star v-for="i in 5" :key="i" class="star-icon" :class="{ filled: i <= review.rating }" />
                </div>
              </td>
              <td class="content-col">
                <p class="review-text">{{ review.comment }}</p>
              </td>
              <td>
                <span class="status-badge" :class="review.active ? 'active' : 'inactive'">
                  {{ review.active ? 'Visible' : 'Hidden' }}
                </span>
              </td>
              <td class="date-col">{{ formatDate(review.created_at) }}</td>
              <td class="actions-col">
                <div class="row-actions">
                  <button @click="toggleActive(review)" class="action-btn">
                    {{ review.active ? 'Hide' : 'Show' }}
                  </button>
                  <button @click="deleteReview(review.id)" class="delete-btn"><i-trash class="icon" /></button>
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
import { API_BASE_URL } from '../composables/useSettings';
import AdminLayout from '../components/AdminLayout.vue';
import { 
  Star as IStar,
  Trash2 as ITrash
} from 'lucide-vue-next';

const reviews = ref([]);
const isLoading = ref(true);

const fetchReviews = async () => {
  isLoading.value = true;
  try {
    const response = await axios.get(`${API_BASE_URL}/api/admin/reviews?all=1`);
    reviews.value = response.data;
  } catch (error) {
    console.error('Failed to fetch reviews:', error);
  } finally {
    isLoading.value = false;
  }
};

const toggleActive = async (review) => {
  try {
    const response = await axios.post(`${API_BASE_URL}/api/reviews/${review.id}/toggle`);
    review.active = response.data.active;
  } catch (error) {
    alert('Failed to update status.');
  }
};

const deleteReview = async (id) => {
  if (!confirm('Are you sure you want to delete this review?')) return;
  try {
    await axios.delete(`${API_BASE_URL}/api/reviews/${id}`);
    fetchReviews();
  } catch (error) {
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

onMounted(fetchReviews);
</script>

<style scoped>
.reviews-management {
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

.author-info { display: flex; flex-direction: column; }
.author-info .name { font-weight: 600; font-size: 14px; }
.author-info .location { font-size: 11px; color: #94a3b8; }

.stars { display: flex; gap: 2px; }
.star-icon { width: 14px; height: 14px; color: #e2e8f0; }
.star-icon.filled { color: #f59e0b; fill: #f59e0b; }

.content-col { max-width: 400px; }
.review-text {
  font-size: 13px;
  color: #64748b;
  line-height: 1.5;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.status-badge {
  display: inline-flex;
  padding: 4px 10px;
  border-radius: 100px;
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
}
.status-badge.active { background: #dcfce7; color: #16a34a; }
.status-badge.inactive { background: #f1f5f9; color: #94a3b8; }

.date-col { font-size: 12px; color: #94a3b8; }

.actions-col { text-align: right; }
.row-actions { display: flex; align-items: center; justify-content: flex-end; gap: 12px; }

.action-btn {
  background: #f1f5f9;
  border: none;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
}

.delete-btn {
  background: transparent;
  border: none;
  color: #ef4444;
  cursor: pointer;
  padding: 4px;
}

.loader { padding: 80px; text-align: center; color: #94a3b8; }
.spinner { width: 32px; height: 32px; border: 3px solid #f1f5f9; border-top-color: #c5a059; border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 16px; }
@keyframes spin { to { transform: rotate(360deg); } }
</style>
