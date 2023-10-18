jQuery(function($) {
	$('.wlticker-repeat').each(function() {
		$(this).repeatable_fields();
	});
	
	
    $('.wlticker-colorpicker').wpColorPicker();
	
	if($('.wlticker-repeat .row').length == 1){
		$('.wlticker-repeat .add-btm').css('opacity','0');
	}
	
	$('.wlticker-repeat .add').click(function(){
		$('.wlticker-repeat .add-btm').css('opacity','1');
	})
});
