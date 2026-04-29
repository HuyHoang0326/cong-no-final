  @extends('layouts.detail')
  @extends('layouts.sidebar')
  @section('content')
      <div class="main">
          <div class="header">
              <h1>Chi Tiết Xe</h1>
              <div>
                  <button class="btn btn-back">← Back</button>
                  <button class="btn btn-edit"><a href="{{ route('cars.edit', $car->id) }}">Chỉnh Sửa</a></button>
                  <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')

                      <button type="submit" class="btn btn-destroy" onclick="return confirm('Bạn có chắc muốn xoá không?')">
                          Xóa
                      </button>
                  </form>
              </div>
          </div>

          <div class="card">
              <div class="detail-grid">

                  <div class="detail-item">
                      <label>Seri</label>
                      <span>{{ $car->code }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Tên</label>
                      <span>{{ $car->name }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Hãng</label>
                      <span>{{ $car->carBrand->name }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Số Máy</label>
                      <span>{{ $car->engine_number }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Số Khung</label>
                      <span>{{ $car->chassis_number }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Trọng Tải</label>
                      <span>{{ $car->payload }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Nhà Cung Cấp</label>
                      <span>{{ $car->supplier_id }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Giá Nhập</label>
                      <span>{{ number_format($car->buy_price, 0, ',', '.') }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Nhập</label>
                      <span>{{ $car->buy_date }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Về Bãi</label>
                      <span>{{ $car->stock_in_date }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Bãi</label>
                      <span>{{ $car->warehouse_id }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Giấy Tờ Trong Kho</label>

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

                      @foreach ($car->document_in_stock ?? [] as $item)
                          <span class="badge {{ $classMap[$item] ?? '' }}">
                              {{ $map[$item] ?? $item }}
                          </span>
                      @endforeach

                  </div>

                  <div class="detail-item">
                      <label>Trạng Thái</label>
                      <span
                          class
                      ="{{ $car->sale_status == 0 ? 'status-success' : ($car->sale_status == 1 ? 'status-danger' : 'status-pending') }}">
                          {{ $car->sale_status == 0 ? 'Trong kho' : ($car->sale_status == 1 ? 'Đã bán' : 'Đã đặt') }}
                      </span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Bán</label>
                      <span>{{ $car->sale_date }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Giá Bán</label>
                      <span>{{ number_format($car->sale_price, 0, ',', '.') }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Giá Bán Hoá Đơn</label>
                      <span>{{ number_format($car->sale_price_invoices, 0, ',', '.') }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Tạo Quản Lí</label>
                      <span>{{ $car->created_at }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Chỉnh Sửa Quản Lí</label>
                      <span>{{ $car->updated_at }}</span>
                  </div>
              </div>
          </div>

      </div>
  @endsection
