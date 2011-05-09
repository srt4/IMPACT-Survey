<?php
    global $better_array;
    require_once('survey_variables.php');

// There far too many tokens to put into just the .module file; this file actually generates the content of the tokens

/*
SurveyResponse() {
	$name = "name";
	$value = "value";
}

$arraytest [] = new SurveyResponse():

_tokens () {
	$replacements = array();
	if($type == 'survey') {
		foreach ($arraytest as $response) {
			$replacements[$name] = $value;
		}
	}
}
_token_info {
	global $survey_responses; // from the included file
	
	// goes inside foreach($tokens as $name => $original) 
	foreach ($survey_responses as $survey_var) {
		foreach($survey_var as $survey_response) {
			// foreach survey response object, make a token for it
			if ($name == $survey_var['variable'] . "_" . $survey_response->title) {
				// put the count into the token
				$replacements[$original] = $survey_response->count;
			}
		}
	}
	$types = array ( 'ga_tokenizer' => '');
	$ga_tokenizer = $testarray;
}
*/

/**
 * Implements hook_tokens().
 */
function impact_reporttokens_tokens($type, $tokens, array $data = array(), array $options = array()){
  $replacements = array();
  $sanitize = !empty($options['sanitize']);
  if ($type == 'ga_tokenizer') {
    foreach ($tokens as $name => $original) {
      switch ($name) {
	case 'ga-source':
          $replacements[$original] = "blassfsdjkfsdhjkhfsic";
	  break;
	}
   }
  }
  if ($type = 'survey') {
    global $better_array;
    foreach($tokens as $name => $original) {
      if (isset($better_array[$name])) {
        $replacements[$original] = $better_array[$name];
      }
    }
  }
  return $replacements;
}

/**
 * Implements hook_token_info().
 */
function impact_reporttokens_token_info() {
  $types = array(
    'ga_tokenizer' => array(
      'name' =>  t('Test Token.'),
      'description' => t('Tokens related with Google Analytics that are not provided by google_analytics module.'),
    ),
    'survey' => array(
      'name' => t('Survey Response'),
      'description' => t('Survey response variables'),
    ),
  );
  $ga_tokenizer['ga-source'] = array(
    'name' => t('Source'),
    'description' => t('Search engine, newsletter name, or other source.'),
  );
  
  $survey = array();
  global $better_array;

  foreach($better_array as $var=>$count) {
    $survey[$var] = array (
      'name' => $var,
      'description' => t('Variable count')
    );
  }

  return array(
    'types' => $types,
    'tokens' => array(
      'ga_tokenizer' => $ga_tokenizer,
      'survey' => $survey
    ),
  );
}

?>
