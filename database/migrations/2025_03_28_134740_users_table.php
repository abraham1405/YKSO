<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role');
            $table->string('photo')->nullable();
            $table->timestamps();
        });

        User::create([
            'name'=>'Aaron_admin',
            'email'=>'aaroncito.loayza@gmail.com',
            'password'=>Hash::make('1234'),
            'role'=>'admin',
            'photo'=>'/user/aaron.jpg'
        ]);

        User::create([
            'name'=>'Abraham_admin',
            'email'=>'abrahamZavala@YKSO.com',
            'password'=>Hash::make('1234'),
            'role'=>'admin',
            'photo'=>'/user/abraham.jpg'
        ]);

        User::create([
            'name'=>'Jessy_admin',
            'email'=>'jessyMaradiaga@YKSO.com',
            'password'=>Hash::make('1234'),
            'role'=>'admin',
            'photo'=>'/user/jessy.jpg'
        ]);

        User::create([
            'name'=>'Abraham_Empleado',
            'email'=>'test@gmail.com',
            'password'=>Hash::make('1234'),
            'role'=>'empleado',
            'photo'=>'/user/abraham.jpg'
        ]);

        User::create([
            'name'=>'Jessy_Empleada',
            'email'=>'test2@gmail.com',
            'password'=>Hash::make('1234'),
            'role'=>'empleado',
            'photo'=>'/user/jessy.jpg'
        ]);

        User::create([
            'name'=>'Aaron_Empleado',
            'email'=>'test3@gmail.com',
            'password'=>Hash::make('1234'),
            'role'=>'empleado',
            'photo'=>'/user/aaron.jpg'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
