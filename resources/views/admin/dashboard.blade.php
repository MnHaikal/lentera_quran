@extends('admin.layouts.app')

@section('title', 'Pusat Kendali & Kurasi Konten — Super Admin Lentera Quran')

@section('topbar_title')
    <div class="flex items-center gap-2.5 flex-wrap">
        <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
            Pusat Kendali &amp; Kurasi Konten
        </h1>
    </div>
@endsection

@section('content')
    {{-- Row 1: 3 KPI Cards --}}
    @include('admin.partials.kpi-cards')

    {{-- Row 2: Total Pengguna Aktif Area Line Chart --}}
    @include('admin.partials.active-users-chart')
@endsection
