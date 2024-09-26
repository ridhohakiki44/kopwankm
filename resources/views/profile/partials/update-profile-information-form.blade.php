<div class="card mb-4">
    <!-- Account -->
    <form method="post" action="{{ route('profile.update') }}" id="formUpdateProfile" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <h5 class="card-header">Profile Details</h5>
        <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('storage/avatars/default-avatar.png') }}"
                    alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                <div class="button-wrapper">
                    <label for="uploadAvatar" class="btn btn-primary me-2 mb-3" tabindex="0">
                        <span class="d-none d-sm-block">Upload new photo</span>
                        <i class="ti ti-upload d-block d-sm-none"></i>
                        <input type="file" id="uploadAvatar" name="avatar" class="account-file-input" hidden
                            accept="image/png, image/jpeg" />
                    </label>
                    <button type="button" class="btn btn-label-secondary account-image-reset mb-3" id="resetAvatar">
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

                <div class="mb-3 col-md-6">
                    <label class="form-label" for="nik">NIK</label>
                    <input class="form-control" type="text" id="nik" name="nik" value="{{ old('nik', $user->nik) }}" placeholder="NIK" maxlength="16" />
                </div>

                <div class="mb-3 col-md-6">
                    <label for="alamat" class="form-label">Alamat</label>
                    <select id="alamat" class="select2 form-select form-select-lg" data-allow-clear="true" name="alamat">
                        <option value="Bunga Tanjung" {{ old('alamat', $user->alamat) == 'Bunga Tanjung' ? 'selected' : '' }}>Bunga Tanjung</option>
                        <option value="Kampung Padang Selatan" {{ old('alamat', $user->alamat) == 'Kampung Padang Selatan' ? 'selected' : '' }}>Kampung Padang Selatan</option>
                        <option value="Kampung Padang Utara" {{ old('alamat', $user->alamat) == 'Kampung Padang Utara' ? 'selected' : '' }}>Kampung Padang Utara</option>
                        <option value="Pasar Baru Barat" {{ old('alamat', $user->alamat) == 'Pasar Baru Barat' ? 'selected' : '' }}>Pasar Baru Barat</option>
                        <option value="Pasar Baru Timur" {{ old('alamat', $user->alamat) == 'Pasar Baru Timur' ? 'selected' : '' }}>Pasar Baru Timur</option>
                        <option value="Pasar Baru Utara" {{ old('alamat', $user->alamat) == 'Pasar Baru Utara' ? 'selected' : '' }}>Pasar Baru Utara</option>
                        <option value="Pasar Dua Suak" {{ old('alamat', $user->alamat) == 'Pasar Dua Suak' ? 'selected' : '' }}>Pasar Dua Suak</option>
                        <option value="Pasar Muara" {{ old('alamat', $user->alamat) == 'Pasar Muara' ? 'selected' : '' }}>Pasar Muara</option>
                        <option value="Pasar Pokan" {{ old('alamat', $user->alamat) == 'Pasar Pokan' ? 'selected' : '' }}>Pasar Pokan</option>
                        <option value="Pasar Satu" {{ old('alamat', $user->alamat) == 'Pasar Satu' ? 'selected' : '' }}>Pasar Satu</option>
                        <option value="Pigogah Patibubur" {{ old('alamat', $user->alamat) == 'Pigogah Patibubur' ? 'selected' : '' }}>Pigogah Patibubur</option>
                        <option value="Pulau Panjang" {{ old('alamat', $user->alamat) == 'Pulau Panjang' ? 'selected' : '' }}>Pulau Panjang</option>
                        <option value="Silawai Tengah" {{ old('alamat', $user->alamat) == 'Silawai Tengah' ? 'selected' : '' }}>Silawai Tengah</option>
                        <option value="Silawai Timur" {{ old('alamat', $user->alamat) == 'Silawai Timur' ? 'selected' : '' }}>Silawai Timur</option>
                    </select>
                </div>                

                <div class="mb-3 col-md-6">
                    <label class="form-label" for="nomor_telepon">Nomor Telepon</label>
                    <input class="form-control" type="text" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon', $user->nomor_telepon) }}"
                        placeholder="081234567890" />
                </div>

                <div class="mb-3 col-md-6">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="tanggal_lahir" name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" />
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label" for="pekerjaan">Pekerjaan</label>
                    <select id="pekerjaan" class="select2 form-select form-select-lg"
                        data-allow-clear="true" name="pekerjaan">
                        <option value="Ibu Rumah Tangga" {{ old('pekerjaan', $user->pekerjaan) == 'Ibu Rumah Tangga' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                        <option value="Petani" {{ old('pekerjaan', $user->pekerjaan) == 'Petani' ? 'selected' : '' }}>Petani</option>
                        <option value="Pedagang" {{ old('pekerjaan', $user->pekerjaan) == 'Pedagang' ? 'selected' : '' }}>Pedagang</option>
                        <option value="Guru" {{ old('pekerjaan', $user->pekerjaan) == 'Guru' ? 'selected' : '' }}>Guru</option>
                        <option value="Dokter" {{ old('pekerjaan', $user->pekerjaan) == 'Dokter' ? 'selected' : '' }}>Dokter</option>
                        <option value="Bidan" {{ old('pekerjaan', $user->pekerjaan) == 'Bidan' ? 'selected' : '' }}>Bidan</option>
                        <option value="PNS" {{ old('pekerjaan', $user->pekerjaan) == 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="PPPK" {{ old('pekerjaan', $user->pekerjaan) == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                        <option value="Karyawan Honorer" {{ old('pekerjaan', $user->pekerjaan) == 'Karyawan Honorer' ? 'selected' : '' }}>Karyawan Honorer</option>
                        <option value="Lainnya" {{ !in_array(old('pekerjaan', $user->pekerjaan), ['Ibu Rumah Tangga', 'Petani', 'Pedagang', 'Guru', 'Dokter', 'Bidan', 'PNS', 'PPPK', 'Karyawan Honorer']) ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="mb-3 col-md-6" id="input-pekerjaan-lainnya" style="display: none;">
                    <label class="form-label" for="pekerjaan_lainnya">Pekerjaan Lainnya</label>
                    <input type="text" id="pekerjaan_lainnya" class="form-control" name="pekerjaan_lainnya" placeholder="Pekerjaan lainnya" value="{{ !in_array(old('pekerjaan', $user->pekerjaan), ['Ibu Rumah Tangga', 'Petani', 'Pedagang', 'Guru', 'Dokter', 'Bidan', 'PNS', 'PPPK', 'Karyawan Honorer']) ? old('pekerjaan', $user->pekerjaan) : '' }}" />
                </div>

                <div class="mb-3 col-md-6">
                    <label for="penghasilan" class="form-label">Penghasilan</label>
                    <select id="penghasilan" class="select2 form-select form-select-lg" data-allow-clear="true" name="penghasilan">
                        <option value="500.000 - 1.000.000" {{ old('penghasilan', $user->penghasilan) == '500.000 - 1.000.000' ? 'selected' : '' }}>500.000 - 1.000.000</option>
                        <option value="1.000.000 - 1.500.000" {{ old('penghasilan', $user->penghasilan) == '1.000.000 - 1.500.000' ? 'selected' : '' }}>1.000.000 - 1.500.000</option>
                        <option value="1.500.000 - 2.000.000" {{ old('penghasilan', $user->penghasilan) == '1.500.000 - 2.000.000' ? 'selected' : '' }}>1.500.000 - 2.000.000</option>
                        <option value="2.000.000 - 3.000.000" {{ old('penghasilan', $user->penghasilan) == '2.000.000 - 3.000.000' ? 'selected' : '' }}>2.000.000 - 3.000.000</option>
                        <option value="3.000.000 - 10.000.000" {{ old('penghasilan', $user->penghasilan) == '3.000.000 - 10.000.000' ? 'selected' : '' }}>3.000.000 - 10.000.000</option>
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <!-- KTP Upload -->
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ auth()->user()->ktp ? asset('storage/' . auth()->user()->ktp) : asset('storage/documents/default-ktp.png') }}"
                            alt="ktp" class="d-block w-px-150 h-px-100 rounded" id="uploadedKtp" />
                        <div class="button-wrapper">
                            <label for="uploadKtp" class="btn btn-primary me-2 mb-3" tabindex="0">
                                <span class="d-none d-sm-block">Upload KTP</span>
                                <i class="ti ti-upload d-block d-sm-none"></i>
                                <input type="file" id="uploadKtp" name="ktp" class="account-file-input" hidden accept="image/png, image/jpeg" />
                            </label>
                            <button type="button" class="btn btn-label-secondary account-image-reset mb-3" id="resetKtp">
                                <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button>
                            <div class="text-muted">Allowed JPG or PNG. Max size of 2MB</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3 col-md-6">
                    <!-- Kartu Keluarga Upload -->
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ auth()->user()->kartu_keluarga ? asset('storage/' . auth()->user()->kartu_keluarga) : asset('storage/documents/default-kk.png') }}"
                            alt="kartu keluarga" class="d-block w-px-150 h-px-100 rounded" id="uploadedKk" />
                        <div class="button-wrapper">
                            <label for="uploadKk" class="btn btn-primary me-2 mb-3" tabindex="0">
                                <span class="d-none d-sm-block">Upload Kartu Keluarga</span>
                                <i class="ti ti-upload d-block d-sm-none"></i>
                                <input type="file" id="uploadKk" name="kartu_keluarga" class="account-file-input" hidden accept="image/png, image/jpeg" />
                            </label>
                            <button type="button" class="btn btn-label-secondary account-image-reset mb-3" id="resetKk">
                                <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button>
                            <div class="text-muted">Allowed JPG or PNG. Max size of 2MB</div>
                        </div>
                    </div>
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
