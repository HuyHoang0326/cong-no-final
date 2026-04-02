@extends('layouts.create')
@extends('layouts.sidebar')

@section('content')
<div class="main">

    <div class="header">
        <h1>Chỉnh Sửa Dư Nợ</h1>
        <div>
            <a href="{{ route('debts.index') }}" class="btn btn-back">← Back</a>
           
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('debts.update', $debt->id) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label>Mã Hoá Đơn</label>
                    <input type="text" value="{{ $debt->invoice->code }}" readonly>
                </div>

                <div class="form-group">
                    <label>Khách Hàng</label>
                    <input type="text" value=" {{ $debt->customer?->name ?? $debt->invoice->customer_name }}" readonly>
                </div>

                <div class="form-group">
                    <label>Dư Nợ</label>
                    <input type="number" name="debt_amount"
                        value="{{ old('debt_amount', $debt->debt_amount) }}">
                </div>

                <div class="form-group">
                    <label>Ngày Nợ</label>
                    <input type="date" name="debt_date"
                        value="{{ old('debt_date', $debt->debt_date) }}">
                </div>

                <div class="form-group">
                    <label>Ngày Hẹn Trả</label>
                    <input type="date" name="debt_due_date"
                        value="{{ old('debt_due_date', $debt->debt_due_date) }}">
                </div>

                <div class="form-group">
                    <label>Ngày Trả</label>
                    <input type="date" name="payment_date"
                        value="{{ old('payment_date', $debt->payment_date) }}">
                </div>

                <div class="form-group">
                    <label>Trạng Thái</label>
                    <select name="status">
                        <option value="0" {{ $debt->status == 0 ? 'selected' : '' }}>Chưa Thanh Toán</option>
                        <option value="1" {{ $debt->status == 1 ? 'selected' : '' }}>Quá Hạn</option>
                        <option value="2" {{ $debt->status == 2 ? 'selected' : '' }}>Đã Thanh Toán</option>
                        <option value="2" {{ $debt->status == 3 ? 'selected' : '' }}>Đã Hủy</option>
                    </select>
                </div>

            </div>

            <div class="form-actions">
                <a href="{{ route('debts.index') }}" class="btn btn-back">Huỷ</a>
                <button type="submit" class="btn btn-primary">Cập Nhật</button>
            </div>

        </form>
    </div>
</div>
@endsection