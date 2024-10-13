'use strict';

/**
 * Form Validation (https://formvalidation.io/guide/examples)
 */
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const formTambahSimpananBySekretaris = document.getElementById('formTambahSimpananBySekretaris'),
      select2jenis = jQuery(formTambahSimpananBySekretaris.querySelector('[name="jenis_simpanan"]')),
      select2status = jQuery(formTambahSimpananBySekretaris.querySelector('[name="status"]')),
      select2user = jQuery(formTambahSimpananBySekretaris.querySelector('[name="user_id[]"]')); // Assuming 'user_id' is the name attribute for anggota dropdown

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
        status: {
          validators: {
            notEmpty: {
              message: 'Please select a status'
            }
          }
        },
        'user_id[]': {
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

          if (select2jenis.val() === 'wajib') {
              // Sembunyikan field jumlah jika jenis simpanan adalah wajib
              document.getElementById('jumlahWrapper').style.display = 'none';
              document.getElementById('jumlah').value = 0;
          } else {
              // Tampilkan field jumlah jika jenis simpanan adalah sukarela
              document.getElementById('jumlahWrapper').style.display = 'block';
              document.getElementById('jumlah').value = '';
          }
        });

      // Saat laman pertama kali diload, cek jenis simpanan
      if (select2jenis.val() === 'wajib') {
        document.getElementById('jumlahWrapper').style.display = 'none';
        document.getElementById('jumlah').value = 0;
      } else {
        document.getElementById('jumlahWrapper').style.display = 'block';
        document.getElementById('jumlah').value = '';
      }
    }

    // Select2 for Anggota
    if (select2user.length) {
      select2user.wrap('<div class="position-relative"></div>');
      select2user.select2({
          placeholder: 'Pilih Anggota',
          dropdownParent: select2user.parent()
      }).on('change', function () {
          fv.revalidateField('user_id[]');
          
          const selectedValues = select2user.val();

          // Cek apakah opsi "Semua Anggota" dipilih
          if (selectedValues.includes('all')) {
              // Jika "Semua Anggota" dipilih, ambil semua nilai anggota
              const allValues = Array.from(select2user.find('option'))
                  .map(option => option.value)
                  .filter(value => value !== 'all');

              // Jika sudah memilih semua anggota, hapus pemilihan
              if (selectedValues.length === allValues.length + 1) { // +1 karena ada opsi "Semua Anggota"
                  select2user.val([]).trigger('change'); // Batalkan semua pemilihan
              } else {
                  // Pilih semua anggota dan hapus opsi "Semua Anggota" dari pemilihan
                  select2user.val(allValues).trigger('change');
              }
          }
      });
    }

    // Select2 for Status
    if (select2status.length) {
      select2status.wrap('<div class="position-relative"></div>');
      select2status.select2({
        placeholder: 'Pilih Status',
        dropdownParent: select2status.parent()
      }).on('change', function () {
        fv.revalidateField('status');
      });
    }
  })();
});
