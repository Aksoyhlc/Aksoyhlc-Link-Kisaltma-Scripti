<?php require 'header.php'; ?>

<div class="container-fluid mt-2">
	<div class="row justify-content-center">		
		<div class="col-md-5 shadow-lg bg-white p-3 rounded" id="sifretamami">
			<div>
				<div class="row">
					<div class="col-md-12">
						<div class="text-center">
							<hr>
							<form id="kayitformu" onsubmit="return false">								
								<div class="form-row">
									<div class="form-group col-md-6">
										<label><?php echo $dil['adsoyad'] ?></label>
										<input type="text" class="form-control" required name="kul_isim" placeholder="<?php echo $dil['adsoyad'] ?>">
									</div>
									<div class="form-group col-md-6">
										<label>E-Mail</label>
										<input type="email" class="form-control" required name="kul_mail" placeholder="E-Mail">
									</div>
								</div>
							
								<div class="form-row">									
									<div class="form-group col-md-6">
										<label><?php echo $dil['sifre'] ?></label>
										<input type="password" class="form-control" required name="kul_sifre" >
									</div>
									<div class="form-group col-md-6">
										<label><?php echo $dil['sifretekrar'] ?></label>
										<input type="password" class="form-control" required name="kul_sifre_tekrar">
									</div>
								</div>
								<div class="form-row justify-content-center">
									<div class="form-group col-md-6">
										<label>
											<a href="privacy.php" target="_blank"><?php echo $dil['gizliliksozlesmesi'] ?></a></label><br>
											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" id="gizlilik" value="1" name="sozlesme" class="custom-control-input">
												<label class="custom-control-label" for="gizlilik"><?php echo $dil['kabulediyorum'] ?></label>
											</div>						
										</div>
									</div>
									<div class="form-row justify-content-center">
										<button type="button" class="btn btn-primary btn-lg kayit-ol"><?php echo $dil['kayitol'] ?></button>
									</div>
									<input type="hidden" name="islem" value="kayit-ol">
								</form>
								<hr>
								<div class="text-center alert mt-2" id="sonuc" name="kayit-ol" role="alert"></div>
							</div>
						</div>
					</div>		
				</div>
			</div>

		</div>
	</div>
	<?php require 'footer.php'; ?>

	<script type="text/javascript">
		$(function(){
			$(".kayit-ol").on("click", function () {     
				sozlesme = "0";
				$(":checkbox").each(function () {
					ischecked = $(this).is(":checked");
					if (ischecked) {
						sozlesme = $(this).val();
					} else {
						sozlesme = "0";
					}
				});
				$.ajax({
					type:"POST",
					url:"panel/islemler/islem.php",
					data: $('#kayitformu').serialize() + "&gizlilik_sozlesme=" + sozlesme,
					success:function(donenveri){
						var gelen=JSON.parse(donenveri);
						var deger=gelen.sonuc;
						console.log(deger);
						if (deger!="tamam") {
							document.getElementById("sonuc").classList.add('alert-danger');
							document.getElementById("sonuc").style.display="block";
						} else {
							document.getElementById("sonuc").classList.remove('alert-danger');
							document.getElementById("sonuc").classList.add('alert-success');
							document.getElementById("sonuc").style.display="block";
							document.getElementById("sonuc").innerHTML="<b>Kayıt Başarılı <br> Lütfen Bekleyin...</b>";
							setTimeout(function(){ window.location="login.php"; }, 1000);
						};
						if (deger=="bos") {
							$("#sonuc").text("<?php echo $dil['hepsinidoldur'] ?>")
						};
						if (deger=="mailhata") {         
							document.getElementById("sonuc").innerHTML="<?php echo $dil['mailhata'] ?>";
						};
						if (deger=="sifreuyusmuyor") {         
							document.getElementById("sonuc").innerHTML="<?php echo $dil['sifrehata'] ?>";
						};
						if (deger=="username") {         
 							//document.getElementById("sonuc").innerHTML="Bu Kullanıcı Adı Daha Öndecen Alınmış";
 							$("#sonuc").text("<?php echo $dil['usernamehata'] ?>")
 						};
 						if (deger=="sozlesme") {         
 							document.getElementById("sonuc").innerHTML="<?php echo $dil['gizlilikkabulet'] ?>";
 						};
 						if (deger=="mailalinmis") {         
 							document.getElementById("sonuc").innerHTML="<?php echo $dil['mailalinmis'] ?>";
 						};
 						if (deger=="kisasifre") {         
 							document.getElementById("sonuc").innerHTML="Şifreniz 10 Karakterden Daha Fazla Olmalıdır";
 						};
 					}
 				});
			});
		});
	</script>
