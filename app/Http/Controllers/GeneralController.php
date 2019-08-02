<?php

namespace App\Http\Controllers;
use App\Achievement;
use App\User;
use App\Setting;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Filesystem\Filesystem;

class GeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function error(){
        $error = 'Ой, вам сюда нельзя!';
        return view('general.error', compact('error'));
    }

    public function leaderboard(){
        $isLeaderBoardWorking = Setting::where('name', 'Рейтинговая таблица (для учеников)')->first()->value == 'on';
        $minimalAllowedScore = Setting::where('name', 'Минимальный порог баллов для участия')->first()->value;
        if (($isLeaderBoardWorking) or (Auth::user()->role == 'admin') or (Auth::user()->role == 'superadmin')) {
                $users = User::all()->where('role', 'student');
            foreach ($users as $user) {
                $count = $user->confirmedScore();
                $user->score = $count;
            }
            $showScore = Setting::where('name', 'Баллы в лидерборде')->first()->value == 'on';
            $showScore = ($showScore) or (Auth::user()->role == 'admin') or (Auth::user()->role == 'superadmin');
            $leaders = $users->sortByDesc('score');
            $awardedPercentage = Setting::where('name', 'Процент призеров')->value('value');
            $winnerPercentage = Setting::where('name', 'Процент победителей')->value('value');
            return view('general.leaderboard', compact('leaders', 'awardedPercentage', 'winnerPercentage', 'showScore','minimalAllowedScore'));
        } else{
            $error = 'Данная функция отключена';
            return view('general.error', compact('error'));
        }
    }
    
    public function downloadConfirmation($id){
        $achievement = Achievement::findOrFail($id);
        if (($achievement->user->id == Auth::user()-> id) or (Auth::user()->role == 'admin') or (Auth::user()->role == 'superadmin')){
            $pathToFile = storage_path('confirmations') . '/' . $achievement->confirmation;
            return response()->download($pathToFile);
        } else {
            $error = 'Ой-ой-ой, похоже, вы пытаетесь скачать не свою грамоту :(';
            return view('general.error', compact('error'));
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
        // ToDo сообщение о том, что профиль был изменен
        $request->validate([
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
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
        $error = '';
        return view('general.changePassword', compact('error'));
    }

    public function getAlertForBannedUsers(){
        Auth::logout();
        $error = 'Ой-ой-ой, похоже, ваша учетная запись заблокирована, обратитесь к администрации :(';
        return view('general.error', compact('error'));
    }

    public function passwordChange(Request $request){
        // ToDo сообщение, что пароль был измененм
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
                $error = 'Новый пароль не совпадает с подтверждением :(';
                return view('general.changePassword', compact('error'));
            }
        } else {
            $error = 'Старый пароль введен неправильно :(';
            return view('general.changePassword', compact('error'));
        }
    }

    public function achievementView($id){
        $comments = Comment::all()->where('achievement_id',$id);
        return view('general.achievement',compact('comments'));
    }
}
