<div class="card mb-4">
    <!-- Account -->
    <form method="post" action="{{ route('profile.update') }}" id="formAccountSettings" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <h5 class="card-header">Profile Details</h5>
        <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('storage/avatars/default-avatar.png') }}"
                    alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                <div class="button-wrapper">
                    <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                        <span class="d-none d-sm-block">Upload new photo</span>
                        <i class="ti ti-upload d-block d-sm-none"></i>
                        <input type="file" id="upload" name="avatar" class="account-file-input" hidden
                            accept="image/png, image/jpeg" />
                    </label>
                    <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                        <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Reset</span>
                    </button>

                    <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
                </div>
            </div>
        </div>
        <hr class="my-0" />
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Nama</label>
                    <input class="form-control" type="text" id="name" name="name"
                        value="{{ old('name', $user->name) }}" required autofocus />
                </div>

                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input class="form-control" type="text" id="email" name="email"
                        value="{{ old('email', $user->email) }}" placeholder="john.doe@example.com" required />
                </div>

            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                <script>
                    var successMessage = @json(session('status'));
                </script>
                <button type="reset" class="btn btn-label-secondary">Cancel</button>
            </div>
        </div>
    </form>
    <!-- /Account -->
</div>
