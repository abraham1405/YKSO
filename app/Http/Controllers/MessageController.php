<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MailController;
use App\Models\MessageInbox;

class MessageController extends Controller
{
    public function markAsRead($id)
    {
        $sessionUser = session('user');

        if (!$sessionUser) {
            return redirect()->route('login');
        }

        $message = MessageInbox::where('id', $id)
            ->where('receiver_id', $sessionUser['id'])
            ->first();

        if ($message) {
            $message->status = 'read';
            $message->save();
        }

        return redirect()->route('mailbox', ['view' => 'received']);
    }
}
