<div class="position-fixed d-flex justify-content-between flex-column flex-shrink-0 p-3" style="width: 250px; min-height: 100vh; background-color: #CDE6FF;">
    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-4 text-decoration-none justify-content-center">
        <img src="{{ asset('assets/images/logo new.png') }}" alt="Logo" width="180">
    </a>

    <ul class="nav nav-pills flex-column mb-auto">

        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"
                style="{{ Route::is('admin.dashboard') ? 'background-color: white; color: #003366;' : 'color: #003366;' }}">
                <i class="bi bi-grid-fill me-2"></i> Dashboard
            </a>
        </li>

        <li>
            <a href="#dataMasterSub" data-bs-toggle="collapse"
            class="nav-link {{ Route::is('admin.barangs.*', 'admin.masuk.*', 'admin.keluar.*', 'admin.kategoris.*') ? 'active' : '' }}"
            style="color: #003366;">
                <i class="bi bi-bar-chart-line-fill me-2"></i> Data Master ▾
            </a>
            <ul class="collapse list-unstyled ps-3 {{ Route::is('admin.barangs.*', 'admin.masuk.*', 'admin.keluar.*', 'admin.kategoris.*') ? 'show' : '' }}" id="dataMasterSub">
                <li>
                    <a href="{{ route('admin.barangs.index') }}"
                    class="nav-link {{ Route::is('admin.barangs.*') ? 'active' : '' }}"
                    style="{{ Route::is('admin.barangs.*') ? 'background-color: white; color: #003366;' : 'color: #003366;' }}">
                        <i class="bi bi-box-seam me-2"></i> Barang
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.masuk.index') }}"
                    class="nav-link {{ Route::is('admin.masuk.*') ? 'active' : '' }}"
                    style="{{ Route::is('admin.masuk.*') ? 'background-color: white; color: #003366;' : 'color: #003366;' }}">
                        <i class="bi bi-box-arrow-in-down me-2"></i> Barang Masuk
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.keluar.index') }}"
                    class="nav-link {{ Route::is('admin.keluar.*') ? 'active' : '' }}"
                    style="{{ Route::is('admin.keluar.*') ? 'background-color: white; color: #003366;' : 'color: #003366;' }}">
                        <i class="bi bi-box-arrow-up me-2"></i> Barang Keluar
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.kategoris.index') }}"
                    class="nav-link {{ Route::is('admin.kategoris.*') ? 'active' : '' }}"
                    style="{{ Route::is('admin.kategoris.*') ? 'background-color: white; color: #003366;' : 'color: #003366;' }}">
                        <i class="bi bi-tags-fill me-2"></i> Kategori
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="{{ route('admin.pesanan.index') }}" class="nav-link {{ Route::is('admin.pesanan.*') ? 'active' : '' }}"
                style="{{ Route::is('admin.pesanan.*') ? 'background-color: white; color: #003366;' : 'color: #003366;' }}">
                <i class="bi bi-bag-fill me-2"></i> Pesanan
            </a>
        </li>

        <li>
            <a href="{{ route('admin.notifikasi') }}" class="nav-link {{ Route::is('admin.notifikasi') ? 'active' : '' }}"
                style="{{ Route::is('admin.notifikasi') ? 'background-color: white; color: #003366;' : 'color: #003366;' }}">
                <i class="bi bi-bell-fill me-2"></i> Notifikasi
            </a>
        </li>

        <li>
            <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ Route::is('admin.laporan.*') ? 'active' : '' }}"
                style="{{ Route::is('admin.laporan.*') ? 'background-color: white; color: #003366;' : 'color: #003366;' }}">
                <i class="bi bi-file-earmark-bar-graph-fill me-2"></i> Laporan
            </a>
        </li>

        <li>
            <a href="{{ route('admin.profile.index') }}" class="nav-link {{ Route::is('admin.profile.*') ? 'active' : '' }}"
                style="{{ Route::is('admin.profile.*') ? 'background-color: white; color: #003366;' : 'color: #003366;' }}">
                <i class="bi bi-person-fill me-2"></i> Profile
            </a>
        </li>
    </ul>

    <hr>

    <div>
        <!-- <a href="{{ route('logout') }}" class="btn w-100" style="color: #003366; border: 1px solid #003366;">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a> -->
        <form method="POST" action="{{ route('logout') }}" class="btn w-100" style="color: #003366; border: 1px solid #003366;">
            @csrf
            <button type="submit" class="dropdown-item text-danger bi bi-box-arrow-right me-2">Logout</button>
        </form>
    </div>
</div>
