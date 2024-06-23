async function carregarArquivoJSON() {
    return fetch("../postagem/session_data.json")
        .then(resposta => resposta.json())
        .then(dados => dados.userId)
        .catch(erro => {
            console.error("Erro ao carregar o arquivo JSON:", erro);
            return null; // Retorna null em caso de erro
        });
}



const BtAddConta = document.querySelector('#AdcConta');
const formContainer = document.createElement('div');

function criarForm() {
    const formAdc = document.createElement('form');
    formAdc.action = '../postagem/backPost.php';
    formAdc.method = 'post';
    formAdc.id = 'formulario-de-novo-usuario';
    formAdc.classList.add('form-container');

    // Crie os elementos do formulário com os atributos e classes apropriados
    const inputNome = document.createElement('input');
    inputNome.name = 'user';
    inputNome.id = 'user';
    inputNome.type = 'text';
    inputNome.placeholder = 'Digite aqui o nome de usuário';
    inputNome.classList.add('form-control');

    const submit = document.createElement('button');
    submit.name = 'acao';
    submit.id = 'acao';
    submit.type = 'submit';
    submit.value = 'adcAcc'
    submit.textContent = 'Salvar usuário';
    submit.classList.add('btn', 'btn-outline-primary');

    const cancelar = document.createElement('button');
    cancelar.name = 'cancel';
    cancelar.id = 'cancel';
    cancelar.type = 'button';
    cancelar.textContent = 'Cancelar';
    cancelar.classList.add('btn', 'btn-outline-danger');

    const idUsu = document.createElement('input')
    idUsu.name = 'idusu'
    idUsu.id = 'idusu'
    idUsu.type = 'text'
    carregarArquivoJSON().then(userId => {
        idUsu.value = userId;
    });
   

    formAdc.appendChild(inputNome);
    formAdc.appendChild(submit);
    formAdc.appendChild(cancelar);
    formAdc.appendChild(idUsu)

    return formAdc;
}

BtAddConta.addEventListener('click', () => {
    const newForm = criarForm();
    const blur = document.querySelector('#blur-container');
    formContainer.classList.add('sweet-alert', 'col-3');
    formContainer.style.position = 'fixed';
    const bodyHeight = document.body.clientHeight;
    const formHeight = formContainer.clientHeight;
    const topPosition = (bodyHeight - formHeight) / 2;
    formContainer.style.top = `${topPosition}px`;
    formContainer.style.left = '50%';
    formContainer.style.transform = 'translate(-50%)';
    formContainer.appendChild(newForm);
    document.body.appendChild(formContainer);
    if (formContainer.parentElement) {
        blur.classList.add('blur-container');
    }
    const cancelar = document.querySelector('#cancel');
    cancelar.addEventListener('click', () => {
        if (formContainer.parentElement) {
            newForm.remove()
            blur.classList.remove('blur-container');
        }
    });
});