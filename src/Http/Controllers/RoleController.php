<?php

namespace MarksIhor\LaravelPermissions\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MarksIhor\LaravelPermissions\Models\Permission;
use MarksIhor\LaravelPermissions\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        if (config('roles.pagination')) {
            $collection = $this->filter(Role::query())->paginate(request()->input('per_page'));
        } else {
            $collection = $this->filter(Role::query())->get();
        }

        return response()->json(['data' => $collection], 200);
    }

    public function show(int $roleId)
    {
        $model = Role::findOrFail($roleId);
        return response()->json(['data' => $model], 200);
    }

    public function rolePermissionsGrouped(int $roleId)
    {
        $model = Role::findOrFail($roleId);
        return response()->json(['data' => $model->getGroupedPermissionsArray()], 200);
    }

    public function rolePermissions(int $roleId)
    {
        $model = Role::findOrFail($roleId);
        return response()->json(['data' => $model->permissions->pluck('name')], 200);
    }

    public function permissions()
    {
        $collection = Permission::all('name')->pluck('name');
        return response()->json(['data' => $collection], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'unique:roles,name']
        ]);

        $model = Role::create($validated);

        return response()->json(['data' => $model], 200);
    }

    public function update(int $roleId, Request $request)
    {
        $model = Role::findOrFail($roleId);
        $validated = $request->validate([
            'name' => ['required', 'unique:roles,name,' . $model->id]
        ]);

        $model->update($validated);

        return response()->json(['data' => $model], 200);
    }

    public function delete(int $roleId)
    {
        $model = Role::findOrFail($roleId);
        if ($systemRoles = config('roles.system_roles')) {
            if (in_array($roleId, $systemRoles)) {
                return response()->json(['error' => 'Cannot delete system role.', 'code' => 403], 403);
            }
        }
        try {
            if (\DB::table('users')->where('role_id', $roleId)->count()) {
                return response()->json(['error' => 'Cannot delete the role. There are users that are using it.', 'code' => 403], 403);
            }
        } catch (\Exception $exception) {
            \Log::info($exception->getMessage());
        }

        $model->permissions()->detach();
        $model->delete();

        return response()->json(['data' => $model], 200);
    }

    public function updatePermissions(Request $request, int $roleId, string $type)
    {
        $model = Role::findOrFail($roleId);
        $validated = $request->validate([
            'permissions' => ['array'],
            'permissions.*' => ['string', 'max:256', 'min:3']
        ]);

        $permissions = $validated['permissions'] ?? [];

        if ($type === 'attach') {
            $model->attachPermissions($permissions);
        } elseif ($type === 'detach') {
            $model->detachPermissions($permissions);
        } elseif ($type === 'update') {
            $model->updatePermissions($permissions);
        }

        return response()->json(['data' => $model->getGroupedPermissionsArray()], 200);
    }
}