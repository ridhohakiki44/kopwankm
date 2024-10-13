/**
 * Sweet Alerts
 */

'use strict';

(function () {

  // auto alert from var successMessage
  if (typeof successMessage !== 'undefined' && successMessage) {
    Swal.fire({
      title: 'Success!',
      text: successMessage,
      icon: 'success',
      customClass: {
        confirmButton: 'btn btn-success waves-effect waves-light'
      },
      buttonsStyling: false
    });
  }

  // Verifikasi Button
  const verifikasiBtn = document.querySelector('#verifikasi-btn');
  const verifikasiForm = document.querySelector('#verifikasi-form');

  if (verifikasiBtn) {
    verifikasiBtn.onclick = function () {
      Swal.fire({
        title: 'Apakah kamu yakin?',
        text: "Kamu ingin menyetujui pengajuan?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, setujui!',
        cancelButtonText: 'Cancel',
        customClass: {
          confirmButton: 'btn btn-success me-3 waves-effect waves-light',
          cancelButton: 'btn btn-label-secondary waves-effect waves-light'
        },
        buttonsStyling: false
      }).then((result) => {
        if (result.isConfirmed) {
          verifikasiForm.submit(); // Submit the form if confirmed
        }
      });
    };
  }

  // Tolak Button
  const tolakBtn = document.querySelector('#tolak-btn');
  const tolakForm = document.querySelector('#tolak-form');

  if (tolakBtn) {
    tolakBtn.onclick = function () {
      Swal.fire({
        title: 'Apakah kamu yakin?',
        text: "Kamu ingin menolak pengajuan?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, tolak!',
        cancelButtonText: 'Cancel',
        customClass: {
          confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
          cancelButton: 'btn btn-label-secondary waves-effect waves-light'
        },
        buttonsStyling: false
      }).then((result) => {
        if (result.isConfirmed) {
          tolakForm.submit(); // Submit the form if confirmed
        }
      });
    };
  }
})();
