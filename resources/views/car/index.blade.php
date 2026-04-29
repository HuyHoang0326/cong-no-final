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
                <p>{{ $cars->count() }}</p>
            </div>
            <a href="{{ route('parsts.index') }}" class="card">
                <div>
                    <h3>Phụ Tùng</h3>
                    <p>{{ $parst }}</p>
                </div>
            </a>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Số Khung</th>
                        <th>Seri</th>
                        <th>Tên</th>
                        <th>Hãng</th>
                        <th>Trọng tải</th>
                        <th>Giá Bán</th>
                        <th>Nhà Cung Cấp</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cars as $car)
                        <tr class="clickable-row" data-href="{{ route('cars.show', $car->id) }}">
                            <td>{{ $car->chassis_number }}</td>
                            <td>{{ $car->code }}</td>
                            <td>{{ $car->name }}</td>
                            <td>{{ $car->carBrand->name ?? '' }}</td>
                            <td>{{ $car->payload }}</td>
                            <td>{{ number_format($car->sale_price, 0, ',', '.') }}</td>
                            <td>{{ $car->supplier->name ?? '' }}</td>
                            <td>
                                <span
                                    class="
                                    {{ $car->sale_status == 0 ? 'status-success' : ($car->sale_status == 1 ? 'status-danger' : 'status-pending') }}">
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
    <style>
        @media (max-width: 768px) {

            table th:nth-child(4),
            table th:nth-child(6),
            table th:nth-child(7),
            table td:nth-child(4),
            table td:nth-child(6),
            table td:nth-child(7) {
                display: none;
            }
        }
    </style>
@endsection
