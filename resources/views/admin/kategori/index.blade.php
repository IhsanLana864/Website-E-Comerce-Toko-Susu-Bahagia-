@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-0">
            @include('admin.sidebar')
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <div class="card shadow rounded-4">
                <div class="card-body p-4" style="background-color: #E3F0FF;">
                    <h4 class="fw-bold mb-4" style="color: #003366;">Kategori</h4>

                    <!-- Tombol Tambah -->
                    <div class="mb-3">
                        <a href="{{ route('admin.kategoris.create') }}" class="btn btn-primary rounded-4 px-4" style="background-color: #003366;">Tambah</a>
                    </div>

                    <!-- Tabel Kategori -->
                    <div class="table-responsive">
                        @if ($kategoris->isEmpty())
                            <div class="col-12 text-center">
                                <p class="text-muted">Kategori Kosong</p>
                            </div>
                        @else
                            <table id="myTable" class="table table-bordered rounded-4" style="background-color: #FFEAEA;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($kategoris as $kategori)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $kategori->kategori }}</td>
                                        <td>
                                            <a href="{{ route('admin.kategoris.edit', $kategori->id) }}" class="btn btn-sm rounded-4 px-3" style="background-color: #003366; color: white;">Edit</a>
                                            <!-- <a href="#" class="btn btn-sm rounded-4 px-3" style="background-color: #E62E4D; color: white;">Hapus</a> -->
                                            <form action="{{ route('admin.kategoris.destroy', $kategori->id) }}" method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready( function () {
        $('#myTable').DataTable( {
            paging: true,
            searching: true,
            ordering: true,
            responsive: true,
            // language: {
            //     url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json', // Untuk Bahasa Indonesia
            // }
        } );
    } );
</script>
@endsection