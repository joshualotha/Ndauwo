import { ref, reactive, provide, inject, onMounted } from 'vue';
import axios from 'axios';

const SETTINGS_KEY = Symbol('site-settings');

// Use relative API path — same origin, no CORS issues
export const API_BASE_URL = '';

export function useSettingsProvider() {
  const settings = reactive({});
  const isLoading = ref(true);
  const error = ref(null);

  const fetchSettings = async () => {
    isLoading.value = true;
    try {
      const response = await axios.get(`${API_BASE_URL}/api/settings`);
      
      // Merge values into the reactive object
      Object.assign(settings, response.data);
    } catch (err) {
      console.error('Failed to fetch site settings:', err);
      error.value = err;
    } finally {
      isLoading.value = false;
    }
  };

  const getImageUrl = (path) => {
    if (!path) return '';
    if (path.startsWith('http') || path.startsWith('data:') || path.startsWith('blob:') || path.startsWith('/image-')) return path;
    
    // If it already has /storage/ or storage/, return relative path
    if (path.includes('/storage/') || path.includes('storage/')) {
      return path.startsWith('/') ? path : '/' + path;
    }
    
    // It's a raw path from a controller that doesn't prefix
    const cleanPath = path.startsWith('/') ? path : '/' + path;
    return '/storage' + cleanPath;
  };

  provide(SETTINGS_KEY, {
    settings,
    isLoading,
    error,
    fetchSettings,
    getImageUrl
  });

  return { settings, isLoading, error, fetchSettings, getImageUrl };
}

export function useSettings() {
  const context = inject(SETTINGS_KEY);
  if (!context) {
    // Fallback if useSettings is called outside of provider context
    return { settings: reactive({}), isLoading: ref(false), error: ref(null), getImageUrl: (p) => p };
  }
  return context;
}
