<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function SendMessages(Request $request)
    {

        Message::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'content' => $request->content
        ]);

        return true;
    }
    public function LoadChat(Request $request)
    {
        $id = $request->id;
        $current_user_id = Auth::user()->id;

        $messages = Message::where(function ($query) use ($current_user_id, $id) {
            $query->where('sender_id', $current_user_id)
                ->where('receiver_id', $id);
        })
            ->orWhere(function ($query) use ($current_user_id, $id) {
                $query->where('sender_id', $id)
                    ->where('receiver_id', $current_user_id);
            })
            ->orderByDesc('id')
            ->get();

        $output = '';
        foreach ($messages as $message) {
            $output .= '<span class="bg-body-secondary mb-3 py-2 px-2" style="width:fit-content !important; border-radius:10px;">
            <small class="fw-bold">' . $message->sender->name . '</small>
            <p class="mb-0">' . $message->content . '</p>
            <small>' . $message->created_at->diffForHumans() . '</small>
        </span>';
        }

        return $output;
    }

}
