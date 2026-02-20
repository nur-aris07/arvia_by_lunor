<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Throwable;

abstract class Controller
{
    protected function handleDatabase(callable $callback, $successMessage) {
        try {
            $callback();
            return back()->with('success', $successMessage);

        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Data sudah terdaftar (duplicate).');
            }
            return back()->with('error', 'Terjadi kesalahan database.');

        } catch (Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }
}
