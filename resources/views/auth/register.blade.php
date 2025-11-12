<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Pengaduan Sarpras</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen relative">

  <!-- Header biru -->
  <div class="absolute top-0 left-0 w-full bg-blue-800 h-48 flex flex-col items-center justify-center text-white shadow-md">
  </div>

  <!-- Kotak register -->
  <div class="bg-white shadow-xl rounded-2xl w-11/12 max-w-md p-8 mt-16 z-10">
      <h1 class="text-center text-2xl font-bold text-blue-700 mb-1">Daftar Akun Baru</h1>
      <p class="text-center text-gray-500 text-sm mb-6">
          Silakan isi data Anda untuk membuat akun baru.
      </p>

      @if($errors->any())
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
              <ul class="list-disc pl-5">
                  @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
          @csrf
          <div>
              <label class="block text-gray-600 font-medium text-sm mb-1">Nama Lengkap</label>
              <input type="text" name="name" placeholder="Masukkan nama lengkap"
                     class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          </div>

          <div>
              <label class="block text-gray-600 font-medium text-sm mb-1">Email</label>
              <input type="email" name="email" placeholder="contoh@email.com"
                     class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          </div>

          <div>
              <label class="block text-gray-600 font-medium text-sm mb-1">Password</label>
              <input type="password" name="password" placeholder="Masukkan password"
                     class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          </div>

          <div>
              <label class="block text-gray-600 font-medium text-sm mb-1">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" placeholder="Ulangi password"
                     class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          </div>

          <button type="submit" 
                  class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
              Daftar
          </button>
      </form>

      <p class="mt-6 text-center text-gray-600 text-sm">
          Sudah punya akun? 
          <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Login Sekarang</a>
      </p>
  </div>

  <!-- Background gelombang bawah -->
  <div class="absolute bottom-0 left-0 right-0 opacity-20 pointer-events-none">
      <svg viewBox="0 0 1440 320">
          <path fill="#3B82F6" fill-opacity="1" d="M0,128L60,133.3C120,139,240,149,360,160C480,171,600,181,720,160C840,139,960,85,1080,64C1200,43,1320,53,1380,58.7L1440,64L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
      </svg>
  </div>

</body>
</html>
