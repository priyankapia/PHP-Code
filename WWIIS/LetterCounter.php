<?php

class LetterCounter {
	private $i;
	public function countLettersInString($string){
		// escaping spaces with php function str_replace
		$string = str_replace(' ', '', $string);

        //str_split is php function. converts string characters into array elements
        $string_array = str_split($string); 


		$string_array_count = array();
		//count the number occurence character within a string
		foreach ($string_array as $values) {
			if (!array_key_exists(strtolower($values), $string_array_count)) {
				$string_array_count[strtolower($values)] = 0;
			}
			$string_array_count[strtolower($values)] += 1;
		}
		$output_data_string = '';
		foreach($string_array_count as $key => $string_array_value){
			$output_data_string .= $key.':';
			//adding star to output string based on number of occurance of string
			for($this->i= 0; $this->i < $string_array_value; $this->i++){
				$output_data_string .= '*';
			}
			$output_data_string .= ';';
		}
        echo $output_data_string .'<br>';
	}
}

$letterCounter1 = new LetterCounter();
$letterCounter1->countLettersInString('Hello World');

$letterCounter1 = new LetterCounter();
$letterCounter1->countLettersInString('WWIIS Services Ltd');