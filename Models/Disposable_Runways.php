<?php

namespace Modules\DisposableTech\Models;

use App\Contracts\Model;
use App\Models\Airport;

class Disposable_Runways extends Model
{
  public $table = 'disposable_runways';

  /* Relationship To Airport */
  public function airport()
  {
    return $this->belongsTo(Airport::class, 'airport');
  }
}
