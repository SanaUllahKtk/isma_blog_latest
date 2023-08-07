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
        Schema::create('blog_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_id'); // Unsigned big integer to reference blogs.id
            $table->string('ip_address'); // Unsigned big integer to reference users.id
            $table->timestamps();

            // Set up foreign keys
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
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
        Schema::dropIfExists('blog_views');
    }
};
