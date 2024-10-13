<div class="card mb-4">
    <h5 class="card-header">Change Password</h5>
    <div class="card-body">

        <form method="post" action="{{ route('password.update') }}" id="formPasswordSettings">
            @csrf
            @method('put')
        
            <div class="row">
                <div class="mb-3 col-md-6 form-password-toggle">
                    <label class="form-label" for="update_password_current_password">Password Lama</label>
                    <input
                    class="form-control"
                    type="password"
                    name="current_password"
                    id="update_password_current_password"
                    placeholder="Masukan password lama"
                    required />
                    @if ($errors->updatePassword->has('current_password'))
                        <div class="mt-1 text-danger">
                            <small id="password_error">{{ $errors->updatePassword->first('current_password') }}</small>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6 form-password-toggle">
                    <label class="form-label" for="update_password_password">Password Baru</label>
                    <input
                    class="form-control"
                    type="password"
                    id="update_password_password"
                    name="password"
                    placeholder="Masukan password baru"
                    required />
                    @if ($errors->updatePassword->has('password'))
                        <div class="mt-1 text-danger">
                            <small id="password_error">{{ $errors->updatePassword->first('password') }}</small>
                        </div>
                    @endif
                </div>

                <div class="mb-3 col-md-6 form-password-toggle">
                    <label class="form-label" for="update_password_password_confirmation">Konfirmasi Password Baru</label>
                    <input
                    class="form-control"
                    type="password"
                    name="password_confirmation"
                    id="update_password_password_confirmation"
                    placeholder="Masukan password baru"
                    required />
                    @if ($errors->updatePassword->has('password_confirmation'))
                        <div class="mt-1 text-danger">
                            <small id="password_error">{{ $errors->updatePassword->first('password_confirmation') }}</small>
                        </div>
                    @endif
                </div>
                <div class="col-12 mb-4">
                    <h6>Password Requirements:</h6>
                    <ul class="ps-3 mb-0">
                        <li class="mb-1">Minimum 8 characters long - the more, the better</li>
                        <li class="mb-1">At least one lowercase character</li>
                        <li>At least one number, symbol, or whitespace character</li>
                    </ul>
                </div>
                <div>
                    <button type="submit" class="btn btn-success me-2">Save changes</button>
                    <script>
                        var successMessage = @json(session('status'));
                    </script>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
