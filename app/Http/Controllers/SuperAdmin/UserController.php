<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\UserRequest;
use App\Models\User;
use App\Services\SuperAdmin\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    public function index(Request $request): View
    {
        return view('super-admin.users.index', [
            'users' => $this->userService->paginate($request->string('search')->toString()),
            'search' => $request->string('search')->toString(),
        ]);
    }

    public function create(): View
    {
        return view('super-admin.users.form', [
            'user' => null,
            'roles' => Role::orderBy('name')->get(),
            'action' => route('super-admin.users.store'),
            'method' => 'POST',
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $this->userService->create($request->validated());

        return redirect()->route('super-admin.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function show(User $user): View
    {
        return view('super-admin.users.show', ['user' => $user->load('roles')]);
    }

    public function edit(User $user): View
    {
        return view('super-admin.users.form', [
            'user' => $user->load('roles'),
            'roles' => Role::orderBy('name')->get(),
            'action' => route('super-admin.users.update', $user),
            'method' => 'PUT',
        ]);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $this->userService->update($user, $request->validated());

        return redirect()->route('super-admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_if($user->is(auth()->user()), 422, 'Tidak dapat menghapus akun sendiri.');

        $this->userService->delete($user);

        return redirect()->route('super-admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
