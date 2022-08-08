<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apply_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users");
            $table->unsignedBigInteger("type_of_leave_id");
            $table->foreign("type_of_leave_id")->references("id")->on("type_of_leaves");
            $table->string("from");
            $table->string("to");
            $table->string("subject");
            $table->text("details");
            $table->tinyInteger("approved_by_manager")->default(0);
            $table->tinyInteger("approved_by_administration")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apply_leaves');
    }
};
