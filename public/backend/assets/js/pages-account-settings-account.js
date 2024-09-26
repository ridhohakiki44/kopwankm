/**
 * Account Settings - Account
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const formUpdateProfile = document.querySelector('#formUpdateProfile'),
          select2Penghasilan = jQuery(formUpdateProfile.querySelector('[name="penghasilan"]')),
          select2Alamat = jQuery(formUpdateProfile.querySelector('[name="alamat"]')),
          select2Pekerjaan = jQuery(formUpdateProfile.querySelector('[name="pekerjaan"]')),
          inputPekerjaanLainnya = document.getElementById('input-pekerjaan-lainnya'),
          flatpickrDate = document.getElementById('tanggal_lahir');

    const fv = FormValidation.formValidation(formUpdateProfile, {
      fields: {
        name: {
          validators: {
            notEmpty: {
              message: 'Please enter name'
            }
          }
        },
        email: {
          validators: {
            notEmpty: {
              message: 'Please enter your email'
            },
            emailAddress: {
              message: 'Please enter valid email address'
            }
          }
        },
        nik: {
          validators: {
            notEmpty: {
              message: 'Masukan NIK'
            },
            stringLength: {
              min: 16,
              max: 16,
              message: 'NIK harus terdiri dari 16 angka'
            }
          }
        },
        alamat: {
          validators: {
            notEmpty: {
              message: 'Pilih alamat'
            }
          }
        },
        nomor_telepon: {
          validators: {
            notEmpty: {
              message: 'Masukan nomor telepon'
            }
          }
        },
        tanggal_lahir: {
          validators: {
            notEmpty: {
              message: 'Pilih tanggal lahir anda'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'The value is not a valid date'
            }
          }
        },
        pekerjaan: {
          validators: {
            notEmpty: {
              message: 'Masukan pekerjaan'
            }
          }
        },
        pekerjaan_lainnya: {
          validators: {
            notEmpty: {
              message: 'Masukkan pekerjaan lainnya'
            }
          }
        },
        penghasilan: {
          validators: {
            notEmpty: {
              message: 'Pilih penghasilan'
            }
          }
        },
        ktp: {
          validators: {
            file: {
                maxSize: 2048 * 1024,
                message: 'KTP tidak boleh lebih dari 2048 KB'
            }
          }
        },
        kartu_keluarga: {
          validators: {
            file: {
                maxSize: 2048 * 1024,
                message: 'Kartu Keluarga tidak boleh lebih dari 2048 KB'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.col-md-6'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      },
      init: instance => {
        instance.on('plugins.message.placed', function (e) {
          if (e.element.parentElement.classList.contains('input-group')) {
            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
          }
        });
      }
    });

    // Hanya memperbolehkan angka di input pada nik dan nomor_telepon
    const hanyaAngka = function(evt) {
      let charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        evt.preventDefault();
      }
    };

    formUpdateProfile.querySelector('[name="nik"]').addEventListener('keypress', hanyaAngka);
    formUpdateProfile.querySelector('[name="nomor_telepon"]').addEventListener('keypress', hanyaAngka);

    // Flatpickr
    if (flatpickrDate) {
      flatpickrDate.flatpickr({
        monthSelectorType: 'static',
        onChange: function () {
          fv.revalidateField('tanggal_lahir');
        }
      });
    }

    // Select Penghasilan
    if (select2Penghasilan.length) {
      select2Penghasilan.wrap('<div class="position-relative"></div>');
      select2Penghasilan
        .select2({
          placeholder: 'Penghasilan',
          dropdownParent: select2Penghasilan.parent()
        })
        .on('change', function () {
          fv.revalidateField('penghasilan');
        });
    }

    // Select Alamat
    if (select2Alamat.length) {
      select2Alamat.wrap('<div class="position-relative"></div>');
      select2Alamat
        .select2({
          placeholder: 'Alamat',
          dropdownParent: select2Alamat.parent()
        })
        .on('change', function () {
          fv.revalidateField('alamat');
        });
    }

    // Select Pekerjaan
    if (select2Pekerjaan.length) {
      select2Pekerjaan.wrap('<div class="position-relative"></div>');
      select2Pekerjaan
        .select2({
          placeholder: 'Pekerjaan',
          dropdownParent: select2Pekerjaan.parent()
        })
        .on('change', function () {
          fv.revalidateField('pekerjaan');

          // Tampilkan input pekerjaan lainnya jika "Lainnya" dipilih
          if (this.value === 'Lainnya') {
            inputPekerjaanLainnya.style.display = 'block';
            fv.enableValidator('pekerjaan_lainnya');
          } else {
            inputPekerjaanLainnya.style.display = 'none';
            document.getElementById('pekerjaan_lainnya').value = '';
            fv.disableValidator('pekerjaan_lainnya');
          }
        });
        
        if (select2Pekerjaan.val() === 'Lainnya') {
          inputPekerjaanLainnya.style.display = 'block';
        } else {
          fv.disableValidator('pekerjaan_lainnya');
        }
    }

    // Update/reset user image of account page
    let avatarImage = document.getElementById('uploadedAvatar');
    const avatarFileInput = document.querySelector('#uploadAvatar'),
      resetAvatarInput = document.querySelector('#resetAvatar');

    if (avatarImage) {
      const resetAvatarImage = avatarImage.src;
      avatarFileInput.onchange = () => {
        if (avatarFileInput.files[0]) {
          avatarImage.src = window.URL.createObjectURL(avatarFileInput.files[0]);
        }
      };
      resetAvatarInput.onclick = () => {
        avatarFileInput.value = '';
        avatarImage.src = resetAvatarImage;
      };
    }

    // Update/reset KTP image
    let ktpImage = document.getElementById('uploadedKtp');
    const ktpFileInput = document.querySelector('#uploadKtp'),
          resetKtpInput = document.querySelector('#resetKtp');

    if (ktpImage) {
        const resetKtpImage = ktpImage.src;
        ktpFileInput.onchange = () => {
            if (ktpFileInput.files[0]) {
                ktpImage.src = window.URL.createObjectURL(ktpFileInput.files[0]);
            }
        };
        resetKtpInput.onclick = () => {
            ktpFileInput.value = '';
            ktpImage.src = resetKtpImage;
        };
    }

    // Update/reset Kartu Keluarga image
    let kkImage = document.getElementById('uploadedKk');
    const kkFileInput = document.querySelector('#uploadKk'),
          resetKkInput = document.querySelector('#resetKk');

    if (kkImage) {
        const resetKkImage = kkImage.src;
        kkFileInput.onchange = () => {
            if (kkFileInput.files[0]) {
                kkImage.src = window.URL.createObjectURL(kkFileInput.files[0]);
            }
        };
        resetKkInput.onclick = () => {
            kkFileInput.value = '';
            kkImage.src = resetKkImage;
        };
    }
  })();
});
