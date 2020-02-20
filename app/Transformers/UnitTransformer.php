<?php

namespace App\Transformers;

use App\Models\Unit;
use League\Fractal\TransformerAbstract;

class UnitTransformer extends TransformerAbstract
{
    public function transform(Unit $unit)
    {
        return [
            'id' => $unit->id,
            'name' => $unit->name,
            'description' => $unit->description,
        ];
    }
}
