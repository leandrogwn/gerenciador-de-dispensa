<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LogsController extends Controller
{
    public function alteracoes(Request $request)
    {
        $identity_id = Auth::user()->identity_id;

        $request->filled('dataInicial') ? $start = Carbon::parse($request->dataInicial)->format('Y-m-d 00:00:00') : $start = Carbon::minValue()->format('Y-m-d 00:00:00');
        $request->filled('dataFinal') ? $end = Carbon::parse($request->dataFinal)->format('Y-m-d 23:59:59') : $end = Carbon::now()->format('Y-m-d 23:59:59');

        $logs = DB::table('users')
            ->join('logs', 'logs.id_user', '=', 'users.id')
            ->havingBetween('logs.created_at', [$start, $end])
            ->select(['logs.*', 'users.name'])->where([
            ['logs.identity_id', 'LIKE', "{$identity_id}"],
            ['logs.alteracao', 'LIKE', "%{$request->pesquisar}%"]
        ])->orderByDesc('logs.id')->paginate();

        return view('log.logs')->with('logs', $logs);
    }
}
