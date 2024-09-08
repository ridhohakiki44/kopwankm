'use strict';

/**
 * Form Validation (https://formvalidation.io/guide/examples)
 */
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const loanForm = document.getElementById('loanForm'),
      select2Keterangan = jQuery(loanForm.querySelector('[name="keterangan"]'));

    const fv = FormValidation.formValidation(loanForm, {
      fields: {
        keterangan: {
          validators: {
            notEmpty: {
              message: 'Pilih keterangan'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.col'
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
    if (select2Keterangan.length) {
      select2Keterangan.wrap('<div class="position-relative"></div>');
      select2Keterangan
        .select2({
          placeholder: 'Pilih keterangan',
          dropdownParent: select2Keterangan.parent()
        })
        .on('change', function () {
          fv.revalidateField('keterangan');
        });
    }
  })();
});
