<?php 
include_once 'islemler/db.php';
include 'fonksiyonlar.php';

ob_start();
session_start();
require("dil.php");

$dil=$dildetaylari;

//Site ayarlarını veritabanından çekme işlemi
$ayarsor=$db->prepare("SELECT * FROM ayarlar");
$ayarsor->execute();
$ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Aksoyhlc Link Kısaltma Scripti</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <!-- Tema CSS -->
  <link rel="stylesheet" href="assets/css/aksoyhlc.css">
  <link rel="shortcut icon" type="image/png" href="logo.jpg">
  <style type="text/css" media="screen">
    body {
      padding: 0px !important;
      background: url(abc.jpg) no-repeat center center fixed; 
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }
  </style>
  <script src="assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {"families":["Lato:300,400,700,900"]},
      custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['assets/css/fonts.min.css']},
      active: function() {
        sessionStorage.fonts = true;
      }
    });
  </script>
</head>
<body>
  <span style="display: none;" id="top"></span>
  <div class="container-fluid" style="padding: 0px !important">
   <nav class="navbar navbar-expand-md">
    <button class="navbar-toggler btn btn-white btn-block" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="margin-left: 7px; max-width: 40%;">
      <span style="font-size: 1rem; font-weight: 300;"><i class="fas fa-bars" style=" color: #5a6464;"></i><?php echo $dil['menu'] ?></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto justify-content-center menu-ul" style="align-items: initial;">
        <li class="nav-item">
          <a class="btn btn-white ml-2 nav-link menu-yazi" href="index.php"><?php echo $dil['linkolustur'] ?></a>
        </li>
      </ul>
    </div>
  </nav>
   <h1 class="d-none">Bu link kıslatma scripti <a href="https://www.aksoyhlc.net" rel="follow">"Ökkeş Aksoy | Aksoyhlc"</a> Tarafından Yapılmıştır</h1> 
  <form id="dilformu" onsubmit="return false" style="display: none;">
    <input type="hidden" name="dil" value="" id="dilid">
    <input type="hidden" name="islem" value="dil">
  </form>