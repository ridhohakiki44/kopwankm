"use strict";

/**
 * Form Validation (https://formvalidation.io/guide/examples)
 */
document.addEventListener("DOMContentLoaded", function (e) {
    (function () {
        const formTransaction = document.getElementById("formTransaction"),
            select2Type = jQuery(formTransaction.querySelector('[name="type"]'));

        const fv = FormValidation.formValidation(formTransaction, {
            fields: {
                description: {
                    validators: {
                        notEmpty: {
                            message: "Please enter the description",
                        },
                    },
                },
                type: {
                    validators: {
                        notEmpty: {
                            message: "Please select a type",
                        },
                    },
                },
                amount: {
                    validators: {
                        notEmpty: {
                            message: "Please enter the transaction amount",
                        },
                    },
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: "",
                    rowSelector: ".col-md-6",
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                autoFocus: new FormValidation.plugins.AutoFocus(),
            },
            init: (instance) => {
                instance.on("plugins.message.placed", function (e) {
                    if (
                        e.element.parentElement.classList.contains(
                            "input-group"
                        )
                    ) {
                        e.element.parentElement.insertAdjacentElement(
                            "afterend",
                            e.messageElement
                        );
                    }
                });
            },
        });

        // Select2
        if (select2Type.length) {
            select2Type.wrap('<div class="position-relative"></div>');
            select2Type
                .select2({
                    placeholder: "Select a type",
                    dropdownParent: select2Type.parent(),
                })
                .on("change", function () {
                    fv.revalidateField("type");
                });
        }
    })();
});
