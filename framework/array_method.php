<?php
namespace Framework
{
	class Array_Methods
	{
		public function __construct()
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
		public static function toObject($array)
		{
			$result = new \stdClass();
			foreach($array as $key => $value)
			{
				if(is_array($value))
				{
					$reslut->{$key} = self::toObject($value);
				}
				else
				{
					$result->{$key} = $value;
				}
			}
			return $reslut;
		}
	}//end class


}//end namespace

namespace{
//---------------------------------------test----------------------------
	function array_method_test() {
		$a = new Framework\Array_Methods();
		$test_array = array(1,2,NULL,3,NULL);
		echo "original array:";
		foreach ($test_array as $num)
		{
				echo "$num ";
		}
		$r_1 = $a->clean($test_array);	
		echo "clean array:";
		foreach ( $r_1 as $num )
		{
				echo "$num ";
		}

		$r_2 = $a->trim($test_array);
		echo "trim array:";
		foreach ($r_2 as $num)
		{
				echo "$num ";
		}
		echo "\n";
	}

	array_method_test();
}
?>
