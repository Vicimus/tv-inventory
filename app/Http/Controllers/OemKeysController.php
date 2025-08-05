<?php

namespace App\Http\Controllers;

class OemKeysController extends Controller
{
    public function index(string $slug)
    {
        $key = config("oem.$slug.key") ?? null;

        if (!$key) {
            abort(404, 'OEM not found.');
        }

        $color = config("oem.$slug.color") ?? '#FFF';

        return view('carousel', compact('key', 'color'));
    }
}
