<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/main.js" type='module' defer></script>
    <title>ViaCEP</title>
</head>
<body>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    :root {
        --bg-color: grey;
        --primary-color: white
    }

body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: var(--bg-color) ;
}

.container {
    flex-grow: 3;
    display: flex;
    flex-direction: column;
    width: 80%;
    padding: 20px;
    gap: 40px;
}

.title {
    font-size: 40px;
    text-align: center;
    user-select: none;
    color: var(--primary-color);
}

.row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 40px;
}
.inputbox {
    position: relative;
    display: flex;
    flex-direction: column-reverse;
    height: 40px;
}


.inputbox input {
    position: absolute;
    background-color: var(--primary-color);
    width: 100%;
    height: 3px;
    bottom: 0;
    box-shadow: none;
    border: none;
    outline: none;
    border-radius: 2px;
    transition: .5s;
    font-size: 20px;
    font-weight: bold;
    padding: 0 10px;
}

.inputbox input:focus,
.inputbox input:valid {
    height: 100%;
}

.inputbox input:focus + label,
.inputbox input:valid + label {
    top: -40px;
    left: 0;
}
    </style>
    <main class="container">
        <h1 class="title">Atividade ViaCEP</h1>
        <div class="row">
            <div class="inputbox">
                <input type="text" id="cep"  required>
                <label for="cep">Digite seu CEP</label>
            </div>
            <div class="inputbox">
                <input type="text" id="endereco"  required>
                <label for="endereco">Rua</label>
            </div>
        </div>
        <div class="row">
            <div class="inputbox">
                <input type="text" id="bairro"  required>
                <label for="bairro">Bairro</label>
            </div>
            <div class="inputbox">
                <input type="text" id="cidade"  required>
                <label for="cidade">Cidade</label>
            </div>
            <div class="inputbox">
                <input type="text" id="estado"  required>
                <label for="estado">Estado</label>
            </div>
        </div>
    </main>
    <script>
        'use strict';

        const limparFormulario = (endereco) =>{
            document.getElementById('endereco').value = '';
            document.getElementById('bairro').value = '';
            document.getElementById('cidade').value = '';
            document.getElementById('estado').value = '';
        };


        const preencherFormulario = (endereco) =>{
            document.getElementById('endereco').value = endereco.logradouro;
            document.getElementById('bairro').value = endereco.bairro;
            document.getElementById('cidade').value = endereco.localidade;
            document.getElementById('estado').value = endereco.uf;
        };


        const eNumero = (numero) => /^[0-9]+$/.test(numero);

        const cepValido = (cep) => cep.length == 8 && eNumero(cep); 

        const pesquisarCep = async() => {
            limparFormulario();

            const cep = document.getElementById('cep').value.replace("-","");
            const url = `https://viacep.com.br/ws/${cep}/json/`;
            if (cepValido(cep)){
                const dados = await fetch(url);
                const endereco = await dados.json();
                if (endereco.hasOwnProperty('erro')){
                    document.getElementById('endereco').value = 'CEP não encontrado!';
                }else {
                    preencherFormulario(endereco);
                }
            }else{
                document.getElementById('endereco').value = 'CEP incorreto!';
            }
        };

        document.getElementById('cep')
        .addEventListener('focusout',pesquisarCep);
    </script>
</body>
</html>