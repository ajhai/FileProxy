    <?php
require('php-captcha.inc.php');
// define fonts
$aFonts = array('fonts/VeraBd.ttf', 'fonts/VeraIt.ttf', 'fonts/Vera.ttf');
// create new image
$oPhpCaptcha = new PhpCaptcha($aFonts, 200, 60);
$oPhpCaptcha->DisplayShadow(true);
$oPhpCaptcha->SetOwnerText('Source: www.ejeliot.com');
$oPhpCaptcha->Create();
		?>