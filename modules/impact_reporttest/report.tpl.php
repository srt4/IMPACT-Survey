<?php
/** 
 * @file
 * Theme for my test module
 * Available variables:
 * - $sponsor_id: the node ID
 * - $sponsor: name of the sponsor
 */

?>

<div id="sponsor-<?php print $sponsor_id; ?>" class="sponsor">
	<h2><?php print ucwords(strtolower($sponsor)); ?></h2>
</div>

<!--
<h2>FSCS: <?php global $fscs; $fscs = "NY0562"; ?><?php print $fscs; ?></h2>
-->

<?php
// Store some useful information for the future
class SurveyResponse {
	public $title;
	public $count;
	public $percent;
	public $countPercent;
	
	public function __construct($title, $count=-1, $total=-1) {
		$this->title = $title;
		$this->count = $count;
		if ( $count != 0 && $total != 0)
			$this->percent = round( $count / $total  * 100 );
		$this->countPercent = $this->count . " (" . $this->percent . "%)"; 
	}
}
?>

<?php
/* get_survey_variable: returns a SQL table with the count of survey responses for each question, on a 
 * variable-by-variable basis.
 * 
 * @variable: the name of the variable to query (for example, GEN_visit)
 * @response_values: an associative array of response number (e.g., 2, 777) to its column title (e.g., "weekly" or "skip")
 *
 * @returns the response_values array in a modified form (a mapping of variable :  SurveyResponse)
 *
 *  Example usage: 
 * 
$gen_visit = get_survey_variable(
"GEN_visit", 
array( 
		"1,2" => "weekly",  
		"3" => "monthly", 
		"4,5" => "less than once a month", 
		"1,2,3,4,5" => "all respondents",
 		"6" => "no visits"
	  ) 
);
 * Theoretically, the title mapping isn't really necessary,
 * but it provides a coherent way to look at the data and get it 
 * into the report.
 * 
 * After this is stored in the $gen_visit variable, 
 * the number of respondants for a number can be found with
 * $gen_visit["1,2"]->count; which returns the count.
 * 
 * This can be used inline with the text, for example:
 * echo ( $gen_visit["1,2"] . " visited the library once a week or more frequently." );
 * 
 */
function get_survey_variable($variable, $response_values) {
	global $fscs; // need this for the db query
	// Harvest all the data, put it into associative arrays
	$data_array = array();
	// get the total number of non-logical skips for the variable
	// TODO: do we want to count people who answer "don't know / refuse"?
	$sql = 'SELECT count(*) AS tot FROM {Sheet1} WHERE ' . $variable . ' NOT IN ( 777 ) AND LIB_fscskey = :fscs';
	$res= db_query($sql, array(':fscs' => $fscs));
	foreach($res as $row) {
		$total = $row->tot;
	}
	
	foreach($response_values as $response_val => &$name) {
		$sql = 'SELECT count(*) AS tot FROM {Sheet1} WHERE ' . $variable . ' IN ( ' . $response_val . ' ) AND LIB_fscskey = :fscs';
		$res = db_query($sql, array(':fscs' => $fscs));
		// TODO: eliminate this foreach-loop, there should only be one result row 
		foreach ($res as $row) {
			$temp = $row->tot;
		}
		$survey_response = new SurveyResponse($name, $temp, $total);
		$name = new SurveyResponse($name, $temp, $total);
	}
	
	$response_values["total"] = $total;
	
	return $response_values;
}

// This method returns a number when called with a variable and response.
// For example, one can use this to do something such as, echo ( get_single_variable("GEN_visit", "1") . " people visited the library every day.");
function get_single_variable($variable, $response) {
	$temp = get_survey_variable( $variable, array((string)$response => "foo") );
	return $temp[(string)$response]->count;
}

$test2 = get_survey_variable("USE_travel", array("1" => "yes", "2" => "no", "3" => "don't know") );

?>

<?php

$gen_visit = get_survey_variable(
"GEN_visit", 
array( 
		"1,2" => "weekly",  
		"3" => "monthly", 
		"4,5" => "less than once a month", 
		"1,2,3,4,5" => "all respondents",
		"6" => "never visited"
	  ) 
);

echo ("All but " . $gen_visit["6"]->count . " survey respondants had visited the library in the past 12 months. Of those who did, ");
echo ("<ul><li>" . $gen_visit["1,2"]->countPercent . " visited the library once as week or more frequently.");

echo ("</ul>");


// Cover bases for the gen_internet variable
$gen_internet = get_survey_variable(
"GEN_internet",
array (
	"1,2,3,4,5,6,7" => "total",
	"1,2,3,4,5" => "used internet to access webpage",
	"1" => "every day",
	"1,2" => "week or more",
	"4,5" => "less than once a month",
	"2" => "weekly",
	"3" => "monthly",
	"4" => "several times a year",
	"5" => "once a year",
	"6" => "never",
	"7" => "don't know, refuse"
	));

echo("When asked specifically if they had <strong>used a computer in the library to access the Internet, ");
echo ($gen_internet["1,2,3,4,5"]->countPercent);
echo (" reported that they had done so, </strong> with frequencies as follows:");

echo ("<ul><li>" . $gen_internet["1,2"]->countPercent ." did so once a week or more frequently;</li>");
echo ("<li>" . $gen_internet["3"]->countPercent . " did so about 1-3 times a month;</li>");
echo ("<li>" . $gen_internet["4,5"]->countPercent . " did so less than once a month.</li></ul>");

/*
$sql = 'select (SELECT count(*) AS "no" FROM {Sheet1} WHERE GEN_visit = 2 AND LIB_fscskey = :fscs) as no, (SELECT count(*) AS "no" FROM {Sheet1} WHERE GEN_visitfr IN (1, 2) AND LIB_fscskey = :fscs) as yes';

$res = db_query($sql, array(':fscs' => $fscs));

foreach($res as $row) {
	$respond_visit_past_12 = $row->no;
	$respond_visit_yes = $row->yes;
}
$sql = 'SELECT COUNT(GEN_visit = 2) AS total FROM {Sheet1} WHERE LIB_fscskey = :fscs';
$res = db_query($sql, array(':fscs' => $fscs));

foreach($res as $row) {
	$total_respondants = $row->total;
}
echo ("All but " . $respond_visit_past_12 . " respondents had visited the library in the past 12 months. Of those who did, ");
 
echo ("<ul><li>" .  $respond_visit_yes . " (" . round($respond_visit_yes / $total_respondants * 100, 0) . "%) visited the library once a week or more frequently.</li>");

$sql = 'SELECT count(*) AS number FROM {Sheet1} WHERE GEN_visitfr IN (3) AND LIB_fscskey = :fscs';

$res = db_query($sql, array(':fscs' => $fscs));

foreach($res as $row) {
	$visit_once_month = $row->number;
}

echo ("<li>" . $visit_once_month . " (" . round($visit_once_month / $total_respondants * 100, 0) . "%) visited the library about 1-3 times a month.</li>");

$sql = 'SELECT count(*) AS number FROM {Sheet1} WHERE GEN_visitfr IN (4,5) AND LIB_fscskey = :fscs';

$res = db_query($sql, array(':fscs' => $fscs));

foreach($res as $row) {
	$visit_less = $row->number;
}

echo ("<li>" . $visit_less . " (" . round($visit_less / $total_respondants * 100, 0) . "%) visited the library less than once a month.</li> </ul>");


$header = array('Respondents who have access to a computer', 'FSCS ID');
$rows = array();
$sql = 'SELECT count(*) AS "gen_access_yes", LIB_fscskey AS "FSCS" FROM {Sheet1} WHERE GEN_access = 1 AND LIB_fscskey = :fscs';
$res = db_query($sql, array(':fscs' => $fscs));

	echo ("<table border=0 style='font-size:18px'>");
	echo ("<tr><td>" . $header[0] . "</td>");
	$gen_yes;
foreach($res as $row) {
	echo ("");
	echo ("<td> &nbsp; &nbsp; &nbsp;" . $row->gen_access_yes . "</td>" );
	$gen_yes = $row->gen_access_yes;
}
echo ("</tr></table>");

$header = array('Respondents who don\'t have access to a computer', 'FSCS ID');
$rows = array();
$sql = 'SELECT count(*) AS "gen_access_no", LIB_fscskey AS "FSCS" FROM {Sheet1} WHERE GEN_access = 2 AND LIB_fscskey = :fscs';
$res = db_query($sql, array(':fscs' => $fscs));

echo ("<table border=0 style='font-size:18px'>");
echo ("<tr><td>" . $header[0] . "</td>");
$gen_no;

foreach($res as $row) {
	echo ("");
	echo ("<td> &nbsp; &nbsp; &nbsp;" . $row->gen_access_no . "</td>" );
	$gen_no = $row->gen_access_no;
}
echo ("</tr></table>");
 
$chart = 
	array(
	'#chart_id' => 'access_pc',
	'#title' => t('Access to Computer'),
	'#size' => chart_size(400,150),
	'#type' => CHART_TYPE_PIE,
	);
$tot = $gen_yes + $gen_no;
$chart['#data']['yes'] = $tot/$gen_yes * 10;
$chart['#data']['no'] = $tot/$gen_no * 10;
$chart['#labels'] = array( "Has no access", "Has access" );
echo theme('chart', array('chart'=>$chart));
 
 */
?>   