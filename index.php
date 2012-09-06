<?php
include dirname(__FILE__).'/include.php';

if (@$_GET['challenge']){
	//Image
	$ch = XcacheCaptcha::get($_GET['challenge']);
	if (!$ch){
		$ch = new XCacheCaptchaImage('????');
		$ch->PrintImage();
	}
	else{
		$ch->printImage();
	}
}
elseif (@$_POST['answer']){
	// GUESS
	$ch = XcacheCaptcha::get($_POST['challenge']);
	if ($ch){
		$guessed = $ch->test($_POST['answer']);
		$ch = XcacheCaptcha::create();
	}
	else{
		$ch = XcacheCaptcha::create();
	}
}
else{
	$ch = XcacheCaptcha::create();
}
?>


<form method="POST">
	What does it say in the image?
	<img src="?challenge=<?php echo $ch?>"/>
	<input type="hidden" name="challenge" value="<?php echo $ch ?>"/>
	<input type="text" name="answer" /> <?php if (isset($guessed)) echo $guessed ? 'You guessed right :) Congrats!' : 'You guessed wrong :( Try again!'?>
	<button type="submit">Guess</button>
</form>