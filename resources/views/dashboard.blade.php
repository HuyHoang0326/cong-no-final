@extends('layouts.dashboard')

@section('title', 'Core System')

@section('content')

<div class="logo">QUẢN LÝ CÔNG NỢ</div>

<div class="grid">

     <a href="{{ route('jobs.index') }}" class="card">
        <div class="icon">⏳</div>
        <h3>Việc Chưa Sử Lý</h3>
    </a>

    <a href="{{ route('invoices.create') }}" class="card">
        <div class="icon">📊</div>
        <h3>Tạo Hoá Đơn Bán Hàng</h3>
    </a>

    <a href="{{ route('cars.create') }}" class="card">
        <div class="icon">🚚</div>
        <h3>Nhập Xe</h3>
    </a>

    <a href="{{ route('parsts.create') }}" class="card">
        <div class="icon">🔧</div>
        <h3>Nhập Phụ Tùng</h3>
    </a>

     <a href="{{ route('debts.index') }}" class="card">
        <div class="icon">💰</div>
        <h3>Quản Lý Nợ</h3>
    </a>
    
    <a href="{{ route('cars.index') }}" class="card">
        <div class="icon">📦</div>
        <h3>Kho</h3>
    </a>

    <a href="{{ route('customers.index') }}" class="card">
        <div class="icon">👤</div>
        <h3>Quản Lý Khách Hàng</h3>
    </a>

    <a href="{{ route('invoices.index') }}" class="card">
        <div class="icon">🧾</div>
        <h3>Quản Lý Hoá Đơn</h3>
    </a>

    <a href="" class="card">
        <div class="icon">👨‍💼</div>
        <h3>Quản Lý Tài Khoản</h3>
    </a>

    <a href="" class="card">
        <div class="icon">📈</div>
        <h3>Thống Kê</h3>
    </a>

</div>

@endsection
