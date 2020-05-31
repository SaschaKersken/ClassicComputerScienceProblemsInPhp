<?php

require_once(__DIR__.'/phone_number_mnemonics_lib.php');
require_once(__DIR__.'/../Output.php');

Output::out("Enter a phone number: ", TRUE);
$phoneNumber = readline();
$possibleMnemonics = possibleMnemonics($phoneNumber);
if (count($possibleMnemonics)) {
  Output::out("Here are the potential mnemonics:");
  foreach ($possibleMnemonics as $mnemonic) {
    Output::out(implode('', $mnemonic));
  }
} else {
  Output::out('Not a valid phone number');
}
