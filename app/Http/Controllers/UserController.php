<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // TASK: turn this SQL query into Eloquent
        // select * from users
        //   where email_verified_at is not null
        //   order by created_at desc
        //   limit 3

        $users = User::whereNotNull('email_verified_at') // replace this with Eloquent statement
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();

        return view('users.index', compact('users'));
    }

    public function show($userId)
    {
        $user = NULL; // TASK: find user by $userId or show "404 not found" page

        return view('users.show', compact('user'));
    }

    public function check_create($name, $email)
    {
        // TASK: find a user by $name and $email
        $user = User::where('name', $name)
                    ->where('email', $email)
                    ->first();

        //   if not found, create a user with $name, $email and random password
        if (!$user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt(str_random(10)),
            ]);
        }

        return view('users.show', compact('user'));
    }

    public function check_update($name, $email)
    {
        // TASK: find a user by $name
        $user = User::where('name', $name)->first();
        //   if not found, create a user with $name, $email and random password
        if(!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt(str_random(10)),
            ]);
            //updates email
        } else {
            $user->email = $request->email;
            $user->save();
        }


        return view('users.show', compact('user'));
    }

    public function destroy(Request $request)
    {
        // TASK: delete multiple users by their IDs
        // SQL: delete from users where id in ($request->users)
        // $request->users is an array of IDs, ex. [1, 2, 3]

        // Insert Eloquent statement here

        return redirect('/')->with('success', 'Users deleted');
    }

    public function only_active()
    {
        // TASK: That "active()" doesn't exist at the moment.
        //   Create this scope to filter "where email_verified_at is not null"
        $users = User::active()->get();

        return view('users.index', compact('users'));
    }

}
