@extends('layouts.list')
@extends('layouts.sidebar')
@section('content')
    <div class="main">
        <div class="topbar">
            <h1>Quản Lí Kho</h1>
            <div>
                <input type="text" placeholder="Search customer...">
                <button class="btn btn-primary">+ Nhập Xe</button>
            </div>
        </div>
        <!-- Stats -->
        <div class="stats">
            <div class="card" active>
                <h3>Xe</h3>
                <p>{{$cars->count()}}</p>
            </div>
            <a href="{{ route('parsts.index') }}" class="card">
                <div>
                    <h3>Phụ Tùng</h3>
                    <p>{{$parst}}</p>
                </div>
            </a>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Seri</th>
                        <th>Tên</th>
                        <th>Số Khung</th>
                        <th>Giá Mua</th>
                        <th>Giá Hoá Đơn</th>
                        <th>Giá Bán</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cars as $car )
                        <tr class="clickable-row" data-href="{{ route('cars.show', $car->id) }}">
                            <td>{{ $car->code }}</td>
                            <td>{{ $car->name }}</td>
                            <td>{{ $car->chassis_number }}</td>
                            <td>{{ number_format($car->buy_price, 0, ',', '.') }}</td>
                            <td>{{ number_format($car->sale_price_invoices, 0, ',', '.') }}</td>
                            <td>{{ number_format($car->sale_price, 0, ',', '.') }}</td>
                            <td>
                                <span  class="
                                    {{  $car->sale_status == 0 ? 'status-success' : ( $car->sale_status == 1 ? 'status-danger' : 'status-pending') }}">
                                    {{ $car->sale_status == 0 ? 'Trong kho' : ($car->sale_status == 1 ? 'Đã bán' : 'Đã đặt') }}
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
