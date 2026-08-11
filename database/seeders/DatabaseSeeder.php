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
use App\Models\User;
use App\Models\VillageEvent;
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

        $this->seedVillageProfile();
        $this->seedMissions();
        $this->seedVillageHeadMessage();
        $this->seedHamlets();
        $this->seedOfficials();
        $this->seedCategoriesAndArticles();
        $this->seedDestinations();
        $this->seedEconomicPotentials();
        $this->seedContactMessages();
        $this->seedVillageEvents();
    }

    private function seedVillageProfile(): void
    {
        VillageProfile::create([
            'history_content' => '<p>Nama Puraseda dipercaya berasal dari dua kata dalam bahasa Sunda kuno: "pura" yang berarti kuil atau tempat suci, dan "seda" yang bermakna tenang atau damai. Gabungan keduanya menggambarkan citra sebuah lembah yang sejak dahulu dipandang sebagai tempat yang tenteram dan sarat nilai spiritual.</p>'
                .'<p>Salah satu catatan yang menarik dari sejarah geologis kawasan ini adalah dugaan bahwa lembah Puraseda merupakan bekas kaldera gunung berapi purba. Dugaan ini diperkuat oleh temuan batuan vulkanik di sekitar Kampung Babakan Empang, yang oleh warga setempat sudah dikenal turun-temurun sebagai bukti aktivitas vulkanik masa lampau. Kondisi tanah yang subur di wilayah Puraseda hingga kini dipercaya merupakan warisan dari proses geologis tersebut, yang kemudian menjadi modal utama masyarakat dalam bertani dan berkebun.</p>'
                .'<p>Di Kampung Tengah, salah satu dusun tertua di Desa Puraseda, berdiri sebuah masjid peninggalan masa kolonial yang menjadi saksi bisu perjalanan panjang masyarakat desa. Masjid ini tidak hanya berfungsi sebagai tempat ibadah, tetapi juga menjadi pusat kegiatan sosial dan pendidikan agama bagi warga sejak beberapa generasi lalu. Arsitekturnya yang sederhana namun kokoh mencerminkan gaya bangunan khas pedesaan Jawa Barat pada masanya.</p>'
                .'<p>[TODO: lengkapi naskah sejarah ini bersama pihak desa — target minimal 600 kata sesuai kebutuhan SEO PRD §11-D. Bagian di atas adalah kerangka awal berdasarkan sumber terbuka dan wajib diverifikasi.]</p>',
            'founded_year' => 1950,
            'vision' => 'Mewujudkan Desa Puraseda yang mandiri, sejahtera, dan berbudaya. Dicapai melalui tata kelola pemerintahan yang bersih, transparan, dan berpihak pada warga.',
            'area_size' => 1608.54,
            'area_unit' => 'Ha',
            'altitude' => 350,
            'altitude_unit' => 'Mdpl',
            'total_population' => 10393,
            'total_families' => 3066,
            'population_by_religion' => [
                ['label' => 'Islam', 'total' => 10393],
                ['label' => 'Kristen', 'total' => 0],
                ['label' => 'Hindu', 'total' => 0],
                ['label' => 'Budha', 'total' => 0],
                ['label' => 'Konghucu', 'total' => 0],
                ['label' => 'Kepercayaan', 'total' => 0],
            ],
            'population_by_marital_status' => [
                ['label' => 'Kawin', 'total' => 4791],
                ['label' => 'Belum Kawin', 'total' => 5160],
                ['label' => 'Cerai Hidup', 'total' => 123],
                ['label' => 'Cerai Mati', 'total' => 319],
            ],
            'population_by_education' => [
                ['label' => 'Strata III', 'male' => 0, 'female' => 0],
                ['label' => 'Strata II', 'male' => 1, 'female' => 0],
                ['label' => 'Strata I', 'male' => 30, 'female' => 27],
                ['label' => 'Diploma III', 'male' => 2, 'female' => 3],
                ['label' => 'Diploma I / II', 'male' => 6, 'female' => 4],
                ['label' => 'SLTA / Sederajat', 'male' => 475, 'female' => 311],
                ['label' => 'SLTP / Sederajat', 'male' => 640, 'female' => 486],
                ['label' => 'SD / Sederajat', 'male' => 2533, 'female' => 2515],
                ['label' => 'Tidak Tamat SD', 'male' => 669, 'female' => 617],
                ['label' => 'Tidak/Belum Sekolah', 'male' => 1021, 'female' => 1053],
            ],
            'population_by_occupation' => [
                ['label' => 'Tidak Bekerja', 'male' => 1189, 'female' => 1074],
                ['label' => 'Ibu Rumah Tangga', 'male' => 0, 'female' => 2757],
                ['label' => 'Pelajar / Mahasiswa', 'male' => 1354, 'female' => 1093],
                ['label' => 'Pensiunan', 'male' => 7, 'female' => 9],
                ['label' => 'Pegawai Negeri / ASN', 'male' => 6, 'female' => 9],
                ['label' => 'TNI / POLRI', 'male' => 0, 'female' => 0],
                ['label' => 'Perdagangan', 'male' => 2, 'female' => 0],
                ['label' => 'Pertanian / Perkebunan', 'male' => 39, 'female' => 0],
                ['label' => 'Peternakan', 'male' => 0, 'female' => 0],
                ['label' => 'Industri', 'male' => 1, 'female' => 0],
                ['label' => 'Karyawan', 'male' => 116, 'female' => 14],
                ['label' => 'Buruh', 'male' => 1893, 'female' => 22],
                ['label' => 'Tukang', 'male' => 0, 'female' => 0],
                ['label' => 'Wiraswasta', 'male' => 706, 'female' => 9],
                ['label' => 'Tokoh Politik', 'male' => 0, 'female' => 0],
                ['label' => 'Tokoh Agama', 'male' => 2, 'female' => 0],
                ['label' => 'Pekerja Medis', 'male' => 0, 'female' => 3],
                ['label' => 'Pekerja Media', 'male' => 0, 'female' => 0],
                ['label' => 'Pekerja Seni', 'male' => 0, 'female' => 0],
                ['label' => 'Pekerja Lainnya', 'male' => 62, 'female' => 26],
            ],
            'population_by_age_group' => [
                ['label' => '00 - 04 Tahun', 'male' => 420, 'female' => 355],
                ['label' => '05 - 09 Tahun', 'male' => 528, 'female' => 541],
                ['label' => '10 - 14 Tahun', 'male' => 521, 'female' => 573],
                ['label' => '15 - 19 Tahun', 'male' => 361, 'female' => 340],
                ['label' => '20 - 24 Tahun', 'male' => 505, 'female' => 500],
                ['label' => '25 - 29 Tahun', 'male' => 516, 'female' => 410],
                ['label' => '30 - 34 Tahun', 'male' => 465, 'female' => 412],
                ['label' => '35 - 39 Tahun', 'male' => 439, 'female' => 397],
                ['label' => '40 - 44 Tahun', 'male' => 375, 'female' => 357],
                ['label' => '45 - 49 Tahun', 'male' => 315, 'female' => 281],
                ['label' => '50 - 54 Tahun', 'male' => 272, 'female' => 266],
                ['label' => '55 - 59 Tahun', 'male' => 247, 'female' => 207],
                ['label' => '60 - 64 Tahun', 'male' => 172, 'female' => 143],
                ['label' => '65 - 69 Tahun', 'male' => 92, 'female' => 83],
                ['label' => '70 - 74 Tahun', 'male' => 77, 'female' => 62],
                ['label' => 'Lebih - 75 Tahun', 'male' => 72, 'female' => 89],
            ],
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
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'
                    .'<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>',
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
        $mapsUrl = 'https://share.google/CEfrd0fOYj1V4Gy4h';

        $potentials = [
            [
                'title' => 'Gula Semut Aren',
                'description' => 'Produk gula semut berbahan dasar nira pohon aren (kawung) khas Desa Puraseda, diolah oleh kelompok tani lokal.',
                'content' => 'Gula semut aren Puraseda diproduksi oleh kelompok tani dari nira pohon kawung yang tumbuh subur di lereng desa. Proses pengolahan dilakukan secara tradisional tanpa bahan pengawet, menghasilkan gula berbutir halus dengan aroma khas dan rasa yang lebih kaya dibanding gula pasir biasa. Produk ini sudah dipasarkan ke beberapa pasar di Kabupaten Bogor dan menjadi salah satu andalan ekonomi kreatif desa.',
                'sector' => 'makanan_minuman',
            ],
            [
                'title' => 'Budidaya Ikan Mas',
                'description' => 'Keramba ikan mas di sepanjang aliran sungai desa menjadi salah satu sumber penghasilan tambahan warga.',
                'content' => 'Sepanjang aliran sungai yang melintasi Desa Puraseda, warga memanfaatkan keramba jaring apung untuk budidaya ikan mas. Usaha ini dikelola secara berkelompok dan menjadi sumber penghasilan tambahan bagi puluhan keluarga, sekaligus memenuhi kebutuhan konsumsi ikan segar di pasar lokal Leuwiliang.',
                'sector' => 'peternakan_perikanan',
            ],
            [
                'title' => 'Padi Menthik',
                'description' => 'Varietas padi unggulan yang menjadi komoditas utama pertanian di Desa Puraseda.',
                'content' => 'Padi Menthik ditanam turun-temurun oleh petani Desa Puraseda karena kualitas berasnya yang pulen dan tahan terhadap kondisi tanah setempat. Komoditas ini menjadi tulang punggung ekonomi pertanian desa, dengan hasil panen sebagian besar dipasarkan ke wilayah Bogor dan sekitarnya.',
                'sector' => 'pertanian',
            ],
            [
                'title' => 'Warung Sembako Bu Aminah',
                'description' => 'Warung kelontong lengkap yang melayani kebutuhan pokok harian warga sekitar balai desa.',
                'content' => 'Warung Bu Aminah sudah berjualan sejak lebih dari sepuluh tahun dan menjadi tempat langganan warga untuk memenuhi kebutuhan sembako sehari-hari, mulai dari beras, minyak, hingga bumbu dapur.',
                'sector' => 'warung_sembako',
            ],
            [
                'title' => 'Toko Bangunan Sumber Jaya',
                'description' => 'Menyediakan material bangunan dan perkakas untuk kebutuhan renovasi rumah warga.',
                'content' => 'Toko Sumber Jaya melayani kebutuhan material bangunan seperti semen, pasir, cat, hingga perkakas pertukangan bagi warga yang sedang membangun atau merenovasi rumah.',
                'sector' => 'toko_bangunan',
            ],
            [
                'title' => 'Bengkel Servis Motor Pak Ujang',
                'description' => 'Jasa servis dan perbaikan sepeda motor dengan mekanik berpengalaman.',
                'content' => 'Bengkel Pak Ujang melayani servis rutin, ganti oli, hingga perbaikan mesin sepeda motor bagi warga desa dan sekitarnya dengan harga terjangkau.',
                'sector' => 'jasa_servis',
            ],
            [
                'title' => 'Anyaman Bambu Kriya Puraseda',
                'description' => 'Kerajinan tangan anyaman bambu khas warga desa, mulai dari bakul hingga hiasan rumah.',
                'content' => 'Kelompok pengrajin anyaman bambu memproduksi berbagai kerajinan tangan seperti bakul, tampah, dan hiasan dinding yang dijual ke pasar lokal maupun sebagai oleh-oleh khas desa.',
                'sector' => 'kerajinan_tangan',
            ],
            [
                'title' => 'Konveksi Baju Puraseda Jaya',
                'description' => 'Usaha konveksi pakaian rumahan yang memproduksi baju dan seragam pesanan warga.',
                'content' => 'Konveksi Puraseda Jaya menerima pesanan pembuatan baju, seragam sekolah, hingga kaos komunitas dengan pengerjaan oleh penjahit lokal desa.',
                'sector' => 'pakaian_fashion',
            ],
        ];

        foreach ($potentials as $i => $potential) {
            EconomicPotential::create([
                ...$potential,
                'slug' => \Illuminate\Support\Str::slug($potential['title']),
                'maps_url' => $mapsUrl,
                'order' => $i,
            ]);
        }
    }

    private function seedVillageEvents(): void
    {
        $events = [
            ['name' => 'Musyawarah Desa Rencana Kerja', 'date' => now()->addDays(7), 'start_time' => '09:00', 'end_time' => '12:00', 'location' => 'Balai Desa Puraseda', 'description' => 'Pembahasan rencana kerja dan anggaran desa tahun berjalan bersama perwakilan warga.'],
            ['name' => 'Posyandu Balita', 'date' => now()->addDays(14), 'start_time' => '08:00', 'end_time' => '10:30', 'location' => 'Posyandu Kampung Tengah', 'description' => 'Pemeriksaan tumbuh kembang balita dan pemberian vitamin rutin bulanan.'],
            ['name' => 'Gotong Royong Bersih Desa', 'date' => now()->addDays(21), 'start_time' => '07:00', 'end_time' => '09:00', 'location' => 'Titik kumpul Lapangan Desa', 'description' => 'Kerja bakti membersihkan saluran irigasi dan lingkungan sekitar desa.'],
        ];

        foreach ($events as $event) {
            VillageEvent::create($event);
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
