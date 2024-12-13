<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Branches;
use App\Messages;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HomeController extends CommonController
{
    /**
     * Return the index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        return $this->view('home.overview');
    }

    /**
     * Save the notes.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postNotes(Request $request)
    {
        $user = User::findOrFail(Auth::user()['id']);
        $user->notes = $request->notes;
        $user->save();
        $request->session()->flash('success', 'Notes saved.');
        return redirect('/');
    }

    /**
     * Return the profile page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUser()
    {
        return $this->view('home.user');
    }

    /**
     * Save user profile.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postUser(Request $request)
    {
        // Validate
        $user = User::findOrFail(Auth::user()['id']);
        if($request->input('email') == $user->email) {
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
        $user->email = $request->input('email');
        $user->job = $request->input('job');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->address = $request->input('address');
        if ($contactChange) {
            $user->contact = $request->contact;
        }
        if ($passChange) {
            $user->password = bcrypt($request->password);
        }
        if ($avatarChange) {
            $user->avatar = '/' . $destinationPath . '/' . $fileName;
        }
        $save = $user->save();
        if ($save) {
            if (!$passChange) {
                $request->session()->flash('success', 'Profile edited successfully. If you changed your e-mail, please use the new one to sign in next time.');
                return redirect('/user');
            } else {
                $request->session()->flash('success', 'Profile and password edited. Please sign in to re-validate your session.');
                Auth::logout();
                return redirect('/auth/login');
            }
        }
    }

    /**
     * List messages.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getMessages()
    {
        $user = User::findOrFail(Auth::user()['id']);
        $messages = DB::table('messages')
            ->join('users', 'users.id', '=', 'messages.sender')
            ->select('messages.*', 'users.first_name as sender_fname', 'users.last_name as sender_lname', 'users.email as sender_email', 'users.avatar as sender_avatar')
            ->where('messages.recipient', $user->id)
            ->whereNull('messages.deleted_at')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return $this->view('home.messages', ['messages' => $messages]);
    }

    /**
     * Delete a message.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteMessage(Request $request, $id)
    {
        $user = User::findOrFail(Auth::user()['id']);

        // Check if user owns this message
        $message = Messages::findOrFail($id);
        if ($user->id != $message->recipient) {
            $request->session()->flash('error', 'You are not allowed to perform that action.');
            return redirect('/messages');
        }

        // Delete
        $message->delete();
        $request->session()->flash('success', 'Message deleted.');
        return redirect('/messages');
    }

    /**
     * Generate the "compose message" view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newMessage()
    {
        // Get Recipients
        $recipients = User::all();
        return $this->view('home.message-new', ['recipients' => $recipients]);
    }

    /**
     * Send message.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postMessage(Request $request)
    {
        $user = User::findOrFail(Auth::user()['id']);
        // Are there attachments?
        $uploadedFiles = "";
        // Count attachments
        if ( (count($request->attachments) == 1) && (empty($request->attachments[0])) ) {
            $attach = false;
        } else {
            // Determine time sent (for file structure)
            $time_sent = time();
            $attach = true;
            $files = Input::file('attachments');
            $file_count = count($files);
            $uploadcount = 0;
            foreach ($files as $file) {
                $rules = array('attachments' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,zip,7z,rar,xls,docx,xlsx,ppt,pptx');
                $validator = Validator::make(array('attachments'=> $file), $rules);
                if ($validator->passes()) {
                    $destinationPath = 'data/attachments/' . $time_sent;
                    if(!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    $filename = $file->getClientOriginalName();
                    $upload_success = $file->move($destinationPath, $filename);
                    if ($uploadedFiles == "") {
                        // First entry
                        $uploadedFiles = "/" . $destinationPath . "/" . $filename;
                    } else {
                        // Not the first
                        $uploadedFiles .= "|/" . $destinationPath . "/" . $filename;
                    }
                    $uploadcount++;
                } else {
                    $request->session()->flash('error', 'Your attached files do not meet the file type requirement.');
                    return redirect('/messages/new')->withInput();
                }
            }
            if ($uploadcount != $file_count) {
                // Upload failed
                $request->session()->flash('error', 'There was an error uploading your attachments.');
                return redirect('/messages/new')-withInput();
            }
        }

        // Send
        $message = new Messages; // I know, grammar. I can get over it, why can't you?
        $message->sender = $user->id; // This is me.
        $message->recipient = $request->recipient;
        $message->subject = $request->subject;
        $message->message = $request->message;
        $message->unread = true;
        $message->attachments = $uploadedFiles;
        $message->save();

        $request->session()->flash('success', 'Message sent.');
        return redirect('/messages');
    }

    public function viewMessage(Request $request, $id)
    {
        $user = User::findOrFail(Auth::user()['id']);

        // Check if user owns this message
        $message = Messages::findOrFail($id);
        if ($user->id != $message->recipient) {
            $request->session()->flash('error', 'You are not allowed to perform that action.');
            return redirect('/messages');
        }

        // Mark as read
        $message->unread = false;
        $message->save();

        // Sender info
        $sender = User::findOrFail($message->sender);

        return $this->view('home.message-view', ['message' => $message, 'sender' => $sender, 'attachments' => explode('|', $message->attachments)]);
    }
}
