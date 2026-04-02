@extends('layouts.create')
@extends('layouts.sidebar')

@section('content')
    <div class="main">

        <div class="header">
            <h1>Thêm Khách Hàng</h1>
        </div>

        <div class="card">
            <form id="customerForm" method="POST" action="{{ route('customers.store') }}">
                @csrf

                <div class="form-grid">

                    <div class="form-group">
                        <label>Mã Khách Hàng</label>
                        <input type="text" id="customer_code" name="customer_code">
                        <div class="error" id="error-customer_code"></div>
                    </div>

                    <div class="form-group">
                        <label>Tên</label>
                        <input type="text" id="name" name="name">
                        <div class="error" id="error-name"></div>
                    </div>

                    <div class="form-group">
                        <label>Số Điện Thoại</label>
                        <input type="text" id="phone" name="phone">
                        <div class="error" id="error-phone"></div>
                    </div>

                    <div class="form-group">
                        <label>Địa Chỉ</label>
                        <input type="text" id="address" name="address">
                        <div class="error" id="error-address"></div>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="email" name="email">
                        <div class="error" id="error-email"></div>
                    </div>

                    <div class="form-group">
                        <label>Khách Hàng Tiềm Năng</label>
                        <select id="is_potential" name="is_potential">
                            <option value="1">Có</option>
                            <option value="0">Không</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Hoá Đơn Đã Thanh Toán</label>
                        <input type="number" id="paid_invoices" name="paid_invoices">
                        <div class="error" id="error-paid_invoices"></div>
                    </div>

                    <div class="form-group">
                        <label>Hoá Đơn Dư Nợ</label>
                        <input type="number" id="debt_invoices" name="debt_invoices">
                        <div class="error" id="error-debt_invoices"></div>
                    </div>

                    <div class="form-group">
                        <label>Tổng Tiền Đã Mua Hàng</label>
                        <input type="number" id="total_spent" name="total_spent">
                        <div class="error" id="error-total_spent"></div>
                    </div>

                    <div class="form-group">
                        <label>Tổng Tiền Còn Nợ</label>
                        <input type="number" id="total_debt" name="total_debt">
                        <div class="error" id="error-total_debt"></div>
                    </div>

                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-back">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Customer</button>
                </div>
            </form>
        </div>

    </div>
     <script src="{{ asset('js/validate/customer.js') }}"></script>
@endsection
