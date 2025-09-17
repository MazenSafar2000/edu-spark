<?php

namespace App\Http\Controllers;

use App\Models\ChMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function fetchMessages(Request $request)
    {
        $userId  = Auth::id();      // المستخدم الحالي (teacher, student, parent, manager)
        $otherId = $request->id;    // المستخدم الآخر

        // هات كل الرسائل بين الاثنين
        $messages = ChMessage::where(function ($q) use ($userId, $otherId) {
            $q->where('from_id', $userId)->where('to_id', $otherId);
        })
            ->orWhere(function ($q) use ($userId, $otherId) {
                $q->where('from_id', $otherId)->where('to_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function markAsRead(Request $request)
    {
        ChMessage::where('from_id', $request->from_id)
            ->where('to_id', Auth::id())
            ->where('seen', 0)
            ->update(['seen' => 1]);

        return response()->json(['status' => 'ok']);
    }
}
