<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangeUserRoleRequest;
use App\Models\Role;
use App\Models\Transport;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function users(User $user, Role $role)
    {
        $roles = $role->getAllRoles();
        $users = $user->getAllUsers();
        return view('admin.users')
            ->with([
                'users' => $users,
                'roles' => $roles
            ]);
    }

    public function changeRole(ChangeUserRoleRequest $request)
    {
        $user = User::find($request->get('user_id'));

        if ($user->role_id == 4) {
            $transport = Transport::where('user_id', '=', $user->id)->first();
            $transport->delete();
        }

        if ($request->get('role_id') == 4) {
            Transport::create([
                "user_id" => $user->id,
                "capacity" => 10.0
            ]);
        }
        $user->role_id = $request->get('role_id');
        $user->save();
        return "Должность успешно изменена!";
    }
}
