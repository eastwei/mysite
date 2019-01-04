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

		public function __call($name, $arguments)
		{
			if(empty($this->_inspector))
			{
			   throw new Exception("Call parent::__construct!");
			}

			$getMatches = StringMethods::match($name, "^get([a-zA-Z0-9]+$");

			if(sizeof($getMatches) > 0)
			{
				$normalized = lcfirst($getMatches[0]);
				$property = "_{$normalized}";
				if(property_exists($this, $property))
				{
					$meta = $this->_inspector->getPropertyMeta($property);
					if (empty ($meta["@readwrite"]) && empty($meta["@read"]))
					{
						throw $this->_getExceptionForWriteonly($normalized);
					}
					if(isset($this->$property))
					{
						return $this->$property;
					}
					return null;
				}
			}

			$setMatches = StringMethods::match($name, "^set([a-zA-Z0-9]+)$");
			if(sizeof($setmatches) > 0)
			{
				$normalzed = lcfirst($setMatches[0]);
				$property = "_{$normalized}";
				if(property_exists($this, $property))
				{
					$meta = $this->_inspector->getPropertyMeta($property);
					if(empty($meta["@readwrite"]) && empty($meta["@write"]))
					{
						throws $this->_getExceptionForReadonly($normalizd);
					}
					$this->$property = $arguments[0];
					return $his;

				}

			}

			throw $this->_getExceptionForImplementation($name);
		}
		public function __get($name)
		{
			$function = "get".ucfirst($name);
			return $this->$function();
		}

		public function __set($name, $value)
		{
			$function = "set".ucfirst($name);
			return $this->$function($value);
		}

		protected function _getExceptionForWriteonly($property)
		{
			return new Exception\WriteOnly("{$property} is write-only");
		}

		protected function _getExceptionForProperty()
		{
			return new Exception\Property("Invalid property");
		}

		protected function _getExceptionForImplementation($method)
		{
			return new Exception\Argument("{$method} method not implemented");
		}

	}//end class
}//end namespace

//----------------------------test---------------------------

class Hello extends Framework\Base
{
	/*
	 *@readwrite
	 */
	protected $_world;
	public function setWorld($value)
	{
		echo "your setter is being called! ";
		$this->_world = $value;
	}

	public function getWorld()
	{
		echo "your getter is being called!";
		return $this->_world;
	}
}

$hello = new Hello();
$hello->world = "foo!";

echo $hello->world;

 ?>
