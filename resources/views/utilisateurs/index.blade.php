@extends('layouts.app')

@section('title', 'Utilisateurs')

@section('content')
<section class="panel">
    <div class="panel-header">
        <h2>Gestion des utilisateurs</h2>
        <a href="{{ route('utilisateurs.create') }}" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> Ajouter</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Nom</th><th>Email</th><th>Role</th><th>Date creation</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse($utilisateurs as $utilisateur)
                <tr>
                    <td>{{ $utilisateur->name }}</td><td>{{ $utilisateur->email }}</td><td><span class="badge text-bg-light">{{ $utilisateur->role }}</span></td><td>{{ $utilisateur->created_at->format('d/m/Y') }}</td>
                    <td class="text-end table-actions">
                        <a href="{{ route('utilisateurs.edit', $utilisateur) }}" class="btn btn-light btn-sm"><i class="fa-solid fa-pen"></i></a>
                        @if($utilisateur->id !== auth()->id())
                            <form method="POST" action="{{ route('utilisateurs.destroy', $utilisateur) }}" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Aucun utilisateur.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $utilisateurs->links() }}
</section>
@endsection
