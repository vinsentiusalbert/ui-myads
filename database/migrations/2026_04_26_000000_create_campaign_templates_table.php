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
        Schema::create('campaign_templates', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->string('template_type')->default('simple_message');
            $table->string('category')->default('Single Banner');
            $table->string('language')->default('Indonesia');
            $table->string('header_type')->default('none');
            $table->string('asset_path')->nullable();
            $table->text('body')->nullable();
            $table->string('footer', 60)->nullable();
            $table->json('buttons')->nullable();
            $table->string('status')->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_templates');
    }
};
