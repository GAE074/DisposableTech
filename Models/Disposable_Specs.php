<?php

namespace Modules\DisposableTech\Models;

use App\Contracts\Model;
use App\Models\Aircraft;
use App\Models\Subfleet;

class Disposable_Specs extends Model
{
  public $table = 'disposable_specs';

  protected $fillable = [
    'aircraft_id',
    'subfleet_id',
    'bew',
    'dow',
    'mzfw',
    'mrw',
    'mtow',
    'mlw',
    'mrange',
    'mceiling',
    'mfuel',
    'mpax',
    'mspeed',
    'cspeed',
    'cat',
    'equip',
    'transponder',
    'pbn',
    'crew',
    'saircraft',
    'stitle',
    'fuelfactor',
    'active',
  ];

  /* Validation rules */
  public static $rules = [
    'aircraft_id' => 'nullable|numeric',
    'subfleet_id' => 'nullable|numeric',
    'bew'         => 'nullable|numeric',
    'dow'         => 'nullable|numeric',
    'mzfw'        => 'nullable|numeric',
    'mrw'         => 'nullable|numeric',
    'mtow'        => 'nullable|numeric',
    'mlw'         => 'nullable|numeric',
    'mrange'      => 'nullable|numeric',
    'mceiling'    => 'nullable|numeric',
    'mfuel'       => 'nullable|numeric',
    'mpax'        => 'nullable|numeric',
    'mspeed'      => 'nullable|numeric',
    'cspeed'      => 'nullable|numeric',
    'cat'         => 'nullable',
    'equip'       => 'nullable',
    'transponder' => 'nullable',
    'pbn'         => 'nullable',
    'maxfuel'     => 'nullable|numeric',
    'maxpax'      => 'nullable|numeric',
    'crew'        => 'nullable|numeric',
    'saircraft'   => 'required|max:50',
    'stitle'      => 'nullable|max:30',
    'fuelfactor'  => 'nullable|max:3',
    'active'      => 'nullable',
  ];

  /* Relationship To Aircraft */
  public function aircraft()
  {
    return $this->belongsTo(Aircraft::class, 'aircraft_id', 'id');
  }

  /* Relationship To Subfleet */
  public function subfleet()
  {
    return $this->belongsTo(Subfleet::class, 'subfleet_id', 'id');
  }
}
