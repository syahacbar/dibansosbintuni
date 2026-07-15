<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\RoleRequest;
use App\Services\SuperAdmin\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(private readonly RoleService $roleService) {}

    public function index(Request $request): View
    {
        return view('super-admin.roles.index', [
            'roles' => $this->roleService->paginate($request->string('search')->toString()),
            'search' => $request->string('search')->toString(),
        ]);
    }

    public function create(): View
    {
        return view('super-admin.roles.form', [
            'role' => null,
            'permissions' => Permission::orderBy('name')->get(),
            'action' => route('super-admin.roles.store'),
            'method' => 'POST',
        ]);
    }

    public function store(RoleRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['guard_name'] = $data['guard_name'] ?? 'web';
        $this->roleService->create($data);

        return redirect()->route('super-admin.roles.index')->with('success', 'Role berhasil dibuat.');
    }

    public function show(Role $role): View
    {
        return view('super-admin.roles.show', ['role' => $role->load('permissions')]);
    }

    public function edit(Role $role): View
    {
        return view('super-admin.roles.form', [
            'role' => $role->load('permissions'),
            'permissions' => Permission::orderBy('name')->get(),
            'action' => route('super-admin.roles.update', $role),
            'method' => 'PUT',
        ]);
    }

    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $data = $request->validated();
        $data['guard_name'] = $data['guard_name'] ?? $role->guard_name;
        $this->roleService->update($role, $data);

        return redirect()->route('super-admin.roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $this->roleService->delete($role);

        return redirect()->route('super-admin.roles.index')->with('success', 'Role berhasil dihapus.');
    }
}
