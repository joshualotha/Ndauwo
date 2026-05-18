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

// Route metadata for client-side SPA navigation
const routeMeta = {
    'home': { title: "Ndauwo — Tanzania's Premier Luxury Safari Experience", description: 'Discover bespoke Tanzania safaris with Ndauwo. Expert-guided luxury expeditions to Serengeti, Ngorongoro, Kilimanjaro & Zanzibar since 2010.' },
    'safaris': { title: 'Luxury Tanzania Safari Packages & Tours — Ndauwo', description: 'Browse our curated collection of Tanzania safari packages. Tailor-made luxury expeditions, Kilimanjaro climbs, and Zanzibar beach retreats.' },
    'safari-detail': { title: 'Safari Details — Ndauwo', description: 'Explore this Tanzania safari package in detail.' },
    'safari-types-index': { title: 'Safari Experiences & Styles — Ndauwo', description: 'Explore Tanzania through our diverse safari experiences: luxury expeditions, cultural tours, mountain hiking, group departures, and Zanzibar retreats.' },
    'safari-mountain': { title: 'Mountain Hiking & Kilimanjaro Climbs — Ndauwo', description: 'Conquer Africa\'s highest peak with Ndauwo. Expert-guided Kilimanjaro climbs, Mount Meru treks, and Tanzania mountain hiking adventures.' },
    'safari-cultural': { title: 'Cultural Tours & Expeditions — Ndauwo', description: 'Experience authentic Tanzania through cultural expeditions. Visit Maasai villages, Hadzabe bushmen, and explore Tanzania\'s rich heritage with Ndauwo.' },
    'safari-luxury': { title: 'Luxury Safari Expeditions — Ndauwo', description: 'Indulge in Tanzania\'s finest luxury safaris. Private guides, premium lodges, and bespoke itineraries across Serengeti, Ngorongoro, and beyond.' },
    'safari-tailor': { title: 'Tailor-Made Tanzania Safaris — Ndauwo', description: 'Design your perfect Tanzania safari. Our experts craft bespoke itineraries tailored to your interests, schedule, and style of travel.' },
    'safari-zanzibar': { title: 'Zanzibar Beach Retreats & Safaris — Ndauwo', description: 'Combine world-class safari with Zanzibar\'s pristine beaches. Luxury beach retreats, spice tours, and Indian Ocean adventures with Ndauwo.' },
    'safari-group': { title: 'Group Safari Departures — Ndauwo', description: 'Join our expertly guided group safari departures. Experience Tanzania\'s wildlife with like-minded adventurers at exceptional value.' },
    'destinations': { title: 'Tanzania Safari Destinations — Ndauwo', description: 'Explore Tanzania\'s iconic safari destinations: Serengeti, Ngorongoro Crater, Kilimanjaro, Zanzibar, Selous, Ruaha, Tarangire, and more.' },
    'destination-detail': { title: 'Destination Guide — Ndauwo', description: 'Detailed guide to this Tanzania safari destination.' },
    'about': { title: 'About Ndauwo — Tanzania Luxury Safari Company', description: 'Ndauwo has been crafting bespoke Tanzania safaris since 2010. Learn about our heritage, conservation commitment, and expert team based in Arusha.' },
    'planning-accommodation': { title: 'Tanzania Safari Accommodation Guide — Ndauwo', description: 'Compare Tanzania safari accommodation styles: luxury lodges, tented camps, mobile camps, and boutique hotels. Find your perfect safari stay.' },
    'planning-visa': { title: 'Tanzania Visa & Entry Requirements — Ndauwo', description: 'Complete guide to Tanzania visa requirements, entry regulations, passport validity, and border crossing information for safari travelers.' },
    'planning-health': { title: 'Health & Safety Guide for Tanzania Safaris — Ndauwo', description: 'Essential health and safety information for Tanzania safari travel: vaccinations, malaria prevention, travel insurance, and emergency protocols.' },
    'planning-packing': { title: 'Tanzania Safari Packing List — Ndauwo', description: 'Comprehensive Tanzania safari packing guide: clothing, gear, photography equipment, and essentials for your East African adventure.' },
    'planning-etiquette': { title: 'Tanzania Cultural Etiquette Guide — Ndauwo', description: 'Learn Tanzania cultural etiquette: greetings, dress codes, photography etiquette, tipping customs, and respectful travel practices.' },
    'conservation': { title: 'Conservation Commitment — Ndauwo', description: 'Ndauwo is committed to preserving Tanzania\'s wildlife and empowering local communities. Learn about our conservation initiatives.' },
    'blog': { title: 'Safari Stories & Tanzania Travel Journal — Ndauwo', description: 'Read expert Tanzania travel guides, safari stories, conservation updates, and insider tips from Ndauwo\'s field team in Arusha.' },
    'blog-post': { title: 'Safari Story — Ndauwo', description: 'Read this Tanzania safari story from Ndauwo\'s travel journal.' },
    'reviews': { title: 'Client Reviews & Testimonials — Ndauwo', description: 'Read what our guests say about their Ndauwo Tanzania safari experiences. Real reviews from discerning travelers worldwide.' },
    'media-kit': { title: 'Press & Media Kit — Ndauwo', description: 'Download Ndauwo\'s media kit, press releases, high-resolution images, and brand assets for editorial use.' },
    'gallery': { title: 'Safari Photo Gallery — Ndauwo', description: 'Browse stunning photography from Ndauwo\'s Tanzania safaris. Wildlife, landscapes, lodges, and unforgettable moments captured across East Africa.' },
    'careers': { title: 'Careers at Ndauwo — Join Our Safari Team', description: 'Explore career opportunities with Ndauwo Safari Co. Join our team of passionate safari guides, conservationists, and hospitality professionals.' },
    'contact': { title: 'Contact Ndauwo — Plan Your Tanzania Safari', description: 'Get in touch with Ndauwo\'s safari experts. We\'ll help you plan the perfect Tanzania luxury expedition tailored to your dreams.' },
    'booking': { title: 'Book Your Tanzania Safari — Ndauwo', description: 'Ready to book your dream Tanzania safari? Contact Ndauwo\'s expert team to reserve your luxury expedition, Kilimanjaro climb, or Zanzibar retreat.' },
};

// Update HTML head meta tags on SPA navigation
function updateMetaTags(meta) {
    const defaults = {
        title: "Ndauwo — Tanzania's Premier Luxury Safari Experience",
        description: 'Discover bespoke Tanzania safaris with Ndauwo. Expert-guided luxury expeditions to Serengeti, Ngorongoro, Kilimanjaro & Zanzibar since 2010.',
    };
    const { title, description } = { ...defaults, ...meta };

    document.title = title;

    // Update meta description
    let descEl = document.querySelector('meta[name="description"]');
    if (descEl) descEl.setAttribute('content', description);

    // Update OG title
    let ogTitle = document.querySelector('meta[property="og:title"]');
    if (ogTitle) ogTitle.setAttribute('content', title);

    // Update OG description
    let ogDesc = document.querySelector('meta[property="og:description"]');
    if (ogDesc) ogDesc.setAttribute('content', description);

    // Update Twitter title
    let twTitle = document.querySelector('meta[name="twitter:title"]');
    if (twTitle) twTitle.setAttribute('content', title);

    // Update Twitter description
    let twDesc = document.querySelector('meta[name="twitter:description"]');
    if (twDesc) twDesc.setAttribute('content', description);

    // Update canonical URL
    let canonical = document.querySelector('link[rel="canonical"]');
    if (canonical) canonical.setAttribute('href', window.location.origin + window.location.pathname);
}

// Navigation Guard
router.beforeEach((to, from) => {
    const isAuthenticated = !!localStorage.getItem('admin_token');
    
    if (to.meta.requiresAuth && !isAuthenticated) {
        return '/admin/login';
    } else if (to.name === 'admin-login' && isAuthenticated) {
        return '/admin/dashboard';
    }
});

// Update HTML head meta tags on SPA navigation
router.afterEach((to) => {
    const meta = routeMeta[to.name] || routeMeta['home'];
    updateMetaTags(meta);
});

export default router
