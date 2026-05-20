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
          <a class="nav-link {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('fasilitas-kesehatan.*') || request()->routeIs('wilaya-dinkes.*') || request()->routeIs('hasil-lab-ibu.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') || request()->routeIs('faqs.*') ? '' : 'collapsed' }}" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-database"></i><span>Data Master</span><i class="bi bi-chevron-down ms-auto fs-5"></i>
          </a>
          <ul id="master-nav" class="nav-content collapse {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('fasilitas-kesehatan.*') || request()->routeIs('wilaya-dinkes.*') || request()->routeIs('hasil-lab-ibu.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') || request()->routeIs('faqs.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Data User</span></a></li>
            <li><a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Data Role</span></a></li>
            <li><a href="{{ route('fasilitas-kesehatan.index') }}" class="{{ request()->routeIs('fasilitas-kesehatan.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Fasilitas Kesehatan</span></a></li>
            <li><a href="{{ route('wilaya-dinkes.index') }}" class="{{ request()->routeIs('wilaya-dinkes.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Wilayah Dinkes</span></a></li>
            <li><a href="#"><i class="bi bi-circle"></i><span>Kategori Artikel</span></a></li>
            <li><a href="{{ route('hasil-lab-ibu.index') }}" class="{{ request()->routeIs('hasil-lab-ibu.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Hasil Lab Ibu</span></a></li>
            <li><a href="{{ route('bayi-baru-lahir.index') }}" class="{{ request()->routeIs('bayi-baru-lahir.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Bayi Baru Lahir</span></a></li>
            <li><a href="{{ route('imunisasi-anak.index') }}" class="{{ request()->routeIs('imunisasi-anak.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Imunisasi Anak</span></a></li>
            <li><a href="{{ route('tumbuh-kembang.index') }}" class="{{ request()->routeIs('tumbuh-kembang.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Tumbuh Kembang</span></a></li>
            <li><a href="{{ route('perkembangan-sidtk.index') }}" class="{{ request()->routeIs('perkembangan-sidtk.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Perkembangan SIDTK</span></a></li>
            <li><a href="{{ route('mpasi.index') }}" class="{{ request()->routeIs('mpasi.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>MPASI</span></a></li>
            <li><a href="{{ route('faqs.index') }}" class="{{ request()->routeIs('faqs.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Data FAQ</span></a></li>
          </ul>
        </li>

        {{-- Buku KIA Dropdown --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('buku-kia.*') || request()->routeIs('kunjungan-anc.*') || request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('profil-anak.*') || request()->routeIs('pembiayaan.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') || request()->routeIs('dokumen.*') ? '' : 'collapsed' }}"
             data-bs-target="#buku-kia-admin-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-book"></i><span>Buku KIA</span><i class="bi bi-chevron-down ms-auto fs-5"></i>
          </a>
          <ul id="buku-kia-admin-nav" class="nav-content collapse {{ request()->routeIs('buku-kia.*') || request()->routeIs('kunjungan-anc.*') || request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('profil-anak.*') || request()->routeIs('pembiayaan.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') || request()->routeIs('dokumen.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('buku-kia.index') }}" class="{{ request()->routeIs('buku-kia.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Buku KIA</span></a></li>
            <li><a href="{{ route('kunjungan-anc.index') }}" class="{{ request()->routeIs('kunjungan-anc.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Kunjungan ANC</span></a></li>
            <li><a href="{{ route('profil-ibu.index') }}" class="{{ request()->routeIs('profil-ibu.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Profil Ibu</span></a></li>
            <li><a href="{{ route('profil-suami.index') }}" class="{{ request()->routeIs('profil-suami.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Profil Suami</span></a></li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('profil-anak.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? '' : 'collapsed' }}"
                 data-bs-target="#profil-anak-admin-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-circle"></i><span>Profil Anak</span><i class="bi bi-chevron-down ms-auto fs-5"></i>
              </a>
              <ul id="profil-anak-admin-nav" class="nav-content collapse {{ request()->routeIs('profil-anak.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? 'show' : '' }}">
                <li><a href="{{ route('profil-anak.index') }}" class="{{ request()->routeIs('profil-anak.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Informasi Detail</span></a></li>
                <li><a href="{{ route('bayi-baru-lahir.index') }}" class="{{ request()->routeIs('bayi-baru-lahir.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Bayi Baru Lahir</span></a></li>
                <li><a href="{{ route('imunisasi-anak.index') }}" class="{{ request()->routeIs('imunisasi-anak.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Imunisasi</span></a></li>
                <li><a href="{{ route('tumbuh-kembang.index') }}" class="{{ request()->routeIs('tumbuh-kembang.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Tumbuh Kembang</span></a></li>
                <li><a href="{{ route('perkembangan-sidtk.index') }}" class="{{ request()->routeIs('perkembangan-sidtk.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>SIDTK</span></a></li>
                <li><a href="{{ route('mpasi.index') }}" class="{{ request()->routeIs('mpasi.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>MPASI</span></a></li>
              </ul>
            </li>
            <li><a href="{{ route('pembiayaan.index') }}" class="{{ request()->routeIs('pembiayaan.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Pembiayaan</span></a></li>
            <li><a href="{{ route('pemantauan-nifas.index') }}" class="{{ request()->routeIs('pemantauan-nifas.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Pemantauan Nifas</span></a></li>
            <li><a href="{{ route('kb-pasca-salin.index') }}" class="{{ request()->routeIs('kb-pasca-salin.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>KB Pasca Salin</span></a></li>
            <li><a href="{{ route('dokumen.index') }}" class="{{ request()->routeIs('dokumen.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Dokumen Pasien</span></a></li>
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

        {{-- Buku KIA Dropdown --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('buku-kia.*') || request()->routeIs('kunjungan-anc.*') || request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('profil-anak.*') || request()->routeIs('pembiayaan.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') || request()->routeIs('dokumen.*') ? '' : 'collapsed' }}"
             data-bs-target="#buku-kia-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-book"></i><span>Buku KIA</span><i class="bi bi-chevron-down ms-auto fs-5"></i>
          </a>
          <ul id="buku-kia-nav" class="nav-content collapse {{ request()->routeIs('buku-kia.*') || request()->routeIs('kunjungan-anc.*') || request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('profil-anak.*') || request()->routeIs('pembiayaan.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') || request()->routeIs('dokumen.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('buku-kia.index') }}" class="{{ request()->routeIs('buku-kia.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Buku KIA</span></a></li>
            <li><a href="{{ route('kunjungan-anc.index') }}" class="{{ request()->routeIs('kunjungan-anc.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Kunjungan ANC</span></a></li>
            <li><a href="{{ route('profil-ibu.index') }}" class="{{ request()->routeIs('profil-ibu.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Ibu</span></a></li>
            <li><a href="{{ route('profil-suami.index') }}" class="{{ request()->routeIs('profil-suami.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Suami</span></a></li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('profil-anak.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? '' : 'collapsed' }}"
                 data-bs-target="#profil-anak-nakes-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-circle"></i><span>Profil Anak</span><i class="bi bi-chevron-down ms-auto fs-5"></i>
              </a>
              <ul id="profil-anak-nakes-nav" class="nav-content collapse {{ request()->routeIs('profil-anak.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? 'show' : '' }}">
                <li><a href="{{ route('profil-anak.index') }}" class="{{ request()->routeIs('profil-anak.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Informasi Detail</span></a></li>
                <li><a href="{{ route('bayi-baru-lahir.index') }}" class="{{ request()->routeIs('bayi-baru-lahir.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Bayi Baru Lahir</span></a></li>
                <li><a href="{{ route('imunisasi-anak.index') }}" class="{{ request()->routeIs('imunisasi-anak.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Imunisasi</span></a></li>
                <li><a href="{{ route('tumbuh-kembang.index') }}" class="{{ request()->routeIs('tumbuh-kembang.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Tumbuh Kembang</span></a></li>
                <li><a href="{{ route('perkembangan-sidtk.index') }}" class="{{ request()->routeIs('perkembangan-sidtk.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>SIDTK</span></a></li>
                <li><a href="{{ route('mpasi.index') }}" class="{{ request()->routeIs('mpasi.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>MPASI</span></a></li>
              </ul>
            </li>
            <li><a href="{{ route('pembiayaan.index') }}" class="{{ request()->routeIs('pembiayaan.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Biaya</span></a></li>
            <li><a href="{{ route('pemantauan-nifas.index') }}" class="{{ request()->routeIs('pemantauan-nifas.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Pemantauan Nifas</span></a></li>
            <li><a href="{{ route('kb-pasca-salin.index') }}" class="{{ request()->routeIs('kb-pasca-salin.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>KB Pasca Salin</span></a></li>
            <li><a href="{{ route('dokumen.index') }}" class="{{ request()->routeIs('dokumen.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Dokumen</span></a></li>
          </ul>
        </li>

        {{-- Pemeriksaan Ibu --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('hasil-lab-ibu.*') ? '' : 'collapsed' }}"
             data-bs-target="#pemeriksaan-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-clipboard2-pulse"></i><span>Pemeriksaan Ibu</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="pemeriksaan-nav" class="nav-content collapse {{ request()->routeIs('hasil-lab-ibu.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('hasil-lab-ibu.index') }}" class="{{ request()->routeIs('hasil-lab-ibu.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Hasil Lab Ibu</span></a></li>
            <li><a href="#" class="text-muted"><i class="bi bi-circle"></i><span>Pencatatan TTD/MMS</span></a></li>
            <li><a href="#" class="text-muted"><i class="bi bi-circle"></i><span>Data Persalinan</span></a></li>
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

        {{-- Buku KIA Saya Dropdown --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('buku-kia.*') || request()->routeIs('kunjungan-anc.*') || request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('profil-anak.*') || request()->routeIs('pembiayaan.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') || request()->routeIs('dokumen.*') ? '' : 'collapsed' }}"
             data-bs-target="#buku-kia-ibu-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-journal-check"></i><span>Buku KIA Saya</span><i class="bi bi-chevron-down ms-auto fs-5"></i>
          </a>
          <ul id="buku-kia-ibu-nav" class="nav-content collapse {{ request()->routeIs('buku-kia.*') || request()->routeIs('kunjungan-anc.*') || request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('profil-anak.*') || request()->routeIs('pembiayaan.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') || request()->routeIs('dokumen.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('buku-kia.index') }}" class="{{ request()->routeIs('buku-kia.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Buku KIA Saya</span></a></li>
            <li><a href="{{ route('kunjungan-anc.index') }}" class="{{ request()->routeIs('kunjungan-anc.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Kunjungan ANC</span></a></li>
            <li><a href="{{ route('profil-ibu.index') }}" class="{{ request()->routeIs('profil-ibu.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Ibu</span></a></li>
            <li><a href="{{ route('profil-suami.index') }}" class="{{ request()->routeIs('profil-suami.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Suami</span></a></li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('profil-anak.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? '' : 'collapsed' }}"
                 data-bs-target="#profil-anak-ibu-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-circle"></i><span>Profil Anak</span><i class="bi bi-chevron-down ms-auto fs-5"></i>
              </a>
              <ul id="profil-anak-ibu-nav" class="nav-content collapse {{ request()->routeIs('profil-anak.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? 'show' : '' }}">
                <li><a href="{{ route('profil-anak.index') }}" class="{{ request()->routeIs('profil-anak.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Informasi Detail</span></a></li>
                <li><a href="{{ route('bayi-baru-lahir.index') }}" class="{{ request()->routeIs('bayi-baru-lahir.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Bayi Baru Lahir</span></a></li>
                <li><a href="{{ route('imunisasi-anak.index') }}" class="{{ request()->routeIs('imunisasi-anak.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Imunisasi</span></a></li>
                <li><a href="{{ route('tumbuh-kembang.index') }}" class="{{ request()->routeIs('tumbuh-kembang.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Tumbuh Kembang</span></a></li>
                <li><a href="{{ route('perkembangan-sidtk.index') }}" class="{{ request()->routeIs('perkembangan-sidtk.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>SIDTK</span></a></li>
                <li><a href="{{ route('mpasi.index') }}" class="{{ request()->routeIs('mpasi.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>MPASI</span></a></li>
              </ul>
            </li>
            <li><a href="{{ route('pembiayaan.index') }}" class="{{ request()->routeIs('pembiayaan.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Biaya</span></a></li>
            <li><a href="{{ route('pemantauan-nifas.index') }}" class="{{ request()->routeIs('pemantauan-nifas.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Pemantauan Nifas</span></a></li>
            <li><a href="{{ route('kb-pasca-salin.index') }}" class="{{ request()->routeIs('kb-pasca-salin.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>KB Pasca Salin</span></a></li>
            <li><a href="{{ route('dokumen.index') }}" class="{{ request()->routeIs('dokumen.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Dokumen</span></a></li>
          </ul>
        </li>

        {{-- Fasilitas Kesehatan --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('fasilitas-kesehatan.*') ? '' : 'collapsed' }}" href="{{ route('fasilitas-kesehatan.index') }}">
            <i class="bi bi-hospital"></i><span>Fasilitas Kesehatan</span>
          </a>
        </li>

        {{-- Hasil Lab Ibu --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('hasil-lab-ibu.*') ? '' : 'collapsed' }}" href="{{ route('hasil-lab-ibu.index') }}">
            <i class="bi bi-clipboard2-pulse"></i><span>Hasil Lab Ibu</span>
          </a>
        </li>

        {{-- Kesehatan Anak --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? '' : 'collapsed' }}"
             data-bs-target="#anak-ibu-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-emoji-smile"></i><span>Kesehatan Anak</span><i class="bi bi-chevron-down ms-auto fs-5"></i>
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
        <a class="nav-link collapsed" href="{{ route('logout') }}">
          <i class="bi bi-box-arrow-right"></i>
          <span>Keluar</span>
        </a>
      </li>

    </ul>

  </aside><!-- End Sidebar-->
