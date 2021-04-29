<?php

namespace Modules\DisposableTech\Http\Controllers;

use App\Contracts\Controller;

class TechAdminController extends Controller
{
  // Admin Page
  public function dtadmin()
  {
    return view('DisposableTech::admin');
  }

}
