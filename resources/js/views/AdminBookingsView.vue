<template>
  <AdminLayout>
    <div class="booking-management">
      <div class="header-section">
        <div>
          <h1>Booking Management</h1>
          <p>Manage confirmed and pending safari expeditions</p>
        </div>
        <div class="actions">
          <button @click="fetchBookings" class="refresh-btn">
            <i-refresh class="icon" />
            Refresh
          </button>
        </div>
      </div>

      <div class="stats-overview">
        <div class="stat-box">
          <span class="label">Total Bookings</span>
          <span class="value">{{ bookings.length }}</span>
        </div>
        <div class="stat-box">
          <span class="label">Total Revenue</span>
          <span class="value">${{ totalRevenue.toLocaleString() }}</span>
        </div>
      </div>

      <div class="table-card">
        <div v-if="isLoading" class="table-loader">
          <div class="spinner"></div>
          <p>Loading bookings...</p>
        </div>
        
        <div v-else-if="bookings.length === 0" class="empty-state">
          <i-calendar class="empty-icon" />
          <h3>No Bookings Found</h3>
          <p>There are no bookings records in the system yet.</p>
        </div>

        <table v-else>
          <thead>
            <tr>
              <th>ID</th>
              <th>Traveler</th>
              <th>Expedition</th>
              <th>Amount</th>
              <th>Payment</th>
              <th>Status</th>
              <th class="actions-col"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="booking in bookings" :key="booking.id">
              <td>#{{ booking.id }}</td>
              <td>
                <div class="user-info">
                  <span class="name">{{ booking.user?.name || booking.traveler_info?.[0]?.name || 'Guest' }}</span>
                  <span class="email">{{ booking.user?.email || booking.traveler_info?.[0]?.email }}</span>
                </div>
              </td>
              <td>{{ booking.package?.title || 'Custom Trip' }}</td>
              <td>${{ number_format(booking.total_amount) }}</td>
              <td>
                <span class="payment-badge" :class="booking.payment_status">
                  {{ booking.payment_status }}
                </span>
              </td>
              <td>
                <span class="status-badge" :class="booking.status">
                  {{ booking.status }}
                </span>
              </td>
              <td class="actions-col">
                <button @click="viewBooking(booking.id)" class="view-btn">Edit</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import AdminLayout from '../components/AdminLayout.vue';
import { 
  RefreshCw as IRefresh, 
  Calendar as ICalendar
} from 'lucide-vue-next';

const router = useRouter();
const bookings = ref([]);
const isLoading = ref(true);

const fetchBookings = async () => {
  isLoading.value = true;
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/bookings');
    bookings.value = response.data;
  } catch (error) {
    console.error('Failed to fetch bookings:', error);
  } finally {
    isLoading.value = false;
  }
};

const totalRevenue = computed(() => {
  return bookings.value.reduce((sum, b) => sum + (parseFloat(b.total_amount) || 0), 0);
});

const number_format = (val) => {
  return parseFloat(val).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
};

const viewBooking = (id) => {
  router.push(`/admin/bookings/${id}`);
};

onMounted(fetchBookings);
</script>

<style scoped>
.booking-management {
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
  cursor: pointer;
}

.stats-overview {
  display: flex;
  gap: 24px;
}

.stat-box {
  background: #fff;
  padding: 20px 24px;
  border-radius: 16px;
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 4px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.stat-box .label {
  font-size: 12px;
  font-weight: 600;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.stat-box .value {
  font-size: 24px;
  font-weight: 700;
  color: #1e293b;
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
  color: #64748b;
  border-bottom: 1px solid #e2e8f0;
}

td {
  padding: 16px 24px;
  border-bottom: 1px solid #f1f5f9;
  font-size: 14px;
}

.user-info {
  display: flex;
  flex-direction: column;
}

.user-info .name { font-weight: 600; }
.user-info .email { font-size: 12px; color: #64748b; }

.payment-badge {
  display: inline-flex;
  padding: 4px 10px;
  border-radius: 100px;
  font-size: 11px;
  font-weight: 700;
}

.payment-badge.paid { background: #dcfce7; color: #16a34a; }
.payment-badge.unpaid { background: #fee2e2; color: #dc2626; }
.payment-badge.partial { background: #fef3c7; color: #d97706; }

.status-badge {
  display: inline-flex;
  padding: 4px 10px;
  border-radius: 100px;
  font-size: 11px;
  font-weight: 700;
}

.status-badge.confirmed { background: #dcfce7; color: #16a34a; }
.status-badge.pending { background: #fef3c7; color: #d97706; }
.status-badge.cancelled { background: #f1f5f9; color: #64748b; }

.actions-col { text-align: right; }

.view-btn {
  background: #f1f5f9;
  border: none;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
}

.table-loader, .empty-state {
  padding: 60px;
  text-align: center;
}

.spinner {
  width: 32px;
  height: 32px;
  border: 3px solid #f1f5f9;
  border-top-color: #c5a059;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
  margin: 0 auto 16px;
}

@keyframes spin { to { transform: rotate(360deg); } }
</style>
