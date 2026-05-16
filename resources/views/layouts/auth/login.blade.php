<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login - Monitoring KIA</title>
  <meta content="Sistem Monitoring Kesehatan Ibu dan Anak" name="description">
  
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
      --primary-color: #EC1E88;
      --primary-hover: #D81B7A;
      --secondary-color: #16B3AC;
      --bg-light: #fdf2f8;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--bg-light);
      color: #333;
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
      box-shadow: 0 20px 60px rgba(236, 30, 136, 0.15);
      display: flex;
      max-width: 1050px;
      width: 100%;
      min-height: 650px;
    }

    .login-illustration {
      flex: 1.2;
      background: linear-gradient(135deg, var(--primary-color), #ad1457);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 4rem;
      color: #fff;
      position: relative;
      overflow: hidden;
    }

    .login-illustration img {
      max-width: 85%;
      z-index: 1;
      border-radius: 20px;
      box-shadow: 0 15px 30px rgba(0,0,0,0.25);
      margin-bottom: 2.5rem;
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
      flex: 1;
      padding: 4.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .brand-logos {
      display: flex;
      align-items: center;
      gap: 18px;
      margin-bottom: 2.5rem;
    }

    .brand-logos img {
      height: 50px;
    }

    .login-header h2 {
      font-weight: 800;
      color: var(--primary-color);
      margin-bottom: 0.6rem;
      font-size: 2.2rem;
    }

    .login-header p {
      color: #718096;
      margin-bottom: 3rem;
      font-size: 1.05rem;
    }

    .form-label {
      font-weight: 600;
      font-size: 0.95rem;
      color: #4a5568;
      margin-bottom: 0.6rem;
    }

    .form-control {
      padding: 0.9rem 1.2rem;
      border-radius: 12px;
      border: 1.5px solid #e2e8f0;
      background-color: #f8fafc;
      transition: all 0.2s ease;
    }

    .form-control:focus {
      background-color: #fff;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 4px rgba(236, 30, 136, 0.12);
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
      margin-top: 1rem;
    }

    .btn-login:hover {
      background-color: var(--primary-hover);
      transform: translateY(-3px);
      box-shadow: 0 12px 24px rgba(236, 30, 136, 0.3);
      color: white;
    }

    .footer-text {
      margin-top: 3rem;
      text-align: center;
      font-size: 0.9rem;
      color: #a0aec0;
      line-height: 1.5;
    }

    .alert {
      border-radius: 14px;
      border: none;
      box-shadow: 0 4px 12px rgba(220, 38, 38, 0.1);
    }

    .hover-primary:hover {
      color: var(--primary-color) !important;
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
      <div class="login-illustration d-none d-lg-flex">
        <div class="text-center">
          <img src="{{ asset('assets/img/login.png') }}" alt="KIA Illustration" class="mb-4">
          <h3 class="fw-bold mb-2">Monitoring MYKIA</h3>
          <p class="opacity-75">Sistem Informasi Monitoring Kesehatan Ibu dan Anak Terpadu</p>
        </div>
      </div>
      
      <div class="login-form-container">
        <div class="brand-logos">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
          <div style="width: 2px; height: 40px; background: #eee;"></div>
          <h4 class="mt-2 fw-bold" style="color: var(--primary-color);">MYKIA</h4>
        </div>

        <div class="login-header">
          <h2>Selamat Datang</h2>
          <p>Silakan masuk menggunakan akun Anda</p>
        </div>

        @include('sweetalert::alert')

        <form action="{{ route('proseslogin') }}" method="POST" class="needs-validation" novalidate>
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
              <input type="email" name="email" class="form-control border-start-0 bg-light" id="email" placeholder="contoh@email.com" required value="{{ old('email') }}">
            </div>
            @error('email')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label for="password" class="form-label">Kata Sandi</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
              <input type="password" name="password" class="form-control border-start-0 border-end-0 bg-light" id="password" placeholder="Masukkan password" required>
              <button class="btn btn-light border border-start-0 text-muted" type="button" id="toggle-password" style="border-radius: 0 12px 12px 0;">
                <i class="bi bi-eye"></i>
              </button>
            </div>
            @error('password')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4 d-flex justify-content-between align-items-center">
            <div class="form-check d-none">
              <input class="form-check-input" type="checkbox" id="show-password">
              <label class="form-check-label small text-muted" for="show-password">Tampilkan Sandi</label>
            </div>
            <a href="#" class="small text-decoration-none" style="color: var(--primary-color);">Lupa Password?</a>
          </div>

          <button type="submit" class="btn btn-login w-100">Masuk Sekarang</button>
          
          <div class="text-center mt-4">
            <a href="{{ route('homepage') }}" class="text-decoration-none small text-muted hover-primary">
              <i class="bi bi-house-door me-1"></i> Kembali ke Beranda
            </a>
          </div>
        </form>

        <p class="footer-text">
          &copy; {{ date('Y') }} Kementerian Kesehatan RI <br>
          Sistem Monitoring KIA Terintegrasi
        </p>
      </div>
    </div>
  </main>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script>
    document.getElementById('toggle-password').addEventListener('click', function() {
      const passwordInput = document.getElementById('password');
      const icon = this.querySelector('i');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
      } else {
        passwordInput.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
      }
    });
  </script>
</body>

</html>
