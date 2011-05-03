<?php 
/** 
 * 
 * 
 * Page callback. 
 */
function survey_fielding_hello($first_name='',$last_name='') {
	
	//Not Ready
	$not_ready="<h3>You must complete the <a href='/profile-imls_data'>IMLS Data</a> and <a href='/profile-intake_form'>Intake</a> forms before selecting your fielding dates.</h3>
<p>Consider the time it will take to complete promotional tasks, including editing your library website and posting flyers.  Visit <a href='/codebox'>Get your links</a> for more information.</p>
<p>You will not be able to edit the IMLS Data and Intake forms once the survey fielding has begun.</p>
<p>As the survey runs, you will be informed of the number of responses, and will have the option to extend the survey.  You may extend the survey while it is running, <em>but not after it has ended.<em></p>
<p>Please <a href='/contact'>contact us</a> if you have any questions.</p>
<strong>We recommend that you run the survey for at least 2 weeks.</strong>";
	
	$content=array(
		'output'=>$not_ready,
		);

	return theme('survey_fielding', $content);
	
}


/** 
 * 
 * 
 * title callback. 
 */
function survey_fielding_title() {
	
	
	//$now = format_date(time());
	
	drupal_set_title(t('hahhaha'));
}

