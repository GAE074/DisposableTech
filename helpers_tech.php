<?php

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
