<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    //  index all roles
    public function index()
    {
        $roles = Role::all();
        if ($roles) {
            return response()->json(
                ['roles' => $roles],
                200
            );
        }
        return response()->json(
            ['message' => 'no roles found'],
            404
        );
    }

    //  seed roles
    public function seedRoles()
    {
        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
    }

    /*  allow the user with the manager role to have the
         ability to promote or demote another user*/
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id !== 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $updated_user = User::where('name', $request->name)
            ->where('father_name', $request->father_name)
            ->first();

        if (!$updated_user) {
            return response()->json(
                ['erorr' => 'user not found!'],
                404
            );
        }

        $updated_user->role_id = $request->new_role_id;
        $updated_user->save();

        return response()->json(
            ['message' => 'user role updated succesfully!'],
            200
        );
    }
}
