  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      @if(optional(Auth::user()->role)->nama_role == 'administrator')
        <li class="nav-heading">Administrator</li>

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-database"></i><span>Data Master</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('users.index') }}"><i class="bi bi-circle"></i><span>Data User</span></a></li>
            <li><a href="{{ route('profil-ibu.index') }}"><i class="bi bi-circle"></i><span>Profil Ibu</span></a></li>
            <li><a href="{{ route('profil-suami.index') }}"><i class="bi bi-circle"></i><span>Profil Suami</span></a></li>
            <li><a href="{{ route('profil-anak.index') }}"><i class="bi bi-circle"></i><span>Profil Anak</span></a></li>
            <li><a href="{{ route('buku-kia.index') }}"><i class="bi bi-circle"></i><span>Buku KIA</span></a></li>
            <li><a href="{{ route('roles.index') }}"><i class="bi bi-circle"></i><span>Data Role</span></a></li>
            <li><a href="{{ route('fasilitas-kesehatan.index') }}"><i class="bi bi-circle"></i><span>Fasilitas Kesehatan</span></a></li>
            <li><a href="{{ route('wilaya-dinkes.index') }}"><i class="bi bi-circle"></i><span>Wilayah Dinkes</span></a></li>
            <li><a href="#"><i class="bi bi-circle"></i><span>Kategori Artikel</span></a></li>
            <li><a href="{{ route('pembiayaan.index') }}"><i class="bi bi-circle"></i><span>Pembiayaan</span></a></li>
            <li><a href="{{ route('dokumen.index') }}"><i class="bi bi-circle"></i><span>Dokumen Pasien</span></a></li>
            <li><a href="{{ route('kb-pasca-salin.index') }}" class="{{ request()->routeIs('kb-pasca-salin.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>KB Pasca Salin</span></a></li>
            <li><a href="{{ route('pemantauan-nifas.index') }}" class="{{ request()->routeIs('pemantauan-nifas.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Pemantauan Nifas</span></a></li>
            <li><a href="{{ route('kunjungan-anc.index') }}" class="{{ request()->routeIs('kunjungan-anc.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Kunjungan ANC</span></a></li>
            <li><a href="{{ route('hasil-lab-ibu.index') }}" class="{{ request()->routeIs('hasil-lab-ibu.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Hasil Lab Ibu</span></a></li>
            <li><a href="{{ route('bayi-baru-lahir.index') }}" class="{{ request()->routeIs('bayi-baru-lahir.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Bayi Baru Lahir</span></a></li>
            <li><a href="{{ route('imunisasi-anak.index') }}" class="{{ request()->routeIs('imunisasi-anak.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Imunisasi Anak</span></a></li>
            <li><a href="{{ route('tumbuh-kembang.index') }}" class="{{ request()->routeIs('tumbuh-kembang.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Tumbuh Kembang</span></a></li>
            <li><a href="{{ route('perkembangan-sidtk.index') }}" class="{{ request()->routeIs('perkembangan-sidtk.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Perkembangan SIDTK</span></a></li>
            <li><a href="{{ route('mpasi.index') }}" class="{{ request()->routeIs('mpasi.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>MPASI</span></a></li>
            <li><a href="{{ route('faqs.index') }}"><i class="bi bi-circle"></i><span>Data FAQ</span></a></li>
          </ul>
        </li>

        <li class="nav-heading">Laporan & Monitoring</li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('laporan.statistik') ? '' : 'collapsed' }}" href="{{ route('laporan.statistik') }}">
            <i class="bi bi-graph-up-arrow"></i><span>Statistik KIA Wilayah</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('laporan.monitoring-faskes') ? '' : 'collapsed' }}" href="{{ route('laporan.monitoring-faskes') }}">
            <i class="bi bi-building"></i><span>Monitoring Faskes</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('laporan.monitoring-buku-kia') ? '' : 'collapsed' }}" href="{{ route('laporan.monitoring-buku-kia') }}">
            <i class="bi bi-book"></i><span>Monitoring Buku KIA</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('laporan.monitoring-imunisasi') ? '' : 'collapsed' }}" href="{{ route('laporan.monitoring-imunisasi') }}">
            <i class="bi bi-shield-plus"></i><span>Monitoring Imunisasi</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('laporan.monitoring-gizi-balita') ? '' : 'collapsed' }}" href="{{ route('laporan.monitoring-gizi-balita') }}">
            <i class="bi bi-heart-pulse"></i><span>Monitoring Gizi Balita</span>
          </a>
        </li>
      @endif

      @if(optional(Auth::user()->role)->nama_role == 'dinas kesehatan')
        <li class="nav-heading">Dinas Kesehatan</li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('laporan.statistik') ? '' : 'collapsed' }}" href="{{ route('laporan.statistik') }}">
            <i class="bi bi-graph-up-arrow"></i><span>Statistik KIA Wilayah</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('laporan.monitoring-faskes') ? '' : 'collapsed' }}" href="{{ route('laporan.monitoring-faskes') }}">
            <i class="bi bi-building"></i><span>Monitoring Faskes</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('laporan.monitoring-buku-kia') ? '' : 'collapsed' }}" href="{{ route('laporan.monitoring-buku-kia') }}">
            <i class="bi bi-book"></i><span>Monitoring Buku KIA</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('laporan.monitoring-imunisasi') ? '' : 'collapsed' }}" href="{{ route('laporan.monitoring-imunisasi') }}">
            <i class="bi bi-shield-plus"></i><span>Monitoring Imunisasi</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('laporan.monitoring-gizi-balita') ? '' : 'collapsed' }}" href="{{ route('laporan.monitoring-gizi-balita') }}">
            <i class="bi bi-heart-pulse"></i><span>Monitoring Gizi Balita</span>
          </a>
        </li>
      @endif

      @if(optional(Auth::user()->role)->nama_role == 'nakes')
        <li class="nav-heading">Tenaga Kesehatan</li>

        {{-- Manajemen Buku KIA --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('buku-kia.*') ? '' : 'collapsed' }}" href="{{ route('buku-kia.index') }}">
            <i class="bi bi-book"></i><span>Manajemen Buku KIA</span>
          </a>
        </li>

        {{-- Data Pasien --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('profil-anak.*') ? '' : 'collapsed' }}"
             data-bs-target="#pasien-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-people"></i><span>Data Pasien</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="pasien-nav" class="nav-content collapse {{ request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('profil-anak.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('profil-ibu.index') }}" class="{{ request()->routeIs('profil-ibu.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Profil Ibu</span></a></li>
            <li><a href="{{ route('profil-suami.index') }}" class="{{ request()->routeIs('profil-suami.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Profil Suami</span></a></li>
            <li><a href="{{ route('profil-anak.index') }}" class="{{ request()->routeIs('profil-anak.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Profil Anak</span></a></li>
          </ul>
        </li>

        {{-- Pembiayaan & Dokumen --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('pembiayaan.*') ? '' : 'collapsed' }}" href="{{ route('pembiayaan.index') }}">
            <i class="bi bi-credit-card"></i><span>Pembiayaan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('dokumen.*') ? '' : 'collapsed' }}" href="{{ route('dokumen.index') }}">
            <i class="bi bi-file-earmark-pdf"></i><span>Manajemen Dokumen</span>
          </a>
        </li>

        {{-- Pemeriksaan Ibu --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('kunjungan-anc.*') || request()->routeIs('hasil-lab-ibu.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') ? '' : 'collapsed' }}"
             data-bs-target="#pemeriksaan-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-clipboard2-pulse"></i><span>Pemeriksaan Ibu</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="pemeriksaan-nav" class="nav-content collapse {{ request()->routeIs('kunjungan-anc.*') || request()->routeIs('hasil-lab-ibu.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('kunjungan-anc.index') }}" class="{{ request()->routeIs('kunjungan-anc.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Kunjungan ANC</span></a></li>
            <li><a href="{{ route('hasil-lab-ibu.index') }}" class="{{ request()->routeIs('hasil-lab-ibu.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Hasil Lab Ibu</span></a></li>
            <li><a href="#" class="text-muted"><i class="bi bi-circle"></i><span>Pencatatan TTD/MMS</span></a></li>
            <li><a href="#" class="text-muted"><i class="bi bi-circle"></i><span>Data Persalinan</span></a></li>
            <li><a href="{{ route('pemantauan-nifas.index') }}" class="{{ request()->routeIs('pemantauan-nifas.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Pemantauan Nifas</span></a></li>
            <li><a href="{{ route('kb-pasca-salin.index') }}" class="{{ request()->routeIs('kb-pasca-salin.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>KB Pasca Salin</span></a></li>
          </ul>
        </li>

        {{-- Kesehatan Anak --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? '' : 'collapsed' }}"
             data-bs-target="#anak-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-emoji-heart-eyes"></i><span>Kesehatan Anak</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="anak-nav" class="nav-content collapse {{ request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('bayi-baru-lahir.index') }}" class="{{ request()->routeIs('bayi-baru-lahir.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Bayi Baru Lahir</span></a></li>
            <li><a href="{{ route('imunisasi-anak.index') }}" class="{{ request()->routeIs('imunisasi-anak.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Imunisasi Anak</span></a></li>
            <li><a href="{{ route('tumbuh-kembang.index') }}" class="{{ request()->routeIs('tumbuh-kembang.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Tumbuh Kembang</span></a></li>
            <li><a href="{{ route('perkembangan-sidtk.index') }}" class="{{ request()->routeIs('perkembangan-sidtk.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Perkembangan SIDTK</span></a></li>
            <li><a href="{{ route('mpasi.index') }}" class="{{ request()->routeIs('mpasi.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>MPASI</span></a></li>
          </ul>
        </li>
      @endif

      @if(optional(Auth::user()->role)->nama_role == 'ibu hamil')
        <li class="nav-heading">Ibu Hamil</li>

        {{-- Buku KIA --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('buku-kia.*') ? '' : 'collapsed' }}" href="{{ route('buku-kia.index') }}">
            <i class="bi bi-journal-check"></i><span>Buku KIA Saya</span>
          </a>
        </li>

        {{-- Profil Keluarga --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('profil-anak.*') ? '' : 'collapsed' }}"
             data-bs-target="#keluarga-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-house-heart"></i><span>Profil Keluarga</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="keluarga-nav" class="nav-content collapse {{ request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('profil-anak.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('profil-ibu.index') }}" class="{{ request()->routeIs('profil-ibu.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Profil Ibu</span></a></li>
            <li><a href="{{ route('profil-suami.index') }}" class="{{ request()->routeIs('profil-suami.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Profil Suami</span></a></li>
            <li><a href="{{ route('profil-anak.index') }}" class="{{ request()->routeIs('profil-anak.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Profil Anak</span></a></li>
          </ul>
        </li>

        {{-- Pembiayaan --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('pembiayaan.*') ? '' : 'collapsed' }}" href="{{ route('pembiayaan.index') }}">
            <i class="bi bi-credit-card"></i><span>Pembiayaan Saya</span>
          </a>
        </li>

        {{-- Dokumen --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('dokumen.*') ? '' : 'collapsed' }}" href="{{ route('dokumen.index') }}">
            <i class="bi bi-file-earmark-medical"></i><span>Dokumen Saya</span>
          </a>
        </li>

        {{-- Fasilitas Kesehatan --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('fasilitas-kesehatan.*') ? '' : 'collapsed' }}" href="{{ route('fasilitas-kesehatan.index') }}">
            <i class="bi bi-hospital"></i><span>Fasilitas Kesehatan</span>
          </a>
        </li>

        {{-- Riwayat Pemeriksaan --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('kunjungan-anc.*') || request()->routeIs('hasil-lab-ibu.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') ? '' : 'collapsed' }}"
             data-bs-target="#riwayat-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-calendar-check"></i><span>Riwayat Pemeriksaan</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="riwayat-nav" class="nav-content collapse {{ request()->routeIs('kunjungan-anc.*') || request()->routeIs('hasil-lab-ibu.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('kunjungan-anc.index') }}" class="{{ request()->routeIs('kunjungan-anc.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Kunjungan ANC</span></a></li>
            <li><a href="{{ route('hasil-lab-ibu.index') }}" class="{{ request()->routeIs('hasil-lab-ibu.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Hasil Lab Ibu</span></a></li>
            <li><a href="{{ route('pemantauan-nifas.index') }}" class="{{ request()->routeIs('pemantauan-nifas.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Pemantauan Nifas</span></a></li>
            <li><a href="{{ route('kb-pasca-salin.index') }}" class="{{ request()->routeIs('kb-pasca-salin.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>KB Pasca Salin</span></a></li>
          </ul>
        </li>

        {{-- Kesehatan Anak --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? '' : 'collapsed' }}"
             data-bs-target="#anak-ibu-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-emoji-smile"></i><span>Kesehatan Anak</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="anak-ibu-nav" class="nav-content collapse {{ request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('bayi-baru-lahir.index') }}" class="{{ request()->routeIs('bayi-baru-lahir.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Bayi Baru Lahir</span></a></li>
            <li><a href="{{ route('imunisasi-anak.index') }}" class="{{ request()->routeIs('imunisasi-anak.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Imunisasi Anak</span></a></li>
            <li><a href="{{ route('tumbuh-kembang.index') }}" class="{{ request()->routeIs('tumbuh-kembang.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Tumbuh Kembang</span></a></li>
            <li><a href="{{ route('perkembangan-sidtk.index') }}" class="{{ request()->routeIs('perkembangan-sidtk.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Perkembangan SIDTK</span></a></li>
            <li><a href="{{ route('mpasi.index') }}" class="{{ request()->routeIs('mpasi.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>MPASI</span></a></li>
          </ul>
        </li>
      @endif

      <li class="nav-heading">Layanan</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('konsultasi-online.*') ? '' : 'collapsed' }}" href="{{ route('konsultasi-online.index') }}">
          <i class="bi bi-chat-dots"></i>
          <span>Konsultasi Online</span>
          <span id="konsultasi-unread-badge" class="badge bg-danger rounded-pill ms-auto d-none" style="font-size: 10px; padding: 3px 6px;">0</span>
        </a>
      </li>

      <li class="nav-heading">Akun</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-person"></i>
          <span>Profil Saya</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('logout') }}">
          <i class="bi bi-box-arrow-right"></i>
          <span>Keluar</span>
        </a>
      </li>

    </ul>

  </aside><!-- End Sidebar-->
