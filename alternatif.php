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
                <h3 style="color: #435EBE;">Jurusan</h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #f4f4f9; border: 1px solid #e0e0e0;">
                                <h4 class="card-title">Tabel Jurusan</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <p class="card-text">
                                        Data jurusan pilihan yang akan dievaluasi direpresentasikan dalam tabel berikut:
                                    </p>
                                    <button type="button" class="btn btn-outline-success btn-sm m-2 d-flex shadow" data-bs-toggle="modal" data-bs-target="#inlineForm">
                                    <i class="iconly-boldShow mt-1 me-1"></i>Tambah Jurusan
                                    </button>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0" style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 14px;">
                                        <caption style="caption-side: top; text-align: center; font-weight: bold; font-size: 16px; color: #333; margin-top: -10px;">
                                            Tabel Jurusan A<sub>i</sub>
                                        </caption>
                                        <thead style="background-color: #435EBE; color: #fff;">
                                            <tr>
                                                <th style="padding: 12px; border: 1px solid #ddd;">No</th>
                                                <th colspan="2" style="padding: 12px; border: 1px solid #ddd;">Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = 'SELECT id_alternative, name FROM saw_alternatives';
                                            $result = $db->query($sql);
                                            $i = 0;
                                            while ($row = $result->fetch_object()) {
                                                echo "<tr>
        <td class='right' style='padding: 12px; border: 1px solid #ddd; text-align: right;'>" . (++$i) . "</td>
        <td class='center' style='padding: 12px; border: 1px solid #ddd; text-align: center;'>{$row->name}</td>
        <td style='padding: 12px; border: 1px solid #ddd;'>
            <div class='btn-group mb-1'>
                <div class='dropdown'>
                    <button class='btn btn-primary dropdown-toggle me-1 btn-sm' type='button'
                        id='dropdownMenuButton' data-bs-toggle='dropdown'
                        aria-haspopup='true' aria-expanded='false'>
                        Aksi
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                        <a class='dropdown-item' href='alternatif-edit.php?id={$row->id_alternative}'>Edit</a>
                        <a class='dropdown-item' href='alternatif-hapus.php?id={$row->id_alternative}'>Hapus</a>
                    </div>
                </div>
            </div>
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
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Login Form</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="alternatif-simpan.php" method="POST">
                    <div class="modal-body">
                        <label>Name: </label>
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Nama Kandidat..." class="form-control" required>
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