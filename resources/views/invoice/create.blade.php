@extends('layouts.create')
@section('content')
    <div class="main">
        @extends('layouts.sidebar')
        <div class="header">
            <h1>Tạo Hoá Đơn</h1>
        </div>

        <div class="card">
            <form id="invoiceForm" method="POST" action="{{ route('invoices.store') }}">
    @csrf

    <!-- ===== Thông tin hoá đơn ===== -->
    <h3 class="section-title">Thông tin chung</h3>

    <div class="form-grid">

        <div class="form-group">
            <label>Mã Hoá Đơn</label>
            <input type="text" placeholder="INV001" class="invoice-id" name="code" id="code">
            <div class="error" id="error-code"></div>
        </div>

        <div class="form-group customer-group">
            <div class="customer-header">
                <label>Tên Khách Hàng</label>
                <div class="checkbox-group">
                    <input type="checkbox" class="guestCustomer" id="guestCustomer">
                    <label>Khách Ngoài</label>
                </div>
            </div>
            <div class="field-customer form-group">
                <input type="text" placeholder="Chọn khách hàng" class="customer-name" name="customer_name" id="customer_name">
                <input type="hidden" name="customer_id" class="customer-id" id="customer_id">
                <div class="suggest-box"></div>
                <div class="error" id="error-customer_name"></div>
            </div>
        </div>

        <div class="form-group">
            <label>Số Điện Thoại</label>
            <input type="text" placeholder="Số điện thoại khách hàng" class="customer-phone"
                name="customer_phone" id="customer_phone">
            <div class="error" id="error-customer_phone"></div>
        </div>

        <div class="form-group">
            <label>Địa Chỉ</label>
            <input type="text" placeholder="Địa chỉ khách hàng" class="customer-address"
                name="customer_address" id="customer_address">
            <div class="error" id="error-customer_address"></div>
        </div>

        <div class="form-group">
            <label>Người Nhận Hàng</label>
            <input type="text" placeholder="Tên người nhận" class="receiver-name" name="receiver_name" id="receiver_name">
            <div class="error" id="error-receiver_name"></div>
        </div>

        <div class="form-group">
            <label>Ngày Bán</label>
            <input type="date" class="date-sell" name="sale_date" id="sale_date">
            <div class="error" id="error-sale_date"></div>
        </div>

        <div class="form-group">
            <label>Người Tạo Đơn</label>
            <input type="text" placeholder="Nhập tên người tạo" name="invoicer" id="invoicer">
            <div class="error" id="error-invoicer"></div>
        </div>

        <div class="form-group">
            <label>Ngày Giao Hàng</label>
            <input type="date" name="delivery_date" id="delivery_date">
            <div class="error" id="error-delivery_date"></div>
        </div>

        <div class="form-group">
            <label>Giá Giao Hàng</label>
            <input type="number" placeholder="Nhập phí giao hàng" name="shipping_cost" id="shipping_cost">
            <div class="error" id="error-shipping_cost"></div>
        </div>

        <div class="form-group">
            <label>Giấy Tờ Đã Giao</label>
            <div class="document-checkbox-group">
                <label class="document-item">
                    <input type="checkbox" name="document_delivered[]" value="hai_quan">
                    Hải Quan
                </label>
                <label class="document-item">
                    <input type="checkbox" name="document_delivered[]" value="dang_kiem">
                    Đăng Kiểm
                </label>
                <label class="document-item">
                    <input type="checkbox" name="document_delivered[]" value="hop_dong">
                    Hợp Đồng
                </label>
                <label class="document-item">
                    <input type="checkbox" name="document_delivered[]" value="da_giao_du">
                    Đã Giao Đủ
                </label>
                <label class="document-item">
                    <input type="checkbox" name="document_delivered[]" value="chua_giao">
                    Chưa Giao
                </label>
            </div>
        </div>

        <div class="form-group">
            <label>Trạng Thái</label>
            <select name="status" id="status">
                <option value="">-- Chọn trạng thái --</option>
                <option value="0">Chưa Giao</option>
                <option value="1">Đã Giao</option>
                <option value="2">Hủy Đơn Hàng</option>
            </select>
            <div class="error" id="error-status"></div>
        </div>

    </div>

    <hr class="divider">

    <!-- ===== Invoice Items ===== -->
    <h3 class="section-title">Danh sách sản phẩm</h3>

    <div class="table-wrapper product-table-wrapper" id="invoice-item-box">
        <table class="invoice-table product-table">
            {{-- invoiceCreate.js fill in here --}}
        </table>
    </div>

    <button type="button" class="btn btn-outline add-btn" id="invoice-add-row-product">
        + Thêm Sản Phẩm
    </button>

    <hr class="divider">

    <div class="debt-wrapper">

        <!-- Dư nợ -->
        <div class="debt-box">
            <h3>Dư Nợ</h3>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Đã Thanh Toán</th>
                        <th>Ngày Hẹn Trả</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="number" placeholder="Nhập tiền đã thanh toán"
                                class="paid-amount" name='paid_amount' id="paid_amount">
                            <div class="error" id="error-paid_amount"></div>
                        </td>
                        <td>
                            <input type="date" name="dubt_due_date" id="dubt_due_date">
                            <div class="error" id="error-dubt_due_date"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="hidden-box"></div>
    </div>

    <hr class="divider">

    <!-- ===== Tổng tiền ===== -->
    <h3>Tổng</h3>

    <div class="summary">
        <div class="table-wrapper">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Giá Hóa Đơn Xe</th>
                        <th>Giá Bán</th>
                        <th>Số Dư Nợ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" class="total-invoice format-number" readonly
                                name="sale_price_invoices" id="sale_price_invoices">
                        </td>
                        <td>
                            <input type="text" class="total-sale format-number" readonly
                                name="price" id="price">
                        </td>
                        <td>
                            <input type="text" class="total-debt format-number" readonly
                                name="debt_amount" id="debt_amount">
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="form-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-back">Huỷ</a>
                <button type="submit" class="btn btn-primary">Lưu Hoá Đơn</button>
            </div>
        </div>
    </div>
</form>
        </div>
        <hr class="divider">
        <div id="invoice-preview" class="invoice-print" style=""></div>
    </div>
    <script src="{{ asset('js/invoiceCreate.js') }}"></script>
    <script src="{{ asset('js/validate/invoice.js') }}"></script>
@endsection
