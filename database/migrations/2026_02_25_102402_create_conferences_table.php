<?php

use App\Enums\Region;
use App\Models\Venue;
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
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->string('name',60);
            $table->text('description');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->tinyInteger('status')->comment('0: upcoming, 1: ongoing, 2: completed');
            $table->string('region')->default(Region::US->value);
            $table->foreignIdFor(Venue::class)->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conferences');
    }
};
