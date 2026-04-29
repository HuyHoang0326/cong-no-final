@extends('layouts.create')
@extends('layouts.sidebar')

@section('content')

    <div class="main">

        <div class="header">
            <h1>Nhập Hàng</h1>
        </div>
        <div class="stats">
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
             <form action="{{ route('import.upload.parst') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="file" name="file" id="excelInputCar" hidden onchange="this.form.submit()">
            </form>

            <button type="button" onclick="document.getElementById('excelInputCar').click()" id="excelCar">
                📥 Nhập Excel Phụ Tùng
            </button>
            <form id="parstForm" method="POST" action="{{ route('parsts.store') }}">
                @csrf

                <div class="form-grid">

                    <div class="form-group">
                        <label>Mã Linh Kiện</label>
                        <input type="text" id="code" name="code">
                        <div class="error" id="error-code"></div>
                    </div>

                    <div class="form-group">
                        <label>Tên</label>
                        <input type="text" id="name" name="name">
                        <div class="error" id="error-name"></div>
                    </div>

                    <div class="form-group">
                        <label>Loại Hàng</label>
                        <select id="parst_category_id" name="parst_category_id">
                            <option value="">-- Chọn loại hàng --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <div class="error" id="error-parst_category_id"></div>
                    </div>

                    <div class="form-group">
                        <label>Cũ / Mới</label>
                        <select id="item_condition" name="item_condition">
                            <option value="">-- Chọn --</option>
                            <option value="0">Mới</option>
                            <option value="1">Cũ</option>
                        </select>
                        <div class="error" id="error-item_condition"></div>
                    </div>

                    <div class="form-group">
                        <label>Nhà Cung Cấp</label>
                        <select id="supplier_id" name="supplier_id">
                            <option value="">-- Chọn nhà cung cấp --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        <div class="error" id="error-supplier_id"></div>
                    </div>

                    <div class="form-group">
                        <label>Số Lượng</label>
                        <input type="number" id="quantity" name="quantity">
                        <div class="error" id="error-quantity"></div>
                    </div>

                    <div class="form-group">
                        <label>Đơn Vị Tính</label>
                        <input id="unit" name="unit">
                        <div class="error" id="error-unit"></div>
                    </div>

                    <div class="form-group">
                        <label>Giá Nhập</label>
                        <input type="number" id="buy_price" name="buy_price">
                        <div class="error" id="error-buy_price"></div>
                    </div>

                    <div class="form-group">
                        <label>Phí Vận Chuyển</label>
                        <input type="number" id="buy_shipping_cost" name="buy_shipping_cost">
                        <div class="error" id="error-buy_shipping_cost"></div>
                    </div>

                    <div class="form-group">
                        <label>Ngày Nhập</label>
                        <input type="date" id="buy_date" name="buy_date">
                        <div class="error" id="error-buy_date"></div>
                    </div>

                    <div class="form-group">
                        <label>Ngày Về Bãi</label>
                        <input type="date" id="stock_in_date" name="stock_in_date">
                        <div class="error" id="error-stock_in_date"></div>
                    </div>

                    <div class="form-group">
                        <label>Bãi</label>
                        <select id="warehouse_id" name="warehouse_id">
                            <option value="">-- Chọn bãi --</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                        <div class="error" id="error-warehouse_id"></div>
                    </div>

                    <div class="form-group">
                        <label>Trạng Thái</label>
                        <select id="sale_status" name="sale_status">
                            <option value="">-- Chọn --</option>
                            <option value="0">Trong kho</option>
                            <option value="1">Đã bán</option>
                            <option value="2">Chưa về bãi</option>
                        </select>
                        <div class="error" id="error-sale_status"></div>
                    </div>
                    
                    <div class="form-group">
                        <label>Giá Bán</label>
                        <input type="number" id="sale_price" name="sale_price">
                        <div class="error" id="error-sale_price"></div>
                    </div>

                </div>

                <div class="form-actions">
                    <a href="" class="btn btn-back">Cancel</a>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>

    </div>
    <script src="{{ asset('js/validate/parst.js') }}"></script>
@endsection
