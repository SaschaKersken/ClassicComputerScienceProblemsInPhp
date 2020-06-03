<?php

/**
* Chromosome abstract class
*
* Base class for all chromosomes; all methods must be overridden
*
* @package ClassicComputerScienceProblemsInPhp
*/
abstract class Chromosome {
  /**
  * Determine how close a chromosome is to the solution
  *
  * @return float The fitness value
  */
  public abstract function fitness(): float;

  /**
  * Return an instance of the chromosome with randomized property values
  *
  * @return Chromosome The new chromosome
  */
  public static abstract function randomInstance(): Chromosome;

  /**
  * Cross this chromosome with another one to build the next generation
  *
  * @return array Two new chromosomes
  */
  public abstract function crossover(Chromosome $other): array;

  /**
  * Randomly modify a chromosome's property values to mutate it
  */
  public abstract function mutate();
}
