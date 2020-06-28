<?php

require_once(__DIR__.'/../Autoloader.php');

$cityGraph2 = new WeightedGraph(["Seattle", "San Francisco", "Los Angeles", "Riverside", "Phoenix", "Chicago", "Boston", "New York", "Atlanta", "Miami", "Dallas", "Houston", "Detroit", "Philadelphia", "Washington"]);
$cityGraph2->addWeightedEdgeByVertices("Seattle", "Chicago", 1737);
$cityGraph2->addWeightedEdgeByVertices("Seattle", "San Francisco", 678);
$cityGraph2->addWeightedEdgeByVertices("San Francisco", "Riverside", 386);
$cityGraph2->addWeightedEdgeByVertices("San Francisco", "Los Angeles", 348);
$cityGraph2->addWeightedEdgeByVertices("Los Angeles", "Riverside", 50);
$cityGraph2->addWeightedEdgeByVertices("Los Angeles", "Phoenix", 357);
$cityGraph2->addWeightedEdgeByVertices("Riverside", "Phoenix", 307);
$cityGraph2->addWeightedEdgeByVertices("Riverside", "Chicago", 1704);
$cityGraph2->addWeightedEdgeByVertices("Phoenix", "Dallas", 887);
$cityGraph2->addWeightedEdgeByVertices("Phoenix", "Houston", 1015);
$cityGraph2->addWeightedEdgeByVertices("Dallas", "Chicago", 805);
$cityGraph2->addWeightedEdgeByVertices("Dallas", "Atlanta", 721);
$cityGraph2->addWeightedEdgeByVertices("Dallas", "Houston", 225);
$cityGraph2->addWeightedEdgeByVertices("Houston", "Atlanta", 702);
$cityGraph2->addWeightedEdgeByVertices("Houston", "Miami", 968);
$cityGraph2->addWeightedEdgeByVertices("Atlanta", "Chicago", 588);
$cityGraph2->addWeightedEdgeByVertices("Atlanta", "Washington", 543);
$cityGraph2->addWeightedEdgeByVertices("Atlanta", "Miami", 604);
$cityGraph2->addWeightedEdgeByVertices("Miami", "Washington", 923);
$cityGraph2->addWeightedEdgeByVertices("Chicago", "Detroit", 238);
$cityGraph2->addWeightedEdgeByVertices("Detroit", "Boston", 613);
$cityGraph2->addWeightedEdgeByVertices("Detroit", "Washington", 396);
$cityGraph2->addWeightedEdgeByVertices("Detroit", "New York", 482);
$cityGraph2->addWeightedEdgeByVertices("Boston", "New York", 190);
$cityGraph2->addWeightedEdgeByVertices("New York", "Philadelphia", 81);
$cityGraph2->addWeightedEdgeByVertices("Philadelphia", "Washington", 123);
Util::out($cityGraph2);

