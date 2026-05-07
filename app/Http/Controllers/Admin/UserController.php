<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $service) {}

    public function index(Request $request)
    {
        $users = $this->service->getAll($request->only('search'));
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['orders' => fn($q) => $q->with('product')->latest()->take(10)]);
        return view('admin.users.show', compact('user'));
    }

    public function create()
    {
        return view('admin.users.form');
    }

    public function store(UserRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $this->service->update($user, $request->validated());
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $this->service->delete($user);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
