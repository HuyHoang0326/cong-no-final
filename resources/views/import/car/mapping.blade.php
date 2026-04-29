@extends('layouts.create')
@extends('layouts.sidebar')

@section('content')
    <div class="main">

        <div class="header">
            <h1>Mapping Excel → Xe</h1>
        </div>

        <div class="card">
            <form method="POST" action="{{ route('import.run.car') }}">
                @csrf

                <div class="form-grid">

                    @php
                        $fields = [
                            'code' => 'Seri',
                            'name' => 'Tên Xe',
                            'brand_id' => 'Hãng',
                            'engine_number' => 'Số Máy',
                            'chassis_number' => 'Số Khung',
                            'payload' => 'Trọng Tải',
                            'supplier_id' => 'Nhà Cung Cấp',
                            'buy_price' => 'Giá Nhập',
                            'buy_shipping_cost' => 'Phí Vận Chuyển',
                            'buy_date' => 'Ngày Nhập',
                            'stock_in_date' => 'Ngày Về Bãi',
                            'warehouse_id' => 'Bãi',
                            'sale_status' => 'Trạng Thái',
                            'sale_date' => 'Ngày Bán',
                            'sale_price' => 'Giá Bán',
                            'sale_price_invoices' => 'Giá Bán Hóa Đơn',
                            'document_in_stock' => 'Giấy Tờ Đã Nhận'
                        ];

                        $dateFields = ['buy_date', 'stock_in_date', 'sale_date'];
                    @endphp

                    @foreach ($fields as $key => $label)
                        <div class="form-group mapping-field mode-excel">

                            <label>{{ $label }}</label>

                            {{-- MODE --}}
                            <div class="mapping-mode">
                                <label>
                                    <input type="radio" name="mode[{{ $key }}]" value="excel" checked>
                                    <span>📊 Excel</span>
                                </label>

                                <label>
                                    <input type="radio" name="mode[{{ $key }}]" value="manual">
                                    <span>✍️ Nhập tay</span>
                                </label>
                            </div>

                            {{-- EXCEL --}}
                            <select name="mapping[{{ $key }}]" class="excel-input">
                                <option value="">-- Chọn cột Excel --</option>
                                @foreach ($headers as $i => $header)
                                    <option value="{{ $i }}">{{ $header }}</option>
                                @endforeach
                            </select>

                            {{-- MANUAL --}}
                            @if ($key == 'brand_id')
                                <select name="manual[{{ $key }}]" class="manual-input" style="display:none">
                                    <option value="">-- Chọn hãng --</option>
                                    @foreach ($brands as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            @elseif ($key == 'supplier_id')
                                <select name="manual[{{ $key }}]" class="manual-input" style="display:none">
                                    <option value="">-- Chọn NCC --</option>
                                    @foreach ($suppliers as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            @elseif ($key == 'payload')
                                <select name="manual[{{ $key }}]" class="manual-input" style="display:none">
                                    <option value="">-- Chọn trọng tải --</option>

                                    <option value="1">1 tấn</option>
                                    <option value="1.5">1.5 tấn</option>
                                    <option value="2">2 tấn</option>
                                    <option value="2.5">2.5 tấn</option>
                                    <option value="3">3 tấn</option>
                                    <option value="3.5">3.5 tấn</option>
                                    <option value="5">5 tấn</option>
                                    <option value="6">6 tấn</option>
                                    <option value="7">7 tấn</option>
                                    <option value="10">10 tấn</option>
                                </select>
                            @elseif ($key == 'warehouse_id')
                                <select name="manual[{{ $key }}]" class="manual-input" style="display:none">
                                    <option value="">-- Chọn bãi --</option>
                                    @foreach ($warehouses as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            @elseif ($key == 'sale_status')
                                <select name="manual[{{ $key }}]" class="manual-input" style="display:none">
                                    <option value="">-- Chọn --</option>
                                    <option value="0">Trong kho</option>
                                    <option value="1">Đã bán</option>
                                    <option value="2">Chưa về bãi</option>
                                </select>
                            @else
                                <input type="{{ in_array($key, $dateFields) ? 'date' : 'text' }}"
                                    name="manual[{{ $key }}]" class="manual-input" placeholder="Nhập giá trị"
                                    style="display:none">
                            @endif

                        </div>
                    @endforeach

                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        🚀 Import Xe
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- JS --}}
    <script>
        document.querySelectorAll('.mapping-field').forEach(field => {

            const radios = field.querySelectorAll('input[type=radio]');
            const excel = field.querySelector('.excel-input');
            const manual = field.querySelector('.manual-input');

            radios.forEach(radio => {
                radio.addEventListener('change', () => {

                    field.classList.remove('mode-excel', 'mode-manual');

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
                });
            });
        });
    </script>

    {{-- CSS --}}
    <style>
        /* BOX */
        .mapping-field {
            background: #fff;
            border-radius: 12px;
            padding: 14px;
            border: 1px solid #e5e7eb;
            border-left: 4px solid #2563eb;
        }

        /* MODE COLOR */
        .mapping-field.mode-manual {
            border-left-color: #f59e0b;
        }

        /* RADIO BUTTON */
        .mapping-mode input {
            display: none;
        }

        .mapping-mode span {
            padding: 6px 12px;
            border-radius: 999px;
            background: #f1f5f9;
            cursor: pointer;
            font-size: 12px;
        }

        .mapping-mode input:checked+span {
            background: #2563eb;
            color: #fff;
        }

        /* INPUT */
        .mapping-field select,
        .mapping-field input {
            width: 100%;
            padding: 8px;
            margin-top: 8px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
    </style>
@endsection
