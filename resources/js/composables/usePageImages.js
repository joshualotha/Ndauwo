import { ref } from 'vue';
import axios from 'axios';
import { API_BASE_URL } from './useSettings';

export function usePageImages(pageName) {
    const images = ref({});
    const isLoading = ref(true);

    const fetchImages = async () => {
        isLoading.value = true;
        try {
            const response = await axios.get(`${API_BASE_URL}/api/page-images/${pageName}`);
            const data = response.data;

            // Transform array to key-value pairs (section -> image_path)
            const map = {};
            data.forEach(img => {
                map[img.section] = getImageUrl(img.image_path);
            });
            images.value = map;
        } catch (error) {
            console.error(`Failed to fetch page images for ${pageName}:`, error);
        } finally {
            isLoading.value = false;
        }
    };

    const getImageUrl = (path) => {
        if (!path) return '';
        if (path.startsWith('http') || path.startsWith('data:') || path.startsWith('blob:') || path.startsWith('/image-')) return path;

        // Robust storage prefixing
        if (path.includes('/storage/') || path.includes('storage/')) {
            const cleanPath = path.startsWith('/') ? path : '/' + path;
            return `${API_BASE_URL}${cleanPath.replace('//', '/')}`;
        }

        const cleanPath = path.startsWith('/') ? path : '/' + path;
        return `${API_BASE_URL}/storage${cleanPath}`;
    };

    // Helper to get an image or fallback securely
    const getImage = (section, fallback) => {
        return images.value[section] || getImageUrl(fallback);
    };

    return {
        images,
        isLoading,
        fetchImages,
        getImage
    };
}
