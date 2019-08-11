<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\User;
use App\Setting;
use App\Comment;
use App\AchievementType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Excel;
use App\Exports\AchievementTypesExport;
use App\Imports\AchievementTypesImport;
use App\Exports\LeadersExport;
use App\Exports\SortedAchievementsExport;
use Illuminate\Filesystem\Filesystem;



class AdminController extends Controller // TODO погуглить, как сделать так, чтобы каждый день в восемь утра срабатывала функция, которая при кол-ве заявок больше 5 сообщала об этом админам
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(\App\Http\Middleware\CheckAdmin::class);
    }

    public function addType(Request $request){
        $request->validate([
            'category' => 'required',
            'type' => 'required',
            'stage' => 'required',
            'result' => 'required',
            'score' => 'required',
        ]);
      $newType = new AchievementType();
      $newType -> category = $request -> category;
      $newType -> type = $request -> type;
      $newType -> stage = $request -> stage;
      $newType -> result = $request -> result;
      $newType -> score = $request -> score;
      $newType -> save();
      return redirect('/admin');
    }

    public function exportLeaderboard() 
    {
        return Excel::download(new LeadersExport, 'leaders.xlsx');
    }

    public function uploadAchievementTypesFile(Request $request){
        if ($request -> has('file')) {
            $mimeTypes = [
                'application/vnd.ms-excel',
                'application/vnd.ms-office',
                'application/vnd-xls',
                'application/vnd.ms-excel',
                'application/msexcel',
                'application/x-msexcel',
                'application/x-ms-excel',
                'application/x-excel',
                'application/excel',
                'application/x-dos_ms_excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/xls',
                'application/x-xls',
            ];
            if (in_array(request()->file->getClientMimeType(), $mimeTypes)) {
                AchievementType::truncate();
                Excel::import(new AchievementTypesImport,request()->file);
            } else {
                $error = 'Данный тип файлов загрузить нельзя :(';
                return view('general.error', compact('error'));
            }
        }
        return redirect(url()->previous());
    }

    public function downloadAchievementTypesFile(){
        return Excel::download(new AchievementTypesExport, 'achievementTypes.xlsx');
    }
    
    public function showAddType(){
        $achievementTypes = AchievementType::all();
        $categories = AchievementType::select('category')->distinct()->get();
        $types = AchievementType::select('type')->distinct()->get();
        $stages = AchievementType::select('stage')->distinct()->get();
        $results = AchievementType::select('result')->distinct()->get();
        return view('admin/addAchievementType', compact('stages', 'results','categories', 'types','achievementTypes'));
    }

    public function deleteAchievementType($id){
        $type = AchievementType::findOrFail($id);
        $type -> delete();
        return redirect(url()->previous());
    }

    public function getEditTypeView($id){
        $thisType = AchievementType::findOrFail($id);
        $achievementTypes = AchievementType::all();
        $categories = AchievementType::select('category')->distinct()->get();
        $types = AchievementType::select('type')->distinct()->get();
        $stages = AchievementType::select('stage')->distinct()->get();
        $results = AchievementType::select('result')->distinct()->get();
        return view('admin/editAchievementType', compact('stages', 'results','categories', 'types','achievementTypes', 'thisType'));
    }

    public function editAchievementType($id, Request $request){
        $request->validate([
            'category' => 'required',
            'type' => 'required',
            'stage' => 'required',
            'result' => 'required',
            'score' => 'required',
        ]);
        $type = AchievementType::findOrFail($id);
        $type -> category = $request -> category;
        $type -> type = $request -> type;
        $type -> stage = $request -> stage;
        $type -> result = $request -> result;
        $type -> score = $request -> score;
        $type -> save();
        return redirect('/all_achievement_types');
    }

    public function index(){
        $allTypes = AchievementType::all() ->take(5);
        $sentAchievements = Achievement::all() -> where('status', 'sent')->take(5);
        $students = User::all()-> where('role', 'student') ->take(10);
        return view('admin/admin', compact('sentAchievements', 'students', 'allTypes'));
    }

    public function getAllSentAchievements(){
        $sentAchievements = Achievement::all() -> where('status', 'sent');
        return view('admin/allSentAchievements', compact('sentAchievements'));
    }

    public function getAllUsers(){
        $users = User::all()->where('role', '!=','superadmin');
        return view('admin/allUsers', compact('users'));
    }

    public function getAllAchievementTypes(){
        $types = AchievementType::all();
        return view('admin/allAchievementTypes', compact('types'));
    }

    public function showBannedUsers(){
        $bannedUsers = User::all() -> where('role', 'banned');
        return view('admin/bannedUsers', compact('bannedUsers'));
    }

    public function aboutUser($id){
        $user = User::findOrFail($id);
        if (($user->role!='admin') and ($user->role!='superadmin')){
            $place = $user -> place();
            $userAchievements = $user -> achievements -> where('status', '!=', 'created');
            $achievements = [];
            foreach ($userAchievements as $achievement){
                $newAchievement=(object)[];
                $newAchievement->student = $achievement->user->name;
                $newAchievement->form = $achievement->user->form;
                $newAchievement->category = $achievement->category;
                $newAchievement->type = $achievement->type;
                $newAchievement->name = $achievement->name;
                $newAchievement->subject = $achievement->subject;
                $newAchievement->stage = $achievement->stage;
                $newAchievement->result = $achievement->result;
                $newAchievement->date = $achievement->date;
                $newAchievement->confirmation = $achievement->confirmation;
                $newAchievement->comments = $achievement->comments;
                $newAchievement->score = $achievement->score;
                switch ($achievement->status){
                    case 'created':
                        $newAchievement->status = 'Созданные, но не отправленные';
                        break;
                    case 'sent':
                        $newAchievement->status = 'Отправленные, но не проверенные';
                        break;
                    case 'rejected':
                        $newAchievement->status = 'Отклоненные';
                        break;
                    case 'confirmed':
                        $newAchievement->status = 'Проверенные';
                        break;
                }
                $newAchievement->id = $achievement->id;
                $achievements[] = $newAchievement;
            }
            return view('admin/profile', compact('user', 'place', 'achievements', 'userAchievements'));
        } else {
            return redirect(url()->previous());
        }
        
    }

    public function ban($id){ // TODO сообщение пользователю о том, что его заблокировали
        $user = User::findOrFail($id);
        if (((Auth::user()->role == 'superadmin')||($user -> role != 'admin')) && ($user -> role != 'superadmin')) {
            $user -> role = 'banned';
            $user -> save();
        }
        return redirect(url() -> previous());
    }

    public function promote($id){ // TODO сообщение пользователю о том, что его повысили
        $user = User::findOrFail($id);
        if ($user -> role != 'superadmin'){
            $user -> role = 'admin';
            $user -> save();
        } else {
            $error = 'Данного пользвателя нельзя повысить :)';
            return view('general.error', compact('error'));
        }
        return redirect(url() -> previous());
    }

    public function degrade($id){ // TODO сообщение пользователю о том, что его понизили
        $user = User::findOrFail($id);
        if (($user -> role != 'superadmin') && ($user -> role != 'student')){
            $user -> role = 'student';
            $user -> save();
        } else {
            $error = 'Данного пользователя нельзя понизить :)';
            return view('general.error', compact('error'));
        }
        return redirect(url() -> previous());
    }

    public function unblock($id){ // TODO сообщение пользователю о том, что его разблокировали
        $user = User::findOrFail($id);
        if (($user -> role != 'admin') && ($user -> role != 'superadmin'))  {
            $user -> role = 'student';
            $user -> save();
        } else {
            $error = 'Данного пользователя нельзя разблокировать';
            return view('general.error', compact('error'));
        }
        return redirect(url() -> previous());
    }

    public function reject($id, Request $request){ // TODO сообщение пользователю о том, что его достижение отклонили
        $achievement = Achievement::findOrFail($id);
        $achievement -> status = 'rejected';
        $achievement -> save();
        if (isset($request->comment)){
            $comment = new Comment;
            $comment->achievement_id = $id;
            $comment->text = $request->comment;
            $comment->author = 'admin';
            $comment->save();
        }
        return redirect(url()->previous());
    }

    public function confirm($id){ // TODO сообщение пользователю о том, что его достижение одобрили
        $achievement = Achievement::findOrFail($id);
        $achievement -> status = 'confirmed';
        $achievement -> save();
        return redirect(url()->previous());
    }

    public function settingsView(){
        $settings = Setting::all();
        $categories = AchievementType::select('category')->distinct()->get();
        return view('admin.settings', compact('settings', 'categories'));
    }

    public function settingsUpdate(Request $request){
        $settings = Setting::all();
        foreach ($settings as $setting){
            if (($setting->type=='on/off') and (empty($request->input($setting->id)))){ // ToDo сообщение о том, что раздел включили/отключили
                $setting->value = 'off';
            } else {
                $setting->value = $request->input($setting->id);
            }
            $setting->save();
        }
        return redirect(url()->previous());
    }

    public function getAchievementsTable(){
        
        $allAchievements = Achievement::all()->where('status', '!=', 'created');
        $achievements = [];
        foreach ($allAchievements as $achievement){
            $newAchievement=(object)[];
            switch ($achievement->status){
                case 'created':
                    $newAchievement->status = 'Созданные, но не отправленные';
                    break;
                case 'sent':
                    $newAchievement->status = 'Отправленные, но не проверенные';
                    break;
                case 'rejected':
                    $newAchievement->status = 'Отклоненные';
                    break;
                case 'confirmed':
                    $newAchievement->status = 'Проверенные';
                    break;
            }
            $newAchievement->student = $achievement->user->name;
            $newAchievement->form = $achievement->user->form;
            $newAchievement->category = $achievement->category;
            $newAchievement->type = $achievement->type;
            $newAchievement->name = $achievement->name;
            $newAchievement->subject = $achievement->subject;
            $newAchievement->stage = $achievement->stage;
            $newAchievement->result = $achievement->result;
            $newAchievement->date = $achievement->date;
            $newAchievement->confirmation = $achievement->confirmation;
            $newAchievement->result = $achievement->result;
            $newAchievement->score = $achievement->score;
            $newAchievement->id = $achievement->id;
            $newAchievement->comments = $achievement->comments;
            $achievements[] = $newAchievement;
        }
        return view('admin.table', compact('achievements'));
    }

    public function downloadAchievementTable($name){
        $pathToFile = storage_path('sorted_achievements') . '/' . $name;
        return response()->download($pathToFile);
    }

    public function exportAchievementTable(Request $request){
        $file = new Filesystem;
        $file->cleanDirectory(storage_path('sorted_achievements'));
        $achievements = $request->table;        
        $filters = $request->columns;
        Excel::store(new SortedAchievementsExport($achievements,$filters),'sortedAchievements.xlsx','mydisk');
        return 'sortedAchievements.xlsx';
    }

    public function deleteSelected(Request $request){
        $achievementTypes = AchievementType::all();
        foreach ($achievementTypes as $achievementType){
            if ($request->input($achievementType->id)=='on'){
                $achievementType->delete();
            }
        }
        return redirect('/achievement_types/all');
    }

    public function deleteAll(){
        // TODO возможно(?) сообщение о том, что сбросили табличку с типами достижений
        AchievementType::truncate();
        return redirect('/achievement_types/all');
    }
}
