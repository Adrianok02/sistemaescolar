<?php
function incluir_aluno(){
    $arDadosAlunos = array();

    // Primeiro, verifica se existe dados no arquivo json
    // @ na frente do metodo, remove o warning
    $dadosAlunos = @file_get_contents("alunos.json");
    if($dadosAlunos){
        // transforma os dados lidos em ARRAY, que estavam em JSON
        $arDadosAlunos = json_decode($dadosAlunos, true);
    }

    // Armazenar os dados do aluno atual, num array associativo

    $aDadosAlunoAtual = array();
    $aDadosAlunoAtual["codigo"] = getProximoCodigo($arDadosAlunos);
    $aDadosAlunoAtual["nome"] = $_POST["nome"];
    $aDadosAlunoAtual["email"] = $_POST["email"];
    $aDadosAlunoAtual["senha"] = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    // Pega os dados atuais do aluno e armazena no array que foi lido
    $arDadosAlunos[] = $aDadosAlunoAtual;

    // Gravar os dados no arquivo
    file_put_contents("alunos.json", json_encode($arDadosAlunos));
}

function getProximoCodigo($arDadosAlunos){
    $totalAlunos = count($arDadosAlunos);

    return $totalAlunos + 1;
}

// PROCESSAMENTO DA PAGINA
// echo "<pre>" . print_r($_POST, true) . "</pre>";return true;

// Verificar se esta setado o $_POST
if(isset($_POST["ACAO"])){
    $acao = $_POST["ACAO"];
    if($acao == "INCLUIR"){
        incluir_aluno();

        // Redireciona para a pagina de consulta de aluno
        header('Location: consulta_aluno.php');
    }
} else {
    // Redireciona para a pagina de consulta de aluno
    header('Location: consulta_aluno.php');
}
