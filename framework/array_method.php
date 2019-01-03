<?php
namespace Framework
{
	class Array_Methods
	{
		private function __construct()
		{
		}
		private function __clone()
		{
		}

		public static function clean($array)
		{
			return array_filter(
				$array,
				function($item) {
					return !empty($item);
				});
		}

		public static function trim($array)
		{
			return array_map(
				function($item) {
					return trim($item);
				}, 
				$array);
		}
	}//end class

	function array_method_test() {
		$a = new Array_Methods();
		$test_array = {1,2,3};

		echo $a->clean($test_array);	
		echo $a->trim($test_array);
	}

}//end namespace

	Framework\array_method_test();
?>
