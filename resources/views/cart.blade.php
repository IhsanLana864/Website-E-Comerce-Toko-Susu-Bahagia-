@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <h2>Keranjang Belanja</h2>

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

        {{-- Pesan jika keranjang kosong --}}
        @if(empty($cart))
            <div class="alert alert-warning">
                Keranjang kosong, silakan <a href="{{ route('index') }}">belanja</a>.
            </div>
        @else

            <table class="table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalHarga = 0; @endphp
                    @foreach ($cart as $id => $item)
                        @php 
                            $subtotal = $item['price'] * $item['quantity'];
                            $totalHarga += $subtotal;
                        @endphp
                        <tr>
                            <td><img src="{{ asset('storage/' . $item['image']) }}" width="50" alt="{{ $item['name'] }}"></td>
                            <td>{{ $item['name'] }}</td>
                            <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary decrement" data-id="{{ $id }}">-</button>
                                <span class="mx-2 quantity" id="quantity-{{ $id }}">{{ $item['quantity'] }}</span>
                                <button class="btn btn-sm btn-outline-secondary increment" data-id="{{ $id }}" data-stok="{{ $item['stok'] }}">+</button>
                            </td>
                            <td>Rp<span id="total-{{ $id }}">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span></td>
                            <td>
                                <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total Harga</strong></td>
                            <td><strong><span id="total-harga">{{ number_format($totalHarga, 0, ',', '.') }}</span></strong></td>
                            <td>
                                <a href="{{ route('cartDetail') }}" class="btn btn-primary btn-sm">Pesan</a>
                            </td>
                        </tr>
                </tbody>
            </table>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            function updateTotalHarga() {
                let totalHarga = 0;
                $("tbody tr").each(function () {
                    let totalItem = $(this).find("span[id^='total-']").text().replace(/[^0-9]/g, '');
                    if (totalItem) {
                        totalHarga += parseInt(totalItem);
                    }
                });
                $("#total-harga").text("Rp" + totalHarga.toLocaleString("id-ID"));
            }

            $(".increment").click(function () {
                let id = $(this).data("id");
                let stok = $(this).data("stok"); 
                let currentQuantity = parseInt($("#quantity-" + id).text());

                if (currentQuantity < stok) {
                    updateCart(id, currentQuantity + 1);
                } else {
                    alert("Jumlah barang melebihi stok yang tersedia!");
                }
            });

            $(".decrement").click(function () {
                let id = $(this).data("id");
                let currentQuantity = parseInt($("#quantity-" + id).text());

                if (currentQuantity > 1) {
                    updateCart(id, currentQuantity - 1);
                }
            });

            $(".remove-from-cart").click(function () {
                let id = $(this).data("id");

                $.ajax({
                    url: "{{ route('remove.from.cart') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        barang_id: id
                    },
                    success: function (response) {
                        alert(response.success);
                        location.reload();
                    }
                });
            });

            function updateCart(id, quantity) {
                $.ajax({
                    url: "{{ route('update.cart') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        barang_id: id,
                        quantity: quantity
                    },
                    success: function (response) {
                        $("#quantity-" + id).text(response.quantity);
                        $("#total-" + id).text(response.total);
                        $("#total-harga").text("Rp" + response.totalHarga); // Update total harga seluruh keranjang
                    },
                    error: function (xhr) {
                        alert(xhr.responseJSON.error);
                    }
                });
            }
            
        });
    </script>
@endsection
