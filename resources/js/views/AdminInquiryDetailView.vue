<template>
  <AdminLayout>
    <div v-if="isLoading" class="loader-container">
      <div class="spinner"></div>
      <p>Fetching inquiry details...</p>
    </div>

    <div v-else-if="inquiry" class="inquiry-detail">
      <!-- Header -->
      <div class="detail-header">
        <div class="left">
          <button @click="$router.push('/admin/inquiries')" class="back-btn">
            <i-arrow-left class="icon" />
            Back to List
          </button>
          <div class="title-group">
            <h1>Inquiry #{{ inquiry.id }}</h1>
            <div class="badges">
              <span class="status-badge" :class="inquiry.status">{{ inquiry.status }}</span>
              <span class="priority-badge" :class="inquiry.priority">{{ inquiry.priority }} Priority</span>
            </div>
          </div>
        </div>
        <div class="actions">
          <button 
            v-if="inquiry.status !== 'converted'" 
            @click="handleConvert" 
            class="convert-btn"
            :disabled="isProcessing"
          >
            <i-check-circle class="icon" />
            Convert to Booking
          </button>
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
            <h3><i-user class="card-icon" /> Traveler Information</h3>
            <div class="info-grid">
              <div class="info-item">
                <label>Full Name</label>
                <p>{{ inquiry.name }}</p>
              </div>
              <div class="info-item">
                <label>Email Address</label>
                <p>{{ inquiry.email }}</p>
              </div>
              <div class="info-item">
                <label>Phone Number</label>
                <p>{{ inquiry.phone || 'N/A' }}</p>
              </div>
              <div class="info-item">
                <label>How they found us</label>
                <p>{{ inquiry.referral_source || 'N/A' }}</p>
              </div>
            </div>
          </div>

          <div class="card">
            <h3><i-map-pin class="card-icon" /> Expedition Interests</h3>
            <div class="info-grid">
              <div class="info-item full">
                <label>Package / Interest</label>
                <p class="highlight">{{ inquiry.package?.title || 'Custom Safari Expedition' }}</p>
              </div>
              <div class="info-item">
                <label>Travel Date</label>
                <p>{{ inquiry.travel_date || 'Flexible' }}</p>
              </div>
              <div class="info-item">
                <label>Party Size</label>
                <p>{{ inquiry.adults }} Adults, {{ inquiry.children }} Children</p>
              </div>
              <div class="info-item">
                <label>Budget Range</label>
                <p>{{ inquiry.budget_range || 'Not specified' }}</p>
              </div>
            </div>
            <div class="message-box">
              <label>Personal Message</label>
              <div class="message-content">
                {{ inquiry.message }}
              </div>
            </div>
            <div v-if="inquiry.preferences?.length" class="preferences">
              <label>Special Preferences</label>
              <div class="tag-group">
                <span v-for="pref in inquiry.preferences" :key="pref" class="tag">{{ pref }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="side-column">
          <div class="card">
            <h3>Management</h3>
            <div class="form-group">
              <label>Status</label>
              <select v-model="editForm.status">
                <option value="new">New</option>
                <option value="contacted">Contacted</option>
                <option value="quote_sent">Quote Sent</option>
                <option value="converted">Converted</option>
                <option value="lost">Lost</option>
              </select>
            </div>
            <div class="form-group">
              <label>Priority</label>
              <select v-model="editForm.priority">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
            </div>
          </div>

          <div class="card">
            <h3>Internal Notes</h3>
            <p class="hint">Only visible to administrators</p>
            <textarea 
              v-model="editForm.notes" 
              rows="12" 
              placeholder="Add internal notes about this inquiry..."
            ></textarea>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import { API_BASE_URL } from '../composables/useSettings';
import AdminLayout from '../components/AdminLayout.vue';
import { 
  ArrowLeft as IArrowLeft,
  Save as ISave,
  CheckCircle as ICheckCircle,
  User as IUser,
  MapPin as IMapPin
} from 'lucide-vue-next';

const route = useRoute();
const router = useRouter();
const inquiry = ref(null);
const isLoading = ref(true);
const isProcessing = ref(false);

const editForm = reactive({
  status: '',
  priority: '',
  notes: ''
});

const fetchInquiry = async () => {
  isLoading.value = true;
  try {
    const response = await axios.get(`${API_BASE_URL}/api/inquiries/${route.params.id}`);
    inquiry.value = response.data;
    editForm.status = response.data.status;
    editForm.priority = response.data.priority || 'medium';
    editForm.notes = response.data.notes || '';
  } catch (error) {
    console.error('Failed to fetch inquiry:', error);
    alert('Failed to load inquiry details.');
  } finally {
    isLoading.value = false;
  }
};

const handleSave = async () => {
  isProcessing.value = true;
  try {
    const response = await axios.put(`${API_BASE_URL}/api/inquiries/${route.params.id}`, editForm);
    inquiry.value = response.data;
    alert('Inquiry updated successfully.');
  } catch (error) {
    console.error('Failed to update inquiry:', error);
    alert('Error updating inquiry.');
  } finally {
    isProcessing.value = false;
  }
};

const handleConvert = async () => {
  if (!confirm('Are you sure you want to convert this inquiry into a formal booking? This will create a booking record.')) return;
  
  isProcessing.value = true;
  try {
    const response = await axios.post(`${API_BASE_URL}/api/inquiries/${route.params.id}/convert`);
    alert('Successfully converted to booking!');
    router.push('/admin/bookings/' + response.data.id);
  } catch (error) {
    console.error('Conversion failed:', error);
    alert('Failed to convert inquiry to booking.');
  } finally {
    isProcessing.value = false;
  }
};

onMounted(fetchInquiry);
</script>

<style scoped>
.inquiry-detail {
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

.status-badge.new { background: #fee2e2; color: #ef4444; }
.status-badge.converted { background: #dcfce7; color: #22c55e; }

.priority-badge {
  padding: 4px 12px;
  border-radius: 100px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  border: 1px solid #e2e8f0;
}

.priority-badge.high { color: #ef4444; border-color: #fee2e2; background: #fff1f2; }

.actions {
  display: flex;
  gap: 16px;
}

.convert-btn {
  background: #fff;
  color: #16a34a;
  border: 1px solid #dcfce7;
  padding: 12px 24px;
  border-radius: 12px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
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

.message-box {
  margin-top: 32px;
  padding-top: 32px;
  border-top: 1px solid #f1f5f9;
}

.message-content {
  background: #f8fafc;
  padding: 24px;
  border-radius: 16px;
  font-size: 15px;
  line-height: 1.6;
  color: #334155;
}

.tag-group {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  margin-top: 12px;
}

.tag {
  background: #f1f5f9;
  padding: 4px 12px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  color: #475569;
}

/* Form Controls */
.form-group {
  margin-bottom: 20px;
}

select, textarea {
  width: 100%;
  padding: 12px;
  background: #f8fafc !important;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  font-size: 14px;
  color: #000000 !important;
}

textarea { resize: none; font-family: inherit; }

.hint { font-size: 12px; color: #94a3b8; margin-bottom: 12px; }

@media (max-width: 1024px) {
  .detail-grid { grid-template-columns: 1fr; }
}
</style>
