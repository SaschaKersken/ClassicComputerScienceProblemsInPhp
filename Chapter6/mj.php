<?php

require_once(__DIR__.'/../Autoloader.php');

// Run KMeans over Michael Jackson's solo albums

$albums = [
  new Album("Got to Be There", 1972, 35.45, 10),
  new Album("Ben", 1972, 31.31, 10),
  new Album("Music & Me", 1973, 32.09, 10),
  new Album("Forever, Michael", 1975, 33.36, 10),
  new Album("Off the Wall", 1979, 42.28, 10),
  new Album("Thriller", 1982, 42.19, 9),
  new Album("Bad", 1987, 48.16, 10),
  new Album("Dangerous", 1991, 77.03, 14),
  new Album("HIStory: Past, Present and Future, Book I", 1995, 148.58, 30),
  new Album("Invincible", 2001, 77.05, 16)
];
$kmeans = new KMeans(2, $albums);
$clusters = $kmeans->run();
foreach ($clusters as $index => $cluster) {
  Util::out(
    sprintf(
      "Cluster %d Avg Length %f Avg Tracks %f",
      $index,
      $cluster->centroid->dimensions[0],
      $cluster->centroid->dimensions[1]
    )
  );
  foreach ($cluster->points as $point) {
    Util::out($point);
  }
}
