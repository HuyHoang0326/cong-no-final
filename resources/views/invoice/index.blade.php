@extends('layouts.list')
@extends('layouts.sidebar')
@section('content')
    <div class="main">
        <div class="topbar">
            <h1>Quản Lí Hoá Đơn</h1>
            <div>
                <input type="text" placeholder="Search customer...">
                <button class="btn btn-primary">+ Tạo Hoá Đơn</button>
            </div>
        </div>

        <!-- Stats -->
       <div class="stats" style="{{ empty($invoiceStatus) ? 'display:none;' : '' }}">
            <a href="{{ route('invoices.listStatus0') }}" class="card">
                <div>
                    <h3>Hàng Chưa Giao</h3>
                    <p>{{ isset($invoiceStatus['pending']) ? $invoiceStatus['pending']->count() : 0 }}</p>
                </div>
            </a>
            <a href="{{ route('invoices.listStatus1') }}" class="card">
                <div>
                    <h3>Hàng Đã Giao</h3>
                    <p>{{ isset($invoiceStatus['success']) ? $invoiceStatus['success']->count() : 0 }}</p>
                </div>
            </a>
            <a href="{{ route('invoices.listStatus2') }}" class="card">
                <div>
                    <h3>Hàng Hủy</h3>
                    <p>{{isset($invoiceStatus['danger']) ? $invoiceStatus['danger']->count() : 0  }}</p>
                </div>
            </a>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Khách Hàng</th>
                        <th>Ngày Giao Hàng</th>
                        <th>Số Nợ</th>
                        <th>Giá Bán</th>
                        <th>Giấy Tờ Đã Giao</th>
                        <th>Thanh Toán</th>
                        <th>Giao Hàng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr class="clickable-row" data-href="{{ route('invoices.show', $invoice->id) }}">
                            <td>{{ $invoice->code }}</td>
                            <td>{{ $invoice->customer_name }}</td>
                            <td>{{ $invoice->delivery_date }}</td>
                            <td>{{ number_format($invoice->debt->debt_amount ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($invoice->price, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $map = [
                                        'hai_quan' => 'Hải quan',
                                        'dang_kiem' => 'Đăng kiểm',
                                        'hop_dong' => 'Hợp đồng',
                                        'da_giao_du' => 'Đã Giao Đủ',
                                        'chua_giao' => 'Chưa Giao',
                                    ];

                                    $classMap = [
                                        'hai_quan' => 'status-pending',
                                        'dang_kiem' => 'status-pending',
                                        'hop_dong' => 'status-pending',
                                        'da_giao_du' => 'status-success',
                                        'chua_giao' => 'status-danger',
                                    ];
                                @endphp

                                @foreach ($invoice->document_delivered ?? [] as $item)
                                    <span class="badge {{ $classMap[$item] ?? '' }}">
                                        {{ $map[$item] ?? $item }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                <span
                                    class="
{{ $invoice->debt?->status !== null
    ? ($invoice->debt->status == 0
        ? 'status-pending'
        : ($invoice->debt->status == 1
            ? 'status-danger'
            : ($invoice->debt->status == 2
                ? 'status-success'
                : ($invoice->debt->status == 3
                    ? 'status-success'
                    : ''))))
    : 'status-success' }}">

                                    {{ $invoice->debt?->status !== null
                                        ? ($invoice->debt->status == 0
                                            ? 'Chưa Thanh Toán'
                                            : ($invoice->debt->status == 1
                                                ? 'Quá Hạn'
                                                : ($invoice->debt->status == 2
                                                    ? 'Đã Thanh Toán'
                                                    : ($invoice->debt->status == 3
                                                        ? 'Đã Huỷ'
                                                        : ''))))
                                        : 'Không Xác Đinh' }}
                                </span>
                            </td>
                            <td>
                                <span
                                    class="
                                    {{ $invoice->status == 0 ? 'status-pending' : ($invoice->status == 1 ? 'status-success' : 'status-danger') }}">
                                    {{ $invoice->status == 0 ? 'Chưa Giao Xe' : ($invoice->status == 1 ? 'Đã Giao Xe' : 'Hủy Đơn Hàng') }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination">
                <button>1</button>
                <button>2</button>
                <button>3</button>
            </div>
        </div>
        <script src="{{ asset('js/list.js') }}"></script>
    </div>
@endsection
