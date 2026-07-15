<?php

namespace App\Services\SuperAdmin;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function paginate(?string $search = null): LengthAwarePaginator
    {
        return Role::query()
            ->with('permissions')
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function create(array $data): Role
    {
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);

        $role = Role::create($data);
        $role->syncPermissions($permissions);

        return $role;
    }

    public function update(Role $role, array $data): Role
    {
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);

        $role->update($data);
        $role->syncPermissions($permissions);

        return $role->refresh();
    }

    public function delete(Role $role): void
    {
        $role->delete();
    }
}
