<!DOCTYPE html>
<html lang="en">
<?php
require "layout/head.php";
require "include/conn.php";

// Menghitung jumlah alternatif
$sql_alternatives = 'SELECT COUNT(*) AS total_alternatives FROM saw_alternatives';
$result_alternatives = $db->query($sql_alternatives);
$total_alternatives = $result_alternatives->fetch_object()->total_alternatives;

// Menghitung jumlah kriteria
$sql_criterias = 'SELECT COUNT(*) AS total_criterias FROM saw_criterias';
$result_criterias = $db->query($sql_criterias);
$total_criterias = $result_criterias->fetch_object()->total_criterias;

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAW Method - Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.16.8/katex.min.css">
    <style>
        .math-formula {
            font-family: Arial, sans-serif;
            font-size: 1.2em;
            line-height: 1.6;
            color: #333;
        }
        .fraction {
            display: inline-block;
            vertical-align: middle;
            text-align: center;
        }
        .fraction > span {
            display: block;
        }
        .fraction .numerator {
            border-bottom: 1px solid #000;
            padding: 0 0.5em;
        }
        .fraction .denominator {
            padding: 0 0.5em;
        }
        .text-info {
            color: #0d6efd;
        }
        .accordion-header {
            cursor: pointer;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 10px 15px;
            font-weight: 500;
        }
        .accordion-body {
            padding: 1.25rem 1.5rem;
        }
    </style>
</head>

<body>
    <div id="app">
        <?php require "layout/sidebar.php"; ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading">
                <h3 style="color: #435EBE;">Dashboard</h3>
            </div>
            <div class="row">
                <!-- Card Alternatif -->
                <div class="col-6 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Jumlah Jurusan</h6>
                                    <h6 class="font-extrabold mb-0"><?php echo $total_alternatives; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Kriteria -->
                <div class="col-6 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Jumlah Kriteria</h6>
                                    <h6 class="font-extrabold mb-0"><?php echo $total_criterias; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header">
                                    <h4>SPK Pemilihan Jurusan Kuliah (Metode SAW)</h4>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <strong>Tentang Metode Simple Additive Weighting (SAW)</strong><br /><br />
                                        Metode Simple Additive Weighting (SAW) merupakan salah satu metode Multiple Criteria Decision-Making (MCDM) yang digunakan untuk membantu pengambil keputusan dalam memilih jurusan kuliah terbaik dari beberapa pilihan yang ada berdasarkan berbagai kriteria. Dalam konteks sistem ini, setiap jurusan dinilai berdasarkan kriteria yang telah ditentukan, diberikan bobot sesuai tingkat kepentingannya, kemudian dijumlahkan sehingga diperoleh nilai preferensi untuk menentukan jurusan yang paling sesuai.
                                    </p>
                                    <hr>
                                    <!-- Accordion untuk Langkah-langkah SAW -->
                                    <div class="accordion mt-4" id="sawStepsAccordion">
                                        <div class="accordion-item">
                                            <h6 class="accordion-header" id="headingOne">
                                                <span data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <strong>Langkah-langkah Penggunaan SAW</strong>
                                                </span>
                                            </h6>
                                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#sawStepsAccordion">
                                                <div class="accordion-body">
                                                    <ol>
                                                        <li><strong>Menentukan Kriteria:</strong> Mengidentifikasi kriteria yang digunakan dalam pemilihan jurusan Kuliah. (<i>C<sub>i</sub></i>).</li>
                                                        <li><strong>Menentukan Rating Kecocokan:</strong> Menentukan nilai kecocokan setiap jurusan terhadap masing-masing kriteria. (<i>X</i>).</li>
                                                        <li><strong>Normalisasi Matriks:</strong> Membuat matriks keputusan berdasarkan kriteria (<i>C<sub>i</sub></i>), kemudian melakukan normalisasi matriks berdasarkan persamaan yang disesuaikan dengan jenis atribut <i>benefit</i> atau <i>cost</i> (atribut keuntungan ataupun atribut biaya) sehingga diperoleh matriks ternormalisasi <i>R</i>.</li>
                                                        <li><strong>Perangkingan:</strong> Hasil akhir diperoleh dari proses perankingan yaitu penjumlahan dari perkalian matriks ternormalisasi <i>R</i> dengan vektor bobot sehingga diperoleh nilai terbesar yang dipilih sebagai jurusan terbaik (<i>A<sub>i</sub></i>) sebagai solusi.</li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php require "layout/footer.php"; ?>
        </div>
    </div>
    <?php require "layout/js.php"; ?>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
