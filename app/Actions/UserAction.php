<?php

namespace App\Actions;

use App\Models\Doctor;
use Illuminate\Http\Request;

class UserAction
{
    public function __construct()
    {
        //
    }


    public function toggleLikeDoctorAction(Request $request)
    {

        $doctor = Doctor::find($request->doctor_id);
        $user = auth()->user();

        if ($user->has_liked($doctor)) {
            $user->unlike($doctor);
            return response()->json(['status' => 'unliked']);
        } else {
            $user->like($doctor);
            return response()->json(['status' => 'liked']);
        }
    }
}
