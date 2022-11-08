<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

/**
 * 验证短信控制其
 */
class VerificationCodesController extends Controller
{
    /**
     * 发送
     */
    public function store()
    {
        return response()->json(['test_message' => 'store verification code']);
    }
}
