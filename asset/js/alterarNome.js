document.addEventListener('DOMContentLoaded', (event) => {
    // Função para criar o input e o botão de OK
    function criarInputNome(postagemId, nomeAtual) {
        const postagemElement = document.getElementById('item-' + postagemId);
        const nomePostElement = postagemElement.querySelector('#NomePost');
        const idUsuElement = postagemElement.querySelector('#idusu');
        const linkElement = postagemElement.querySelector('#link');
        const userElement = postagemElement.querySelector('#user');
        const imgElement = postagemElement.querySelector('img');
        const senhaElement = postagemElement.querySelector('#pass');

        // Criar input para novo nome
        const inputNovoNome = document.createElement('input');
        inputNovoNome.type = 'text';
        inputNovoNome.value = nomeAtual;
        inputNovoNome.className = 'form-control';
        inputNovoNome.id = 'inputNovoNome-' + postagemId;

        // Criar botão de OK
        const botaoOk = document.createElement('button');
        botaoOk.textContent = 'OK';
        botaoOk.className = 'btn btn-success';
        botaoOk.id = 'botaoOk-' + postagemId;

        // Adicionar eventos ao botão de OK
        botaoOk.addEventListener('click', () => {
            const novoNome = inputNovoNome.value;
            salvarNovoNome(postagemId, novoNome, nomePostElement, inputNovoNome, botaoOk);
        });

        // Inserir input e botão no DOM
        nomePostElement.innerHTML = '';
        nomePostElement.appendChild(inputNovoNome);
        nomePostElement.appendChild(botaoOk);
    }

    // Função para salvar o novo nome no banco de dados e atualizar a interface
    function salvarNovoNome(postagemId, novoNome, nomePostElement, inputNovoNome, botaoOk) {
        const idUsuElement = document.querySelector('#item-' + postagemId + ' #idusu');
        const linkElement = document.querySelector('#item-' + postagemId + ' #link');
        const userElement = document.querySelector('#item-' + postagemId + ' #user');
        const senhaElement = document.querySelector('#item-' + postagemId + ' #pass');
        const imgElement = document.querySelector('#item-' + postagemId + ' img');

        const idUsu = idUsuElement.value;
        const link = linkElement.value;
        const userEmail = userElement.value;
        const senha = senhaElement.value;
        const imgSrc = imgElement.src;

        $.ajax({
            url: '../postagem/backPost.php', // Substitua pelo caminho correto do seu servidor
            type: 'POST',
            data: {
                acao: 'alterarNome',
                idpost: postagemId,
                nome: novoNome,
                link: link,
                idusu: idUsu,
                user: userEmail,
                pass: senha,
                imagem: imgSrc
            },
            success: function(response) {
                // Atualiza o nome da postagem na página
                nomePostElement.textContent = novoNome;
                // Remove o input e o botão OK
                inputNovoNome.remove();
                botaoOk.remove();
            },
            error: function(xhr, status, error) {
                console.error('Erro ao salvar:', error);
            }
        });
    }

    // Adicionar evento de clique para alterar o nome da postagem
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', () => {
            const postagemId = item.id;
            const nomeAtual = document.querySelector('#item-' + postagemId + ' #NomePost').textContent;
            criarInputNome(postagemId, nomeAtual);
        });
    });
});
