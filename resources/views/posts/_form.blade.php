<div class="mb-3">
    <label for="title" class="form-label fw-semibold">Título</label>
    <input
        id="title"
        name="title"
        type="text"
        class="form-control @error('title') is-invalid @enderror"
        value="{{ old('title', $post->title ?? '') }}"
        maxlength="150"
        required
        aria-describedby="title-help"
    >
    <div id="title-help" class="form-text">Máximo 150 caracteres.</div>
    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-4">
    <label for="body" class="form-label fw-semibold">Contenido</label>
    <textarea
        id="body"
        name="body"
        rows="10"
        class="form-control @error('body') is-invalid @enderror"
        maxlength="10000"
        required
    >{{ old('body', $post->body ?? '') }}</textarea>
    <div class="form-text">El contenido se muestra como texto; no se ejecuta HTML.</div>
    @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-check form-switch mb-4">
    <input type="hidden" name="is_published" value="0">
    <input
        id="is_published"
        name="is_published"
        type="checkbox"
        value="1"
        class="form-check-input"
        @checked(old('is_published', $post->is_published ?? false))
    >
    <label for="is_published" class="form-check-label fw-semibold">Publicar en el sitio</label>
    <div class="form-text">Si no se activa, la publicación queda como borrador y solo tú puedes verla.</div>
</div>

<div class="d-flex flex-column flex-sm-row gap-2">
    <button type="submit" class="btn btn-primary">{{ isset($post) ? 'Guardar cambios' : 'Guardar publicación' }}</button>
    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
