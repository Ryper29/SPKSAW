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
      <div class="page-heading">
        <h3 style="color: #435EBE;">Bobot Kriteria</h3>
      </div>
      <div class="page-content">
        <section class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header" style="background-color: #f4f4f9; border: 1px solid #e0e0e0;">
                <h4 class="card-title">Tabel Bobot Kriteria</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <p class="card-text">
                    Pengambil keputusan memberikan bobot pada setiap kriteria sesuai tingkat kepentingannya dalam pemilihan jurusan kuliah siswa.
                  <p>
                    Dalam metode SAW, terdapat dua tipe atribut kriteria: <strong>cost</strong> dan <strong>benefit</strong>.
                  </p>
                  <ul>
                    <li><strong>Cost</strong>: Semakin kecil nilainya, semakin baik. Contoh: Biaya kuliah, Jarak kampus.</li>
                    <li><strong>Benefit</strong>: Semakin besar nilainya, semakin baik. Contoh: Nilai akademik, Minat siswa.</li>
                  </ul>
                  </p>

                  <button type="button" class="btn btn-outline-success btn-sm m-2 d-flex shadow" data-bs-toggle="modal" data-bs-target="#inlineForm">
                    <i class="iconly-boldProfile mt-1 me-1"></i>Tambah Kriteria
                  </button>
                </div>
                <hr>
                <div class="table-responsive">
                  <table class="table table-striped mb-0" style="width: 100%; border-collapse: collapse;">
                    <caption style="caption-side: top; text-align: center; font-weight: bold; font-size: 16px; color: #333; margin-top: -10px;">
                      Tabel Kriteria C<sub>i</sub>
                    </caption>
                    <thead style="background-color: #435EBE; color: #fff;">
                      <tr>
                        <th style="padding: 12px; border: 1px solid #ddd;">No</th>
                        <th style="padding: 12px; border: 1px solid #ddd;">Simbol</th>
                        <th style="padding: 12px; border: 1px solid #ddd;">Kriteria</th>
                        <th style="padding: 12px; border: 1px solid #ddd;">Bobot</th>
                        <th style="padding: 12px; border: 1px solid #ddd;">Atribut</th>
                        <th style="padding: 12px; border: 1px solid #ddd;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = 'SELECT id_criteria,criteria,weight,attribute FROM saw_criterias';
                      $result = $db->query($sql);
                      $i = 0;
                      while ($row = $result->fetch_object()) {
                        echo "<tr>
        <td class='right' style='text-align: right; padding: 12px; border: 1px solid #ddd;'>" . (++$i) . "</td>
        <td class='center' style='text-align: center; padding: 12px; border: 1px solid #ddd;'>C{$i}</td>
        <td style='padding: 12px; border: 1px solid #ddd;'>{$row->criteria}</td>
        <td style='padding: 12px; border: 1px solid #ddd;'>{$row->weight}</td>
        <td style='padding: 12px; border: 1px solid #ddd;'>{$row->attribute}</td>
        <td style='padding: 12px; border: 1px solid #ddd;'>
            <a href='bobot-edit.php?id={$row->id_criteria}' class='btn btn-info btn-sm'>Edit</a>
            <a href='bobot-hapus.php?id={$row->id_criteria}' class='btn btn-danger btn-sm'>Hapus</a>
        </td>
      </tr>\n";
                      }
                      $result->free();
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

  <!-- Modal for adding criteria -->
  <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">Tambah Kriteria</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <form action="bobot-simpan.php" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="criteria">Kriteria:</label>
              <input type="text" id="criteria" name="criteria" placeholder="Nama Kriteria..." class="form-control" required>
            </div>
            <div class="form-group mt-3">
              <label for="weight">Bobot:</label>
              <input type="number" id="weight" name="weight" step="0.01" placeholder="Bobot Kriteria..." class="form-control" required>
            </div>
            <div class="form-group mt-3">
              <label for="attribute">Atribut:</label>
              <select id="attribute" name="attribute" class="form-control" required>
                <option value="benefit">Keuntungan (benefit)</option>
                <option value="cost">Biaya (cost)</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
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

  <?php require "layout/js.php"; ?>
</body>

</html>