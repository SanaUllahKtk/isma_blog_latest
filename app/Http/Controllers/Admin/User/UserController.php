<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use App\Helpers\Helper;
use App\Mail\User\Password;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(UserDataTable $table)
    {
        $pageConfigs = ['has_table' => true,];
        //for filter use with
        // $table->with('id', 1);
        return $table->render('content.tables.users', compact('pageConfigs'));
    }




    public function status(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'status' => 'required|in:active,inactive',
        ]);

        User::where('id', $request->id)->update([
            'status' => $request->status,
        ]);

        return response(['status' => 'success', 'header' => "User Status Changed", 'message' => 'User status changed successfully.']);
    }
}
