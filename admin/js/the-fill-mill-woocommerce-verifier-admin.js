(function( $ ) {
	'use strict';
	
	$(function() {
		$('.meta-box-sortables').sortable({
	         opacity: 0.6,
	         revert: true,
	         cursor: 'move',
	         handle: '.hndle'
	     });

		$( '.tab-account-credentials' ).on( 'click', '.button-primary', function(e) {

			var $holder = $(this).closest('.tab-account-credentials');
			var api_key = $holder.find('.tfm_form_api_key').val();
			var company_name = $holder.find('.tfm_form_company_name').val();
			var company_id = $holder.find('.tfm_form_company_id').val();

			var $thisbutton = $(this);
			var $loader = $holder.find('.loader');
            var data = {
	            action: 'tfm_save_api_credentials',
	            _ajax_nonce: lt_ajax_obj.nonce,
	            api_key: api_key,
	            company_name: company_name,
	            company_id: company_id
	        };

	        $.ajax({
	            type: 'post',
	            url: lt_ajax_obj.ajax_url,
	            data: data,
	            beforeSend: function (response) {
	                $thisbutton.hide();
	                $loader.show();
	            },
	            complete: function (response) {
	                $loader.hide();
	                $thisbutton.fadeIn();
	            },
	            success: function (response) {

	            	$('.tab-account-credentials .right-col .message').hide();

	                if (response.success) {
	                    $('.tab-account-credentials .right-col .updated').fadeIn();
	                } else {
	                    $('.tab-account-credentials .right-col .error span').html(response.message);
	                    $('.tab-account-credentials .right-col .error').fadeIn();
	                }
	            },
	            error: function (xhr, ajaxOptions, thrownError) {
	            	$('.tab-account-credentials .right-col .message').hide();
					$('.tab-account-credentials .right-col .error span').html('Unauthorized access.');
	                $('.tab-account-credentials .right-col .error').fadeIn();
				}
	        });

		});
	});

})( jQuery );
