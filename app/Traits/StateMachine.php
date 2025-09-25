<?php

namespace App\Traits;

use InvalidArgumentException;
use App\Events\ModelTransitioning;
use App\Events\ModelTransitioned;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;

trait StateMachine
{
    /**
     * Validate the transition between current and allowed states.
     * 
     * @access public
     * @param string $newState
     * @return boolean
     */
    public function transitionTo(string $newState): bool
    {
        try {
            $currentState = $this->status;
            $allowed = static::$states[$currentState] ?? [];
            if (in_array($newState, $allowed, true)) {
                Event::dispatch(new ModelTransitioning($this, $currentState, $newState));
                $this->status = $newState;
                $this->save();
                Event::dispatch(new ModelTransitioned($this, $currentState, $newState));
                return true;
            } else {
                throw new InvalidArgumentException("Invalid transition from [$currentState] to [$newState].");
            }
        } catch (InvalidArgumentException $e) {
            echo $e->getMessage();
        }
    }
}
