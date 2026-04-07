<!DOCTYPE html>
<html lang="en">
<?php
require "layout/head.php";
require "include/conn.php";
?>

<body>
  <div id="app">
    <?php require "layout/sidebar.php"; ?>
    <div id="main">
      <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
          <i class="bi bi-justify fs-3"></i>
        </a>
      </header>
      <style>
        .message {
          padding: 20px;
          background-color: #f8d7da;
          color: #721c24;
          border: 1px solid #f5c6cb;
          border-radius: 5px;
          margin: 20px 0;
          font-family: Arial, sans-serif;
        }
      </style>
      <div class="page-heading">
        <h3 style="color: #435EBE;">Matrik</h3>
      </div>
      <div class="page-content">
        <section class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header" style="background-color: #f4f4f9; border: 1px solid #e0e0e0;">
                <h4 class="card-title">Matriks Keputusan (X) &amp; Ternormalisasi (R)</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <p class="card-text">
                    Halaman ini menampilkan matriks keputusan yang berisi nilai setiap jurusan terhadap kriteria yang digunakan, serta hasil normalisasi (R) yang dipakai dalam perhitungan metode SAW untuk pemilihan jurusan kuliah, dengan ketentuan:
                  </p>

                  <div class="d-flex">
                    <button type="button" class="btn btn-primary btn-sm m-2 d-flex" data-bs-toggle="modal" data-bs-target="#costModal">
                      <i class="bi bi-info-circle mt-1 me-1"></i> Rumus Cost
                    </button>

                    <button type="button" class="btn btn-primary btn-sm m-2 d-flex" data-bs-toggle="modal" data-bs-target="#benefitModal">
                      <i class="bi bi-info-circle mt-1 me-1"></i> Rumus Benefit
                    </button>
                  </div>

                  <button type="button" class="btn btn-outline-success btn-sm m-2 d-flex shadow" data-bs-toggle="modal" data-bs-target="#inlineForm">
                    <i class="iconly-boldShow mt-1 me-1"></i> Isi Nilai Jurusan
                  </button>

                  <!-- Modal untuk Cost -->
                  <div class="modal fade" id="costModal" tabindex="-1" aria-labelledby="costModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header" style="background-color: #f4f4f9; border: 1px solid #e0e0e0;">
                          <h5 class="modal-title" id="costModalLabel">Rumus Normalisasi untuk Kriteria Cost</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <p class="math-formula">
                            Jika faktor/atribut kriteria bertipe <strong>cost</strong> maka digunakan rumusan:
                          </p>
                          <p class="math-formula">
                            \( R_{ij} = \frac{\text{min}(X_{ij})}{X_{ij}} \)
                          </p>
                          <p>Di mana:</p>
                          <ul>
                            <li><strong>R<sub>ij</sub></strong> adalah nilai ternormalisasi untuk jurusan <em>i</em> pada kriteria <em>j</em>.</li>
                            <li><strong>X<sub>ij</sub></strong> adalah nilai dari jurusan <em>i</em> pada kriteria <em>j</em>.</li>
                            <li><strong>min(X<sub>ij</sub>)</strong> adalah nilai minimum dari kriteria <em>j</em> di seluruh jurusan.</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Modal untuk Benefit -->
                  <div class="modal fade" id="benefitModal" tabindex="-1" aria-labelledby="benefitModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header" style="background-color: #f4f4f9; border: 1px solid #e0e0e0;">
                          <h5 class="modal-title" id="benefitModalLabel">Rumus Normalisasi untuk Kriteria Benefit</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <p class="math-formula">
                            Jika faktor/atribut kriteria bertipe <strong>benefit</strong> maka digunakan rumusan:
                          </p>
                          <p class="math-formula">
                            \( R_{ij} = \frac{X_{ij}}{\text{max}(X_{ij})} \)
                          </p>
                          <p>Di mana:</p>
                          <ul>
                            <li><strong>R<sub>ij</sub></strong> adalah nilai ternormalisasi untuk jurusan <em>i</em> pada kriteria <em>j</em>.</li>
                            <li><strong>X<sub>ij</sub></strong> adalah nilai dari jurusan <em>i</em> pada kriteria <em>j</em>.</li>
                            <li><strong>max(X<sub>ij</sub>)</strong> adalah nilai maksimum dari kriteria <em>j</em> di seluruh jurusan.</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>


                </div>

                <?php
                // Ambil daftar kriteria dari database
                $criterias_result = $db->query("SELECT id_criteria, criteria, attribute FROM saw_criterias ORDER BY id_criteria ASC");
                $criterias = [];
                $attributes = [];
                while ($criteria_row = $criterias_result->fetch_object()) {
                  $criterias[$criteria_row->id_criteria] = $criteria_row->criteria;
                  $attributes[$criteria_row->id_criteria] = $criteria_row->attribute;
                }

                // Ambil data alternatif dan nilai kriteria
                $sql = "SELECT
    a.id_alternative,
    b.name,
    a.id_criteria,
    a.value
FROM
    saw_evaluations a
    JOIN saw_alternatives b ON a.id_alternative = b.id_alternative
ORDER BY a.id_alternative, a.id_criteria";
                $result = $db->query($sql);

                $alternatives = [];
                while ($row = $result->fetch_object()) {
                  $alternatives[$row->id_alternative]['name'] = $row->name;
                  $alternatives[$row->id_alternative]['criteria'][$row->id_criteria] = $row->value;
                }

                // Membangun Matriks Keputusan (X)
                $X = [];
                foreach ($alternatives as $id_alternative => $data) {
                  foreach ($data['criteria'] as $id_criteria => $value) {
                    $X[$id_criteria][] = $value;
                  }
                }

                $maxValues = [];
                $minValues = [];
                foreach ($criterias as $id_criteria => $criteria_name) {
                  $maxValues[$id_criteria] = !empty($X[$id_criteria]) ? max($X[$id_criteria]) : 0;
                  $minValues[$id_criteria] = !empty($X[$id_criteria]) ? min($X[$id_criteria]) : 0;
                }

                // Tabel Matriks Keputusan (X)
                if (!empty($alternatives)) {
                  echo "<div class='table-responsive'>";
                  echo "<table class='table table-striped mb-0' style='width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 14px;'>";
                  echo "<caption style='caption-side: top; text-align: center; font-weight: bold; font-size: 16px; color: #333; margin-top: -10px;'>Matrik Keputusan (X)</caption>";
                  echo "<thead style='background-color: #435EBE; color: #fff;'>";
                  echo "<tr>
        <th rowspan='2' style='padding: 12px; border: 1px solid #ddd;'>Jurusan</th>";

                  foreach ($criterias as $id => $name) {
                    echo "<th style='padding: 12px; border: 1px solid #ddd;'>$name</th>";
                  }

                  echo "<th rowspan='2' style='padding: 12px; border: 1px solid #ddd;'>Aksi</th>
    </tr>";

                  echo "<tr>";
                  $i = 1;
                  foreach ($criterias as $id => $name) {
                    echo "<th style='padding: 12px; border: 1px solid #ddd;'>C<sub>$i</sub></th>";
                    $i++;
                  }
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";

                  $counter = 1; // Inisialisasi counter
                  foreach ($alternatives as $id_alternative => $data) {
                    echo "<tr class='center'>
            <th style='padding: 12px; border: 1px solid #ddd;'>A<sub>{$counter}</sub> {$data['name']}</th>"; // Menggunakan counter

                    foreach ($criterias as $id_criteria => $name) {
                      $value = isset($data['criteria'][$id_criteria]) ? round($data['criteria'][$id_criteria], 2) : 0;
                      echo "<td style='padding: 12px; border: 1px solid #ddd;'>$value</td>";
                    }

                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>
            <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='{$id_alternative}' data-name='{$data['name']}'>Hapus</button>
            </td>
        </tr>\n";
                    $counter++; // Increment counter setelah setiap alternatif
                  }

                  echo "</tbody>";
                  echo "</table>";
                  echo "</div>";
                } else {
                  echo '<div class="message">😥🤗 Belum ada data kriteria. Silakan isi nilai jurusan terlebih dahulu.</div>';
                }

                // Tabel Matriks Ternormalisasi (R)
                $sql = "SELECT
    a.id_alternative,
    b.name,
    a.id_criteria,
    a.value,
    c.attribute
FROM
    saw_evaluations a
    JOIN saw_alternatives b ON a.id_alternative = b.id_alternative
    JOIN saw_criterias c ON a.id_criteria = c.id_criteria
ORDER BY a.id_alternative, a.id_criteria";

                $result = $db->query($sql);
                if (!$result) {
                  die("Query failed: " . $db->error);
                }

                $R = [];
                while ($row = $result->fetch_object()) {
                  $id_alternative = $row->id_alternative;
                  $id_criteria = $row->id_criteria;
                  $value = $row->value;
                  $attribute = $row->attribute;

                  if ($attribute == 'benefit') {
                    $normalizedValue = $maxValues[$id_criteria] != 0 ? $value / $maxValues[$id_criteria] : 0;
                  } else { // cost
                    $normalizedValue = $minValues[$id_criteria] != 0 ? $minValues[$id_criteria] / $value : 0;
                  }

                  $R[$id_alternative][$id_criteria] = round($normalizedValue, 2);
                }

                // Menampilkan Matriks Ternormalisasi (R)
                if (!empty($alternatives)) {
                  echo "<div class='table-responsive'>";
                  echo "<table class='table table-striped mb-0' style='width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 14px;'>";
                  echo "<caption style='caption-side: top; text-align: center; font-weight: bold; font-size: 16px; color: #333; margin-top: -10px;'>Matrik Ternormalisasi (R)</caption>";
                  echo "<thead style='background-color: #435EBE; color: #fff;'>";
                  echo "<tr>
        <th rowspan='2' style='padding: 12px; border: 1px solid #ddd;'>Jurusan</th>";

                  foreach ($criterias as $id => $name) {
                    echo "<th style='padding: 12px; border: 1px solid #ddd;'>$name</th>";
                  }

                  echo "</tr>";
                  echo "<tr>";
                  $i = 1;
                  foreach ($criterias as $id => $name) {
                    echo "<th style='padding: 12px; border: 1px solid #ddd;'>C<sub>$i</sub></th>";
                    $i++;
                  }
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";

                  $counter = 1; // Inisialisasi counter untuk urutan alternatif pada tabel ternormalisasi
                  foreach ($alternatives as $id_alternative => $data) {
                    echo "<tr class='center'>
            <th style='padding: 12px; border: 1px solid #ddd;'>A<sub>{$counter}</sub> {$data['name']}</th>"; // Menggunakan counter

                    foreach ($criterias as $id_criteria => $name) {
                      $normalizedValue = isset($R[$id_alternative][$id_criteria]) ? round($R[$id_alternative][$id_criteria], 2) : 0;
                      echo "<td style='padding: 12px; border: 1px solid #ddd;'>$normalizedValue</td>";
                    }

                    echo "</tr>\n";
                    $counter++; // Increment counter setelah setiap alternatif
                  }

                  echo "</tbody>";
                  echo "</table>";
                  echo "</div>";
                } else {
                  echo '<div class="message">😥🤗 Belum ada data kriteria. Silakan isi nilai Jurusan terlebih dahulu.</div>';
                }
                ?>






              </div>
            </div>
          </div>
        </section>
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Isi Nilai Kandidat </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <i data-feather="x"></i>
                </button>
              </div>
              <form action="matrik-simpan.php" method="POST">
                <div class="modal-body">
                  <label>Name: </label>
                  <div class="form-group">
                    <select class="form-control form-select" name="id_alternative">
                      <?php
                      $sql = 'SELECT id_alternative,name FROM saw_alternatives';
                      $result = $db->query($sql);
                      $i = 0;
                      while ($row = $result->fetch_object()) {
                        echo '<option value="' . $row->id_alternative . '">' . $row->name . '</option>';
                      }
                      $result->free();
                      ?>
                    </select>
                  </div>
                </div>
                <div class="modal-body">
                  <label>Criteria: </label>
                  <div class="form-group">
                    <select class="form-control form-select" name="id_criteria">
                      <?php
                      $sql = 'SELECT * FROM saw_criterias';
                      $result = $db->query($sql);
                      $i = 0;
                      while ($row = $result->fetch_object()) {
                        echo '<option value="' . $row->id_criteria . '">' . $row->criteria . '</option>';
                      }
                      $result->free();
                      ?>
                    </select>
                  </div>
                </div>
                <div class="modal-body">
                  <label>Value: </label>
                  <div class="form-group">
                    <input type="text" name="value" placeholder="value..." class="form-control" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Batal</span>
                  </button>
                  <button type="submit" name="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Simpan</span>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Modal Konfirmasi Hapus -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header" style="background-color: #f4f4f9; border: 1px solid #e0e0e0;">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus <span id="alternativeName"></span>?</p>
                <p>Data ini akan dihapus secara permanen!</p>
              </div>
              <div class="modal-footer">
                <form id="deleteForm" method="POST">
                  <input type="hidden" name="id" id="alternativeId">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
      <?php require "layout/footer.php"; ?>
    </div>
  </div>
  <?php require "layout/js.php"; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var deleteModal = document.getElementById('deleteModal')
      deleteModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')
        var name = button.getAttribute('data-name')

        var modalTitle = deleteModal.querySelector('.modal-title')
        var alternativeName = deleteModal.querySelector('#alternativeName')
        var alternativeId = deleteModal.querySelector('#alternativeId')
        var deleteForm = deleteModal.querySelector('#deleteForm')

        modalTitle.textContent = 'Hapus ' + name
        alternativeName.textContent = name
        alternativeId.value = id
        deleteForm.action = 'keputusan-hapus.php?id=' + id
      })
    })
  </script>

</body>

</html>