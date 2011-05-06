// $Id$

(function($){
$(document).ready(function(){
	$('.square_feet_link').attr('href', '#');
	$('.square_feet_link').removeAttr('target');
	var openwin;
	$('.square_feet_link').click(function() {
		openwin=window.open('http://localhost/impact_local/square_feet','loading','height=300,width=300,scrollbars=yes,toolbar=no,location=no,status=no,menubar=no,resizable=no,dependent=no');
	});
});
})(jQuery);