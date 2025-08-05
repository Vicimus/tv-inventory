<?php

namespace App\Http\Controllers;

class OemKeysController extends Controller
{
    public function index(string $slug)
    {
        $oemKey = config("oem.$slug") ?? null;

        if (!$oemKey) {
            abort(404, 'OEM not found.');
        }

        return view('carousel', compact('oemKey'));
    }
}
