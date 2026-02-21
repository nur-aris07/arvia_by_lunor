<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
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

    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'        => 'required|string',
            'password'  => [
                'required',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()->max(15),
            ],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error', 'Validasi gagal, silakan cek kembali input.')->withInput();
        }
        
        $user = User::where('id', Crypt::decryptString($request->id))->first();
        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }
        return $this->handleDatabase(function() use ($user, $request) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }, 'Berhasil Memperbarui Password User.');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'unique:users,email', 'max:150'],
            'phone'     => ['nullable', 'string', 'max:20'],
            'role'      => ['required', 'string', 'in:admin,user'],
            'password'  => [
                'required',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()->max(15)
            ],
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with('error', 'Validasi gagal, silakan cek kembali input.')
                ->withInput();
        }

        return $this->handleDatabase(function() use ($request) {
            User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'password'  => Hash::make($request->password),
                'role'      => $request->role,
            ]);            
        }, 'Berhasil Menambahkan User Baru.');
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'    => ['required','string'],
            'name'  => ['required','string','max:100'],
            'email' => ['required','email','max:150'],
            'phone' => ['nullable','string','max:20'],
            'role'  => ['required','string'],
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with('error', 'Validasi gagal, silakan cek kembali input.')
                ->withInput();
        }

        try {
            $userId = Crypt::decryptString($request->id);
        } catch (DecryptException $e) {
            return back()
                ->with('error', 'ID user tidak valid.')
                ->withInput();
        }
        $user = User::find($userId);
        if (!$user) {
            return back()
                ->with('error', 'User tidak ditemukan.')
                ->withInput();
        }

        $emailValidator = Validator::make($request->all(), [
            'email' => [
                Rule::unique('users','email')->ignore($userId),
            ],
        ]);
        if ($emailValidator->fails()) {
            return back()
                ->withErrors($emailValidator)
                ->with('error', 'Email sudah digunakan user lain.')
                ->withInput();
        }

        return $this->handleDatabase(function() use ($user, $request) {
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role'  => $request->role,
            ]);
        }, 'Data user berhasil diupdate.');
    }

    public function destroy($id) {
        try {
            $user = User::where('id', Crypt::decryptString($id))->firstOrfail();
            $user->delete();
            return back()->with('success', 'Berhasil Menghapus Data User');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal Menghapus Data User');
        }
        
    }

    function temp() {
        $users = User::paginate(5);
        return view('users.temp', compact('users'));
    }
}
