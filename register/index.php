<?php

include './function.php';

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo " <script>
        alert('user baru berhasil ditambahkan');  
        window.location.href = '/myapp/auth/login.php';
        </script>";
       
    } else {
        echo " <script>
        alert('user baru gagal ditambahkan')    ;
        window.location.href= '/myapp/auth/register.php');
        </script>";
      
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Aplikasi SIM Warung">
    <meta name="author" content="Daniel Fransiscus">
    <title>Register - SB Admin</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-dark">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Registrasi</h3>
                                </div>
                                <div class="card-body">
                                    <form action="<?php echo BASEURL; ?>/register/index.php" onsubmit="return validateForm()" method="POST" >
                                        <div class="row mb-2">
                                            <div class="form-floating mb-2">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="nama" type="text" placeholder="" name="nama" required />
                                                    <label class="form-label" for="nama">Nama Anda</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="form-floating mb-2">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="username" type="text" name="username" autocomplete="off" required />
                                                    <label class="form-label" for="username">Username</label>
                                                    <small class="text-danger" id="msg"> </small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="form mb-2">
                                                <select class="form-select" id="id_role" name="id_role">
                                                    <option selected disabled hidden>Pilih Role</option>
                                                    <option value="1">Admin</option>
                                                    <option value="2">Kasir</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="password" type="password" placeholder="" name="password" required />
                                                    <label class="form-label" for="password">Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="password2" type="password" placeholder="" name="password2" required />
                                                    <label class="form-label" for="password2">Password Konfirmasi</label>
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-danger" id="msg2"> </small>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-block" name="register">Registrasi</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="<?php echo BASEURL; ?>/auth/login.php">Punya akun ? Silahkan ke halaman login </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Daniel 2022</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.js"></script>



        <script>

            var siteURL = "http://localhost/myapp";

            $(document).ready(function() {
                $('#username').keyup(function() {
                    var uname = $('#username').val();
                    if(uname == 0) {
                        $('#result').text('');
                    }
                    else {
                        $.ajax({
                            url: siteURL + '/register/cek.php',
                            type: 'POST',
                            data: 'username='+uname,
                            success: function(hasil) {
                                if(hasil > 0) {
                                    $('#msg').text('Username sudah terdaftar, Pilih username baru !');
                                }
                                else {
                                    $('#msg').text('');
                                }
                            }
                        });
                    }
                });
            });

            function validateForm() {


                var password = document.getElementById("password").value;
                var password2 = document.getElementById("password2").value;

                if (password != password2){
                   text = "Password dan password konfirmasi tidak sama";
                   document.getElementById("msg2").innerHTML = text;
                   return false;
               }
               else{
                text = "";
                document.getElementById("msg2").innerHTML = text;
            }

        }
    </script>
</body>

</html>