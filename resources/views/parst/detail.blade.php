  @extends('layouts.detail')
  @extends('layouts.sidebar')
  @section('content')
      <div class="main">
          <div class="header">
              <h1>Chi Tiết Phụ Tùng</h1>
              <div>
                  <button class="btn btn-back">← Back</button>
                  <button class="btn btn-edit"><a href="{{ route('parsts.edit', $parst->id) }}">Chỉnh Sửa</a></button>
                  <form action="{{ route('parsts.destroy', $parst->id) }}" method="POST" style="display:inline;">
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
                      <label>ID</label>
                      <span>{{ $parst->code }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Tên</label>
                      <span>{{ $parst->name }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Loại Hàng</label>
                      <span>{{ $parst->parstsCategory->name }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Cũ/Mới</label>
                      <span>{{ $parst->item_condition }}.</span>
                  </div>

                  <div class="detail-item">
                      <label>Nhà Cung Cấp</label>
                      <span>{{ $parst->supplier_id }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Số Lượng</label>
                      <span>{{ $parst->quantity }}</span>
                  </div>

                
                  <div class="detail-item">
                      <label>Đơn Vị Tính</label>
                      <span>{{ $parst->unit }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Giá Nhập</label>
                      <span>{{ $parst->buy_price }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Nhập</label>
                      <span>{{ $parst->buy_date }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Về Bãi</label>
                      <span>{{ $parst->stock_in_date }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Bãi</label>
                      <span>{{ $parst->warehouse_id }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Trạng Thái</label>
                      <span class="status sold">{{ $parst->sale_status }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Bán</label>
                      <span>{{ $parst->sale_date }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Giá Bán</label>
                      <span>{{ $parst->sale_price }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Giá Bán Hoá Đơn</label>
                      <span>{{ $parst->sale_price_invoices }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Tạo Quản Lí</label>
                      <span>{{ $parst->created_at }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Chỉnh Sửa Quản Lí</label>
                      <span>{{ $parst->updated_at }}</span>
                  </div>
              </div>
          </div>

      </div>
  @endsection
