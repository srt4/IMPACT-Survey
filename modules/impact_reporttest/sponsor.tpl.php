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
	<h2>Node ID: <?php print $sponsor_id; ?></h2>
	<h2>Node information: <?php print ucwords(strtolower($sponsor)); ?></h2>
</div>


<h2>FSCS: <?php $fscs = "NY0562"; ?><?php print $fscs; ?></h2>

<?php
/*$chart = array(
  '#chart_id' => 'New_Chart',
  '#title' => t('Servings'),
  '#type' => CHART_TYPE_SCATTER,
  '#fscs' => token_replace("[current-user:profile-library-registration:field-library-reg-system]")
);

$chart['#data']['fruits'] = 3;
$chart['#data']['meats']  = 2;
$chart['#data']['dairy']  = 5;

//echo theme('chart', array('chart' => $chart)); 
*/

// SELECT (SELECT count(*) FROM dr_Sheet1 WHERE GEN_visitfr IN (1,2)  AND LIB_fscskey = 'OK0093') as "no_visit" 

$sql = 'select (SELECT count(*) AS "no" FROM {Sheet1} WHERE GEN_visit = 2 AND LIB_fscskey = :fscs) as no, (SELECT count(*) AS "no" FROM {Sheet1} WHERE GEN_visitfr IN (1, 2) AND LIB_fscskey = :fscs) as yes';

$res = db_query($sql, array(':fscs' => $fscs));

foreach($res as $row) {
	$respond_visit_past_12 = $row->no;
	$respond_visit_yes = $row->yes;
}
$sql = 'select count(*) as total from {Sheet1} where GEN_visitfr in (1,2,3,4,5) and LIB_fscskey = :fscs';

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
?>   