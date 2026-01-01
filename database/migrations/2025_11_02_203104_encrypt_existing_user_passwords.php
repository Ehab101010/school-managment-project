<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

return new class extends Migration
{
    public function up()
    {
        // تشفير كل كلمات المرور الموجودة
        User::all()->each(function($user) {
            if (!Hash::needsRehash($user->password)) {
                $user->password = Hash::make($user->password);
                $user->save();
            }
        });
    }

    public function down()
    {
        // لا يمكن التراجع عن هذا التغيير تلقائيًا
    }
};
