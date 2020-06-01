<?php

require_once(__DIR__.'/Chromosome.php');

class SelectionType {
  const ROULETTE = 0;
  const TOURNAMENT = 1;
}

class GeneticAlgorithm {
  private $_population = [];
  private $_threshold = 0.0;
  private $_maxGenerations = 100;
  private $_mutationChance = 0.01;
  private $_crossoverChance = 0.7;
  private $_selectionType = SelectionType::TOURNAMENT;

  public function __construct(array $initialPopulation, float $threshold, int $maxGenerations = 100, float $mutationChance = 0.01, float $crossoverChance = 0.7, int $selectionType = SelectionType::TOURNAMENT) {
    $this->_population = $initialPopulation;
    $this->_threshold = $threshold;
    $this->_maxGenerations = $maxGenerations;
    $this->_mutationChance = $mutationChance;
    $this->_crossoverChance = $crossoverChance;
    $this->_selectionType = $selectionType;
  }

  public function choices(array $population, array $weights = NULL, $k = 1) {
    if (is_null($weights)) {
      $weights = array_fill(0, count($population), 1);
    }
    $keysToChooseFrom = array_keys($population);
    $max = array_sum($weights);
    $picks = [];
    for ($i = 0; $i < $k; $i++) {
      $r = (float)rand() / getrandmax() * $max;
      $counter = 0;
      while ($r > 0) {
        $r -= $weights[$counter];
        if ($r <= 0) {
          break;
        }
        $counter++;
        if ($counter >= count($weights) || $counter >= count($population)) {
          $counter = 0;
        }
      }
      $picks[] = $population[$keysToChooseFrom[$counter]];
    }
    return $picks;
  }

  public function pickRoulette(array $wheel): array {
    return $this->choices($this->_population, $wheel, 2);
  }

  public function pickTournament(int $numParticipants): array {
    $participants = $this->choices($this->_population, NULL, $numParticipants);
    usort(
      $participants,
      function ($a, $b) {
        return $b->fitness() - $a->fitness();
      }
    );
    return array_slice($participants, 0, 2);
  }

  public function reproduceAndReplace() {
    $newPopulation = array();
    while (count($newPopulation) < count($this->_population)) {
      if ($this->_selectionType == SelectionType::ROULETTE) {
        $parents = $this->pickRoulette(
          array_map(
            function($x) {
              return $x->fitness();
            },
            $this->_population,
          )
        );
      } else {
        $parents = $this->pickTournament(floor(count($this->_population) / 2));
      }
      if ((float)rand() / getrandmax() < $this->_crossoverChance) {
        $newPopulation = array_merge(
          $newPopulation,
          $parents[0]->crossover($parents[1])
        );
      } else {
        $newPopulation = array_merge($newPopulation, $parents);
      }
    }
    if (count($newPopulation) > count($this->_population)) {
      array_pop($newPopulation);
    }
    $this->_population = $newPopulation;
  }

  public function mutate() {
    foreach ($this->_population as $individual) {
      if ((float)rand() / getrandmax() < $this->_mutationChance) {
        $individual->mutate();
      }
    }
  }

  private function _bestAndAvgByFitness() {
    $best = $this->_population[0];
    $sum = 0;
    foreach ($this->_population as $individual) {
      $sum += $individual->fitness();
      if ($individual->fitness() > $best->fitness()) {
        $best = $individual;
      }
    }
    $avg = $sum / count($this->_population);
    return [$best, $avg];
  }

  public function run() {
    list($best, $avg) = $this->_bestAndAvgByFitness();
    for ($i = 0; $i < $this->_maxGenerations; $i++) {
      if ($best->fitness() >= $this->_threshold) {
        return $best;
      }
      Util::out(sprintf("Generation: %d, Best: %f, Average: %f", $i, $best->fitness(), $avg));
      $this->reproduceAndReplace();
      $this->mutate();
      list($highest, $avg) = $this->_bestAndAvgByFitness();
      if ($highest->fitness() > $best->fitness()) {
        $best = $highest;
      }
    }
    return $best;
  }
}
