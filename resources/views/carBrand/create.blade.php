@extends('layouts.create')
@extends('layouts.sidebar')
@section('content')
    <div class="main">

        <div class="header">
            <h1>Nhập Hãng Xe</h1>
        </div>
        <div class="card">
            <form method="POST" action="{{ route('carBrands.store') }}">
                @csrf

                <div class="form-grid">
                    <!-- ID (SERI) -->
                    <div class="form-group">
                        <label>Tên</label>
                        <input type="text" name="name">
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Lưu Xe</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <script src="{{ asset('js/carCreate.js') }}"></script>
@endsection
