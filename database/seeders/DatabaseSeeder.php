<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Destination;
use App\Models\EconomicPotential;
use App\Models\Hamlet;
use App\Models\Mission;
use App\Models\Official;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\VillageHeadMessage;
use App\Models\VillageProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Sebagian angka (jumlah KK, tahun berdiri, nama kepala desa) berasal dari
 * sumber terbuka dan BELUM diverifikasi ke pihak Desa Puraseda — lihat PRD §13-C.
 * Hanya untuk kebutuhan development/demo, jangan dipakai langsung di production.
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Superadmin Puraseda',
            'email' => 'superadmin@desapuraseda.com',
            'role' => User::ROLE_SUPERADMIN,
        ]);

        User::factory()->create([
            'name' => 'Admin Desa',
            'email' => 'admin@desapuraseda.com',
            'role' => User::ROLE_ADMIN,
        ]);

        $this->seedSiteSettings();
        $this->seedVillageProfile();
        $this->seedMissions();
        $this->seedVillageHeadMessage();
        $this->seedHamlets();
        $this->seedOfficials();
        $this->seedCategoriesAndArticles();
        $this->seedDestinations();
        $this->seedEconomicPotentials();
        $this->seedContactMessages();
    }

    private function seedSiteSettings(): void
    {
        SiteSetting::create([
            'address' => 'Jl. Raya Puraseda, Kecamatan Leuwiliang, Kabupaten Bogor, Jawa Barat 16640',
            'phone' => '(0251) 123-4567',
            'whatsapp' => '628123456789',
            'email' => 'kantordesa@desapuraseda.com',
            'office_hours_weekday' => 'Senin–Jumat, 08.00–15.00 WIB',
            'office_hours_weekend' => 'Sabtu–Minggu, Tutup',
            'office_lat' => -6.5808,
            'office_lng' => 106.6142,
            'google_maps_url' => 'https://maps.google.com/?q=Desa+Puraseda+Leuwiliang',
            'facebook_url' => null,
            'instagram_url' => 'https://instagram.com/desapuraseda',
            'youtube_url' => null,
        ]);
    }

    private function seedVillageProfile(): void
    {
        VillageProfile::create([
            'history_content' => "Nama Puraseda dipercaya berasal dari dua kata dalam bahasa Sunda kuno: \"pura\" yang berarti kuil atau tempat suci, dan \"seda\" yang bermakna tenang atau damai. Gabungan keduanya menggambarkan citra sebuah lembah yang sejak dahulu dipandang sebagai tempat yang tenteram dan sarat nilai spiritual.\n\n"
                ."Salah satu catatan yang menarik dari sejarah geologis kawasan ini adalah dugaan bahwa lembah Puraseda merupakan bekas kaldera gunung berapi purba. Dugaan ini diperkuat oleh temuan batuan vulkanik di sekitar Kampung Babakan Empang, yang oleh warga setempat sudah dikenal turun-temurun sebagai bukti aktivitas vulkanik masa lampau. Kondisi tanah yang subur di wilayah Puraseda hingga kini dipercaya merupakan warisan dari proses geologis tersebut, yang kemudian menjadi modal utama masyarakat dalam bertani dan berkebun.\n\n"
                ."Di Kampung Tengah, salah satu dusun tertua di Desa Puraseda, berdiri sebuah masjid peninggalan masa kolonial yang menjadi saksi bisu perjalanan panjang masyarakat desa. Masjid ini tidak hanya berfungsi sebagai tempat ibadah, tetapi juga menjadi pusat kegiatan sosial dan pendidikan agama bagi warga sejak beberapa generasi lalu. Arsitekturnya yang sederhana namun kokoh mencerminkan gaya bangunan khas pedesaan Jawa Barat pada masanya.\n\n"
                ."[TODO: lengkapi naskah sejarah ini bersama pihak desa — target minimal 600 kata sesuai kebutuhan SEO PRD §11-D. Bagian di atas adalah kerangka awal berdasarkan sumber terbuka dan wajib diverifikasi.]",
            'founded_year' => 1950,
            'vision' => 'Mewujudkan Desa Puraseda yang mandiri, sejahtera, dan berbudaya menuju masyarakat yang religius dan berdaya saing.',
            'area_size' => 140,
            'area_unit' => 'Ha',
            'altitude' => 350,
            'altitude_unit' => 'Mdpl',
            'boundary_north' => 'Desa Karacak',
            'boundary_south' => 'Desa Leuwiliang',
            'boundary_east' => 'Desa Purasari',
            'boundary_west' => 'Desa Barengkok',
            'total_population' => 12500,
            'total_families' => 3586,
            'total_hamlets' => 4,
            'map_center_lat' => -6.5808,
            'map_center_lng' => 106.6142,
            'map_zoom' => 14,
        ]);
    }

    private function seedMissions(): void
    {
        $missions = [
            ['title' => 'Tata Kelola Transparan', 'description' => 'Menyelenggarakan pemerintahan desa yang bersih, transparan, dan akuntabel dalam pelayanan kepada masyarakat.'],
            ['title' => 'Ekonomi Kerakyatan', 'description' => 'Mengembangkan potensi ekonomi lokal berbasis pertanian dan UMKM untuk meningkatkan kesejahteraan warga.'],
            ['title' => 'Infrastruktur Merata', 'description' => 'Membangun dan memelihara infrastruktur dasar yang merata di seluruh wilayah dusun.'],
            ['title' => 'Pelestarian Budaya', 'description' => 'Menjaga dan melestarikan nilai-nilai budaya serta kearifan lokal sebagai identitas desa.'],
        ];

        foreach ($missions as $i => $mission) {
            Mission::create([...$mission, 'order' => $i]);
        }
    }

    private function seedVillageHeadMessage(): void
    {
        VillageHeadMessage::create([
            'name' => 'Asep Ruhiyat',
            'position' => 'Kepala Desa',
            'message' => 'Assalamualaikum warahmatullahi wabarakatuh. Selamat datang di website resmi Desa Puraseda. Website ini kami hadirkan sebagai wujud komitmen pemerintah desa dalam memberikan informasi yang terbuka dan mudah diakses oleh seluruh warga maupun masyarakat luas. Mari bersama-sama membangun Desa Puraseda yang lebih maju, sejahtera, dan berbudaya.',
        ]);
    }

    private function seedHamlets(): void
    {
        $hamlets = [
            ['name' => 'Kampung Tengah', 'population' => 3400, 'families' => 950],
            ['name' => 'Babakan Empang', 'population' => 3100, 'families' => 880],
            ['name' => 'Kampung Sawah', 'population' => 2900, 'families' => 820],
            ['name' => 'Kampung Hilir', 'population' => 3100, 'families' => 936],
        ];

        foreach ($hamlets as $i => $hamlet) {
            Hamlet::create([...$hamlet, 'order' => $i]);
        }
    }

    private function seedOfficials(): void
    {
        $officials = [
            ['name' => 'Asep Ruhiyat', 'position' => 'Kepala Desa', 'level' => 1, 'order' => 0],
            ['name' => 'Dedi Supriadi', 'position' => 'Sekretaris Desa', 'level' => 2, 'order' => 0],
            ['name' => 'Yayat Sudrajat', 'position' => 'Kaur Keuangan', 'level' => 3, 'order' => 0],
            ['name' => 'Rina Marlina', 'position' => 'Kaur Perencanaan', 'level' => 3, 'order' => 1],
            ['name' => 'Ujang Sutisna', 'position' => 'Kasi Pemerintahan', 'level' => 3, 'order' => 2],
            ['name' => 'Nia Kurniasih', 'position' => 'Kasi Kesejahteraan', 'level' => 3, 'order' => 3],
            ['name' => 'Endang Suryana', 'position' => 'Kepala Dusun Kampung Tengah', 'level' => 4, 'order' => 0],
            ['name' => 'Iwan Setiawan', 'position' => 'Kepala Dusun Babakan Empang', 'level' => 4, 'order' => 1],
            ['name' => 'Maman Abdurahman', 'position' => 'Kepala Dusun Kampung Sawah', 'level' => 4, 'order' => 2],
            ['name' => 'Wawan Gunawan', 'position' => 'Kepala Dusun Kampung Hilir', 'level' => 4, 'order' => 3],
        ];

        foreach ($officials as $official) {
            Official::create([...$official, 'is_active' => true]);
        }
    }

    private function seedCategoriesAndArticles(): void
    {
        $categories = [
            ['name' => 'Berita Desa', 'slug' => 'berita-desa', 'color' => '#1F3D2E'],
            ['name' => 'Pembangunan', 'slug' => 'pembangunan', 'color' => '#6E8F6B'],
            ['name' => 'Kegiatan Warga', 'slug' => 'kegiatan-warga', 'color' => '#C98A4B'],
        ];

        $categoryModels = [];
        foreach ($categories as $i => $category) {
            $categoryModels[] = Category::create([...$category, 'order' => $i]);
        }

        $articles = [
            ['title' => 'Musyawarah Desa Bahas Rencana Pembangunan Jalan Dusun', 'category' => 0, 'featured' => true],
            ['title' => 'Panen Raya Padi Menthik di Kampung Sawah Meningkat 15%', 'category' => 1, 'featured' => false],
            ['title' => 'Warga Puraseda Gotong Royong Bersihkan Saluran Irigasi', 'category' => 2, 'featured' => false],
            ['title' => 'Pelatihan Pembuatan Gula Semut untuk Kelompok Tani', 'category' => 1, 'featured' => false],
            ['title' => 'Posyandu Balita Rutin Digelar di Empat Dusun', 'category' => 2, 'featured' => false],
            ['title' => 'Pembangunan Jembatan Penghubung Kampung Tengah Rampung', 'category' => 1, 'featured' => false],
            ['title' => 'Peringatan Hari Kemerdekaan Diramaikan Lomba Antar Dusun', 'category' => 2, 'featured' => false],
            ['title' => 'Sosialisasi Program Bantuan Bibit Ikan Mas', 'category' => 0, 'featured' => false],
            ['title' => 'Desa Puraseda Raih Predikat Desa Mandiri', 'category' => 0, 'featured' => false],
            ['title' => 'Kunjungan Dinas Pariwisata Kabupaten Bogor ke Puraseda', 'category' => 0, 'featured' => false],
        ];

        foreach ($articles as $i => $article) {
            Article::create([
                'category_id' => $categoryModels[$article['category']]->id,
                'title' => $article['title'],
                'slug' => \Illuminate\Support\Str::slug($article['title']),
                'excerpt' => 'Ringkasan sementara untuk artikel demo — ganti dengan ringkasan asli sebelum publikasi.',
                'content' => '<p>Isi artikel demo untuk keperluan pengembangan. Konten asli perlu diisi oleh admin desa sebelum artikel dipublikasikan ke publik.</p>',
                'author_name' => 'Admin Desa',
                'status' => 'published',
                'is_featured' => $article['featured'],
                'published_at' => now()->subDays(10 - $i),
            ]);
        }
    }

    private function seedDestinations(): void
    {
        $destinations = [
            [
                'name' => 'Curug Ciputri',
                'category' => 'wisata_alam',
                'short' => 'Air terjun alami dengan kolam jernih, cocok untuk wisata keluarga.',
                'hamlet' => 'Babakan Empang',
                'lat' => -6.5750,
                'lng' => 106.6100,
                'featured' => true,
            ],
            [
                'name' => 'Kebun Kawung Puraseda',
                'category' => 'agrowisata',
                'short' => 'Perkebunan pohon aren tempat produksi gula semut khas Puraseda.',
                'hamlet' => 'Kampung Sawah',
                'lat' => -6.5820,
                'lng' => 106.6180,
                'featured' => true,
            ],
            [
                'name' => 'Masjid Tua Kampung Tengah',
                'category' => 'wisata_budaya',
                'short' => 'Masjid peninggalan masa kolonial dengan nilai sejarah tinggi.',
                'hamlet' => 'Kampung Tengah',
                'lat' => -6.5795,
                'lng' => 106.6130,
                'featured' => false,
            ],
        ];

        foreach ($destinations as $i => $destination) {
            Destination::create([
                'name' => $destination['name'],
                'slug' => \Illuminate\Support\Str::slug($destination['name']),
                'category' => $destination['category'],
                'short_description' => $destination['short'],
                'description' => '<p>Deskripsi lengkap destinasi ini masih berupa draf demo. Perlu dilengkapi minimal 300 kata oleh admin desa sesuai kebutuhan SEO sebelum publikasi.</p>',
                'hamlet_name' => $destination['hamlet'],
                'latitude' => $destination['lat'],
                'longitude' => $destination['lng'],
                'is_featured' => $destination['featured'],
                'order' => $i,
            ]);
        }
    }

    private function seedEconomicPotentials(): void
    {
        $potentials = [
            ['title' => 'Gula Semut Aren', 'description' => 'Produk gula semut berbahan dasar nira pohon aren (kawung) khas Desa Puraseda, diolah oleh kelompok tani lokal.', 'icon' => 'wheat', 'tags' => ['Gula Aren', 'Kawung', 'UMKM']],
            ['title' => 'Budidaya Ikan Mas', 'description' => 'Keramba ikan mas di sepanjang aliran sungai desa menjadi salah satu sumber penghasilan tambahan warga.', 'icon' => 'fish', 'tags' => ['Perikanan', 'Keramba']],
            ['title' => 'Padi Menthik', 'description' => 'Varietas padi unggulan yang menjadi komoditas utama pertanian di Desa Puraseda.', 'icon' => 'sprout', 'tags' => ['Padi Menthik', 'Sayur Mayur']],
        ];

        foreach ($potentials as $i => $potential) {
            EconomicPotential::create([...$potential, 'order' => $i]);
        }
    }

    private function seedContactMessages(): void
    {
        ContactMessage::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'message' => 'Selamat siang, saya ingin bertanya mengenai jadwal pelayanan surat pengantar di kantor desa. Terima kasih.',
            'ip_address' => '127.0.0.1',
            'is_read' => false,
        ]);
    }
}
