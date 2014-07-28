<?php
$suspect=false;
$missing=array();
$errors=array();
$pattern='/Content-Type:|Bcc:|Cc:/i' ;
isSuspect($_POST, $pattern, $suspect);
$required=array( "name", "email", "message");
$to="" ;
$subject="feedback" ;
$headers="" ;
function isSuspect($val, $pattern, &$suspect) {
	if (is_array($val)) {
		foreach ($val as $item) {
			isSuspect($item, $pattern, $suspect);
		}
	}
	else {
		if (preg_match($pattern, $val)) {
			$suspect=true;
		}
	}
}
if (!$suspect) {
	foreach ($_POST as $key=>$value) {
		$temp = is_array($value) ? $value : trim($value);
		if (empty($temp) && in_array($key, $required)) {
			$missing[] = $key;
		}
		${$key} = $temp;
	}
}
$mailSent = false;
if (!$suspect && !$missing) {
	$msg = '';
	foreach($required as $item) {
		if (isset(${$item}) && !empty(${$item})) {
			$val = ${$item};
		}
		else {
			$val = 'Not selected';
		}
		if (is_array($val)) {
			$val = implode(', ', $val);
		}
		$item = str_replace(array('_', '-'), ' ', $item);
		$msg .= ucfirst($item).": $val\r\n\r\n";
	}
	$msg = wordwrap($msg, 70);
	$mailSent = mail($to, $subject, $msg, $headers);
	if (!$mailSent) {
		$errors['mailfail'] = true;
	}
}
?>

	<form class="pure-form pure-form-stacked" id="feedback" method="post" action="">
		<legend> We accept any suggestions,comments and queries that you may have.</legend>
		<fieldset>

			<input type="text" class="pure-input-1" name="name" placeholder="Name" required <?php if ($missing) { echo 'value="' . htmlentities($name, ENT_COMPAT, 'UTF-8') . '"'; } ?>/>
			<?php if($missing&&in_array( 'name',$missing)){ ?>
			<span class="error">Enter the name</span>
			<?php } ?>

			<input type="text" class="pure-input-1" name="email" placeholder="Email" required <?php if ($missing) { echo 'value="' . htmlentities($name, ENT_COMPAT, 'UTF-8') . '"'; } ?>/>
			<?php if($missing&&in_array( 'email',$missing)){ ?>
			<span class="error">Enter the mail id</span>
			<?php } ?>

			<textarea name="message" placeholder="Message" cols="40" rows="6" class="pure-input-1" required <?php if ($missing) { echo 'value="' . htmlentities($name, ENT_COMPAT, 'UTF-8') . '"'; } ?>></textarea>
			<?php if($missing&&in_array( 'message',$missing)){ ?>
			<span class="error">Enter the message</span>
			<?php } ?>

			<input type="submit" class="pure-button pure-button-primary button-success button-xlarge" name="submit" value="Send message" style="width:200px;height:50px;padding: 0; font-size:18px;"/>
		</fieldset>
		<?php if ($_POST && $suspect && !$missing) { ?>
		<p class="warning">Sorry, your mail could not be sent. Please try later.</p>
		<?php } elseif ($missing) { ?>
		<p class="warning">Please fix the item(s) indicated.</p>
		<?php } elseif($_POST && $errors && !$missing) { ?>
		<p class="warning">Sorry, your mail could not be sent. Please try later.</p>
		<?php } ?>
	</form>
