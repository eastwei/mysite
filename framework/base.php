<?php
namespace Framework
{
	use Framework\Inspector as Inspector;
	use Framework\Array_Methods as Array_Methods;
	use Framework\String_Methods as String_Methods;
	class Base
	{
		private $_inspector;
		public function __construct($options = array())
		{
			$this->_inspector = new Inspector($this);
			if(is_array($options) || is_object($options))
			{
				foreach($options as $key => $value)
				{
					$key = ucfirst($key);
					$method = "set{$key}";
					$this->$method($value);
				}
			}
		}
	}//end class
}//end namespace
 ?>
