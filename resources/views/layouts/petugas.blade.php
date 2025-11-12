<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Petugas Panel')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body { font-family: Arial, sans-serif; background:#f4f6f9; }
    .sidebar{position:fixed;left:0;top:0;width:220px;height:100vh;background:#2c3e50;color:#ecf0f1;padding:20px;}
    .sidebar a{color:#bdc3c7;display:block;padding:10px 8px;text-decoration:none;}
    .sidebar a.active,.sidebar a:hover{background:#34495e;color:#fff;}
    .main{margin-left:240px;padding:20px;}
  </style>
</head>
<body>
  <div class="sidebar">
    <h5 class="text-center mb-3">PETUGAS</h5>
    <div class="text-center mb-3">
      <i class="fa-solid fa-user-circle fa-3x"></i>
      <div class="mt-2">{{ Auth::user()->name ?? '-' }}</div>
    </div>
    <a href="{{ route('petugas.dashboard') }}" class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}"><i class="fa fa-home me-2"></i> Dashboard</a>
    <a href="{{ route('petugas.riwayat.index') }}" class="{{ request()->routeIs('petugas.riwayat.*') ? 'active' : '' }}"><i class="fa fa-history me-2"></i> Riwayat</a>
    <hr style="border-color:rgba(255,255,255,0.06)">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="btn btn-danger w-100"><i class="fa fa-sign-out-alt me-2"></i> Logout</button>
    </form>
  </div>

  <div class="main">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>