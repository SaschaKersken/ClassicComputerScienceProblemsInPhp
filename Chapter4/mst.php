<?php

require_once(__DIR__.'/WeightedGraph.php');
require_once(__DIR__.'/../Chapter2/generic_search.php');
require_once(__DIR__.'/../Util.php');

function totalWeight(array $wp): float {
  return array_sum(
    array_map(
      function($e) {
        return $e->weight;
      },
      $wp
    )
  );
}

function visit(WeightedGraph $wg, PriorityQueue $pq, array $visited, int $index) {
  $visited[$index] = TRUE;
  foreach ($wg->edgesForIndex($index) as $edge) {
    if (!$visited[$edge->v]) {
      $pq->push($edge);
    }
  }
  return $visited;
}

function mst(WeightedGraph $wg, int $start = 0) {
  if ($start > $wg->vertexCount - 1 || $start < 0) {
    return NULL;
  }
  $result = [];
  $pq = new PriorityQueue();
  $visited = array_fill(0, $wg->vertexCount, FALSE);

  $visited = visit($wg, $pq, $visited, $start);

  while(!$pq->empty) {
    $edge = $pq->pop();
    if ($visited[$edge->v]) {
      continue;
    }
    $result[] = $edge;
    $visited = visit($wg, $pq, $visited, $edge->v);
  }
  return $result;
}

function printWeightedPath(WeightedGraph $wg, array $wp) {
  foreach ($wp as $edge) {
    Util::out(sprintf('%s %d> %s', $wg->vertexAt($edge->u), $edge->weight, $wg->vertexAt($edge->v)));
  }
  Util::out(sprintf('Total weight: %d', totalWeight($wp)));
}
