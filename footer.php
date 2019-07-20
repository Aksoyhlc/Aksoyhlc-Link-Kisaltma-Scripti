<script type="text/javascript">
	dil="<?php echo @$_SESSION['site_dili'] ?>"
</script>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="assets/js/core/jquery.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/editor/summernote-bs4.min.js"></script>
<script type="text/javascript" src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="assets/js/plugin/moment/moment.js"></script>



<script type="text/javascript">
	function dilsec(sitedili){
		$("#dilid").val(sitedili);
		$.ajax({
			url: 'islemler/ajax.php',
			type: 'POST',
			data: $("#dilformu").serialize(),
			success:function(donenveri){
				location.reload();       
			}
		})
		.done(function() {
			console.log("başarılı");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});

	}
</script>
</body>
</html>