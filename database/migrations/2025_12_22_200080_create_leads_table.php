<?php

use App\Enums\LeadStatus;
use App\Enums\PropertyType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('source_page')->nullable();
            $table->enum('property_type', array_column(PropertyType::cases(), 'value'));
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 50);
            $table->text('message');
            $table->enum('status', array_column(LeadStatus::cases(), 'value'))->default(LeadStatus::New->value);
            $table->json('utm_json')->nullable();
            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('source_page');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
