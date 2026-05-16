  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      @if(Auth::user()->role->nama_role == 'administrator')
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
            <li><a href="#"><i class="bi bi-circle"></i><span>Kategori Artikel</span></a></li>
            <li><a href="#"><i class="bi bi-circle"></i><span>Jenis Pembiayaan</span></a></li>
            <li><a href="{{ route('faqs.index') }}"><i class="bi bi-circle"></i><span>Data FAQ</span></a></li>
          </ul>
        </li>
      @endif

      @if(Auth::user()->role->nama_role == 'dinas kesehatan')
        <li class="nav-heading">Dinas Kesehatan</li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#"><i class="bi bi-graph-up-arrow"></i><span>Statistik KIA Wilayah</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#"><i class="bi bi-building"></i><span>Monitoring Faskes</span></a>
        </li>
      @endif

      @if(Auth::user()->role->nama_role == 'nakes')
        <li class="nav-heading">Tenaga Kesehatan</li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="{{ route('buku-kia.index') }}"><i class="bi bi-book"></i><span>Manajemen Buku KIA</span></a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#pasien-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-people"></i><span>Data Pasien</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="pasien-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('profil-ibu.index') }}"><i class="bi bi-circle"></i><span>Profil Ibu</span></a></li>
            <li><a href="{{ route('profil-suami.index') }}"><i class="bi bi-circle"></i><span>Profil Suami</span></a></li>
            <li><a href="{{ route('profil-anak.index') }}"><i class="bi bi-circle"></i><span>Profil Anak</span></a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#pemeriksaan-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-clipboard2-pulse"></i><span>Pemeriksaan Ibu</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="pemeriksaan-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li><a href="#"><i class="bi bi-circle"></i><span>Kunjungan ANC</span></a></li>
            <li><a href="#"><i class="bi bi-circle"></i><span>Hasil Lab Ibu</span></a></li>
            <li><a href="#"><i class="bi bi-circle"></i><span>Pencatatan TTD</span></a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#persalinan-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-heart-pulse"></i><span>Persalinan & Nifas</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="persalinan-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li><a href="#"><i class="bi bi-circle"></i><span>Data Persalinan</span></a></li>
            <li><a href="#"><i class="bi bi-circle"></i><span>Pemantauan Nifas</span></a></li>
            <li><a href="#"><i class="bi bi-circle"></i><span>KB Pasca Salin</span></a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#anak-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-child"></i><span>Kesehatan Anak</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="anak-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li><a href="#"><i class="bi bi-circle"></i><span>Bayi Baru Lahir</span></a></li>
            <li><a href="#"><i class="bi bi-circle"></i><span>Imunisasi Anak</span></a></li>
          </ul>
        </li>
      @endif

      @if(Auth::user()->role->nama_role == 'ibu hamil')
        <li class="nav-heading">Ibu Hamil</li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="{{ route('buku-kia.index') }}"><i class="bi bi-journal-check"></i><span>Buku KIA Saya</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="{{ route('profil-ibu.index') }}"><i class="bi bi-person-heart"></i><span>Profil Ibu</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="{{ route('profil-suami.index') }}"><i class="bi bi-person-badge"></i><span>Profil Suami</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="{{ route('profil-anak.index') }}"><i class="bi bi-person-hearts"></i><span>Profil Anak</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#"><i class="bi bi-calendar-check"></i><span>Riwayat Pemeriksaan</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#"><i class="bi bi-emoji-smile"></i><span>Kesehatan Anak</span></a>
        </li>
      @endif

      <li class="nav-heading">Layanan</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-chat-dots"></i>
          <span>Konsultasi Online</span>
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
