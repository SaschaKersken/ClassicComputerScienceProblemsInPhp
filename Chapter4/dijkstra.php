<?php

require_once(__DIR__.'/WeightedGraph.php');

require_once(__DIR__.'/../Chapter2/generic_search.php');

class DijkstraNode {
  public $distance;

  public $vertex;

  public function __construct(int $vertex, float $distance) {
    $this->vertex = $vertex;
    $this->distance = $distance;
  }
}

function dijkstra(WeightedGraph $wg, $root): array {
  $first = $wg->indexOf($root);
  $distances = array_fill(0, $wg->vertexCount, NULL);
  $distances[$first] = 0;
  $paths = [];
  $pq = new PriorityQueue();
  $pq->push(new DijkstraNode($first, 0));

  while (!$pq->empty) {
    $u = $pq->pop()->vertex;
    $distU = $distances[$u];
    foreach ($wg->edgesForIndex($u) as $we) {
      $distV = $distances[$we->v];
      if (is_null($distV) || $distV > $we->weight + $distU) {
        $distances[$we->v] = $we->weight + $distU;
        $paths[$we->v] = $we;
        $pq->push(new DijkstraNode($we->v, $we->weight + $distU));
      }
    }
  }
  return [$distances, $paths];
}

function distanceArrayToVertices(WeightedGraph $wg, array $distances): array {
  $distanceArray = [];
  for ($i = 0; $i < count($distances); $i++) {
    $distanceArray[$wg->vertexAt($i)] = $distances[$i];
  }
  return $distanceArray;
}

function pathArrayToPath(int $start, int $end, array $paths): array {
  if (count($paths) == 0) {
    return [];
  }
  $edgePath = [];
  $e = $paths[$end];
  $edgePath[] = $e;
  while ($e->u != $start) {
    $e = $paths[$e->u];
    $edgePath[] = $e;
  }
  return array_reverse($edgePath);
}
