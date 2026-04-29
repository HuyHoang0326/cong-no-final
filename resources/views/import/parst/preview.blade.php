@extends('layouts.create')
@extends('layouts.sidebar')

@section('content')

    @php
        $parsts = session('import_parsts', []);

        $fields = [
            'code' => 'Mã Linh Kiện',
            'name' => 'Tên',
            'parst_category_id' => 'Loại Hàng',
            'item_condition' => 'Cũ / Mới',
            'supplier_id' => 'Nhà Cung Cấp',
            'quantity' => 'Số Lượng',
            'unit' => 'Đơn Vị',
            'buy_price' => 'Giá Nhập',
            'buy_shipping_cost' => 'Phí Vận Chuyển',
            'buy_date' => 'Ngày Nhập',
            'stock_in_date' => 'Ngày Về Bãi',
            'warehouse_id' => 'Bãi',
            'sale_status' => 'Trạng Thái',
            'sale_price' => 'Giá Bán',
        ];
    @endphp

    <div class="main">

        <div class="header">
            <h1>Xem trước Linh Kiện</h1>
        </div>

        <div class="card">

            @if (empty($parsts))
                <p>❌ Không có dữ liệu</p>
            @else
                <form method="POST" id="parstForm" action="{{ route('import.store.parst') }}">
                    @csrf

                    <div class="grid-container">

                        @foreach ($parsts as $i => $item)
                            @php
                                //  bỏ dòng rỗng
                                $isEmpty = true;
                                foreach ($item as $v) {
                                    if (!is_null($v) && trim($v) !== '') {
                                        $isEmpty = false;
                                        break;
                                    }
                                }
                            @endphp

                            @if (!$isEmpty)
                                <div class="parst-box">

                                    <div class="box-header">
                                        <div class="box-title">📦 Linh kiện</div>
                                        <div class="box-index">#{{ $i + 1 }}</div>
                                    </div>

                                    {{-- Hàng 1 (quan trọng) --}}
                                    <div class="box-row">
                                        @foreach (['code', 'name', 'quantity'] as $key)
                                            <div class="field field-main">
                                                <label>{{ $fields[$key] }}</label>
                                                <input type="text" class="input-field" data-field="{{ $key }}"
                                                    data-index="{{ $i }}"
                                                    name="items[{{ $i }}][{{ $key }}]"
                                                    value="{{ $item[$key] ?? '' }}">

                                                <div class="error-text"></div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Hàng 2 --}}
                                    <div class="box-row">
                                        @foreach (['buy_price', 'buy_shipping_cost', 'unit'] as $key)
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

                                    {{-- Hàng 3 --}}
                                    <div class="box-row">
                                        @foreach (['parst_category_id', 'supplier_id', 'warehouse_id'] as $key)
                                            <div class="field">
                                                <label>{{ $fields[$key] }}</label>

                                                <select class="input-field" data-field="{{ $key }}"
                                                    data-index="{{ $i }}"
                                                    name="items[{{ $i }}][{{ $key }}]">
                                                    <option value="">-- Chọn --</option>

                                                    @if ($key === 'supplier_id')
                                                        @foreach ($suppliers as $row)
                                                            <option value="{{ $row->id }}"
                                                                {{ ($item[$key] ?? '') == $row->id ? 'selected' : '' }}>
                                                                {{ $row->name }}
                                                            </option>
                                                        @endforeach
                                                    @elseif ($key === 'parst_category_id')
                                                        @foreach ($categories as $row)
                                                            <option value="{{ $row->id }}"
                                                                {{ ($item[$key] ?? '') == $row->id ? 'selected' : '' }}>
                                                                {{ $row->name }}
                                                            </option>
                                                        @endforeach
                                                    @elseif ($key === 'warehouse_id')
                                                        @foreach ($warehouses as $row)
                                                            <option value="{{ $row->id }}"
                                                                {{ ($item[$key] ?? '') == $row->id ? 'selected' : '' }}>
                                                                {{ $row->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif

                                                </select>

                                                <div class="error-text"></div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Hàng 4 --}}
                                    <div class="box-row">
                                        @foreach (['buy_date', 'stock_in_date'] as $key)
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

                                    {{-- Hàng 5 --}}
                                    <div class="box-row">
                                        @foreach (['sale_status', 'sale_price', 'item_condition'] as $key)
                                            <div class="field">
                                                <label>{{ $fields[$key] }}</label>

                                                @if ($key === 'sale_status')
                                                    <select class="input-field" data-field="{{ $key }}"
                                                        data-index="{{ $i }}"
                                                        name="items[{{ $i }}][{{ $key }}]">
                                                        <option value="">-- Chọn --</option>
                                                        <option value="0"
                                                            {{ ($item[$key] ?? '') == 0 ? 'selected' : '' }}>
                                                            Trong kho
                                                        </option>
                                                        <option value="1"
                                                            {{ ($item[$key] ?? '') == 1 ? 'selected' : '' }}>
                                                            Đã bán
                                                        </option>
                                                        <option value="2"
                                                            {{ ($item[$key] ?? '') == 2 ? 'selected' : '' }}>
                                                            Chưa về bãi
                                                        </option>
                                                    </select>
                                                @elseif ($key === 'item_condition')
                                                    <select class="input-field" data-field="{{ $key }}"
                                                        data-index="{{ $i }}"
                                                        name="items[{{ $i }}][{{ $key }}]">
                                                        <option value="">-- Chọn --</option>
                                                        <option value="0"
                                                            {{ ($item[$key] ?? '') == 0 ? 'selected' : '' }}>
                                                            Mới
                                                        </option>
                                                        <option value="1"
                                                            {{ ($item[$key] ?? '') == 1 ? 'selected' : '' }}>
                                                            Cũ
                                                        </option>
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
        }

        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: 1fr;
            }
        }

        /* BOX */
        /* ===== GRID giữ nguyên ===== */


        /* ===== BOX ===== */
        .parst-box {
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
    </style>

    <script src="{{ asset('js/validate/importParst.js') }}"></script>
@endsection
