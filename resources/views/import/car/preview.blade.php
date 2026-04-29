@extends('layouts.create')
@extends('layouts.sidebar')

@section('content')

    @php
        $cars = session('import_cars', []);

        $fields = [
            'code' => 'Seri',
            'name' => 'Tên Xe',
            'brand_id' => 'Hãng',
            'engine_number' => 'Số Máy',
            'chassis_number' => 'Số Khung',
            'payload' => 'Trọng Tải',
            'supplier_id' => 'Nhà Cung Cấp',
            'warehouse_id' => 'Bãi',
            'buy_price' => 'Giá Nhập',
            'buy_shipping_cost' => 'Phí VC',
            'buy_date' => 'Ngày Nhập',
            'stock_in_date' => 'Ngày Về',
            'sale_status' => 'Trạng Thái',
            'sale_date' => 'Ngày Bán',
            'sale_price' => 'Giá Bán',
            'sale_price_invoices' => 'Giá HĐ',
            'document_in_stock' => 'Giấy Tờ Đã Nhận',
        ];
    @endphp

    <div class="main">

        <div class="header">
            <h1>Xem trước Xe</h1>
        </div>

        <div class="card">

            @if (empty($cars))
                <p>❌ Không có dữ liệu</p>
            @else
                <form method="POST" id="carForm" action="{{ route('import.store.car') }}">
                    @csrf

                    <div class="grid-container">

                        @foreach ($cars as $i => $item)
                            @php
                                $isEmpty = empty(
                                    array_filter($item, function ($v) {
                                        // null → bỏ
                                        if ($v === null) {
                                            return false;
                                        }

                                        // string
                                        if (is_string($v)) {
                                            return trim($v) !== '';
                                        }

                                        // array (quan trọng cho document_in_stock)
                                        if (is_array($v)) {
                                            return !empty($v);
                                        }

                                        // số
                                        if (is_numeric($v)) {
                                            return true;
                                        }

                                        return false;
                                    })
                                );
                            @endphp

                            @if (!$isEmpty)
                                <div class="parst-box" data-index="{{ $i }}">

                                    <div class="box-header">
                                        <div class="box-title">🚗 Xe</div>
                                        <div class="box-index">#{{ $i + 1 }}</div>
                                    </div>

                                    {{-- HÀNG 1 --}}
                                    <div class="box-row">
                                        @foreach (['code', 'name', 'brand_id'] as $key)
                                            <div class="field field-main">
                                                <label>{{ $fields[$key] }}</label>

                                                @if ($key == 'brand_id')
                                                    <select class="input-field" data-field="{{ $key }}"
                                                        data-index="{{ $i }}"
                                                        name="items[{{ $i }}][{{ $key }}]">

                                                        <option value="">-- Chọn hãng --</option>

                                                        @foreach ($brands as $b)
                                                            <option value="{{ $b->id }}"
                                                                {{ ($item[$key] ?? '') == $b->id ? 'selected' : '' }}>
                                                                {{ $b->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <input type="text" class="input-field"
                                                        data-field="{{ $key }}" data-index="{{ $i }}"
                                                        name="items[{{ $i }}][{{ $key }}]"
                                                        value="{{ $item[$key] ?? '' }}">
                                                @endif

                                                <div class="error-text"></div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- HÀNG 2 --}}
                                    <div class="box-row">
                                        @foreach (['engine_number', 'chassis_number', 'payload'] as $key)
                                            <div class="field">
                                                <label>{{ $fields[$key] }}</label>
                                                @if ($key == 'payload')
                                                    <select class="input-field" data-field="payload"
                                                        data-index="{{ $i }}"
                                                        name="items[{{ $i }}][payload]">

                                                        <option value="">-- Chọn tải trọng --</option>

                                                        @php
                                                            $payloads = [
                                                                '1' => '1 tấn',
                                                                '1.5' => '1.5 tấn',
                                                                '2' => '2 tấn',
                                                                '2.5' => '2.5 tấn',
                                                                '3' => '3 tấn',
                                                                '3.5' => '3.5 tấn',
                                                                '5' => '5 tấn',
                                                                '6' => '6 tấn',
                                                                '7' => '7 tấn',
                                                                '10' => '10 tấn',
                                                            ];
                                                        @endphp

                                                        @foreach ($payloads as $val => $label)
                                                            <option value="{{ $val }}"
                                                                {{ ($item['payload'] ?? '') == $val ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach

                                                    </select>

                                                    <div class="error-text"></div>
                                                @else
                                                    <input type="text" class="input-field"
                                                        data-field="{{ $key }}" data-index="{{ $i }}"
                                                        name="items[{{ $i }}][{{ $key }}]"
                                                        value="{{ $item[$key] ?? '' }}">
                                                    <div class="error-text"></div>
                                                @endif

                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- HÀNG 3 --}}
                                    <div class="box-row">
                                        @foreach (['supplier_id', 'warehouse_id', 'sale_status'] as $key)
                                            <div class="field">
                                                <label>{{ $fields[$key] }}</label>

                                                @if ($key == 'supplier_id')
                                                    <select class="input-field" data-field="{{ $key }}"
                                                        data-index="{{ $i }}"
                                                        name="items[{{ $i }}][{{ $key }}]">

                                                        <option value="">-- NCC --</option>

                                                        @foreach ($suppliers as $s)
                                                            <option value="{{ $s->id }}"
                                                                {{ ($item[$key] ?? '') == $s->id ? 'selected' : '' }}>
                                                                {{ $s->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @elseif($key == 'warehouse_id')
                                                    <select class="input-field" data-field="{{ $key }}"
                                                        data-index="{{ $i }}"
                                                        name="items[{{ $i }}][{{ $key }}]">

                                                        <option value="">-- Bãi --</option>

                                                        @foreach ($warehouses as $w)
                                                            <option value="{{ $w->id }}"
                                                                {{ ($item[$key] ?? '') == $w->id ? 'selected' : '' }}>
                                                                {{ $w->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @elseif($key == 'sale_status')
                                                    <select class="input-field" data-field="{{ $key }}"
                                                        data-index="{{ $i }}"
                                                        name="items[{{ $i }}][{{ $key }}]">

                                                        <option value="">-- Trạng thái --</option>
                                                        <option value="0"
                                                            {{ ($item[$key] ?? '') == 0 ? 'selected' : '' }}>Trong kho
                                                        </option>
                                                        <option value="1"
                                                            {{ ($item[$key] ?? '') == 1 ? 'selected' : '' }}>Đã bán
                                                        </option>
                                                        <option value="2"
                                                            {{ ($item[$key] ?? '') == 2 ? 'selected' : '' }}>Chưa về
                                                        </option>
                                                    </select>
                                                @endif

                                                <div class="error-text"></div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- HÀNG 4 --}}
                                    <div class="box-row">
                                        @foreach (['buy_price', 'buy_shipping_cost', 'sale_price'] as $key)
                                            <div class="field">
                                                <label>{{ $fields[$key] }}</label>
                                                <input type="text" class="input-field" data-field="{{ $key }}"
                                                    data-index="{{ $i }}"
                                                    name="items[{{ $i }}][{{ $key }}]"
                                                    value="{{ $item[$key] ?? '' }}">
                                                <div class="error-text"></div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- HÀNG 5 --}}
                                    <div class="box-row">
                                        @foreach (['buy_date', 'stock_in_date', 'sale_date'] as $key)
                                            <div class="field">
                                                <label>{{ $fields[$key] }}</label>
                                                <input type="date" class="input-field" data-field="{{ $key }}"
                                                    data-index="{{ $i }}"
                                                    name="items[{{ $i }}][{{ $key }}]"
                                                    value="{{ $item[$key] ?? '' }}">
                                                <div class="error-text"></div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- HÀNG 6 --}}
                                    <div class="box-row">

                                        <div class="field">
                                            <label>{{ $fields['sale_price_invoices'] }}</label>
                                            <input type="text" class="input-field" data-field="sale_price_invoices"
                                                data-index="{{ $i }}"
                                                name="items[{{ $i }}][sale_price_invoices]"
                                                value="{{ $item['sale_price_invoices'] ?? '' }}">
                                            <div class="error-text"></div>
                                        </div>

                                        <!-- CHECKBOX DOCUMENT -->
                                        <div class="field">
                                            <label>Giấy Tờ Trong Kho</label>

                                            <div class="document-checkbox-group">

                                                <label class="checkbox-item">
                                                    <input type="checkbox"
                                                        name="items[{{ $i }}][document_in_stock][]"
                                                        value="hai_quan" @if (!empty($item['document_in_stock']) && in_array('hai_quan', $item['document_in_stock'])) checked @endif>
                                                    <span>Hải Quan</span>
                                                </label>

                                                <label class="checkbox-item">
                                                    <input type="checkbox"
                                                        name="items[{{ $i }}][document_in_stock][]"
                                                        value="dang_kiem" @if (!empty($item['document_in_stock']) && in_array('dang_kiem', $item['document_in_stock'])) checked @endif>
                                                    <span>Đăng Kiểm</span>
                                                </label>

                                                <label class="checkbox-item">
                                                    <input type="checkbox"
                                                        name="items[{{ $i }}][document_in_stock][]"
                                                        value="hop_dong" @if (!empty($item['document_in_stock']) && in_array('hop_dong', $item['document_in_stock'])) checked @endif>
                                                    <span>Hợp Đồng</span>
                                                </label>

                                                <label class="checkbox-item">
                                                    <input type="checkbox"
                                                        name="items[{{ $i }}][document_in_stock][]"
                                                        value="da_giao_du"
                                                        @if (!empty($item['document_in_stock']) && in_array('da_giao_du', $item['document_in_stock'])) checked @endif>
                                                    <span>Đầy Đủ</span>
                                                </label>

                                                <label class="checkbox-item">
                                                    <input type="checkbox"
                                                        name="items[{{ $i }}][document_in_stock][]"
                                                        value="chua_giao"
                                                        @if (!empty($item['document_in_stock']) && in_array('chua_giao', $item['document_in_stock'])) checked @endif>
                                                    <span>Chưa Giao</span>
                                                </label>
                                                <div class="error-text"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            💾 Lưu tất cả
                        </button>
                    </div>

                </form>
            @endif

        </div>
    </div>
    {{-- ================= STYLE ================= --}}
    <style>
      .main {
    width: 100%;
    max-width: 100%;
    padding: 12px;
    margin: 0 auto;
    box-sizing: border-box; /* 🔥 QUAN TRỌNG */
}

        .card {
            width: 100%;
            max-width: 100%;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        /* responsive */
        @media (max-width: 1200px) {
            .grid-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .box-row {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 768px) {
            .main {
                margin-left: 0 !important;
            }

            .sidebar {
                display: none;
            }

            .grid-container {
                grid-template-columns: 1fr;
                width: 100%;
    box-sizing: border-box;
            }

            .box-row {
                grid-template-columns: 1fr !important;
            }
        }

        /* BOX */
        /* ===== GRID giữ nguyên ===== */


        /* ===== BOX ===== */

        .parst-box {
            width: 100%;
            max-width: 100%;
            border-radius: 14px;
            padding: 16px;
            background: #ffffff;

            border: 1px solid #f1f5f9;

            /*  accent tinh tế (không gắt) */
            border-top: 3px solid #f59e0b;


            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.04);
            transition: all 0.25s ease;
        }

        /* hover mượt */
        .parst-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
            border-top-color: #ea580c;
            border-left-color: #ea580c;
        }


        /* ===== HEADER ===== */
        .box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .box-title {
            font-weight: 700;
            font-size: 15px;
            color: #111827;
        }

        .box-index {
            font-size: 12px;
            color: red;
            background: #f3f4f6;
            padding: 2px 8px;
            border-radius: 6px;
        }


        /* ===== ROW ===== */
        .box-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 12px;
        }


        /* ===== FIELD ===== */
        .field {
            display: flex;
            flex-direction: column;
        }

        /* label đẹp hơn */
        .field label {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 4px;
        }

        /* field chính */
        .field-main label {
            font-size: 13px;
            font-weight: 700;
            color: #111827;
        }

        /* input xịn hơn */
        .field input {
            width: 100%;
            padding: 8px 10px;
            font-size: 13px;

            border-radius: 8px;
            border: 1px solid #e5e7eb;

            background: #fafafa;

            transition: all 0.2s ease;
        }

        /* focus đẹp */
        .field input:focus {
            background: #fff;
            border-color: #f59e0b;
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.15);
            outline: none;
        }

        /* hover nhẹ */
        .field input:hover {
            border-color: #d1d5db;
        }


        /* field chính nổi bật */
        .field-main input {
            font-weight: 600;
            background: #fff;
            border-color: #d1d5db;
        }

        /* error */
        .error-text {
            color: red;
            font-size: 12px;
            margin-top: 4px;
        }

        .input-error {
            border-color: red !important;
            background: #fff1f2;
        }

        .field input,
        .field select {
            width: 100%;
            padding: 8px 10px;
            font-size: 13px;

            border-radius: 8px;
            border: 1px solid #e5e7eb;

            background: #fafafa;
            transition: all 0.2s ease;

            appearance: none;
            /* bỏ style mặc định */
        }

        /* focus */
        .field input:focus,
        .field select:focus {
            background: #fff;
            border-color: #f59e0b;
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.15);
            outline: none;
        }

        /* hover */
        .field input:hover,
        .field select:hover {
            border-color: #d1d5db;
        }

        .field select {
            background-image: url("data:image/svg+xml;utf8,<svg fill='%236b7280' height='20' viewBox='0 0 20 20' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M5 7l5 5 5-5H5z'/></svg>");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 30px;
        }

        .document-checkbox-group input[type="checkbox"] {
            appearance: auto !important;
            flex-wrap: wrap;
            gap: 6px;
        }

        .checkbox-item {
            align-items: center;
            gap: 4px;
            font-size: 12px;
        }
    </style>
    <script src="{{ asset('js/validate/importCar.js') }}"></script>
@endsection
