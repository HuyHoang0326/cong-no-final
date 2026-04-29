@extends('layouts.create')
@extends('layouts.sidebar')

@section('content')
    <div class="main">

        <div class="header">
            <h1>Chỉnh Sửa Phụ Tùng</h1>
        </div>

        <div class="card">
            <form id="parstForm" method="POST" action="{{ route('parsts.update', $parst->id) }}">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    <!-- CODE -->
                    <div class="form-group">
                        <label>ID</label>
                        <input type="text" id="code" name="code" value="{{ $parst->code }}" readonly>
                        <div class="error" id="error-code"></div>
                    </div>

                    <!-- NAME -->
                    <div class="form-group">
                        <label>Tên</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $parst->name) }}">
                        <div class="error" id="error-name"></div>
                    </div>

                    <!-- CATEGORY -->
                    <div class="form-group">
                        <label>Loại Hàng</label>
                        <select id="parst_category_id" name="parst_category_id">
                            <option value="">-- Chọn --</option>
                            @foreach ($categories as $cate)
                                <option value="{{ $cate->id }}"
                                    {{ old('parst_category_id', $parst->parst_category_id) == $cate->id ? 'selected' : '' }}>
                                    {{ $cate->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="error" id="error-parst_category_id"></div>
                    </div>

                    <!-- CONDITION -->
                    <div class="form-group">
                        <label>Cũ / Mới</label>
                        <select id="item_condition" name="item_condition">
                            <option value="">-- Chọn --</option>
                            <option value="0"
                                {{ old('item_condition', $parst->item_condition) == 0 ? 'selected' : '' }}>Mới</option>
                            <option value="1"
                                {{ old('item_condition', $parst->item_condition) == 1 ? 'selected' : '' }}>Cũ</option>
                        </select>
                        <div class="error" id="error-item_condition"></div>
                    </div>

                    <!-- SUPPLIER -->
                    <div class="form-group">
                        <label>Nhà Cung Cấp</label>
                        <select id="supplier_id" name="supplier_id">
                            <option value="">-- Chọn --</option>
                            @foreach ($suppliers as $sup)
                                <option value="{{ $sup->id }}"
                                    {{ old('supplier_id', $parst->supplier_id) == $sup->id ? 'selected' : '' }}>
                                    {{ $sup->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="error" id="error-supplier_id"></div>
                    </div>

                    <!-- QUANTITY -->
                    <div class="form-group">
                        <label>Số Lượng</label>
                        <input type="number" id="quantity" name="quantity"
                            value="{{ old('quantity', $parst->quantity) }}">
                        <div class="error" id="error-quantity"></div>
                    </div>

                    <!-- UNIT -->
                    <div class="form-group">
                        <label>Đơn Vị</label>
                        <input id="unit" name="unit" value="{{ old('unit', $parst->unit) }}">
                        <div class="error" id="error-unit"></div>
                    </div>

                    <!-- BUY PRICE -->
                    <div class="form-group">
                        <label>Giá Nhập</label>
                        <input type="number" id="buy_price" name="buy_price"
                            value="{{ old('buy_price', $parst->buy_price) }}">
                        <div class="error" id="error-buy_price"></div>
                    </div>

                    <!-- SHIPPING -->
                    <div class="form-group">
                        <label>Phí Vận Chuyển</label>
                        <input type="number" id="buy_shipping_cost" name="buy_shipping_cost"
                            value="{{ old('buy_shipping_cost', $parst->buy_shipping_cost) }}">
                        <div class="error" id="error-buy_shipping_cost"></div>
                    </div>

                    <!-- BUY DATE -->
                    <div class="form-group">
                        <label>Ngày Nhập</label>
                        <input type="date" id="buy_date" name="buy_date"
                            value="{{ old('buy_date', $parst->buy_date) }}">
                        <div class="error" id="error-buy_date"></div>
                    </div>

                    <!-- STOCK DATE -->
                    <div class="form-group">
                        <label>Ngày Về Kho</label>
                        <input type="date" id="stock_in_date" name="stock_in_date"
                            value="{{ old('stock_in_date', $parst->stock_in_date) }}">
                        <div class="error" id="error-stock_in_date"></div>
                    </div>

                    <!-- WAREHOUSE -->
                    <div class="form-group">
                        <label>Bãi</label>
                        <select id="warehouse_id" name="warehouse_id">
                            <option value="">-- Chọn --</option>
                            @foreach ($warehouses as $wh)
                                <option value="{{ $wh->id }}"
                                    {{ old('warehouse_id', $parst->warehouse_id) == $wh->id ? 'selected' : '' }}>
                                    {{ $wh->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="error" id="error-warehouse_id"></div>
                    </div>

                    <!-- STATUS -->
                    <div class="form-group">
                        <label>Trạng Thái</label>
                        <select id="sale_status" name="sale_status">
                            <option value="">-- Chọn --</option>
                            <option value="0" {{ old('sale_status', $parst->sale_status) == 0 ? 'selected' : '' }}>
                                Trong kho</option>
                            <option value="1" {{ old('sale_status', $parst->sale_status) == 1 ? 'selected' : '' }}>Đã
                                bán</option>
                            <option value="2" {{ old('sale_status', $parst->sale_status) == 2 ? 'selected' : '' }}>Đã
                                đặt</option>
                        </select>
                        <div class="error" id="error-sale_status"></div>
                    </div>

                    <!-- SALE INVOICE -->
                    <div class="form-group">
                        <label>Giá Hóa Đơn</label>
                        <input type="number" id="sale_price_invoices" name="sale_price_invoices"
                            value="{{ old('sale_price_invoices', $parst->sale_price_invoices) }}">
                        <div class="error" id="error-sale_price_invoices"></div>
                    </div>

                    <!-- SALE PRICE -->
                    <div class="form-group">
                        <label>Giá Bán</label>
                        <input type="number" id="sale_price" name="sale_price"
                            value="{{ old('sale_price', $parst->sale_price) }}">
                        <div class="error" id="error-sale_price"></div>
                    </div>

                </div>

                <div class="form-actions">
                    <a href="{{ route('parsts.index') }}" class="btn btn-back">Huỷ</a>
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </div>

            </form>
        </div>
<script src="{{ asset('js/validate/parst.js') }}"></script>
    </div>
@endsection
