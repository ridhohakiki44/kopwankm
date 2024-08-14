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
              message: 'Please enter the loan amount'
            },
            numeric: {
              message: 'The value is not a valid number'
            }
          }
        },
        jangka_waktu: {
          validators: {
            notEmpty: {
              message: 'Please enter the loan term in months'
            },
            numeric: {
              message: 'The value is not a valid number'
            }
          }
        },
        bank: {
          validators: {
            notEmpty: {
              message: 'Please select a bank'
            }
          }
        },
        no_rek: {
          validators: {
            notEmpty: {
              message: 'Please enter your bank account number'
            },
            regexp: {
              regexp: /^[0-9]+$/,
              message: 'The bank account number can only consist of numbers'
            }
          }
        },
        jaminan: {
          validators: {
            notEmpty: {
              message: 'Please upload your collateral'
            },
            file: {
              maxSize: 2048 * 1024, // 2 MB
              message: 'The collateral file must not be larger than 2048 KB'
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

    // Select2
    if (select2Bank.length) {
      select2Bank.wrap('<div class="position-relative"></div>');
      select2Bank
        .select2({
          placeholder: 'Select a bank',
          dropdownParent: select2Bank.parent()
        })
        .on('change', function () {
          fv.revalidateField('bank');
        });
    }
  })();
});
