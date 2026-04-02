@extends('layouts.list')
@extends('layouts.sidebar')
@section('content')
    <div class="main">
        <div class="topbar">
            <h1>Quản Dư Nợ</h1>
            <div>
                <input type="text" placeholder="Search customer...">
            </div>
        </div>

        <!-- Stats -->
        <div class="stats">
            <div class="card" active>
                <h3>Hoá Đơn Còn Nợ</h3>
                <p>{{ number_format($debtsPrice, 0, ',', '.') }} Vnd / {{ $debts_count }} Hóa Đơn</p>
            </div>
            <a href="{{ route('debts.overdueDebtList') }}" class="card">
                <div>
                    <h3>Số Nợ Quá Hạn</h3>
                    <p>{{ number_format($totalOverdue, 0, ',', '.') }} Vnd / {{ $overdueDebtsCount }} Hóa Đơn</p>
                </div>
            </a>
            <a href="{{ route('debts.isPaidList') }}" class="card">
                <div>
                    <h3>Số Nợ Đã Thanh Toán</h3>
                    <p>{{ number_format($totalDebtsIsPaid, 0, ',', '.') }} Vnd / {{ $debtIsPaidCount }} Hóa Đơn</p>
                </div>
            </a>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã Hoá Đơn</th>
                        <th>Tên Khách Hàng</th>
                        <th>Số Nợ</th>
                        <th>Ngày Nợ</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($debts as $debt)
                        <tr class="clickable-row" data-href="{{ route('debts.show', $debt->id) }}">
                            <td>{{ $debt->id }}</td>
                            <td>{{ $debt->invoice->code }}</td>
                            <td>
                                {{ $debt->customer?->name ?? $debt->invoice->customer_name }}
                            </td>
                            <td>{{ number_format($debt->debt_amount, 0, ',', '.') }}</td>
                            <td>{{ $debt->debt_date }}</td>
                            <td> <span
                                    class="
                                        {{ $debt->status == 0
                                            ? 'status-pending'
                                            : ($debt->status == 1
                                                ? 'status-danger'
                                                : ($debt->status == 2
                                                    ? 'status-success'
                                                    : ($debt->status == 3
                                                        ? 'status-success'
                                                        : ''))) }}
                                    ">
                                    {{ $debt->status == 0
                                        ? 'Chưa Thanh Toán'
                                        : ($debt->status == 1
                                            ? 'Quá Hạn'
                                            : ($debt->status == 2
                                                ? 'Đã Thanh Toán'
                                                : ($debt->status == 3
                                                    ? 'Đã Huỷ'
                                                    : ''))) }}
                                </span></td>
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
