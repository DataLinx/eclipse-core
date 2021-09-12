<?php

namespace Ocelot\Core\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Ocelot\Core\DataGrids\UsersGrid;
use Ocelot\Core\Framework\Output;
use Ocelot\Core\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $grid = new UsersGrid();

        return view('core::users.index', [
            'grid' => $grid,
        ]);
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
     * @param \Illuminate\Http\Request $request
     * @param Output $output
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
        return view('core::users.edit', [
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
     * @param \Ocelot\Core\Models\User $user
     * @param Output $output
     * @return array
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
     * @param Request $request
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
