let itensSelecionados = [];

function resetCheckboxes() {
    // Remove os checkboxes existentes
    document.querySelectorAll('.checkbox-comparar').forEach(checkbox => {
        checkbox.parentNode.removeChild(checkbox);
    });
    itensSelecionados = [];

    // Cria novos checkboxes e os deixa invisíveis
    let itens = document.querySelectorAll('div[id^="item-"]');
    itens.forEach(item => {
        let id = item.id.split('-')[1];
        let checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = 'checkbox-' + id;
        checkbox.className = 'checkbox-comparar';
        checkbox.style.display = 'none'; // Inicia escondido
        checkbox.onchange = function () { prepararComparacao(id); };
        item.appendChild(checkbox);
    });
}

function mostrarElementos(id) {
    // Verifica se os checkboxes precisam ser recriados
    if (document.querySelectorAll('.checkbox-comparar').length === 0) {
        resetCheckboxes();
    }

    // Mostra todos os checkboxes
    document.querySelectorAll('.checkbox-comparar').forEach(checkbox => {
        checkbox.style.display = 'inline';
    });

    // Marca o checkbox do item clicado
    let checkboxClicado = document.getElementById('checkbox-' + id);
    if (checkboxClicado) {
        checkboxClicado.checked = true;
        prepararComparacao(id); // Atualiza a lista de itens selecionados
    }

    // Exibe os botões de controle
    let elementosComparacao = document.getElementById('elementosComparacao');
    if (elementosComparacao) {
        elementosComparacao.style.display = 'block';
    }
}

function prepararComparacao(id) {
    let checkbox = document.getElementById('checkbox-' + id);
    if (checkbox.checked && !itensSelecionados.includes(id)) {
        itensSelecionados.push(id);
    } else {
        itensSelecionados = itensSelecionados.filter(item => item !== id);
    }

    // Permite apenas dois checkboxes selecionados
    if (itensSelecionados.length > 2) {
        let primeiroId = itensSelecionados.shift();
        let primeiroCheckbox = document.getElementById('checkbox-' + primeiroId);
        if (primeiroCheckbox) {
            primeiroCheckbox.checked = false;
        }
    }
}

function cancelarComparacao() {
    resetCheckboxes(); // Recria os checkboxes invisíveis

    // Esconde os botões de controle
    let elementosComparacao = document.getElementById('elementosComparacao');
    if (elementosComparacao) {
        elementosComparacao.style.display = 'none';
    }
}

function compararItens() {
    if (itensSelecionados.length === 2) {
        let url = 'seu_script.php?item1=' + itensSelecionados[0] + '&item2=' + itensSelecionados[1];
        window.location.href = url;
    } else {
        alert('Selecione dois itens para comparar.');
    }
}

// Inicializa os checkboxes quando a página é carregada
document.addEventListener('DOMContentLoaded', function () {
    resetCheckboxes();

    // Adiciona o evento de clique para mostrar os checkboxes e marcar o clicado
    document.querySelectorAll('button[id^="btnComparar-"]').forEach(botao => {
        let id = botao.id.split('-')[1];
        botao.addEventListener('click', function() {
            mostrarElementos(id);
        });
    });

    // Adiciona o evento de clique no botão 'Cancelar' para resetar os checkboxes
    let btnCancelar = document.getElementById('btnCancelar');
    if (btnCancelar) {
        btnCancelar.addEventListener('click', cancelarComparacao);
    }
});
