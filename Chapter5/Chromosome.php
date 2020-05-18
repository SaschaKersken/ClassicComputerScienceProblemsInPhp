<?php

abstract class Chromosome {
  public abstract function fitness(): float;

  public static abstract function randomInstance();

  public abstract function crossover($other): array;

  public abstract function mutate();
}
