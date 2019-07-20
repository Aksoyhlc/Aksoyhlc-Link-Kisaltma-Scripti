/* 
	Bu Js Dosyasi Vehbi aksoyhlc Tarafindan Kodlanmistir. // Düzenlemeler Yapılmıştır... \\
	E-Posta: mf.leqelyy@gmail.com
	Web: vehbiaksoyhlc.com
*/
 
(function($){
	$.fn.aksoyhlcSayac = function(config){
		
		var ayarlar = $.extend({
			'gun' : 10,
			'saat': 24,
			'dakika': 60,
			'saniye': 0
		},config);
		
		// ayarları aldık 
		return this.each(function(){
			
			var saniye = ayarlar.gun*60*60*24 + ayarlar.saat*60*60 + ayarlar.dakika*60+ ayarlar.saniye,
				sayacDiv = $(this);
			
			$.azalt = function(){
				saniye--;
				
					var gun  = Math.floor(saniye/(60*60*24)),
						saat = Math.floor(saniye/(60*60)),
						dakika = Math.floor( ((saniye - saat*60*60))/60) ,
						kalanSaniye =(saniye - ( saat*60*60 + dakika*60)) ;
						kalanSaniye = kalanSaniye > 9 ? kalanSaniye : kalanSaniye;
						
						sayacDiv.html(
							'<h4>Kalan Süre: <b><span class="saniye">' + kalanSaniye + '</span><span class="min"> Saniye</span></b></h4>'
						);
						
						if(kalanSaniye == 0) {sayacDiv.html("");}
						if(kalanSaniye > 7) {sayacDiv.html("");}

					

				
				
			}
			setInterval('$.azalt()',1000);
			
			
		});
		
		
		
		
	}
	
})(jQuery);