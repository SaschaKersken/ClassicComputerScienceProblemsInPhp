<?php

require_once(__DIR__.'/Edge.php');

class Graph {
  protected $_vertices = [];
  protected $_edges = [];

  public function __construct(array $vertices) {
    $this->_vertices = $vertices;
    for ($i = 0; $i < count($vertices); $i++) {
      $this->_edges[] = [];
    }
  }

  public function __get($property) {
    switch ($property) {
    case 'vertexCount':
      return count($this->_vertices);
    case 'edgeCount':
      return array_sum(array_map('count', $this->_edges));
    }
  }

  public function addVertex($vertex): int {
    $this->_vertices[] = $vertex;
    $this->_edges[] = [];
    return $this->vertexCount - 1;
  }

  public function addEdge(Edge $edge) {
    $this->_edges[$edge->u][] = $edge;
    $this->_edges[$edge->v][] = $edge->reversed();
  }

  public function addEdgeByIndices(int $u, int $v) {
    $edge = new Edge($u, $v);
    $this->addEdge($edge);
  }

  public function addEdgeByVertices($first, $second) {
    $u = array_search($first, $this->_vertices);
    $v = array_search($second, $this->_vertices);
    if ($u === FALSE || $v === FALSE) {
      throw new InvalidArgumentException('Trying to add edge for vertices that are not part of the current graph.');
    }
    return $this->addEdgeByIndices($u, $v);
  }

  public function vertexAt(int $index) {
    return $this->_vertices[$index];
  }

  public function indexOf($vertex) {
    return array_search($vertex, $this->_vertices);
  }

  public function neighborsForIndex(int $index): array {
    return array_map(
      function($edge) {
        return $this->vertexAt($edge->v);
      },
      $this->_edges[$index]
    );
  }

  public function neighborsForVertex($vertex): array {
    $index = $this->indexOf($vertex);
    $result = [];
    if ($index !== FALSE) {
      $result = $this->neighborsForIndex($index);
    }
    return $result;
  }

  public function edgesForIndex(int $index): array {
    return $this->_edges[$index];
  }

  public function edgesForVertex($vertex): array {
    $index = $this->indexOf($vertex);
    $result = [];
    if ($index !== FALSE) {
      $result = $this->edgesForIndex($index);
    }
    return $result;
  }

  public function __toString() {
    $desc = '';
    foreach ($this->_vertices as $vertex) {
      $desc .= $vertex." -> ".implode(', ', $this->neighborsForVertex($vertex)).PHP_EOL;
    }
    return $desc;
  }
} 
