<?php

namespace App\Http\Controllers;

use App\Models\ChMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function fetchMessages(Request $request)
    {
        $userId = $request->id;
        $authId = Auth::id();

        $messages = ChMessage::where(function ($q) use ($authId, $userId) {
            $q->where('from_id', $authId)->where('to_id', $userId);
        })
            ->orWhere(function ($q) use ($authId, $userId) {
                $q->where('from_id', $userId)->where('to_id', $authId);
            })
            ->orderBy('created_at')
            ->get(['id', 'from_id', 'to_id', 'body', 'created_at']);

        return response()->json($messages);
    }
}
