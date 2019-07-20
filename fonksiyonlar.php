<?php




date_default_timezone_set('Europe/Istanbul');



function kisalinkuret(){
	$karakterler = "1234567890abcdefghijuvwxyzklmnopqrst0987654321";
	$link = '';
	for($i=0;$i<5;$i++)                   
	{
		$link .= $karakterler{rand() % 46};  
	}
	return $link;                         
}

function uzunlinkuret(){
	$karakterler = "1234567890abcdefghijuvwxyzklmnopqrst0987654321";
	$link = '';
	for($i=0;$i<30;$i++)                   
	{
		$link .= $karakterler{rand() % 46};  
	}
	return $link;                         
}

function turkce($metin) {
	$metin = trim($metin);
	$aranacak = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
	$replace = array('c','c','g','g','i','i','o','o','s','s','u','u','-');
	$yeni_metin = str_replace($aranacak,$replace,$metin);
	return $yeni_metin;
}  


function guvenlik($gelen){
	//$giden = addslashes($gelen);
	$giden = htmlspecialchars($gelen);
	//$giden = htmlentities($giden);
	$giden = strip_tags($giden);
	return $giden;
};


function sifre($gelenveri) {
	$sifre=md5(sha1(md5($gelenveri)));
	return $sifre;
};

?>