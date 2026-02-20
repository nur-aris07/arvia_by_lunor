<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class TemplatesController extends Controller
{
    function index(Request $request) {
        if ($request->ajax()) {
            $status = $request->input('status');
            $search = trim((string) $request->input('search'));

            $query = Template::query();
            if ($status !== null && $status !== '') $query->where('is_active', $status);
            if ($search !== '') {
                $like = "%{$search}%";
                $query->where(function ($q) use ($like) {
                    $q->where('name', 'like', $like)
                        ->orWhere('description', 'like', $like);
                });
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('template', function($template) {
                    return view('templates.columns.template', compact('template'))->render();
                })
                ->orderColumn('template', function($query, $order) {
                    $query->orderBy('name', $order);
                })
                ->addColumn('status', function($template) {
                    return view('templates.columns.status', compact('template'))->render();
                })
                ->orderColumn('status', function($query, $order) {
                    $query->orderBy('is_active', $order);
                })
                ->addColumn('harga', function($template) {
                    return view('templates.columns.harga', compact('template'))->render();
                })
                ->orderColumn('harga', function($query, $order) {
                    $query->orderBy('price', $order);
                })
                ->addColumn('action', function($template) {
                    return view('templates.columns.action', compact('template'))->render();
                })
                ->rawColumns(['template', 'status', 'harga', 'action'])->make(true);
        }
        return view('templates.index');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:100',
            'slug'        => 'required|string|max:120',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'description' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error', 'Validasi Gagal, silakan cek kembali input.')->withInput();
        }

        $previewImage = null;
        if ($request->hasFile('image')) {
            $image     = $request->file('image');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);

            $previewImage = $imageName;
        }

        $template = Template::create([
            'name'          => $request->name,
            'slug'          => $request->slug,
            'price'         => $request->price,
            'preview_image' => $previewImage,
            'description'   => $request->description,
            'is_active'     => 1,
        ]);

        if ($template) {
            return back()->with('success', 'Berhasil Menambahkan Template Baru');
        } else {
            return back()->with('error', 'Gagal Menambahkan Template Baru');
        }
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'          => 'required|string',
            'name'        => 'required|string|max:100',
            'slug'        => 'required|string|max:120',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'description' => 'nullable|string',
            'status'      => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error', 'Validasi gagal, silakan cek kembali input.')->withInput();
        }

        $template = Template::where('id', Crypt::decryptString($request->id))->first();
        if (!$template) {
            return back()->with('error', 'Data Template Tidak Ditemukan');
        }

        $previewImage = $template->preview_image;
        if ($request->hasFile('image')) {
            if ($previewImage && file_exists(public_path('uploads/' . $previewImage))) {
                unlink(public_path('uploads/' . $previewImage));
            }

            $image     = $request->file('image');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $previewImage = $imageName;
        }

        $template->update([
            'name'          => $request->name,
            'slug'          => $request->slug,
            'price'         => $request->price,
            'preview_image' => $previewImage,
            'description'   => $request->description,
            'is_active'     => $request->status ,
        ]);

        if ($template) {
            return back()->with('success', 'Berhasil Memperbarui Data Template');
        } else {
            return back()->with('error', 'Gagal Memperbarui Data Template');
        }
    }

    public function destroy($id) {
        try {
            $template = Template::where('id', Crypt::decryptString($id))->firstOrfail();
            $template->delete();
            return back()->with('success', 'Berhasil Menghapus Template');
        } catch(Throwable $e) {
            return back()->with('error', 'Gagal Menghapus Template');
        }
    }

    public function temp() {}
}
