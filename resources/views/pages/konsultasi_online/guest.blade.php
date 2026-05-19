<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Mulai Konsultasi Online - KIA Care</title>
  <meta content="Sistem Konsultasi Kesehatan Ibu dan Anak Online" name="description">
  
  <!-- Favicons -->
  <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
  <link href="{{ asset('assets/img/logo.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  
  <style>
    :root {
      --primary-color: #128C7E;
      --primary-hover: #075E54;
      --secondary-color: #25D366;
      --bg-light: #ECE5DD;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--bg-light);
      color: #333;
      background-image: radial-gradient(circle, #e3dfd8 20%, transparent 20%), radial-gradient(circle, #e3dfd8 20%, transparent 20%);
      background-size: 15px 15px;
      background-position: 0 0, 7.5px 7.5px;
    }

    .login-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }

    .login-card {
      background: #fff;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(18, 140, 126, 0.15);
      display: flex;
      max-width: 950px;
      width: 100%;
      min-height: 600px;
    }

    .login-illustration {
      flex: 1;
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 4rem;
      color: #fff;
      position: relative;
      overflow: hidden;
    }

    .login-illustration i {
      font-size: 6rem;
      margin-bottom: 1.5rem;
      z-index: 2;
    }

    .login-illustration::after {
      content: '';
      position: absolute;
      bottom: -50px;
      left: -50px;
      width: 250px;
      height: 250px;
      background: rgba(255,255,255,0.08);
      border-radius: 50%;
    }

    .login-form-container {
      flex: 1.2;
      padding: 4.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .brand-logos {
      display: flex;
      align-items: center;
      gap: 18px;
      margin-bottom: 2rem;
    }

    .brand-logos img {
      height: 45px;
    }

    .login-header h2 {
      font-weight: 800;
      color: var(--primary-color);
      margin-bottom: 0.6rem;
      font-size: 2rem;
    }

    .login-header p {
      color: #718096;
      margin-bottom: 2.5rem;
      font-size: 1rem;
    }

    .form-label {
      font-weight: 600;
      font-size: 0.95rem;
      color: #4a5568;
      margin-bottom: 0.6rem;
    }

    .form-control, .form-select {
      padding: 0.9rem 1.2rem;
      border-radius: 12px;
      border: 1.5px solid #e2e8f0;
      background-color: #f8fafc;
      transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
      background-color: #fff;
      border-color: var(--secondary-color);
      box-shadow: 0 0 0 4px rgba(37, 211, 102, 0.12);
    }

    .input-group-text {
      background-color: #f8fafc;
      border: 1.5px solid #e2e8f0;
      border-radius: 12px;
      color: #94a3b8;
    }

    .btn-login {
      background-color: var(--primary-color);
      border: none;
      padding: 1rem;
      border-radius: 14px;
      font-weight: 700;
      font-size: 1.1rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      color: white;
      margin-top: 1.5rem;
    }

    .btn-login:hover {
      background-color: var(--primary-hover);
      transform: translateY(-3px);
      box-shadow: 0 12px 24px rgba(18, 140, 126, 0.3);
      color: white;
    }

    .footer-text {
      margin-top: 2rem;
      text-align: center;
      font-size: 0.9rem;
      color: #a0aec0;
      line-height: 1.5;
    }

    @media (max-width: 1024px) {
      .login-illustration {
        display: none;
      }
      .login-card {
        max-width: 520px;
      }
      .login-form-container {
        padding: 3.5rem;
      }
    }
  </style>
</head>

<body>

  <main class="login-container min-vh-100">
    <div class="login-card">
      <div class="login-illustration d-none d-lg-flex text-center">
        <i class="bi bi-chat-heart-fill"></i>
        <h3 class="fw-bold mb-2">Telemedisin KIA</h3>
        <p class="opacity-75">Konsultasikan keluhan medis Anda langsung dengan ahlinya.</p>
      </div>
      
      <div class="login-form-container">
        <div class="brand-logos">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
          <div style="width: 2px; height: 35px; background: #eee;"></div>
          <h5 class="mt-2 fw-bold text-dark">Portal Layanan Publik</h5>
        </div>

        <div class="login-header">
          <h2>Mulai Konsultasi</h2>
          <p>Lengkapi identitas Anda untuk terhubung ke klinik.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger rounded-4 border-0 shadow-sm small">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('konsultasi-publik.login') }}" method="POST" class="needs-validation" novalidate>
          @csrf
          
          <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <div class="input-group">
              <span class="input-group-text border-end-0"><i class="bi bi-person text-muted"></i></span>
              <input type="text" name="nama" class="form-control border-start-0" id="nama" placeholder="Masukkan nama lengkap Anda" required value="{{ old('nama') }}">
            </div>
          </div>

          <div class="mb-3">
            <label for="nik" class="form-label">Nomor Induk Kependudukan (NIK)</label>
            <div class="input-group">
              <span class="input-group-text border-end-0"><i class="bi bi-credit-card-2-front text-muted"></i></span>
              <input type="text" name="nik" class="form-control border-start-0" id="nik" placeholder="Contoh: 3201..." required value="{{ old('nik') }}" maxlength="16">
            </div>
          </div>

          <div class="mb-4">
            <label for="faskes_id" class="form-label">Tujuan Fasilitas Kesehatan</label>
            <div class="input-group">
              <span class="input-group-text border-end-0"><i class="bi bi-hospital text-muted"></i></span>
              <select name="faskes_id" class="form-select border-start-0" id="faskes_id" required>
                <option value="" disabled selected>Pilih klinik / poli tujuan...</option>
                @foreach($faskes as $f)
                    <option value="{{ $f->id }}" {{ old('faskes_id') == $f->id ? 'selected' : '' }}>{{ $f->nama_faskes }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <button type="submit" class="btn btn-login w-100 d-flex justify-content-center align-items-center gap-2">
            Masuk ke Ruang Obrolan <i class="bi bi-arrow-right-circle-fill"></i>
          </button>
          
          <div class="text-center mt-4">
            <a href="{{ route('homepage') }}" class="text-decoration-none small text-muted hover-primary">
              <i class="bi bi-house-door me-1"></i> Kembali ke Beranda
            </a>
          </div>
        </form>
      </div>
    </div>
  </main>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
