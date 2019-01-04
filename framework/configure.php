<?php
namespace Framework
{
	use Framework\Base as Base;
	use Framework\Configuration as Configuration;
	use Framework\Configuration\Exception as Exeption;

	class Configuration extends Base
	{
		/**
		 * @readwrite
		 */
		protected $_type;
		/**
		 * @readwrite
		 */
		protected $_options;
		protected function _getExceptionForImplementation($method)
		{
			return new EXception\Implementation("{$method} method not implemented");
		}

		public function initialize()
		{
			if(!$this->type)
			{
				throw new Exception\Argument("Invalid type");
			}
			switch($this->type)
			{
			case "ini":
				return new Configuration\Driver\Ini($this->options);

			default:
				throw new Exception\Argument("Invalid type");
			}
		}
	}//end class
}//end framework
?>
