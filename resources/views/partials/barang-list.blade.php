<style>
    .keranjang{
        background-color:white;
        color:black;
    }
    .keranjang:hover{
        background-color:#003366;
        color:white;
    }
</style>

@if ($barangs->isEmpty())
    <div class="col-12 text-center">
        <p class="text-muted">Barang Kosong</p>
    </div>
@else
    @foreach ($barangs as $barang)
    <div class="featureCol px-3 mb-4">
        <div class="border rounded p-3 shadow-sm" style="background-color:rgb(255, 255, 255);">
            <div class="imgHolder position-relative w-100 overflow-hidden mb-3">
                <img src="/storage/{{ $barang->gambar }}" alt="{{ $barang->nama }}" class="img-fluid w-100" style="max-height: 150px; object-fit: contain;" />
            </div>
            <div class="row">
                <div class="col text-start px-2">
                    <span class="title d-block fw-bold mb-1" style="font-size: 16px; color: #00296b;">{{ $barang->nama }}</span>
                    <span class="price d-block fw-bold text-dark mb-1" style="font-size: 15px;">Rp{{ number_format($barang->harga, 0, ',', '.') }}</span>
                    <p class="text-danger mb-1" style="font-size: 12px;">Ex. {{ $barang->barangMasuk->first()->kedaluwarsa ?? 'TBA' }}</p>
                    <p class="text-muted" style="font-size: 12px;">Tersisa {{ $barang->stok }} Pcs</p>
                </div>
                <div class="col text-start px-2">
                    <div class="d-flex justify-content-center m-0 position-absolute" style="bottom: 10px; right:10px">
                        @if ($barang->stok > 0)
                            {{-- Ubah dari icon-cart ke tombol Beli --}}
                            <a href="{{ route('cart') }}" class="add-to-cart keranjang icon-cart d-block rounded-circle shadow-sm p-2"
                                data-id="{{ $barang->id }}" data-stok="{{ $barang->stok }}"></a>
                        @else
                            <button class="btn btn-sm btn-secondary" style="border-radius:10%; font-size:12px" disabled>Stok Habis</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endforeach

    <div class="col-12 d-flex justify-content-center mt-4">
        {!! $barangs->appends(request()->except('page'))->links() !!}
    </div>
@endif
