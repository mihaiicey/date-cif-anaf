(function( $ ) {
	'use strict';

	$( window ).load(function() {
		$('#cui').on("change", function(e){
			e.preventDefault();
			const cui = $(this).val()
			if (  cui.toLowerCase().includes("ro") ){
				alert("CUI-ul se trece fara RO")
			} else{
					const formData = {
						cui
					}
					const form = new FormData()
					$.ajax({
						type: 'GET',
						url: '/wp-json/anaf/cui',
						data: formData,
						beforeSend: function ( xhr ) {
							xhr.setRequestHeader( 'X-WP-Nonce', anafcui_object.nonce );
						},
						success: (response) => {
							if(response === false){
								alert('Acest CUI: '+cui+' este gresit!')
							}else{
								$('#nr_reg_com').val(response.reg_com)
								$('#billing_company').val(response.nume)
								$('#billing_phone').val(response.telefon)
								$('#billing_address_1').val(response.strada + ', Nr. ' + response.numar)
								$('#billing_postcode').val(response.cod_postal)
							}
						}
					});
			}
		});
	})

})( jQuery );
