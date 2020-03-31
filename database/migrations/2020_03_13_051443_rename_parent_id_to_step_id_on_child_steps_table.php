<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameParentIdToStepIdOnChildStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('child_steps', function (Blueprint $table) {
            $table->renameColumn('parent_id', 'step_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('child_steps', function (Blueprint $table) {
            $table->renameColumn('step_id', 'parent_id');
        });
    }
}
