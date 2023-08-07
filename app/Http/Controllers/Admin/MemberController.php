<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use Illuminate\Http\Request;
use App\DataTables\MemberDataTable;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function index(MemberDataTable $table)
    {

        $pageConfigs = ['has_table' => true];
        return $table->render('content.tables.members', compact('pageConfigs'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Member::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Member created successfully',
            'status' => 'success',
            'table' => 'member-table'
        ]);
    }

    public function delete($id)
    {
        $member = Member::findOrFail($id);

        $member->delete();

        return response()->json([
            'message' => 'Member deleted successfully',
            'status' => 'success',
            'table' => 'member-table'
        ]);
    }
}
