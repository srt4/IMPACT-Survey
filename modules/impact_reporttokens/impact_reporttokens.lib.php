<?php

// generate some temp tables to speed up the queries
global $temp_table;
$temp_table = db_query_temporary("SELECT * FROM {survey_responses} WHERE LIBid = 'MD0016'");
//, array(":fscs" => $fscs));

// SurveyResponse class - useful for generating tokens
class SurveyResponse {
        public $title;
        public $count;
        public $percent;
        public $countPercent;
        public function __construct($title, $count=-1, $total=-1) {
                $this->title = $title;
                $this->count = $count;
                if ( $count != 0 && $total != 0) $this->percent = round( $count / $total  * 100 );
                else $this->percent = 0;
                $this->countPercent = number_format($this->count) . " (" . $this->percent . "%)";
        }
}



/* get_survey_variable: returns a SQL table with the count of survey responses for each question, on a
 * variable-by-variable basis.
 *
 * @variable: the name of the variable to query (for example, GEN_visit)
 * @response_values: an associative array of response number (e.g., 2, 777) to its column title (e.g., "weekly" or "skip")
 *
 * @returns the response_values array in a modified form (a mapping of variable :  SurveyResponse)
 *
 * Example usage:
 *
 * $gen_visit = get_survey_variable(
 * "GEN_visit",
 * array(
 *              "1,2" => "weekly",
 *              "3" => "monthly",
 *              "4,5" => "less than once a month",
 *              "1,2,3,4,5" => "all respondents",
 *              "6" => "no visits"
 *        )
 * );
 *
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
        global $temp_table; // more db stuffs
        // Harvest all the data, put it into associative arrays
        $data_array = array();
        // TODO: should there be a better way to deal with total?
        // Idea: maybe accept a "total" index in the array or something
        $sql = 'SELECT count(*) AS tot FROM {' . $temp_table . '} WHERE ' . $variable . ' >= 0';
        $res= db_query($sql)->fetchObject();
        $total = $res->tot;

        foreach($response_values as $response_val => &$name) {
                $sql = 'SELECT count(*) AS tot FROM {' . $temp_table . '} WHERE ' . $variable . ' IN ( ' . $response_val . ' )';
                $res = db_query($sql)->fetchObject();
                $survey_response = new SurveyResponse($name, $res->tot, $total);
                $name = $survey_response;
        }

        $response_values["total"] = $total;
        $response_values["variable"] = $variable;
        return $response_values;
}

/* This method returns a number when called with a variable and response.
 For example, one can use this to do something such as, echo ( get_single_variable("GEN_visit", "1") . " people visited the library every day."); */
function get_single_variable($variable, $response) {
	$temp = get_survey_variable( $variable, array((string)$response => "foo") );
	return $temp[(string)$response]->count;
}
?>
