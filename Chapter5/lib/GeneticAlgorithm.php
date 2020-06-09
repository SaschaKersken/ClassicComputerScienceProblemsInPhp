<?php

require_once(__DIR__.'/../../Util.php');

/**
* GeneticAlgorithm class
*
* Create a number of random chromosomes and modify them
* over a definable number of generations
*
* @package ClassicComputerScienceProblemsInPhp
*/
class GeneticAlgorithm {
  /**
  * The population of the current generation
  * @var array
  */
  private $_population = [];

  /**
  * Threshold for the fitness function that indicates an optimal solution
  * @var float
  */
  private $_threshold = 0.0;

  /**
  * Maximum number of generations
  * @var int
  */
  private $_maxGenerations = 100;

  /**
  * Chance for chromosomes to mutate
  * @var float
  */
  private $_mutationChance = 0.01;

  /**
  * Chance for two chromosomes to crossover
  * @var float
  */
  private $_crossoverChance = 0.7;

  /**
  * Selection type to choose the fittest individuals
  * @var int
  */
  private $_selectionType = SelectionType::TOURNAMENT;

  /**
  * Constructor
  *
  * @param array $initialPopulation The population to start with
  * @param float $threshold Fitness threshols for optimal solution
  * @param int $maxGenerations Maximum number of generations optional, default 100
  * @param float $mutationChance Chance for mutation optional, default 0.01
  * @param float $crossoverChance Chance for crossover optional, default 0.7
  * @param int optional, SelectionType::TOURNAMENT (default) or SelectionType::ROULETTE
  */
  public function __construct(array $initialPopulation, float $threshold, int $maxGenerations = 100, float $mutationChance = 0.01, float $crossoverChance = 0.7, int $selectionType = SelectionType::TOURNAMENT) {
    $this->_population = $initialPopulation;
    $this->_threshold = $threshold;
    $this->_maxGenerations = $maxGenerations;
    $this->_mutationChance = $mutationChance;
    $this->_crossoverChance = $crossoverChance;
    $this->_selectionType = $selectionType;
  }

  /**
  * Choices algorithm for roulette wheel selection and more
  *
  * @param array $population The population to run the algorithm on
  * @param array $weights Probabilities to be picked optional, default NULL
  * @param int $k How many individuals to pick optional, default 1
  * @return array $k individuals
  */
  public function choices(array $population, array $weights = NULL, $k = 1): array {
    // If no weights are given, the chance for each individual is the same
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

  /**
  * Use the probability distribution wheel to pick 2 parents
  *
  * Note: will not work with negative fitness results
  *
  * @param array $wheel Probabilities for individuals to be picked
  * @return array The two picked individuals
  */
  public function pickRoulette(array $wheel): array {
    return $this->choices($this->_population, $wheel, 2);
  }

  /**
  * Choose $numParticipants at random and take the best 2
  *
  * @param int $numParticipants How many random participants to choose
  * @return array The two picked individuals
  */
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

  /**
  * Replace the population with a new generation of individuals
  */
  public function reproduceAndReplace() {
    $newPopulation = [];
    // Keep going until we've filled the new generation
    while (count($newPopulation) < count($this->_population)) {
      // Pick the 2 parents
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
      // Potentially crossover the 2 parents
      if ((float)rand() / getrandmax() < $this->_crossoverChance) {
        $newPopulation = array_merge(
          $newPopulation,
          $parents[0]->crossover($parents[1])
        );
      } else {
        $newPopulation = array_merge($newPopulation, $parents);
      }
    }
    // If we had an odd number, we'll have 1 extra, so we remove it
    if (count($newPopulation) > count($this->_population)) {
      array_pop($newPopulation);
    }
    $this->_population = $newPopulation;
  }

  /**
  * With $this->_mutationChance probability mutate each individual
  */
  public function mutate() {
    foreach ($this->_population as $individual) {
      if ((float)rand() / getrandmax() < $this->_mutationChance) {
        $individual->mutate();
      }
    }
  }

  /**
  * Determine best chromosome and average fitnesses of the current generation
  *
  * @return array Best (Chromosome), average (float)
  */
  private function _bestAndAvgByFitness(): array {
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

  /**
  * The evolutionary process
  *
  * Run the genetic algorithm for $this->maxGenerations iterations
  * and return the best individual found
  *
  * @return Chromosome The best one found
  */
  public function run(): Chromosome {
    list($best, $avg) = $this->_bestAndAvgByFitness();
    for ($i = 0; $i < $this->_maxGenerations; $i++) {
      // Early exit if we beat threshold
      if ($best->fitness() >= $this->_threshold) {
        return $best;
      }
      Util::out(
        sprintf(
          "Generation: %d, Best: %f, Average: %f",
          $i,
          $best->fitness(),
          $avg
        )
      );
      $this->reproduceAndReplace();
      $this->mutate();
      list($highest, $avg) = $this->_bestAndAvgByFitness();
      if ($highest->fitness() > $best->fitness()) {
        $best = $highest; // Found a new best
      }
    }
    return $best; // Best we found in $this->_maxGenerations
  }
}
