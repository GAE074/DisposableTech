@extends('admin.app')
@section('title', 'Disposable Tech Specs and Runways')

@section('content')
  <div class="card border-blue-bottom" style="margin-left:5px; margin-right:5px; margin-bottom:5px;">
    <div class="content">
      <p>
        This module is designed to provide aircraft technical specs and runway information, mainly for SimBrief usage.
        <br>
        And there are no standalone frontend views/pages. Information provided will blend in SimBrief form if you are using Disposable Theme 
        and aircraft/subfleet specifications can be shown in aircraft details page too
      </p>
      <p>&nbsp;</p>
      <p>
        If you need to customize the layouts according to your template please copy relevant blade files from <b>modules\ModuleName\Resources\views</b> 
        to a folder under your theme folder named <b>modules\ModuleName</b> (case sensitive) and edit files there</p>
      <p>
        Example Source: <b>phpvms root\Modules\DisposableTech\Resources\views\specs_table.blade.php</b> * Do Not Edit Source Files, so you can update easily<br>
        Example 1 Target: <b>phpvms root\Resources\views\layouts\default\modules\DisposableTech\specs_table.blade.php</b><br>
        Example 2 Target: <b>phpvms root\Resources\views\layouts\Disposable_v2\modules\DisposableTech\specs_table.blade.php</b>
      </p>
      <p>&nbsp;</p>
      <p>Module Developed by <a href="https://github.com/FatihKoz" target="_blank">B.Fatih KOZ</a> &copy; 2021</p>
    </div>
  </div>

  <div class="row text-center" style="margin-left:5px; margin-right:5px;">
    <div class="col-sm-12">
        <h4 style="margin:5px;"><b>Admin Functions</b></h4><hr>
      <div class="col-sm-3">
        {{-- Intentionally Left Blank --}}
      </div>
      <div class="col-sm-6">
        <div class="card border-blue-bottom" style="padding:10px;">
            <a href="{{ route('DisposableTech.dtacspecs')}}">Define Aircraft or SubFleet Specs</a>
            <br><br>
            Specs will be shown at Aircraft details and Subfleet listing pages, also they may be used for SimBrief Flight planning.
        </div>
      </div>
      <div class="col-sm-3">
        {{-- Intentionally Left Blank --}}
      </div>
    </div>
  </div>
@endsection
