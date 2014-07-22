<?php

namespace Forkwars;

class Engine
{
	public function __construct(General $red, General $blue, World $world)
	{
		// sets
	}

	public function setLog()
	{
		
	}

	/**
	 * Run the game until one of the following happens :
	 * - A general reach win condition
	 * - A general orders something not possible
	 * - Unresponsive general
	 * - General issue no order
	 * - The game is running for more than 500 step
     *
     * @return General|null Winning general
	 */
	public function step()
	{
		$winner = null;

        $orders = $this->blue->getOrders($this->world);
        // empty orders raises exception
        $this->world->apply($orders);

        if($this->world->hasWinner()){

            return $this->world->getWinner();
        }

        $orders = $this->red->getOrders($this->world);
        $this->world->apply($orders);

		return $this->world->getWinner();
	}
}