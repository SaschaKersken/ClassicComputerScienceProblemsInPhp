<?php

require_once(__DIR__.'/../Autoloader.php');
require_once(__DIR__.'/../Chapter2/generic_search.php');

/**
* Dijkstra's algorithm to find the path with the lowest weight
*
* @param WeigtedGraph $wg A weighted graph to search the path in
* @param mixed $root The vertex to start at
*/
function dijkstra(WeightedGraph $wg, $root): array {
  $first = $wg->indexOf($root);
  // Distances are unknown at first
  $distances = array_fill(0, $wg->vertexCount, NULL);
  $distances[$first] = 0; // The root is 0 away from the root
  $paths = []; // How we got to each vertex
  $pq = new PriorityQueue();
  $pq->push(new DijkstraNode($first, 0));

  while (!$pq->empty) {
    $u = $pq->pop()->vertex; // Explore the next closest vertex
    $distU = $distances[$u]; // Should already have seen it
    // Look at every edge/vertex from the vertex in question
    foreach ($wg->edgesForIndex($u) as $we) {
      // The old distance to this vertex
      $distV = $distances[$we->v];
      // No old distance or found shorter path
      if (is_null($distV) || $distV > $we->weight + $distU) {
        // Update distance to this vertex
        $distances[$we->v] = $we->weight + $distU;
        // Update the edge on the shortest path to this vertex
        $paths[$we->v] = $we;
        // Explore it sooon
        $pq->push(new DijkstraNode($we->v, $we->weight + $distU));
      }
    }
  }
  return [$distances, $paths];
}

/**
*  Helper function to get easier access to dijkstra results
*
* @param WeightedGraph $wg A weighted graph
* @param array $distances An array of distances
* @return array Associative array with vertices as keys and distances as values
*/
function distanceArrayToVertices(WeightedGraph $wg, array $distances): array {
  $distanceArray = [];
  for ($i = 0; $i < count($distances); $i++) {
    $distanceArray[$wg->vertexAt($i)] = $distances[$i];
  }
  return $distanceArray;
}

/**
* Convert a path array to a start-to-end path
*
* Takes an array of edges to reach each node and returns an array of
* edges that goes from `start` to `end`
*
* @param int $start Index of the start vertex
* @param int $end Index of the end vertex
* @param array $path The paths to create a single path from
* @return array The start-to-end path
*/
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
