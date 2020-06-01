<?php

require_once(__DIR__.'/Graph.php');
require_once(__DIR__.'/../Chapter2/generic_search.php');
require_once(__DIR__.'/../Util.php');

$cityGraph = new Graph(["Seattle", "San Francisco", "Los Angeles", "Riverside", "Phoenix", "Chicago", "Boston", "New York", "Atlanta", "Miami", "Dallas", "Houston", "Detroit", "Philadelphia", "Washington"]);
$cityGraph->addEdgeByVertices("Seattle", "Chicago");
$cityGraph->addEdgeByVertices("Seattle", "San Francisco");
$cityGraph->addEdgeByVertices("San Francisco", "Riverside");
$cityGraph->addEdgeByVertices("San Francisco", "Los Angeles");
$cityGraph->addEdgeByVertices("Los Angeles", "Riverside");
$cityGraph->addEdgeByVertices("Los Angeles", "Phoenix");
$cityGraph->addEdgeByVertices("Riverside", "Phoenix");
$cityGraph->addEdgeByVertices("Riverside", "Chicago");
$cityGraph->addEdgeByVertices("Phoenix", "Dallas");
$cityGraph->addEdgeByVertices("Phoenix", "Houston");
$cityGraph->addEdgeByVertices("Dallas", "Chicago");
$cityGraph->addEdgeByVertices("Dallas", "Atlanta");
$cityGraph->addEdgeByVertices("Dallas", "Houston");
$cityGraph->addEdgeByVertices("Houston", "Atlanta");
$cityGraph->addEdgeByVertices("Houston", "Miami");
$cityGraph->addEdgeByVertices("Atlanta", "Chicago");
$cityGraph->addEdgeByVertices("Atlanta", "Washington");
$cityGraph->addEdgeByVertices("Atlanta", "Miami");
$cityGraph->addEdgeByVertices("Miami", "Washington");
$cityGraph->addEdgeByVertices("Chicago", "Detroit");
$cityGraph->addEdgeByVertices("Detroit", "Boston");
$cityGraph->addEdgeByVertices("Detroit", "Washington");
$cityGraph->addEdgeByVertices("Detroit", "New York");
$cityGraph->addEdgeByVertices("Boston", "New York");
$cityGraph->addEdgeByVertices("New York", "Philadelphia");
$cityGraph->addEdgeByVertices("Philadelphia", "Washington");
Util::out($cityGraph);
$bfsResult = bfs(
  'Boston',
  function($x) {
    return $x == 'Miami';
  },
  [$cityGraph, 'neighborsForVertex']
);
if (is_null($bfsResult)) {
  Util::out('No solution found using breadth-first search!');
} else {
  $path = nodeToPath($bfsResult);
  Util::out('Path from Boston to Miami:');
  Util::out($path);
}
