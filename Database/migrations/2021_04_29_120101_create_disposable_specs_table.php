<?php

use App\Contracts\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposableSpecsTable extends Migration
{
  public function up()
  {
    if (Schema::hasTable('turksim_specs')) {
      // Drop Indexes : for MariaDB compatibility
      Schema::table('turksim_specs', function (Blueprint $table) {
        $table->dropIndex('turksim_specs_id_index');
        $table->dropUnique('turksim_specs_id_unique');
      });
      // Rename Table
      Schema::rename('turksim_specs', 'disposable_specs');
      // Add Indexes Back
      Schema::table('disposable_specs', function (Blueprint $table) {
        $table->index('id');
        $table->unique('id');
      });
    } else {
      // Create Disposable Specs Table
      Schema::create('disposable_specs', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('aircraft_id')->nullable();
        $table->unsignedInteger('subfleet_id')->nullable();
        $table->string('saircraft', 50);
        $table->string('stitle',30)->nullable();
        $table->string('bew', 6)->nullable();
        $table->string('dow', 6)->nullable();
        $table->string('mzfw', 6)->nullable();
        $table->string('mrw', 6)->nullable();
        $table->string('mtow', 6)->nullable();
        $table->string('mlw', 6)->nullable();
        $table->string('mrange', 5)->nullable();
        $table->string('mceiling', 5)->nullable();
        $table->string('mfuel', 6)->nullable();
        $table->string('fuelfactor',3)->nullable();
        $table->string('mpax', 6)->nullable();
        $table->string('mspeed', 4)->nullable();
        $table->string('cspeed', 4)->nullable();
        $table->string('cat', 1)->nullable();
        $table->string('equip', 30)->nullable();
        $table->string('transponder', 10)->nullable();
        $table->string('pbn', 30)->nullable();
        $table->string('crew', 2)->nullable();
        $table->boolean('active')->nullable()->default(false);
        $table->timestamps();
        $table->index('id');
        $table->unique('id');
      });
    }
  }

  public function down()
  {
    Schema::dropIfExists('disposable_specs');
  }
}
