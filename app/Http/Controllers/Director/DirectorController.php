<?php

namespace App\Http\Controllers\Director;

use App\Http\Controllers\Controller;
use App\Http\Requests\Director\ChangeUserRoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class DirectorController extends Controller
{

    public function users(User $user, Role $role)
    {
        $users = $user->getAllUsersWithoutDirectors();
        $roles = $role->getAllRolesWithoutDirector();
        return view('director.users')
            ->with([
               'users' => $users,
               'roles' => $roles
            ]);
    }

    public function changeRole(ChangeUserRoleRequest $request)
    {
        $user = User::find($request->get('user_id'));
        $user->role_id = $request->get('role_id');
        $user->save();
        return "Должность успешно изменена!";
    }

}
