@extends('layouts.list')
@extends('layouts.sidebar')
@section('content')
    <div class="main">
        <div class="topbar">
            <h1>Quản Lí Khách Hàng</h1>
            <div>
                <input type="text" placeholder="Search customer...">
                <button class="btn btn-primary"><a href="{{ route('customers.create') }}"> Thêm Khách Hàng</a></button>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats">
            <div class="card" active>
                <h3>Tổng Khách Hàng</h3>
                <p>{{ $customers->count() }}</p>
            </div>
            <a href="{{ route('customers.debt') }}" class="card">
                <div>
                    <h3>Khách Nợ / Số Nợ / Tiền Nợ</h3>
                    @php
                        $debts = $customerDebt->pluck('debt')->flatten();
                    @endphp
                    <p>{{ $customerDebt->count() }} / {{ $debts->count() }} / {{ number_format($debts->sum('debt_amount')) }}</p>
                </div>
            </a>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Mã Khách Hàng</th>
                        <th>Tên</th>
                        <th>Hoá Đơn Dư Nợ</th>
                        <th>Tổng Tiền Còn Nợ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr class="clickable-row" data-href="{{ route('customers.show', $customer->id) }}">
                            <td>{{ $customer->customer_code }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>
                                <span
                                    class="
                                    {{ $customer->debt->whereIn('status', [0, 1])->count() > 0 ? 'status-danger' : 'status-success' }}">
                                    {{ $customer->debt->whereIn('status', [0, 1])->count() }}
                                </span>
                            </td>
                            <td>
                                <span
                                    class="
                                    {{ $customer->debt->whereIn('status', [0, 1])->sum('debt_amount') > 0 ? 'status-danger' : 'status-success' }}">
                                    {{ number_format($customer->debt->whereIn('status', [0, 1])->sum('debt_amount')) }}
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
