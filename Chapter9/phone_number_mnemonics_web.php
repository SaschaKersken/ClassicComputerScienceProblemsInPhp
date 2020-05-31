<?php

require_once(__DIR__.'/phone_number_mnemonics_lib.php');

?>
<!DOCTYPE html>
<html>
<head>
<title>Phone Number Mnemonics</title>
</head>
<body>
<h1>Phone Number Mnemonics</h1>
<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="get">
<p>Enter a valid phone number:
<input type="text" name="phone_number" />
<br />
<input type="submit" value="Generate mnemonics" />
</form>
<?php

if (isset($_GET['phone_number'])) {
  $phoneNumber = $_GET['phone_number'];
  $possibleMnemonics = possibleMnemonics($phoneNumber);
  if (count($possibleMnemonics)) {
    echo "<h2>Here are the potential mnemonics</h2>";
    echo "<ul>";
    foreach ($possibleMnemonics as $mnemonic) {
      echo "<li>".implode('', $mnemonic)."</li>";
    }
  } else {
    echo "Not a valid phone number";
  }
}

?>
</body>
</html>
