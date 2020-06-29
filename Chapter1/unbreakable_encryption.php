<?php

require_once(__DIR__.'/../Autoloader.php');

function randomKey(int $length): string {
  // Generate $length random bytes and return them
  return random_bytes($length);
}

function encrypt(string $original): array {
  $dummy = randomKey(strlen($original));
  $encrypted = '';
  for ($i = 0; $i < strlen($original); $i++) {
    $encrypted .= chr(ord($original[$i]) ^ ord($dummy[$i])); // XOR
  }
  return [$dummy, $encrypted];
}

function decrypt(string $key1, string $key2): string {
  $decrypted = '';
  for ($i = 0; $i < strlen($key1); $i++) {
    $decrypted .= chr(ord($key1[$i]) ^ ord($key2[$i])); // XOR
  }
  return $decrypted;
}

list($key1, $key2) = encrypt('One Time Pad!');
$result = decrypt($key1, $key2);
Util::out($result);
