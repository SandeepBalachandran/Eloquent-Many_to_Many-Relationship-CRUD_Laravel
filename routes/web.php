<?php

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
use App\User;
use App\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/create',function()
{
    $user=User::findOrFail(1);
    $role=new Role(['name'=>'admin']);
    $result=$user->roles()->save($role);
    return $result;
});

Route::get('/create/{rolename?}',function($rolename)
{
    $user=User::findOrFail(1);
    $role=new Role(['name'=>$rolename]);
    $result=$user->roles()->save($role);
});


Route::get('/read',function()
{
    $user=User::findOrFail(1);
    foreach($user->roles as $role)
    {
        // dd($role);
        echo $role->name."<br>";  
    }
});


Route::get('/update',function()
{
    $user=User::findOrFail(1);  
    if($user->has('roles'))
    {
        foreach($user->roles as $role)
        {
            $role->name="edited rolename";
            $role->save();
        }
    }

});



Route::get('/delete',function()
{
    $user=User::findOrFail(1);
    $user->roles()->delete();
});



Route::get('/delete/{id?}',function($id)
{
    $user=User::findOrFail(1);
//    $result= $user->roles()->delete($id);
//    return $result;
    foreach($user->roles as $role)
    {
       $result= $role->whereId($id)->delete();
        
    }
    if($result)
    {
        echo "deleted succesfully";
    }
    else
    {
        echo "error deleting record";
    }
});