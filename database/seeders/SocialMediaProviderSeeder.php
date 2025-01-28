<?php

namespace Database\Seeders;

use App\Models\SocialMediaProvider;
use Illuminate\Database\Seeder;

class SocialMediaProviderSeeder extends Seeder
{
    public function run(): void
    {
        SocialMediaProvider::create([
            'platform_name' => 'facebook',
            'website_url' => 'https://www.facebook.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'YouTube',
            'website_url' => 'https://www.youtube.com/',
        ]);
        //		Start here
        SocialMediaProvider::create([
            'platform_name' => 'Instagram',
            'website_url' => 'https://www.instagram.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'TikToc',
            'website_url' => 'https://www.tiktok.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'X',
            'website_url' => 'https://www.twitter.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'LinkedIn',
            'website_url' => 'https://www.linkedin.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'Snapchat',
            'website_url' => 'https://www.snapchat.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'Pinterest',
            'website_url' => 'https://www.pinterest.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'Reddit',
            'website_url' => 'https://www.reddit.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'WhatsApp',
            'website_url' => 'https://www.whatsapp.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'WeChat',
            'website_url' => 'https://www.wechat.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'Telegram',
            'website_url' => 'https://www.telegram.org/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'Discord',
            'website_url' => 'https://www.discord.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'Tumblr',
            'website_url' => 'https://www.tumblr.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'Quora',
            'website_url' => 'https://www.quora.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'Clubhouse',
            'website_url' => 'https://www.clubhouse.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'Threads',
            'website_url' => 'https://www.threads.net/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'Signal',
            'website_url' => 'https://www.signal.org/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'BeReal',
            'website_url' => 'https://www.bereal.com/',
        ]);
        SocialMediaProvider::create([
            'platform_name' => 'Twitch',
            'website_url' => 'https://www.twitch.tv/',
        ]);
    }
}
