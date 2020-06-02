<?php

require_once(__DIR__.'/../Chapter2/generic_search.php');
require_once(__DIR__.'/../Util.php');

/**
* Calculate the total weight of a weighted path
*
* @param array $wp Array of WeigtedEdge items
* @return float Sum of weights
*/
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

/**
* Visit a specific vertex
*
* @param WeightedGraph $wg The weighted graph to visit a vertex in
* @param PriorityQueue $pq The priority queue to add edges to
* @param array $visited List of vertices that have already been visited
* @param int $index Index of the vertex to visit
* @return array List of vertices that have already been visited, including current one
*/
function visit(WeightedGraph $wg, PriorityQueue $pq, array $visited, int $index) {
  $visited[$index] = TRUE; // Mark as visited
  foreach ($wg->edgesForIndex($index) as $edge) {
    // Add all edges coming from here to $pq
    if (!$visited[$edge->v]) {
      $pq->push($edge);
    }
  }
  return $visited;
}

/**
* The minimum spanning tree algorithm
*
* @param WeightedGraph $wg The weighted graph to find the mst for
* @param int $start Index of the vertex to start at
* @return mixed The mst (array) or NULL if none
*/
function mst(WeightedGraph $wg, int $start = 0) {
  if ($start > $wg->vertexCount - 1 || $start < 0) {
    return NULL;
  }
  $result = []; // holds the final MST
  $pq = new PriorityQueue();
  $visited = array_fill(0, $wg->vertexCount, FALSE); // where we've been

  // The first vertex is where everything starts
  $visited = visit($wg, $pq, $visited, $start);

  while(!$pq->empty) { // keep going while there are edges to process
    $edge = $pq->pop();
    if ($visited[$edge->v]) {
      continue; // don't ever revisit
    }
    // This is the current smallest, so add it to solution
    $result[] = $edge;
    $visited = visit($wg, $pq, $visited, $edge->v); // visit where this connects
  }
  return $result;
}

/**
* Print a weighted path
*
* @param WeightedGraph $wg The weighted graph the path is for
* @param array $wp The path to print
*/
function printWeightedPath(WeightedGraph $wg, array $wp) {
  foreach ($wp as $edge) {
    Util::out(
      sprintf(
        '%s %d> %s',
        $wg->vertexAt($edge->u),
        $edge->weight,
        $wg->vertexAt($edge->v)
      )
    );
  }
  Util::out(sprintf('Total weight: %d', totalWeight($wp)));
}
