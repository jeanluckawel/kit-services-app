@extends('layoutsddd.app')

@section('title', 'Edit Permissions - KIT SERVICES')

@section('content')
    <div class="d-flex mt-2 justify-content-center align-items-start" style="background-color: #f9f9f9;">
        <div class="card shadow-sm border-0" style="width: 100%; max-width: 90%; border-radius: 0;">

            <div class="card-header bg-orange-600 text-white" style="border-radius: 0;">
                <h5 class="mb-0 fw-bold">Edit Permissions for {{ $user->name }}</h5>
            </div>

            <div class="card-body p-2">
                <form action="{{ route('users.updatePermissions', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @foreach($permissionsGrouped as $group => $permissions)
                        <div class="mb-3">
                        <span class="fw-semibold text-success small" style="font-size: 0.85rem;">
                            {{ ucfirst($group) }}:
                        </span>
                            <div class="d-flex flex-wrap mt-1">
                                @foreach($permissions as $perm)
                                    @php
                                        $hasPermission = $user->hasPermissionTo($perm->name);
                                    @endphp
                                    <div class="permission-tag me-1 mb-1 px-2 py-1 {{ $hasPermission ? 'active' : '' }}"
                                         data-perm-name="{{ $perm->name }}">
                                        {{ ucwords(str_replace('_', ' ', $perm->name)) }}
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                               style="opacity:0; position:absolute; left:-9999px;"
                                            {{ $hasPermission ? 'checked' : '' }}>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-3 p-2 border bg-light" style="min-height: 40px; font-size: 0.85rem; display: flex; flex-wrap: wrap; gap: 6px;">
                        <div><strong>User:</strong> {{ $user->name }}</div>
                        <div style="flex-basis: 100%;"></div>
                        <div><strong>Permissions:</strong>
                            <span id="preview-permissions">
                            {{ implode(', ', $user->permissions->pluck('name')->toArray()) ?: '-' }}
                        </span>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-orange px-3 py-1">Update Permissions</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        body { background-color: #f9f9f9; }

        .bg-orange-600 { background-color: #FF6600 !important; }
        .btn-orange { background-color: #FF6600; color: white; border: none; font-size: 0.85rem; border-radius: 0; transition: all 0.2s ease; }
        .btn-orange:hover { background-color: #e65c00; }

        .permission-tag {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 0;
            font-size: 0.75rem;
            padding: 3px 8px;
            cursor: pointer;
            color: #555;
            transition: all 0.2s ease;
        }
        .permission-tag:hover { background-color: #ffe5cc; border-color: #ff6600; color: #ff6600; }
        .permission-tag.active {
            background-color: #ff6600;
            color: white;
            border-color: #ff6600;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
    </style>

    <script>
        const permissionTags = document.querySelectorAll('.permission-tag');
        const previewPermissions = document.getElementById('preview-permissions');

        permissionTags.forEach(tag => {
            const checkbox = tag.querySelector('input[type="checkbox"]');

            tag.addEventListener('click', function() {
                tag.classList.toggle('active');
                checkbox.checked = tag.classList.contains('active');

                // Update preview
                const selected = Array.from(permissionTags)
                    .filter(t => t.querySelector('input').checked)
                    .map(t => t.querySelector('input').value);

                previewPermissions.textContent = selected.join(', ') || '-';
            });
        });
    </script>
@endsection
