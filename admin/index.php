<?PHP error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); 
session_start();
if (isset($_POST['tombol-login'])) {
$username = $_POST['username'];
$password = $_POST['password'];
if ($username=="admin"){
if ($password=="smk"){
$_SESSION['username'] = $username;
//header("location:#");
}
else{
header("location:./?error=1");// error
}
}
else{
header("location:./?error=2");// error
}
}
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/main.css">
        <script src="../js/vendor/modernizr-2.8.3.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="../js/vendor/bootstrap.min.js"></script>
        <script src="../js/plugins.js"></script>
        <script src="../js/main.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
      
    
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Admin SMS-System</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <?php if(empty($_SESSION[username])) {  ?>
          <form class="navbar-form navbar-right" role="form" action="" name="form-login" method="post">
            <div class="form-group">
              <input type="text" placeholder="Username" name="username" id="user" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password"  name="password" id="pass" class="form-control">
            </div>
            <button name="tombol-login" type="submit" class="btn btn-success">Sign in</button>
          </form>
          </div><!--/.navbar-collapse -->
      </div>
    </nav>
    <br>
    <br>
    <br>
    <hr>

    <div class="container">
      <?php  if (!empty($_GET['error'])) { if ($_GET['error'] == 1) 
            { echo '<div class="alert alert-danger" role="alert"><strong>Salah!</strong> username dan password salah silahkan coba lagi</div>';}
                else if ($_GET['error'] == 2) 
                  { echo '<div class="alert alert-danger" role="alert">Maaf anda tidak berhak Masuk ke halaman ini, Anda harus Login Terlebih Dahulu..!</div>';}}?>
                <div class="alert alert-danger" role="alert">Maaf anda tidak berhak Masuk ke halaman ini, Anda harus Login Terlebih Dahulu..!</div>
    </div><!-- Akhir Contaner -->
      <nav class="navbar navbar-fixed-bottom navbar-inverse">
      <a class="navbar-brand" href="#">&copy; Bad Company 2016</a>
      </nav>    
      
    </div> <!-- /container -->        

    </body>
</html>
            <?php } else { ?><!-- Jika Sukses Login -->
            <a href="log_out.php"><button type="button" class="btn btn-danger navbar-btn navbar-right">Logout</button></a>    
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

   
    <div class="container">
        <br>
        <br>
        <br>
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#home" role="tab" data-toggle="tab">
          <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Data Siswa</a></li>
          <li role="presentation"><a href="#menu1" role="tab" data-toggle="tab">
          <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Laporan Pelanggaran</a></li>
          <li role="presentation"><a href="#menu2" role="tab" data-toggle="tab">
          <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Laporan Izin</a></li>
          <li role="presentation"><a href="#menu3" role="tab" data-toggle="tab">
          <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Laporan Informasi</a></li>
          <li role="presentation"><a href="#menu4" role="tab" data-toggle="tab">
          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Laporan Absensi</a></li>
        </ul>

        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
            <?php include "tabel-data.php";?>
          </div>
          <div id="menu1" class="tab-pane fade">
            <?php include "tabel-pelanggaran.php";?>
          </div>
          <div id="menu2" class="tab-pane fade">
            <?php include "tabel-izin.php";?>
          </div>
          <div id="menu3" class="tab-pane fade">
            <?php include "tabel-informasi.php";?>
          </div>
          <div id="menu4" class="tab-pane fade">
            <?php include "tabel-absen.php";?>
          </div>          
        </div>
      </div>

      <script>
      $(document).ready(function(){
          $(".nav-tabs a").click(function(){
              $(this).tab('show');
          });
      });
      </script>
    </div><!-- Akhir Container -->
    <hr>
    <nav class="navbar navbar-fixed-bottom navbar-inverse">
      <a class="navbar-brand" href="#">&copy; Bad Company 2016</a>
    </nav>        
    <?PHP  }; ?>
    </body>
</html>
