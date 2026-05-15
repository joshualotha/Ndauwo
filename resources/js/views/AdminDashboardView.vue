<template>
  <AdminLayout>
    <div class="dashboard-content">
      <header class="content-header">
        <h1>Dashboard Overview</h1>
        <div class="user-meta">
          <span>{{ adminUser?.name || 'Admin User' }}</span>
          <div class="avatar">{{ adminUser?.name?.charAt(0) || 'A' }}</div>
        </div>
      </header>

      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon inquiries">
            <i-message-square />
          </div>
          <div class="stat-info">
            <h3>Recent Inquiries</h3>
            <p class="stat-value">{{ stats.total_inquiries || '0' }}</p>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon bookings">
            <i-calendar />
          </div>
          <div class="stat-info">
            <h3>Active Bookings</h3>
            <p class="stat-value">{{ stats.confirmed_bookings || '0' }}</p>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon revenue">
            <i-dollar-sign />
          </div>
          <div class="stat-info">
            <h3>Forecast Revenue</h3>
            <p class="stat-value">${{ stats.total_revenue?.toLocaleString() || '0' }}</p>
          </div>
        </div>
      </div>

      <div class="dashboard-grid">
        <!-- Recent Activity -->
        <div class="activity-card card">
          <div class="card-header">
            <h3>Recent Inquiries</h3>
            <router-link to="/admin/inquiries" class="view-all">View All</router-link>
          </div>
          <div class="activity-list">
            <div v-for="item in recentInquiries" :key="item.id" class="activity-item" @click="viewInquiry(item.id)">
              <div class="avatar-mini">{{ item.name.charAt(0) }}</div>
              <div class="info">
                <span class="name">{{ item.name }}</span>
                <span class="meta">{{ item.package?.title || 'Custom Trip' }}</span>
              </div>
              <span class="date">{{ formatDateShort(item.created_at) }}</span>
            </div>
            <div v-if="recentInquiries.length === 0" class="empty-msg">No recent inquiries</div>
          </div>
        </div>

        <!-- Upcoming Departures -->
        <div class="activity-card card">
          <div class="card-header">
            <h3>Upcoming Departures</h3>
            <router-link to="/admin/bookings" class="view-all">View All</router-link>
          </div>
          <div class="activity-list">
            <div v-for="item in upcomingDepartures" :key="item.id" class="activity-item">
              <div class="date-badge">
                <span class="month">{{ formatDateMonth(item.travel_date) }}</span>
                <span class="day">{{ formatDateDay(item.travel_date) }}</span>
              </div>
              <div class="info">
                <span class="name">{{ item.name }}</span>
                <span class="meta">{{ item.package?.title || 'Expedition' }}</span>
              </div>
            </div>
            <div v-if="upcomingDepartures.length === 0" class="empty-msg">No upcoming departures</div>
          </div>
        </div>
      </div>

      <div class="welcome-section">
        <div class="welcome-card">
          <h2>Welcome to the Ndauwo Command Center</h2>
          <p>You are logged in with administrative privileges. From here, you can manage all aspects of the safari expeditions, from initial inquiries to final booking confirmations.</p>
          <div class="quick-actions">
            <router-link to="/admin/destinations" class="action-btn">Manage Destinations</router-link>
            <router-link to="/admin/inquiries" class="action-btn secondary">View All Inquiries</router-link>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { API_BASE_URL } from '../composables/useSettings';
import AdminLayout from '../components/AdminLayout.vue';
import { 
  MessageSquare as IMessageSquare, 
  Calendar as ICalendar, 
  DollarSign as IDollarSign
} from 'lucide-vue-next';

const adminUser = ref(null);
const stats = ref({
  total_inquiries: 0,
  confirmed_bookings: 0,
  total_revenue: 0
});

const recentInquiries = ref([]);
const upcomingDepartures = ref([]);

const fetchDashboardData = async () => {
  try {
    const token = localStorage.getItem('admin_token');
    const response = await axios.get(`${API_BASE_URL}/api/dashboard`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });
    if (response.data.stats) {
      stats.value = response.data.stats;
    }
    recentInquiries.value = response.data.recent_inquiries || [];
    upcomingDepartures.value = response.data.upcoming_departures || [];
  } catch (error) {
    console.error("Failed to fetch dashboard data", error);
  }
};

const formatDateShort = (d) => new Date(d).toLocaleDateString(undefined, { month: 'short', day: 'numeric' });
const formatDateMonth = (d) => new Date(d).toLocaleDateString(undefined, { month: 'short' });
const formatDateDay = (d) => new Date(d).toLocaleDateString(undefined, { day: 'numeric' });
const viewInquiry = (id) => router.push(`/admin/inquiries/${id}`);

onMounted(() => {
  const user = localStorage.getItem('admin_user');
  if (user) {
    adminUser.value = JSON.parse(user);
  }
  fetchDashboardData();
});
</script>

<style scoped>
.admin-dashboard {
  display: flex;
  min-height: 100vh;
  background: #f8fafc;
  font-family: 'Outfit', sans-serif;
}

/* Sidebar */
.sidebar {
  width: 280px;
  background: #1a1f18;
  color: #fff;
  display: flex;
  flex-direction: column;
  flex-shrink: 0;
}

.sidebar-header {
  padding: 32px;
  display: flex;
  flex-direction: column;
}

.logo {
  font-size: 24px;
  font-weight: 800;
  letter-spacing: 0.2em;
}

.tag {
  font-size: 10px;
  color: #c5a059;
  letter-spacing: 0.3em;
  font-weight: 600;
  margin-top: 4px;
}

.sidebar-nav {
  flex: 1;
  padding: 0 16px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  color: rgba(255, 255, 255, 0.6);
  text-decoration: none;
  border-radius: 12px;
  font-weight: 500;
}

.nav-item:hover {
  background: rgba(255, 255, 255, 0.05);
  color: #fff;
}

.nav-item.active {
  background: rgba(197, 160, 89, 0.1);
  color: #c5a059;
}

.nav-icon {
  width: 20px;
  height: 20px;
}

.sidebar-footer {
  padding: 32px;
  border-top: 1px solid rgba(255, 255, 255, 0.05);
}

.logout-btn {
  display: flex;
  align-items: center;
  gap: 12px;
  width: 100%;
  padding: 12px;
  background: transparent;
  border: none;
  color: #f87171;
  cursor: pointer;
  font-weight: 600;
}

.logout-btn:hover {
  background: rgba(239, 68, 68, 0.1);
  border-radius: 12px;
}

/* Main Content */
.content {
  flex: 1;
  padding: 48px;
  overflow-y: auto;
}

.content-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 40px;
}

h1 {
  font-size: 28px;
  font-weight: 700;
  color: #1e293b;
}

.user-meta {
  display: flex;
  align-items: center;
  gap: 12px;
  color: #64748b;
  font-weight: 500;
}

.avatar {
  width: 40px;
  height: 40px;
  background: #c5a059;
  color: #1a1f18;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
}

/* Stats */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-bottom: 40px;
}

.stat-card {
  background: #fff;
  padding: 24px;
  border-radius: 20px;
  display: flex;
  align-items: center;
  gap: 20px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.stat-icon {
  width: 56px;
  height: 56px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
}

.stat-icon.inquiries { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
.stat-icon.bookings { background: rgba(16, 185, 129, 0.1); color: #10b981; }
.stat-icon.revenue { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }

.stat-info h3 {
  font-size: 14px;
  color: #64748b;
  margin-bottom: 4px;
}

.stat-value {
  font-size: 24px;
  font-weight: 700;
  color: #1e293b;
}

/* Welcome Section */
.welcome-card {
  background: #1a1f18;
  color: #fff;
  padding: 48px;
  border-radius: 24px;
  background-image: linear-gradient(to right, rgba(0,0,0,0.7), transparent), url('https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&q=80');
  background-size: cover;
  background-position: center;
}

h2 {
  font-size: 32px;
  font-weight: 700;
  margin-bottom: 16px;
  max-width: 500px;
}

.welcome-card p {
  color: rgba(255, 255, 255, 0.7);
  font-size: 16px;
  line-height: 1.6;
  margin-bottom: 32px;
  max-width: 600px;
}

.quick-actions {
  display: flex;
  gap: 16px;
}

.action-btn {
  padding: 12px 24px;
  background: #c5a059;
  color: #1a1f18;
  border: none;
  border-radius: 12px;
  font-weight: 700;
  cursor: pointer;
}

.action-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(197, 160, 89, 0.3);
}

.action-btn.secondary {
  background: rgba(255, 255, 255, 0.1);
  color: #fff;
  backdrop-filter: blur(10px);
}

.action-btn.secondary:hover {
  background: rgba(255, 255, 255, 0.2);
}

.dashboard-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 32px;
  margin-bottom: 40px;
}

.card {
  background: #fff;
  border-radius: 20px;
  padding: 32px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.card-header h3 { font-size: 18px; font-weight: 700; color: #1e293b; }
.view-all { font-size: 13px; font-weight: 600; color: #c5a059; text-decoration: none; }

.activity-list { display: flex; flex-direction: column; gap: 16px; }

.activity-item {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 12px;
  border-radius: 12px;
  cursor: pointer;
}

.activity-item:hover { background: #f8fafc; }

.avatar-mini {
  width: 36px;
  height: 36px;
  background: #e2e8f0;
  color: #64748b;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 14px;
}

.info { flex: 1; display: flex; flex-direction: column; }
.info .name { font-size: 14px; font-weight: 600; color: #1e293b; }
.info .meta { font-size: 12px; color: #94a3b8; }

.date { font-size: 12px; color: #94a3b8; }

.date-badge {
  width: 44px;
  height: 48px;
  background: #f1f5f9;
  border-radius: 8px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.date-badge .month { font-size: 10px; font-weight: 700; text-transform: uppercase; color: #64748b; }
.date-badge .day { font-size: 16px; font-weight: 800; color: #1e293b; line-height: 1; }

.empty-msg { text-align: center; padding: 24px; color: #94a3b8; font-size: 14px; }

@media (max-width: 1024px) {
  .stats-grid, .dashboard-grid {
    grid-template-columns: 1fr;
  }
}
</style>
