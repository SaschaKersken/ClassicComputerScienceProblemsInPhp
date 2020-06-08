<?php

/**
* SearchState interface
*
* Implement the getKey() method to return unique keys for different objects
* of your class if you want to use them as search states for A* search
* The return value of getKey() has to be a legal array key
*
* @package ClassicComputerScienceProblemsInPhp
*/
interface SearchState {
  public function getKey();
}
