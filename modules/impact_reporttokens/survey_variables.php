<?php
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
// Time this stuff
$time_start = microtime_float();

// All of the survey variables are contained within this file.
global $survey_variables;
$survey_variables = array();
require('impact_reporttokens.lib.php');
$survey_variables[] = get_survey_variable(
"GEN_visit",
array(
	"1,2" => "weekly",
	"3" => "13_month",
	"4,5" => "less_than_month"
	)
);

$survey_variables[] = get_survey_variable(
"GEN_comp",
array(
	"1,2" => "weekly",
	"3" => "13_month",
	"4,5" => "less_than_month"
	)
);

$survey_variables[] = get_survey_variable(
"GEN_remote",
array(
	"1,2" => "weekly",
	"3" => "13_month",
	"4,5" => "less_than_month"
	)
);

$survey_variables[] = get_survey_variable(
"GEN_internet",
array(
	"1,2" => "weekly",
	"3" => "13_month",
	"4,5" => "less_than_month"
	)
);

$survey_variables[] = get_survey_variable(
"GEN_wireless",
array(
	"1,2" => "weekly",
	"3" => "13_month",
	"4,5" => "less_than_month"
	)
);

/*
$survey_variables[] = get_survey_variable(
"USE_tool",
array(
	"1" => "print",
	"3" => "search",
	"6" => "blog",
	"7" => "wiki",
	"8" => "social",
	"9" => "video",
	"10" => "audio",
	"2" => "email",
	"4" => "chat",
	"5" => "phone"
	)
);

$survey_variables[] = get_survey_variable(
"USE_help",
array(
	"1" => "print",
	"2" => "database",
	"3" => "instruction",
	"4" => "search",
	"5" => "form",
	"6" => "documents"
	)
);
*/
$use_tool = array ( "USE_tools01", "USE_tools03", "USE_tools06", "USE_tools07", "USE_tools08", "USE_tools09", 
                      "USE_tools10", "USE_tools02", "USE_tools04", "USE_tools05" );
binary_array($use_tool);

$use_help = array ( "USE_help1", "USE_help2", "USE_help3", "USE_help4", "USE_help5", "USE_help6");
binary_array($use_help);

function binary_array($in) {
     global $survey_variables;
	foreach ($in as $var) {
		$survey_variables[] = binary_response($var);
	}
	//return $array;
}
function binary_response($variable) {
	return get_survey_variable($variable, array ("0"=>"no", "1"=>"yes") );
}

$gov_vars = array ( "GOV_legal", "GOV_form", "GOV_form_submit", "GOV_law", "GOV_permit", "GOV_permit_apply", "GOV_legal",
                   "GOV_program", "GOV_program_apply");
binary_array ($gov_vars);

$edu_vars = array ("EDU_program", "EDU_apply", "EDU_apply_admit", "EDU_class", "EDU_research", "EDU_crswork", "EDU_testprep",
		   "EDU_test", "EDU_test_pro", "EDU_finaid", "EDU_finaid_get");
binary_array($edu_vars);

$hea_vars = array ("HEA_illness", "HEA_medpro", "HEA_supgrp", "HEA_prescr", "HEA_diet", "HEA_diet_change", "HEA_exercs",
		   "HEA_exercs_change", "HEA_doctor", "HEA_hlthins", "HEA_records");
binary_array($hea_vars);

$emp_vars = array ("EMP_oppr", "EMP_oppr_jobapp", "EMP_oppr_intrvw", "EMP_oppr_hired", "EMP_resume", "EMP_train", "EMP_research",
		   "EMP_work");
binary_array($emp_vars);

$bus_vars = array ("BUS_start", "BUS_manage", "BUS_busplan", "BUS_research", "BUS_license", "BUS_cust", "BUS_cust_incrs", 
		   "BUS_contract", "BUS_contract_recvd");
binary_array($bus_vars);

$com_vars = array ("COM_housing", "COM_bank", "COM_paybills", "COM_invest", "COM_compare", "COM_purchase", "COM_sell", "COM_travel",
		   "COM_credit", "COM_debt");
binary_array($com_vars);
  
$better_array = array();
// Probably an expensive operation, so maybe clean this up later?
foreach($survey_variables as $variable) {
  foreach($variable as $option) {
    if (is_object($option)){ // if option is a surveyresponse
      $better_array[$variable['variable'] . "_" . $option->title] = $option->count;
    }
  }
}
/*
foreach ($survey_variables as $variable) {
  ?>
  <h1><?=$variable['variable']?></h1>
  <?php
  foreach ($variable as $option) {
    if (is_object($option)) { // if it's a SurveyResponse 
      ?>
      <h3><?=$option->title?> - <?=$option->count?>
      <?php
    }
  }
}
*/

$time_end = microtime_float();
$time = $time_end - $time_start;

echo "<!--Variables took $time seconds to calculate-->";

echo "<!--";
print_r($better_array);
echo "-->";
?>
