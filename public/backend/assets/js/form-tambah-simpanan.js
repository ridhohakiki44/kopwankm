'use strict';

/**
 * Form Validation (https://formvalidation.io/guide/examples)
 */
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const formTambahSimpanan = document.getElementById('formTambahSimpanan'),
      select2jenis = jQuery(formTambahSimpanan.querySelector('[name="jenis_simpanan"]'));

    const fv = FormValidation.formValidation(formTambahSimpanan, {
      fields: {
        jumlah: {
          validators: {
            notEmpty: {
              message: 'Please enter the saving amount'
            },
            numeric: {
              message: 'The value is not a valid number'
            }
          }
        },
        jenis_simpanan: {
          validators: {
            notEmpty: {
              message: 'Please select a saving type'
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
    if (select2jenis.length) {
      select2jenis.wrap('<div class="position-relative"></div>');
      select2jenis
        .select2({
          placeholder: 'Select a saving type',
          dropdownParent: select2jenis.parent()
        })
        .on('change', function () {
          fv.revalidateField('jenis_simpanan');

          // Mengambil jumlah simpanan wajib
          if (this.value === 'wajib') {
            fetch('/get-wajib-savings-amount')
              .then(response => response.json())
              .then(data => {
                document.getElementById('jumlah').value = data.jumlah;
                document.getElementById('jumlah').setAttribute('readonly', true);
              });
          } else {
            document.getElementById('jumlah').value = '';
            document.getElementById('jumlah').removeAttribute('readonly');
          }
        });

        // Mengambil jumlah simpanan wajib ketika laman pertama kali diload
        if (select2jenis.val() === 'wajib') {
          fetch('/get-wajib-savings-amount')
            .then(response => response.json())
            .then(data => {
              console.log(data);
              document.getElementById('jumlah').value = data.jumlah;
              document.getElementById('jumlah').setAttribute('readonly', true);
            });
        }
    }
  })();
});
