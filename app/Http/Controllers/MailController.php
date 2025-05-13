<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MessageInbox;
use Illuminate\Support\Facades\Auth;

class MailController extends Controller
{
    private $sessionUser;
    public function mailbox(Request $request)
    {
        $sessionUser = session('user');

        if (!$sessionUser) {
            return view('auth.login', ['error' => 'Debes iniciar sesión para acceder al buzón']);
        }

        $users = User::all();
        $unreadMessages = [];
        $readMessages = [];
        $sentMessages = [];

        if ($request->get('view') === 'received') {
            $unreadMessages = MessageInbox::with('sender')
                ->where('receiver_id', $sessionUser['id'])
                ->where('status', '!=', 'read')
                ->orderByDesc('created_at')
                ->get();
        }

        if ($request->get('view') === 'read') {
            $readMessages = MessageInbox::with('sender')
                ->where('receiver_id', $sessionUser['id'])
                ->where('status', 'read')
                ->orderByDesc('created_at')
                ->get();
        }

        if ($request->get('view') === 'sent') {
            $sentMessages = MessageInbox::with('receiver')
                ->where('sender_id', $sessionUser['id'])
                ->orderByDesc('created_at')
                ->get();
        }

        return view('mailbox.mailbox', compact('users', 'unreadMessages', 'readMessages', 'sentMessages'));
    }


    public function send(Request $request)
    {
        // Validación de los datos del formulario
        $this->sessionUser = session('user');
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Verifica si el usuario está autenticado
        if ($this->sessionUser) {
            MessageInbox::create([
                'sender_id' => $this->sessionUser['id'],
                'receiver_id' => $request->receiver_id,
                'subject' => $request->subject,
                'body' => $request->body,
                'is_read' => false,
            ]);

            return redirect()->route('mailbox')->with('ok_alert', 'Mensaje enviado correctamente.');
        }

        return redirect()->route('login')->with('error', 'Debes iniciar sesión para enviar un mensaje');
    }
}
