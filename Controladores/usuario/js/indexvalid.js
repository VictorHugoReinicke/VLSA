$(function() {
    $("#indexForm").validate({
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.siblings('label'));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
            $(element).closest('.form-control').addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
            $(element).closest('.form-control').removeClass(errorClass).addClass(validClass);
        },
        rules: {
            user: {
                required: true
            },
            pass: {
                required: true
            },
            nome: {
                required: true,
                // cpfBR: true
            },
            link: {
                required: true,
            }
        },
        messages: {
            user: "Preenchimento de campo obrigatório",
            pass: "Preenchimento de campo obrigatório",
            nome: "Preenchimento de campo obrigatório",
            link: "Preenchimento de campo obrigatório",
        }
    });
});