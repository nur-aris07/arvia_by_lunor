<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    function index(Request $request) {
        if ($request->ajax()) {
            $role   = $request->input('role');
            $search = trim((string) $request->input('search'));
            
            $query = User::query();
            if ($role) $query->where('role', $role);
            if ($search !== '') {
                $escaped = addcslashes($search, "\\%_");
                $like = "%{$escaped}%";
                $query->where(function ($q) use ($like) {
                    $q->where('name', 'like', $like)
                        ->orWhere('email', 'like', $like);
                });
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('user', function($user) {
                    return view('users.columns.user', compact('user'))->render();
                })
                ->orderColumn('user', function ($query, $order) {
                    $query->orderBy('name', $order);
                })
                ->addColumn('contact', function($user) {
                    return view('users.columns.contact', compact('user'))->render();
                })
                ->orderColumn('contact', function ($query, $order) {
                    $query->orderBy('email', $order);
                })
                ->addColumn('role', function($user) {
                    return view('users.columns.role', compact('user'))->render();
                })
                ->orderColumn('role', function ($query, $order) {
                    $query->orderBy('role', $order);
                })
                ->addColumn('action', function($user) {
                    return view('users.columns.action', compact('user'))->render();
                })
                ->rawColumns(['user', 'contact', 'role', 'action'])
                ->make(true);
        }
        return view('users.index');
    }

    function temp() {
        $users = User::paginate(5);
        return view('users.temp', compact('users'));
    }
}
