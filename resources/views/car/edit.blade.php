@extends('layouts.create')
@extends('layouts.sidebar')

@section('content')
    <div class="main">

        <div class="header">
            <h1>Chỉnh Sửa Xe</h1>
            <div>
                <a href="{{ route('cars.index') }}" class="btn btn-back">← Back</a>
            </div>
        </div>

        <div class="card">
            <form id="carForm" method="POST" action="{{ route('cars.update', $car->id) }}">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    <!-- CODE -->
                    <div class="form-group">
                        <label>Seri</label>
                        <input type="text" id="code" name="code" value="{{ $car->code }}" readonly>
                    </div>

                    <!-- NAME -->
                    <div class="form-group">
                        <label>Tên</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $car->name) }}">
                        <div class="error" id="error-name"></div>
                    </div>

                    <!-- BRAND -->
                    <div class="form-group">
                        <label>Hãng</label>
                        <select id="brand_id" name="brand_id">
                            <option value="">-- Chọn hãng --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ old('brand_id', $car->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="error" id="error-brand_id"></div>
                    </div>

                    <!-- ENGINE -->
                    <div class="form-group">
                        <label>Số Máy</label>
                        <input type="text" id="engine_number" name="engine_number"
                            value="{{ old('engine_number', $car->engine_number) }}">
                        <div class="error" id="error-engine_number"></div>
                    </div>

                    <!-- CHASSIS -->
                    <div class="form-group">
                        <label>Số Khung</label>
                        <input type="text" id="chassis_number" name="chassis_number"
                            value="{{ old('chassis_number', $car->chassis_number) }}">
                        <div class="error" id="error-chassis_number"></div>
                    </div>

                    <!-- PAYLOAD -->
                    <div class="form-group">
                        <label>Trọng Tải</label>

                        @php
                            $payloads = [1, 1.5, 2, 2.5, 3, 3.5, 5, 6, 7, 10];
                        @endphp

                        <select id="payload" name="payload">
                            <option value="">-- Chọn --</option>

                            @foreach ($payloads as $p)
                                <option value="{{ $p }}"
                                    {{ old('payload', $car->payload) == $p ? 'selected' : '' }}>
                                    {{ $p }} tấn
                                </option>
                            @endforeach
                        </select>

                        <div class="error" id="error-payload"></div>
                    </div>

                    <!-- SUPPLIER -->
                    <div class="form-group">
                        <label>Nhà Cung Cấp</label>
                        <select id="supplier_id" name="supplier_id">
                            <option value="">-- Chọn --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id', $car->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="error" id="error-supplier_id"></div>
                    </div>

                    <!-- BUY PRICE -->
                    <div class="form-group">
                        <label>Giá Nhập</label>
                        <input type="number" id="buy_price" name="buy_price"
                            value="{{ old('buy_price', $car->buy_price) }}">
                        <div class="error" id="error-buy_price"></div>
                    </div>

                    <!-- SHIPPING (nullable) -->
                    <div class="form-group">
                        <label>Phí Vận Chuyển</label>
                        <input type="number" id="buy_shipping_cost" name="buy_shipping_cost"
                            value="{{ old('buy_shipping_cost', $car->buy_shipping_cost) }}">
                        <div class="error" id="error-buy_shipping_cost"></div>
                    </div>

                    <!-- BUY DATE -->
                    <div class="form-group">
                        <label>Ngày Nhập</label>
                        <input type="date" id="buy_date" name="buy_date" value="{{ old('buy_date', $car->buy_date) }}">
                        <div class="error" id="error-buy_date"></div>
                    </div>

                    <!-- STOCK DATE -->
                    <div class="form-group">
                        <label>Ngày Về Bãi</label>
                        <input type="date" id="stock_in_date" name="stock_in_date"
                            value="{{ old('stock_in_date', $car->stock_in_date) }}">
                        <div class="error" id="error-stock_in_date"></div>
                    </div>

                    <!-- WAREHOUSE -->
                    <div class="form-group">
                        <label>Bãi</label>
                        <select id="warehouse_id" name="warehouse_id">
                            <option value="">-- Chọn --</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}"
                                    {{ old('warehouse_id', $car->warehouse_id) == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="error" id="error-warehouse_id"></div>
                    </div>

                    <!-- DOCUMENT -->
                    <div class="form-group">
                        <label>Giấy Tờ Trong Kho</label>
                        @php $docs = old('document_in_stock', $car->document_in_stock ?? []); @endphp

                        <div class="document-checkbox-group">
                            @foreach ([
            'hai_quan' => 'Hải quan',
            'dang_kiem' => 'Đăng kiểm',
            'hop_dong' => 'Hợp đồng',
            'da_giao_du' => 'Đã Giao Đủ',
            'chua_giao' => 'Chưa Giao',
        ] as $key => $label)
                                <label>
                                    <input type="checkbox" name="document_in_stock[]" value="{{ $key }}"
                                        {{ in_array($key, $docs) ? 'checked' : '' }}>
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- STATUS -->
                    <div class="form-group">
                        <label>Trạng Thái</label>
                        <select id="sale_status" name="sale_status">
                            <option value="">-- Chọn --</option>
                            <option value="0" {{ old('sale_status', $car->sale_status) == 0 ? 'selected' : '' }}>
                                Trong kho</option>
                            <option value="1" {{ old('sale_status', $car->sale_status) == 1 ? 'selected' : '' }}>Đã
                                bán</option>
                            <option value="2" {{ old('sale_status', $car->sale_status) == 2 ? 'selected' : '' }}>Đã
                                đặt</option>
                        </select>
                        <div class="error" id="error-sale_status"></div>
                    </div>

                    <!-- SALE DATE -->
                    <div class="form-group">
                        <label>Ngày Bán</label>
                        <input type="date" id="sale_date" name="sale_date"
                            value="{{ old('sale_date', $car->sale_date) }}">
                        <div class="error" id="error-sale_date"></div>
                    </div>

                    <!-- SALE PRICE -->
                    <div class="form-group">
                        <label>Giá Bán</label>
                        <input type="number" id="sale_price" name="sale_price"
                            value="{{ old('sale_price', $car->sale_price) }}">
                        <div class="error" id="error-sale_price"></div>
                    </div>

                    <!-- SALE INVOICE -->
                    <div class="form-group">
                        <label>Giá Bán Hoá Đơn</label>
                        <input type="number" id="sale_price_invoices" name="sale_price_invoices"
                            value="{{ old('sale_price_invoices', $car->sale_price_invoices) }}">
                        <div class="error" id="error-sale_price_invoices"></div>
                    </div>

                </div>

                <div class="form-actions">
                    <a href="{{ route('cars.index') }}" class="btn btn-back">Huỷ</a>
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </div>
            </form>
        </div>
        <script src="{{ asset('js/carCreate.js') }}"></script>
        <script src="{{ asset('js/validate/car.js') }}"></script>
    </div>
@endsection
