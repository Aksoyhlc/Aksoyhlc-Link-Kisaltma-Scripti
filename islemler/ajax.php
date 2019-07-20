<?php 
require 'db.php';
include_once '../fonksiyonlar.php';
ob_start();
session_start();

//Site ayarlarını veritabanından çekme işlemi
$ayarsor=$db->prepare("SELECT * FROM ayarlar");
$ayarsor->execute();
$ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC);

$tarih=date('Y.m.d H:i:s');

/****************************************************/

if (isset($_POST['link_kontrol'])) {
	if (strlen($_POST['link_uzun'])<5) {
		echo '{"sonuc":"bos"}';
	} else {
		if (filter_var($_POST['link_uzun'], FILTER_VALIDATE_URL)) {
			if ($_POST['link_sifre']==$_POST['link_sifre_tekrar']) { 
				
				$linksor=$db->prepare("SELECT * FROM link WHERE link_kisa=:link_kisa");
				$linksor->execute(array(
					'link_kisa'=> $_POST['link_kisa']));
				$sayi=$linksor->rowcount();
				if ($sayi>0) {
					echo '{"sonuc":"link"}';
				} else {
					echo '{"sonuc":"tamam"}';
				}
				
			} else {
				echo '{"sonuc":"sifreuyusmuyor"}';
			}
		} else {
			echo '{"sonuc":"linkdegil"}';
		}
	}
	exit;
}


/****************************************************/


if (@$islem=="dil") {
	unset($_SESSION['site_dili']); 
	$_SESSION['site_dili']=$_POST['dil'];
	exit;
}


/****************************************************/

if (isset($_POST['sifre_kontrol'])) {
	if (strlen($_POST['sifre'])==0) {
		echo '{"sonuc":"bos"}';
	} else {
		$notsor=$db->prepare("SELECT * FROM link WHERE link_kisa=:link AND link_sifre=:sifre");
		$notsor->execute(array(
			'link'=> guvenlik($_POST['link']),
			'sifre' => sifre($_POST['sifre'])
		));
		$sayi=$notsor->rowcount();

		if ($sayi==0) {
			echo '{"sonuc":"yanlis"}';
		} else {
			$_SESSION['link_kisa']=guvenlik($_POST['link']);
			echo '{"sonuc":"tamam"}';
		}
	}
	exit;
}

/****************************************************/


if (isset($_POST['linkekle'])) {
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/

	if ($_POST['link_bitis']=="asla") {
		$link_tur=2;
	}
	

	if (strlen($_POST['link_kisa'])==0) {		
		if ($_POST['link_turu']=="kisa") {
			$link=kisalinkuret();
		} else {
			$link=uzunlinkuret();
		}

		$linksor=$db->prepare("SELECT * FROM link WHERE link_kisa=:link_kisa");
		$linksor->execute(array(
			'link_kisa'=> $link));
		$sayi=$linksor->rowcount();	

		if ($sayi!=0) {
			$sonuc=$sayi;
			while ($sonuc==0) {
				if ($_POST['link_turu']=="kisa") {
					$link=kisalinkuret();
				} else {
					$link=uzunlinkuret();
				}
				$linksor=$db->prepare("SELECT * FROM link WHERE link_kisa=:link_kisa");
				$linksor->execute(array(
					'link_kisa'=> $link));
				$sonuc=$linksor->rowcount();	
			}
		} else {
			echo '{"sonuc":"tamam"}';
		}
	} else {
		$link=turkce($_POST['link_kisa']);
	}	

	$ip='IP Adresi: '. @$_SERVER['REMOTE_ADDR'];
	$uzakhost='<br>Bilgisayar Adı-Uzak Host: '. gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$useragent='<br>İnternet Tarayıcısı: '. @$_SERVER['HTTP_USER_AGENT'];
	$geldigiadres='<br>Geldiği Adres: '. @$_SERVER['HTTP_REFERER'];
	$tarayicidili='<br>Tarayıcı Dili: '. @$_SERVER['HTTP_ACCEPT_LANGUAGE'];
	$gercekip='<br>Gerçek IP (Proxy ile gelmişse): '. @$_SERVER['HTTP_X_FORWARDED_FOR'];

	$bilgiler=$ip.$uzakhost.$useragent.$geldigiadres.$tarayicidili.$gercekip;

	if (strlen($_POST['link_sifre'])==0) {
		$sifre="";
	} else {
		$sifre=sifre($_POST['link_sifre']);
	}
	

	if ($_POST['link_bitis']=="asla") {
		$bitis_tarihi="2050.12.12 23:59:59"	;
	} else {
		if ($_POST['link_bitis']!=0 AND $_POST['link_bitis']!=1 AND $_POST['link_bitis']!=3 AND  $_POST['link_bitis']!=24 AND $_POST['link_bitis']!=72 AND $_POST['link_bitis']!=168 AND $_POST['link_bitis']!=336 AND $_POST['link_bitis']!=720) {
			$gelenbitis=168;
		} else {
			$gelenbitis=$_POST['link_bitis'];
		}

		if ($_POST['link_bitis']<1) {
			$link_tur=0;
			$gelenbitis=336;
		} else {
			$link_tur=1;
		}
		$bitis_tarihi=date('Y.m.d H:i:s', strtotime('+'.$gelenbitis.' hours'));	
	}

	$linkekle=$db->prepare("INSERT INTO link SET 
		link_kisa=:link_kisa,
		link_uzun=:link_uzun,
		link_bitis=:link_bitis, 
		link_baslangic=:link_baslangic,
		link_sifre=:link_sifre,
		link_tur=:link_tur,		
		link_ekleyen_bilgiler=:link_ekleyen_bilgiler						
		");

	$linkekle->execute(array(
		'link_kisa' => guvenlik($link),
		'link_uzun' => guvenlik($_POST['link_uzun']),		
		'link_bitis'=> $bitis_tarihi,
		'link_baslangic'=> $tarih,
		'link_sifre' => 	$sifre,
		'link_tur'=> $link_tur,		
		'link_ekleyen_bilgiler' => $bilgiler
	));

	if ($linkekle) {	
		$_SESSION['hazirlanan_link']=$link;
		header("location:../link.php");
	} else {
		//header("location:../link.php");
		print_r($linkekle->errorInfo());
		exit;
	}
	exit;
}


?>