<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InvitationsController extends Controller
{
    function index(Request $request) {
        if ($request->ajax()) {
            $status = $request->input('status');
            $payment = $request->input('payment');
            $search = trim((string) $request->input('search'));

            $query = Invitation::query()->with(['user', 'template']);
            if ($status) $query->where('status', $status);
            if ($payment) $query->where('payment_status', $payment);
            if ($search !== '') {
                $like = "%{$search}%";
                $query->where(function ($q) use ($like) {
                    $q->where('title', 'like', $like)
                        ->orWhere('slug', 'like', $like)
                        ->orWhereHas('user', fn($u) => $u->where('name', 'like', $like)->orWhere('email', 'like', $like))
                        ->orWhereHas('template', fn($t) => $t->where('name', 'like', $like));
                });
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('undangan', function($invitation) {
                    return view('invitations.columns.undangan', compact('invitation'))->render();
                })
                ->orderColumn('undangan', function($query, $order) {
                    $query->orderBy('title', $order);
                })
                ->addColumn('user', function($invitation) {
                    return view('invitations.columns.user', compact('invitation'))->render();
                })
                ->orderColumn('user', function($query, $order) {
                    $query->join('users as u', 'u.id', '=', 'invitations.user_id')
                        ->orderBy('u.name', $order)
                        ->select('invitations.*');
                })
                ->addColumn('template', function($invitation) {
                    return view('invitations.columns.template', compact('invitation'))->render();
                })
                ->orderColumn('template', function($query, $order) {
                    $query->join('templates as t', 't.id', '=', 'invitations.template_id')
                        ->orderBy('t.name', $order)
                        ->select('invitations.*');
                })
                ->addColumn('status', function($invitation) {
                    return view('invitations.columns.status', compact('invitation'))->render();
                })
                ->orderColumn('status', function($query, $order) {
                    $query->orderBy('status', $order);
                })
                ->addColumn('payment', function($invitation) {
                    return view('invitations.columns.payment', compact('invitation'))->render();
                })
                ->orderColumn('payment', function($query, $order) {
                    $query->orderBy('payment_status', $order);
                })
                ->addColumn('created', function($invitation) {
                    return view('invitations.columns.created', compact('invitation'))->render();
                })
                ->orderColumn('created', function($query, $order) {
                    $query->orderBy('created_at', $order);
                })
                ->addColumn('action', function($invitation) {
                    return view('invitations.columns.action', compact('invitation'))->render();
                })
                ->rawColumns(['undangan', 'user', 'template', 'status', 'payment', 'created', 'action'])
                ->make(true);
        }
        return view('invitations.index');
    }

    public function store(Request $request) {}

    public function update(Request $request) {}

    public function destroy($id) {}

    public function lookup(Request $request) {
        if (!$request->ajax()) abort(404);

        $type = $request->query('type');
        $q    = trim((string) $request->query('q', ''));

        if ($type === 'users') {
            $items = User::query()
                ->select(['id','name','email'])
                ->when($q !== '', function ($qq) use ($q) {
                    $like = "%{$q}%";
                    $qq->where(function ($w) use ($like) {
                        $w->where('name','like',$like)->orWhere('email','like',$like);
                    });
                })
                ->orderBy('name')
                ->limit(20)
                ->get()
                ->map(fn($u) => [
                    'id'    => $u->hash_id,
                    'label' => $u->name,
                    'meta'  => $u->email,
                ]);

            return response()->json($items);
        }

        if ($type === 'templates') {
            $items = Template::query()
                ->select(['id','name','price'])
                ->when($q !== '', function ($qq) use ($q) {
                    $like = "%{$q}%";
                    $qq->where('name','like',$like);
                })
                ->orderBy('name')
                ->limit(20)
                ->get()
                ->map(fn($t) => [
                    'id'    => $t->hash_id,
                    'label' => $t->name,
                    'meta'  => 'Rp '.number_format($t->price ?? 0, 0, ',', '.'),
                ]);

            return response()->json($items);
        }

        return response()->json([], 400);
    }

    public function stats() {
        $query = Invitation::query();
        $stats = $query->selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
            SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft,
            SUM(CASE WHEN status = 'archived' THEN 1 ELSE 0 END) as archived,
            SUM(CASE WHEN payment_status = 'unpaid' THEN 1 ELSE 0 END) as unpaid
        ")->first();

        return response()->json([
            'active'   => (int) $stats->active,
            'draft'    => (int) $stats->draft,
            'unpaid'   => (int) $stats->unpaid,
            'archived' => (int) $stats->archived,
        ]);
    }

    public function temp() {}
}
