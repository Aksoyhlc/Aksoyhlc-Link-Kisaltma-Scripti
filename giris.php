<?php require 'header.php'; ?>

<div class="container-fluid mt-2">
	<div class="row justify-content-center">		
		<div class="col-md-5 shadow-lg bg-white p-3 rounded" id="sifretamami">
			<div>
				<div class="row">
					<div class="col-md-12">
						<div class="text-center">
							<hr>
							<form id="girisformu" onsubmit="return false">								
								<div class="form-row justify-content-center">								
									<div class="form-group col-md-6">
										<label>E-Mail</label>
										<input type="email" class="form-control" required name="kul_mail" placeholder="E-Mail">
									</div>									
								</div>		
								<div class="form-row justify-content-center">
									<div class="form-group col-md-6">
										<label><?php echo $dil['sifre'] ?></label>
										<input type="password" class="form-control" required name="kul_sifre" placeholder="<?php echo $dil['sifre'] ?>">
									</div>
								</div>				
								<div class="form-row justify-content-center">
									<button type="button" class="btn btn-primary btn-lg oturumac"><?php echo $dil['oturumac'] ?></button>
								</div>
								<input type="hidden" name="oturumacgiris" value="oturumacgiris">
							</form>
							<hr>
							<div class="text-center alert mt-2" id="sonuc" role="alert"></div>
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
		$(".oturumac").on("click", function () {     
			$.ajax({
				type:"POST",
				url:"panel/islemler/islem.php",
				data: $('#girisformu').serialize(),
				success:function(donenveri){
					var gelen=JSON.parse(donenveri);
					var deger=gelen.sonuc;
					if (deger!="tamam") {
						document.getElementById("sonuc").classList.add('alert-danger');
						document.getElementById("sonuc").style.display="block";
					} else {
						document.getElementById("sonuc").classList.remove('alert-danger');
						document.getElementById("sonuc").classList.add('alert-success');
						document.getElementById("sonuc").style.display="block";
						document.getElementById("sonuc").innerHTML="<b>Oturum Açma İşlemi Başarılı <br> Lütfen Bekleyin...</b>";
						setTimeout(function(){ window.location="index.php"; }, 1000);
					};
					if (deger=="bos") {
						$("#sonuc").text("<?php echo $dil['hepsinidoldur'] ?>")
					};
					if (deger=="yanlis") {
						$("#sonuc").text("<?php echo $dil['oturumyanlis'] ?>")
					};
				}
			});
		});
	});
</script>
