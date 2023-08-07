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
        //
        Schema::create('blog_shares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_id'); // Unsigned big integer to reference blogs.id
            $table->unsignedBigInteger('shared_by'); // Unsigned big integer to reference users.id
            $table->unsignedBigInteger('shared_to'); // Unsigned big integer to reference users.id
            $table->timestamps();

            // Set up foreign keys
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->foreign('shared_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shared_to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('blog_shares');
    }
};
