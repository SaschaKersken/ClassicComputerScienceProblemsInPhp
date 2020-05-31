<?php

require_once(__DIR__.'/CompressedGene.php');
require_once(__DIR__.'/../Output.php');

$original = str_repeat('TAGGGATTAACCGTTATATATATATAGCCATGGATCGATTATATAGGGATTAACCGTTATATATATATAGCCATGGATCGATTATA', 100);
Output::out(sprintf("Original: %d", strlen($original)));
$compressed = new CompressedGene($original);
Output::out(sprintf("Compressed: %d", strlen($compressed->getBitString())));
if ($original == $compressed->decompress()) {
  echo "Identical\n";
} else {
  echo "Different!\n";
}
