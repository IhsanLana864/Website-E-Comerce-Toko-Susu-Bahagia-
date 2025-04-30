@if ($barangs->isEmpty())
    <div class="col-12 text-center">
        <p class="text-muted">Barang Kosong</p>
    </div>
@else
    @foreach ($barangs as $barang)
        <div class="featureCol px-3 mb-6">
            <div class="border">
                <div class="imgHolder position-relative w-100 overflow-hidden">
                    <img src="/storage/{{ $barang->gambar }}" alt="{{ $barang->nama }}" class="img-fluid w-100" />
                    <ul class="list-unstyled postHoverLinskList d-flex justify-content-center m-0">
                        <li class="mr-2 overflow-hidden">
                            @if ($barang->stok > 0)
                                <a href="#" class="add-to-cart icon-cart d-block" data-id="{{ $barang->id }}" data-stok="{{ $barang->stok }}"></a>
                            @else
                                <button class="icon-cart d-block" disabled></button>
                            @endif
                        </li>
                        <li class="mr-2 overflow-hidden">
                            <a href="javascript:void(0);" class="icon-eye d-block"></a>
                        </li>
                    </ul>
                </div>
                <div class="text-center py-xl-5 py-sm-4 py-2 px-xl-2 px-1">
                    <span class="title d-block mb-2">{{ $barang->nama }}</span>
                    <span class="price d-block fwEbold">Rp{{ number_format($barang->harga, 0, ',', '.') }}</span>
                    <p class="card-title">{{ $barang->satuan }}</p>
                    <p class="card-title">Stok: {{ $barang->stok }}</p>
                </div>
            </div>
        </div>
    @endforeach

    <div class="col-12 d-flex justify-content-center mt-4">
        {!! $barangs->appends(request()->except('page'))->links() !!}
    </div>
@endif
