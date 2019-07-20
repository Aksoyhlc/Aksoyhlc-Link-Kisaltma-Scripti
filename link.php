<?php require 'header.php'; 

$linksor=$db->prepare("SELECT * FROM link WHERE link_kisa=:link_kisa");
$linksor->execute(array(
	'link_kisa'=> guvenlik(@$_GET['link'])
));
$sayi=$linksor->rowcount();
$linkcek=$linksor->fetch(PDO::FETCH_ASSOC);



if (empty($_SESSION['hazirlanan_link'])) {
	if ($sayi==0 OR $linkcek['link_durum']==0) {
		header("location:404.php");
		exit;
	} else {
		if ($linkcek['link_tur']==1) {
			$tarih1 =time();
			$tarih2 = strtotime($linkcek['link_bitis']);
			$fark = $tarih2 - $tarih1;
			$tarihsonuc = floor($fark / (60));

			if ($tarihsonuc<1) {
				$linkguncelle=$db->prepare("UPDATE link SET link_durum=:link_durum WHERE link_kisa=:link_kisa");
				$linkguncelle->execute(array(
					'link_kisa' => $_GET['link'],					
					'link_durum' => 2
				));
				header("location:404.php");
				exit;
			}
		}
	}
}
?>

<style type="text/css" media="screen">
	a.disabled {
		pointer-events: none;
		cursor: default;
	}
	div {
		word-break: break-all;
	}
</style>

<div class="container-fluid mt-2 justify-content-center">
	<?php 
	if (isset($_SESSION['hazirlanan_link']) AND empty($_GET['link'])) { ?>			
		<div class="row justify-content-center">
			<div class="col-md-7 shadow-lg bg-white p-3 rounded" id="sifretamami">
				<div>
					<div class="row">
						<div class="col-md-12">
							<div class="text-center">
								<span class="badge badge-info shadow" style="font-size: 1rem; font-weight: 300; padding: 0.8rem;"><?php echo $dil['notlinki'] ?></span>
								<hr>
								<form>
									<div class="form-row justify-content-around p-2">
										<div class="col-md-10">
											<label style="font-weight: 300; font-size: 1.7rem">Link</label>
											<div class="input-group flex-nowrap">
												<div class="input-group-prepend">
													<span class="input-group-text" id="addon-wrapping"><i class="fas fa-link"></i></span>
												</div>
												<div style="font-size: 1.5rem; word-break: break-all; height: auto;" readonly="" class="form-control">
													<p style="margin-bottom: 0px !important;"><?php echo $ayarcek['site_link'] ?>/<?php echo $_SESSION['hazirlanan_link'] ?></p>
												</div>	
												<input style="font-size: 1.5rem; display: none;" id="linkalani" readonly="" class="form-control" type="hidden" value="<?php echo $ayarcek['site_link'] ?>/<?php echo $_SESSION['hazirlanan_link'] ?>">											
											</div>
											<button onclick="linkkopyala();" id="linkkopyalamabutonu" type="button" class="btn btn-danger mt-3"><?php echo $dil['kopyala'] ?></button>
											<a href="index.php" title="Ana Sayfa"><button type="button" class="btn btn-info mt-3 ml-2"><?php echo $dil['linkolustur'] ?></button></a>
										</div>
									</div>
								</form>
							</div>						
							<hr>

							<div class="text-center">
								<a rel="nofollow" href="http://twitter.com/share?url=<?php echo $ayarcek['site_link'] ?>/<?php echo $_SESSION['hazirlanan_link']; ?>&text=Aksoyhlc Link Kısaltma Scripti" target="_blank"><span style="font-size: 1.5rem" class="badge badge-dark"><i class="fab fa-twitter-square"></i></span></a>
								<a rel="nofollow" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $ayarcek['site_link'] ?>/<?php echo $_SESSION['hazirlanan_link']; ?> " target="_blank"><span style="font-size: 1.5rem" class="badge badge-dark"><i class="fab fa-facebook-square"></i></span></a>
								<a rel="nofollow" href="mailto:abc@gmail.com?body=<?php echo $ayarcek['site_link'] ?>/<?php echo $_SESSION['hazirlanan_link']; ?> " target="_blank"><span style="font-size: 1.5rem" class="badge badge-dark"><i class="fas fa-envelope"></i></span></a>
								<a rel="nofollow" href="http://wa.me/?text=<?php echo $ayarcek['site_link'] ?>/<?php echo $_SESSION['hazirlanan_link']; ?> " target="_blank"><span style="font-size: 1.5rem" class="badge badge-dark"><i class="fab fa-whatsapp"></i></span></a>
							</div>
						</div>	
						<?php unset($_SESSION['hazirlanan_link']); ?>
					</div>	
					<script type="text/javascript">
						metin="10";
					</script>			
				</div>
			</div>
		</div>
	<?php } else { 
		if (strlen($linkcek['link_sifre'])>5 AND @$_SESSION['link_kisa']!=@$_GET['link']) { ?>	
			<div class="row justify-content-center">
				<div class="col-md-5 shadow-lg bg-white p-3 rounded" id="sifretamami">
					<div>
						<div class="row">
							<div class="col-md-12">
								<div class="text-center">
									<span class="badge badge-info shadow" style="font-size: 1rem; font-weight: 300; padding: 0.8rem;"><?php echo $dil['notsifregir'] ?></span>
									<hr>
									<form onsubmit="return false" id="sifreformu">
										<!-- Reklam alanı girş (reklam eklemeyeceksiniz alttaki satırları silin) -->
										<div class="row mt-3">
											<div class="col-md-12">							
												"REKLAM ALANI"			
											</div>
										</div>
										<!-- Reklam alanı çıkış (reklam eklemeyeceksiniz yukarıdali satırları silin) -->		
										<div class="form-row justify-content-around p-2">
											<div class="col-md-10">
												<label style="font-weight: 300; font-size: 1.7rem"><?php echo $dil['sifre'] ?></label>
												<div class="input-group flex-nowrap">
													<div class="input-group-prepend">
														<span class="input-group-text" id="addon-wrapping"><i class="fas fa-lock"></i></span>
													</div>
													<input type="password" name="sifre" class="form-control" placeholder="Şifre" aria-label="password" aria-describedby="addon-wrapping">
													<input type="text" name="link" value="<?php echo $_GET['link'] ?>" style="display: none;">
													<input type="hidden" name="sifre_kontrol" value="0">
												</div>
												<button type="button" class="btn btn-danger mt-3" id="kontrol"><?php echo $dil['kontrolet'] ?></button>
											</div>											
										</div>
										<!-- Reklam alanı girş (reklam eklemeyeceksiniz alttaki satırları silin) -->
										<div class="row mt-3">
											<div class="col-md-12">							
												"REKLAM ALANI"			
											</div>
										</div>
										<!-- Reklam alanı çıkış (reklam eklemeyeceksiniz yukarıdali satırları silin) -->
									</form>
								</div>						
								<hr>
								<div class="text-center" style="font-weight: 300; font-synthesis: 0.9rem">www.aksoyhlc.net</div>
							</div>
						</div>	
						<script type="text/javascript">
							metin="10";
						</script>			
					</div>
				</div>
			</div>
			<?php unset($_SESSION['hazirlanan_link']); ?>
			<?php unset($_SESSION['link_kisa']); ?>
		<?php } else { ?>

			<!--------------------------------------------------------------------------------------------------------->

			<div class="container-fluid">
				<div class="row justify-content-center ">
					<div class="col-md-8 text-center shadow-lg bg-white p-4 rounded" id="notalanitamami">
						<span class="badge badge-danger shadow" style="font-size: 1rem; font-weight: 300; padding: 0.8rem;"><?php echo $dil['sureuyari'] ?></span>
						<hr>
						<!-- Reklam alanı girş (reklam eklemeyeceksiniz alttaki satırları silin) -->
						<div class="row mt-3">
							<div class="col-md-12">							
								"REKLAM ALANI"			
							</div>
						</div>
						<!-- Reklam alanı çıkış (reklam eklemeyeceksiniz yukarıdali satırları silin) -->
						<div class="row justify-content-center text-center mb-3 mt-2 surebolumu">
							<span class="surebolumu" style="
							background: #4e73df;
							padding: 12px;
							border-radius: 5px;
							color: white;
							"><?php echo $dil['kalansure'] ?> <span style="
							background: white;
							padding: 7px;
							border-radius: 3px;
							color: gray;
							" id="sure" class="font-weight-bold">0</span>
						</span>
					</div>
					<!-- Reklam alanı girş (reklam eklemeyeceksiniz alttaki satırları silin) -->
					<div class="row mt-3">
						<div class="col-md-12">							
							"REKLAM ALANI"			
						</div>
					</div>
					<!-- Reklam alanı çıkış (reklam eklemeyeceksiniz yukarıdali satırları silin) -->
					<br>
					<div class="row justify-content-center text-center">
						<a rel="nofollow" id="gidileceklink" href="#" class="disabled linkegit" style="display: none;">
							<button type="button" class="btn btn-info btn-lg disabled linkegit" id="notkopyalamabutonu"><i class="fas fa-arrow-circle-right"></i></i> <?php echo $dil['linkegit'] ?></button>
						</a>
						<button type="button" class="btn btn-primary btn-lg disabled bekleyin"><?php echo $dil['bekleyin'] ?>...</button>
					</div>
					<!-- Reklam alanı girş (reklam eklemeyeceksiniz alttaki satırları silin) -->
					<div class="row mt-3">
						<div class="col-md-12">							
							"REKLAM ALANI"			
						</div>
					</div>
					<!-- Reklam alanı çıkış (reklam eklemeyeceksiniz yukarıdali satırları silin) -->
					<hr>
					<p><b><?php echo $dil['gidileceklink'] ?>: </b><?php echo $linkcek['link_uzun'] ?></p>

					<?php 
					unset($_SESSION['link_kisa']); 
					if ($linkcek['link_tur']==0) {
						$linkguncelle=$db->prepare("UPDATE link SET link_durum=:link_durum WHERE link_kisa=:link_kisa ");
						$linkguncelle->execute(array(
							'link_kisa' => $_GET['link'],					
							'link_durum' => 0
						));
					} else {
						$linkguncelle=$db->prepare("UPDATE link SET link_son_okunma=:link_son_okunma, link_toplam_okunma=:link_toplam_okunma WHERE link_kisa=:link_kisa ");
						$linkguncelle->execute(array(
							'link_kisa' => $_GET['link'],					
							'link_son_okunma' => date('Y.m.d H:i:s'),
							'link_toplam_okunma' => $linkcek['link_toplam_okunma']=$linkcek['link_toplam_okunma']+1
						));
					}
					?>
				</div>
			</div>
		</div>

		<!--------------------------------------------------------------------------------------------------------->

		<div class="container mt-5">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-sm-6 col-md-4 mb-2">
						<div class="card card-stats card-round shadow-lg">
							<div class="card-body ">
								<div class="row align-items-center">
									<div class="col-icon">
										<div class="icon-big text-center icon-info bubble-shadow-small">
											<i class="fas fa-eye"></i>
										</div>
									</div>
									<div class="col col-stats ml-2">
										<div class="numbers">
											<p class="card-category"><?php echo $dil['okunmasayisi'] ?></p>
											<h4 class="card-sayi"><span class="badge badge-secondary" style="font-size: 1.1rem; font-weight: 300"><?php echo $linkcek['link_toplam_okunma'] ?></span></h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-4 mb-2 justify-content-center">
						<div class="card card-stats card-round shadow-lg">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-icon">
										<div class="icon-big text-center icon-success bubble-shadow-small">
											<i class="far fa-calendar-plus"></i>
										</div>
									</div>
									<a style="display: none;" href="https://www.aksoyhlc.net" title="Ökkeş Aksoy | Aksoyhlc" rel="follow"></a>
									<div class="col col-stats ml-2">
										<div class="numbers">
											<p class="card-category"><?php echo $dil['eklenmetarihi'] ?></p>
											<h4 class="card-sayi"><span class="badge badge-secondary" style="font-size: 1rem; font-weight: 300"><?php echo $linkcek['link_baslangic'] ?></span></h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-4 mb-2">
						<div class="card card-stats card-round shadow-lg">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-icon">
										<div class="icon-big text-center icon-secondary bubble-shadow-small">
											<i class="far fa-calendar-check"></i>
										</div>
									</div>
									<div class="col col-stats ml-2">
										<div class="numbers">
											<p class="card-category"><?php echo $dil['sonokunmatarihi'] ?></p>
											<h4 class="card-sayi"><span class="badge badge-secondary" style="font-size: 1rem; font-weight: 300"><?php echo $linkcek['link_son_okunma'] ?></span></h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>		
				<div class="row justify-content-center">
					<div class="col-md-10">
						<div class="card card-stats card-round shadow-lg">
							<div class="card-body text-center">
								<p style="margin-bottom: -3px">Bu script <a class="btn-link" href="https://www.aksoyhlc.net" rel="follow" title="Ökkeş Aksoy | Aksoyhlc">"Ökkeş Aksoy | Aksoyhlc"</a> tarafından hazırlanmıştır ve <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/deed.tr"> Creative Commons Lisansı</a> ile lisanslanmıştır. <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/deed.tr"><img alt="Creative Commons Lisansı" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" /></a>
								</p>
							</div>
						</div>
					</div>
				</div>			
			</div>
		</div>
	<?php } } ?>
</div>
<?php require 'footer.php'; ?>
<script type="text/javascript" src="assets/js/plugin/clipboard/clipboard.js"></script>
<style type="text/css" media="screen">
	.file-preview{
		display: block !important;
	}
	.file-details-cell{
		display: none !important;
	}
	.file-drag-handle {
		display: none !important;
	}
</style>

<script type="text/javascript">

	$(document).ready(function() {
		surebaslat();
	});

	function surebaslat(){
		sure = 10;
		zaman = setInterval(function(){
			$("#sure").text(sure);
			sure -= 1;		
			if (sure==10 || sure==20 || sure==30 || sure==40) {
				$(".surebolumu").addClass("animated wobble")
			} else {
				$(".surebolumu").removeClass('animated wobble')
			}
			if (sure==-1) {
				clearInterval(zaman);
				$('.linkegit').removeClass("disabled");
				$("#gidileceklink").attr("href", "<?php echo $linkcek['link_uzun'] ?>");
				$(".surebolumu").css('display', 'none');
				$(".bekleyin").css('display', 'none');
				$(".linkegit").css('display', 'block');
			};

		}, 1000);
	};

	$("#notkopyalamabutonu").click(function(event) {

		var clipboard = new ClipboardJS('#notkopyalamabutonu', {
			text: function() {
				kopyalanacak=$("#notalani").text();
				return kopyalanacak;				
			}
		});
		clipboard.on('success', function(e) {
			Swal.fire({				
				type: 'success',
				title: '<?php echo $dil['kopyalandi'] ?>',
				showConfirmButton: false,
				timer: 1000
			})
		});


	});

	function linkkopyala(){
		var clipboard = new ClipboardJS('#linkkopyalamabutonu', {
			text: function() {
				kopyalanacak=$("#linkalani").val();
				return kopyalanacak;				
			}
		});
		clipboard.on('success', function(e) {
			Swal.fire({				
				type: 'success',
				title: 'Link '+"<?php echo $dil['kopyalandi'] ?>",
				showConfirmButton: false,
				timer: 1000
			})
		});

	}

	$("#kontrol").click(function(event) {
		$.ajax({
			type:"POST",
			url:"islemler/ajax.php",
			data: $('#sifreformu').serialize(),
			success:function(donenveri){
				var gelen=JSON.parse(donenveri);
				var deger=gelen.sonuc;
				if (deger!="tamam") {
					if (deger=="bos") {
						metin="<?php echo $dil['hepsinidoldur'] ?>";
					};

					if (deger=="yanlis") {
						metin="<?php echo $dil['yanlissifre'] ?>";
					};

					Swal.fire({
						type: 'error',
						showConfirmButton: false,
						showCancelButton:true,
						title: "<?php echo $dil['hata'] ?>",
						text: metin,
						closeOnClickOutside: false,
						allowOutsideClick: false,
						customClass: {
							cancelButton: 'btn btn-danger'
						},
						cancelButtonText: "<?php echo $dil['tamam'] ?>"
					})

				} else {
					location.reload();
				}
			}
		})
	});

	if ($('#notalanitamami').is(':visible')) {
		abc=$("#notalani").text();
		$("#notalani").html(abc);
		metin=$("#notalani").text();
	}

	uzunluk=metin.length;
	if (uzunluk>1500) {
		$("#footeralani").removeClass("fixed-bottom");
	} else {
		$("#footeralani").addClass("fixed-bottom")
	}

</script>
