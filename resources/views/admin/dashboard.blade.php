@extends('admin.layouts.app')

@section('title', 'Super Admin Dashboard — Lentera Quran')

@section('content')
    {{-- Row 1: 3 KPI Cards --}}
    @include('admin.partials.kpi-cards')

    {{-- Row 2: Total Pengguna Aktif Area Line Chart --}}
    @include('admin.partials.active-users-chart')
@endsection
