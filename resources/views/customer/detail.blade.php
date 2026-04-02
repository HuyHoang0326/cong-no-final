  @extends('layouts.detail')
  @extends('layouts.sidebar')
  @section('content')
  <div class="main">
        <div class="header">
            <h1>Chi Khách Hàng</h1>
            <div>
                <button class="btn btn-back">← Back</button>
                <button class="btn btn-edit"><a href="{{ route('customers.edit', $customer->id) }}">Chỉnh Sửa</a></button>
            </div>
        </div>

        <div class="card">
            <div class="detail-grid">

                <div class="detail-item">
                    <label>Mã Khách Hàng</label>
                    <span>{{ $customer->customer_code }}</span>
                </div>

                <div class="detail-item">
                    <label>Tên</label>
                    <span>{{ $customer->name }}</span>
                </div>

                <div class="detail-item">
                    <label>Số Điện Thoại</label>
                    <span>{{ $customer->phone }}</span>
                </div>

                <div class="detail-item">
                    <label>Địa Chỉ</label>
                    <span>{{ $customer->address }}.</span>
                </div>

                <div class="detail-item">
                    <label>Email</label>
                    <span>{{ $customer->email }}</span>
                </div>

                <div class="detail-item">
                    <label>Khách Hàng Tiềm Năng</label>
                    <span>{{ $customer->is_potential }}</span>
                </div>

                <div class="detail-item clickable-row clickable-invoice" data-href="{{ route('invoices.customerIsPaid', $customer->id) }}">
                    <label>Hoá Đơn Đã Thanh Toán</label>
                    <span>{{ $invoiceIsPaid }}</span>
                </div>

                <div class="detail-item clickable-row clickable-invoice" data-href="{{ route('invoices.customerIsDebt', $customer->id) }}">
                    <label>Hoá Đơn Dư Nợ</label>
                    <span>{{ $invoiceIsDebt }}</span>
                </div>

                <div class="detail-item clickable-row clickable-invoice" data-href="{{ route('invoices.customerIsDebt', $customer->id) }}">
                    <label>Hoá Đơn Đã Hủy</label>
                    <span>{{ $invoiceCustomerCancelled }}</span>
                </div>

                <div class="detail-item">
                    <label>Tổng Tiền Đã Mua Hàng</label>
                    <span>{{ number_format($customer->total_purchased_amount, 0, ',', '.') }}</span>
                </div>

                <div class="detail-item">
                    <label>Tổng Tiền Còn Nợ</label>
                    <span>{{ number_format($customer->outstanding_amount, 0, ',', '.') }}</span>
                </div>

                <div class="detail-item">
                    <label>Ngày Tạo Quản Lí</label>
                    <span>{{ $customer->created_at}}</span>
                </div>

                <div class="detail-item">
                    <label>Ngày Chỉnh Sửa Quản Lí</label>
                    <span>{{ $customer->updated_at}}</span>
                </div>
            </div>
        </div>
 <script src="{{ asset('js/detail.js') }}"></script>
    </div>
@endsection
