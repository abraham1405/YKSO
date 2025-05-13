<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('message_inboxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');     // ID del usuario que envía
            $table->unsignedBigInteger('receiver_id');   // ID del usuario que recibe
            $table->string('subject')->nullable();       // Asunto del mensaje
            $table->text('body');                        // Cuerpo del mensaje
            $table->boolean('is_read')->default(false);  // Si fue leído o no
            $table->string('status')->default('unread');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('MessageInbox');
    }
};
