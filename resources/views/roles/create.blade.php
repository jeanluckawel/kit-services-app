@extends('layoutsddd.app')

@section('title', 'Create Role - KIT SERVICES')

@section('content')
    <div class="d-flex mt-2 justify-content-center align-items-start" style=" background-color: #f9f9f9;">
        <div class="card shadow-sm border-0" style="width: 100%; max-width: 90%; border-radius: 0;">

            <div class="card-header d-flex align-items-center"
                 style="background-color: #FF6600; color: #fff; border-radius:0;">
                <h5 class="mb-0 fw-bold" style="font-size: 1rem;">Create a New Role</h5>

                <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb mb-0 bg-transparent">
                        @can('dashboard')
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-white">Home</a>
                            </li>
                        @endcan

                        @can('role_list')
                            <li class="breadcrumb-item">
                                <a href="{{ route('roles.index') }}" class="text-white">Roles</a>
                            </li>
                        @endcan

                        <li class="breadcrumb-item active text-white" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>


            <div class="card-body p-2">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf


                    <div class="mb-3" style="max-width: 400px;">
                        <label for="role_name" class="form-label fw-semibold small text-secondary">
                            Role Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="role_name"
                               name="name"
                               class="form-control form-control-sm"
                               placeholder="Enter role name"
                               required
                               autocomplete="off"
                               style="font-size: 0.85rem; border-radius:0;">
                    </div>




                    <div class="mb-2">
                        <h6 class="fw-bold text-orange-600 small mb-1" style="font-size: 0.85rem;">Permissions</h6>

                        @foreach($permissionsGrouped as $group => $permissions)
                            <div class="mb-1">
                                <span class="fw-semibold text-success small" style="font-size: 0.8rem;">{{ ucfirst($group) }}:</span>
                                <div class="d-flex flex-wrap mt-1">
                                    @foreach($permissions as $perm)
                                        <div class="permission-tag me-1 mb-1 px-2 py-1" data-perm-id="{{ $perm->id }}" style="font-size: 0.75rem;">
                                            {{ ucwords(str_replace('_', ' ', $perm->name)) }}
                                            <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" class="d-none">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="mt-2 p-2 border bg-light" id="role-preview" style="min-height: 40px; font-size: 0.85rem; display: flex; flex-wrap: wrap; gap: 6px;">
                        <div><strong>Role Name:</strong> <span id="preview-role-name">-</span></div>
                        <div style="flex-basis: 100%;"></div>
                        <div><strong>Permissions:</strong> <span id="preview-permissions">-</span></div>
                    </div>


                    <div class="text-right mt-2">
                        <button type="submit" class="btn btn-orange px-3 py-1 " >Save</button>
                    </div>
                </form>


            </div>
        </div>
    </div>

    <style>
        body { background-color: #f9f9f9; }

        .bg-orange-600 { background-color: #FF6600 !important; }
        .btn-orange {
            background-color: #FF6600;
            color: white;
            border: none;
            font-size: 0.85rem;
            border-radius: 0;
            transition: all 0.2s ease;
        }
        .btn-orange:hover { background-color: #e65c00; color: white; }

        .permission-tag {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 0;
            font-size: 0.7rem;
            padding: 3px 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #555;
        }
        .permission-tag:hover {
            background-color: #ffe5cc;
            border-color: #ff6600;
            color: #ff6600;
        }
        .permission-tag.active {
            background-color: #ff6600;
            color: white;
            border-color: #ff6600;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
    </style>

    <script>
        const roleNameInput = document.getElementById('role_name');
        const previewRoleName = document.getElementById('preview-role-name');
        const previewPermissions = document.getElementById('preview-permissions');
        const permissionTags = document.querySelectorAll('.permission-tag');


        permissionTags.forEach(tag => {
            tag.addEventListener('click', function() {
                this.classList.toggle('active');
                this.querySelector('input[type="checkbox"]').checked = !this.querySelector('input[type="checkbox"]').checked;


                const selected = Array.from(permissionTags)
                    .filter(t => t.classList.contains('active'))
                    .map(t => t.textContent.trim());
                previewPermissions.textContent = selected.length ? selected.join(', ') : '-';
            });
        });


        roleNameInput.addEventListener('input', () => {
            previewRoleName.textContent = roleNameInput.value || '-';
        });
    </script>
@endsection
