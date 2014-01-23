<?php
/**
 * LightPHP Framework
 * LitePHP is a framework that has been designed to be lite waight, extensible and fast.
 *
 * !! WARNING: This file is not yet been tested and is not expected to work !!
 * 
 * @author Robert Pitt <robertpitt1988@gmail.com>
 * @category core
 * @copyright 2013 Robert Pitt
 * @license GPL v3 - GNU Public License v3
 * @version 1.0.0
 */
class Sorting_Library
{
	/**
	 * Sort an array using the natural algorithm
	 */
	public function natural(array &$stack)
	{
		/**
		 * Use PHP's inbuilt function for this
		 */
		natsort($stack);
	}

	/**
	 * Sort an array using the bubble algorithm
	 */
	public function bubble(array &$stack)
	{
		$c = count($stack);

		/**
		 * Start loopping the stack
		 */
		for($i = 0; $i < $c; $i++)
		{
			for ($j = 0, $stop = ($c - $i); $j < $stop; $j++)
			{
				if ($stack[$j] > $stack[j+1])
				{
					$this->_swap($stack, $j, $j + 1);
				}
			}
		}
	}

	/**
	 * Sort an array using the insertion algorithm
	 */
	public function insertion(array &$stack)
	{
		$c = count($stack);

		for ($i = 0; $i < $c; $i++)
		{
			/**
			 * store the current value because it may shift later
			 * @var *
			 */
			$value = $stack[$i];

			/**
			 * Whenever the value in the sorted section is greater than the value
			 * in the unsorted section, shift all items in the sorted section over
			 * by one. This creates space in which to insert the value.
			 */
			for ($j = i - 1; $j > -1 && $stack[$j] > $value; $j--)
			{
				$stack[$j + 1] = $stack[$j];
			}

			$stack[$j + 1] = $value;
		}
	}

	/**
	 * Sort an array using the merge algorithm
	 */
	public function merge(array &$stack)
	{
		$c = count($stack);

		/**
		 * Return if we only have one item
		 */
		if($c === 1)
		{
			return $stack;
		}

		/**
		 * Declare a working stack
		 */
		$work = array();

		for ($i = 0; $i < $c; $i++)
		{
			$work[] = [$stack[$i]];
		}

		$work[] = []; //In case we have an odd set.

		/**
		 * Start looping the working set.
		 */
		for ($lim = $c; $lim > 1; $lim = floor(($lim + 1) / 2))
		{
			for ($j = 0, $k=0; $k < $lim; $j++, $k += 2)
			{
				$work[$j] = $this->_merge($work[$k], $work[$k + 1]);
			}

			 $work[$j] = []; //In case we have an odd set.
		}

		/**
		 * Set the new stack to the working stack.
		 */
		$stack = $work[0];
	}

	/**
	 * Sort an array using the selection algorithm
	 */
	public function selection(array &$stack)
	{
		$c = count($stack);


		for ($i = 0; $i < $c; $i++)
		{
			// set minimum to this position
			$min = $i;

			// check the rest of the array to see if anything is smaller
			for ($j = $i + 1; $j < $c; $j++)
			{
				if($stack[$j] < $stack[$min])
				{
					$min = $j;
				}
			}

			// if the minimum isn't in the position, swap it
			if($i != $min)
			{
				$this->_swap($stack, $i, $min);
			}
		}
	}

	/**
	 * Shell sort
	 */
	public function shell(array &$stack)
	{
		$c = count($stack);
		$g = floor($c / 2);

		while($g > 0)
		{
			for($i = $g; $i < $c; $i++)
			{
				$temp = $stack[$i];
				$j = $i;
				while($j >= $g && $stack[$j - $g] > $temp)
				{
					$stack[$j] = $stack[$j - $g];
					$j -= $g;
				}

				$stack[$j] = $temp;
			}

			$g = floor($g / 2);
		}
	}

	/**
	 * Radix sorting
	 * @todo Implement.
	 */
	public function radix(&$input)
	{
	}

	/**
	 * Swap the value of the first index with the value of the second index.
	 */
	private function _swap(array &$stack, $key_from, $key_to)
	{
		/**
		 * Get the key from the first value
		 */
		$temp = $stack[$key_from];

		/**
		 * Replace the first index with the value of the second index
		 */
		$stack[$key_from] = $stack[$key_to];

		/**
		 * Set the first value to the second index.
		 */
		$stack[$key_to] = $temp;
	}

	/**
	 * Merges to arrays in order based on their natural
	 * relationship.
	 */
	private function _merge($left, $right)
	{
		$result = array();

		/**
		 * Get the lengths
		 */
		$lc = count($left);
		$rc = count($right);

		while ($lc > 0 && $rc > 0)
		{
			if ($left[0] < $right[0])
			{
				$result[] = array_shift($left);
				$lc--;
			}
			else
			{
				$result[] = array_shift($right);
				$rc--;
			}
		}

		$result = array_merge($result, $left, $right);

		/**
		 * Clear out the arrays
		 */
		unset($left);
		unset($right);

		/**
		 * Return the computed result
		 */
		return $result;
	}
}