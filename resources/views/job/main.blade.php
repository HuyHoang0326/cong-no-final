@extends('layouts.dashboard')

@section('title', 'Core System')

@section('content')

<div class="logo">Công Việc Phải Xử Lí</div>

<div class="grid">

    <a href="{{ route('invoices.create') }}" class="card">
        <div class="icon">📊</div>
        <h3>Hóa Đơn Đến Hạn</h3>
    </a>

    <a href="{{ route('cars.create') }}" class="card">
        <div class="icon">🚚</div>
        <h3>Đến Hạn Giao Xe</h3>
    </a>

    <a href="{{ route('cars.create') }}" class="card">
        <div class="icon">🚚</div>
        <h3>Xe Chưa Về Bãi</h3>
    </a>
    
    <a href="{{ route('parsts.create') }}" class="card">
        <div class="icon">🔧</div>
        <h3>Phụ Tùng Chưa Về Bãi</h3>
    </a>

     <a href="{{ route('debts.index') }}" class="card">
        <div class="icon">🚚</div>
        <h3>Giấy Tờ Xe Còn Thiếu Trong Kho</h3>
    </a>

    <a href="{{ route('debts.index') }}" class="card">
        <div class="icon">🚚</div>
        <h3>Giấy Tờ Xe Còn Thiếu Khi Giao Xe</h3>
    </a>

</div>

@endsection
