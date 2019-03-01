<?php
// Get average review rating
if ( !function_exists( 'logistic_company_reviews_get_average_rating' ) ) {
	function logistic_company_reviews_get_average_rating($marks) {
		$r = explode(',', $marks);
		$rez = 0;
		$cnt = 0;
		if (is_array($r) && count($r) > 0) {
			foreach ($r as $v) {
				if (is_numeric($v)) {
					$rez += $v;
					$cnt++;
				}
			}
		}
		return $cnt > 0 ? round($rez / $cnt, 1) : 0;
	}
}

?>