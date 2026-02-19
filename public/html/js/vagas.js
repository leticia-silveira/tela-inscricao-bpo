function comandoExportar() {
    // Seleciona o elemento de entrada pelo seu ID
    var exportarInput = document.getElementById('exportar');
    exportarInput.value = 'exportar';

    document.getElementById('formLista').submit();

    exportarInput.value = '';
}

function buscarDados(campo) {

    const url = '/vagas/buscarLocal';

    $.ajax({
        url: url,
        method: 'GET',
        data: {
            condicao: campo.value
        },
        success: function (response) {
            if (response.erro) {
                console.error(response.mensagem);
                return;
            }

            document.getElementById('descricaoLocalizacao').value = response.dados[0].descricaoFuncao;

        },
        error: function (xhr, status, error) {
            console.error("Erro ao buscar o conteúdo:", error);
        }
    });
}


function pesquisar(campo) {
    $.ajax({
        url: '/vagas/pesquisar',
        method: 'GET',
        data: {
            _token: '{{ csrf_token() }}',
            campo: campo.id,
            valor: campo.value
        },
        success: function (response) {
            if (Array.isArray(response) && response.length > 0) {
                if (response.length === 1) {
                    // Preenche automaticamente quando há apenas um resultado
                    preencherCampos(response[0]);
                } else {
                    // Exibe o modal com múltiplos resultados
                    exibirResultadosModal(response);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error("Erro ao pesquisar:", error);
        }
    });
}

function preencherCampos(item) {
    document.getElementById('Pcmso_id').value = item.idPcmso;
    document.getElementById('Funcao_id').value = item.idFuncao;
    document.getElementById('descricaoFuncao').value = item.descricaoFuncao;
    document.getElementById('descricaoLocal').value = item.descricaoLocal;
}

function exibirResultadosModal(resultados) {
    var tableBody = document.getElementById('resultTableBody');
    tableBody.innerHTML = '';

    resultados.forEach(function (item) {
        var row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.descricaoFuncao || ''}</td>
            <td>${item.descricaoLocal || ''}</td>
        `;

        row.addEventListener('click', function () {
            preencherCampos(item);
            $('#resultModal').modal('hide');
        });

        tableBody.appendChild(row);
    });

    $('#resultModal').modal('show');
}


const atividades = new FroalaEditor('#atividades', {
    quickInsertTags: [],
    toolbarButtons: [
        'bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', '|',
        'align', 'formatOL', 'formatUL', 'insertHR', 'insertTable', 'insertImage', 'insertFile'
    ],
    attribution: false,
    enter: FroalaEditor.ENTER_DIV,
    heightMin: 200,
    width: '100%',
    events: {
        'initialized': function () {
            const editorInstance = this;

            if (typeof window.configurarBotaoArquivo === 'function') {
                window.configurarBotaoArquivo(editorInstance);
            }

            if (typeof window.configurarBotaoImagem === 'function') {
                window.configurarBotaoImagem(editorInstance);
            }

        },
        'image.error': function (error, response) {
            console.warn("Erro ao inserir imagem:", error);
        },
        'file.error': function (error, response) {
            console.warn("Erro ao inserir arquivo:", error);
        }
    }
});

const requisitos = new FroalaEditor('#requisitos', {
    quickInsertTags: [],
    toolbarButtons: [
        'bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', '|',
        'align', 'formatOL', 'formatUL', 'insertHR', 'insertTable', 'insertImage', 'insertFile'
    ],
    attribution: false,
    enter: FroalaEditor.ENTER_DIV,
    heightMin: 200,
    width: '100%',
    events: {
        'initialized': function () {
            const editorInstance = this;

            if (typeof window.configurarBotaoArquivo === 'function') {
                window.configurarBotaoArquivo(editorInstance);
            }

            if (typeof window.configurarBotaoImagem === 'function') {
                window.configurarBotaoImagem(editorInstance);
            }

        },
        'image.error': function (error, response) {
            console.warn("Erro ao inserir imagem:", error);
        },
        'file.error': function (error, response) {
            console.warn("Erro ao inserir arquivo:", error);
        }
    }
});

const condicoes = new FroalaEditor('#condicoes', {
    quickInsertTags: [],
    toolbarButtons: [
        'bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', '|',
        'align', 'formatOL', 'formatUL', 'insertHR', 'insertTable', 'insertImage', 'insertFile'
    ],
    attribution: false,
    enter: FroalaEditor.ENTER_DIV,
    heightMin: 200,
    width: '100%',
    events: {
        'initialized': function () {
            const editorInstance = this;

            if (typeof window.configurarBotaoArquivo === 'function') {
                window.configurarBotaoArquivo(editorInstance);
            }

            if (typeof window.configurarBotaoImagem === 'function') {
                window.configurarBotaoImagem(editorInstance);
            }
        },
        'image.error': function (error, response) {
            console.warn("Erro ao inserir imagem:", error);
        },
        'file.error': function (error, response) {
            console.warn("Erro ao inserir arquivo:", error);
        }
    }
});

setTimeout(() => {
    document.querySelectorAll('p[data-f-id="pbf"], p:empty').forEach(el => {
        el.remove();
    });
}, 500);

document.addEventListener("DOMContentLoaded", function () {
    const allCheckbox = document.querySelector("input[name='beneficios_9']");
    const checkboxes = document.querySelectorAll(".grupo-checkbox");

    if (allCheckbox) {
        // Função para verificar se todos os checkboxes estão marcados
        function checkIfAllSelected() {
            const allSelected = [...checkboxes].every(checkbox => checkbox.checked || checkbox === allCheckbox);
            allCheckbox.checked = allSelected;
        }

        // Evento para marcar/desmarcar todos os checkboxes quando "Todos" é alterado
        allCheckbox.addEventListener("change", function () {
            const isChecked = this.checked;
            checkboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
        });

        // Adiciona eventos de mudança para todos os checkboxes individuais
        checkboxes.forEach(checkbox => {
            if (checkbox !== allCheckbox) { // Ignora o checkbox "Todos"
                checkbox.addEventListener("change", function () {
                    // Verifica se todos os checkboxes individuais estão marcados
                    checkIfAllSelected();
                });
            }
        });

        // Inicializa o estado correto ao carregar a página
        checkIfAllSelected();
    }
});


document.addEventListener('DOMContentLoaded', function () {
    // Remove todos os parágrafos que contêm "Froala Editor"
    document.querySelectorAll('p').forEach(p => {
        if (p.innerHTML.includes('Froala Editor')) {
            p.remove();
        }
    });

    // Remove parágrafos vazios (opcional)
    document.querySelectorAll('p').forEach(p => {
        if (!p.textContent.trim()) {
            p.remove();
        }
    });
});