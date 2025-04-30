<!DOCTYPE html>
<html lang="id">
<head>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
        }

        .cart-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #003087;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        thead {
            background-color: #ffdede;
        }

        thead th {
            padding: 12px;
            text-align: left;
            color: #333;
            font-weight: bold;
        }

        tbody tr {
            background-color: #e6f1ff;
            border-bottom: 1px solid #ccc;
        }

        tbody td {
            padding: 15px;
            vertical-align: middle;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-info img {
            width: 50px;
            height: auto;
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .qty-control button {
            width: 25px;
            height: 25px;
            background-color: #003087;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }

        .qty-control input {
            width: 30px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .hapus-btn {
            background-color: #d9edff;
            color: #003087;
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }

        .total {
            text-align: right;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .total strong {
            font-size: 1.3rem;
        }

        .checkout-btn {
            background-color: #003087;
            color: #fff;
            padding: 10px 25px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="cart-title">Keranjang Belanja</h1>

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

        <table>
            <thead>
                <tr>
                    <th>Barang</th>
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
                            <td>
                                <div class="product-info">
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                                    <span>{{ $item['name'] }}</span>
                                </div>
                            </td>
                            <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td>
                                <div class="qty-control">
                                    <button class="btn btn-sm btn-outline-secondary decrement" data-id="{{ $id }}">-</button>
                                    <span class="mx-2 quantity" id="quantity-{{ $id }}">{{ $item['quantity'] }}</span>
                                    <button class="btn btn-sm btn-outline-secondary increment" data-id="{{ $id }}" data-stok="{{ $item['stok'] }}">+</button>
                                </div>
                            </td>
                            <td>Rp<span id="total-{{ $id }}">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span></td>
                            <td>
                                <button class="hapus-btn remove-from-cart" data-id="{{ $id }}">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>

        <div class="total">
            TOTAL HARGA : <strong><span id="total-harga">{{ number_format($totalHarga, 0, ',', '.') }}</span></strong>
        </div>

        <div class="text-right">
            <a href="{{ route('cartDetail') }}" class="checkout-btn">Checkout</a>
        </div>
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
</body>

</html>
