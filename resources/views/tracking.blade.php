@extends('layouts.main')

@section('content')
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1>Tracking</h1>
    <p>Silakan pilih menu di atas untuk menjelajahi toko kami.</p>
    <form action="{{ route('tracking.show') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="mb-3">
            <label class="form-label">Order ID</label>
            <input type="text" class="form-control" name="order_id" placeholder="Masukkan order id" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
