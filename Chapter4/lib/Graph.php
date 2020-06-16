<?php

require_once(__DIR__.'/../../Autoloader.php');

/**
* Graph class
*
* Represents a graph
*
* @package ClassicComputerScienceProblemsInPhp
* @property int $vertexCount Number of vertices
* @property int $edgeCount Number of edges
*/
class Graph {
  /**
  * Vertices
  * @var array
  */
  protected $_vertices = [];

  /**
  * Edges connecting the vertices
  * @var array
  */
  protected $_edges = [];

  /**
  * Constructor
  *
  * @param array $vertices The vertices of this graph
  */
  public function __construct(array $vertices) {
    $this->_vertices = $vertices;
    for ($i = 0; $i < count($vertices); $i++) {
      $this->_edges[] = [];
    }
  }

  /**
  * Magic getter
  *
  * @param string $property Property to read
  * @return mixed Value of the property
  */
  public function __get(string $property) {
    switch ($property) {
    case 'vertexCount':
      return count($this->_vertices);
    case 'edgeCount':
      return array_reduce(
        $this->_edges,
        function ($sum, $edgesByVertex) {
          $sum += count($edgesByVertex);
          return $sum;
        }
      );
    }
  }

  /**
  * Add a vertex to the graph and return its index
  *
  * @param mixed $vertex The vertex to add
  * @return int Index of the new vertex
  */
  public function addVertex($vertex): int {
    $this->_vertices[] = $vertex;
    $this->_edges[] = []; // Add empty list for containing edges
    return $this->vertexCount - 1; // Return index of added vertex
  }

  /**
  * Add an edge
  *
  * This is an undirected graph,
  * so we always add edges in both directions
  *
  * @param Edge $edge The edge to add
  */
  public function addEdge(Edge $edge) {
    $this->_edges[$edge->u][] = $edge;
    $this->_edges[$edge->v][] = $edge->reversed();
  }

  /**
  * Add an edge using vertex indices (convenience method)
  *
  * @param int $u Index of the "from" vertex
  * @param int $v Index of the "to" vertex
  */
  public function addEdgeByIndices(int $u, int $v) {
    $edge = new Edge($u, $v);
    $this->addEdge($edge);
  }

  /**
  * Add an edge by looking up vertex indices (convenience method)
  *
  * @param mixed $first The "from" vertex
  * @param mixed $second The "to" vertex
  * @throws InvalidArgumentException if any of the vertices doesn't exist
  */
  public function addEdgeByVertices($first, $second) {
    $u = array_search($first, $this->_vertices);
    $v = array_search($second, $this->_vertices);
    if ($u === FALSE || $v === FALSE) {
      throw new InvalidArgumentException(
        'Trying to add edge for vertices that are not part of the current graph.'
      );
    }
    $this->addEdgeByIndices($u, $v);
  }

  /**
  * Find the vertex at a specific index
  *
  * @param int $index Index of the vertex to return
  * @return mixed The vertex at that index
  */
  public function vertexAt(int $index) {
    return $this->_vertices[$index];
  }

  /**
  * Find the index of a vertex in the graph
  *
  * @param mixed $vertex The vertex to find the index for
  * @return mixed Found index (int) or bool FALSE if it doesn't exist
  */
  public function indexOf($vertex) {
    return array_search($vertex, $this->_vertices);
  }

  /**
  * Find the vertices that a vertex at some index is connected to
  *
  * @param int $index Index of a vertex
  * @return array The neighboring vertices
  */
  public function neighborsForIndex(int $index): array {
    return array_map(
      function($edge) {
        return $this->vertexAt($edge->v);
      },
      $this->_edges[$index]
    );
  }

  /**
  * Lookup a vertice's index and find its neighbors (convenience method)
  *
  * @param mixed $vertex The vertex to find neighbors for
  * @return array The neigboring vertices
  */
  public function neighborsForVertex($vertex): array {
    $index = $this->indexOf($vertex);
    $result = [];
    if ($index !== FALSE) {
      $result = $this->neighborsForIndex($index);
    }
    return $result;
  }

  /**
  * Return all of the edges associated with a vertex at some index
  *
  * @param int $index Index of some vertex
  * @return array Edge objects associated with that vertex
  */
  public function edgesForIndex(int $index): array {
    return $this->_edges[$index];
  }

  /**
  * Lookup the index of a vertex and return its edges (convenience method)
  *
  * @param mixed $vertex A vertex
  * @return array Edge objects associated with that vertex
  */
  public function edgesForVertex($vertex): array {
    $index = $this->indexOf($vertex);
    $result = [];
    if ($index !== FALSE) {
      $result = $this->edgesForIndex($index);
    }
    return $result;
  }

  /**
  * Make it easy to pretty-print the graph
  *
  * @return string String representation of the graph
  */
  public function __toString(): string {
    $desc = '';
    foreach ($this->_vertices as $vertex) {
      $desc .= $vertex." -> ".implode(
        ', ',
        $this->neighborsForVertex($vertex)
      ).PHP_EOL;
    }
    return $desc;
  }
}
