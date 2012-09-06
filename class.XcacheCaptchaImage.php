<?php

class XCacheCaptchaImage
{
	public $showLine = true;
	public $applyWave = true;
	public $winHeight = 50;
	public $winWidth = 320;

	public $font = "tahomabd.ttf";
	public $font_size = 33;

	public $Characters; // random characters

	private $Colors =  array (	'145',
								'204',
								'177',
								'184',
								'199',
								'255');

////////////////////////////////////////////////////////////////////////////////
	public function __construct($Characters)
	{
		$this -> Characters = $Characters;
		$this -> winWidth = 50*strlen($Characters) + 20;
	}

////////////////////////////////////////////////////////////////////////////////
	public function PrintImage()
	{
		header('Content-Type: image/png');
		////////////////////////////////////
		//background image
		$image = imagecreatetruecolor($this -> winWidth, $this -> winHeight);
		if (!$image)throw new Exception("Cannot Initialize new GD image stream");
		$bg = imagecolorallocate($image, 255, 255, 255);
		imagefill($image, 10, 10, $bg);

		for ($x=0; $x < $this -> winWidth; $x++)
		{
			for ($y=0; $y < $this -> winHeight; $y++)
			{
				$random = mt_rand(0 , count($this->Colors)-1);
				$temp_color = imagecolorallocate($image, $this -> Colors["$random"], $this -> Colors["$random"], $this -> Colors["$random"]);
				imagesetpixel( $image, $x, $y , $temp_color );
			}
		}

		$char_color = imagecolorallocatealpha($image, 0, 0, 0, 90);

		//Font
		$font = dirname(__FILE__).'/'.$this->font;//"tahomabd.ttf";
		$font_size = $this->font_size;//33;
		////////////////////////////////////
		//Image characters

		for ($i=0;$i<strlen($this->Characters);$i++){
			$char = $this -> Characters[$i];
			$random_x = mt_rand(max($i*50,10) , $i*50+20);
			$random_y = mt_rand(35 , 45);
			$random_angle = mt_rand(-20 , 20);
			imagettftext($image, $font_size, $random_angle, $random_x, $random_y, $char_color, $font, $char);
		}


		////////////////////////////////////
		if ($this -> applyWave)
			$image = $this -> apply_wave($image, $this -> winWidth, $this -> winHeight);

		////////////////////////////////////
		//lines
		if ($this -> showLine)
		{
			for ($i=0; $i<$this->winWidth; $i++ )
			{
				if ($i%10 == 0)
				{
					imageline ( $image, $i, 0, $i+10, 50, $char_color );
					imageline ( $image, $i, 0, $i-10, 50, $char_color );
				}
			}
		}

		////////////////////////////////////
		return imagepng($image);
		imagedestroy($image);
	}


////////////////////////////////////////////////////////////////////////////////
	private function apply_wave($image, $width, $height)
	{
		$x_period = 10;
		$y_period = 10;
		$y_amplitude = 5;
		$x_amplitude = 5;

		$xp = $x_period*rand(1,3);
		$k = rand(0,100);
		for ($a = 0; $a<$width; $a++)
			imagecopy($image, $image, $a-1, sin($k+$a/$xp)*$x_amplitude, $a, 0, 1, $height);

		$yp = $y_period*rand(1,2);
		$k = rand(0,100);
		for ($a = 0; $a<$height; $a++)
			imagecopy($image, $image, sin($k+$a/$yp)*$y_amplitude, $a-1, 0, $a, $width, 1);

		return $image;
	}
}


?>
