<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // Site
            'site_name'            => 'Church Name',
            'site_tagline'         => 'A community built on faith, hope, and love.',
            // Contact
            'church_address'       => '123 Church Street',
            'church_city'          => 'Your City, State',
            'church_phone'         => '',
            'church_email'         => '',
            'church_service_time'  => 'Sunday 10:00 AM',
            // Donation
            'donate_bank_name'     => 'Your Bank Name',
            'donate_account_name'  => 'Church Name',
            'donate_account_no'    => '000-000-0000',
            'donate_routing_no'    => '000000000',
            'donate_online_label'  => 'Give via PayPal',
            'donate_online_url'    => '',
            // Homepage
            'home_hero_title'           => 'Jesus Saves You',
            'home_hero_description'     => 'A community built on faith, hope, and love. Join us every Sunday.',
            'home_stat_1_number'        => '500+',
            'home_stat_1_label'         => 'Active Members',
            'home_stat_2_number'        => '25+',
            'home_stat_2_label'         => 'Years Serving',
            'home_stat_3_number'        => '100%',
            'home_stat_3_label'         => 'Faith Based',
            'home_ministry_1_title'     => "Children's Ministry",
            'home_ministry_1_desc'      => 'A safe, fun environment where kids learn about Jesus and grow in faith.',
            'home_ministry_2_title'     => 'Youth Ministry',
            'home_ministry_2_desc'      => 'Empowering young people to live out their faith with purpose and passion.',
            'home_ministry_3_title'     => 'Community Outreach',
            'home_ministry_3_desc'      => 'Serving our neighbors and making a real difference in our community.',
            'home_ministry_4_title'     => 'Small Groups',
            'home_ministry_4_desc'      => 'Connect deeply with others through meaningful Bible study and fellowship.',
            'home_sermon_section_desc'  => 'Join us every week as we dive into Scripture and grow together in faith.',
            'home_cta_title'            => 'Ready to Join Our Community?',
            'home_cta_description'      => "We'd love to see you this Sunday! Experience authentic worship, spiritual growth, and meaningful fellowship.",
            // About page
            'about_mission_text'    => 'We exist to glorify God by making disciples of Jesus Christ who worship faithfully, live intentionally, and serve sacrificially.',
            'about_value_1_title'   => 'Faith in Christ',
            'about_value_1_desc'    => 'We believe in the transformative power of faith in Jesus Christ as our Lord and Savior.',
            'about_value_2_title'   => 'Love & Compassion',
            'about_value_2_desc'    => 'We extend love and compassion to all people, reflecting God\'s unconditional love.',
            'about_value_3_title'   => 'Community',
            'about_value_3_desc'    => 'We foster a welcoming community where everyone belongs and can grow together.',
            'about_value_4_title'   => 'Service',
            'about_value_4_desc'    => 'We serve our neighbors and community, living out the Gospel through action.',
            'about_pastor_name'     => 'Pastor John Smith',
            'about_pastor_title'    => 'Senior Pastor',
            'about_pastor_bio'      => 'Pastor John has been leading our congregation with passion and dedication for over 15 years. With a heart for discipleship and community outreach, he brings biblical teaching that is both relevant and transformative.',
            'about_pastor_image'    => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&h=400&fit=crop',
            // Contact page
            'contact_service_1_name' => 'Sunday Morning',
            'contact_service_1_time' => '9:00 AM & 11:00 AM',
            'contact_service_2_name' => 'Wednesday Evening',
            'contact_service_2_time' => '7:00 PM',
            // Footer
            'footer_description'    => 'A community built on faith, hope, and love. Everyone is welcome.',
            // Blogs page
            'blogs_hero_label'       => 'From Our Community',
            'blogs_hero_title'       => 'Blog',
            'blogs_hero_description' => 'Thoughts, stories, and reflections from our church community.',
            // Sermons page
            'sermons_hero_title'       => 'Sermons',
            'sermons_hero_description' => 'Listen to messages that encourage, challenge, and grow your faith.',
            // Events page
            'events_hero_title'       => 'Events',
            'events_hero_description' => 'Gatherings, services, and community events happening at our church.',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
