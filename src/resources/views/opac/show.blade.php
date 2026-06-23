<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} - Perpustakaan Ilham Berkah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #faf8f5; overflow-x: hidden; }
        h1, h2, h3, h4 { font-family: 'Playfair Display', serif; }
        .hero-gradient { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); }
        .glass-card { background: white; border-radius: 24px; border: 1px solid rgba(0,0,0,0.04); transition: all 0.3s ease; }
        .glass-card:hover { box-shadow: 0 20px 60px -12px rgba(0,0,0,0.15); }
        .gradient-text { background: linear-gradient(135deg, #c4955d 0%, #e8c98a 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .btn-gold { background: linear-gradient(135deg, #c4955d 0%, #e8c98a 100%); color: #1a1a2e; transition: all 0.3s ease; }
        .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(196,149,93,0.35); }
        .fade-in { opacity: 0; transform: translateY(20px); animation: fadeUp 0.6s ease forwards; }
        @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .info-item { display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid #f3f1ee; }
        .info-item:last-child { border-bottom: none; }
        .info-label { min-width: 120px; font-size: 0.875rem; color: #9ca3af; font-weight: 500; }
        .info-value { font-size: 0.875rem; color: #374151; font-weight: 500; }
        .status-badge { display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.375rem 1rem; border-radius: 9999px; font-size: 0.8125rem; font-weight: 600; }
        .related-card { transition: all 0.3s ease; }
        .related-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px -8px rgba(0,0,0,0.15); }
    </style>
</head>
<body>
    <!-- Breadcrumb -->
    <nav class="hero-gradient">
        <div class="max-w-6xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('opac.index') }}" class="flex items-center gap-2 text-white/70 hover:text-white transition-colors group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    <span>Kembali ke Katalog</span>
                </a>
                <a href="/" class="flex items-center gap-2 text-white/50 hover:text-white transition-colors text-sm">
                    <i class="fas fa-home"></i>
                    <span class="hidden sm:inline">Beranda</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Book Detail -->
    <main class="max-w-6xl mx-auto px-6 py-10">
        <div class="glass-card overflow-hidden">
            <div class="lg:flex">
                <!-- Cover Section -->
                <div class="lg:w-[380px] shrink-0 bg-gradient-to-b from-gray-50 to-gray-100 p-10 flex items-start justify-center">
                    <div class="fade-in relative w-full max-w-[280px]">
                        <div class="aspect-[3/4] rounded-2xl overflow-hidden shadow-2xl bg-white">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                    <div class="text-center">
                                        <i class="fas fa-book-open text-6xl text-gray-300 mb-3"></i>
                                        <p class="text-sm text-gray-400">Tidak ada sampul</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if($book->isbn)
                            <div class="mt-4 p-3 rounded-xl bg-white border border-gray-100 shadow-sm text-center">
                                <p class="text-xs text-gray-400 mb-1">ISBN</p>
                                <p class="text-sm font-mono font-semibold text-gray-700">{{ $book->isbn }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info Section -->
                <div class="flex-1 p-8 lg:p-10">
                    <div class="fade-in stagger-1 space-y-2">
                        <div class="flex flex-wrap items-center gap-3">
                            @if($book->category)
                                <span class="status-badge bg-amber-50 text-amber-700 border border-amber-200">
                                    <i class="fas fa-tag text-xs"></i>{{ $book->category->name }}
                                </span>
                            @endif
                            @if($book->language)
                                <span class="status-badge bg-blue-50 text-blue-700 border border-blue-200">
                                    <i class="fas fa-globe text-xs"></i>{{ $book->language }}
                                </span>
                            @endif
                            @if($book->publication_year)
                                <span class="status-badge bg-gray-50 text-gray-600 border border-gray-200">
                                    <i class="far fa-calendar text-xs"></i>{{ $book->publication_year }}
                                </span>
                            @endif
                        </div>

                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mt-2">{{ $book->title }}</h1>
                        @if($book->subtitle)
                            <p class="text-lg text-gray-500 font-['Inter']">{{ $book->subtitle }}</p>
                        @endif

                        @if($book->authors->count())
                            <p class="text-gray-600 flex items-center gap-2 mt-2">
                                <i class="fas fa-feather text-[#c4955d]"></i>
                                <span>oleh <strong>{{ $book->authors->pluck('name')->implode(', ') }}</strong></span>
                            </p>
                        @endif
                    </div>

                    <!-- Info Grid -->
                    <div class="fade-in stagger-2 mt-8 grid grid-cols-2 gap-6 p-6 rounded-2xl bg-gray-50/50">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Penerbit</p>
                            <p class="text-sm font-semibold text-gray-800 mt-1">{{ $book->publisher?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Edisi</p>
                            <p class="text-sm font-semibold text-gray-800 mt-1">{{ $book->edition ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Halaman</p>
                            <p class="text-sm font-semibold text-gray-800 mt-1">{{ $book->pages ? $book->pages . ' hlm' : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">DDC</p>
                            <p class="text-sm font-semibold text-gray-800 mt-1 font-mono">{{ $book->ddc_classification ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Availability -->
                    <div class="fade-in stagger-3 mt-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-chart-pie text-[#c4955d]"></i>
                            Ketersediaan
                        </h3>
                        @php
                            $available = $book->bookCopies->where('status', 'available');
                            $borrowed = $book->bookCopies->whereIn('status', ['borrowed']);
                            $damaged = $book->bookCopies->where('status', 'damaged');
                            $lost = $book->bookCopies->where('status', 'lost');
                        @endphp
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-center">
                                <p class="text-3xl font-bold text-emerald-600 font-['Playfair_Display']">{{ $available->count() }}</p>
                                <p class="text-xs text-emerald-700 font-medium mt-1">Tersedia</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-center">
                                <p class="text-3xl font-bold text-amber-600 font-['Playfair_Display']">{{ $borrowed->count() }}</p>
                                <p class="text-xs text-amber-700 font-medium mt-1">Dipinjam</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-center">
                                <p class="text-3xl font-bold text-red-600 font-['Playfair_Display']">{{ $damaged->count() }}</p>
                                <p class="text-xs text-red-700 font-medium mt-1">Rusak</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200 text-center">
                                <p class="text-3xl font-bold text-gray-600 font-['Playfair_Display']">{{ $lost->count() }}</p>
                                <p class="text-xs text-gray-700 font-medium mt-1">Hilang</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action -->
                    <div class="fade-in stagger-4 mt-8 flex flex-wrap gap-3">
                        @if($available->count() > 0)
                            <div class="btn-gold px-6 py-3.5 rounded-2xl font-semibold inline-flex items-center gap-2 cursor-default">
                                <i class="fas fa-check-circle"></i>
                                Buku Tersedia untuk Dipinjam
                            </div>
                        @else
                            <div class="px-6 py-3.5 rounded-2xl font-semibold inline-flex items-center gap-2 bg-gray-100 text-gray-500 cursor-default">
                                <i class="fas fa-clock"></i>
                                Semua Eksemplar Sedang Dipinjam
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($book->description || $book->abstract)
                <div class="border-t border-gray-100 p-8 lg:p-10">
                    <div class="fade-in max-w-3xl">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-align-left text-[#c4955d]"></i>
                            Deskripsi
                        </h3>
                        <div class="prose prose-gray max-w-none">
                            <p class="text-gray-600 leading-relaxed">{{ $book->description ?? $book->abstract ?? 'Tidak ada deskripsi.' }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Copy Locations -->
        @if($book->bookCopies->where('is_active', true)->count() > 0)
            <div class="glass-card mt-8 p-8 lg:p-10">
                <div class="fade-in">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="fas fa-location-dot text-[#c4955d]"></i>
                        Lokasi Eksemplar
                    </h3>
                    <div class="space-y-3">
                        @foreach($book->bookCopies->where('is_active', true) as $copy)
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center shadow-sm">
                                        <i class="fas fa-barcode text-gray-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-mono text-sm font-semibold text-gray-800">{{ $copy->barcode }}</p>
                                        <p class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                            <i class="fas fa-location-dot"></i>
                                            {{ $copy->bookshelf?->name ?? 'Belum ditempatkan' }}
                                            @if($copy->bookshelf?->location)
                                                — {{ $copy->bookshelf->location }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <span class="status-badge text-xs
                                    @if($copy->status == 'available') bg-emerald-100 text-emerald-700 border border-emerald-200
                                    @elseif($copy->status == 'borrowed') bg-amber-100 text-amber-700 border border-amber-200
                                    @elseif($copy->status == 'reserved') bg-blue-100 text-blue-700 border border-blue-200
                                    @else bg-gray-100 text-gray-600 border border-gray-200
                                    @endif">
                                    <i class="fas fa-circle text-[0.375rem]"></i>
                                    {{ ucfirst($copy->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Related Books -->
        @if($relatedBooks->count() > 0)
            <section class="mt-12">
                <div class="fade-in">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-bold text-gray-900">Buku Terkait</h2>
                        <a href="{{ route('opac.index', ['category' => $book->category_id]) }}" class="text-sm text-[#c4955d] hover:text-[#b8864d] transition-colors font-medium">
                            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach($relatedBooks as $related)
                            <a href="{{ route('opac.show', $related) }}" class="related-card bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                                <div class="aspect-[3/4] rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden mb-3">
                                    @if($related->cover_image)
                                        <img src="{{ asset('storage/' . $related->cover_image) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-book text-3xl text-gray-300"></i>
                                    @endif
                                </div>
                                <h4 class="text-sm font-semibold text-gray-900 line-clamp-2">{{ $related->title }}</h4>
                                @if($related->authors->count())
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $related->authors->pluck('name')->implode(', ') }}</p>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Back Button -->
        <div class="text-center mt-12 fade-in">
            <a href="{{ route('opac.index') }}" class="btn-gold inline-flex items-center gap-3 px-8 py-4 rounded-2xl font-semibold">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Katalog
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="hero-gradient mt-16">
        <div class="max-w-7xl mx-auto px-6 py-8 text-center text-sm text-white/50">
            <p>&copy; {{ date('Y') }} Perpustakaan Ilham Berkah. <span class="text-white/30">Dibangun dengan <i class="fas fa-heart text-red-400"></i> untuk literasi</span></p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.glass-card, section, .fade-in').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>