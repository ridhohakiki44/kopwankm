"use strict";

/**
 * Form Validation (https://formvalidation.io/guide/examples)
 */
document.addEventListener("DOMContentLoaded", function (e) {
    (function () {
        const formSetBalance = document.getElementById("formSetBalance");

        const fv = FormValidation.formValidation(formSetBalance, {
            fields: {
                description: {
                    validators: {
                        notEmpty: {
                            message: "Please enter the description",
                        },
                    },
                },
                balance: {
                    validators: {
                        notEmpty: {
                            message: "Please enter the balance amount",
                        },
                    },
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: "",
                    rowSelector: ".col",
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
    })();
});
