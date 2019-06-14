<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GeneralController extends Controller
{
    public function index()
    {
        $leaders = [];
        $users = User::all()  -> where('role', 'student');
        foreach ($users as $user){
            $count = $user -> achievements -> where('status', 'confirmed') -> sum('score');
            $leaders[$user->name] = $count;
        }
        asort($leaders);
        return view('general/leaderboard',compact('leaders'));
    }

    public function profile(){
        $user = Auth::user();
        return view('general/profile', compact('user'));
    }

    public function profileEditView(){
        $user = Auth::user();
        $name = $user->name;
        $email = $user->email;
        $role = $user->role;
        $formNumbers = [1,2,3,4,5,6,7,8,9,10,11];
        $formLetters = ['А','Б','В','Г','Д','Е','Ж','З','И','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц'];
        list($userFormNumber,$userFormLetter) = explode("-", $user->form);
        return view('general/edit_profile',compact('name','email','formNumbers','formLetters','userFormNumber','userFormLetter','role'));
    }

    public function profileEdit(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'formNumber' => 'required',
            'formLetter' => 'required',
        ]);
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->form = $request->formNumber . '-' . $request->formLetter;
        $user->save();
        return redirect('/profile');
    }

    public function passwordChangeView(){
        return view('general/change_password');
    }

    public function getAlertForBannedUsers(){
        Auth::logout();
        return view('general/alertForBannedUsers');
    }

    public function passwordChange(Request $request){
        $request->validate([
            'old' => 'required',
            'new' => 'required',
            'confirm' => 'required',
        ]);
        $user = Auth::user();
        if (Hash::check($request->old, $user->password)) {
            if ($request->new==$request->confirm){
                $user->password = Hash::make($request->new);
                $user->save();
                return redirect('/profile');
            } else {
                return redirect('/profile/password_change');
            }
        } else {
            return redirect('/profile/password_change');
        }
        
    }
}