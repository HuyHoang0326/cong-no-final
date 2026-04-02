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
        <div class="stats">
            <div class="card">
                <h3>Tổng Khách Hàng</h3>
                <p>120</p>
            </div>
            <div class="card">
                <h3>Tổng Tiền Nợ</h3>
                <p>250,000,000 VND</p>
            </div>
            <div class="card">
                <h3>Số Nợ Quá Hạn</h3>
                <p>15</p>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã Hoá Đơn</th>
                        <th>Xe/Phụ Tùng</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Số Lượng</th>
                        <th>Đơn Giá</th>
                        <th>Giá Bán Hoá Đơn</th>
                        <th>Giá Đã Bán</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoiceItems as $invoiceItem )
                        <tr class="clickable-row" data-href="{{ route('invoiceItem.show', $invoiceItem->id) }}">
                            <td>{{ $invoiceItem->id }}</td>
                            <td>{{ $invoiceItem->invoices_id }}</td>
                            <td>{{ $invoiceItem->product_type }}</td>
                            <td>{{ $invoiceItem->product_id }}</td>
                            <td>{{ $invoiceItem->quantity }}</td>
                            <td>{{ $invoiceItem->unit_price }}</td>
                            <td>{{ $invoiceItem->sale_price_invoices }}</td>
                            <td>{{ $invoiceItem->sale_price }}</td>
                            <td>
                               <button class="btn-detail">
                                    <a href="{{ route('invoiceItem.show', $invoiceItem->id) }}">
                                        Chi Tiết
                                    </a>
                               </button>
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
