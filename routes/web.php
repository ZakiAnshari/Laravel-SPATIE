<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('give-permission-to-role', function(){

    $role = Role::findOrFail(3); 

    $permission1 = Permission::findOrFail(1);
    $permission2 = Permission::findOrFail(2);
    $permission3 = Permission::findOrFail(3);

    $role->givePermissionTo([$permission1, $permission2, $permission3]);
});

Route::get('assign-role-to-user', function()
{

    $user = User::create([
        'name' => 'user multiple role',
        'email' => 'user@gmail.com',
        'password' => '$2y$10$d05PSBtklcydqAAgAZlbt.Rv/9AbLgNC4wM.FoQk40xqzDezOo/iK'
    ]);

    $role1 = Role::findOrFail(1); //author
    $role2 = Role::findOrFail(2); //author
    $role3 = Role::findOrFail(3); //author

    $user->assignRole([ $role1, $role2, $role3]);

});

Route::get('spatie-method', function(){
    $user = User::findOrFail(1);
    dd( $user-> getPermissionNames());
});

// ///////////////////INI CARA DEFAULT middleware............//

$user = User::findOrFail(1); // 1 masukk sebagai zaki(create)
                            // 2 masuk sebagai gilang (editor)
                            // 3 masuk sebagai nanda (moderator)
Auth::login($user);



Route::get('create-article', function(){
    dd('Ini adalah fitur CREATE article . hanya bisa di akses oleh aothor atau moderator');
})->middleware('can:create article');

Route::get('edit-article', function(){
    dd('Ini adalah fitur EDIT article . hanya bisa di akses oleh editor atau moderator');
})->middleware('can:edit article');

Route::get('delete-article', function(){
    dd('Ini adalah fitur DELETE article . hanya bisa di akses oleh moderator');
})->middleware('can:delete article');

