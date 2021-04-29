<?php

namespace Modules\DisposableTech\Http\Controllers;

use App\Contracts\Controller;
use App\Repositories\AircraftRepository;
use App\Repositories\SubfleetRepository;
use Modules\DisposableTech\Models\Disposable_Specs;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class TechSpecsController extends Controller
{
  private $aircraftRepo;
  private $subfleetRepo;

  public function __construct(
      AircraftRepository $aircraftRepo,
      SubfleetRepository $subfleetRepo
  ) {
      $this->aircraftRepo = $aircraftRepo;
      $this->subfleetRepo = $subfleetRepo;
  }
  // Admin Specs Page
  public function dtspecs(Request $request) {

    //Get SubFleet List
    $subfleets = $this->subfleetRepo->get();
    $aircrafts = $this->aircraftRepo->select('id', 'name', 'registration', 'icao')->get();
    $allspecs = Disposable_Specs::get();
    $specs = null;

    if($request->input('editsp')) {
      $specs = Disposable_Specs::where('id', $request->input('editsp'))->first();
      if(!$specs)
      {
        Flash::error('Record Not Found !');
        return redirect(route('DisposableTech.techadmin'));
      }
    }

    return view('DisposableTech::admin_acspecs',[
      'subfleets' => $subfleets,
      'aircrafts' => $aircrafts,
      'allspecs'  => $allspecs,
      'specs'     => $specs,
    ]);
  }

  // Add Specs
  public function dtstorespecs(Request $request) {

    if($request->active == 1) { 
      $active = 1; 
    } else { 
      $active = 0; 
    }

    if($request->aircraft_id == 0 && $request->subfleet_id == 0) {
      Flash::error('Nothing To Record !');
      return redirect(route('DisposableTech.techadmin'));
    }

    if(!$request->saircraft) {
      Flash::error('Name Field Is Required !');
      return redirect(route('DisposableTech.techadmin'));
    }

    if($request->aircraft_id != 0) { 
      $aircraft_id = $request->aircraft_id;
      $subfleet_id = null;
    } else {
      $aircraft_id = null;
      $subfleet_id = $request->subfleet_id;
    }

    // Create New Record
    Disposable_Specs::create([
      'aircraft_id' => $aircraft_id,
      'subfleet_id' => $subfleet_id,
      'bew'         => $request->bew,
      'dow'         => $request->dow,
      'mzfw'        => $request->mzfw,
      'mrw'         => $request->mrw,
      'mtow'        => $request->mtow,
      'mlw'         => $request->mlw,
      'mrange'      => $request->mrange,
      'mceiling'    => $request->mceiling,
      'mfuel'       => $request->mfuel,
      'mpax'        => $request->mpax,
      'mspeed'      => $request->mspeed,
      'cspeed'      => $request->cspeed,
      'cat'         => $request->cat,
      'equip'       => $request->equip,
      'transponder' => $request->transponder,
      'pbn'         => $request->pbn,
      'crew'        => $request->crew,
      'saircraft'   => $request->saircraft,
      'stitle'      => $request->stitle,
      'fuelfactor'  => $request->fuelfactor,
      'active'      => $active,
    ]);

    Flash::success('Specifications Recorded');
    return redirect(route('DisposableTech.dtacspecs'));
  }

  // Update Specs
  public function dtupdatespecs(Request $request) {

    if($request->active == 1) { 
      $active = 1; 
    } else { 
      $active = 0; 
    }

    if($request->aircraft_id == 0 && $request->subfleet_id == 0) {
      Flash::error('Nothing To Update !');
      return redirect(route('DisposableTech.techadmin'));
    }

    if(!$request->saircraft) {
      Flash::error('Name Field Is Required !');
      return redirect(route('DisposableTech.techadmin'));
    }

    if($request->aircraft_id != 0) { 
      $aircraft_id = $request->aircraft_id;
      $subfleet_id = null;
    } else {
      $aircraft_id = null;
      $subfleet_id = $request->subfleet_id;
    }

    // Get The Record And Update
    Disposable_Specs::where('id', $request->id)->update([
      'id'          => $request->id,
      'aircraft_id' => $aircraft_id,
      'subfleet_id' => $subfleet_id,
      'bew'         => $request->bew,
      'dow'         => $request->dow,
      'mzfw'        => $request->mzfw,
      'mrw'         => $request->mrw,
      'mtow'        => $request->mtow,
      'mlw'         => $request->mlw,
      'mrange'      => $request->mrange,
      'mceiling'    => $request->mceiling,
      'mfuel'       => $request->mfuel,
      'mpax'        => $request->mpax,
      'mspeed'      => $request->mspeed,
      'cspeed'      => $request->cspeed,
      'cat'         => $request->cat,
      'equip'       => $request->equip,
      'transponder' => $request->transponder,
      'pbn'         => $request->pbn,
      'crew'        => $request->crew,
      'saircraft'   => $request->saircraft,
      'stitle'      => $request->stitle,
      'fuelfactor'  => $request->fuelfactor,
      'active'      => $active,
    ]);

    Flash::success('Specifications Updated');
    return redirect(route('DisposableTech.dtacspecs'));
  }
}
