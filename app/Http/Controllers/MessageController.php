<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
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


    public function showChat()
    {
        return view('chat');
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
            $is_seen_class = ($message->seen == 1) ? 'bg-dark-subtle' : 'bg-body-secondary';
            $is_seen = ($message->seen == 1) ? '(Seen)' : '';
            $output .= '<span class="' . $is_seen_class . ' mb-3 py-2 px-2" style="width:fit-content !important; border-radius:10px;">
            <small class="fw-bold">' . $message->sender->name . '</small>
            <p class="mb-0">' . $message->content . '</p>
            <small>' . $message->created_at->diffForHumans() . ' '. $is_seen.'</small>
        </span>';
        }

        return $output;
    }
    public function GetRecentChat()
    {
        $current_user_id = Auth::user()->id;

        $recentChats = User::with([
            'receivedMessages' => function ($q) use ($current_user_id) {
                $q->where('sender_id', $current_user_id)
                    ->orWhere('receiver_id', $current_user_id);
            },
            'sentMessages' => function ($q) use ($current_user_id) {
                $q->where('sender_id', $current_user_id)
                    ->orWhere('receiver_id', $current_user_id);
            }
        ])
            ->where('id', '!=', $current_user_id)
            ->get();



        $output = '';

        if ($recentChats->isNotEmpty()) {
            foreach ($recentChats as $recentChat) {

                if ($recentChat->receivedMessages->isNotEmpty() || $recentChat->sentMessages->isNotEmpty()) {
                    $is_active = ($recentChat->is_active == 1) ? '<span class="badge text-bg-dark mx-2">Active</span>' : '';
                    $message_count = Message::where('receiver_id', $current_user_id)
                        ->where('sender_id', $recentChat->id)
                        ->where('seen', 0)
                        ->count();
                    $output .= '<div class="card mb-3">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <a href="' . route('chat', ['id' => $recentChat->id]) . '" class="text-black text-decoration-none">
                                        ' . $recentChat->name . '
                                    </a>
                                    <div>
                                    ' . $is_active . '
                                    <span class="bg-black text-white rounded-circle px-2">' . $message_count . '</span>
                                    </div>
                                </div>
                            </div>';
                }
            }
        }
        return $output;
    }

    public function SeenMessage(Request $request)
    {
        $current_user_id = Auth::user()->id;
        $receiver_id = $request->input('receiver_id');

        $messages = Message::where('receiver_id', $current_user_id)
            ->where('sender_id', $receiver_id)
            ->get();

        foreach ($messages as $message) {
            $message->update(['seen' => 1]); // Fix the update method syntax here
        }

        return response()->json(['status' => true, 'message' => 'Message seen successfully']);
    }
}
