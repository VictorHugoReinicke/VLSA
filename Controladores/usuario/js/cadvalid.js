$(function() {
    $("#cadForm").validate({
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
            nome: {
                required: true
            },
            usuario: {
                required: true
            },
            cpf: {
                required: true,
                cpfBR: true
            },
            rg: {
                required: true,
                rgBR: true
            },
            email: {
                required: true,
                email: true
            },
            senha: {
                required: true
            },
            confirmasenha: {
                required: true,
                equalTo: "#senhaCAD"
            }
        },
        messages: {
            nome: "Preenchimento de campo obrigatório",
            usuario: "Preenchimento de campo obrigatório",
            cpf: "Preenchimento de campo obrigatório",
            rg: "Preenchimento de campo obrigatório",
            email: {
                required: "Preenchimento de campo obrigatório",
                email: "Por favor, insira um endereço de e-mail válido"
            },
            senha: "Preenchimento de campo obrigatório",
            confirmasenha: {
                required: "Preenchimento de campo obrigatório",
                equalTo: "As senhas não correspondem"
            }
        }
    });
});
