<meta property="og:site_name" content="LinkGo">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $villageOpenGraph['title'] }}">
<meta property="og:description" content="{{ $villageOpenGraph['description'] }}">
<meta property="og:url" content="{{ route('village.show', ['slug' => $villageSlug]) }}">
@if ($villageOpenGraph['image'])
    <meta property="og:image" content="{{ asset($villageOpenGraph['image']) }}">
    <meta property="og:image:type" content="{{ $villageOpenGraph['image_type'] ?? 'image/png' }}">
    <meta property="og:image:width" content="{{ $villageOpenGraph['image_width'] ?? 1200 }}">
    <meta property="og:image:height" content="{{ $villageOpenGraph['image_height'] ?? 630 }}">
    <meta property="og:image:alt" content="{{ $villageOpenGraph['image_alt'] }}">
@endif
