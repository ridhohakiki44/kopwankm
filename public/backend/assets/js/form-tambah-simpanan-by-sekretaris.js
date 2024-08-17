'use strict';

/**
 * Form Validation (https://formvalidation.io/guide/examples)
 */
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const formTambahSimpananBySekretaris = document.getElementById('formTambahSimpananBySekretaris'),
      select2jenis = jQuery(formTambahSimpananBySekretaris.querySelector('[name="jenis_simpanan"]')),
      select2user = jQuery(formTambahSimpananBySekretaris.querySelector('[name="user_id"]')); // Assuming 'user_id' is the name attribute for anggota dropdown

    const fv = FormValidation.formValidation(formTambahSimpananBySekretaris, {
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
        },
        user_id: {
          validators: {
            notEmpty: {
              message: 'Please select a member'
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

    // Select2 for Jenis Simpanan
    if (select2jenis.length) {
      select2jenis.wrap('<div class="position-relative"></div>');
      select2jenis
        .select2({
          placeholder: 'Select a saving type',
          dropdownParent: select2jenis.parent()
        })
        .on('change', function () {
          fv.revalidateField('jenis_simpanan');

          const userId = select2user.val(); // Get selected anggota ID

          // Mengambil jumlah simpanan wajib
          if (this.value === 'wajib') {
            fetch(`/get-wajib-savings-amount/${userId}`)
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
        const userId = select2user.val(); // Get selected anggota ID
        fetch(`/get-wajib-savings-amount/${userId}`)
          .then(response => response.json())
          .then(data => {
            document.getElementById('jumlah').value = data.jumlah;
            document.getElementById('jumlah').setAttribute('readonly', true);
          });
      }
    }

    // Select2 for Anggota dropdown
    if (select2user.length) {
      select2user.wrap('<div class="position-relative"></div>');
      select2user.select2({
        placeholder: 'Pilih Anggota',
        dropdownParent: select2user.parent()
      }).on('change', function () {
        fv.revalidateField('user_id');
        // Re-trigger the change event on jenis_simpanan to recalculate the amount
        select2jenis.trigger('change');
      });
    }
  })();
});
