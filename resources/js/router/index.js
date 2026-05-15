import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ContactView from '../views/ContactView.vue'
import SafarisView from '../views/SafarisView.vue'
import DestinationsView from '../views/DestinationsView.vue'
import SafariDetailView from '../views/SafariDetailView.vue'
import DestinationDetailView from '../views/DestinationDetailView.vue'
import MountainHikingView from '../views/safari-types/MountainHikingView.vue'
import CulturalToursView from '../views/safari-types/CulturalToursView.vue'
import LuxurySafariView from '../views/safari-types/LuxurySafariView.vue'
import TailorMadeSafariView from '../views/safari-types/TailorMadeSafariView.vue'
import ZanzibarBeachView from '../views/safari-types/ZanzibarBeachView.vue'
import GroupSafariView from '../views/safari-types/GroupSafariView.vue'
import AboutView from '../views/AboutView.vue'
import ConservationView from '../views/ConservationView.vue'
import BlogView from '../views/BlogView.vue'
import BlogPostView from '../views/BlogPostView.vue'
import ReviewsView from '../views/ReviewsView.vue'
import MediaKitView from '../views/MediaKitView.vue'
import CareersView from '../views/CareersView.vue'
import GalleryView from '../views/GalleryView.vue'
import AdminAuthView from '../views/AdminAuthView.vue'
import AdminDashboardView from '../views/AdminDashboardView.vue'
import AdminInquiriesView from '../views/AdminInquiriesView.vue'
import AdminInquiryDetailView from '../views/AdminInquiryDetailView.vue'
import AdminBookingsView from '../views/AdminBookingsView.vue'
import AdminBookingDetailView from '../views/AdminBookingDetailView.vue'
import AdminDestinationsView from '../views/AdminDestinationsView.vue'
import AdminDestinationEditorView from '../views/AdminDestinationEditorView.vue'
import AdminPackagesView from '../views/AdminPackagesView.vue'
import AdminPackageEditorView from '../views/AdminPackageEditorView.vue'
import AdminReviewsView from '../views/AdminReviewsView.vue'
import AdminGalleryView from '../views/AdminGalleryView.vue'
import AdminSettingsView from '../views/AdminSettingsView.vue'

import AdminPageImagesView from '../views/AdminPageImagesView.vue'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        { path: '/', name: 'home', component: HomeView },
        { path: '/contact', name: 'contact', component: ContactView },
        { path: '/safaris', name: 'safaris', component: SafarisView },
        { path: '/safaris/:id', name: 'safari-detail', component: SafariDetailView },
        { path: '/safari-types', name: 'safari-types-index', component: () => import('../views/SafariCategoryIndexView.vue') },
        { path: '/safari-types/mountain-hiking', name: 'safari-mountain', component: MountainHikingView },
        { path: '/safari-types/cultural-tours', name: 'safari-cultural', component: CulturalToursView },
        { path: '/safari-types/luxury-safari', name: 'safari-luxury', component: LuxurySafariView },
        { path: '/safari-types/tailor-made-safari', name: 'safari-tailor', component: TailorMadeSafariView },
        { path: '/safari-types/zanzibar-beach-safari', name: 'safari-zanzibar', component: ZanzibarBeachView },
        { path: '/safari-types/group-safari', name: 'safari-group', component: GroupSafariView },
        { path: '/destinations', name: 'destinations', component: DestinationsView },
        { path: '/destinations/:slug', name: 'destination-detail', component: DestinationDetailView },
        { path: '/about', name: 'about', component: AboutView },
        {
            path: '/planning/accommodation-styles',
            name: 'planning-accommodation',
            component: () => import('../views/planning/AccommodationStylesView.vue')
        },
        {
            path: '/planning/visa-entry',
            name: 'planning-visa',
            component: () => import('../views/planning/VisaEntryView.vue')
        },
        {
            path: '/planning/health-safety',
            name: 'planning-health',
            component: () => import('../views/planning/HealthSafetyView.vue')
        },
        {
            path: '/planning/packing-list',
            name: 'planning-packing',
            component: () => import('../views/planning/PackingListView.vue')
        },
        {
            path: '/planning/cultural-etiquette',
            name: 'planning-etiquette',
            component: () => import('../views/planning/CulturalEtiquetteView.vue')
        },
        { path: '/conservation', name: 'conservation', component: ConservationView },
        { path: '/journal', name: 'blog', component: BlogView },
        { path: '/journal/:slug', name: 'blog-post', component: BlogPostView },
        { path: '/reviews', name: 'reviews', component: ReviewsView },
        { path: '/press', name: 'media-kit', component: MediaKitView },
        { path: '/gallery', name: 'gallery', component: GalleryView },
        { path: '/careers', name: 'careers', component: CareersView },
        { path: '/privacy', name: 'privacy', component: HomeView },
        { path: '/terms', name: 'terms', component: HomeView },
        { path: '/booking', name: 'booking', component: ContactView },
        { path: '/admin/login', name: 'admin-login', component: AdminAuthView, meta: { hideNavbar: true, hideFooter: true } },
        { path: '/admin/dashboard', name: 'admin-dashboard', component: AdminDashboardView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } },
        { path: '/admin/inquiries', name: 'admin-inquiries', component: AdminInquiriesView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } },
        { path: '/admin/inquiries/:id', name: 'admin-inquiry-detail', component: AdminInquiryDetailView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } },
        { path: '/admin/bookings', name: 'admin-bookings', component: AdminBookingsView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } },
        { path: '/admin/bookings/:id', name: 'admin-booking-detail', component: AdminBookingDetailView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } },
        { path: '/admin/destinations', name: 'admin-destinations', component: AdminDestinationsView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } },
        { path: '/admin/destinations/create', name: 'admin-destination-create', component: AdminDestinationEditorView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } },
        { path: '/admin/destinations/edit/:id', name: 'admin-destination-edit', component: AdminDestinationEditorView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } },
        { path: '/admin/packages', name: 'admin-packages', component: AdminPackagesView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } },
        { path: '/admin/packages/create', name: 'admin-package-create', component: AdminPackageEditorView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } },
        { path: '/admin/packages/edit/:id', name: 'admin-package-edit', component: AdminPackageEditorView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } },
        { path: '/admin/reviews', name: 'admin-reviews', component: AdminReviewsView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } },
        { path: '/admin/gallery', name: 'admin-gallery', component: AdminGalleryView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } },
        { path: '/admin/page-images', name: 'admin-page-images', component: AdminPageImagesView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } },
        { path: '/admin/settings', name: 'admin-settings', component: AdminSettingsView, meta: { requiresAuth: true, hideNavbar: true, hideFooter: true } }
    ],
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return { el: to.hash, behavior: 'smooth' }
        }
        if (savedPosition) {
            return savedPosition
        } else {
            return { top: 0, behavior: 'smooth' }
        }
    }
})

// Navigation Guard
router.beforeEach((to, from) => {
    const isAuthenticated = !!localStorage.getItem('admin_token');
    
    if (to.meta.requiresAuth && !isAuthenticated) {
        return '/admin/login';
    } else if (to.name === 'admin-login' && isAuthenticated) {
        return '/admin/dashboard';
    }
});

export default router
