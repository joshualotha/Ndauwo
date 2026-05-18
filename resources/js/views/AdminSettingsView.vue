<template>
  <AdminLayout>
    <div class="settings-management">
      <div class="header-section">
        <div>
          <h1>System Settings</h1>
          <p>Configure website global parameters, brand assets, and operations</p>
        </div>
        <div class="actions">
          <div v-if="saveStatus" :class="['status-message', saveStatus.type]">
            {{ saveStatus.text }}
          </div>
          <button @click="saveSettings" class="save-btn" :disabled="isSaving">
            <ISave class="icon" />
            {{ isSaving ? 'Saving...' : 'Save Changes' }}
          </button>
        </div>
      </div>

      <!-- Tab Navigation -->
      <div class="tabs-container">
        <button 
          v-for="tab in tabs" 
          :key="tab.id"
          @click="activeTab = tab.id"
          :class="['tab-btn', { active: activeTab === tab.id }]"
        >
          <component :is="tab.icon" class="tab-icon" />
          {{ tab.name }}
        </button>
      </div>

      <div class="settings-content">
        <!-- General & Branding -->
        <div v-if="activeTab === 'general'" class="settings-grid">
          <div class="settings-card">
            <h3><IGlobe class="card-icon" /> Site Information</h3>
            <div class="form-grid">
              <div class="form-group full">
                <label>Site Name</label>
                <input type="text" v-model="settings.site_name">
              </div>
              <div class="form-group full">
                <label>Site Tagline</label>
                <input type="text" v-model="settings.site_tagline">
              </div>
              <div class="form-group full">
                <label>Site Description</label>
                <textarea v-model="settings.site_description" rows="3"></textarea>
              </div>
            </div>
          </div>

          <div class="settings-card">
            <h3><IImage class="card-icon" /> Brand Assets</h3>
            <div class="assets-grid">
              <div class="asset-item">
                <label>Logo (Light)</label>
                <div class="image-preview" @click="triggerUpload('site_logo_light')">
                  <img v-if="settings.site_logo_light" :src="getImageUrl(settings.site_logo_light)" />
                  <div v-else class="placeholder"><IUpload /></div>
                </div>
              </div>
              <div class="asset-item">
                <label>Logo (Dark)</label>
                <div class="image-preview dark" @click="triggerUpload('site_logo_dark')">
                  <img v-if="settings.site_logo_dark" :src="getImageUrl(settings.site_logo_dark)" />
                  <div v-else class="placeholder"><IUpload /></div>
                </div>
              </div>
              <div class="asset-item">
                <label>Favicon</label>
                <div class="image-preview" @click="triggerUpload('site_favicon')">
                  <img v-if="settings.site_favicon" :src="getImageUrl(settings.site_favicon)" />
                  <div v-else class="placeholder"><IUpload /></div>
                </div>
              </div>
            </div>
            <input type="file" ref="fileInput" hidden @change="handleFileUpload" accept="image/*">
          </div>
        </div>

        <!-- Contact Details -->
        <div v-if="activeTab === 'contact'" class="settings-grid">
          <div class="settings-card">
            <h3><IPhone class="card-icon" /> Communication</h3>
            <div class="form-grid">
              <div class="form-group">
                <label>Contact Email</label>
                <input type="email" v-model="settings.contact_email">
              </div>
              <div class="form-group">
                <label>General Phone</label>
                <input type="text" v-model="settings.contact_phone">
              </div>
              <div class="form-group">
                <label>WhatsApp Number</label>
                <input type="text" v-model="settings.contact_whatsapp">
              </div>
              <div class="form-group">
                <label>Emergency Contact</label>
                <input type="text" v-model="settings.contact_emergency">
              </div>
            </div>
          </div>

          <div class="settings-card">
            <h3><IMapPin class="card-icon" /> Location</h3>
            <div class="form-grid">
              <div class="form-group full">
                <label>Office Address</label>
                <textarea v-model="settings.office_address" rows="2"></textarea>
              </div>
              <div class="form-group full">
                <label>GPS Coordinates (HQ)</label>
                <input type="text" v-model="settings.gps_hq">
              </div>
              <div class="form-group full">
                <label>GPS Coordinates (Serengeti Base)</label>
                <input type="text" v-model="settings.gps_serengeti">
              </div>
            </div>
          </div>
        </div>

        <!-- Social Media -->
        <div v-if="activeTab === 'social'" class="settings-grid">
          <div class="settings-card full">
            <h3><IShare class="card-icon" /> Social Profiles</h3>
            <div class="form-grid">
              <div class="form-group">
                <label>Instagram URL</label>
                <input type="text" v-model="settings.social_instagram" placeholder="https://instagram.com/...">
              </div>
              <div class="form-group">
                <label>Facebook URL</label>
                <input type="text" v-model="settings.social_facebook" placeholder="https://facebook.com/...">
              </div>
              <div class="form-group">
                <label>Twitter/X URL</label>
                <input type="text" v-model="settings.social_twitter" placeholder="https://twitter.com/...">
              </div>
              <div class="form-group">
                <label>LinkedIn URL</label>
                <input type="text" v-model="settings.social_linkedin" placeholder="https://linkedin.com/company/...">
              </div>
              <div class="form-group">
                <label>YouTube URL</label>
                <input type="text" v-model="settings.social_youtube" placeholder="https://youtube.com/...">
              </div>
            </div>
          </div>
        </div>

        <!-- SEO & Analytics -->
        <div v-if="activeTab === 'seo'" class="settings-grid">
          <div class="settings-card">
            <h3><ISearch class="card-icon" /> Search Optimization</h3>
            <div class="form-grid">
              <div class="form-group full">
                <label>Default Meta Title</label>
                <input type="text" v-model="settings.seo_meta_title">
              </div>
              <div class="form-group full">
                <label>Default Meta Description</label>
                <textarea v-model="settings.seo_meta_description" rows="3"></textarea>
              </div>
              <div class="form-group full">
                <label>Meta Keywords</label>
                <input type="text" v-model="settings.seo_meta_keywords">
              </div>
            </div>
          </div>

          <div class="settings-card">
            <h3><IBarChart class="card-icon" /> Analytics & Tracking</h3>
            <div class="form-grid">
              <div class="form-group full">
                <label>Google Analytics 4 ID</label>
                <input type="text" v-model="settings.ga4_id" placeholder="G-XXXXXXXXXX">
                <span class="field-hint">Recommended. Enter your GA4 Measurement ID (starts with G-).</span>
              </div>
              <div class="form-group full">
                <label>Google Tag Manager ID</label>
                <input type="text" v-model="settings.gtm_id" placeholder="GTM-XXXXXXX">
                <span class="field-hint">If set, overrides direct GA4 tag. Enter your GTM container ID (starts with GTM-).</span>
              </div>
              <div class="form-group full">
                <label>Legacy Google Analytics ID</label>
                <input type="text" v-model="settings.seo_google_analytics" placeholder="UA-XXXXX-Y">
                <span class="field-hint">Fallback if GA4 ID is not set. Used for older UA- tracking codes.</span>
              </div>
              <div class="form-group full">
                <label>Facebook Pixel ID</label>
                <input type="text" v-model="settings.seo_facebook_pixel">
              </div>
              <div class="form-group full">
                <label>Open Graph Image</label>
                <div class="image-preview og" @click="triggerUpload('seo_og_image')">
                  <img v-if="settings.seo_og_image" :src="getImageUrl(settings.seo_og_image)" />
                  <div v-else class="placeholder"><IUpload /></div>
                </div>
              </div>
            </div>
          </div>

          <div class="settings-card">
            <h3><IUsers class="card-icon" /> Social Profiles (Schema)</h3>
            <div class="form-grid">
              <div class="form-group full">
                <label>TripAdvisor URL</label>
                <input type="text" v-model="settings.social_tripadvisor" placeholder="https://www.tripadvisor.com/...">
              </div>
              <div class="form-group full">
                <label>Facebook Page URL</label>
                <input type="text" v-model="settings.social_facebook" placeholder="https://facebook.com/...">
              </div>
              <div class="form-group full">
                <label>Instagram URL</label>
                <input type="text" v-model="settings.social_instagram" placeholder="https://instagram.com/...">
              </div>
              <div class="form-group full">
                <label>YouTube URL</label>
                <input type="text" v-model="settings.social_youtube" placeholder="https://youtube.com/...">
              </div>
            </div>
          </div>
        </div>

        <!-- Booking & Payments -->
        <div v-if="activeTab === 'booking'" class="settings-grid">
          <div class="settings-card">
            <h3><ICalendar class="card-icon" /> Booking Policies</h3>
            <div class="form-grid">
              <div class="form-group">
                <label>Base Currency</label>
                <input type="text" v-model="settings.booking_currency">
              </div>
              <div class="form-group">
                <label>Deposit Percentage (%)</label>
                <input type="number" v-model="settings.booking_deposit_percentage">
              </div>
              <div class="form-group full">
                <label>Min. Booking Notice (Days)</label>
                <input type="number" v-model="settings.booking_min_days_notice">
              </div>
              <div class="form-group full">
                <label>Terms & Conditions Summary</label>
                <textarea v-model="settings.booking_terms_conditions" rows="4"></textarea>
              </div>
            </div>
          </div>

          <div class="settings-card">
            <h3><ICreditCard class="card-icon" /> Payment Gateways</h3>
            <div class="form-grid">
              <div class="form-group full">
                <label class="toggle-label">
                  <span>Enable Stripe Payments</span>
                  <input type="checkbox" v-model="settings.payment_stripe_enabled" :true-value="'1'" :false-value="'0'">
                </label>
              </div>
              <div class="form-group full" v-if="settings.payment_stripe_enabled === '1'">
                <label>Stripe Publishable Key</label>
                <input type="password" v-model="settings.payment_stripe_key">
              </div>
              <div class="form-group full" v-if="settings.payment_stripe_enabled === '1'">
                <label>Stripe Secret Key</label>
                <input type="password" v-model="settings.payment_stripe_secret">
              </div>
              <div class="form-group full">
                <label>Cancellation Policy</label>
                <textarea v-model="settings.booking_cancellation_policy" rows="4"></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- Mail Settings -->
        <div v-if="activeTab === 'mail'" class="settings-grid">
          <div class="settings-card full">
            <h3><IMail class="card-icon" /> SMTP Configuration</h3>
            <div class="form-grid">
              <div class="form-group">
                <label>Mail Mailer</label>
                <input type="text" v-model="settings.mail_mailer">
              </div>
              <div class="form-group">
                <label>Mail Host</label>
                <input type="text" v-model="settings.mail_host">
              </div>
              <div class="form-group">
                <label>Mail Port</label>
                <input type="text" v-model="settings.mail_port">
              </div>
              <div class="form-group">
                <label>Mail Encryption</label>
                <select v-model="settings.mail_encryption">
                  <option value="tls">TLS</option>
                  <option value="ssl">SSL</option>
                  <option value="none">None</option>
                </select>
              </div>
              <div class="form-group">
                <label>Mail Username</label>
                <input type="text" v-model="settings.mail_username">
              </div>
              <div class="form-group">
                <label>Mail Password</label>
                <input type="password" v-model="settings.mail_password">
              </div>
              <div class="form-group">
                <label>From Address</label>
                <input type="text" v-model="settings.mail_from_address">
              </div>
              <div class="form-group">
                <label>From Name</label>
                <input type="text" v-model="settings.mail_from_name">
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
import AdminLayout from '../components/AdminLayout.vue';
import { 
  Save as ISave,
  Globe as IGlobe,
  Phone as IPhone,
  Share2 as IShare,
  Image as IImage,
  MapPin as IMapPin,
  Search as ISearch,
  BarChart as IBarChart,
  Calendar as ICalendar,
  CreditCard as ICreditCard,
  Mail as IMail,
  Upload as IUpload,
  Users as IUsers
} from 'lucide-vue-next';

import { API_BASE_URL } from '../composables/useSettings';

const tabs = [
  { id: 'general', name: 'General', icon: IGlobe },
  { id: 'contact', name: 'Contact', icon: IPhone },
  { id: 'social', name: 'Social', icon: IShare },
  { id: 'seo', name: 'SEO', icon: ISearch },
  { id: 'booking', name: 'Booking', icon: ICalendar },
  { id: 'mail', name: 'Mail', icon: IMail }
];

const activeTab = ref('general');
const isSaving = ref(false);
const saveStatus = ref(null);
const fileInput = ref(null);
const activeUploadKey = ref('');

const settings = ref({
  site_name: '',
  site_tagline: '',
  site_description: '',
  site_logo_light: '',
  site_logo_dark: '',
  site_favicon: '',
  contact_email: '',
  contact_phone: '',
  contact_whatsapp: '',
  contact_emergency: '',
  office_address: '',
  gps_hq: '',
  gps_serengeti: '',
  social_instagram: 'https://instagram.com/ndauwosafari',
  social_facebook: 'https://facebook.com/ndauwosafari',
  social_twitter: '',
  social_linkedin: '',
  social_youtube: '',
  social_tripadvisor: '',
  seo_meta_title: '',
  seo_meta_description: '',
  seo_meta_keywords: '',
  seo_og_image: '',
  ga4_id: '',
  gtm_id: '',
  seo_google_analytics: '',
  seo_facebook_pixel: '',
  social_tripadvisor: '',
  booking_currency: 'USD',
  booking_deposit_percentage: 30,
  booking_terms_conditions: '',
  booking_cancellation_policy: '',
  booking_min_days_notice: 7,
  payment_stripe_enabled: '0',
  payment_stripe_key: '',
  payment_stripe_secret: '',
  mail_mailer: 'smtp',
  mail_host: '',
  mail_port: '',
  mail_username: '',
  mail_password: '',
  mail_encryption: 'tls',
  mail_from_address: '',
  mail_from_name: ''
});

const getImageUrl = (path) => {
  if (!path) return '';
  if (path.startsWith('http') || path.startsWith('data:') || path.startsWith('blob:')) return path;
  
  if (path.includes('/storage/') || path.includes('storage/')) {
    const cleanPath = path.startsWith('/') ? path : '/' + path;
    return `${API_BASE_URL}${cleanPath.replace('//', '/')}`;
  }
  
  const cleanPath = path.startsWith('/') ? path : '/' + path;
  return `${API_BASE_URL}/storage${cleanPath}`;
};

const triggerUpload = (key) => {
  activeUploadKey.value = key;
  fileInput.value.click();
};

const handleFileUpload = async (event) => {
  const file = event.target.files[0];
  if (!file) return;

  const formData = new FormData();
  formData.append('image', file);
  formData.append('key', activeUploadKey.value);

  saveStatus.value = { type: 'info', text: 'Uploading asset...' };

  try {
    const response = await axios.post(`${API_BASE_URL}/api/settings/upload`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    settings.value[activeUploadKey.value] = response.data.path;
    saveStatus.value = { type: 'success', text: 'Asset uploaded successfully' };
    setTimeout(() => saveStatus.value = null, 3000);
  } catch (error) {
    console.error('Upload failed:', error);
    saveStatus.value = { type: 'error', text: 'Upload failed' };
  }
};

const fetchSettings = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/settings`);
    const data = response.data;
    
    // Merge backend values into our settings object
    Object.keys(settings.value).forEach(key => {
      if (data.hasOwnProperty(key)) {
        // Handle null values from backend by keeping them as empty strings if null
        settings.value[key] = data[key] === null ? '' : data[key];
      }
    });
  } catch (error) {
    console.error('Failed to fetch settings:', error);
    saveStatus.value = { type: 'error', text: 'Connection to server failed' };
  }
};

const saveSettings = async () => {
  isSaving.value = true;
  saveStatus.value = null;
  try {
    await axios.post(`${API_BASE_URL}/api/settings`, settings.value);
    saveStatus.value = { type: 'success', text: 'Settings saved successfully' };
    setTimeout(() => saveStatus.value = null, 3000);
  } catch (error) {
    console.error('Failed to save settings:', error);
    saveStatus.value = { type: 'error', text: 'Error saving settings' };
  } finally {
    isSaving.value = false;
  }
};

onMounted(fetchSettings);
</script>

<style scoped>
.settings-management {
  display: flex;
  flex-direction: column;
  gap: 32px;
  padding-bottom: 40px;
}

.header-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

h1 { font-size: 24px; font-weight: 700; color: #1a1f18; }
p { color: #64748b; font-size: 14px; margin-top: 4px; }

.actions {
  display: flex;
  align-items: center;
  gap: 16px;
}

.status-message {
  font-size: 13px;
  font-weight: 600;
  padding: 8px 16px;
  border-radius: 8px;
}

.status-message.success { color: #16a34a; background: #dcfce7; }
.status-message.error { color: #dc2626; background: #fee2e2; }
.status-message.info { color: #2563eb; background: #dbeafe; }

.save-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #c5a059;
  color: #fff;
  border: none;
  padding: 12px 28px;
  border-radius: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

.save-btn:hover:not(:disabled) {
  background: #b38e4b;
  transform: translateY(-1px);
}

.save-btn:disabled { opacity: 0.7; cursor: not-allowed; }

/* Tabs */
.tabs-container {
  display: flex;
  gap: 12px;
  padding: 6px;
  background: #f1f5f9;
  border-radius: 16px;
  width: fit-content;
  flex-wrap: wrap;
}

.tab-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px;
  border: none;
  background: transparent;
  color: #64748b;
  border-radius: 12px;
  font-weight: 600;
  font-size: 13px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.tab-btn.active {
  background: #fff;
  color: #c5a059;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Settings Grid */
.settings-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
}

.settings-card {
  background: #fff;
  padding: 32px;
  border-radius: 24px;
  border: 1px solid #f1f5f9;
}

.settings-card.full { grid-column: span 2; }

h3 {
  font-size: 16px;
  font-weight: 700;
  margin-bottom: 24px;
  display: flex;
  align-items: center;
  gap: 10px;
  color: #1a1f18;
}

.card-icon { width: 18px; height: 18px; color: #c5a059; }

/* Forms */
.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
}

.form-group.full { grid-column: span 2; }

label {
  display: block;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  color: #94a3b8;
  margin-bottom: 8px;
  letter-spacing: 0.05em;
}

input, textarea, select {
  width: 100%;
  padding: 14px;
  background: #f8fafc !important;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  font-size: 14px;
  color: #000000 !important;
  transition: all 0.2s ease;
}

input:focus, textarea:focus, select:focus {
  outline: none;
  border-color: #c5a059;
  background: #fff;
  box-shadow: 0 0 0 4px rgba(197, 160, 89, 0.1);
}

/* Brand Assets Management */
.assets-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 20px;
}

.asset-item {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.image-preview {
  aspect-ratio: 1;
  background: #f8fafc;
  border: 2px dashed #e2e8f0;
  border-radius: 16px;
  cursor: pointer;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.image-preview.dark { background: #1a1f18; }

.image-preview:hover {
  border-color: #c5a059;
  background: #f1f5f9;
}

.image-preview img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  padding: 10px;
}

.image-preview.og {
  aspect-ratio: 16/9;
}

.placeholder { color: #cbd5e1; }

.toggle-label {
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
}

.toggle-label input[type="checkbox"] { width: auto; }

@media (max-width: 1024px) {
  .settings-grid { grid-template-columns: 1fr; }
}
</style>


