@if ($barangs->isEmpty())
    <div class="col-12 text-center">
        <p class="text-muted">Barang Kosong</p>
    </div>
@else
    @foreach ($barangs as $barang)
    <div class="featureCol px-3 mb-4">
        <div class="border rounded p-3 shadow-sm" style="background-color: #f0f8ff;">
            <div class="imgHolder position-relative w-100 overflow-hidden mb-3">
                <img src="/storage/{{ $barang->gambar }}" alt="{{ $barang->nama }}" class="img-fluid w-100" style="max-height: 150px; object-fit: contain;" />
                <ul class="list-unstyled postHoverLinskList d-flex justify-content-center m-0 position-absolute w-100" style="bottom: 10px;">
                    <li class="mr-2 overflow-hidden">
                        @if ($barang->stok > 0)
                            {{-- Ubah dari icon-cart ke tombol Beli --}}
                            <a href="{{ route('cart') }}" class="btn btn-sm btn-primary fw-semibold px-3"
                                data-id="{{ $barang->id }}" data-stok="{{ $barang->stok }}">Beli</a>
                        @else
                            <button class="btn btn-sm btn-secondary px-3" disabled>Stok Habis</button>
                        @endif
                    </li>
                    <li class="mr-2 overflow-hidden">
                        {{-- Ubah dari icon-eye ke icon-cart --}}
                        <a href="{{ route('cart') }}" class="icon-cart d-block bg-blue rounded-circle shadow-sm p-2"></a>
                    </li>
                </ul>
            </div>
            <div class="text-center px-2">
                <span class="title d-block fw-bold mb-1" style="font-size: 16px; color: #00296b;">{{ $barang->nama }}</span>
                <span class="price d-block fw-bold text-dark mb-1" style="font-size: 15px;">Rp{{ number_format($barang->harga, 0, ',', '.') }}</span>
                <p class="text-danger mb-1" style="font-size: 12px;">Ex. {{ $barang->kadaluarsa ?? '14/12/2028' }}</p>
                <p class="text-muted" style="font-size: 12px;">Tersisa {{ $barang->stok }} Pcs</p>
            </div>
        </div>
    </div>

    @endforeach

    <div class="col-12 d-flex justify-content-center mt-4">
        {!! $barangs->appends(request()->except('page'))->links() !!}
    </div>
@endif
