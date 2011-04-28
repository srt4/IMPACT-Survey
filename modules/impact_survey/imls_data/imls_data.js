// $Id$

(function($){
$(document).ready(function(){
	$('#profile-imls-data-field-sq-ft-add-more-wrapper a').attr('href', '');
	$('#profile-imls-data-field-sq-ft-add-more-wrapper a').removeAttr('target');
	var openwin;
	$('#profile-imls-data-field-sq-ft-add-more-wrapper a').click(function() {
		openwin=window.open('http://localhost/impact_local/square_feet','loading','height=300,width=300,scrollbars=yes,toolbar=no,location=no,status=no,menubar=no,resizable=no,dependent=no');
	});
});
})(jQuery);