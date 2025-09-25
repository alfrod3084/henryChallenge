<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Database\Eloquent\Model;

class ModelTransitioning
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Model $model,
        public string $from,
        public string $to
    )
    {}
}
