<?php

class Edge {
  public $u;
  public $v;

  public function __construct(int $u, int $v) {
    $this->u = $u;
    $this->v = $v;
  }

  public function reversed(): Edge {
    return new Edge($this->v, $this->u);
  }

  public function __toString(): string {
    return sprintf('%d -> %d', $this->u, $this->v);
  }
}
