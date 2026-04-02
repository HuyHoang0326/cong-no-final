@extends('layouts.list')
@extends('layouts.sidebar')
@section('content')
    <div class="main">
        <div class="topbar">
            <h1>Quản Lí Phụ Tùng</h1>
            <div>
                <input type="text" placeholder="Search customer...">
                <button class="btn btn-primary">+ Nhập Phụ Tùng</button>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats">
             <a href="{{route('cars.index')}}" class="card">
                <h3>Xe</h3>
                <p>{{$car}}</p>
             </a>
              <a href="{{ route('parsts.new') }}" class="card">
                <h3>Phụ Tùng Mới</h3>
                <p>{{ $new }}</p>
            </a>
            <a href="{{ route('parsts.old') }}" class="card" active>
                <h3>Phụ Tùng Cũ</h3>
                <p>{{ $old }}</p>
            </a>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Cũ/Mới</th>
                        <th>Số Lượng</th>
                        <th>Giá Bán</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parsts as $parst )
                        <tr class="clickable-row "  class="clickable-row" data-href="{{ route('parsts.show', $parst->id) }}">
                            <td>{{ $parst->code }}</td>
                            <td>{{ $parst->name }}</td>
                            <td>{{ match($parst->item_condition) {
                                "0" => 'Mới',
                                "1" => 'Cũ',
                                default => 'Không xác định'
                            } }}
                            <td><span class="{{ $parst->quantity > 0 ? 'status-success' : 'status-danger' }}">
                                    {{ $parst->quantity }}
                                </span></td>
                            <td>{{ $parst->sale_price }}</td>
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
