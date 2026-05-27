@php
    $villageLogo = \App\Models\VillageProfile::getCached()?->logo;
@endphp
@if($villageLogo)
    <link rel="icon" type="image/png" href="{{ Storage::url($villageLogo) }}">
    <link rel="apple-touch-icon" href="{{ Storage::url($villageLogo) }}">
@endif
