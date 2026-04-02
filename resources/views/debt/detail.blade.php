  @extends('layouts.detail')
  @extends('layouts.sidebar')
  @section('content')
      <div class="main">
          <div class="header">
              <h1>Chi Tiết Dư Nợ</h1>
              <div>
                  <button class="btn btn-back">← Back</button>
                  <button class="btn btn-edit"><a href="{{ route('debts.edit', $debt->id) }}">Chỉnh Sửa</a></button>
              </div>
          </div>

          <div class="card">
              <div class="detail-grid">
                  <div class="detail-item">
                      <label>ID</label>
                      <span>{{ $debt->id }}</span>
                  </div>
                  <div class="detail-item  clickable-row clickable-invoice"
                      data-href="{{ route('invoices.show', $debt->invoice->id) }}">
                      <label>Mã Hoá Đơn</label>
                      <span>{{ $debt->invoice->code }}</span>
                  </div>

                  <div class="detail-item {{ $debt->customer ? 'clickable-row clickable-invoice' : '' }}"
                      @if ($debt->customer) data-href="{{ route('customers.show', $debt->customer->id) }}" @endif>
                      <label>Tên Khách Hàng</label>
                      <span>{{ $debt->invoice->customer_name }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Dư Nợ</label>
                      <span>{{ number_format($debt->debt_amount, 0, ',', '.') }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Nợ</label>
                      <span>{{ $debt->debt_date }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Hẹn Trả</label>
                      <span>{{ $debt->debt_due_date }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Trả</label>
                      <span>{{ $debt->payment_date }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Trạng Thái</label>
                      <span
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
                      </span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Tạo Quản Lí</label>
                      <span>{{ $debt->created_at }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Chỉnh Sửa Quản Lí</label>
                      <span>{{ $debt->updated_at }}</span>
                  </div>
              </div>
          </div>
      </div>
      <script src="{{ asset('js/detail.js') }}"></script>
  @endsection
