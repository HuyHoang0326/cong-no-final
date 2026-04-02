@extends('layouts.create')
@extends('layouts.sidebar')

@section('content')
    <div class="main">

        <div class="header">
            <h1>Chỉnh Sửa Khách Hàng</h1>
            <div>
                <a href="{{ route('customers.index') }}" class="btn btn-back">← Back</a>
            </div>
        </div>

        <div class="card">
            <form id="customerForm" method="POST" action="{{ route('customers.update', $customer->id) }}">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    <div class="form-group">
                        <label>Mã Khách Hàng</label>
                        <input type="text" id="customer_code" name="customer_code" value="{{ $customer->customer_code }}"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label>Tên Khách Hàng</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $customer->name) }}">
                        <div class="error" id="error-name"></div>
                    </div>

                    <div class="form-group">
                        <label>SĐT</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}">
                        <div class="error" id="error-phone"></div>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $customer->email) }}">
                        <div class="error" id="error-email"></div>
                    </div>

                    <div class="form-group">
                        <label>Địa Chỉ</label>
                        <input type="text" id="address" name="address"
                            value="{{ old('address', $customer->address) }}">
                        <div class="error" id="error-address"></div>
                    </div>

                    <div class="form-group">
                        <label>Khách Tiềm Năng</label>
                        <select id="is_potential" name="is_potential">
                            <option value="0" {{ $customer->is_potential == 0 ? 'selected' : '' }}>Không</option>
                            <option value="1" {{ $customer->is_potential == 1 ? 'selected' : '' }}>Có</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Số Đơn Đã Thanh Toán</label>
                        <input type="number" id="paid_orders_count" name="paid_orders_count"
                            value="{{ old('paid_orders_count', $customer->paid_orders_count) }}">
                        <div class="error" id="error-paid_orders_count"></div>
                    </div>

                    <div class="form-group">
                        <label>Số Đơn Chưa Thanh Toán</label>
                        <input type="number" id="unpaid_orders_count" name="unpaid_orders_count"
                            value="{{ old('unpaid_orders_count', $customer->unpaid_orders_count) }}">
                        <div class="error" id="error-unpaid_orders_count"></div>
                    </div>

                    <div class="form-group">
                        <label>Tổng Tiền Đã Mua</label>
                        <input type="number" id="total_purchased_amount" name="total_purchased_amount"
                            value="{{ old('total_purchased_amount', $customer->total_purchased_amount) }}">
                        <div class="error" id="error-total_purchased_amount"></div>
                    </div>

                    <div class="form-group">
                        <label>Dư Nợ</label>
                        <input type="number" id="outstanding_amount" name="outstanding_amount"
                            value="{{ old('outstanding_amount', $customer->outstanding_amount) }}">
                        <div class="error" id="error-outstanding_amount"></div>
                    </div>

                </div>

                <div class="form-actions">
                    <a href="{{ route('customers.index') }}" class="btn btn-back">Huỷ</a>
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </div>
            </form>
        </div>
<script src="{{ asset('js/validate/customer.js') }}"></script>
    </div>
@endsection
