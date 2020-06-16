<?php

require_once(__DIR__.'/phone_number_mnemonics_lib.php');
require_once(__DIR__.'/../Autoloader.php');

Util::out("Enter a phone number: ", TRUE);
$phoneNumber = readline();
$possibleMnemonics = possibleMnemonics($phoneNumber);
if (count($possibleMnemonics)) {
  Util::out("Here are the potential mnemonics:");
  foreach ($possibleMnemonics as $mnemonic) {
    Util::out(implode('', $mnemonic));
  }
} else {
  Util::out('Not a valid phone number');
}
