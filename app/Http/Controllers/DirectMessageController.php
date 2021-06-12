<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DirectMessage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Events\NewMessage;

class DirectMessageController extends Controller
{
    public function getMessages(Request $request, $userId)
    {
        $messages = DirectMessage::where('user_id_1', Auth::user()->id)->where('user_id_2', $userId);
        return DirectMessage::where('user_id_1', $userId)->where('user_id_2', Auth::user()->id)->union($messages)->OrderBy('created_at', 'ASC')->get();
    }

    public function getLastMessages(Request $request, $userId)
    {
        $messages = DirectMessage::where('user_id_1', Auth::user()->id)->where('user_id_2', $userId);
        return DirectMessage::where('user_id_1', $userId)->where('user_id_2', Auth::user()->id)->union($messages)->latest()->first();
    }

    public function newMessage(Request $request, $userId)
    {
        if ($request->message) {
            $newMessage = new DirectMessage;
            $newMessage->user_id_1 = Auth::user()->id;
            $newMessage->user_id_2 = $userId;
            $newMessage->message = $request->message;
            $newMessage->save();

            broadcast(new NewMessage($newMessage))->toOthers();

            return $newMessage;
        }
    }

    public function listUsers(Request $request)
    {
        return Auth::user()->friends()->where('accepted', true)->orderBy('name')->get();
    }
}
