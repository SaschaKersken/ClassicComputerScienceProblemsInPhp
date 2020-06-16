<?php

use PHPUnit\Framework\TestCase;

final class NeuronTest extends TestCase {
  /**
  * @covers Neuron::__construct
  */
  public function testConstruct() {
    $neuron = new Neuron_TestProxy([1, 1], 0.5);
    $this->assertInstanceOf('Neuron', $neuron);
  }

  /**
  * @covers Neuron::output
  */
  public function testOutput() {
    $neuron = new Neuron_TestProxy([1, 1], 0.5);
    $this->assertEquals(2, $neuron->output([1, 1]));
  }
}

class Neuron_TestProxy extends Neuron {
  public function activationFunction(float $x): float {
    return $x;
  }
}
