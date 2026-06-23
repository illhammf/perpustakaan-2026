<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Bookshelf;
use App\Models\Category;
use App\Models\LibrarySetting;
use App\Models\Member;
use App\Models\MemberType;
use App\Models\Publisher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LibrarySeeder extends Seeder
{
    public function run(): void
    {
        // Member Types
        $memberTypes = [
            ['name' => 'Siswa', 'slug' => 'siswa', 'max_loans' => 3, 'loan_duration_days' => 7, 'fine_per_day' => 500],
            ['name' => 'Mahasiswa', 'slug' => 'mahasiswa', 'max_loans' => 5, 'loan_duration_days' => 14, 'fine_per_day' => 1000],
            ['name' => 'Guru/Dosen', 'slug' => 'guru-dosen', 'max_loans' => 7, 'loan_duration_days' => 21, 'fine_per_day' => 1000],
            ['name' => 'Umum', 'slug' => 'umum', 'max_loans' => 3, 'loan_duration_days' => 7, 'fine_per_day' => 2000],
        ];
        foreach ($memberTypes as $type) {
            MemberType::create($type);
        }

        // Bookshelves
        $bookshelves = [];
        $shelfCodes = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'D1', 'D2'];
        foreach ($shelfCodes as $i => $code) {
            $bookshelves[] = Bookshelf::create([
                'code' => $code,
                'name' => "Rak {$code}",
                'location' => ($i < 4) ? 'Lantai 1' : 'Lantai 2',
                'capacity' => 100,
            ]);
        }

        // Categories
        $categories = [
            ['name' => 'Fiksi', 'slug' => 'fiksi'],
            ['name' => 'Non-Fiksi', 'slug' => 'non-fiksi'],
            ['name' => 'Ilmu Pengetahuan Alam', 'slug' => 'ipa'],
            ['name' => 'Ilmu Pengetahuan Sosial', 'slug' => 'ips'],
            ['name' => 'Teknologi', 'slug' => 'teknologi'],
            ['name' => 'Agama', 'slug' => 'agama'],
            ['name' => 'Sejarah', 'slug' => 'sejarah'],
            ['name' => 'Bahasa', 'slug' => 'bahasa'],
            ['name' => 'Seni', 'slug' => 'seni'],
            ['name' => 'Olahraga', 'slug' => 'olahraga'],
        ];
        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Publishers
        $publishers = [
            'Gramedia Pustaka Utama', 'Erlangga', 'Yudhistira', 'Mizan', 'Pustaka Jaya',
            'Balai Pustaka', 'Kompas Gramedia', 'Bentang Pustaka', 'Gadjah Mada University Press',
            'ITB Press', 'Rajawali Press', 'Prenada Media', 'Remaja Rosdakarya', 'Alfabeta',
        ];
        foreach ($publishers as $pub) {
            Publisher::create(['name' => $pub, 'slug' => \Str::slug($pub)]);
        }

        // Authors
        $authors = [
            ['name' => 'Andrea Hirata', 'slug' => 'andrea-hirata'],
            ['name' => 'Pramoedya Ananta Toer', 'slug' => 'pramoedya-ananta-toer'],
            ['name' => 'Tere Liye', 'slug' => 'tere-liye'],
            ['name' => 'Dee Lestari', 'slug' => 'dee-lestari'],
            ['name' => 'Habiburrahman El Shirazy', 'slug' => 'habiburrahman-el-shirazy'],
            ['name' => 'Seno Gumira Ajidarma', 'slug' => 'seno-gumira-ajidarma'],
            ['name' => 'Sapardi Djoko Damono', 'slug' => 'sapardi-djoko-damono'],
            ['name' => 'Mochtar Lubis', 'slug' => 'mochtar-lubis'],
            ['name' => 'N.H. Dini', 'slug' => 'nh-dini'],
            ['name' => 'Rendra', 'slug' => 'rendra'],
            ['name' => 'B.J. Habibie', 'slug' => 'bj-habibie'],
            ['name' => 'Ir. Soekarno', 'slug' => 'ir-soekarno'],
            ['name' => 'Moh. Hatta', 'slug' => 'moh-hatta'],
            ['name' => 'Ki Hajar Dewantara', 'slug' => 'ki-hajar-dewantara'],
            ['name' => 'Tan Malaka', 'slug' => 'tan-malaka'],
        ];
        foreach ($authors as $author) {
            Author::create($author);
        }

        // Books
        $bookData = [
            ['title' => 'Laskar Pelangi', 'isbn' => '9789793062792', 'author_ids' => [1], 'publisher_id' => 1, 'category_id' => 1, 'pages' => 534, 'publication_year' => 2005],
            ['title' => 'Bumi Manusia', 'isbn' => '9789799731243', 'author_ids' => [2], 'publisher_id' => 1, 'category_id' => 1, 'pages' => 535, 'publication_year' => 1980],
            ['title' => 'Hafalan Shalat Delisa', 'isbn' => '9789791140558', 'author_ids' => [3], 'publisher_id' => 1, 'category_id' => 6, 'pages' => 380, 'publication_year' => 2005],
            ['title' => 'Perahu Kertas', 'isbn' => '9789791227343', 'author_ids' => [4], 'publisher_id' => 1, 'category_id' => 1, 'pages' => 444, 'publication_year' => 2009],
            ['title' => 'Ayat-Ayat Cinta', 'isbn' => '9789791140999', 'author_ids' => [5], 'publisher_id' => 4, 'category_id' => 6, 'pages' => 420, 'publication_year' => 2004],
            ['title' => 'Sang Pemimpi', 'isbn' => '9789793062808', 'author_ids' => [1], 'publisher_id' => 1, 'category_id' => 1, 'pages' => 292, 'publication_year' => 2006],
            ['title' => 'Detik-Detik Yang Menentukan', 'isbn' => '9789796058349', 'author_ids' => [11], 'publisher_id' => 7, 'category_id' => 7, 'pages' => 624, 'publication_year' => 2006],
            ['title' => 'Madilog', 'isbn' => '9789799994363', 'author_ids' => [15], 'publisher_id' => 6, 'category_id' => 2, 'pages' => 500, 'publication_year' => 1999],
            ['title' => 'Pendidikan Karakter', 'isbn' => '9789796923455', 'author_ids' => [14], 'publisher_id' => 5, 'category_id' => 2, 'pages' => 200, 'publication_year' => 2010],
            ['title' => 'Ilmu Pengetahuan Alam Kelas 7', 'isbn' => '9786022418879', 'author_ids' => [1], 'publisher_id' => 2, 'category_id' => 3, 'pages' => 300, 'publication_year' => 2017],
            ['title' => 'Teknologi Informasi dan Komunikasi', 'isbn' => '9789792942213', 'author_ids' => [3], 'publisher_id' => 9, 'category_id' => 5, 'pages' => 250, 'publication_year' => 2018],
            ['title' => 'Belajar Pemrograman Laravel', 'isbn' => '9789792942214', 'author_ids' => [1, 3], 'publisher_id' => 10, 'category_id' => 5, 'pages' => 400, 'publication_year' => 2020],
        ];

        foreach ($bookData as $i => $data) {
            $book = Book::create([
                'title' => $data['title'],
                'slug' => \Str::slug($data['title']),
                'isbn' => $data['isbn'],
                'publisher_id' => $data['publisher_id'],
                'category_id' => $data['category_id'],
                'pages' => $data['pages'],
                'publication_year' => $data['publication_year'],
                'language' => 'Indonesia',
                'description' => 'Deskripsi buku ' . $data['title'],
            ]);
            $book->authors()->attach($data['author_ids']);

            // Create 2-3 copies per book
            for ($j = 0; $j < rand(2, 3); $j++) {
                BookCopy::create([
                    'book_id' => $book->id,
                    'bookshelf_id' => $bookshelves[array_rand($bookshelves)]->id,
                    'barcode' => 'BK-' . str_pad($book->id, 5, '0', STR_PAD_LEFT) . '-' . str_pad($j + 1, 2, '0', STR_PAD_LEFT),
                    'condition' => 'good',
                    'status' => 'available',
                    'acquisition_date' => now()->subMonths(rand(1, 24)),
                    'acquisition_type' => 'purchase',
                    'price' => rand(50000, 150000),
                ]);
            }
        }

        // Members
        $users = User::all();
        $memberTypes = MemberType::all();
        $member = Member::create([
            'user_id' => $users->first()?->id,
            'member_type_id' => $memberTypes->first()->id,
            'member_number' => 'MB-202501-0001',
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@example.com',
            'phone' => '081234567890',
            'status' => 'active',
            'registered_at' => now()->subYear(),
            'expired_at' => now()->addYear(),
        ]);

        for ($i = 2; $i <= 10; $i++) {
            Member::create([
                'member_type_id' => $memberTypes->random()->id,
                'member_number' => 'MB-202501-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => fake()->name(),
                'email' => fake()->email(),
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'status' => $i <= 8 ? 'active' : 'expired',
                'registered_at' => now()->subMonths(rand(1, 12)),
                'expired_at' => now()->addMonths(rand(1, 12)),
            ]);
        }

        // Library Settings
        $settings = [
            ['key' => 'library_name', 'value' => 'Perpustakaan Ilham Berkah', 'type' => 'text', 'group' => 'general'],
            ['key' => 'library_address', 'value' => 'Jl. Merdeka No. 123, Jakarta', 'type' => 'text', 'group' => 'general'],
            ['key' => 'library_phone', 'value' => '021-12345678', 'type' => 'text', 'group' => 'general'],
            ['key' => 'library_email', 'value' => 'info@ilhamberkah.perpus', 'type' => 'text', 'group' => 'general'],
            ['key' => 'default_loan_duration', 'value' => '14', 'type' => 'number', 'group' => 'loan'],
            ['key' => 'max_loans_per_member', 'value' => '5', 'type' => 'number', 'group' => 'loan'],
            ['key' => 'fine_per_day', 'value' => '1000', 'type' => 'number', 'group' => 'loan'],
            ['key' => 'max_renewals', 'value' => '1', 'type' => 'number', 'group' => 'loan'],
            ['key' => 'member_card_prefix', 'value' => 'MB', 'type' => 'text', 'group' => 'membership'],
            ['key' => 'member_expiry_years', 'value' => '1', 'type' => 'number', 'group' => 'membership'],
            ['key' => 'opac_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'opac'],
            ['key' => 'opac_title', 'value' => 'Katalog Online Perpustakaan Ilham Berkah', 'type' => 'text', 'group' => 'opac'],
        ];
        foreach ($settings as $setting) {
            LibrarySetting::create($setting);
        }

        $this->command->info('Library seeded successfully!');
    }
}
