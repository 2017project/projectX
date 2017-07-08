<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class TestController extends Controller {
    public function test1(Request $request) {
        $a = $request->input('a');
        $b = $request->input('b');

        $result = [
            'c' => $a,
            'd' => $b
        ];
        
        return response()->json($result, 200);
    }
}