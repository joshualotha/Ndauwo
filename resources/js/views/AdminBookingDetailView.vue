<template>
  <AdminLayout>
    <div v-if="isLoading" class="loader-container">
      <div class="spinner"></div>
      <p>Loading booking details...</p>
    </div>

    <div v-else-if="booking" class="booking-detail">
      <!-- Header -->
      <div class="detail-header">
        <div class="left">
          <button @click="$router.push('/admin/bookings')" class="back-btn">
            <i-arrow-left class="icon" />
            Back to Bookings
          </button>
          <div class="title-group">
            <h1>Booking #{{ booking.id }}</h1>
            <div class="badges">
              <span class="status-badge" :class="booking.status">{{ booking.status }}</span>
              <span class="payment-badge" :class="booking.payment_status">Payment: {{ booking.payment_status }}</span>
            </div>
          </div>
        </div>
        <div class="actions">
          <button @click="handleSave" class="save-btn" :disabled="isProcessing">
            <i-save class="icon" />
            {{ isProcessing ? 'Saving...' : 'Save Changes' }}
          </button>
        </div>
      </div>

      <div class="detail-grid">
        <!-- Main Info -->
        <div class="main-column">
          <div class="card">
            <h3><i-package class="card-icon" /> Expedition Details</h3>
            <div class="info-grid">
              <div class="info-item full">
                <label>Safari Package</label>
                <p class="highlight">{{ booking.package?.title || 'Custom Safari Expedition' }}</p>
              </div>
              <div class="info-item">
                <label>Main Contact</label>
                <p>{{ booking.user?.name || booking.traveler_info?.[0]?.name || 'Guest' }}</p>
              </div>
              <div class="info-item">
                <label>Contact Email</label>
                <p>{{ booking.user?.email || booking.traveler_info?.[0]?.email || 'N/A' }}</p>
              </div>
            </div>
          </div>

          <div class="card">
            <h3><i-users class="card-icon" /> Traveler Roster</h3>
            <div v-if="booking.traveler_info?.length" class="traveler-list">
              <div v-for="(traveler, index) in booking.traveler_info" :key="index" class="traveler-item">
                <div class="traveler-header">
                  <span class="index">Traveler {{ index + 1 }}</span>
                </div>
                <div class="traveler-body">
                  <div class="field">
                    <label>Name</label>
                    <p>{{ traveler.name }}</p>
                  </div>
                  <div class="field">
                    <label>Email</label>
                    <p>{{ traveler.email }}</p>
                  </div>
                  <div class="field">
                    <label>Phone</label>
                    <p>{{ traveler.phone }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div v-else class="empty-travelers">
              <p>No detailed traveler information provided yet.</p>
            </div>
          </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="side-column">
          <div class="card">
            <h3>Booking Status</h3>
            <div class="form-group">
              <label>Service Status</label>
              <select v-model="editForm.status">
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
                <option value="completed">Completed</option>
              </select>
            </div>
          </div>

          <div class="card">
            <h3>Financials</h3>
            <div class="form-group">
              <label>Payment Status</label>
              <select v-model="editForm.payment_status">
                <option value="unpaid">Unpaid</option>
                <option value="partial">Partial</option>
                <option value="paid">Paid</option>
                <option value="refunded">Refunded</option>
              </select>
            </div>
            <div class="form-group">
              <label>Total Amount ($)</label>
              <input type="number" v-model="editForm.total_amount" step="0.01">
            </div>
            <div class="form-group">
              <label>Paid Amount ($)</label>
              <input type="number" v-model="editForm.paid_amount" step="0.01">
            </div>
            <div class="balance-info">
              <label>Balance Due</label>
              <p :class="{ 'overpaid': balance < 0, 'paid-off': balance === 0 }">
                ${{ balance.toLocaleString(undefined, { minimumFractionDigits: 2 }) }}
              </p>
            </div>
          </div>

          <div class="card">
            <h3>Internal Notes</h3>
            <textarea 
              v-model="editForm.internal_notes" 
              rows="8" 
              placeholder="Add internal notes about this booking..."
            ></textarea>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import { API_BASE_URL } from '../composables/useSettings';
import AdminLayout from '../components/AdminLayout.vue';
import { 
  ArrowLeft as IArrowLeft,
  Save as ISave,
  Package as IPackage,
  Users as IUsers
} from 'lucide-vue-next';

const route = useRoute();
const router = useRouter();
const booking = ref(null);
const isLoading = ref(true);
const isProcessing = ref(false);

const editForm = reactive({
  status: '',
  payment_status: '',
  total_amount: 0,
  paid_amount: 0,
  internal_notes: ''
});

const balance = computed(() => {
  return (parseFloat(editForm.total_amount) || 0) - (parseFloat(editForm.paid_amount) || 0);
});

const fetchBooking = async () => {
  isLoading.value = true;
  try {
    const response = await axios.get(`${API_BASE_URL}/api/bookings/${route.params.id}`);
    booking.value = response.data;
    editForm.status = response.data.status;
    editForm.payment_status = response.data.payment_status;
    editForm.total_amount = response.data.total_amount;
    editForm.paid_amount = response.data.paid_amount || 0;
    editForm.internal_notes = response.data.internal_notes || '';
  } catch (error) {
    console.error('Failed to fetch booking:', error);
    alert('Failed to load booking details.');
  } finally {
    isLoading.value = false;
  }
};

const handleSave = async () => {
  isProcessing.value = true;
  try {
    const response = await axios.put(`${API_BASE_URL}/api/bookings/${route.params.id}`, editForm);
    booking.value = response.data;
    alert('Booking updated successfully.');
  } catch (error) {
    console.error('Failed to update booking:', error);
    alert('Error updating booking.');
  } finally {
    isProcessing.value = false;
  }
};

onMounted(fetchBooking);
</script>

<style scoped>
.booking-detail {
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
.detail-header {
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

.title-group h1 {
  font-size: 32px;
  font-weight: 800;
  color: #1e293b;
  margin-bottom: 8px;
}

.badges {
  display: flex;
  gap: 12px;
}

.status-badge {
  padding: 4px 12px;
  border-radius: 100px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
}

.status-badge.confirmed { background: #dcfce7; color: #16a34a; }
.status-badge.pending { background: #fef3c7; color: #d97706; }
.status-badge.cancelled { background: #fee2e2; color: #ef4444; }

.payment-badge {
  padding: 4px 12px;
  border-radius: 100px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  border: 1px solid #e2e8f0;
}

.payment-badge.paid { background: #dcfce7; color: #16a34a; }

.actions {
  display: flex;
  gap: 16px;
}

.save-btn {
  background: #1a1f18;
  color: #fff;
  border: none;
  padding: 12px 24px;
  border-radius: 12px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
}

.save-btn:disabled { opacity: 0.7; }

/* Grid Layout */
.detail-grid {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 32px;
}

.card {
  background: #fff;
  padding: 32px;
  border-radius: 24px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
  margin-bottom: 32px;
}

h3 {
  font-size: 16px;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 24px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.card-icon { width: 18px; color: #c5a059; }

.info-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
}

.info-item.full { grid-column: span 2; }

label {
  display: block;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  color: #94a3b8;
  margin-bottom: 6px;
}

p { font-size: 15px; color: #1e293b; font-weight: 500; }
p.highlight { font-size: 18px; font-weight: 700; color: #1a1f18; }

/* Traveler Roster */
.traveler-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.traveler-item {
  background: #f8fafc;
  border-radius: 16px;
  overflow: hidden;
  border: 1px solid #f1f5f9;
}

.traveler-header {
  background: #f1f5f9;
  padding: 8px 16px;
  font-size: 11px;
  font-weight: 700;
  color: #64748b;
  text-transform: uppercase;
}

.traveler-body {
  padding: 16px;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
}

/* Sidebar Controls */
.form-group {
  margin-bottom: 20px;
}

select, input, textarea {
  width: 100%;
  padding: 12px;
  background: #f8fafc !important;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  font-size: 14px;
  color: #000000 !important;
}

.balance-info {
  margin-top: 24px;
  padding-top: 24px;
  border-top: 1px solid #f1f5f9;
}

.balance-info p {
  font-size: 24px;
  font-weight: 800;
  color: #ef4444;
}

.balance-info p.paid-off { color: #16a34a; }
.balance-info p.overpaid { color: #3b82f6; }

textarea { resize: none; font-family: inherit; }

@media (max-width: 1024px) {
  .detail-grid { grid-template-columns: 1fr; }
  .traveler-body { grid-template-columns: 1fr; }
}
</style>
