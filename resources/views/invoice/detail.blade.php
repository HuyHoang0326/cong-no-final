  @extends('layouts.detail')
  @extends('layouts.sidebar')
  @section('content')
      <div class="main">
          <div class="header">
              <h1>Chi Tiết Hóa Đơn</h1>
              <div>
                  <button class="btn btn-back">← Back</button>
                  <button class="btn btn-edit"><a href="{{ route('invoices.edit', $invoice->id) }}">Chỉnh Sửa</a></button>
                  <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-destroy" onclick="return confirm('Bạn có chắc muốn xoá không?')">
                          Xóa
                      </button>
                  </form>
              </div>
          </div>

          <div class="card">
              <h3 class="section-title">Thông Tin </h3>
              <div class="detail-grid">

                  <div class="detail-item">
                      <label>Mã Hóa Đơn</label>
                      <span class="invoice-id">{{ $invoice->code }}</span>
                  </div>

                  <div class="detail-item {{ $invoice->customer ? 'clickable-row clickable-invoice' : '' }}"
                      {{ $invoice->customer ? 'data-href=' . route('customers.show', $invoice->customer->id) : '' }}>
                      <label>Tên Khách Hàng</label>
                      <span class="customer-name">{{ $invoice->customer_name }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Người Nhận Hàng</label>
                      <span class="receiver-name">{{ $invoice->receiver_name }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Địa Chỉ</label>
                      <span class="customer-address">{{ $invoice->customer_address }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Số Điện Thoại</label>
                      <span class="customer-phone">{{ $invoice->customer_phone }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Bán</label>
                      <span class="date-sell">{{ $invoice->sale_date }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Người Tạo Đơn</label>
                      <span>{{ $invoice->invoicer }}.</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Giao Hàng</label>
                      <span>{{ $invoice->delivery_date }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Đã Thanh Toán</label>
                      <span class="paid-amount">{{ number_format($invoice->is_paid, 0, ',', '.') }}</span>
                  </div>

                  <div class="detail-item  {{ $invoice->debt ? 'clickable-row clickable-invoice' : '' }}"
                      {{ $invoice->debt ? 'data-href=' . route('debts.show', $invoice->debt->id) : '' }}
                      id = 'invoice-debt-amount'>
                      <label>Còn Nợ</label>
                      <span class="total-debt"><span
                              class="{{ $invoice->debt
                                  ? match ($invoice->debt->status) {
                                      0 => 'status-pending',
                                      1 => 'status-danger',
                                      2 => 'status-success',
                                      default => '',
                                  }
                                  : 'status-success' }}">
                              {{ $invoice->debt && $invoice->debt->status != 2 ? $invoice->debt->debt_amount : 0 }}
                          </span></span>
                  </div>

                  <div class="detail-item">
                      <label>Giấy Tờ Đã Giao</label>
                      <span>
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

                          @foreach ($invoice->document_delivered ?? [] as $item)
                              <span class="badge {{ $classMap[$item] ?? '' }}">
                                  {{ $map[$item] ?? $item }}
                              </span>
                          @endforeach
                  </div>

                  <div class="detail-item">
                      <label>Giá Vận Chuyển</label>
                      <span class="shipping-cost">{{ number_format($invoice->shipping_cost, 0, ',', '.') }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Giá Đã Bán</label>
                      <span class="total-sale">{{ number_format($invoice->price) }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Trạng Thái</label>
                      <span
                          class="
                                    {{ $invoice->status == 0 ? 'status-pending' : ($invoice->status == 1 ? 'status-success' : 'status-danger') }}">
                          {{ $invoice->status == 0 ? 'Chưa Giao Xe' : ($invoice->status == 1 ? 'Đã Giao Xe' : 'Hủy Đơn Hàng') }}
                      </span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Tạo Quản Lí</label>
                      <span>{{ $invoice->created_at }}</span>
                  </div>

                  <div class="detail-item">
                      <label>Ngày Chỉnh Sửa Quản Lí</label>
                      <span>{{ $invoice->updated_at }}</span>
                  </div>
              </div>
              <!-- ===== ITEMS ===== -->
              <br>
              <h3 class="section-title">Danh sách sản phẩm</h3>
              <div class="product-grid">

                  @foreach ($invoice->items as $item)
                      <div class="product-card {{ $item->product_type }}">

                          <!-- TYPE -->
                          <div class="detail-item">
                              <label>Loại</label>
                              <span>{{ $item->product_type == 'car' ? 'Xe' : 'Phụ Tùng' }}</span>
                          </div>

                          {{-- ================= CAR ================= --}}
                          @if ($item->product_type === 'car')
                              <div class="detail-item">
                                  <label>Mã Xe</label>
                                  <span class="car-serial">{{ $item->product_code }}</span>
                              </div>

                              <div class="detail-item">
                                  <label>Tên Xe</label>
                                  <span class="car-name">{{ $item->car_name }}</span>
                              </div>

                              <div class="detail-item">
                                  <label>Hãng</label>
                                  <span class="car-brand">{{ $item->car_brand }}</span>
                              </div>

                              <div class="detail-item">
                                  <label>Số Máy</label>
                                  <span class="car-engine">{{ $item->car_engine_number }}</span>
                              </div>

                              <div class="detail-item">
                                  <label>Số Khung</label>
                                  <span class="car-chassis">{{ $item->car_chassis_number }}</span>
                              </div>

                              <div class="detail-item">
                                  <label>Trọng Tải</label>
                                  <span class="car-payload">{{ $item->car_payload }}</span>
                              </div>

                              <div class="detail-item total-price-car">
                                  <label>Tổng Giá Bán</label>
                                  <span class="car-price">{{ number_format($item->sale_price) }}</span>
                              </div>

                              <div class="detail-item">
                                  <label>Giá Hóa Đơn Xe</label>
                                  <span class="car-invoice-price">{{ number_format($item->sale_price_invoice) }}</span>
                              </div>
                          @endif


                          {{-- ================= PARST ================= --}}
                          @if ($item->product_type === 'parst')
                              <div class="detail-item">
                                  <label>Mã Phụ Tùng</label>
                                  <span class="parst-code">{{ $item->product_code }}</span>
                              </div>

                              <div class="detail-item">
                                  <label>Tên</label>
                                  <span class="parst-name">{{ $item->parst_name }}</span>
                              </div>

                              <div class="detail-item">
                                  <label>Loại</label>
                                  <span class="parst-category">{{ $item->parst_category }}</span>
                              </div>

                              <div class="detail-item">
                                  <label>Cũ/Mới</label>
                                  <span class="parst-condition">{{ $item->parst_condition }}</span>
                              </div>

                              <div class="detail-item">
                                  <label>Nhà Cung Cấp</label>
                                  <span class="parst-supplier">{{ $item->parst_supplier }}</span>
                              </div>

                              <div class="detail-item">
                                  <label>Số Lượng Đã Bán</label>
                                  <span class="parst-sold-quantity">{{ $item->quantity }}</span>
                              </div>
                              <div class="detail-item">
                                  <label>Đơn Vị Tính</label>
                                  <span class="parst-unit">{{ $item->unit }}</span>
                              </div>
                              <div class="detail-item">
                                  <label>Đơn Giá Bán</label>
                                  <span class="parst-price">{{ number_format($item->sale_price) }}</span>
                              </div>

                              <div class="detail-item total-price-parst">
                                  <label>Tổng Giá Bán</label>
                                  <span class="total-parst-price">
                                      {{ number_format($item->quantity * $item->sale_price, 0, ',', '.') }}
                                  </span>
                              </div>
                          @endif

                      </div>
                  @endforeach
              </div>
                        <button type="button" class="btn-print" onclick="printInvoice()">
    🖨 In hóa đơn
</button>
          </div>
          <div id="invoice-preview" class="invoice-print"></div>
      </div>
      <script src="{{ asset('js/invoiceDetail.js') }}"></script>
      <script src="{{ asset('js/detail.js') }}"></script>
  @endsection
