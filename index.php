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
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
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
          <a class="navbar-brand" href="#">SMS-System</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

   
    <div class="container">
        <br>
        <br>
        <br>
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#home" role="tab" data-toggle="tab">
          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Absensi</a></li>
          <li role="presentation"><a href="#menu1" role="tab" data-toggle="tab">
          <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Pelanggaran</a></li>
          <li role="presentation"><a href="#menu2" role="tab" data-toggle="tab">
          <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Izin</a></li>
          <li role="presentation"><a href="#menu3" role="tab" data-toggle="tab">
          <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Informasi</a></li>
        </ul>

        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
            <?php include "assets/tabel/tabel-absen.php";?>
          </div>
          <div id="menu1" class="tab-pane fade">
            <?php include "assets/tabel/tabel-pelanggaran.php";?>
          </div>
          <div id="menu2" class="tab-pane fade">
            <?php include "assets/tabel/tabel-izin.php";?>
          </div>
          <div id="menu3" class="tab-pane fade">
            <?php include "assets/tabel/tabel-informasi.php";?>
          </div>
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
    </div> <!-- /container -->        
    </body>
</html>
