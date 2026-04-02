@extends('layouts.create')
@extends('layouts.sidebar')

@section('content')
    <div class="main">

        <div class="header">
            <h1>Chỉnh Sửa Hoá Đơn</h1>
        </div>

        <div class="card">
            <form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
                @csrf
                @method('PUT')

                <h3 class="section-title">Thông tin chung</h3>

                <div class="form-grid">

                    <div class="form-group">
                        <label>Mã Hoá Đơn</label>
                        <input type="text" class="invoice-id" value="{{ $invoice->code }}" readonly>
                    </div>

                    <!-- CUSTOMER -->
                    <div class="form-group customer-group">
                        <div class="customer-header">
                            <label>Tên Khách Hàng</label>
                            <div class="checkbox-group">
                                <input type="checkbox" class="guestCustomer">
                                <label>Khách Ngoài</label>
                            </div>
                        </div>

                        <div class="field-customer form-group">
                            <input type="text" name="customer_name" class="customer-name"
                                value="{{ $invoice->customer_name }}">

                            <input type="hidden" name="customer_id" class="customer-id"
                                value="{{ $invoice->customer_id ?? '' }}">

                            <div class="suggest-box"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>SĐT</label>
                        <input type="text" name="customer_phone" class="customer-phone"
                            value="{{ $invoice->customer_phone }}">
                    </div>

                    <div class="form-group">
                        <label>Địa Chỉ</label>
                        <input type="text" name="customer_address" class="customer-address"
                            value="{{ $invoice->customer_address }}">
                    </div>

                    <div class="form-group">
                        <label>Người Nhận</label>
                        <input type="text" name="receiver_name" class="receiver-name"
                            value="{{ $invoice->receiver_name }}">
                    </div>

                    <div class="form-group">
                        <label>Ngày Bán</label>
                        <input type="date" name="sale_date" class="date-sell" value="{{ $invoice->sale_date }}">
                    </div>

                    <div class="form-group">
                        <label>Người Tạo</label>
                        <input type="text" name="invoicer" value="{{ $invoice->invoicer }}">
                    </div>

                    <div class="form-group">
                        <label>Ngày Giao</label>
                        <input type="date" name="delivery_date" value="{{ $invoice->delivery_date }}">
                    </div>

                    <div class="form-group">
                        <label>Phí Ship</label>
                        <input type="number" name="shipping_cost" value="{{ $invoice->shipping_cost }}">
                    </div>

                    <div class="form-group">
                        <label>Giấy Tờ Đã Giao</label>
                        @php $docs = $invoice->document_delivered ?? []; @endphp

                        <div class="document-checkbox-group">
                            @foreach (['hai_quan', 'dang_kiem', 'hop_dong', 'da_giao_du', 'chua_giao'] as $doc)
                                <label class="document-item">
                                    <input type="checkbox" name="document_delivered[]" value="{{ $doc }}"
                                        {{ in_array($doc, $docs) ? 'checked' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $doc)) }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Trạng Thái</label>
                        <select name="status">
                            <option value="0" {{ $invoice->status == 0 ? 'selected' : '' }}>Chưa Giao Xe</option>
                            <option value="1" {{ $invoice->status == 1 ? 'selected' : '' }}>Đã Giao Xe</option>
                            <option value="2" {{ $invoice->status == 2 ? 'selected' : '' }}>Huỷ Đơn Hàng</option>
                        </select>
                    </div>

                </div>

                <hr class="divider">

                <!-- ===== ITEMS ===== -->
                <h3 class="section-title">Danh sách sản phẩm</h3>

                <div class="table-wrapper product-table-wrapper" id="invoice-item-box">

                    @foreach ($invoice->items as $index => $item)
                        <table class="invoice-table product-table">
                            <thead>
                                <tr>
                                    <th>Xe/Phụ Tùng</th>

                                    @if ($item->product_type === 'car')
                                        <th>Mã Xe</th>
                                        <th>Tên Xe</th>
                                        <th>Hãng</th>
                                        <th>Số Máy</th>
                                        <th>Số Khung</th>
                                        <th>Trọng Tải</th>
                                        <th>Đơn Giá Bán</th>
                                        <th>Đơn Giá Hóa Đơn Xe</th>
                                    @endif

                                    @if ($item->product_type === 'parst')
                                        <th>Mã Phụ Tùng</th>
                                        <th>Tên</th>
                                        <th>Loại Hàng</th>
                                        <th>Cũ/Mới</th>
                                        <th>Nhà Cung Cấp</th>
                                        <th>Số Lượng Còn</th>
                                        <th>Đơn Vị Tính</th>
                                        <th>Số Lượng Bán</th>
                                        <th>Đơn Giá Bán</th>
                                        <th>Tổng Giá Bán</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                <tr>

                                    <td>
                                        <select name="items[{{ $index }}][type]" class="invoice-select item-type">
                                            <option value="car" {{ $item->product_type == 'car' ? 'selected' : '' }}>Xe
                                            </option>
                                            <option value="parst" {{ $item->product_type == 'parst' ? 'selected' : '' }}>
                                                Phụ Tùng</option>
                                        </select>
                                    </td>

                                    <!-- CAR -->
                                    @if ($item->product_type === 'car')
                                        <td class="field-car">
                                            <div class="search-box">
                                                <input type="text" name="items[{{ $index }}][car_serial]"
                                                    class="car-serial" value="{{ $item->product_code }}">
                                                <div class="suggest-box"></div>
                                            </div>
                                        </td>

                                        <td>
                                            <input type="text" name="items[{{ $index }}][car_name]"
                                                class="car-name" value="{{ $item->car_name }}" readonly>
                                        </td>

                                        <td>
                                            <input type="text" name="items[{{ $index }}][brand]"
                                                class="car-brand" value="{{ $item->car_brand }}" readonly>
                                        </td>

                                        <td>
                                            <input type="text" name="items[{{ $index }}][engine_number]"
                                                class="car-engine" value="{{ $item->car_engine_number }}" readonly>
                                        </td>

                                        <td>
                                            <input type="text" name="items[{{ $index }}][chassis_number]"
                                                class="car-chassis" value="{{ $item->car_chassis_number }}" readonly>
                                        </td>

                                        <td>
                                            <input type="text" name="items[{{ $index }}][payload]"
                                                class="car-payload" value="{{ $item->car_payload }}" readonly>
                                        </td>

                                        <td>
                                            <input type="number" name="items[{{ $index }}][car_price]"
                                                class="car-price price-sale" value="{{ $item->sale_price }}">
                                        </td>

                                        <td>
                                            <input type="number" name="items[{{ $index }}][car_invoice_price]"
                                                class="car-invoice-price price-invoice"
                                                value="{{ $item->sale_price_invoice }}">
                                        </td>
                                    @endif


                                    {{-- ================= PARST ================= --}}
                                    @if ($item->product_type === 'parst')
                                        <td class="field-parst">
                                            <div class="search-box">
                                                <input type="text" name="items[{{ $index }}][parst_code]"
                                                    class="parst-code" value="{{ $item->product_code }}">
                                                <div class="suggest-box"></div>
                                            </div>
                                        </td>

                                        <td>
                                            <input type="text" name="items[{{ $index }}][parst_name]"
                                                class="parst-name" value="{{ $item->parst_name }}" readonly>
                                        </td>

                                        <td>
                                            <input type="text" name="items[{{ $index }}][category]"
                                                class="parst-category" value="{{ $item->parst_category }}" readonly>
                                        </td>

                                        <td>
                                            <input type="text" name="items[{{ $index }}][condition]"
                                                class="parst-condition" value="{{ $item->parst_condition }}" readonly>
                                        </td>

                                        <td>
                                            <input type="text" name="items[{{ $index }}][supplier]"
                                                class="parst-supplier" value="{{ $item->parst_supplier }}" readonly>
                                        </td>

                                        <td>
                                            <input type="number" name="items[{{ $index }}][quantity_stock]"
                                                class="parst-stock-quantity" value="{{ $item->parst->quantity }}"
                                                readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="items[{{ $index }}][unit]"
                                                class="parst-unit" value="{{ $item->parst_unit }}">
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][quantity_sold]"
                                                class="parst-sold-quantity" value="{{ $item->quantity }}">
                                        </td>

                                        <td>
                                            <input type="number" name="items[{{ $index }}][parst_price]"
                                                class="parst-price price-sale" value="{{ $item->sale_price }}">
                                        </td>

                                        <td>
                                            <input type="number" value="{{ $item->quantity * $item->sale_price }}"
                                                class="total-parst-price total-parst-price-sale" readonly>
                                        </td>
                                    @endif
                                    <td>
                                        <button type="button" class="btn btn-delete remove-item">X</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach

                </div>

                <button type="button" class="btn btn-outline add-btn" id="invoice-add-row-product">
                    + Thêm Sản Phẩm
                </button>

                <hr class="divider">

                <!-- DEBT -->
                <div class="debt-wrapper">
                    @php $debt = $invoice->debt ?? null; @endphp

                    <div class="debt-box">
                        <h3>Dư Nợ</h3>
                        <table class="invoice-table">
                            <tbody>
                                <tr>
                                    <th>Đã Thanh Toán</th>
                                    <th>Ngày Hẹn Trả</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="number" name="paid_amount" class="paid-amount"
                                            value="{{ $invoice->is_paid ?? 0 }}">
                                    </td>

                                    <td>
                                        <input type="date" name="debt_due_date"
                                            value="{{ $debt->debt_due_date ?? '' }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- ✅ TOTAL nằm ngay dưới -->
                    <div class="total-box">
                        <h3>TỔNG</h3>
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
                                        <input type="text" class="total-invoice" readonly name="sale_price_invoices"
                                            value="{{ $invoice->sale_price_invoices }}">
                                    </td>

                                    <td>
                                        <input type="text" class="total-sale" readonly name="price"
                                            value="{{ $invoice->price }}">
                                    </td>

                                    <td>
                                        <input type="text" class="total-debt" readonly name="debt_amount"
                                            value="{{ $invoice->debt->debt_amount ?? 0 }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr class="divider">
                {{-- preview --}}
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </div>

            </form>
        </div>
        <div class="invoice-print" id="invoice-preview"></div>
    </div>

    <script src="{{ asset('js/invoiceCreate.js') }}"></script>

    <script src="{{ asset('js/invoiceEdit.js') }}"></script>
@endsection
