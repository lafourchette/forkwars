<?php

/**
 *
 */
interface StrategyInterface 
{
	/**
	 * Receive a World, must return Order[]
	 */
	function decide(World $world);
}