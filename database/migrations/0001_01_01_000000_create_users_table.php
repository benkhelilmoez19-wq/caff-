<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // MODIFIÉ : email limité à 191 pour éviter l'erreur de longueur d'index
            $table->string('email', 191)->unique(); 
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            $table->string('phone')->nullable();
            // CORRIGÉ : Passé en 'address' (string) pour correspondre au Seeder et au Modèle User
            $table->string('address')->nullable(); 
            $table->enum('role', ['client', 'admin'])->default('client');
            
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            // MODIFIÉ : email limité à 191 car il est défini comme PRIMARY KEY
            $table->string('email', 191)->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            // MODIFIÉ : id limité à 191 car il est défini comme PRIMARY KEY
            $table->string('id', 191)->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};