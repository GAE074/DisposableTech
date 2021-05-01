<?php

use App\Models\Pirep;
use App\Models\PirepFieldValue;
use Modules\DisposableTech\Models\Disposable_Specs;
use Modules\DisposableTech\Models\Disposable_Runways;

if (!function_exists('Dispo_GetAcSpecs')) {
  // Get Technical Specs of an Aircraft or its Subfleet
  // Return Collection
  function Dispo_GetAcSpecs($aircraft) {
    $specs = Disposable_Specs::where('aircraft_id', $aircraft->id)->where('active', true)
                  ->orwhere('subfleet_id', $aircraft->subfleet_id)->where('active', true)
                  ->get();
    return $specs;
  }
}

if (!function_exists('Dispo_GetSubfleetSpecs')) {
  // Get Technical Specs of a Subfleet
  // Return Collection
  function Dispo_GetSubfleetSpecs($subfleet) {
    $specs = Disposable_Specs::where('subfleet_id', $subfleet->id)->where('active', true)->get();
    return $specs;
  }
}

if (!function_exists('Dispo_Specs')) {
  // Prepare The Specs Selection Dropdown value
  // Return String
  function Dispo_Specs($specs) {
    $result = $specs->id."#1#".$specs->dow."#2#".$specs->mzfw."#3#".$specs->mtow."#4#".$specs->mlw."#5#".$specs->mfuel."#6#".$specs->fuelfactor."#7#";
    if(filled($specs->cat) && filled($specs->equip) && filled($specs->transponder) && filled($specs->pbn)) {
      $result = $result.$specs->cat."#8#".$specs->equip."#9#".$specs->transponder."#10#".$specs->pbn."#11#";
    }
    return $result;
  }
}

if (!function_exists('Dispo_GetRunways')) {
  // Get Runways of an airport
  // Return Collection
  function Dispo_GetRunways($icao) {
    $runways = Disposable_Runways::where('airport', $icao)->orderby('runway_ident', 'asc')->get();
    return $runways;
  }
}

if (!function_exists('Dispo_CheckWeights')) {
  // Check Weights of a Pirep According to Specs
  // Return formatted string (with html tags)
  function Dispo_CheckWeights($pirepid, $slug) {   
    if(stripos($slug, '-weight') !== false) 
    {
      $specwgt = null;
      $specselect = 'bew';
      if($slug === 'ramp-weight') { $specselect = 'mrw';}
      elseif($slug === 'takeoff-weight') { $specselect = 'mtow';}
      elseif($slug === 'landing-weight') { $specselect = 'mlw';}

      $pirep = Pirep::where('id', $pirepid)->first();

      if($pirep && $slug) {
        $pirepwgt = PirepFieldValue::select('id', 'value')->where('pirep_id', $pirep->id)->where('slug', $slug)->first();
        $pirepac = PirepFieldValue::select('id', 'value')->where('pirep_id', $pirep->id)->where('slug', 'aircraft')->first();
      }

      if($pirepac) {
        $specs = Disposable_Specs::select('id', 'stitle', $specselect)->where('aircraft_id', $pirep->aircraft_id)
                              ->whereNotNull('stitle')->whereNotNull($specselect)->where('active', 1)
                              ->orwhere('subfleet_id', $pirep->aircraft->subfleet_id)
                              ->whereNotNull('stitle')->whereNotNull($specselect)->where('active', 1)
                              ->get();
        foreach($specs as $spec) {
          if(stripos($pirepac->value, $spec->stitle) !== false) {
            $specwgt = $spec->$specselect;
          }
        }
      }

      // Check User Weight Settings and Convert Pirep Weight
      if($pirepwgt && setting('units.weight') === 'kg') {
        $pirepwgt->value = $pirepwgt->value / 2.20462262185 ;
      }
      // Do The Final Check and Return
      if($pirepwgt && $specwgt && $pirepwgt->value > $specwgt) { 
        return "<span class='badge badge-danger ml-1 mr-1' title='Max: ".number_format($specwgt)." ".setting('units.weight')."'>OVERWEIGHT !</span>";
      } 
    }
  }
}
