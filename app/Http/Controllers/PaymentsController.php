<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentsController extends Controller
{
    function index(Request $request) {
        if ($request->ajax()) {
            $method = $request->input('method');
            $search = trim((string) $request->input('search'));

            $query = Payment::query()->with(['invitation.user', 'invitation.template']);
            if ($method) $query->where('payment_method', $method);
            if ($search !== '') {
                $like = "%{$search}%";
                $query->where(function ($q) use ($like) {
                    $q->where('invoice_number', 'like', $like)
                        ->orWhere('notes', 'like', $like)
                        ->orWhereHas('invitation', fn($i) => $i->where('title', 'like', $like)->orWhere('slug', 'like', $like))
                        ->orWhereHas('invitation.user', fn($u) => $u->where('name', 'like', $like)->orWhere('email', 'like', $like))
                        ->orWhereHas('invitation.template', fn($t) => $t->where('name', 'like', $like));
                });
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('invoice', function($payment) {
                    return view('payments.columns.invoice', compact('payment'))->render();
                })
                ->orderColumn('invoice', fn($q, $order) => $q->orderBy('invoice_number', $order))
                ->addColumn('undangan', function($payment) {
                    return view('payments.columns.undangan', compact('payment'));
                })
                ->orderColumn('undangan', function($q, $order) {
                    $q->join('invitations', 'invitations.id', '=', 'payments.invitation_id')
                        ->orderBy('invitations.title', $order)
                        ->select('payments.*');
                })
                ->addColumn('user', fn($payment) => view('payments.columns.user', compact('payment'))->render())
                ->addColumn('method', fn($payment) => view('payments.columns.method', compact('payment'))->render())
                ->orderColumn('method', fn($q, $order) => $q->orderBy('payment_method', $order))

                ->addColumn('amount', fn($payment) => view('payments.columns.amount', compact('payment'))->render())
                ->orderColumn('amount', fn($q, $order) => $q->orderBy('amount', $order))

                ->addColumn('status', fn($payment) => view('payments.columns.status', compact('payment'))->render())
                ->orderColumn('status', fn($q, $order) => $q->orderBy('paid_at', $order))

                ->addColumn('waktu', fn($payment) => view('payments.columns.waktu', compact('payment'))->render())
                ->orderColumn('waktu', fn($q, $order) => $q->orderBy('created_at', $order))
                ->addColumn('action', function($payment) {
                    return view('payments.columns.action', compact('payment'))->render();
                })
                ->rawColumns(['invoice','undangan','user','method','amount','status','waktu','action'])
                ->make(true);
        }
        return view('payments.index');
    }

    public function store(Request $request) {}

    public function update(Request $request) {}

    public function destroy($id) {}

    public function stats() {}

    public function temp() {}
}
