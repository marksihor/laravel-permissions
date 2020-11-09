<?php

namespace MarksIhor\LaravelPermissions\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MarksIhor\LaravelPermissions\Models\Role as Model;

class RoleController extends Controller
{
    public function index()
    {
        $collection = Model::all();

        return response()->json(['data' => $collection], 200);
    }

    public function show(Model $model)
    {
        return response()->json(['data' => $model], 200);
    }

    public function permissions(Model $model)
    {
        return response()->json(['data' => $model->getGroupedPermissionsArray()], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'unique:roles,name']
        ]);

        $model = Model::create($validated);

        return response()->json(['data' => $model], 200);
    }

    public function update(Model $model, Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'unique:roles,name,' . $model->id]
        ]);

        $model->update($validated);

        return response()->json(['data' => $model], 200);
    }

    public function delete(Model $model)
    {
        $model->permissions()->detach();
        $model->delete();

        return response()->json(['data' => $model], 200);
    }

    public function updatePermissions(Request $request, Model $model, string $type)
    {
        $validated = $request->validate([
            'permissions' => ['required', 'array'],
            'permissions.*' => ['string', 'max:256', 'min:3']
        ]);

        $permissions = $validated['permissions'];

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
