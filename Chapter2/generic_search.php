<?php

require_once(__DIR__.'/../Util.php');

/**
* Generic search library
*
* Usage: require_once('[path/]generic_search.php');
*/

require_once(__DIR__.'/Stack.php');

function linearContains($iterable, $key): bool {
  foreach ($iterable as $item) {
    if ($item == $key) {
      return TRUE;
    }
  }
  return FALSE;
}

function binaryContains($sequence, $key): bool {
  $low = 0;
  $high = count($sequence) - 1;
  while ($low <= $high) {
    $mid = floor(($low + $high) / 2);
    if ($sequence[$mid] < $key) {
      $low = $mid + 1;
    } elseif ($sequence[$mid] > $key) {
      $high = $mid - 1;
    } else {
      return TRUE;
    }
  }
  return FALSE;
}

/**
* Depth-first search
*
* @param mixed $initial Starting state
* @param callable $goalTest Function to check whether we've reached the goal
* @param callable $successors Function to find states to reach from current one
* @return mixed Node if the goal has been reached, otherwise NULL
*/
function dfs($initial, $goalTest, $successors) {
  // Frontier is where we've yet to go
  $frontier = new Stack();
  $frontier->push(new Node($initial, NULL));
  // Explored is where we've been
  $explored = [$initial];

  // Keep going while there is more to explore
  while (!$frontier->empty) {
    $currentNode = $frontier->pop();
    $currentState = $currentNode->state;
    // If we found the goal, we're done
    if ($goalTest($currentState)) {
      return $currentNode;
    }
    // Check where we can go next and haven't explored
    foreach ($successors($currentState) as $child) {
      if (in_array($child, $explored)) {
        // Skip children we already explored
        continue;
      }
      $explored[] = $child;
      $frontier->push(new Node($child, $currentNode));
    }
  }
  return NULL; // Went throug everything and never found goal
}

/**
* Breadth-first search
*
* @param mixed $initial Starting state
* @param callable $goalTest Function to check whether we've reached the goal
* @param callable $successors Function to find states to reach from current one
* @return mixed Node if the goal has been reached, otherwise NULL
*/
function bfs($initial, $goalTest, $successors) {
  // Frontier is where we've yet to go
  $frontier = new Queue();
  $frontier->push(new Node($initial, NULL));
  // Explored is where we've been
  $explored = [$initial];

  // Keep going while there is more to explore
  while (!$frontier->empty) {
    $currentNode = $frontier->pop();
    $currentState = $currentNode->state;
    // If we found the goal, we're done
    if ($goalTest($currentState)) {
      return $currentNode;
    }
    // Check where we can go next and haven't explored
    foreach ($successors($currentState) as $child) {
      if (in_array($child, $explored)) { 
        // Skip children we already explored
        continue;
      }
      $explored[] = $child;
      $frontier->push(new Node($child, $currentNode));
    }
  }
  return NULL; // Went through everything and never found goal
}

/**
* A* search
*
* @param SearchState $initial Starting state
* @param callable $goalTest Function to check whether we've reached the goal
* @param callable $successors Function to find states to reach from current one
* @param callable $heuristic Function to estimate the cost to reach a state
* @return mixed Node if the goal has been reached, otherwise NULL
*/
function astar(SearchState $initial, $goalTest, $successors, $heuristic) {
  // Frontier is where we've yet to go
  $frontier = new PriorityQueue();
  $frontier->push(new Node($initial, NULL, 0.0, $heuristic($initial)));
  // Explored is where we've been
  $explored = [$initial->getKey() => 0.0];

  // Keep going while there's more to explore
  while (!$frontier->empty) {
    $currentNode = $frontier->pop();
    $currentState = $currentNode->state;
    // If we found the goal, we're done
    if ($goalTest($currentState)) {
      return $currentNode;
    }
    // Check where we can go next and haven't explored
    foreach ($successors($currentState) as $child) {
      // cost+1 assumes a grid, need a cost function for more sophisticated apps
      $newCost = $currentNode->cost + 1;
      $key = $child->getKey();
      if (!isset($explored[$key]) || $explored[$key] > $newCost) {
        $explored[$key] = $newCost;
        $frontier->push(new Node($child, $currentNode, $newCost, $heuristic($child)));
      }
    }
  }
  return NULL; // Went through everything and never found goal
}

/**
* Convert a node to a path by going through nodes' parents and reversing the result
*
* @param Node $node The node to convert to a path
* @return array The path created from the node
*/
function nodeToPath(Node $node): array {
  $path = [$node->state];
  while (!is_null($node->parent)) {
    $node = $node->parent;
    $path[] = $node->state;
  }
  return array_reverse($path);
}
