<?php

use App\Contracts\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add SimBrief Airframe ID To Disposable Specs table
 */
class UpdateDisposableSpecsTable extends Migration
{
  public function up()
  {
    Schema::table('disposable_specs', function (Blueprint $table) {
      $table->string('airframe_id', 50)->nullable()->after('subfleet_id');
    });
  }
}
