@extends('layouts.create')
@extends('layouts.sidebar')
@section('content')
    <div class="main">

        <div class="header">
            <h1>Nhập Xe</h1>
        </div>
        <div class="stats">
            <a href="{{ route('carBrands.create') }}" class="cardAdd">
                <div>
                    <h3>Thêm Hãng Xe</h3>
                </div>
            </a>
            <a href="{{ route('warehouses.create') }}" class="cardAdd">
                <div>
                    <h3>Thêm Bãi</h3>
                </div>
            </a>
            <a href="{{ route('suppliers.create') }}" class="cardAdd">
                <div>
                    <h3>Thêm Nhà Cung Cấp</h3>
                </div>
            </a>
        </div>
        <div class="card">
            <form id="carForm" method="POST" action="{{ route('cars.store') }}">
                @csrf

                <div class="form-grid">

                    <!-- CODE -->
                    <div class="form-group">
                        <label>Seri</label>
                        <input type="text" id="code" name="code">
                        <div class="error" id="error-code"></div>
                    </div>

                    <!-- NAME -->
                    <div class="form-group">
                        <label>Tên</label>
                        <input type="text" id="name" name="name">
                        <div class="error" id="error-name"></div>
                    </div>

                    <!-- BRAND -->
                    <div class="form-group">
                        <label>Hãng</label>
                        <select id="brand_id" name="brand_id">
                            <option value="">-- Chọn hãng --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <div class="error" id="error-brand_id"></div>
                    </div>

                    <!-- ENGINE -->
                    <div class="form-group">
                        <label>Số Máy</label>
                        <input type="text" id="engine_number" name="engine_number">
                        <div class="error" id="error-engine_number"></div>
                    </div>

                    <!-- CHASSIS -->
                    <div class="form-group">
                        <label>Số Khung</label>
                        <input type="text" id="chassis_number" name="chassis_number">
                        <div class="error" id="error-chassis_number"></div>
                    </div>

                    <!-- PAYLOAD -->
                    <div class="form-group">
                        <label>Trọng Tải</label>
                        <input type="text" id="payload" name="payload">
                        <div class="error" id="error-payload"></div>
                    </div>

                    <!-- SUPPLIER -->
                    <div class="form-group">
                        <label>Nhà Cung Cấp</label>
                        <select id="supplier_id" name="supplier_id">
                            <option value="">-- Chọn nhà cung cấp --</option>
                            @foreach ($suppliers as $sp)
                                <option value="{{ $sp->id }}">{{ $sp->name }}</option>
                            @endforeach
                        </select>
                        <div class="error" id="error-supplier_id"></div>
                    </div>

                    <!-- BUY PRICE -->
                    <div class="form-group">
                        <label>Giá Nhập</label>
                        <input type="number" id="buy_price" name="buy_price">
                        <div class="error" id="error-buy_price"></div>
                    </div>

                    <!-- SHIPPING (nullable) -->
                    <div class="form-group">
                        <label>Phí Vận Chuyển</label>
                        <input type="number" id="buy_shipping_cost" name="buy_shipping_cost">
                        <div class="error" id="error-buy_shipping_cost"></div>
                    </div>

                    <!-- BUY DATE -->
                    <div class="form-group">
                        <label>Ngày Nhập</label>
                        <input type="date" id="buy_date" name="buy_date">
                        <div class="error" id="error-buy_date"></div>
                    </div>

                    <!-- STOCK DATE (nullable) -->
                    <div class="form-group">
                        <label>Ngày Về Bãi</label>
                        <input type="date" id="stock_in_date" name="stock_in_date">
                        <div class="error" id="error-stock_in_date"></div>
                    </div>

                    <!-- WAREHOUSE -->
                    <div class="form-group">
                        <label>Bãi</label>
                        <select id="warehouse_id" name="warehouse_id">
                            <option value="">-- Chọn bãi --</option>
                            @foreach ($warehouses as $wh)
                                <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                            @endforeach
                        </select>
                        <div class="error" id="error-warehouse_id"></div>
                    </div>

                    <!-- DOCUMENT (nullable) -->
                    <div class="form-group">
                        <label>Giấy Tờ Trong Kho</label>
                        <div class="document-checkbox-group">

                            <label><input type="checkbox" name="document_in_stock[]" value="hai_quan"> Hải Quan</label>
                            <label><input type="checkbox" name="document_in_stock[]" value="dang_kiem"> Đăng Kiểm</label>
                            <label><input type="checkbox" name="document_in_stock[]" value="hop_dong"> Hợp Đồng</label>
                            <label><input type="checkbox" name="document_in_stock[]" value="da_giao_du"> Đầy Đủ</label>
                            <label><input type="checkbox" name="document_in_stock[]" value="chua_giao"> Chưa Giao</label>

                        </div>
                    </div>

                    <!-- STATUS -->
                    <div class="form-group">
                        <label>Trạng Thái</label>
                        <select id="sale_status" name="sale_status">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="0">Trong kho</option>
                            <option value="1">Đã bán</option>
                            <option value="2">Đã đặt</option>
                        </select>
                        <div class="error" id="error-sale_status"></div>
                    </div>

                    <!-- SALE DATE (nullable) -->
                    <div class="form-group">
                        <label>Ngày Bán</label>
                        <input type="date" id="sale_date" name="sale_date">
                        <div class="error" id="error-sale_date"></div>
                    </div>

                    <!-- SALE PRICE (nullable) -->
                    <div class="form-group">
                        <label>Giá Bán</label>
                        <input type="number" id="sale_price" name="sale_price">
                        <div class="error" id="error-sale_price"></div>
                    </div>

                    <!-- SALE INVOICE PRICE (nullable) -->
                    <div class="form-group">
                        <label>Giá Bán Hoá Đơn</label>
                        <input type="number" id="sale_price_invoices" name="sale_price_invoices">
                        <div class="error" id="error-sale_price_invoices"></div>
                    </div>

                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Lưu Xe</button>
                </div>
            </form>
        </div>

    </div>
    <script src="{{ asset('js/carCreate.js') }}"></script>
    <script src="{{ asset('js/validate/car.js') }}"></script>
@endsection
