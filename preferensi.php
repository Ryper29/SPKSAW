<!DOCTYPE html>
<html lang="en">
<?php
require "layout/head.php";
require "include/conn.php";
require "W.php";
require "R.php";

// Ambil data alternatif dari database
$sql = 'SELECT id_alternative, name FROM saw_alternatives';
$result = $db->query($sql);
$alternatives = [];
while ($row = $result->fetch_object()) {
  $alternatives[$row->id_alternative] = $row->name;
}
$result->free();
?>

<body>

  <style>
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
  <div id="app">
    <?php require "layout/sidebar.php"; ?>
    <div id="main">
      <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
          <i class="bi bi-justify fs-3"></i>
        </a>
      </header>
      <div class="page-heading">
        <h3 style="color: #435EBE;">Nilai Preferensi (P)</h3>
      </div>
      <div class="page-content">
        <section class="row">
          <div class="col-12">
            <div class="card" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px;">

              <div class="card-header" style="background-color: #f4f4f9; border: 1px solid #e0e0e0;">
                <h4 class="card-title" style="font-weight: bold;">Tabel Nilai Preferensi (P)</h4>
              </div>
              <div class="card-content">
                <div class="card-body" style="padding: 20px;">
                  <p class="card-text">
                    Setelah melakukan normalisasi, sistem menghitung <strong>nilai preferensi</strong> untuk setiap jurusan sehingga diperoleh ranking rekomendasi jurusan kuliah yang paling sesuai dengan profil siswa.
                  </p>
                  <p>
                    <strong>Nilai Preferensi</strong> digunakan untuk menentukan jurusan terbaik berdasarkan kriteria yang telah dinormalisasi dan diberi bobot.
                  </p>

                  <!-- Accordion untuk Contoh Perhitungan Nilai Preferensi -->
                  <div class="accordion" id="preferenceExampleAccordion">
                    <div class="accordion-item">
                      <h6 class="accordion-header" id="headingExample" style="cursor: pointer; margin-bottom: 16px;">
                        <span data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
                          <strong>Contoh Perhitungan Nilai Preferensi</strong>
                        </span>
                      </h6>
                      <div id="collapseExample" class="accordion-collapse collapse" aria-labelledby="headingExample" data-bs-parent="#preferenceExampleAccordion">
                        <div class="accordion-body">
                          <p>
                            Misalnya, jika bobot dan nilai ternormalisasi adalah sebagai berikut:
                          </p>
                          <p>
                          <ul>
                            <li>Kriteria 1: Bobot \( w_1 = 2.5 \), Nilai Ternormalisasi \( R_{A1} = 0.8 \)</li>
                            <li>Kriteria 2: Bobot \( w_2 = 2.8 \), Nilai Ternormalisasi \( R_{A2} = 0.5 \)</li>
                          </ul>
                          </p>
                          <p>
                            Maka, nilai preferensi \( P_A \) untuk jurusan A adalah:
                          </p>
                          <p>
                            \( P_A = (2.5 \cdot 0.8) + (2.8 \cdot 0.5) \)
                          </p>
                          <p>
                            \( P_A = 2.0 + 1.4 = 3.4 \)
                          </p>
                          <p>
                            Jurusan dengan nilai preferensi tertinggi adalah jurusan yang dipilih sebagai yang terbaik.
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-primary btn-sm m-2 d-flex shadow" data-bs-toggle="modal" data-bs-target="#preferenceModal">
                    <i class="bi bi-info-circle mt-1 me-1"></i> Lihat Rumus Nilai Preferensi
                  </button>

                  <!-- Modal untuk Nilai Preferensi -->
                  <div class="modal fade" id="preferenceModal" tabindex="-1" aria-labelledby="preferenceModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header" style="background-color: #f4f4f9; border: 1px solid #e0e0e0;">
                          <h5 class="modal-title" id="preferenceModalLabel">Rumus Nilai Preferensi dalam Metode SAW</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <p class="math-formula">
                            Untuk menghitung <strong>nilai preferensi</strong> pada metode SAW, gunakan rumus berikut:
                          </p>
                          <p class="math-formula">
                            \( P_i = \sum_{j=1}^{n} w_j \cdot R_{ij} \)
                          </p>
                          <p>Di mana:</p>
                          <ul>
                            <li><strong>P<sub>i</sub></strong> adalah nilai preferensi untuk jurusan <em>i</em>.</li>
                            <li><strong>w<sub>j</sub></strong> adalah bobot dari kriteria <em>j</em>.</li>
                            <li><strong>R<sub>ij</sub></strong> adalah nilai ternormalisasi untuk jurusan <em>i</em> pada kriteria <em>j</em>.</li>
                            <li><strong>n</strong> adalah jumlah total kriteria.</li>
                          </ul>
                          <p>
                            Setelah menghitung nilai preferensi untuk semua jurusan, Anda dapat melakukan <strong>perankingan</strong> dengan membandingkan nilai-nilai tersebut. Jurusan dengan nilai preferensi tertinggi dianggap sebagai jurusan terbaik.
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover mb-0" style="width: 100%; border-collapse: collapse;">
                    <caption style="caption-side: top; text-align: center; padding-bottom: 10px; font-weight: bold; margin-top: -10px;">Nilai Preferensi (P)</caption>
                    <thead style="background-color: #435EBE; color: #fff;">
                      <tr>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">No</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Jurusan</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Hasil</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Rangking</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $P = array();
                      $no = 0;

                      if (empty($W) || empty($R)) {
                        echo "<tr style='background-color: #f8f9fa;'>
                <td colspan='4' style='padding: 10px; border: 1px solid #dee2e6; text-align: center;'>Belum ada data kriteria. Silakan tambahkan data terlebih  di menu matrix.</td>
              </tr>";
                      } else {
                        $m = count($W);

                        // Hitung nilai preferensi (P)
                        foreach ($R as $i => $r) {
                          $P[$i] = 0;
                          for ($j = 0; $j < $m; $j++) {
                            $P[$i] += $r[$j] * $W[$j];
                          }
                        }

                        // Urutkan nilai preferensi (P) dari tertinggi ke terendah
                        arsort($P);

                        // Hitung dan tampilkan tabel dengan kolom "Rangking"
                        $rangking = 1;
                        foreach ($P as $key => $value) {
                          $alt_name = isset($alternatives[$key]) ? $alternatives[$key] : "A{$key}";
                          echo "<tr style='background-color: #f8f9fa;'>
                  <td style='padding: 10px; border: 1px solid #dee2e6;'>" . (++$no) . "</td>
                  <td style='padding: 10px; border: 1px solid #dee2e6;'>{$alt_name}</td>
                  <td style='padding: 10px; border: 1px solid #dee2e6;'>{$value}</td>
                  <td style='padding: 10px; border: 1px solid #dee2e6;'>{$rangking}</td>
                </tr>";
                          $rangking++;
                        }
                      }
                      ?>
                    </tbody>
                  </table>
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
</body>

</html>