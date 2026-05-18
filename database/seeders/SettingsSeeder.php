<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General & Branding
            ['key' => 'site_name', 'value' => 'Ndauwo Safari Co.', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Expeditions designed for the discerning explorer.', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Premium safari experiences across Tanzania, from the Serengeti to Zanzibar.', 'group' => 'general'],
            ['key' => 'site_logo_light', 'value' => null, 'group' => 'appearance', 'type' => 'image'],
            ['key' => 'site_logo_dark', 'value' => null, 'group' => 'appearance', 'type' => 'image'],
            ['key' => 'site_favicon', 'value' => null, 'group' => 'appearance', 'type' => 'image'],

            // Contact Details
            ['key' => 'contact_email', 'value' => 'expeditions@ndauwo.com', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+255 799 729 889', 'group' => 'contact'],
            ['key' => 'contact_whatsapp', 'value' => '+255 799 729 889', 'group' => 'contact'],
            ['key' => 'contact_emergency', 'value' => '+255 7XX XXX XXX', 'group' => 'contact'],
            ['key' => 'office_address', 'value' => 'HQ Arusha, Arusha Safari Centre, Plot 42, Arusha, Tanzania', 'group' => 'contact'],
            ['key' => 'gps_hq', 'value' => '3.3869° S, 36.6830° E', 'group' => 'contact'],
            ['key' => 'gps_serengeti', 'value' => '2.3333° S, 34.8333° E', 'group' => 'contact'],

            // Social Media
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/ndauwosafari', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/ndauwosafari', 'group' => 'social'],
            ['key' => 'social_twitter', 'value' => '', 'group' => 'social'],
            ['key' => 'social_linkedin', 'value' => '', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => '', 'group' => 'social'],
            ['key' => 'social_tripadvisor', 'value' => 'https://www.tripadvisor.com/', 'group' => 'social'],

            // Email (SMTP configuration)
            ['key' => 'mail_mailer', 'value' => 'smtp', 'group' => 'mail'],
            ['key' => 'mail_host', 'value' => 'smtp.mailtrap.io', 'group' => 'mail'],
            ['key' => 'mail_port', 'value' => '2525', 'group' => 'mail'],
            ['key' => 'mail_username', 'value' => '', 'group' => 'mail'],
            ['key' => 'mail_password', 'value' => '', 'group' => 'mail'],
            ['key' => 'mail_encryption', 'value' => 'tls', 'group' => 'mail'],
            ['key' => 'mail_from_address', 'value' => 'expeditions@ndauwo.com', 'group' => 'mail'],
            ['key' => 'mail_from_name', 'value' => 'Ndauwo Safaris', 'group' => 'mail'],

            // SEO
            ['key' => 'seo_meta_title', 'value' => 'Ndauwo Safaris - Ultimate Tanzania Adventure', 'group' => 'seo'],
            ['key' => 'seo_meta_description', 'value' => 'Experience the best of Tanzania with Ndauwo Safaris. Kilimanjaro treks, wildlife safaris, and Zanzibar beach holidays.', 'group' => 'seo'],
            ['key' => 'seo_meta_keywords', 'value' => 'safari, tanzania, serengeti, kilimanjaro, zanzibar, adventure travel', 'group' => 'seo'],
            ['key' => 'seo_og_image', 'value' => null, 'group' => 'seo', 'type' => 'image'],
            ['key' => 'seo_google_analytics', 'value' => 'UA-XXXXX-Y', 'group' => 'seo'],
            ['key' => 'seo_facebook_pixel', 'value' => '', 'group' => 'seo'],
            ['key' => 'ga4_id', 'value' => '', 'group' => 'seo'],
            ['key' => 'gtm_id', 'value' => '', 'group' => 'seo'],
            ['key' => 'seo_social_profiles', 'value' => '["https://www.tripadvisor.com/","https://www.facebook.com/","https://www.instagram.com/"]', 'group' => 'seo', 'type' => 'json'],
            ['key' => 'seo_aggregate_rating', 'value' => '4.9', 'group' => 'seo'],
            ['key' => 'seo_review_count', 'value' => '312', 'group' => 'seo'],
            ['key' => 'seo_price_range', 'value' => '$$$', 'group' => 'seo'],
            ['key' => 'seo_postal_code', 'value' => '23000', 'group' => 'seo'],
            ['key' => 'gps_lat', 'value' => '-3.3869', 'group' => 'contact'],
            ['key' => 'gps_lng', 'value' => '36.6830', 'group' => 'contact'],

            // Payment & Booking
            ['key' => 'booking_currency', 'value' => 'USD', 'group' => 'booking'],
            ['key' => 'booking_deposit_percentage', 'value' => '30', 'group' => 'booking'],
            ['key' => 'booking_terms_conditions', 'value' => 'Standard terms apply. 30% deposit required to confirm booking.', 'group' => 'booking'],
            ['key' => 'booking_cancellation_policy', 'value' => 'Free cancellation up to 60 days before travel.', 'group' => 'booking'],
            ['key' => 'booking_min_days_notice', 'value' => '7', 'group' => 'booking'],

            // Stripe Payment
            ['key' => 'payment_stripe_enabled', 'value' => '0', 'group' => 'payment'],
            ['key' => 'payment_stripe_key', 'value' => '', 'group' => 'payment'],
            ['key' => 'payment_stripe_secret', 'value' => '', 'group' => 'payment'],

            // Appearance
            ['key' => 'appearance_primary_color', 'value' => '#c5a059', 'group' => 'appearance'],
            ['key' => 'appearance_accent_color', 'value' => '#1a1f18', 'group' => 'appearance'],
            ['key' => 'appearance_font_heading', 'value' => 'Playfair Display', 'group' => 'appearance'],
            ['key' => 'appearance_font_body', 'value' => 'Inter', 'group' => 'appearance'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}