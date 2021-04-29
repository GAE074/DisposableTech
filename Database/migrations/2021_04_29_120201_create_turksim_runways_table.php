<?php

use App\Contracts\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposableRunwaysTable extends Migration
{
  public function up()
  {
    if (Schema::hasTable('turksim_runways')) {
      // Rename TurkSim Runways Table
      Schema::rename('turksim_runways', 'disposable_runways');

    } else {
      // Create Disposable Runways Table
      Schema::create('disposable_runways', function (Blueprint $table) {
        $table->increments('id');
        $table->string('airport', 5);
        $table->string('runway_ident', 3);
        $table->string('lat', 12);
        $table->string('lon', 12);
        $table->string('heading', 3);
        $table->string('lenght', 5);
        $table->string('ils_freq', 7)->nullable();
        $table->string('loc_course', 3)->nullable();
        $table->string('airac', 4)->nullable();
        $table->timestamps();
        $table->index('id');
        $table->unique('id');
      });
    }
  }

  public function down()
  {
    Schema::dropIfExists('disposable_runways');
  }
}
