<?php

declare(strict_types=1);

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateCasbinRuleTable extends Migration
{
    public string $description = 'Create casbin_rule table for RBAC policies';

    public function up(): void
    {
        Schema::create('casbin_rule', function (Blueprint $table) {
            $table->id();
            $table->string('ptype', 12)->default('');
            $table->string('v0', 128)->default('');
            $table->string('v1', 128)->default('');
            $table->string('v2', 128)->nullable();
            $table->string('v3', 128)->nullable();
            $table->string('v4', 128)->nullable();
            $table->string('v5', 128)->nullable();

            $table->index('ptype');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('casbin_rule');
    }
}