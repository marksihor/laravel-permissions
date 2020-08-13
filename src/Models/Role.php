<?php

namespace MarksIhor\LaravelPermissions\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use Cachable;

    protected $guarded = ['id'];

    public function permissions()
    {
        return $this->belongsToMany('MarksIhor\LaravelPermissions\Models\Permission');
    }

    public function permissionsArray(): array
    {
        return $this->permissions->groupBy('group')->map(function ($item, $key) {
            return ['group' => $key, 'permissions' => $item->pluck('name')->toArray()];
        })->values()->toArray();
    }

    public function attachPermissions(array $permissions): void
    {
        $this->permissions()->syncWithoutDetaching($this->permissionsNamesToIds($permissions));
    }

    public function detachPermissions(array $permissions): void
    {
        $this->permissions()->detach($this->permissionsNamesToIds($permissions));
    }

    private function permissionsNamesToIds(array $permissions): array
    {
        return Permission::whereIn('name', $permissions)->select('id')->get()->pluck('id')->toArray();
    }

    public function getPermissionsArray(): array
    {
        return $this->permissions->pluck('name')->toArray();
    }

    public function getGroupedPermissionsArray(): array
    {
        return $this->permissions->groupBy('group')->map(function ($item, $key) {
            return ['group' => $key, 'permissions' => $item->pluck('name')->toArray()];
        })->values()->toArray();
    }

    public function hasPermission(string $permission): bool
    {
        return boolval($this->permissions->where('name', $permission)->count());
    }
}