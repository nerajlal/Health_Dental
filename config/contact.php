<?php

return [
    'name' => env('APP_NAME', 'DentalChain'),
    
    // Contact Information
    'contact' => [
        'email' => env('CONTACT_EMAIL', 'info@dentalchain.com'),
        'phone' => env('CONTACT_PHONE', '+1 (555) 123-4567'),
        'address' => env('CONTACT_ADDRESS', '123 Business Park, City, State 12345'),
        'whatsapp' => env('CONTACT_WHATSAPP', '15551234567'),
        'map_url' => env('CONTACT_MAP_URL', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.2412648750455!2d-73.98823492346454!3d40.75889697138558!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25855c6480299%3A0x55194ec5a1ae072e!2sTimes%20Square!5e0!3m2!1sen!2sus!4v1234567890123!5m2!1sen!2sus'),
    ],
    
    // Department Emails
    'emails' => [
        'support' => env('EMAIL_SUPPORT', 'support@dentalchain.com'),
        'privacy' => env('EMAIL_PRIVACY', 'privacy@dentalchain.com'),
        'legal' => env('EMAIL_LEGAL', 'legal@dentalchain.com'),
        'refunds' => env('EMAIL_REFUNDS', 'refunds@dentalchain.com'),
    ],
    
    // Social Media
    'social' => [
        'facebook' => env('SOCIAL_FACEBOOK', '#'),
        'twitter' => env('SOCIAL_TWITTER', '#'),
        'linkedin' => env('SOCIAL_LINKEDIN', '#'),
        'instagram' => env('SOCIAL_INSTAGRAM', '#'),
    ],
    
    // Business Hours
    'hours' => env('BUSINESS_HOURS', 'Monday-Friday, 9 AM - 6 PM EST'),
];

