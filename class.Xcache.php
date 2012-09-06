<?php

/*/**
 * XCache
 *
 * @package XCache
 * @version $Id$
 * @copyright 2007
 * @author Cristian Rodriguez <judas.iscariote@flyspray.org>
 * @license BSD {@link http://www.opensource.org/licenses/bsd-license.php}
 */

class XCache {
	public $ttl;
    private static $xcobj;

    private function __construct()
    {
    }

    public final function __clone()
    {
        throw new BadMethodCallException("Clone is not allowed");
    }

    /**
     * getInstance
     *
     * @static
     * @access public
     * @return object XCache instance
     */
    public static function getInstance()
    {
        if (!(self::$xcobj instanceof XCache)) {
            self::$xcobj = new XCache;
        }
        return self::$xcobj;
    }

    /**
     * __set
     *
     * @param mixed $name
     * @param mixed $value
     * @access public
     * @return void
     */
    public function __set($name, $value)
    {
			if ($this->ttl){
			  xcache_set($name, $value, $this->ttl);
				$this->ttl = null;
			}
			else{
			  xcache_set($name, $value);
			}
      
    }

    /**
     * __get
     *
     * @param mixed $name
     * @access public
     * @return void
     */
    public function __get($name)
    {
        return xcache_get($name);
    }

    /**
     * __isset
     *
     * @param mixed $name
     * @access public
     * @return bool
     */
    public function __isset($name)
    {
        return xcache_isset($name);
    }

    /**
     * __unset
     *
     * @param mixed $name
     * @access public
     * @return void
     */
    public function __unset($name)
    {
        xcache_unset($name);
    }
		public function inc($name, $value=1){
			if ($this->ttl){
			  xcache_inc($name, $value, $this->ttl);
				$this->ttl = null;
			}
			else{
			  xcache_inc($name, $value);
			}
		}
		public function dec($name, $value=1){
			if ($this->ttl){
			  xcache_dec($name, $value, $this->ttl);
				$this->ttl = null;
			}
			else{
			  xcache_dec($name, $value);
			}
		}
}
?>
