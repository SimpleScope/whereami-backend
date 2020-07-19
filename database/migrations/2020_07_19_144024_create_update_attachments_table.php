<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('update_attachments', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['image', 'video']);
            $table->foreignId('challenge_update_id')->constrained('challenges_updates');
            $table->text('lint');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('update_attachments');
    }
}
