<?php
// =========================================================================
// LOGIKA PHP NATIVE TETAP DIPERTAHANKAN
// =========================================================================
require_once('include/config.php');

session_name("jbsakad");
session_start();

// Pengecekan session login asli
if (!isset($_SESSION['namasimaka'])) {
    include("login.php");
    exit;
}
require_once("cek.php");

// =========================================================================
// STRUKTUR DATA MENU UNTUK SIDEBAR (Ditambahkan icon submenu)
// =========================================================================
$menus = [
    [
        'title' => 'Referensi', 'icon' => 'fas fa-book', 'color' => 'text-blue-500',
        'items' => [
            ['label' => 'Identitas Sekolah', 'url' => 'referensi/identitas.php', 'icon' => 'fas fa-id-badge'],
            ['label' => 'Pegawai', 'url' => 'referensi/pegawai.php', 'icon' => 'fas fa-user-tie'],
            ['label' => 'Departemen', 'url' => 'referensi/departemen.php', 'icon' => 'fas fa-building'],
            ['label' => 'Angkatan', 'url' => 'referensi/angkatan.php', 'icon' => 'fas fa-layer-group'],
            ['label' => 'Tingkat', 'url' => 'referensi/tingkat.php', 'icon' => 'fas fa-sitemap'],
            ['label' => 'Tahun Ajaran', 'url' => 'referensi/tahunajaran.php', 'icon' => 'fas fa-calendar-check'],
            ['label' => 'Semester', 'url' => 'referensi/semester.php', 'icon' => 'fas fa-clock'],
            ['label' => 'Kelas', 'url' => 'referensi/kelas.php', 'icon' => 'fas fa-chalkboard']
        ]
    ],
    [
        'title' => 'PPDB', 'icon' => 'fas fa-users', 'color' => 'text-emerald-500',
        'items' => [
            ['label' => 'PPDB', 'url' => 'siswa_baru/proses.php', 'icon' => 'fas fa-door-open'],
            ['label' => 'Kelompok', 'url' => 'siswa_baru/kelompok.php', 'icon' => 'fas fa-users-cog'],
            ['label' => 'Pendataan', 'url' => 'siswa_baru/calon_main.php', 'icon' => 'fas fa-address-book'],
            ['label' => 'Cari Calon Siswa', 'url' => 'siswa_baru/cari_main.php', 'icon' => 'fas fa-search'],
            ['label' => 'Penempatan', 'url' => 'siswa_baru/penempatan_main.php', 'icon' => 'fas fa-map-pin'],
            ['label' => 'Statistik', 'url' => 'siswa_baru/statistik_main.php', 'icon' => 'fas fa-chart-bar'],
            ['label' => 'Setting PSB', 'url' => 'siswa_baru/settingpsb_main.php', 'icon' => 'fas fa-cogs'],
            ['label' => 'PIN Calon Siswa', 'url' => 'siswa_baru/pincs.main.php', 'icon' => 'fas fa-key']
        ]
    ],
    [
        'title' => 'Pelajaran', 'icon' => 'fas fa-book-open', 'color' => 'text-yellow-500',
        'items' => [
            ['label' => 'Pendataan Pelajaran', 'url' => 'guru/pelajaran.php', 'icon' => 'fas fa-book'],
            ['label' => 'RPP', 'url' => 'guru/rpp_main.php', 'icon' => 'fas fa-file-signature'],
            ['label' => 'Jenis Pengujian', 'url' => 'guru/jenis_pengujian.php', 'icon' => 'fas fa-vials'],
            ['label' => 'Aturan Grading', 'url' => 'guru/aturannilai_main.php', 'icon' => 'fas fa-balance-scale'],
            ['label' => 'Perhitungan Nilai', 'url' => 'guru/perhitungan_rapor.php', 'icon' => 'fas fa-calculator'],
            ['label' => 'Aspek Nilai', 'url' => 'guru/aspeknilai.php', 'icon' => 'fas fa-cubes'],
            ['label' => 'Kelompok Pelajaran', 'url' => 'guru/kelompokpelajaran.php', 'icon' => 'fas fa-layer-group']
        ]
    ],
    [
        'title' => 'Guru', 'icon' => 'fas fa-chalkboard-teacher', 'color' => 'text-purple-500',
        'items' => [
            ['label' => 'Status Guru', 'url' => 'guru/statusguru.php', 'icon' => 'fas fa-user-check'],
            ['label' => 'Pendataan Guru', 'url' => 'guru/guru_main.php', 'icon' => 'fas fa-chalkboard-teacher']
        ]
    ],
    [
        'title' => 'Jadwal & Kalender', 'icon' => 'fas fa-calendar-alt', 'color' => 'text-red-500',
        'items' => [
            ['label' => 'Penyusunan Jadwal Guru', 'url' => 'jadwal/jadwal_guru_main.php', 'icon' => 'fas fa-calendar-day'],
            ['label' => 'Jam Belajar', 'url' => 'jadwal/definisi_jam.php', 'icon' => 'fas fa-clock'],
            ['label' => 'Penyusunan Jadwal Kelas', 'url' => 'jadwal/jadwal_kelas_main.php', 'icon' => 'fas fa-calendar-week'],
            ['label' => 'Rekapitulasi Jadwal', 'url' => 'jadwal/rekap_jadwal_main.php', 'icon' => 'fas fa-clipboard-list'],
            ['label' => 'Kalender Akademik', 'url' => 'jadwal/kalender_main.php', 'icon' => 'fas fa-calendar-alt']
        ]
    ],
    [
        'title' => 'Kesiswaan', 'icon' => 'fas fa-user-graduate', 'color' => 'text-indigo-500',
        'items' => [
            ['label' => 'Data Siswa', 'url' => 'siswa/siswa_main.php', 'icon' => 'fas fa-user-graduate'],
            ['label' => 'Cari Siswa', 'url' => 'siswa/siswa_cari_main.php', 'icon' => 'fas fa-search'],
            ['label' => 'Pindah Kelas', 'url' => 'siswa/siswa_pindah_main.php', 'icon' => 'fas fa-exchange-alt'],
            ['label' => 'Statistik', 'url' => 'siswa/siswa_statistik_main.php', 'icon' => 'fas fa-chart-pie'],
            ['label' => 'PIN', 'url' => 'siswa/pin_main.php', 'icon' => 'fas fa-key']
        ]
    ],
    [
        'title' => 'Presensi', 'icon' => 'fas fa-clipboard-check', 'color' => 'text-teal-500',
        'items' => [
            ['label' => 'Cetak Form Harian', 'url' => 'presensi/formpresensi_harian.php', 'icon' => 'fas fa-print'],
            ['label' => 'Input Presensi Harian', 'url' => 'presensi/input_presensi_main.php', 'icon' => 'fas fa-edit'],
            ['label' => 'Laporan Harian Siswa', 'url' => 'presensi/lap_hariansiswa_main.php', 'icon' => 'fas fa-file-alt'],
            ['label' => 'Laporan Harian Kelas', 'url' => 'presensi/lap_hariankelas_main.php', 'icon' => 'fas fa-file-alt'],
            ['label' => 'Laporan Harian Absen', 'url' => 'presensi/lap_harianabsen_main.php', 'icon' => 'fas fa-user-times'],
            ['label' => 'Statistik Harian Siswa', 'url' => 'presensi/statistik_hariansiswa_main.php', 'icon' => 'fas fa-chart-line'],
            ['label' => 'Statistik Harian Kelas', 'url' => 'presensi/statistik_hariankelas_main.php', 'icon' => 'fas fa-chart-line'],
            ['label' => 'Cetak Form Pelajaran', 'url' => 'presensi/formpresensi_pelajaran.php', 'icon' => 'fas fa-print'],
            ['label' => 'Input Presensi Pelajaran', 'url' => 'presensi/presensi_main.php', 'icon' => 'fas fa-edit'],
            ['label' => 'Laporan Pelajaran Siswa', 'url' => 'presensi/lap_siswa_main.php', 'icon' => 'fas fa-file-invoice'],
            ['label' => 'Laporan Pelajaran Kelas', 'url' => 'presensi/lap_kelas_main.php', 'icon' => 'fas fa-file-invoice'],
            ['label' => 'Laporan Presensi Pengajar', 'url' => 'presensi/lap_pengajar_main.php', 'icon' => 'fas fa-chalkboard-teacher'],
            ['label' => 'Laporan Pelajaran Absen', 'url' => 'presensi/lap_absen_main.php', 'icon' => 'fas fa-user-times'],
            ['label' => 'Laporan Refleksi Mengajar', 'url' => 'presensi/lap_refleksi_main.php', 'icon' => 'fas fa-comments'],
            ['label' => 'Statistik Kehadiran Siswa', 'url' => 'presensi/statistik_siswa_main.php', 'icon' => 'fas fa-chart-area'],
            ['label' => 'Statistik Kehadiran Kelas', 'url' => 'presensi/statistik_kelas_main.php', 'icon' => 'fas fa-chart-area']
        ]
    ],
    [
        'title' => 'Penilaian', 'icon' => 'fas fa-star', 'color' => 'text-orange-500',
        'items' => [
            ['label' => 'Cetak Form Nilai', 'url' => 'penilaian/formpenilaian.php', 'icon' => 'fas fa-print'],
            ['label' => 'Penilaian', 'url' => 'penilaian/lihat_nilai_pelajaran.php', 'icon' => 'fas fa-edit'],
            ['label' => 'Perhitungan Nilai', 'url' => 'penilaian/lihat_penentuan.php', 'icon' => 'fas fa-calculator'],
            ['label' => 'Rata-rata RPP Kelas', 'url' => 'penilaian/ujian_rpp_kelas.php', 'icon' => 'fas fa-chart-bar'],
            ['label' => 'Rata-rata RPP Siswa', 'url' => 'penilaian/ujian_rpp_siswa.php', 'icon' => 'fas fa-chart-bar'],
            ['label' => 'Laporan Nilai Siswa', 'url' => 'penilaian/lap_pelajaran_main.php', 'icon' => 'fas fa-file-invoice'],
            ['label' => 'Rata-rata Nilai', 'url' => 'penilaian/rataus.main.php', 'icon' => 'fas fa-chart-area'],
            ['label' => 'Legger', 'url' => 'penilaian/lap_legger.php', 'icon' => 'fas fa-table'],
            ['label' => 'Legger Nilai Pelajaran', 'url' => 'penilaian/legger.rapor.php', 'icon' => 'fas fa-table'],
            ['label' => 'Legger Kelas', 'url' => 'penilaian/legger.kelas.php', 'icon' => 'fas fa-table'],
            ['label' => 'Komentar', 'url' => 'penilaian/komentar_main.php', 'icon' => 'fas fa-comment-dots'],
            ['label' => 'Laporan Akhir', 'url' => 'penilaian/lap_rapor_main.php', 'icon' => 'fas fa-file-contract']
        ]
    ],
    [
        'title' => 'Expor Import', 'icon' => 'fas fa-exchange-alt', 'color' => 'text-cyan-500',
        'items' => [
            ['label' => 'Expor Nilai', 'url' => 'penilaian/expnilai.php', 'icon' => 'fas fa-file-export'],
            ['label' => 'Impor Nilai', 'url' => 'penilaian/impnilai.php', 'icon' => 'fas fa-file-import']
        ]
    ],
    [
        'title' => 'Kenaikan & Kelulusan', 'icon' => 'fas fa-level-up-alt', 'color' => 'text-pink-500',
        'items' => [
            ['label' => 'Kenaikan Kelas', 'url' => 'siswa/siswa_kenaikan_main.php', 'icon' => 'fas fa-level-up-alt'],
            ['label' => 'Tinggal Kelas', 'url' => 'siswa/siswa_tidak_naik_main.php', 'icon' => 'fas fa-level-down-alt'],
            ['label' => 'Kelulusan', 'url' => 'siswa/siswa_lulus_main.php', 'icon' => 'fas fa-graduation-cap'],
            ['label' => 'Input Alumni', 'url' => 'siswa/alumni_main.php', 'icon' => 'fas fa-user-plus'],
            ['label' => 'Data Alumni', 'url' => 'siswa/alumni.php', 'icon' => 'fas fa-user-graduate'],
            ['label' => 'Cari Alumni', 'url' => 'siswa/alumni_cari.php', 'icon' => 'fas fa-search']
        ]
    ],
    [
        'title' => 'Mutasi', 'icon' => 'fas fa-share-square', 'color' => 'text-rose-500',
        'items' => [
            ['label' => 'Jenis Mutasi', 'url' => 'mutasi/jenis_mutasi_siswa.php', 'icon' => 'fas fa-list-ul'],
            ['label' => 'Mutasi Siswa', 'url' => 'mutasi/mutasi_siswa.php', 'icon' => 'fas fa-sign-out-alt'],
            ['label' => 'Daftar Mutasi', 'url' => 'mutasi/daftar_mutasi.php', 'icon' => 'fas fa-clipboard-list'],
            ['label' => 'Statistik Mutasi', 'url' => 'mutasi/statistik_mutasi_siswa.php', 'icon' => 'fas fa-chart-bar']
        ]
    ],
    [
        'title' => 'Laporan', 'icon' => 'fas fa-file-alt', 'color' => 'text-amber-500',
        'items' => [
            ['label' => 'Pengantar Surat', 'url' => 'pelaporan/pengantar.php', 'icon' => 'fas fa-envelope'],
            ['label' => 'Lampiran Surat', 'url' => 'pelaporan/lampiran.php', 'icon' => 'fas fa-paperclip'],
            ['label' => 'Penyusunan Surat', 'url' => 'pelaporan/penyusunan.php', 'icon' => 'fas fa-pen-nib']
        ]
    ],
    [
        'title' => 'Pengaturan', 'icon' => 'fas fa-cogs', 'color' => 'text-gray-500',
        'items' => [
            ['label' => 'Daftar User', 'url' => 'user/user.php', 'icon' => 'fas fa-users-cog'],
            ['label' => 'Ganti Password', 'url' => 'user/user_ganti.php', 'icon' => 'fas fa-key'],
            ['label' => 'Audit', 'url' => 'referensi/auditnilai.php', 'icon' => 'fas fa-history'],
            ['label' => 'Log Error', 'url' => 'referensi/queryerror.php', 'icon' => 'fas fa-exclamation-triangle']
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JIBAS - AKADEMIK</title>
    <link href="images/jibas2015.ico" rel="shortcut icon" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome (Untuk Icon Menu) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js (Untuk Interaktivitas Sidebar & Accordion) -->
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script type="text/javascript">
        function logout() {
            if (confirm("Anda yakin akan menutup Aplikasi Manajemen Akademik ini?")) {
                document.location.href = "logout.php";
            }
        }
    </script>
</head>

<!-- Alpine Data Initialization -->
<body x-data="{ sidebarOpen: false, activeUrl: 'referensi.php' }" class="bg-gray-100 font-sans overflow-hidden">

    <div class="flex h-screen w-full">
        
        <!-- ========================================== -->
        <!-- MOBILE OVERLAY                             -->
        <!-- ========================================== -->
        <div 
            x-show="sidebarOpen" 
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden"
            @click="sidebarOpen = false"
            style="display: none;"
        ></div>

        <!-- ========================================== -->
        <!-- SIDEBAR NAVIGATION                         -->
        <!-- ========================================== -->
        <!-- Tema Emerald-900 diimplementasikan pada sidebar dan aksen aktif -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-emerald-100 shadow-xl transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 lg:flex lg:flex-col lg:shadow-none"
        >
            <!-- Logo / Brand Area (Menggunakan Emerald-900) -->
            <div class="flex items-center justify-between h-16 px-6 bg-emerald-900 text-white flex-shrink-0 shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fas fa-graduation-cap text-2xl text-emerald-300"></i>
                    <span class="text-lg font-bold tracking-wider">JIBAS AKADEMIK</span>
                </div>
                <!-- Tombol Close (Mobile Saja) -->
                <button @click="sidebarOpen = false" class="lg:hidden text-emerald-200 hover:text-white focus:outline-none transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Area Menu Accordion -->
            <nav class="flex-1 px-4 py-4 overflow-y-auto space-y-1" x-data="{ activeAccordion: null }">
                
                <?php foreach ($menus as $index => $menu): ?>
                <div class="mb-1">
                    <!-- Tombol Parent Menu -->
                    <button 
                        @click="activeAccordion = (activeAccordion === <?= $index ?> ? null : <?= $index ?>)"
                        class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-emerald-50 transition-colors"
                        :class="{ 'bg-emerald-50 text-emerald-900': activeAccordion === <?= $index ?> }"
                    >
                        <div class="flex items-center gap-3">
                            <i class="<?= $menu['icon'] ?> <?= $menu['color'] ?> w-5 text-center text-lg"></i>
                            <span :class="{ 'font-bold': activeAccordion === <?= $index ?> }"><?= $menu['title'] ?></span>
                        </div>
                        <i 
                            class="fas fa-chevron-down text-xs text-emerald-600 transition-transform duration-300"
                            :class="{ 'rotate-180': activeAccordion === <?= $index ?> }"
                        ></i>
                    </button>

                    <!-- Submenu (Expand/Collapse) -->
                    <div 
                        x-show="activeAccordion === <?= $index ?>" 
                        x-collapse
                        class="mt-1 space-y-1"
                        style="display: none;"
                    >
                        <?php foreach ($menu['items'] as $item): ?>
                            <!-- Target "content" akan mengarahkan link ini ke iframe -->
                            <a 
                                href="<?= $item['url'] ?>" 
                                target="content"
                                @click="activeUrl = '<?= $item['url'] ?>'; if(window.innerWidth < 1024) sidebarOpen = false;"
                                class="group flex items-center gap-3 pl-11 pr-3 py-2 text-sm text-gray-600 rounded-md hover:text-emerald-900 hover:bg-emerald-50 transition-colors relative"
                                :class="{ 'text-emerald-900 bg-emerald-100 font-semibold shadow-sm': activeUrl === '<?= $item['url'] ?>' }"
                            >
                                <!-- Icon Submenu -->
                                <i 
                                    class="<?= $item['icon'] ?> text-gray-400 group-hover:text-emerald-600 transition-colors"
                                    :class="{ 'text-emerald-700': activeUrl === '<?= $item['url'] ?>' }"
                                ></i>
                                <?= $item['label'] ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Menu Logout Berdiri Sendiri -->
                <div class="pt-4 mt-4 border-t border-emerald-100">
                    <button 
                        onclick="logout()"
                        class="w-full flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 transition-colors"
                    >
                        <i class="fas fa-sign-out-alt w-5 text-center text-lg"></i>
                        <span>Keluar Sistem</span>
                    </button>
                </div>

            </nav>
        </aside>

        <!-- ========================================== -->
        <!-- MAIN CONTENT AREA                          -->
        <!-- ========================================== -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50">
            
            <!-- HEADER BAR -->
            <header class="flex-shrink-0 h-16 bg-white border-b border-emerald-100 shadow-sm flex items-center justify-between px-4 lg:px-8">
                <div class="flex items-center">
                    <!-- Hamburger Menu Button (Mobile) -->
                    <button 
                        @click="sidebarOpen = true" 
                        class="text-emerald-800 hover:text-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-md p-2 lg:hidden mr-3"
                    >
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-bold text-emerald-900 hidden sm:block">Panel Akademik</h1>
                </div>

                <!-- Info User Kanan Atas -->
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-emerald-900">
                            <?php 
                            if ($_SESSION['namasimaka'] == "landlord") {
                                echo "Administrator JIBAS";
                            } else {
                                echo $_SESSION['namasimaka'];
                            }
                            ?>
                        </p>
                        <p class="text-xs text-emerald-600 flex items-center justify-end gap-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span> Online
                        </p>
                    </div>
                    <!-- Avatar Placeholder (Warna Emerald Light) -->
                    <div class="w-10 h-10 rounded-full bg-emerald-100 border border-emerald-200 flex items-center justify-center text-emerald-700">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </header>

            <!-- KONTEN UTAMA (IFRAME) -->
            <!-- Iframe ini menggantikan frame 'content' lama. Logic PHP didalam file tidak akan terganggu. -->
            <div class="flex-1 h-full w-full relative overflow-hidden bg-white shadow-inner">
                <iframe 
                    name="content" 
                    id="contentFrame"
                    src="referensi.php" 
                    class="absolute inset-0 w-full h-full border-none"
                    title="Main Content Area"
                ></iframe>
            </div>

        </main>
    </div>

</body>
</html>