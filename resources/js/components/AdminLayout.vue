<template>
  <div class="admin-layout">
    <aside class="sidebar">
      <div class="sidebar-header">
        <span class="logo">NDAUWO</span>
        <span class="tag">ADMIN</span>
      </div>
      
      <nav class="sidebar-nav">
        <router-link to="/admin/dashboard" class="nav-item">
          <i-layout-dashboard class="nav-icon" />
          <span>Dashboard</span>
        </router-link>
        <router-link to="/admin/inquiries" class="nav-item">
          <i-message-square class="nav-icon" />
          <span>Inquiries</span>
        </router-link>
        <router-link to="/admin/bookings" class="nav-item">
          <i-calendar class="nav-icon" />
          <span>Bookings</span>
        </router-link>
        <router-link to="/admin/destinations" class="nav-item">
          <i-map class="nav-icon" />
          <span>Destinations</span>
        </router-link>
        <router-link to="/admin/packages" class="nav-item">
          <i-package class="nav-icon" />
          <span>Safari Packages</span>
        </router-link>
        <router-link to="/admin/reviews" class="nav-item">
          <i-star class="nav-icon" />
          <span>Reviews</span>
        </router-link>
        <router-link to="/admin/gallery" class="nav-item">
          <i-image class="nav-icon" />
          <span>Gallery</span>
        </router-link>
        <router-link to="/admin/page-images" class="nav-item">
          <i-panels-top-left class="nav-icon" />
          <span>Page Assets</span>
        </router-link>
        <router-link to="/admin/settings" class="nav-item">
          <i-settings class="nav-icon" />
          <span>Settings</span>
        </router-link>
      </nav>

      <div class="sidebar-footer">

        <button @click="handleLogout" class="logout-btn">
          <i-log-out class="nav-icon" />
          <span>Logout</span>
        </button>
      </div>
    </aside>

    <div class="main-wrapper">
      <header class="top-bar">
        <div class="search-box">
          <i-search class="search-icon" />
          <input type="text" placeholder="Search records...">
        </div>
        <div class="user-actions">
          <button class="icon-btn">
            <i-bell class="icon" />
          </button>
          <div class="user-profile">
            <div class="avatar">{{ adminUser?.name?.charAt(0) || 'A' }}</div>
            <div class="details">
              <span class="name">{{ adminUser?.name || 'Admin User' }}</span>
              <span class="role">System Administrator</span>
            </div>
          </div>
        </div>
      </header>

      <main class="content-area">
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { 
  LayoutDashboard as ILayoutDashboard, 
  MessageSquare as IMessageSquare, 
  Calendar as ICalendar, 
  Map as IMap, 
  Package as IPackage,
  Star as IStar,
  Image as IImage,
  PanelsTopLeft as IPanelsTopLeft,
  Settings as ISettings,
  LogOut as ILogOut,
  Bell as IBell,
  Search as ISearch
} from 'lucide-vue-next';

const router = useRouter();
const adminUser = ref(null);

onMounted(() => {
  const user = localStorage.getItem('admin_user');
  if (user) {
    adminUser.value = JSON.parse(user);
  }
});

const handleLogout = () => {
  localStorage.removeItem('admin_token');
  localStorage.removeItem('admin_user');
  router.push('/admin/login');
};
</script>

<style scoped>
.admin-layout {
  display: flex;
  min-height: 100vh;
  background: #f1f5f9;
  font-family: 'Outfit', sans-serif;
  color: #1e293b;
}

/* Sidebar */
.sidebar {
  width: 260px;
  background: #1a1f18;
  color: #fff;
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 100;
}

.sidebar-header {
  padding: 32px;
}

.logo {
  font-size: 20px;
  font-weight: 800;
  letter-spacing: 0.15em;
  display: block;
}

.tag {
  font-size: 10px;
  color: #c5a059;
  letter-spacing: 0.3em;
  font-weight: 600;
  margin-top: 4px;
  display: block;
}

.sidebar-nav {
  flex: 1;
  padding: 0 16px;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  color: rgba(255, 255, 255, 0.5);
  text-decoration: none;
  border-radius: 12px;
  font-size: 14px;
  font-weight: 500;
}

.nav-item:hover {
  color: #fff;
  background: rgba(255, 255, 255, 0.05);
}

.nav-item.router-link-active {
  background: rgba(197, 160, 89, 0.1);
  color: #c5a059;
}

.nav-icon {
  width: 18px;
  height: 18px;
}

.sidebar-footer {
  padding: 24px 16px;
  border-top: 1px solid rgba(255, 255, 255, 0.05);
}

.logout-btn {
  display: flex;
  align-items: center;
  gap: 12px;
  width: 100%;
  padding: 12px 16px;
  background: transparent;
  border: none;
  color: #f87171;
  cursor: pointer;
  font-weight: 600;
  font-size: 14px;
  border-radius: 12px;
}

.logout-btn:hover {
  background: rgba(239, 68, 68, 0.1);
}

/* Main Content Area */
.main-wrapper {
  flex: 1;
  margin-left: 260px;
  display: flex;
  flex-direction: column;
  min-width: 0;
}

.top-bar {
  height: 72px;
  background: #fff;
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 40px;
  position: sticky;
  top: 0;
  z-index: 90;
}

.search-box {
  position: relative;
  width: 300px;
}

.search-icon {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  width: 16px;
  height: 16px;
  color: #94a3b8;
}

.search-box input {
  width: 100%;
  border: 1px solid #e2e8f0;
  padding: 10px 16px 10px 40px;
  border-radius: 10px;
  font-size: 13px;
  background: #f8fafc !important;
  color: #000000 !important;
}

.search-box input:focus {
  outline: none;
  border-color: #c5a059;
  background: #fff;
  box-shadow: 0 0 0 3px rgba(197, 160, 89, 0.1);
}

.user-actions {
  display: flex;
  align-items: center;
  gap: 24px;
}

.icon-btn {
  position: relative;
  background: transparent;
  border: none;
  color: #64748b;
  cursor: pointer;
  padding: 8px;
  border-radius: 50%;
}

.icon-btn:hover {
  background: #f1f5f9;
  color: #1e293b;
}

.icon {
  width: 20px;
  height: 20px;
}

.user-profile {
  display: flex;
  align-items: center;
  gap: 12px;
  padding-left: 24px;
  border-left: 1px solid #e2e8f0;
}

.avatar {
  width: 36px;
  height: 36px;
  background: #c5a059;
  color: #1a1f18;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
}

.details {
  display: flex;
  flex-direction: column;
}

.name {
  font-size: 14px;
  font-weight: 600;
  color: #1e293b;
}

.role {
  font-size: 11px;
  color: #64748b;
  font-weight: 500;
}

.content-area {
  padding: 40px;
  flex: 1;
}

@media (max-width: 1024px) {
  .sidebar {
    width: 80px;
  }
  
  .sidebar-header, .sidebar-footer, .nav-item span, .details {
    display: none;
  }
  
  .main-wrapper {
    margin-left: 80px;
  }
  
  .logo {
    display: none;
  }
  
  .nav-item {
    justify-content: center;
    padding: 16px;
  }
}
</style>
