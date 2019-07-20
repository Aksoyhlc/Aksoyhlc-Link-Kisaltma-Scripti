<?php 
/*
Türkçe 
Bu script, "Creative Commons 4.0 (CC BY-NC-ND 4.0)" lisansı altında lisanslanmıştır. Bir ücret karşılığında satış yapamazsınız, bir yerde paylaştığınızda adımı paylaşmak zorundasınız, kendinize aitmiş gibi paylaşım yapamazsınız.

İletişim:
Skype: Aksoyhlc (önerilen)
Mail: aksoyhlc@gmail.com | 27aksoy27@gmail.com | admin@aksoyhlc.net
Link: https://www.aksoyhlc.net/iletisim

English 
This script is licensed under "creative commons 4.0 (CC BY-NC-ND 4.0)" license. You can't sell for a fee, you have to share my name when you share it somewhere.
*/
 ?>
<?php include 'header.php'; ?>

<div class="container-fluid mt-2 icerik">
  <div class="row justify-content-center">
    <div class="col-md-6 bg-white shadow-lg p-4 rounded mt-3">
      <form id="linkformu" action="islemler/ajax.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-12 p-4">
            <input type="text" class="form-control" name="link_uzun" placeholder="Link" style="padding: 1.6rem; font-size:1.2rem; border-radius: 0.5rem;">
          </div>    
          <div class="container-fluid">
            <div class="form-row">
              <div class="col-md-6 text-center mt-2">
                <button type="button" class="btn btn-danger" id="secenekler"><i class="fas fa-cogs"></i> <?php echo $dil['secenekler'] ?></button> 
              </div>
              <div class="col-md-6 text-center mt-2">                  
                <button type="button" class="btn btn-info" id="kaydet"><i class="fas fa-link"></i> <?php echo $dil['linkolustur'] ?></button>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-4" id="seceneklerbolumu" style="display: none">
         <div class="jumbotron-fluid">
          <h4 class="lead"><?php echo $dil['ayarlanabilirsecenekler'] ?></h4>
          <hr>
          <div class="form-row">
            <div class="col-md-6">
              <label for="ozellink"><?php echo $dil['ozellink'] ?></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3"><?php echo $ayarcek['site_link'] ?>/</span>
                </div>
                <input type="text" class="form-control" name="link_kisa" id="ozellink" aria-describedby="basic-addon3">
              </div>
            </div>
            <div class="col-md-6">
              <label><?php echo $dil['sure'] ?> <span class="badge badge-danger"><?php echo $dil['nezamansilinsin'] ?></span></label>
              <select name="link_bitis" id="tarih" class="form-control">
               <option value="0"><?php echo $dil['okunduktansonra'] ?></option>
               <option value="1"><?php echo $dil['birsaat'] ?></option>
               <option value="3"><?php echo $dil['ucsaat'] ?></option>
               <option value="24"><?php echo $dil['birgun'] ?></option>
               <option value="72"><?php echo $dil['ucgun'] ?></option>
               <option value="168"><?php echo $dil['yedigun'] ?></option>
               <option value="336"><?php echo $dil['ondortgun'] ?></option>
               <option value="720"><?php echo $dil['otuzgun'] ?></option>
               <option selected="" value="asla"><?php echo $dil['asla'] ?></option>
             </select>
           </div>
           <div class="col-md-6">
            <label><?php echo $dil['sifre'] ?></label>
            <input type="password" class="form-control" name="link_sifre" placeholder="<?php echo $dil['sifre'] ?>">
          </div>
          <div class="col-md-6">
            <label><?php echo $dil['sifretekrar'] ?></label>
            <input type="password" class="form-control" name="link_sifre_tekrar" placeholder="<?php echo $dil['sifretekrar'] ?>">
          </div>
        </div>
        

        <div class="form-row justify-content-center mt-3">
          <div class="col-md-6 text-center">
            <label><?php echo $dil['linkturu'] ?></label>
            <div class="custom-control custom-radio">
              <input value="kisa" checked="" type="radio" class="custom-control-input" id="kisalink" name="link_turu" required>
              <label class="custom-control-label" for="kisalink"><?php echo $dil['kisa'] ?></label>
            </div>
            <div class="custom-control custom-radio mb-3">
              <input value="uzun" type="radio" class="custom-control-input" id="uzunlink" name="link_turu" required>
              <label class="custom-control-label" for="uzunlink"><?php echo $dil['uzun'] ?></label>
              <div class="invalid-feedback">More example invalid feedback text</div>
            </div>
          </div>
        </div>
        <div class="gondermealani">

        </div>
      </div>
    </div>
  </form>
</div>
</div>

<?php 
$nottoplamsor=$db->prepare("SELECT link_uzun FROM link");
$nottoplamsor->execute(); 
$nottoplamsonuc=$nottoplamsor->rowcount()
?>

<div class="container mt-3">  
  <div class="row justify-content-center">
    <div class="col-sm-6 col-md-3 mb-2">
      <div class="card card-stats card-round shadow-lg">
        <div class="card-body ">
          <div class="row align-items-center">
            <div class="col-icon">
              <div class="icon-big text-center icon-primary bubble-shadow-small">
                <i class="far fa-sticky-note"></i>
              </div>
            </div>
            <div class="col col-stats ml-3 ml-sm-0">
              <div class="numbers">
                <p class="card-category"><?php echo $dil['linksayisi'] ?></p>
                <h4 class="card-sayi"><span class="badge badge-secondary" style="font-size: 1.1rem; font-weight: 300"><?php echo $nottoplamsonuc ?></span></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php 
    $nottoplamsor=$db->prepare("SELECT SUM(link_toplam_okunma) FROM link");
    $nottoplamsor->execute(); 
    $toplamokunma=$nottoplamsor->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="col-sm-6 col-md-4 mb-2">
      <div class="card card-stats card-round shadow-lg">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-icon">
              <div class="icon-big text-center icon-info bubble-shadow-small">
                <i class="fas fa-chart-line"></i>
              </div>
            </div>
            <div class="col col-stats ml-3 ml-sm-0">
              <div class="numbers">
                <p class="card-category"><?php echo $dil['toplamokunma'] ?></p>
                <h4 class="card-sayi"><span class="badge badge-secondary" style="font-size: 1.1rem; font-weight: 300"><?php echo $toplamokunma['SUM(link_toplam_okunma)'] ?></span></h4>
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
</div>
<script type="text/javascript">
  dil="tr";
</script>
<?php include 'footer.php';?>

<script type="text/javascript" src="assets/upload/js/locales/tr.js"></script>
<style type="text/css" media="screen">
  .file-details-cell{
    display: none !important;
  }
  .file-preview{
    display: none;
  }
</style>
<script>
  $(document).ready(function () {
    $("#secenekler").click(function(){
      $("#seceneklerbolumu").toggle(800);
    });

    moment.locale();       
    tarih=moment().format('YYYY-MM-DD HH:mm:ss');  
    
    $("#dosya").click(function(){
      $(".file-preview").show(800);
    });

    metin1="<?php echo $dil['placeholder'] ?>"


    $("#kaydet").click(function(event) {
      $.ajax({
        type:"POST",
        url:"islemler/ajax.php",
        data: $('#linkformu').serialize() + "&link_kontrol=kontrol&link_baslangic="+tarih,
        success:function(donenveri){
          var gelen=JSON.parse(donenveri);
          var deger=gelen.sonuc;
          if (deger!="tamam") {
            if (deger=="bos") {
              metin="<?php echo $dil['hepsinidoldur'] ?>";
            };
            if (deger=="mailhata") {         
              metin="<?php echo $dil['mailhata'] ?>"
            };
            if (deger=="sifreuyusmuyor") {         
              metin="<?php echo $dil['sifrehata'] ?>"
            };
            if (deger=="link") {         
             metin="<?php echo $dil['linkhata'] ?>";
           };

           if (deger=="linkdegil") {         
             metin="<?php echo $dil['linkdegil'] ?>";
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
          gonder='<input type="submit" name="linkekle" id="gonder" style="display: none;">';
          $(".gondermealani").html(gonder);
          $("#gonder").trigger('click');
        };         
      }
    });
    });
  });
</script>