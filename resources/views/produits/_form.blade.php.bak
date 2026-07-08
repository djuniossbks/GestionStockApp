@csrf
<div class="row g-3">
    <div class="col-md-5">
        <label class="form-label" for="nom">Nom</label>
        <input class="form-control" id="nom" name="nom" value="{{ old('nom', $produit->nom ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="categorie">Categorie</label>
        <input class="form-control" id="categorie" name="categorie" value="{{ old('categorie', $produit->categorie ?? '') }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="prix_unitaire">Prix unitaire</label>
        <input class="form-control" id="prix_unitaire" name="prix_unitaire" type="number" min="0" step="0.01" value="{{ old('prix_unitaire', $produit->prix_unitaire ?? '') }}" required>
    </div>
</div>
<div class="form-actions">
    <a href="{{ route('produits.index') }}" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Retour</a>
    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Enregistrer <i class="fa-solid fa-heart" style="margin-left:8px;color:#fff;opacity:.9"></i></button>
</div>
