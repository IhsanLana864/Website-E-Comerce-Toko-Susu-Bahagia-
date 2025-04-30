@if ($notifikasis->isEmpty())
    <div class="col-12 text-center">
        <p class="text-muted">Notifikasi Kosong</p>
    </div>
@else
    <ul class="row gap-2">
        @forelse ($notifikasis as $notif)
            @php
                // Menentukan URL tujuan berdasarkan jenis notifikasi
                $url = '#';
                if (str_contains($notif->jenis, 'Pesanan')) {
                    $url = route('admin.pesanan.show', $notif->pesanan_id);
                } elseif (str_contains($notif->jenis, 'Kedaluwarsa')) {
                    $url = route('admin.masuk.show', $notif->barang_masuk_id);
                }
            @endphp
            <div class="row p-2 position-relative {{ $notif->dibaca ? '' : 'bg-light' }}" 
                style="border: solid 2px #FFB1B1; border-radius: 5px;">

                @if (!$notif->dibaca)
                    <span class="position-absolute top-0 start-0 translate-middle p-1 bg-danger border border-light rounded-circle" 
                        style="width: 10px; height: 10px; z-index: 10; left: -5px; top: -5px;"></span>
                @endif

                <a href="#" class="notif-item text-decoration-none text-dark" data-id="{{ $notif->id }}" data-href="{{ $url }}">
                    {{ $notif->pesan }}
                </a>
                <br>
                <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
            </div>
        @empty
            <li class="list-group-item text-muted">Tidak ada notifikasi</li>
        @endforelse
    </ul>

    <div class="col-12 d-flex justify-content-center mt-4">
        {!! $notifikasis->appends(request()->except('page'))->links() !!}
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".notif-item").forEach(item => {
                item.addEventListener("click", function (event) {
                    event.preventDefault(); // Mencegah langsung redirect

                    const notifId = this.getAttribute("data-id");
                    const targetUrl = this.getAttribute("data-href");

                    if (notifId && targetUrl && targetUrl !== "#") {
                        fetch(`/admin/notifikasi/${notifId}/read`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = targetUrl;
                            } else {
                                alert("Gagal menandai notifikasi sebagai dibaca.");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("Terjadi kesalahan saat memproses notifikasi.");
                        });
                    }
                });
            });
        });
    </script>
@endif
