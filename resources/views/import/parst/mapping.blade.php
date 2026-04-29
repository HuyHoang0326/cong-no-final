@extends('layouts.create')
@extends('layouts.sidebar')

@section('content')
    <div class="main">

        <div class="header">
            <h1>Mapping Excel → Linh Kiện</h1>
        </div>

        <div class="card">
            <form method="POST" action="{{ route('import.run.parst') }}">
                @csrf

                <div class="form-grid">

                    @php
                        $fields = [
                            //  Hàng 1
                            'code' => 'Mã Linh Kiện',
                            'name' => 'Tên',
                            'quantity' => 'Số Lượng',

                            //  Hàng 2
                            'buy_price' => 'Giá Nhập',
                            'buy_shipping_cost' => 'Phí Vận Chuyển',
                            'unit' => 'Đơn Vị',

                            //  Hàng 3
                            'parst_category_id' => 'Loại Hàng',
                            'supplier_id' => 'Nhà Cung Cấp',
                            'warehouse_id' => 'Bãi',

                            //  Hàng 4
                            'buy_date' => 'Ngày Nhập',
                            'stock_in_date' => 'Ngày Về Bãi',

                            //  Hàng 5
                            'item_condition' => 'Cũ / Mới',
                            'sale_price' => 'Giá Bán',
                            'sale_status' => 'Trạng Thái',
                        ];
                        $dateFields = ['buy_date', 'stock_in_date'];
                    @endphp

                    @foreach ($fields as $key => $label)
                        <div class="form-group mapping-field">

                            <label>{{ $label }}</label>

                            <!-- MODE -->
                            <div class="mapping-mode">
                                <label>
                                    <input type="radio" name="mode[{{ $key }}]" value="excel" checked>
                                    <span>Excel</span>
                                </label>

                                <label>
                                    <input type="radio" name="mode[{{ $key }}]" value="manual">
                                    <span>Nhập tay</span>
                                </label>
                            </div>

                            <!-- EXCEL SELECT -->
                            <select name="mapping[{{ $key }}]" class="excel-input">
                                <option value="">-- Chọn cột Excel --</option>
                                @foreach ($headers as $i => $header)
                                    <option value="{{ $i }}">{{ $header }}</option>
                                @endforeach
                            </select>

                            <!-- MANUAL INPUT -->

                            @if ($key == 'sale_status')
                                <select name="manual[{{ $key }}]" class="manual-input" style="display:none">
                                    <option value="">-- Chọn --</option>
                                    <option value="0">Trong kho</option>
                                    <option value="1">Đã bán</option>
                                    <option value="2">Chưa về bãi</option>
                                </select>
                            @elseif ($key == 'supplier_id')
                                <select name="manual[{{ $key }}]" class="manual-input" style="display:none">
                                    <option value="">-- Chọn nhà cung cấp --</option>
                                    @foreach ($suppliers as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            @elseif ($key == 'parst_category_id')
                                <select name="manual[{{ $key }}]" class="manual-input" style="display:none">
                                    <option value="">-- Chọn loại hàng --</option>
                                    @foreach ($categories as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            @elseif ($key == 'warehouse_id')
                                <select name="manual[{{ $key }}]" class="manual-input" style="display:none">
                                    <option value="">-- Chọn bãi --</option>
                                    @foreach ($warehouses as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            @elseif ($key == 'item_condition')
                                <select name="manual[{{ $key }}]" class="manual-input" style="display:none">
                                    <option value="">-- Chọn --</option>
                                    <option value="0">mới</option>
                                    <option value="1">cũ</option>
                                </select>
                            @else
                                <input type="{{ in_array($key, $dateFields) ? 'date' : 'text' }}"
                                    name="manual[{{ $key }}]" class="manual-input"
                                    placeholder="Nhập giá trị chung" style="display:none">
                            @endif

                        </div>
                    @endforeach

                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        🚀 Import Linh Kiện
                    </button>
                </div>

            </form>
        </div>

    </div>

    {{-- JS toggle --}}
    <script>
        document.querySelectorAll('.mapping-field').forEach(field => {

            const radios = field.querySelectorAll('input[type=radio]');
            const excel = field.querySelector('.excel-input');
            const manual = field.querySelector('.manual-input');

            radios.forEach(radio => {
                radio.addEventListener('change', () => {

                    if (radio.value === 'excel') {
                        excel.style.display = 'block';
                        manual.style.display = 'none';
                    }

                    if (radio.value === 'manual') {
                        excel.style.display = 'none';
                        manual.style.display = 'block';
                    }

                    if (radio.value === 'skip') {
                        excel.style.display = 'none';
                        manual.style.display = 'none';
                    }

                });
            });

        });

        document.querySelectorAll('.mapping-field').forEach(field => {

            const radios = field.querySelectorAll('input[type=radio]');
            const excel = field.querySelector('.excel-input');
            const manual = field.querySelector('.manual-input');

            radios.forEach(radio => {
                radio.addEventListener('change', () => {

                    field.classList.remove('mode-excel', 'mode-manual');

                    if (radio.checked) {

                        if (radio.value === 'excel') {
                            excel.style.display = 'block';
                            manual.style.display = 'none';
                            field.classList.add('mode-excel');
                        }

                        if (radio.value === 'manual') {
                            excel.style.display = 'none';
                            manual.style.display = 'block';
                            field.classList.add('mode-manual');
                        }
                    }

                });
            });

        });
    </script>

    {{-- CSS nhẹ cho dễ nhìn --}}
    <style>
        /* FIELD BOX */
        .mapping-field {
            background: #ffffff;
            border-radius: 12px;
            padding: 14px;

            border: 1px solid #e5e7eb;

            /* accent nhẹ */
            border-left: 4px solid #cbd5f5;

            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            transition: all 0.2s ease;
        }

        .mapping-field:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06);
        }

        /* LABEL */
        .mapping-field>label {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 8px;
            display: block;
        }

        /* MODE */
        .mapping-mode {
            display: flex;
            gap: 8px;
            margin-bottom: 10px;
        }

        /* RADIO STYLE */

        /* hover */

        /* active (JS thêm class) */
        .mapping-mode label.active {
            background: #2563eb;
            color: #fff;
        }

        /* INPUT + SELECT */
        .mapping-field select,
        .mapping-field input {
            width: 100%;

            padding: 8px 10px;
            font-size: 13px;

            border-radius: 8px;
            border: 1px solid #e5e7eb;

            background: #f9fafb;

            transition: all 0.2s;
        }

        /* focus */
        .mapping-field select:focus,
        .mapping-field input:focus {
            border-color: #2563eb;
            background: #fff;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        /* ===== MODE COLORS ===== */

        /* excel */
        .mapping-field.mode-excel {
            border-left-color: #2563eb;
        }

        /* manual */
        .mapping-field.mode-manual {
            border-left-color: #f59e0b;
        }

        /* skip */
        .mapping-field.mode-skip {
            border-left-color: #e5e7eb;
            opacity: 0.7;
        }

        /* hide input smooth */
        .manual-input,
        .excel-input {
            transition: all 0.2s ease;
        }

        .mapping-mode input[type="radio"] {
            display: none;
        }

        /* BUTTON */
        .mapping-mode label {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 6px 12px;
            border-radius: 999px;

            font-size: 12px;
            font-weight: 500;

            background: #f1f5f9;
            color: #475569;

            cursor: pointer;
            transition: all 0.2s;
        }

        /* HOVER */
        .mapping-mode label:hover {
            background: #e2e8f0;
        }

        /* ACTIVE */
        .mapping-mode input[type="radio"]:checked+span {
            background: #2563eb;
            color: #fff;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .mapping-mode input[type="radio"] {
            display: none;
        }

        /* Button */
        .mapping-mode label span {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 6px 14px;
            border-radius: 999px;

            font-size: 12px;
            font-weight: 500;

            background: #f1f5f9;
            color: #475569;

            cursor: pointer;
            transition: all 0.2s ease;
        }

        /* hover */
        .mapping-mode label span:hover {
            background: #e2e8f0;
        }

        /* ACTIVE */
        .mapping-mode input[type="radio"]:checked+span {
            background: #2563eb;
            color: #fff;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
        }

        /* animation nhẹ */
        .mapping-mode label span:active {
            transform: scale(0.95);
        }
    </style>
@endsection
