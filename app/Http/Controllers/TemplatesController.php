<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TemplatesController extends Controller
{
    function index(Request $request) {
        if ($request->ajax()) {
            $status = $request->input('status');
            $search = trim((string) $request->input('search'));

            $query = Template::query();
            if ($status) $query->where('is_active', $status);
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

    public function store(Request $request) {}

    public function update(Request $request) {}

    public function destroy($id) {}

    public function temp() {}
}
