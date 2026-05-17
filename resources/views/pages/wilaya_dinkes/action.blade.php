<div class="d-flex justify-content-center gap-2">
    <a href="{{ route('wilaya-dinkes.edit', $id) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 6px;">
        <i class="bi bi-pencil-square"></i>
    </a>
    <button type="button" class="btn btn-sm btn-outline-danger" style="border-radius: 6px;" onclick="confirmDelete('{{ $id }}')">
        <i class="bi bi-trash"></i>
    </button>
</div>
