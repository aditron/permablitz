<script type="text/javascript">
jQuery(document).ready(function($){
	$('.frmapi_test_connection').click(frmapi_test_connection);
	$('.frmapi_insert_default_json').click(frmapi_insert_json);
});

function frmapi_test_connection(){
	var settings = jQuery(this).closest('.frm_single_api_settings');
	var key = settings.data('actionkey');
	var baseName = 'frm_api_action['+key+'][post_content]';

	var url = jQuery('input[name="'+baseName+'[url]"]').val();
	var key = jQuery('input[name="'+baseName+'[api_key]"]').val();

	if (url == '') {
		settings.find('.frmapi_test_connection').html('Please enter a URL');
		return;
	}

	var testResponse = settings.find('.frmapi_test_resp');
	testResponse.html('').addClass('spinner').show();

	jQuery.ajax({
		type:'POST',url:ajaxurl,
		data:'action=frmapi_test_connection&url='+url+'&key='+key,
		success:function(html){
			testResponse.removeClass('spinner').html(html);
		}
	});
}

function frmapi_insert_json(){
	var form_id = jQuery('input[name="id"]').val();
	var settings = jQuery(this).closest('.frm_single_api_settings');
	var key = settings.data('actionkey');
	var baseName = 'frm_api_action['+key+'][post_content]';

	if (form_id == '') {
		jQuery('textarea[name="'+baseName+'[data_format]"]').val('');
		return;
	}

	jQuery.ajax({
		type:'POST',url:ajaxurl,
		data:'action=frmapi_insert_json&form_id='+form_id,
		success:function(html){
			jQuery('textarea[name="'+baseName+'[data_format]"]').val(html);
		}
	});
}
</script>
