<?php

namespace App\Enums;

enum SocialMediaPlatforms: string
{
    case FACEBOOK = 'https://www.facebook.com';
    case YOUTUBE = 'https://www.youtube.com';
    case WHATSAPP = 'https://www.whatsapp.com';
    case INSTAGRAM = 'https://www.instagram.com';
    case WECHAT = 'https://www.wechat.com';
    case TIKTOK = 'https://www.tiktok.com';
    case TWITTER = 'https://www.twitter.com';
    case SINA_WEIBO = 'https://www.weibo.com';
    case QQ = 'https://im.qq.com';
    case TELEGRAM = 'https://www.telegram.org';
    case SNAPCHAT = 'https://www.snapchat.com';
    case PINTEREST = 'https://www.pinterest.com';
    case REDDIT = 'https://www.reddit.com';
    case LINKEDIN = 'https://www.linkedin.com';
    case DISCORD = 'https://discord.com';
    case QUORA = 'https://www.quora.com';
    case TUMBLR = 'https://www.tumblr.com';
    case SKYPE = 'https://www.skype.com';
    case VIBER = 'https://www.viber.com';
    case LINE = 'https://line.me';
    case MEDIUM = 'https://medium.com';
    case VK = 'https://vk.com';
    case DOUBAN = 'https://www.douban.com';
    case FLICKR = 'https://www.flickr.com';
    case MEWE = 'https://mewe.com';
    case MIX = 'https://mix.com';
    case CLUBHOUSE = 'https://www.clubhouse.com';
    case SIGNAL = 'https://www.signal.org';
    case BEHANCE = 'https://www.behance.net';
    case DRIBBBLE = 'https://www.dribbble.com';
    case GAB = 'https://www.gab.com';
    case RUMBLE = 'https://rumble.com';
    case PARLER = 'https://parler.com';
    case GETTR = 'https://gettr.com';
    case BEREAL = 'https://bere.al';
    case PEACH = 'https://peach.cool';
    case GOODREADS = 'https://www.goodreads.com';
    case BAND = 'https://band.us';
    case STEEMIT = 'https://steemit.com';

    public function getUrl(): string
    {
        return $this->value;
    }
}
