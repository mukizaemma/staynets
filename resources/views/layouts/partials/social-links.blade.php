@php
    $socialLinks = [
        'facebook' => ['url' => $setting->facebook ?? null, 'icon' => 'fab fa-facebook-f', 'label' => 'Facebook'],
        'instagram' => ['url' => $setting->instagram ?? null, 'icon' => 'fab fa-instagram', 'label' => 'Instagram'],
        'tiktok' => ['url' => $setting->tiktok ?? null, 'icon' => 'fab fa-tiktok', 'label' => 'TikTok'],
        'youtube' => ['url' => $setting->youtube ?? null, 'icon' => 'fab fa-youtube', 'label' => 'YouTube'],
        'linkedin' => ['url' => $setting->linkedin ?? null, 'icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn'],
    ];
    $phone = primaryPhone($setting);
    $wa = whatsappUrl($phone);
@endphp

@foreach($socialLinks as $network => $item)
    @if(! empty($item['url']))
        <a href="{{ $item['url'] }}" rel="noopener noreferrer" target="_blank" aria-label="{{ $item['label'] }}">
            <i class="{{ $item['icon'] }}" aria-hidden="true"></i>
        </a>
    @endif
@endforeach

@if($wa)
    <a href="{{ $wa }}" rel="noopener noreferrer" target="_blank" aria-label="WhatsApp">
        <i class="fab fa-whatsapp" aria-hidden="true"></i>
    </a>
@endif
