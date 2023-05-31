<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Enum\ReviewStatus;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function(Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('email');
            $table->string('subject');
            $table->bigInteger('picture_id')->unsigned();
            $table->text('message');
            $table->tinyInteger('score')->default(1);
            $table->enum('status', [ReviewStatus::WaitingForApproval->value, ReviewStatus::Revoked->value, ReviewStatus::Published->value])->default(ReviewStatus::WaitingForApproval->value);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
