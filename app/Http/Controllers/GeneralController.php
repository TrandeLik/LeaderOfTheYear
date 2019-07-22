<?php

namespace App\Http\Controllers;
use App\Achievement;
use App\User;
use App\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Filesystem\Filesystem;

class GeneralController extends Controller
{
    public function index()
    {
        $users = User::all() -> where('role', 'student');
        foreach ($users as $user){
            $count = $user -> confirmedScore();
            $user -> score = $count;
        }
        $leaders = $users -> sortByDesc('score');
        $awardedPercentage = Setting::where('name','Процент призеров')->value('value');
        $winnerPercentage = Setting::where('name','Процент победителей')->value('value');
        return view('general.leaderboard',compact('leaders','awardedPercentage','winnerPercentage'));
    }
    
    public function downloadConfirmation($id){
        $achievement = Achievement::findOrFail($id);
        if (($achievement->user->id == Auth::user()-> id) or (Auth::user()->role == 'admin') or (Auth::user()->role == 'superadmin')){
            $pathToFile = storage_path('confirmations') . '/' . $achievement->confirmation;
            return response()->download($pathToFile);
        } else {
            return redirect('/user');
        }
    }
    public function profile(){
        $user = Auth::user();
        return view('general.profile', compact('user'));
    }

    public function profileEditView(){
        $user = Auth::user();
        $name = $user->name;
        $email = $user->email;
        $role = $user->role;
        $formNumbers = [1,2,3,4,5,6,7,8,9,10,11];
        $formLetters = ['А','Б','В','Г','Д','Е','Ж','З','И','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц'];
        list($userFormNumber,$userFormLetter) = explode("-", $user->form);
        return view('general.editProfile',compact('name','email','formNumbers','formLetters','userFormNumber','userFormLetter','role'));
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
        return view('general.changePassword');
    }

    public function getAlertForBannedUsers(){
        Auth::logout();
        return view('general.alertForBannedUsers');
    }

    public function getAchievementsTable(){
        $achievements = Achievement::all()->where('status', 'confirmed');
        foreach ($achievements as $achievement){
            $achievement->aboutUser = $achievement->user;
        }
        return view('admin.table', compact('achievements'));
    }

    public function downloadAchievementTable($name){
        $pathToFile = storage_path('confirmations') . '/' . $name; // TODO узнать дерикторию, куда будут сохраняться файлы
        return response()->download($pathToFile);
    }

    public function importAchievementTable(Request $request){
        $file = new Filesystem;
        $file->cleanDirectory(storage_path('confirmations'));
        // TODO перенос данных и сохранение
        return '.gitignore';
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
