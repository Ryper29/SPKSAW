<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SAW</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
</head>

<body>
    <div id="auth">

        <div class="container d-flex justify-content-center align-items-center min-vh-100">

            <div class="row border rounded p-3 bg-white shadow box-area">
                <div class="col-md-6 rounded d-flex justify-content-center align-items-center flex-column left-box" style="background: #435EBE;">
                    <div class="featured-image mb-3">
                        <img src="assets/images/logo.png" class="img-fluid" style="width: 250px;">
                    </div>
                    <p class="text-white text-center fs-3" style="font-weight: 600;">SPK Pemilihan Jurusan Kuliah
                    </p>
                    <small class="text-white text-wrap text-center" style="font-weight: 700; width: 17rem; font-size: 12px;">Bantu siswa memilih jurusan kuliah.</small>
                </div>

                <div class="col-md-6 right-box">
                    <div class="row align-items-center">
                        <div class="mb-4">
                            <h2>Halo!</h2>
                            <p>Selamat datang kembali</p>
                        </div>

                        <form action="login-act.php" method="post">
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" class="form-control form-control-xl" placeholder="Masukan Username..." name="username">
                                <div class="form-control-icon">
                                    <i class="bi bi-person-circle"></i>
                                </div>
                            </div>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="password" class="form-control form-control-xl" placeholder="Masukan Password..." name="password">
                                <div class="form-control-icon">
                                    <i class="bi bi-lock"></i>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /*------------ For small screens------------*/
            @media only screen and (max-width: 768px) {
                .box-area {
                    margin: 0 10px;
                }

                .left-box {
                    height: 100px;
                    overflow: hidden;
                }

                .right-box {
                    padding: 20px;
                }
            }
        </style>

    </div>
</body>

</html>