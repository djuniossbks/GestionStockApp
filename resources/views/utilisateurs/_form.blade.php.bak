@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nom</label>
        <input class="form-control" name="name" value="{{ old('name', $utilisateur->name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" value="{{ old('email', $utilisateur->email ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Mot de passe</label>
        <input class="form-control" type="password" name="password" @if(!isset($utilisateur)) required @endif>
    </div>
    <div class="col-md-6">
        <label class="form-label">Confirmation</label>
        <input class="form-control" type="password" name="password_confirmation" @if(!isset($utilisateur)) required @endif>
    </div>
    <div class="col-md-4">
        <label class="form-label">Role</label>
        <select class="form-select" name="role" required>
            <option value="gestionnaire" @selected(old('role', $utilisateur->role ?? '') === 'gestionnaire')>Gestionnaire</option>
            <option value="admin" @selected(old('role', $utilisateur->role ?? '') === 'admin')>Admin</option>
        </select>
    </div>
</div>
<div class="form-actions">
    <a href="{{ route('utilisateurs.index') }}" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Retour</a>
    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Enregistrer</button>
</div>
