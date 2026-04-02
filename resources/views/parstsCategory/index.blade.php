@extends('layouts.list')
@extends('layouts.sidebar')
@section('content')
    <div class="main">
        <div class="topbar">
            <h1>Quản Lí Khách Hàng</h1>
            <div>
                <input type="text" placeholder="Search customer...">
                <button class="btn btn-primary">+ Add Customer</button>
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
                        <th>Tên</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parstsCategorys as $parstsCategory )
                        <tr class="clickable-row">
                            <td>{{ $parstsCategory->id }}</td>
                            <td>{{ $parstsCategory->name }}</td>
                            <td>
                               <button class="btn-detail">
                                    <a href="{{ route('parstsCategory.show', $parstsCategory->id) }}">
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
