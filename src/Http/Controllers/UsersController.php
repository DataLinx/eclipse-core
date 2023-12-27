<?php

namespace Eclipse\Core\Http\Controllers;

use Eclipse\Core\Foundation\Http\Controllers\AbstractController;
use Eclipse\Core\Framework\Output;
use Eclipse\Core\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends AbstractController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('core::users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('core::users.edit', [
            'user' => new User,
            'action' => url('users'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, Output $output)
    {
        if (request('action') === 'cancel') {
            return redirect('users');
        }

        User::create($this->validateRequest($request), true);

        $output->toast(_('User created'))->success();

        return redirect('users');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('core::users.edit', [
            'user' => $user,
            'action' => url("users/{$user->id}"),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, User $user, Output $output)
    {
        if (request('action') === 'cancel') {
            return redirect('users');
        }

        if ($request->delete_image) {
            $user->deleteImage();
        }

        $user->update($this->validateRequest($request));

        $output->toast(_('User updated'))->success();

        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return array
     *
     * @throws \Exception
     */
    public function destroy(User $user, Output $output)
    {
        $user->delete();

        $output->toast(_('User deleted'));

        return [
            'error' => 0,
        ];
    }

    /**
     * Validate the request
     *
     * @return array
     */
    protected function validateRequest(Request $request, $is_new = false)
    {
        $rules = [
            'name' => 'required|max:100',
            'surname' => 'required|max:100',
            'email' => 'required|email|max:100',
            'image' => 'image',
        ];

        if ($is_new or $request->get('password')) {
            $rules['password'] = 'required|min:6';
        }

        $data = $request->validate($rules);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        unset($data['image']); // At the moment, I have no idea how to validate an input without fetching it to the data array

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $data['image'] = $image->store('storage/images/users');
            }
        }

        return $data;
    }
}
