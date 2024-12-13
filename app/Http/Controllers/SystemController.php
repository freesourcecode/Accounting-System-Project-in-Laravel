<?php

namespace App\Http\Controllers;

use App\User;
use App\Branches;
use App\Messages;
use App\Logs;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class SystemController extends CommonController
{
    /**
     * List users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUsers()
    {
        // Get a list of users
        $users = DB::table('users')
            ->join('branches', 'branches.id', '=', 'users.branch')
            ->select('users.*', 'branches.name as branch_name')
            ->paginate(10);
        return $this->view('system.users', ['users' => $users]);
    }

    /**
     * Display user registration view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newUser()
    {
        $branches = Branches::all();
        return $this->view('system.users-new', ['branches' => $branches]);
    }

    /**
     * Save user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addUser(Request $request)
    {
        // Validate
        $this->validate($request, [
            'email'     =>      "required|unique:users,email",
            'password'  =>      "required|confirmed"
        ]);

        // Process Addition
        // Is there an avatar uploaded?
        $avatarChange = false;
        if (!empty($request->image)) {
            $file = ['image' => Input::file('image')];
            $this->validate($request, [
                'image'     =>      'image'
            ]);
            if (Input::file('image')->isValid()) {
                $destinationPath = 'data/avatars';
                $extension = Input::file('image')->getClientOriginalExtension();
                $fileName = hash('sha256', time() . rand(111,999)) . '.' . $extension;
                Input::file('image')->move($destinationPath, $fileName);
                $avatarChange = true;
            } else {
                $request->session()->flash('error', 'Failed to upload image.');
                return redirect('/users/new');
            }
        }
        $addUser = new User;
        $addUser->email = $request->email;
        $addUser->password = bcrypt($request->password);
        $addUser->branch = $request->branch;
        $addUser->job = $request->job;
        $addUser->first_name = $request->first_name;
        $addUser->last_name = $request->last_name;
        $addUser->address = $request->address;
        $addUser->contact = $request->contact;
        if ($avatarChange) {
            $addUser->avatar = '/' . $destinationPath . '/' . $fileName;
        }

        // Generate a random confirmation code
        $confirmation_code = str_random(30);
        $addUser->confirmation_code = $confirmation_code;

        $addUser->save();

        // Send confirmation e-mail
        Mail::send('emails.userconfirm', ['user' => $request, 'code' => $confirmation_code], function ($m) use ($request) {
            $m->from('noreply@a-1driving.com', 'A-1 Driving - Accounting');

            $m->to($request->email, $request->first_name . $request->last_name)->subject('Confirm your E-mail Address');
        });

        $request->session()->flash('success', 'User ' . $request->email . ' added successfully. The user needs to confirm his e-mail before being able to sign in.');
        return redirect('/users');
    }

    /**
     * Suspends a user.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function suspendUser(Request $request, $id)
    {
        // Can't suspend user ID 1!
        if ($id == 1) {
            $request->session()->flash('error', 'Sorry, you are not allowed to suspend this user.');
            return redirect('/users');
        }
        // You can't suspend yourself!
        if ($id == Auth::user()['id']) {
            $request->session()->flash('error', 'You can\'t suspend yourself.');
            return redirect('/users');
        }
        User::findOrFail($id)->delete();

        $request->session()->flash('success', 'User suspended.');
        return redirect('/users');
    }

    /**
     * Unsuspends a user.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function unsuspendUser(Request $request, $id)
    {
        User::withTrashed()->find($id)->restore();
        $request->session()->flash('success', 'User activated.');
        return redirect('/users');
    }

    /**
     * Edit user page.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editUser(Request $request, $id)
    {
        if ($id == Auth::user()['id']) {
            // You're editing yourself.
            $request->session()->flash('success', 'You tried to edit your own profile. We redirected you instead to your own profile editor.');
            return redirect('/user');
        }
        $branches = Branches::all();
        $editUser = User::findOrFail($id);
        return $this->view('system.users-edit', ['id' => $id, 'branches' => $branches, 'editUser' => $editUser]);
    }

    public function saveEditedUser(Request $request)
    {
        $editedUser = User::findOrFail($request->id);
        if($request->input('email') == $editedUser->email) {
            $validate_email = "required";
        } else {
            $validate_email = "required|email|unique:users,email";
        }
        $this->validate($request, [
            'email'         =>      $validate_email,
            'job'           =>      "required|string",
            'first_name'    =>      "required|alpha",
            'last_name'     =>      "required|alpha",
            'address'       =>      "required"
        ]);

        // Was there a password change request?
        $passChange = false;
        if (!empty($request->password)) {
            $this->validate($request, [
                'password'      =>      'required|confirmed'
            ]);
            $passChange = true;
        }

        // Was the contact number filled up?
        $contactChange = false;
        if (!empty($request->contact)) {
            $this->validate($request, [
                'contact'        =>      'required|string'
            ]);
            $contactChange = true;
        }

        // Is there an avatar uploaded?
        $avatarChange = false;
        if (!empty($request->image)) {
            $file = ['image' => Input::file('image')];
            $this->validate($request, [
                'image'     =>      'image'
            ]);
            if (Input::file('image')->isValid()) {
                $destinationPath = 'data/avatars';
                $extension = Input::file('image')->getClientOriginalExtension();
                $fileName = hash('sha256', time() . rand(111,999)) . '.' . $extension;
                Input::file('image')->move($destinationPath, $fileName);
                $avatarChange = true;
            } else {
                Session::flash('error', 'Failed to upload image.');
                return redirect('/user');
            }
        }

        // Validations passed. Let's update!
        $editedUser->email = $request->input('email');
        $editedUser->job = $request->input('job');
        $editedUser->first_name = $request->input('first_name');
        $editedUser->last_name = $request->input('last_name');
        $editedUser->address = $request->input('address');
        if ($contactChange) {
            $editedUser->contact = $request->contact;
        }
        if ($passChange) {
            $editedUser->password = bcrypt($request->password);
        }
        if ($avatarChange) {
            $editedUser->avatar = '/' . $destinationPath . '/' . $fileName;
        }
        $save = $editedUser->save();
        if ($save) {
            $request->session()->flash('success', 'User edited successfully.');
            return redirect('/users');
        }
    }

    public function getLogs()
    {
        // We can't use the Eloquent model here. Pagination + join statements make it impossible.
        $logs = DB::table('logs')
            ->join('users', 'users.id', '=', 'logs.user')
            ->select('users.email', 'users.first_name', 'users.last_name', 'users.avatar', 'logs.*')
            ->paginate(10);
        return $this->view('system.logs', ['logs' => $logs]);
    }


}
