<?php

namespace Ocelot\Core\Http\Controllers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ocelot\Core\Models\User;
use Illuminate\Http\Request;

class UsersController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('core::users/index', [
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('core::users/edit', [
            'user' => new User,
            'action' => url('users'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if (request('action') === 'cancel') {
            return redirect('users');
        }

        User::create($this->validateRequest($request), true);

        return redirect('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Ocelot\Core\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Ocelot\Core\Models\User  $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('core::users/edit', [
            'user' => $user,
            'action' => url("users/{$user->id}"),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Ocelot\Core\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, User $user)
    {
        if (request('action') === 'cancel') {
            return redirect('users');
        }

        $user->update($this->validateRequest($request));

        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Ocelot\Core\Models\User  $user
     * @return array
     */
    public function destroy(User $user)
    {
        $user->delete();

        return [
            'error' => 0,
        ];
    }

    /**
     * Validate the request
     *
     * @param Request $request
     * @return array
     */
    protected function validateRequest(Request $request, $is_new = false)
    {
        $rules = [
            'name' => 'required|max:100',
            'surname' => 'required|max:100',
            'email' => 'required|email|max:100',
        ];

        if ($is_new or $request->get('password')) {
            $rules['password'] = 'required|min:6';
        }

        $data = $request->validate($rules);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }
}
