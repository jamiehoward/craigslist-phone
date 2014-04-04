<?php
function format_phone_number($phoneNumber = null)
{
    if (!is_null($phoneNumber))
    {
        // Replace dashes
        $phoneNumber = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $phoneNumber);
        return $phoneNumber;
    }
    else
    {
        return FALSE;
    }
}

function get_number_equivalent($string = null)
{
	$string = strtolower($string);
	$numbers = array(
		'zero' => 0,
		'one' => 1,
		'two' => 2,
		'three' => 3,
		'four' => 4,
		'five' => 5,
		'six' => 6,
		'seven' => 7,
		'eight' => 8,
		'nine' => 9,
		);

	if (!is_null($string))
	{
		if (array_key_exists($string, $numbers))
		{
			return $numbers[$string];
		}
		else
		{
			return FALSE;
		}
	}
	else
	{
		return FALSE;
	}
}
function decrypt_phone($phoneNumber = null)
{
	if (!is_null($phoneNumber))
	{
		$newNumber = array();
		$charArray = str_split($phoneNumber);
		$numberPlace = 1;
		$numberString = ''; 
		$letters = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

		foreach ($charArray as $char)
		{
			if (is_numeric($char))
			{
				$newNumber[$numberPlace] = $char;
				$numberPlace++;
			}
			else
			{
				if (in_array(strtolower($char), $letters))
				{
					$numberString .= $char;
					$charNumber = get_number_equivalent($numberString);
					if (is_numeric($charNumber))
					{
						$newNumber[$numberPlace] = $charNumber;
						$numberPlace++;
						$numberString = '';
					}
				}
			}
		}
		return implode("", $newNumber);
	}
	else
	{
		return FALSE;
	}
}
if (isset($_POST['phoneNumber']))
{
	$decryptedPhoneNum = format_phone_number(decrypt_phone($_POST['phoneNumber']));
}
?>
<html>
<head>
	<title>Craigslist Phone Number decrpyt</title>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
		.btn {margin-top: 15px;}
		.panel-body {overflow: scroll; font-size: .85em;}
		.panel-content {margin-right: 15px;}
	</style>
</head>
<body>
	<div class="container">
		<div class="row-fluid" id="instructional-text">
			<p>This is a simple form to illustrate how easy it is to decrypt the method many craigslist users post their phone numbers.</p>
			<p>For example: <strong>5five5 4OneThree 8Two36</strong></p>
		<div class="row-fluid">
			<h1 class="header">Decrypt A Craigslist Phone Number</h1> 
			<form action="./index.php" class="form-horizontal" method="POST">
				<div class="control-group">
					<label for="phoneNumber" class="control-label">Phone number text to decrypt</label>
					<input type="text" name="phoneNumber" id="phone-number-field" class="form-control" <?php if (isset($_POST['phoneNumber'])) { echo "value='" . $_POST['phoneNumber'] . "'"; } ?> />
				</div>
				<div class="control-group">
					<input id="cl-phone-submit-button" type="submit" value="Decrypt!" class="btn btn-primary"/>
				</div>
			</form>
		</div>
		<?php if (isset($decryptedPhoneNum)) {?>
		<div class="row-fluid">
			<?php if (!is_array($decryptedPhoneNum)) 
			{ 
				echo "<h2>" . $decryptedPhoneNum . "</h2>"; 
			}
			else 
			{ 
				echo "<pre>"; 
				print_r($decryptedPhoneNum);
				echo "</pre>";
			}
			?>
		</div>
		<?php } ?>
		<footer class="row-fluid">
			<hr />
			<p>
				Thrown together by <a href="http://github.com/blackairplane">Jamie Howard</a>
			 	<a href="https://twitter.com/share" class="twitter-share-button" data-via="JamieHoward">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			</p>
		</footer>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>