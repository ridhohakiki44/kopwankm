'use strict';

/**
 * Form Validation (https://formvalidation.io/guide/examples)
 */
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const formPengajuanPinjaman = document.getElementById('formPengajuanPinjaman'),
      select2Bank = jQuery(formPengajuanPinjaman.querySelector('[name="bank"]'));

    const fv = FormValidation.formValidation(formPengajuanPinjaman, {
      fields: {
        jumlah: {
          validators: {
            notEmpty: {
              message: 'Masukan jumlah pinjaman'
            }
          }
        },
        jangka_waktu: {
          validators: {
            notEmpty: {
              message: 'Masukan jangka waktu'
            }
          }
        },
        bank: {
          validators: {
            notEmpty: {
              message: 'Pilih bank'
            }
          }
        },
        no_rek: {
          validators: {
            notEmpty: {
              message: 'Masukan nomor rekening'
            }
          }
        },
        jaminan: {
          validators: {
            notEmpty: {
              message: 'Upload jaminan pinjaman'
            },
            file: {
              maxSize: 2048 * 1024, // 2 MB
              message: 'Jaminan tidak boleh lebih dari 2048 KB / 2 MB'
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

    // Hanya memperbolehkan angka di input pada jumlah dan no_rek
    const hanyaAngka = function(evt) {
      let charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        evt.preventDefault();
      }
    };

    formPengajuanPinjaman.querySelector('[name="jumlah"]').addEventListener('keypress', hanyaAngka);
    formPengajuanPinjaman.querySelector('[name="no_rek"]').addEventListener('keypress', hanyaAngka);

    // Select2
    if (select2Bank.length) {
      select2Bank.wrap('<div class="position-relative"></div>');
      select2Bank
        .select2({
          placeholder: 'Pilih bank',
          dropdownParent: select2Bank.parent()
        })
        .on('change', function () {
          fv.revalidateField('bank');
        });
    }
  })();
});
