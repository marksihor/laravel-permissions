<?php

namespace MarksIhor\LaravelPermissions\Traits;

class Permissions
{
    public function getPermissionsArray(): array
    {
        return $this->role->permissions->pluck('name')->toArray();
    }

    public function getGroupedPermissionsArray(): array
    {
        return $this->role->groupedPermissionsArray();
    }

    public function hasPermission(string $permission): bool
    {
        return boolval($this->role->permissions->where('name', $permission)->count());
    }
}