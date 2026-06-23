<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Online - Perpustakaan Ilham Berkah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #faf8f5; overflow-x: hidden; }
        h1, h2, h3, h4 { font-family: 'Playfair Display', serif; }
        .bg-pattern { background-image: radial-gradient(rgba(139,92,74,0.06) 1px, transparent 1px); background-size: 30px 30px; }
        .hero-gradient { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); }
        .book-card { background: white; border-radius: 20px; overflow: hidden; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); border: 1px solid rgba(0,0,0,0.04); }
        .book-card:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); border-color: rgba(196,149,93,0.3); }
        .book-card:hover .book-cover { transform: scale(1.05); }
        .book-cover { transition: transform 0.5s ease; }
        .search-box { transition: all 0.3s ease; }
        .search-box:focus-within { box-shadow: 0 0 0 3px rgba(196,149,93,0.3); border-color: #c4955d; }
        .gradient-text { background: linear-gradient(135deg, #c4955d 0%, #e8c98a 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .btn-gold { background: linear-gradient(135deg, #c4955d 0%, #e8c98a 100%); color: #1a1a2e; transition: all 0.3s ease; }
        .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(196,149,93,0.35); }
        .btn-outline-gold { border: 2px solid #c4955d; color: #c4955d; transition: all 0.3s ease; }
        .btn-outline-gold:hover { background: #c4955d; color: white; }
        .tag { display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; }
        .fade-in { opacity: 0; transform: translateY(20px); animation: fadeUp 0.6s ease forwards; }
        @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .pagination { display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap; }
        .pagination a, .pagination span { padding: 0.5rem 1rem; border-radius: 10px; font-size: 0.875rem; transition: all 0.2s; border: 1px solid #e5e7eb; }
        .pagination a:hover { background: #c4955d; color: white; border-color: #c4955d; }
        .pagination .active { background: #c4955d; color: white; border-color: #c4955d; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="hero-gradient sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg">
                    <i class="fas fa-book-open text-white text-lg"></i>
                </div>
                <div class="hidden sm:block">
                    <p class="text-white font-bold font-['Playfair_Display']">Ilham Berkah</p>
                    <p class="text-xs text-white/50">Katalog Online</p>
                </div>
            </a>
            <div class="flex items-center gap-3">
                <a href="/" class="px-4 py-2 text-sm text-white/70 hover:text-white transition-colors">
                    <i class="fas fa-home mr-1.5"></i>Beranda
                </a>
                <a href="{{ route('filament.admin.auth.login') }}" class="btn-gold px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                    <i class="fas fa-lock"></i>
                    <span class="hidden sm:inline">Admin</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Search -->
    <section class="hero-gradient relative overflow-hidden">
        <div class="absolute inset-0 bg-pattern opacity-30"></div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-white/5 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-6 py-16 lg:py-24 text-center">
            <div class="fade-in max-w-3xl mx-auto space-y-6">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-amber-300 text-sm border border-white/10">
                    <i class="fas fa-sparkles text-xs"></i>
                    Telusuri {{ $books->total() }} judul buku
                </span>
                <h1 class="text-4xl lg:text-6xl font-bold text-white">Temukan Buku <span class="gradient-text">Impianmu</span></h1>
                <p class="text-white/60 text-lg max-w-xl mx-auto">Cari judul, pengarang, atau ISBN buku yang Anda butuhkan dari koleksi perpustakaan kami</p>

                <form action="{{ route('opac.index') }}" method="GET" class="max-w-2xl mx-auto mt-8">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1 relative">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-[#c4955d]"></i>
                            <input type="text" name="q" value="{{ $query ?? '' }}" 
                                placeholder="Cari judul, pengarang, ISBN..." 
                                class="search-box w-full pl-12 pr-4 py-4 rounded-2xl bg-white/10 border border-white/20 text-white placeholder:text-white/40 focus:outline-none focus:bg-white/15">
                        </div>
                        <button type="submit" class="btn-gold px-8 py-4 rounded-2xl font-semibold flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            <span>Cari</span>
                        </button>
                    </div>
                    <div class="flex flex-wrap justify-center gap-3 mt-4">
                        <select name="category" class="px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white text-sm focus:outline-none focus:border-amber-400">
                            <option value="" class="text-gray-800">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" class="text-gray-800" {{ $categoryId == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <select name="language" class="px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white text-sm focus:outline-none focus:border-amber-400">
                            <option value="" class="text-gray-800">Semua Bahasa</option>
                            @foreach($languages as $lang)
                                <option value="{{ $lang }}" class="text-gray-800" {{ $language == $lang ? 'selected' : '' }}>{{ $lang }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-[#faf8f5] to-transparent"></div>
    </section>

    <!-- Results -->
    <main class="max-w-7xl mx-auto px-6 py-12">
        @if($query || $categoryId || $language)
            <div class="fade-in flex items-center justify-between mb-8">
                <p class="text-gray-500">
                    <i class="fas fa-search mr-2 text-[#c4955d]"></i>
                    Menampilkan <span class="font-semibold text-gray-800">{{ $books->total() }}</span> hasil 
                    @if($query) untuk "<span class="font-semibold text-gray-800">{{ $query }}</span>" @endif
                </p>
                <a href="{{ route('opac.index') }}" class="text-sm text-[#c4955d] hover:text-[#b8864d] transition-colors">
                    <i class="fas fa-times mr-1"></i>Reset
                </a>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($books as $book)
                <a href="{{ route('opac.show', $book) }}" class="book-card group fade-in">
                    <div class="relative h-56 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="book-cover w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-book-open text-5xl text-gray-300 mb-2"></i>
                                    <p class="text-xs text-gray-400">No Cover</p>
                                </div>
                            </div>
                        @endif
                        @php $avail = $book->bookCopies->count(); @endphp
                        <div class="absolute top-4 right-4">
                            @if($avail > 0)
                                <span class="tag bg-emerald-500 text-white shadow-lg shadow-emerald-500/20">
                                    <i class="fas fa-check-circle text-xs"></i>{{ $avail }} Tersedia
                                </span>
                            @else
                                <span class="tag bg-red-500 text-white shadow-lg shadow-red-500/20">
                                    <i class="fas fa-times-circle text-xs"></i>Habis
                                </span>
                            @endif
                        </div>
                        @if($book->category)
                            <div class="absolute bottom-4 left-4">
                                <span class="tag bg-white/90 text-gray-700 shadow-lg backdrop-blur-sm">
                                    <i class="fas fa-tag text-[#c4955d] text-xs"></i>{{ $book->category->name }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-gray-900 group-hover:text-[#c4955d] transition-colors line-clamp-2">{{ $book->title }}</h3>
                        @if($book->subtitle)
                            <p class="text-sm text-gray-500 mt-1 line-clamp-1">{{ $book->subtitle }}</p>
                        @endif
                        <div class="mt-4 space-y-2">
                            @if($book->authors->count())
                                <p class="text-sm text-gray-600 flex items-center gap-2">
                                    <i class="fas fa-feather text-[#c4955d] w-4"></i>
                                    <span>{{ $book->authors->pluck('name')->implode(', ') }}</span>
                                </p>
                            @endif
                            @if($book->publisher)
                                <p class="text-sm text-gray-500 flex items-center gap-2">
                                    <i class="fas fa-building text-gray-400 w-4"></i>
                                    <span>{{ $book->publisher->name }}</span>
                                </p>
                            @endif
                            @if($book->isbn)
                                <p class="text-sm text-gray-400 flex items-center gap-2">
                                    <i class="fas fa-barcode text-gray-400 w-4"></i>
                                    <span class="font-mono">{{ $book->isbn }}</span>
                                </p>
                            @endif
                        </div>
                        <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-sm text-gray-400">
                                <i class="far fa-calendar mr-1"></i>{{ $book->publication_year ?? '-' }}
                            </span>
                            <span class="text-sm font-medium text-[#c4955d] group-hover:gap-3 flex items-center gap-2 transition-all">
                                Detail <i class="fas fa-arrow-right text-xs"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20">
                    <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-book-open text-4xl text-gray-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 font-['Playfair_Display']">Buku Tidak Ditemukan</h3>
                    <p class="text-gray-500 mt-2 max-w-md mx-auto">Maaf, buku yang Anda cari tidak ditemukan. Coba gunakan kata kunci lain atau reset filter pencarian.</p>
                    <a href="{{ route('opac.index') }}" class="btn-gold inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold mt-6">
                        <i class="fas fa-arrow-left"></i>Kembali ke Katalog
                    </a>
                </div>
            @endforelse
        </div>

        @if($books->hasPages())
            <div class="mt-12">
                {{ $books->links('vendor.pagination.tailwind') }}
            </div>
        @endif

        <!-- Quick Stats -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-6 text-center border border-gray-100 shadow-sm">
                <i class="fas fa-book text-2xl text-[#c4955d] mb-2"></i>
                <p class="text-2xl font-bold font-['Playfair_Display'] text-gray-900">{{ $books->total() }}</p>
                <p class="text-sm text-gray-500">Total Judul</p>
            </div>
            <div class="bg-white rounded-2xl p-6 text-center border border-gray-100 shadow-sm">
                <i class="fas fa-users text-2xl text-[#c4955d] mb-2"></i>
                <p class="text-2xl font-bold font-['Playfair_Display'] text-gray-900">{{ $categories->count() }}</p>
                <p class="text-sm text-gray-500">Kategori</p>
            </div>
            <div class="bg-white rounded-2xl p-6 text-center border border-gray-100 shadow-sm">
                <i class="fas fa-language text-2xl text-[#c4955d] mb-2"></i>
                <p class="text-2xl font-bold font-['Playfair_Display'] text-gray-900">{{ $languages->count() }}</p>
                <p class="text-sm text-gray-500">Bahasa</p>
            </div>
            <div class="bg-white rounded-2xl p-6 text-center border border-gray-100 shadow-sm">
                <i class="fas fa-check-circle text-2xl text-emerald-500 mb-2"></i>
                <p class="text-2xl font-bold font-['Playfair_Display'] text-gray-900">
                    @php $totalAvail = $books->sum(fn($b) => $b->bookCopies->count()); @endphp
                    {{ $totalAvail }}
                </p>
                <p class="text-sm text-gray-500">Tersedia</p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="hero-gradient mt-16">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-white/50">
                <p>&copy; {{ date('Y') }} Perpustakaan Ilham Berkah</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-amber-400 transition-colors"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-amber-400 transition-colors"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="hover:text-amber-400 transition-colors"><i class="fab fa-twitter"></i></a>
                </div>
                <p class="text-white/30">Dibangun dengan <i class="fas fa-heart text-red-400"></i> untuk literasi</p>
            </div>
        </div>
    </footer>

    <script>
        // Simple scroll reveal
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.book-card').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>