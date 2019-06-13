<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('leaderboard',compact('leaders'));
    }

    public function profile(){
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function profileEditView(){
        $user = Auth::user();
        $name = $user->name;
        $email = $user->email;
        $formNumbers = [1,2,3,4,5,6,7,8,9,10,11];
        $formLetters = ['А','Б','В','Г','Д','Е','Ж','З','И','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц'];
        list($userFormNumber,$userFormLetter) = explode("-", $user->form);
        return view('edit_profile',compact('name','email','formNumbers','formLetters','userFormNumber','userFormLetter'));
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
}
