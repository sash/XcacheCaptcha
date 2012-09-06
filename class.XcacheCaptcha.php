<?php

class XcacheCaptcha{
	private $human;
	private $challenge;
	private function __construct($challenge, $human) {
		$this->challenge = $challenge;
		$this->human = $human;
	}
	function printImage(){
		$image = new XCacheCaptchaImage($this->human);
		$image->PrintImage();
	}
	/**
	 *
	 * @return XcacheCaptcha
	 */
	static function create(){
		$res = new self(md5(uniqid(mt_rand(0, 1000000), true)), self::randomSymbols(4));
		// Store in xCache
		$xcache = XCache::getInstance();
		$xcache->ttl = 10*60; // 10 minutes
		$xcache->{'XcacheCaptcha_'.$res->challenge} = $res->human;
		// Perform cleanup
		// Next release
		return $res;
	}
	/**
	 *
	 * @param type $ident
	 * @return boolean|XcacheCaptcha
	 */
	static function get($challenge){
		// Look in xcache
		$xcache = XCache::getInstance();
		$human = $xcache->{'XcacheCaptcha_'.$challenge};
		if (!$human)return false;
		else return new self($challenge,$human);
	}
	function test($user_input){
		$correct = $this->human == $user_input;

		// Remove from Xcache
		$xcache = XCache::getInstance();
		unset($xcache->{'XcacheCaptcha_'.$this->challenge});

		return $correct;
	}
	function getChallenge(){
		return $this->challenge;
	}
	public function __toString() {
		return $this->getChallenge();
	}
	private static function randomSymbols($length){
		$res = '';
		for($i=0;$i<$length;$i++){
			do{
				$char = base_convert(mt_rand(1, 35), 10, 36);
			}while($char == '0' || $char == 'O' || $char == 'o' || $char == 'l' );
			$res .= $char;
		}
		return $res;
	}
}
?>
