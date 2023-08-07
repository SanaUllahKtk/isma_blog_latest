<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CommitteeMember;
use App\Http\Controllers\Controller;
use App\DataTables\CommitteeMemberDataTable;

class CommitteeMemberController extends Controller
{
    public function index(CommitteeMemberDataTable $table)
    {
        $pageConfigs = ['has_table' => true];
        return $table->render('content.tables.committee-member', compact('pageConfigs'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
        ]);

        CommitteeMember::create([
            'name' => $request->name,
            'designation' => $request->designation,
        ]);

        return response()->json([
            'message' => 'Committee Member created successfully',
            'status' => 'success',
            'table' => 'committee-member-table'
        ]);
    }


    public function delete($id)
    {
        $committeeMember = CommitteeMember::findOrFail($id);

        $committeeMember->delete();

        return response()->json([
            'message' => 'Committee Member deleted successfully',
            'status' => 'success',
            'table' => 'committee-member-table'
        ]);
    }
}
