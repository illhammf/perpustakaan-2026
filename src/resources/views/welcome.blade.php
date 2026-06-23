<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan Ilham Berkah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
        .hero-glow { position: absolute; width: 600px; height: 600px; border-radius: 50%; filter: blur(120px); opacity: 0.15; pointer-events: none; }
        .glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.12); }
        .glass-card { background: rgba(255,255,255,0.06); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.1); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .glass-card:hover { transform: translateY(-8px) scale(1.02); background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .gradient-text { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .btn-primary { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 40px rgba(253,160,133,0.4); }
        .floating { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
        .fade-in { opacity: 0; transform: translateY(30px); animation: fadeInUp 0.8s ease forwards; }
        .fade-in:nth-child(2) { animation-delay: 0.2s; }
        .fade-in:nth-child(3) { animation-delay: 0.4s; }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        .book-spine { writing-mode: vertical-rl; text-orientation: mixed; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; }
    </style>
</head>
<body class="bg-[#0f0f13] text-white min-h-screen">

    <!-- Animated Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="hero-glow bg-orange-500 top-[-100px] left-[-100px]"></div>
        <div class="hero-glow bg-amber-500 bottom-[-200px] right-[-100px]"></div>
        <div class="hero-glow bg-yellow-500 top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]"></div>
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><rect fill=\"none\" stroke=\"rgba(255,255,255,0.03)\" stroke-width=\"0.5\" x=\"0\" y=\"0\" width=\"10\" height=\"10\"/></svg>'); background-size: 40px 40px;"></div>
    </div>

    <!-- Navbar -->
    <nav class="relative z-50 glass border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-orange-500/20 group-hover:shadow-orange-500/40 transition-all">
                    <i class="fas fa-book-open text-white text-lg"></i>
                </div>
                <span class="text-xl font-bold font-['Playfair_Display']">Ilham Berkah</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('opac.index') }}" class="px-5 py-2.5 text-sm font-medium text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-search mr-2"></i>Katalog
                </a>
                <a href="{{ route('filament.admin.auth.login') }}" class="btn-primary px-5 py-2.5 rounded-xl text-sm font-semibold text-[#1a1a1a] flex items-center gap-2">
                    <i class="fas fa-lock"></i>
                    <span>Admin</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative z-10 min-h-[90vh] flex items-center">
        <div class="max-w-7xl mx-auto px-6 py-20 w-full">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <div class="fade-in">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass text-sm text-amber-300 border border-amber-500/20">
                            <i class="fas fa-sparkles text-xs"></i>
                            Sistem Informasi Perpustakaan Digital
                        </span>
                    </div>
                    <h1 class="fade-in text-5xl lg:text-7xl font-bold leading-tight">
                        <span class="gradient-text block mt-2">Perpustakaan<br>Ilham Berkah</span>
                    </h1>
                    <p class="fade-in text-lg text-white/60 leading-relaxed max-w-lg">
                        Temukan ribuan koleksi buku dan bahan bacaan berkualitas. 
                        Nikmati pengalaman membaca yang menyenangkan di perpustakaan 
                        digital modern kami.
                    </p>
                    <div class="fade-in flex flex-wrap gap-4">
                        <a href="{{ route('opac.index') }}" class="btn-primary px-8 py-4 rounded-2xl text-base font-semibold text-[#1a1a1a] flex items-center gap-3">
                            <i class="fas fa-search"></i>
                            Jelajahi Katalog
                            <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                        <a href="#tentang" class="glass-card px-8 py-4 rounded-2xl text-base font-medium flex items-center gap-3 hover:bg-white/10">
                            <i class="fas fa-info-circle"></i>
                            Tentang Kami
                        </a>
                    </div>
                </div>
                <div class="relative lg:block hidden">
                    <div class="floating relative">
                        <div class="relative w-96 h-96 mx-auto">
                            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-amber-500/20 to-orange-500/20 blur-3xl"></div>
                            <div class="relative glass-card rounded-3xl p-8">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-4 rounded-2xl bg-white/5">
                                        <i class="fas fa-book text-3xl text-amber-400"></i>
                                        <p class="text-3xl font-bold font-['Playfair_Display'] mt-3">12rb+</p>
                                        <p class="text-xs text-white/50">Judul Buku</p>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-white/5">
                                        <i class="fas fa-users text-3xl text-amber-400"></i>
                                        <p class="text-3xl font-bold font-['Playfair_Display'] mt-3">500+</p>
                                        <p class="text-xs text-white/50">Anggota Aktif</p>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-white/5">
                                        <i class="fas fa-clock text-3xl text-amber-400"></i>
                                        <p class="text-3xl font-bold font-['Playfair_Display'] mt-3">5rb+</p>
                                        <p class="text-xs text-white/50">Peminjaman</p>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-white/5">
                                        <i class="fas fa-star text-3xl text-amber-400"></i>
                                        <p class="text-3xl font-bold font-['Playfair_Display'] mt-3">4.8</p>
                                        <p class="text-xs text-white/50">Rating</p>
                                    </div>
                                </div>
                                <div class="mt-6 flex items-center gap-3 p-4 rounded-2xl bg-amber-500/10 border border-amber-500/20">
                                    <div class="flex -space-x-2">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-xs font-bold border-2 border-[#0f0f13]">A</div>
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-xs font-bold border-2 border-[#0f0f13]">B</div>
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center text-xs font-bold border-2 border-[#0f0f13]">C</div>
                                    </div>
                                    <p class="text-sm text-white/60">Pengunjung baru hari ini <span class="text-white font-semibold">+24</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="tentang" class="relative z-10 py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 space-y-4">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass text-sm text-amber-300 border border-amber-500/20">
                    <i class="fas fa-sparkles"></i>
                    Layanan Kami
                </span>
                <h2 class="text-4xl lg:text-5xl font-bold">Kenapa Memilih Kami?</h2>
                <p class="text-white/50 max-w-2xl mx-auto">Kami menyediakan layanan perpustakaan modern dengan kemudahan akses untuk semua kalangan</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="glass-card rounded-3xl p-8 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400/20 to-orange-500/20 flex items-center justify-center">
                        <i class="fas fa-book-open text-2xl text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-bold font-['Playfair_Display']">Koleksi Lengkap</h3>
                    <p class="text-white/50 leading-relaxed">Ribuan judul buku dari berbagai kategori, mulai dari fiksi, non-fiksi, akademik, hingga referensi.</p>
                </div>
                <div class="glass-card rounded-3xl p-8 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400/20 to-orange-500/20 flex items-center justify-center">
                        <i class="fas fa-laptop text-2xl text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-bold font-['Playfair_Display']">Katalog Online</h3>
                    <p class="text-white/50 leading-relaxed">Cari dan telusuri koleksi buku kami secara online dari mana saja, kapan saja.</p>
                </div>
                <div class="glass-card rounded-3xl p-8 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400/20 to-orange-500/20 flex items-center justify-center">
                        <i class="fas fa-id-card text-2xl text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-bold font-['Playfair_Display']">Keanggotaan Mudah</h3>
                    <p class="text-white/50 leading-relaxed">Proses pendaftaran anggota yang cepat dan mudah. Nikmati layanan peminjaman buku.</p>
                </div>
                <div class="glass-card rounded-3xl p-8 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400/20 to-orange-500/20 flex items-center justify-center">
                        <i class="fas fa-clock text-2xl text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-bold font-['Playfair_Display']">Jam Operasional</h3>
                    <p class="text-white/50 leading-relaxed">Senin - Jumat: 08:00 - 20:00<br>Sabtu: 08:00 - 17:00<br>Minggu & Libur: Tutup</p>
                </div>
                <div class="glass-card rounded-3xl p-8 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400/20 to-orange-500/20 flex items-center justify-center">
                        <i class="fas fa-headset text-2xl text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-bold font-['Playfair_Display']">Bantuan 24/7</h3>
                    <p class="text-white/50 leading-relaxed">Tim kami siap membantu Anda dengan layanan informasi dan bantuan pencarian buku.</p>
                </div>
                <div class="glass-card rounded-3xl p-8 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400/20 to-orange-500/20 flex items-center justify-center">
                        <i class="fas fa-shield text-2xl text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-bold font-['Playfair_Display']">Sistem Modern</h3>
                    <p class="text-white/50 leading-relaxed">Dikelola dengan sistem informasi terintegrasi untuk pelayanan yang cepat dan akurat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="relative z-10 py-20">
        <div class="max-w-5xl mx-auto px-6">
            <div class="glass rounded-3xl p-10 lg:p-16">
                <div class="stats-grid">
                    <div class="text-center space-y-2">
                        <p class="text-4xl lg:text-5xl font-bold gradient-text font-['Playfair_Display']">12.000+</p>
                        <p class="text-sm text-white/50">Judul Buku</p>
                    </div>
                    <div class="text-center space-y-2">
                        <p class="text-4xl lg:text-5xl font-bold gradient-text font-['Playfair_Display']">500+</p>
                        <p class="text-sm text-white/50">Anggota Aktif</p>
                    </div>
                    <div class="text-center space-y-2">
                        <p class="text-4xl lg:text-5xl font-bold gradient-text font-['Playfair_Display']">5.000+</p>
                        <p class="text-sm text-white/50">Peminjaman/Bulan</p>
                    </div>
                    <div class="text-center space-y-2">
                        <p class="text-4xl lg:text-5xl font-bold gradient-text font-['Playfair_Display']">15</p>
                        <p class="text-sm text-white/50">Tahun Berdiri</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative z-10 py-24">
        <div class="max-w-4xl mx-auto px-6 text-center space-y-8">
            <h2 class="text-4xl lg:text-5xl font-bold">Siap Menjelajahi Dunia Buku?</h2>
            <p class="text-white/50 text-lg max-w-2xl mx-auto">Mulai petualangan literasi Anda bersama Perpustakaan Ilham Berkah. Temukan buku favorit Anda sekarang!</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('opac.index') }}" class="btn-primary px-10 py-4 rounded-2xl text-base font-semibold text-[#1a1a1a] flex items-center gap-3">
                    <i class="fas fa-search"></i>
                    Jelajahi Katalog
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="https://wa.me/62895336900466" target="_blank" class="glass-card px-10 py-4 rounded-2xl text-base font-medium flex items-center gap-3 hover:bg-white/10">
                    <i class="fab fa-whatsapp"></i>
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative z-10 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid md:grid-cols-4 gap-10">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
                            <i class="fas fa-book-open text-white text-lg"></i>
                        </div>
                        <span class="text-lg font-bold font-['Playfair_Display']">Ilham Berkah</span>
                    </div>
                    <p class="text-sm text-white/40 leading-relaxed">Perpustakaan digital modern yang menyediakan akses ke ribuan koleksi buku berkualitas.</p>
                </div>
                <div class="space-y-4">
                    <h4 class="font-semibold text-sm uppercase tracking-wider text-white/60">Layanan</h4>
                    <ul class="space-y-3 text-sm text-white/40">
                        <li><a href="{{ route('opac.index') }}" class="hover:text-amber-400 transition-colors">Katalog Online</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Keanggotaan</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Peminjaman</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Layanan Referensi</a></li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <h4 class="font-semibold text-sm uppercase tracking-wider text-white/60">Tautan</h4>
                    <ul class="space-y-3 text-sm text-white/40">
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Kebijakan</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">FAQ</a></li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <h4 class="font-semibold text-sm uppercase tracking-wider text-white/60">Kontak</h4>
                    <ul class="space-y-3 text-sm text-white/40">
                        <li class="flex items-center gap-2"><i class="fas fa-map-marker-alt w-4 text-amber-400"></i>Jl. Merdeka No. 123, Jakarta</li>
                        <li class="flex items-center gap-2"><i class="fas fa-phone w-4 text-amber-400"></i>(021) 1234-5678</li>
                        <li class="flex items-center gap-2"><i class="fas fa-envelope w-4 text-amber-400"></i>info@ilhamberkah.perpus</li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-white/30">
                <p>&copy; {{ date('Y') }} Perpustakaan Ilham Berkah. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-amber-400 transition-colors"><i class="fab fa-instagram text-lg"></i></a>
                    <a href="#" class="hover:text-amber-400 transition-colors"><i class="fab fa-facebook text-lg"></i></a>
                    <a href="#" class="hover:text-amber-400 transition-colors"><i class="fab fa-twitter text-lg"></i></a>
                    <a href="#" class="hover:text-amber-400 transition-colors"><i class="fab fa-youtube text-lg"></i></a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>