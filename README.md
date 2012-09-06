XcacheCaptcha - php captcha checker with xcache backend
=======================================================

This php class will enable you to include [CAPTCHA](http://en.wikipedia.org/wiki/CAPTCHA) bot checks in your forms. The integration is just a few lines of code

## Integrate the captcha image in your code
```php
$captcha = XCacheCaptcha::create();
echo '<input type="hidden" name="challenge" value="'.$captcha.'"/>';
echo '<img src="?image='.$captcha.'"/>';
echo 'Verification code: <input type="text" name="response"/>';
```

## Render the image
```php
if ($_GET['image']){
	$captcha = XCacheCaptcha::get($_GET['image']);
	if ($captcha){
		$captcha->printImage();
	}
	else{
		//The challenge is not valid or has expired
		$image = new XcacheCaptchaImage('????');
		$image->PrintImage();
	}
}
```

## Test for the user response
```php
if ($_POST['response'] && $_POST['challenge']){
	$captcha = XcacheCaptcha::get($_POST['challenge']);
	if (!$captcha) die('The captcha has expired!');
	else if ($captcha->test($_POST['response'])){
		echo "The user answered correctly"
	}
	else{
		echo "The user was wrong! The current captcha object was auto expired and cannot be tested again!";
	}
}
```

_An example can be found in [index.php][link]_
[link]:https://github.com/sash/XcacheCaptcha/blob/master/index.php
