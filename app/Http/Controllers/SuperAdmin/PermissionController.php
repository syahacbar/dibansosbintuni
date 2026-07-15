<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\PermissionRequest;
use App\Services\SuperAdmin\PermissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct(private readonly PermissionService $permissionService) {}

    public function index(Request $request): View
    {
        return view('super-admin.permissions.index', [
            'permissions' => $this->permissionService->paginate($request->string('search')->toString()),
            'search' => $request->string('search')->toString(),
        ]);
    }

    public function create(): View
    {
        return view('super-admin.permissions.form', [
            'permission' => null,
            'action' => route('super-admin.permissions.store'),
            'method' => 'POST',
        ]);
    }

    public function store(PermissionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['guard_name'] = $data['guard_name'] ?? 'web';
        $this->permissionService->create($data);

        return redirect()->route('super-admin.permissions.index')->with('success', 'Permission berhasil dibuat.');
    }

    public function show(Permission $permission): View
    {
        return view('super-admin.permissions.show', ['permission' => $permission]);
    }

    public function edit(Permission $permission): View
    {
        return view('super-admin.permissions.form', [
            'permission' => $permission,
            'action' => route('super-admin.permissions.update', $permission),
            'method' => 'PUT',
        ]);
    }

    public function update(PermissionRequest $request, Permission $permission): RedirectResponse
    {
        $data = $request->validated();
        $data['guard_name'] = $data['guard_name'] ?? $permission->guard_name;
        $this->permissionService->update($permission, $data);

        return redirect()->route('super-admin.permissions.index')->with('success', 'Permission berhasil diperbarui.');
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $this->permissionService->delete($permission);

        return redirect()->route('super-admin.permissions.index')->with('success', 'Permission berhasil dihapus.');
    }
}
