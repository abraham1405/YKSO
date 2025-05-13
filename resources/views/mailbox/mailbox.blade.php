{{-- resources/views/mailbox/mailbox.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-lg navbar-light bg-light rounded shadow-sm mb-4">
            <a class="navbar-brand" href="#">Buzón</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{ request()->get('view') === null ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('mailbox') }}">Enviar Mensaje</a>
                    </li>
                    <li class="nav-item {{ request()->get('view') === 'received' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('mailbox', ['view' => 'received']) }}">Recibidos</a>
                    </li>
                    <li class="nav-item {{ request()->get('view') === 'sent' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('mailbox', ['view' => 'sent']) }}">Enviados</a>
                    </li>
                    <li class="nav-item {{ request()->get('view') === 'read' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('mailbox', ['view' => 'read']) }}">Leídos</a>
                    </li>
                </ul>
            </div>
        </nav>

       @if (request()->get('view') === 'received')
        <h4>Mensajes No Leídos</h4>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>De</th>
                    <th>Asunto</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($unreadMessages as $message)
                    <tr>
                        <td>{{ $message->sender->name }} ({{ $message->sender->email }})</td>
                        <td>{{ $message->subject }}</td>
                        <td>{{ $message->body }}</td>
                        <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <form action="{{ route('mark_as_read', $message->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-sm">Marcar como leído</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">No tienes mensajes nuevos.</td></tr>
                @endforelse
            </tbody>
        </table>

        @elseif (request()->get('view') === 'sent')
            <h4>Mensajes Enviados</h4>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Para</th>
                        <th>Asunto</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sentMessages as $message)
                        <tr>
                            <td>{{ $message->receiver->name }} ({{ $message->receiver->email }})</td>
                            <td>{{ $message->subject }}</td>
                            <td>{{ $message->body }}</td>
                            <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No has enviado mensajes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        @elseif (request()->get('view') === 'read')
            <h4>Mensajes Leídos</h4>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>De</th>
                        <th>Asunto</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($readMessages as $message)
                        <tr>
                            <td>{{ $message->sender->name }} ({{ $message->sender->email }})</td>
                            <td>{{ $message->subject }}</td>
                            <td>{{ $message->body }}</td>
                            <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">No tienes mensajes leídos.</td></tr>
                    @endforelse
                </tbody>
            </table>

        @else
            {{-- Formulario --}}
            <h4>Enviar Mensaje</h4>
            <form action="{{ route('send_mail') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="receiver_id">Selecciona el destinatario:</label>
                    <select name="receiver_id" class="form-control" required>
                        <option value="" disabled selected>Selecciona un usuario</option>
                        @foreach($users as $user)
                            @if($user->id !== session('user')['id'])
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="subject">Asunto:</label>
                    <input type="text" name="subject" class="form-control" placeholder="Asunto del mensaje" required>
                </div>

                <div class="form-group mb-3">
                    <label for="body">Mensaje:</label>
                    <textarea name="body" class="form-control" rows="5" required></textarea>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        @endif
    </div>
@endsection