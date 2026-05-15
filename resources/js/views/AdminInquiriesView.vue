<template>
  <AdminLayout>
    <div class="inquiry-management">
      <div class="header-section">
        <div>
          <h1>Inquiry Management</h1>
          <p>Review and respond to expedition requests</p>
        </div>
        <div class="actions">
          <button @click="fetchInquiries" class="refresh-btn">
            <i-refresh class="icon" />
            Refresh
          </button>
        </div>
      </div>

      <div class="filters-card">
        <div class="filter-group">
          <label>Status</label>
          <select v-model="filters.status">
            <option value="">All Statuses</option>
            <option value="new">New</option>
            <option value="processing">Processing</option>
            <option value="responded">Responded</option>
            <option value="converted">Converted</option>
            <option value="closed">Closed</option>
          </select>
        </div>
      </div>

      <div class="table-card">
        <div v-if="isLoading" class="table-loader">
          <div class="spinner"></div>
          <p>Loading inquiries...</p>
        </div>
        
        <div v-else-if="inquiries.length === 0" class="empty-state">
          <i-message-square class="empty-icon" />
          <h3>No Inquiries Found</h3>
          <p>There are no inquiries matching your current filters.</p>
        </div>

        <table v-else>
          <thead>
            <tr>
              <th>Sender</th>
              <th>Package / Interest</th>
              <th>Details</th>
              <th>Status</th>
              <th>Date</th>
              <th class="actions-col"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="inquiry in filteredInquiries" :key="inquiry.id">
              <td>
                <div class="sender-info">
                  <span class="name">{{ inquiry.name }}</span>
                  <span class="email">{{ inquiry.email }}</span>
                </div>
              </td>
              <td>
                <div class="package-info">
                  <span class="title">{{ inquiry.package?.title || 'Custom Safari' }}</span>
                  <span v-if="inquiry.package_id" class="id">ID: #{{ inquiry.package_id }}</span>
                </div>
              </td>
              <td>
                <div class="details-mini">
                  <span>{{ inquiry.adults }} Adults, {{ inquiry.children }} Children</span>
                  <span>Travel: {{ inquiry.travel_date || 'Flexible' }}</span>
                </div>
              </td>
              <td>
                <span class="status-badge" :class="inquiry.status">
                  {{ inquiry.status }}
                </span>
              </td>
              <td>
                {{ formatDate(inquiry.created_at) }}
              </td>
              <td class="actions-col">
                <button @click="viewDetails(inquiry.id)" class="view-btn">Details</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import axios from 'axios';
import AdminLayout from '../components/AdminLayout.vue';
import { 
  RefreshCw as IRefresh, 
  MessageSquare as IMessageSquare,
  Search as ISearch
} from 'lucide-vue-next';

const inquiries = ref([]);
const isLoading = ref(true);
const filters = reactive({
  status: '',
  search: ''
});

const fetchInquiries = async () => {
  isLoading.value = true;
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/inquiries');
    inquiries.value = response.data;
  } catch (error) {
    console.error('Failed to fetch inquiries:', error);
  } finally {
    isLoading.value = false;
  }
};

const filteredInquiries = computed(() => {
  return inquiries.value.filter(inquiry => {
    const matchesStatus = !filters.status || inquiry.status === filters.status;
    const matchesSearch = !filters.search || 
      inquiry.name.toLowerCase().includes(filters.search.toLowerCase()) ||
      inquiry.email.toLowerCase().includes(filters.search.toLowerCase());
    return matchesStatus && matchesSearch;
  });
});

const formatDate = (dateStr) => {
  return new Date(dateStr).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric'
  });
};

const viewDetails = (id) => {
  router.push(`/admin/inquiries/${id}`);
};

onMounted(fetchInquiries);
</script>

<style scoped>
.inquiry-management {
  display: flex;
  flex-direction: column;
  gap: 32px;
}

.header-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

h1 {
  font-size: 24px;
  font-weight: 700;
  color: #0f172a;
  margin-bottom: 4px;
}

p {
  color: #64748b;
  font-size: 14px;
}

.refresh-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #fff;
  border: 1px solid #e2e8f0;
  padding: 8px 16px;
  border-radius: 10px;
  font-size: 13px;
  font-weight: 600;
  color: #475569;
  cursor: pointer;
}

.refresh-btn:hover {
  background: #f8fafc;
  border-color: #cbd5e1;
}

.icon {
  width: 14px;
  height: 14px;
}

.filters-card {
  background: #fff;
  padding: 24px;
  border-radius: 16px;
  display: flex;
  gap: 24px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.filter-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

label {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: #94a3b8;
}

select {
  padding: 8px 12px;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 13px;
  color: #000000 !important;
  background: #f8fafc !important;
}

.table-card {
  background: #fff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

table {
  width: 100%;
  border-collapse: collapse;
}

th {
  text-align: left;
  padding: 16px 24px;
  background: #f8fafc;
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  color: #64748b;
  letter-spacing: 0.05em;
  border-bottom: 1px solid #e2e8f0;
}

td {
  padding: 20px 24px;
  border-bottom: 1px solid #f1f5f9;
  vertical-align: middle;
}

.sender-info {
  display: flex;
  flex-direction: column;
}

.sender-info .name {
  font-weight: 600;
  font-size: 14px;
  color: #1e293b;
}

.sender-info .email {
  font-size: 12px;
  color: #64748b;
}

.package-info {
  display: flex;
  flex-direction: column;
}

.package-info .title {
  font-size: 13px;
  font-weight: 500;
  color: #334155;
}

.package-info .id {
  font-size: 11px;
  color: #94a3b8;
}

.details-mini {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.details-mini span {
  font-size: 12px;
  color: #64748b;
}

.status-badge {
  display: inline-flex;
  padding: 4px 10px;
  border-radius: 100px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.status-badge.new { background: #fee2e2; color: #ef4444; }
.status-badge.processing { background: #fef3c7; color: #f59e0b; }
.status-badge.responded { background: #dcfce7; color: #22c55e; }
.status-badge.converted { background: #e0f2fe; color: #0ea5e9; }
.status-badge.closed { background: #f1f5f9; color: #64748b; }

.actions-col {
  text-align: right;
}

.view-btn {
  background: #f1f5f9;
  border: none;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  color: #475569;
  cursor: pointer;
}

.view-btn:hover {
  background: #e2e8f0;
  color: #1e293b;
}

.table-loader, .empty-state {
  padding: 80px;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #f1f5f9;
  border-top-color: #c5a059;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.empty-icon {
  width: 48px;
  height: 48px;
  color: #cbd5e1;
}

h3 {
  font-size: 18px;
  font-weight: 600;
  color: #334155;
  margin-bottom: 4px;
}
</style>
