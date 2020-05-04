<?php

require_once(__DIR__.'/../Output.php');

function randomKey(int $length): string {
  return random_bytes($length);
}

function encrypt(string $original): array {
  $dummy = randomKey(strlen($original));
  $encrypted = '';
  for ($i = 0; $i < strlen($original); $i++) {
    $encrypted .= chr(ord($original[$i]) ^ ord($dummy[$i]));
  }
  return [$dummy, $encrypted];
}

function decrypt(string $key1, string $key2): string {
  $decrypted = '';
  for ($i = 0; $i < strlen($key1); $i++) {
    $decrypted .= chr(ord($key1[$i]) ^ ord($key2[$i]));
  }
  return $decrypted;
}

list($key1, $key2) = encrypt('One Time Pad!');
$result = decrypt($key1, $key2);
Output::out($result);
