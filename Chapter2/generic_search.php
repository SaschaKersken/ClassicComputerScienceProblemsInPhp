<?php

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

class Stack {
  protected $_container = [];

  public function __get($key) {
    if ($key == 'empty') {
      return !$this->_container;
    }
  }

  public function push($item) {
    $this->_container[] = $item;
  }

  public function pop() {
    return array_pop($this->_container);
  }

  public function __toString() {
    return implode(', ', $this->_container);
  }
}

class Node {
  private $state = NULL;
  private $parent = NULL;
  private $cost = 0.0;
  private $heuristic = 0.0;

  public function __construct($state, $parent = NULL, $cost = 0.0, $heuristic = 0.0) {
    $this->state = $state;
    $this->parent = $parent;
    $this->cost = $cost;
    $this->heuristic = $heuristic;
  }

  public function compare(Node $other): bool {
    if ($this->cost + $this->heuristic < $other->cost + $other->heuristic) {
      return -1;
    }
    if ($this->cost + $this->heuristic > $other->cost + $other->heuristic) {
      return 1;
    }
    return 0;
  }

  public function __get($property) {
    switch ($property) {
    case 'state':
      return $this->state;
    case 'parent':
      return $this->parent;
    case 'cost':
      return $this->cost;
    case 'heuristic':
      return $this->heuristic;
    }
  }
}

function dfs($initial, $goalTest, $successors) {
  $frontier = new Stack();
  $frontier->push(new Node($initial, NULL));
  $explored = [$initial];

  while (!$frontier->empty) {
    $currentNode = $frontier->pop();
    $currentState = $currentNode->state;
    if ($goalTest($currentState)) {
      return $currentNode;
    }
    foreach ($successors($currentState) as $child) {
      if (in_array($child, $explored)) {
        continue;
      }
      $explored[] = $child;
      $frontier->push(new Node($child, $currentNode));
    }
  }
  return NULL;
}

function nodeToPath($node): array {
  $path = [$node->state];
  while (!is_null($node->parent)) {
    $node = $node->parent;
    $path[] = $node->state;
  }
  return array_reverse($path);
}

class Queue extends Stack {
  public function pop() {
    return array_shift($this->_container);
  }
}

function bfs($initial, $goalTest, $successors) {
  $frontier = new Queue();
  $frontier->push(new Node($initial, NULL));
  $explored = [$initial];

  while (!$frontier->empty) {
    $currentNode = $frontier->pop();
    $currentState = $currentNode->state;
    if ($goalTest($currentState)) {
      return $currentNode;
    }
    foreach ($successors($currentState) as $child) {
      if (in_array($child, $explored)) {
        continue;
      }
      $explored[] = $child;
      $frontier->push(new Node($child, $currentNode));
    }
  }
  return NULL;
}

class PriorityQueue extends Queue {
  public function push($item) {
    $this->_container[] = $item;
    sort($this->_container);
  }
}

function astar($initial, $goalTest, $successors, $heuristic) {
  $frontier = new PriorityQueue();
  $frontier->push(new Node($initial, NULL, 0.0, $heuristic($initial)));
  $explored = [$initial];

  while (!$frontier->empty) {
    $currentNode = $frontier->pop();
    $currentState = $currentNode->state;
    if ($goalTest($currentState)) {
      return $currentNode;
    }
    foreach ($successors($currentState) as $child) {
      if (in_array($child, $explored)) {
        continue;
      }
      $explored[] = $child;
      $frontier->push(new Node($child, $currentNode));
    }
  }
  return NULL;
}

