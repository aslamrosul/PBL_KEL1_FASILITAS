<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href={{ url('/admin') }}><span class="brand-text font-weight-bold">
                            FixIT <span style="color: rgb(41, 205, 255);">POLINEMA</span>
                        </span></a>
                </div>
                <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                    <!-- Theme toggle icons -->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20"
                        preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                opacity=".3"></path>
                            <g transform="translate(-210 -1)">
                                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                <circle cx="220.5" cy="11.5" r="4"></circle>
                                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                            </g>
                        </g>
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                        <label class="form-check-label"></label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20"
                        preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                        </path>
                    </svg>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu Utama</li>

                <!-- Dashboard -->
                <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route(strtolower(Auth::user()->level->level_route) . '.dashboard') }}"
                        class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Menu untuk Admin -->
                @if(Auth::user()->level->level_kode === 'ADM')
                            <li class="sidebar-title">Administrator</li>

                            <li
                                class="sidebar-item has-sub
                                                                                                                                                                                                                {{
                    request()->routeIs('admin.user.*') ||
                    request()->routeIs('admin.mahasiswa.*') ||
                    request()->routeIs('admin.dosen.*') ||
                    request()->routeIs('admin.tendik.*') ||
                    request()->routeIs('admin.sarpras.*') ||
                    request()->routeIs(patterns: 'admin.teknisi.*')
                    ? 'active'
                    : ''
                                                                                                                                                                                                                }}">
                                <a href="#" class='sidebar-link'>
                                    <i class="bi bi-people-fill"></i>
                                    <span>Manajemen User</span>
                                </a>
                                <ul class="submenu">
                                    <li class="submenu-item {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                                        <a href="{{ route('admin.user.index') }}">Admin</a>
                                    </li>
                                    <li class="submenu-item {{ request()->routeIs('admin.pelapor.*') ? 'active' : '' }}">
                                        <a href="#">Pelapor</a>
                                    </li>
                                    <li class="submenu-item {{ request()->routeIs('admin.sarpras.*') ? 'active' : '' }}">
                                        <a href="#">Sarana Prasarana</a>
                                    </li>
                                    <li class="submenu-item {{ request()->routeIs('admin.teknisi.*') ? 'active' : '' }}">
                                        <a href="#">Teknisi</a>
                                    </li>
                                </ul>
                            </li>



                            <li
                                class="sidebar-item has-sub
                                                                                                                                                                                                                {{
                    request()->routeIs('admin.periode.*') ||
                    request()->routeIs('admin.gedung.*') ||
                    request()->routeIs('admin.lantai.*') ||
                    request()->routeIs(patterns: 'admin.ruang.*')
                    ? 'active'
                    : ''
                                                                                                                                                                                                                }}">
                                <a href="#" class='sidebar-link'>
                                    <i class="bi bi-map"></i>
                                    <span>Manajemen Lokasi</span>
                                </a>
                                <ul class="submenu">
                                    <li class="submenu-item {{ request()->routeIs('admin.periode.*') ? 'active' : '' }}">
                                        <a href="{{ route('admin.periode.index') }}">Periode</a>
                                    </li>
                                    <li class="submenu-item {{ request()->routeIs('admin.gedung.*') ? 'active' : '' }}">
                                        <a href="{{ route('admin.gedung.index') }}">Gedung</a>
                                    </li>
                                    <li class="submenu-item {{ request()->routeIs('admin.lantai.*') ? 'active' : '' }}">
                                        <a href="{{ route('admin.lantai.index') }}">Lantai</a>
                                    </li>
                                    <li class="submenu-item {{ request()->routeIs('admin.ruang.*') ? 'active' : '' }}">
                                        <a href="{{ route('admin.ruang.index') }}">Ruang</a>
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="sidebar-item has-sub
                                                                                                                                                                                                                {{
                    request()->routeIs('admin.fasilitas.*') ||
                    request()->routeIs('admin.klasifikasi.*') ||
                    request()->routeIs('admin.kategori.*') ||
                    request()->routeIs('admin.barang.*') ||
                    request()->routeIs('admin.bobot-prioritas.*') ||
                    request()->routeIs('admin.kriteria.*')
                    ? 'active'
                    : ''
                                                                                                                                                                                                                }}">
                                <a href="#" class='sidebar-link'>
                                    <i class="bi bi-gear"></i>
                                    <span>Manajemen Fasilitas</span>
                                </a>
                                <ul class="submenu">

                                    <li class="submenu-item {{ request()->routeIs('admin.klasifikasi.*') ? 'active' : '' }}">
                                        <a href="{{ route('admin.klasifikasi.index') }}">Klasifikasi</a>
                                    </li>
                                    <li class="submenu-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                                        <a href="{{ route('admin.kategori.index') }}">Kategori</a>
                                    </li>
                                    <li class="submenu-item {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                                        <a href="{{ route('admin.barang.index') }}">Barang</a>
                                    </li>
                                    <li class="submenu-item {{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">
                                        <a href="{{ route('admin.fasilitas.index') }}">Fasilitas</a>
                                    </li>
                                    <li class="submenu-item {{ request()->routeIs('admin.kriteria.*') ? 'active' : '' }}">
                                        <a href="{{ route('admin.kriteria.index') }}">Kriteria</a>
                                    </li>
                                    <li class="submenu-item {{ request()->routeIs('admin.bobot-prioritas.*') ? 'active' : '' }}">
                                        <a href="{{ route('admin.bobot-prioritas.index') }}">Bobot Prioritas</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.laporan.index') }}" class='sidebar-link'>
                                    <i class="bi bi-file-earmark-text"></i>
                                    <span>Laporan Kerusakan</span>
                                </a>
                            </li>
                @endif

                <!-- Menu untuk Pelapor (Mahasiswa/Dosen/Tendik) -->
                @if(Auth::user()->level->level_kode === 'DSN' || Auth::user()->level->level_kode === 'MHS' || Auth::user()->level->level_kode === 'TNK')
                    <li class="sidebar-title">Pelaporan</li>

                    <li class="sidebar-item {{ request()->routeIs('pelapor.laporan.*') ? 'active' : '' }}">
                        <a href="{{ route('pelapor.laporan.index') }}" class='sidebar-link'>
                            <i class="bi bi-file-earmark-plus"></i>
                            <span>Buat Laporan</span>
                        </a>
                    </li>
                    {{-- <li class="sidebar-item {{ request()->routeIs('pelapor.feedback.*') ? 'active' : '' }}">
                        <a href="{{ route('pelapor.feedback.index') }}" class='sidebar-link'>
                            <i class="bi bi-chat-dots"></i>
                            <span>Feedback Laporan</span>
                        </a>
                    </li> --}}
                    <li class="sidebar-item {{ request()->routeIs('pelapor.riwayat.*') ? 'active' : '' }}">
                        <a href="{{ route('pelapor.riwayat.index') }}" class='sidebar-link'>
                            <i class="bi bi-clock-history"></i>
                            <span>Riwayat Laporan</span>
                        </a>
                    </li>

                @endif

                <!-- Menu untuk Sarana Prasarana (SPR) -->
                @if(Auth::user()->level->level_kode === 'SPR')
                            <li class="sidebar-title">Sarana Prasarana</li>

                            <li class="sidebar-item {{ request()->routeIs('sarpras.laporan.*') ? 'active' : '' }}">
                                <a href="{{ route('sarpras.laporan.index') }}" class='sidebar-link'>
                                    <i class="bi bi-inboxes"></i>
                                    <span>Kelola Laporan</span>
                                </a>
                            </li>


                            <li
                                class="sidebar-item has-sub
                                                                                                                                                                                                                {{
                    request()->routeIs('sarpras.rekomendasi.*') ||
                    request()->routeIs('sarpras.rekomendasi-mahasiswa.*') ||
                    request()->routeIs('sarpras.rekomendasi-dosen.*') ||
                    request()->routeIs(patterns: 'sarpras.rekomendasi-tendik.*')
                    ? 'active'
                    : ''
                                                                                                                                                                                                                }}">
                                <a href="#" class='sidebar-link'>
                                    <i class="bi bi-lightbulb"></i>
                                    <span>Rekomendasi Laporan</span>
                                </a>
                                <ul class="submenu">
                                    <li class="submenu-item {{ request()->routeIs('sarpras.rekomendasi.*') ? 'active' : '' }}">
                                        <a href="{{ route('sarpras.rekomendasi.index') }}">Semua</a>
                                    </li>
                                    <li
                                        class="submenu-item {{ request()->routeIs('pelapor.rekomendasi-mahasiswa.*') ? 'active' : '' }}">
                                        <a href="{{ route('sarpras.rekomendasi-mahasiswa.index') }}">Mahasiswa</a>
                                    </li>
                                    <li
                                        class="submenu-item {{ request()->routeIs('pelapor.rekomendasi-dosen.*') ? 'active' : '' }}">
                                        <a href="{{ route('sarpras.rekomendasi-dosen.index') }}">Dosen</a>
                                    </li>
                                    <li
                                        class="submenu-item {{ request()->routeIs('pelapor.rekomendasi-tendik.*') ? 'active' : '' }}">
                                        <a href="{{ route('sarpras.rekomendasi-tendik.index') }}">Tendik</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-item {{ request()->routeIs('sarpras.riwayat.*') ? 'active' : '' }}">
                                <a href="{{ route('sarpras.riwayat.index') }}" class='sidebar-link'>
                                    <i class="bi bi-journal-text"></i>
                                    <span>Riwayat Penugasan</span>
                                </a>
                            </li>



                            <li class="sidebar-item {{ request()->routeIs('sarpras.prioritas.*') ? 'active' : '' }}">
                                {{-- <a href="{{ route('sarpras.prioritas.index') }}" class='sidebar-link'>
                                    <i class="bi bi-exclamation-triangle"></i>
                                    <span>rekomendasi Laporan</span>
                                </a> --}}
                            </li>

                            <li class="sidebar-item {{ request()->routeIs('sarpras.penugasan.*') ? 'active' : '' }}">
                                {{-- <a href="{{ route('sarpras.penugasan.index') }}" class='sidebar-link'>
                                    <i class="bi bi-person-workspace"></i>
                                    <span>Penugasan Teknisi</span>
                                </a> --}}
                            </li>

                @endif

                <!-- Menu untuk Teknisi -->
                @if(Auth::user()->level->level_kode === 'TKN')
                    <li class="sidebar-title">Perbaikan</li>

                    <li class="sidebar-item {{ request()->routeIs('teknisi.perbaikan.*') ? 'active' : '' }}">
                        <a href="{{ route('teknisi.perbaikan.index') }}" class='sidebar-link'>
                            <i class="bi bi-tools"></i>
                            <span>Daftar Perbaikan</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('teknisi.riwayat.*') ? 'active' : '' }}">
                        <a href="{{ route('teknisi.riwayat.index') }}" class='sidebar-link'>
                            <i class="bi bi-journal-check"></i>
                            <span>Riwayat Perbaikan</span>
                        </a>
                    </li>
                @endif
                <!-- Menu Umum untuk Semua Role -->
                <li class="sidebar-title">Akun</li>

                {{-- <li class="sidebar-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <a href="{{ route('profile.edit') }}" class='sidebar-link'>
                        <i class="bi bi-person-circle"></i>
                        <span>Profil Saya</span>
                    </a>
                </li> --}}

                <li class="sidebar-item">
                    <form method="GET" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class='sidebar-link'
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Keluar</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>