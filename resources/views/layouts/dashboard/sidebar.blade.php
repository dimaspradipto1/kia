  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}"
                  href="{{ route('dashboard') }}">
                  <i class="bi bi-grid"></i>
                  <span>Dashboard</span>
              </a>
          </li><!-- End Dashboard Nav -->

          @if (optional(Auth::user()->role)->nama_role == 'administrator')
              <li class="nav-heading">Administrator</li>

              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('fasilitas-kesehatan.*') || request()->routeIs('wilaya-dinkes.*') || request()->routeIs('kategori-artikel.*') || request()->routeIs('artikel-edukasi.*') || request()->routeIs('hasil-lab-ibu.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? '' : 'collapsed' }}"
                      data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
                      <i class="bi bi-database"></i><span>Data Master</span><i
                          class="bi bi-chevron-down ms-auto fs-5"></i>
                  </a>
                  <ul id="master-nav"
                      class="nav-content collapse {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('fasilitas-kesehatan.*') || request()->routeIs('wilaya-dinkes.*') || request()->routeIs('kategori-artikel.*') || request()->routeIs('artikel-edukasi.*') || request()->routeIs('hasil-lab-ibu.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? 'show' : '' }}"
                      data-bs-parent="#sidebar-nav">
                      <li><a href="{{ route('users.index') }}"
                              class="{{ request()->routeIs('users.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Data User</span></a></li>
                      <li><a href="{{ route('roles.index') }}"
                              class="{{ request()->routeIs('roles.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Data Role</span></a></li>
                      <li><a href="{{ route('fasilitas-kesehatan.index') }}"
                              class="{{ request()->routeIs('fasilitas-kesehatan.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Fasilitas Kesehatan</span></a></li>
                      <li><a href="{{ route('wilaya-dinkes.index') }}"
                              class="{{ request()->routeIs('wilaya-dinkes.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Wilayah Dinkes</span></a></li>
                      <li><a href="{{ route('hasil-lab-ibu.index') }}"
                              class="{{ request()->routeIs('hasil-lab-ibu.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Hasil Lab Ibu</span></a></li>
                      <li><a href="{{ route('bayi-baru-lahir.index') }}"
                              class="{{ request()->routeIs('bayi-baru-lahir.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Bayi Baru Lahir</span></a></li>
                      <li><a href="{{ route('imunisasi-anak.index') }}"
                              class="{{ request()->routeIs('imunisasi-anak.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Imunisasi Anak</span></a></li>
                      <li><a href="{{ route('tumbuh-kembang.index') }}"
                              class="{{ request()->routeIs('tumbuh-kembang.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Tumbuh Kembang</span></a></li>
                      <li><a href="{{ route('perkembangan-sidtk.index') }}"
                              class="{{ request()->routeIs('perkembangan-sidtk.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Perkembangan SIDTK</span></a></li>
                      <li><a href="{{ route('mpasi.index') }}"
                              class="{{ request()->routeIs('mpasi.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>MPASI</span></a></li>
                  </ul>
              </li>

              {{-- Buku KIA Dropdown --}}
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('buku-kia.*') || request()->routeIs('kunjungan-anc.*') || request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('pembiayaan.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') || request()->routeIs('dokumen.*') ? '' : 'collapsed' }}"
                      data-bs-target="#buku-kia-admin-nav" data-bs-toggle="collapse" href="#">
                      <i class="bi bi-book"></i><span>Buku KIA</span><i class="bi bi-chevron-down ms-auto fs-5"></i>
                  </a>
                  <ul id="buku-kia-admin-nav"
                      class="nav-content collapse {{ request()->routeIs('buku-kia.*') || request()->routeIs('kunjungan-anc.*') || request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('pembiayaan.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') || request()->routeIs('dokumen.*') ? 'show' : '' }}"
                      data-bs-parent="#sidebar-nav">
                      <li><a href="{{ route('buku-kia.index') }}"
                              class="{{ request()->routeIs('buku-kia.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Buku KIA</span></a></li>
                      <li><a href="{{ route('kunjungan-anc.index') }}"
                              class="{{ request()->routeIs('kunjungan-anc.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Kunjungan ANC</span></a></li>
                      <li><a href="{{ route('profil-ibu.index') }}"
                              class="{{ request()->routeIs('profil-ibu.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Profil Ibu</span></a></li>
                      <li><a href="{{ route('profil-suami.index') }}"
                              class="{{ request()->routeIs('profil-suami.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Profil Suami</span></a></li>
                      <li><a href="{{ route('pembiayaan.index') }}"
                              class="{{ request()->routeIs('pembiayaan.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Pembiayaan</span></a></li>
                      <li><a href="{{ route('pemantauan-nifas.index') }}"
                              class="{{ request()->routeIs('pemantauan-nifas.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Pemantauan Nifas</span></a></li>
                      <li><a href="{{ route('kb-pasca-salin.index') }}"
                              class="{{ request()->routeIs('kb-pasca-salin.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>KB Pasca Salin</span></a></li>
                      <li><a href="{{ route('dokumen.index') }}"
                              class="{{ request()->routeIs('dokumen.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Dokumen Pasien</span></a></li>
                  </ul>
              </li>

              {{-- Kesehatan Anak Dropdown --}}
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('profil-anak.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? '' : 'collapsed' }}"
                      data-bs-target="#anak-admin-nav" data-bs-toggle="collapse" href="#">
                      <i class="bi bi-emoji-smile"></i><span>Kesehatan Anak</span><i
                          class="bi bi-chevron-down ms-auto fs-5"></i>
                  </a>
                  <ul id="anak-admin-nav"
                      class="nav-content collapse {{ request()->routeIs('profil-anak.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? 'show' : '' }}"
                      data-bs-parent="#sidebar-nav">
                      <li><a href="{{ route('profil-anak.index') }}"
                              class="{{ request()->routeIs('profil-anak.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Profil Anak</span></a></li>
                      <li><a href="{{ route('bayi-baru-lahir.index') }}"
                              class="{{ request()->routeIs('bayi-baru-lahir.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Bayi Baru Lahir</span></a></li>
                      <li><a href="{{ route('imunisasi-anak.index') }}"
                              class="{{ request()->routeIs('imunisasi-anak.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Imunisasi Anak</span></a></li>
                      <li><a href="{{ route('tumbuh-kembang.index') }}"
                              class="{{ request()->routeIs('tumbuh-kembang.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Tumbuh Kembang</span></a></li>
                      <li><a href="{{ route('perkembangan-sidtk.index') }}"
                              class="{{ request()->routeIs('perkembangan-sidtk.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Perkembangan SIDTK</span></a></li>
                      <li><a href="{{ route('mpasi.index') }}"
                              class="{{ request()->routeIs('mpasi.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>MPASI</span></a></li>
                  </ul>
              </li>

              {{-- Homepage Management Dropdown --}}
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('homepage') || request()->routeIs('homepage.*') || request()->routeIs('artikel-edukasi.*') || request()->routeIs('kategori-artikel.*') || request()->routeIs('faqs.*') || request()->routeIs('contacts.*') || request()->routeIs('abouts.*') || request()->routeIs('teams.*') || request()->routeIs('visi-misi.*') || request()->routeIs('layanans.*') || request()->routeIs('layanan-intro.*') || request()->routeIs('konsultasi-publik.*') ? '' : 'collapsed' }}"
                      data-bs-target="#homepage-nav" data-bs-toggle="collapse" href="#">
                      <i class="bi bi-globe"></i><span>Kelola Homepage</span><i
                          class="bi bi-chevron-down ms-auto fs-5"></i>
                  </a>
                  <ul id="homepage-nav"
                      class="nav-content collapse {{ request()->routeIs('homepage') || request()->routeIs('homepage.*') || request()->routeIs('artikel-edukasi.*') || request()->routeIs('kategori-artikel.*') || request()->routeIs('faqs.*') || request()->routeIs('contacts.*') || request()->routeIs('abouts.*') || request()->routeIs('teams.*') || request()->routeIs('visi-misi.*') || request()->routeIs('layanans.*') || request()->routeIs('layanan-intro.*') || request()->routeIs('konsultasi-publik.*') ? 'show' : '' }}"
                      data-bs-parent="#sidebar-nav">
                      <li><a href="{{ route('homepage') }}"
                              class="{{ request()->routeIs('homepage') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Beranda</span></a></li>
                      <li><a href="{{ route('abouts.index') }}"
                              class="{{ request()->routeIs('abouts.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Tentang</span></a></li>
                      <li><a href="{{ route('teams.index') }}"
                              class="{{ request()->routeIs('teams.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Kelola Tim</span></a></li>
                      <li><a href="{{ route('visi-misi.index') }}"
                              class="{{ request()->routeIs('visi-misi.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Visi &amp; Misi</span></a></li>
                      <li><a href="{{ route('layanan-intro.index') }}"
                              class="{{ request()->routeIs('layanan-intro.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Tentang Layanan</span></a></li>
                      <li><a href="{{ route('layanans.index') }}"
                              class="{{ request()->routeIs('layanans.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Layanan Unggulan</span></a></li>
                      <li><a href="{{ route('artikel-edukasi.index') }}"
                              class="{{ request()->routeIs('artikel-edukasi.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Artikel Edukasi</span></a></li>
                      <li><a href="{{ route('kategori-artikel.index') }}"
                              class="{{ request()->routeIs('kategori-artikel.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Kategori Artikel</span></a></li>
                      <li><a href="{{ route('contacts.index') }}"
                              class="{{ request()->routeIs('contacts.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Kontak Kami</span></a></li>
                      <li><a href="{{ route('konsultasi-publik.form') }}"
                              class="{{ request()->routeIs('konsultasi-publik.form') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Konsultasi Publik</span></a></li>
                      <li><a href="{{ route('faqs.index') }}"
                              class="{{ request()->routeIs('faqs.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>FAQ</span></a></li>
                  </ul>
              </li>

              <li class="nav-heading">Laporan & Monitoring</li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('laporan.statistik') ? '' : 'collapsed' }}"
                      href="{{ route('laporan.statistik') }}">
                      <i class="bi bi-graph-up-arrow"></i><span>Statistik KIA Wilayah</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('laporan.monitoring-faskes') ? '' : 'collapsed' }}"
                      href="{{ route('laporan.monitoring-faskes') }}">
                      <i class="bi bi-building"></i><span>Monitoring Faskes</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('laporan.monitoring-buku-kia') ? '' : 'collapsed' }}"
                      href="{{ route('laporan.monitoring-buku-kia') }}">
                      <i class="bi bi-book"></i><span>Monitoring Buku KIA</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('laporan.monitoring-imunisasi') ? '' : 'collapsed' }}"
                      href="{{ route('laporan.monitoring-imunisasi') }}">
                      <i class="bi bi-shield-plus"></i><span>Monitoring Imunisasi</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('laporan.monitoring-gizi-balita') ? '' : 'collapsed' }}"
                      href="{{ route('laporan.monitoring-gizi-balita') }}">
                      <i class="bi bi-heart-pulse"></i><span>Monitoring Gizi Balita</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('laporan.kb-pasca-salin') ? '' : 'collapsed' }}"
                      href="{{ route('laporan.kb-pasca-salin') }}">
                      <i class="bi bi-hearts"></i><span>KB Pasca Salin</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('laporan.peta-sebaran') ? '' : 'collapsed' }}"
                      href="{{ route('laporan.peta-sebaran') }}">
                      <i class="bi bi-geo-alt"></i><span>Peta Sebaran Risiko</span>
                  </a>
              </li>
          @endif

          @if (in_array(optional(Auth::user()->role)->nama_role, ['administrator', 'dinas kesehatan']))
              <li class="nav-heading">Dinas Kesehatan</li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('laporan.statistik') ? '' : 'collapsed' }}"
                      href="{{ route('laporan.statistik') }}">
                      <i class="bi bi-graph-up-arrow"></i><span>Statistik KIA Wilayah</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('laporan.monitoring-faskes') ? '' : 'collapsed' }}"
                      href="{{ route('laporan.monitoring-faskes') }}">
                      <i class="bi bi-building"></i><span>Monitoring Faskes</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('laporan.monitoring-buku-kia') ? '' : 'collapsed' }}"
                      href="{{ route('laporan.monitoring-buku-kia') }}">
                      <i class="bi bi-book"></i><span>Monitoring Buku KIA</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('laporan.monitoring-imunisasi') ? '' : 'collapsed' }}"
                      href="{{ route('laporan.monitoring-imunisasi') }}">
                      <i class="bi bi-shield-plus"></i><span>Monitoring Imunisasi</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('laporan.monitoring-gizi-balita') ? '' : 'collapsed' }}"
                      href="{{ route('laporan.monitoring-gizi-balita') }}">
                      <i class="bi bi-heart-pulse"></i><span>Monitoring Gizi Balita</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('laporan.kb-pasca-salin') ? '' : 'collapsed' }}"
                      href="{{ route('laporan.kb-pasca-salin') }}">
                      <i class="bi bi-hearts"></i><span>KB Pasca Salin</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('laporan.peta-sebaran') ? '' : 'collapsed' }}"
                      href="{{ route('laporan.peta-sebaran') }}">
                      <i class="bi bi-geo-alt"></i><span>Peta Sebaran Risiko</span>
                  </a>
              </li>
          @endif

          @php
              $sidebarRole = strtolower(optional(Auth::user()->role)->nama_role ?? '');
          @endphp
          @if (in_array($sidebarRole, ['administrator', 'nakes', 'kader posyandu', 'kader']))
              <li class="nav-heading">{{ in_array($sidebarRole, ['kader posyandu', 'kader']) ? 'Kader Posyandu' : 'Tenaga Kesehatan' }}</li>

              {{-- Buku KIA Dropdown --}}
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('buku-kia.*') || request()->routeIs('kunjungan-anc.*') || request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('pembiayaan.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') || request()->routeIs('dokumen.*') ? '' : 'collapsed' }}"
                      data-bs-target="#buku-kia-nav" data-bs-toggle="collapse" href="#">
                      <i class="bi bi-book"></i><span>Buku KIA</span><i class="bi bi-chevron-down ms-auto fs-5"></i>
                  </a>
                  <ul id="buku-kia-nav"
                      class="nav-content collapse {{ request()->routeIs('buku-kia.*') || request()->routeIs('kunjungan-anc.*') || request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('pembiayaan.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') || request()->routeIs('dokumen.*') ? 'show' : '' }}"
                      data-bs-parent="#sidebar-nav">
                      <li><a href="{{ route('buku-kia.index') }}"
                              class="{{ request()->routeIs('buku-kia.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Buku KIA</span></a></li>
                      <li><a href="{{ route('kunjungan-anc.index') }}"
                              class="{{ request()->routeIs('kunjungan-anc.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Kunjungan ANC</span></a></li>
                      <li><a href="{{ route('profil-ibu.index') }}"
                              class="{{ request()->routeIs('profil-ibu.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Ibu</span></a></li>
                      <li><a href="{{ route('profil-suami.index') }}"
                              class="{{ request()->routeIs('profil-suami.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Suami</span></a></li>
                      <li><a href="{{ route('pembiayaan.index') }}"
                              class="{{ request()->routeIs('pembiayaan.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Biaya</span></a></li>
                      <li><a href="{{ route('pemantauan-nifas.index') }}"
                              class="{{ request()->routeIs('pemantauan-nifas.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Pemantauan Nifas</span></a></li>
                      <li><a href="{{ route('kb-pasca-salin.index') }}"
                              class="{{ request()->routeIs('kb-pasca-salin.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>KB Pasca Salin</span></a></li>
                      <li><a href="{{ route('dokumen.index') }}"
                              class="{{ request()->routeIs('dokumen.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Dokumen</span></a></li>
                  </ul>
              </li>

              {{-- Pemeriksaan Ibu --}}
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('hasil-lab-ibu.*') || request()->routeIs('pencatatan-ttd.*') || request()->routeIs('persalinan.*') ? '' : 'collapsed' }}"
                      data-bs-target="#pemeriksaan-nav" data-bs-toggle="collapse" href="#">
                      <i class="bi bi-clipboard2-pulse"></i><span>Pemeriksaan Ibu</span><i
                          class="bi bi-chevron-down ms-auto"></i>
                  </a>
                  <ul id="pemeriksaan-nav"
                      class="nav-content collapse {{ request()->routeIs('hasil-lab-ibu.*') || request()->routeIs('pencatatan-ttd.*') || request()->routeIs('persalinan.*') ? 'show' : '' }}"
                      data-bs-parent="#sidebar-nav">
                      <li><a href="{{ route('hasil-lab-ibu.index') }}"
                              class="{{ request()->routeIs('hasil-lab-ibu.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Hasil Lab Ibu</span></a></li>
                      <li><a href="{{ route('pencatatan-ttd.index') }}"
                              class="{{ request()->routeIs('pencatatan-ttd.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Pencatatan TTD/MMS</span></a></li>
                      <li><a href="{{ route('persalinan.index') }}"
                              class="{{ request()->routeIs('persalinan.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Data Persalinan</span></a></li>
                  </ul>
              </li>

              {{-- Kesehatan Anak --}}
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('profil-anak.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? '' : 'collapsed' }}"
                      data-bs-target="#anak-nav" data-bs-toggle="collapse" href="#">
                      <i class="bi bi-emoji-heart-eyes"></i><span>Kesehatan Anak</span><i
                          class="bi bi-chevron-down ms-auto"></i>
                  </a>
                  <ul id="anak-nav"
                      class="nav-content collapse {{ request()->routeIs('profil-anak.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? 'show' : '' }}"
                      data-bs-parent="#sidebar-nav">
                      <li><a href="{{ route('profil-anak.index') }}"
                              class="{{ request()->routeIs('profil-anak.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Profil Anak</span></a></li>
                      <li><a href="{{ route('bayi-baru-lahir.index') }}"
                              class="{{ request()->routeIs('bayi-baru-lahir.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Bayi Baru Lahir</span></a></li>
                      <li><a href="{{ route('imunisasi-anak.index') }}"
                              class="{{ request()->routeIs('imunisasi-anak.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Imunisasi Anak</span></a></li>
                      <li><a href="{{ route('tumbuh-kembang.index') }}"
                              class="{{ request()->routeIs('tumbuh-kembang.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Tumbuh Kembang</span></a></li>
                      <li><a href="{{ route('perkembangan-sidtk.index') }}"
                              class="{{ request()->routeIs('perkembangan-sidtk.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Perkembangan SIDTK</span></a></li>
                      <li><a href="{{ route('mpasi.index') }}"
                              class="{{ request()->routeIs('mpasi.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>MPASI</span></a></li>
                  </ul>
              </li>
          @endif

          @if (in_array(optional(Auth::user()->role)->nama_role, ['administrator', 'ibu hamil']))
              <li class="nav-heading">Ibu Hamil</li>

              {{-- Buku KIA Saya Dropdown --}}
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('buku-kia.*') || request()->routeIs('kunjungan-anc.*') || request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('pembiayaan.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') || request()->routeIs('dokumen.*') ? '' : 'collapsed' }}"
                      data-bs-target="#buku-kia-ibu-nav" data-bs-toggle="collapse" href="#">
                      <i class="bi bi-journal-check"></i><span>Buku KIA Saya</span><i
                          class="bi bi-chevron-down ms-auto fs-5"></i>
                  </a>
                  <ul id="buku-kia-ibu-nav"
                      class="nav-content collapse {{ request()->routeIs('buku-kia.*') || request()->routeIs('kunjungan-anc.*') || request()->routeIs('profil-ibu.*') || request()->routeIs('profil-suami.*') || request()->routeIs('pembiayaan.*') || request()->routeIs('pemantauan-nifas.*') || request()->routeIs('kb-pasca-salin.*') || request()->routeIs('dokumen.*') ? 'show' : '' }}"
                      data-bs-parent="#sidebar-nav">
                      <li><a href="{{ route('buku-kia.index') }}"
                              class="{{ request()->routeIs('buku-kia.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Buku KIA Saya</span></a></li>
                      <li><a href="{{ route('kunjungan-anc.index') }}"
                              class="{{ request()->routeIs('kunjungan-anc.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Kunjungan ANC</span></a></li>
                      <li><a href="{{ route('profil-ibu.index') }}"
                              class="{{ request()->routeIs('profil-ibu.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Ibu</span></a></li>
                      <li><a href="{{ route('profil-suami.index') }}"
                              class="{{ request()->routeIs('profil-suami.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Suami</span></a></li>
                      <li><a href="{{ route('pembiayaan.index') }}"
                              class="{{ request()->routeIs('pembiayaan.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Biaya</span></a></li>
                      <li><a href="{{ route('pemantauan-nifas.index') }}"
                              class="{{ request()->routeIs('pemantauan-nifas.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Pemantauan Nifas</span></a></li>
                      <li><a href="{{ route('kb-pasca-salin.index') }}"
                              class="{{ request()->routeIs('kb-pasca-salin.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>KB Pasca Salin</span></a></li>
                      <li><a href="{{ route('dokumen.index') }}"
                              class="{{ request()->routeIs('dokumen.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Dokumen</span></a></li>
                  </ul>
              </li>
 
              {{-- Fasilitas Kesehatan --}}
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('fasilitas-kesehatan.*') ? '' : 'collapsed' }}"
                      href="{{ route('fasilitas-kesehatan.index') }}">
                      <i class="bi bi-hospital"></i><span>Fasilitas Kesehatan</span>
                  </a>
              </li>
 
              {{-- Pemeriksaan Ibu --}}
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('hasil-lab-ibu.*') || request()->routeIs('pencatatan-ttd.*') || request()->routeIs('persalinan.*') ? '' : 'collapsed' }}"
                      data-bs-target="#pemeriksaan-ibu-nav" data-bs-toggle="collapse" href="#">
                      <i class="bi bi-clipboard2-pulse"></i><span>Pemeriksaan Ibu</span><i
                          class="bi bi-chevron-down ms-auto fs-5"></i>
                  </a>
                  <ul id="pemeriksaan-ibu-nav"
                      class="nav-content collapse {{ request()->routeIs('hasil-lab-ibu.*') || request()->routeIs('pencatatan-ttd.*') || request()->routeIs('persalinan.*') ? 'show' : '' }}"
                      data-bs-parent="#sidebar-nav">
                      <li><a href="{{ route('hasil-lab-ibu.index') }}"
                              class="{{ request()->routeIs('hasil-lab-ibu.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Hasil Lab Ibu</span></a></li>
                      <li><a href="{{ route('pencatatan-ttd.index') }}"
                              class="{{ request()->routeIs('pencatatan-ttd.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Pencatatan TTD/MMS</span></a></li>
                      <li><a href="{{ route('persalinan.index') }}"
                              class="{{ request()->routeIs('persalinan.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Data Persalinan</span></a></li>
                  </ul>
              </li>

              {{-- Kesehatan Anak --}}
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('profil-anak.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? '' : 'collapsed' }}"
                      data-bs-target="#anak-ibu-nav" data-bs-toggle="collapse" href="#">
                      <i class="bi bi-emoji-smile"></i><span>Kesehatan Anak</span><i
                          class="bi bi-chevron-down ms-auto fs-5"></i>
                  </a>
                  <ul id="anak-ibu-nav"
                      class="nav-content collapse {{ request()->routeIs('profil-anak.*') || request()->routeIs('bayi-baru-lahir.*') || request()->routeIs('imunisasi-anak.*') || request()->routeIs('tumbuh-kembang.*') || request()->routeIs('perkembangan-sidtk.*') || request()->routeIs('mpasi.*') ? 'show' : '' }}"
                      data-bs-parent="#sidebar-nav">
                      <li><a href="{{ route('profil-anak.index') }}"
                              class="{{ request()->routeIs('profil-anak.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Profil Anak</span></a></li>
                      <li><a href="{{ route('bayi-baru-lahir.index') }}"
                              class="{{ request()->routeIs('bayi-baru-lahir.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Bayi Baru Lahir</span></a></li>
                      <li><a href="{{ route('imunisasi-anak.index') }}"
                              class="{{ request()->routeIs('imunisasi-anak.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Imunisasi Anak</span></a></li>
                      <li><a href="{{ route('tumbuh-kembang.index') }}"
                              class="{{ request()->routeIs('tumbuh-kembang.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Tumbuh Kembang</span></a></li>
                      <li><a href="{{ route('perkembangan-sidtk.index') }}"
                              class="{{ request()->routeIs('perkembangan-sidtk.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>Perkembangan SIDTK</span></a></li>
                      <li><a href="{{ route('mpasi.index') }}"
                              class="{{ request()->routeIs('mpasi.*') ? 'active' : '' }}"><i
                                  class="bi bi-circle"></i><span>MPASI</span></a></li>
                  </ul>
              </li>
          @endif

          <li class="nav-heading">Layanan</li>

          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('konsultasi-online.*') ? '' : 'collapsed' }}"
                  href="{{ route('konsultasi-online.index') }}">
                  <i class="bi bi-chat-dots"></i>
                  <span>Konsultasi Online</span>
                  <span id="konsultasi-unread-badge" class="badge bg-danger rounded-pill ms-auto d-none"
                      style="font-size: 10px; padding: 3px 6px;">0</span>
              </a>
          </li>

          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('notifikasi.*') ? '' : 'collapsed' }}"
                  href="{{ route('notifikasi.index') }}">
                  <i class="bi bi-bell"></i>
                  <span>Notifikasi</span>
                  <span id="sidebar-notif-badge" class="badge bg-danger rounded-pill ms-auto d-none"
                      style="font-size: 10px; padding: 3px 6px;">0</span>
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
