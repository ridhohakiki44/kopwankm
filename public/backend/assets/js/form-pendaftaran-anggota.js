'use strict';



/**
 * Form Validation (https://formvalidation.io/guide/examples)
 */
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const formPendaftaranAnggota = document.getElementById('formPendaftaranAnggota'),
      select2Penghasilan = jQuery(formPendaftaranAnggota.querySelector('[name="penghasilan"]')),
      flatpickrDate = document.getElementById('tanggal_lahir');

    const fv = FormValidation.formValidation(formPendaftaranAnggota, {
      fields: {
        nik: {
          validators: {
            notEmpty: {
              message: 'Please enter your NIK'
            }
          }
        },
        alamat: {
          validators: {
            notEmpty: {
              message: 'Please enter your address'
            }
          }
        },
        nomor_telepon: {
          validators: {
            notEmpty: {
              message: 'Please enter your phone number'
            },
            regexp: {
              regexp: /^[0-9]+$/,
              message: 'The phone number can only consist of numbers'
            }
          }
        },
        tanggal_lahir: {
          validators: {
            notEmpty: {
              message: 'Please select your date of birth'
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
              message: 'Please enter your occupation'
            }
          }
        },
        penghasilan: {
          validators: {
            notEmpty: {
              message: 'Please select your income'
            }
          }
        },
        ktp: {
          validators: {
            notEmpty: {
              message: 'Please upload your KTP'
            },
            file: {
                maxSize: 2048 * 1024,
                message: 'The KTP file must not be larger than 2048 KB'
            }
          }
        },
        kartu_keluarga: {
          validators: {
            notEmpty: {
              message: 'Please upload your Kartu Keluarga'
            },
            file: {
                maxSize: 2048 * 1024,
                message: 'The Kartu Keluarga file must not be larger than 2048 KB'
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

    // Flatpickr
    if (flatpickrDate) {
      flatpickrDate.flatpickr({
        monthSelectorType: 'static',
        onChange: function () {
          fv.revalidateField('tanggal_lahir');
        }
      });
    }

    // Select2
    if (select2Penghasilan.length) {
      select2Penghasilan.wrap('<div class="position-relative"></div>');
      select2Penghasilan
        .select2({
          placeholder: 'Select income',
          dropdownParent: select2Penghasilan.parent()
        })
        .on('change', function () {
          fv.revalidateField('penghasilan');
        });
    }
  })();
});
