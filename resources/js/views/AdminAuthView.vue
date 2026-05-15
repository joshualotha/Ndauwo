<template>
  <div class="admin-auth-container">
    <div class="auth-overlay"></div>
    <div class="auth-card" v-reveal>
      <div class="auth-header">
        <div class="logo">
          <span class="logo-text">NDAUWO</span>
          <span class="logo-tag">SAFARI CO.</span>
        </div>
        <h1>Admin Portal</h1>
        <p>Enter your credentials to manage expeditions</p>
      </div>

      <form @submit.prevent="handleLogin" class="auth-form">
        <div class="form-group">
          <label for="email">Email Address</label>
          <div class="input-wrapper">
            <i-mail class="input-icon" />
            <input 
              type="email" 
              id="email" 
              v-model="email" 
              placeholder="admin@ndauwo.com" 
              required
              :disabled="isLoading"
            >
          </div>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-wrapper">
            <i-lock class="input-icon" />
            <input 
              type="password" 
              id="password" 
              v-model="password" 
              placeholder="••••••••" 
              required
              :disabled="isLoading"
            >
          </div>
        </div>

        <div v-if="error" class="error-message">
          <i-alert-circle class="error-icon" />
          <span>{{ error }}</span>
        </div>

        <button type="submit" class="submit-btn" :disabled="isLoading">
          <span v-if="!isLoading">Authorize Access</span>
          <span v-else class="loader"></span>
        </button>
      </form>

      <div class="auth-footer">
        <p>&copy; 2026 Ndauwo Safari Co. All rights reserved.</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { API_BASE_URL } from '../composables/useSettings';
import { Mail as IMail, Lock as ILock, AlertCircle as IAlertCircle } from 'lucide-vue-next';

const router = useRouter();
const email = ref('admin@ndauwo.com'); // Default for convenience
const password = ref('password');
const isLoading = ref(false);
const error = ref(null);

const handleLogin = async () => {
  isLoading.value = true;
  error.value = null;

  try {
    const response = await axios.post(`${API_BASE_URL}/api/login`, {
      email: email.value,
      password: password.value
    });

    if (response.data.token) {
      localStorage.setItem('admin_token', response.data.token);
      localStorage.setItem('admin_user', JSON.stringify(response.data.user));

      // Set axios default header for future requests
      axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;

      router.push('/admin/dashboard');
    }
  } catch (err) {
    console.error('Login error:', err);
    error.value = err.response?.data?.message || 'Authentication failed. Please check your credentials.';
  } finally {
    isLoading.value = false;
  }
};
</script>

<style scoped>
.admin-auth-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background-image: url('https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&q=80');
  background-size: cover;
  background-position: center;
  position: relative;
  font-family: 'Outfit', sans-serif;
}

.auth-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(26, 31, 24, 0.9), rgba(45, 54, 41, 0.8));
  backdrop-filter: blur(4px);
}

.auth-card {
  position: relative;
  z-index: 1;
  width: 100%;
  max-width: 440px;
  background: rgba(255, 255, 255, 0.03);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 24px;
  padding: 48px;
  box-shadow: 0 24px 48px rgba(0, 0, 0, 0.4);
}

.auth-header {
  text-align: center;
  margin-bottom: 40px;
}

.logo {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 24px;
}

.logo-text {
  font-size: 28px;
  font-weight: 800;
  letter-spacing: 0.2em;
  color: #fff;
}

.logo-tag {
  font-size: 10px;
  font-weight: 500;
  letter-spacing: 0.4em;
  color: var(--primary-gold, #c5a059);
  margin-top: 4px;
}

h1 {
  font-size: 24px;
  color: #fff;
  margin-bottom: 8px;
  font-weight: 600;
}

p {
  color: rgba(255, 255, 255, 0.6);
  font-size: 14px;
}

.auth-form {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

label {
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: rgba(255, 255, 255, 0.5);
  margin-left: 4px;
}

.input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.input-icon {
  position: absolute;
  left: 16px;
  width: 18px;
  height: 18px;
  color: rgba(255, 255, 255, 0.3);
}

input {
  width: 100%;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 12px;
  padding: 14px 16px 14px 48px;
  color: #fff;
  font-size: 16px;
}

input:focus {
  outline: none;
  background: rgba(255, 255, 255, 0.08);
  border-color: var(--primary-gold, #c5a059);
  box-shadow: 0 0 0 4px rgba(197, 160, 89, 0.1);
}

input:focus + .input-icon {
  color: var(--primary-gold, #c5a059);
}

.error-message {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 16px;
  background: rgba(239, 68, 68, 0.1);
  border: 1px solid rgba(239, 68, 68, 0.2);
  border-radius: 12px;
  color: #f87171;
  font-size: 13px;
}

.error-icon {
  width: 16px;
  height: 16px;
  flex-shrink: 0;
}

.submit-btn {
  margin-top: 8px;
  background: var(--primary-gold, #c5a059);
  color: #1a1f18;
  border: none;
  border-radius: 12px;
  padding: 16px;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.submit-btn:hover {
  background: #d4b375;
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(197, 160, 89, 0.3);
}

.submit-btn:active {
  transform: translateY(0);
}

.submit-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
  transform: none;
}

.loader {
  width: 20px;
  height: 20px;
  border: 2px solid rgba(26, 31, 24, 0.3);
  border-top-color: #1a1f18;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.auth-footer {
  margin-top: 40px;
  text-align: center;
}

.auth-footer p {
  font-size: 11px;
  letter-spacing: 0.05em;
  opacity: 0.4;
}

@media (max-width: 480px) {
  .auth-card {
    padding: 32px;
    border-radius: 0;
    backdrop-filter: none;
    background: #1a1f18;
    height: 100vh;
    max-width: none;
  }
}
</style>
