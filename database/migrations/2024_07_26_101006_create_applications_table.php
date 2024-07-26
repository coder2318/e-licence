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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('status')->default(0);
            $table->string('name');
            $table->string('address');
            $table->string('tin');
            $table->string('phone');
            $table->text('bank_requisite');
            $table->string('brand_name');
            $table->text('mxik');
            $table->string('contract_details');
            $table->text('manufactured_countries');
            $table->text('official_documents');
            $table->text('at_least_country_documents');
            $table->text('retail_documents');
            $table->text('rent_building_documents');
            $table->text('distributor_documents');
            $table->text('website_documents');
            $table->text('reason_rejected')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
