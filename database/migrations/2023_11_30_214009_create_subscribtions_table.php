<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable(false);
            $table->timestamp('date');
            $table->string('price');
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('service_id')->nullable(false);
            $table->timestamps();


            $table->foreign("user_id")->references('id')->on('users');
            $table->foreign("service_id")->references('id')->on('services');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['subscription_id']);
        });

        Schema::dropIfExists('subscriptions');
    }

};
