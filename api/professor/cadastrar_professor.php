<?php
function alterar_professor(){
    $codigoProfessorAlterar = $_POST["codigo"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    
    $dadosProfessor = @file_get_contents("professor.json");
    $arDadosProfessor = json_decode($dadosProfessor, true);

    $arDadosProfessorNovo = array();
    foreach($arDadosProfessor as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoProfessorAlterar == $codigoAtual){
            $aDados["nome"] = $nome;
            $aDados["email"] = $email;
        }

        $arDadosProfessorNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("professor.json", json_encode($arDadosProfessorNovo));
}

function excluir_professor(){
    $codigoProfessorExcluir = $_GET["codigo"];

    $dadosProfessor = @file_get_contents("professor.json");
    $arDadosProfessor = json_decode($dadosProfessor, true);

    $arDadosProfessorNovo = array();
    foreach($arDadosProfessor as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoProfessorExcluir == $codigoAtual){
            // ignora e vai para o proximo registro
            continue;
        }

        $arDadosProfessorNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("professor.json", json_encode($arDadosProfessorNovo));
}

function incluir_professor(){
    $arDadosProfessor = array();

    // Primeiro, verifica se existe dados no arquivo json
    // @ na frente do metodo, remove o warning
    $dadosProfessor = @file_get_contents("professor.json");
    if($dadosProfessor){
        // transforma os dados lidos em ARRAY, que estavam em JSON
        $arDadosProfessor = json_decode($dadosProfessor, true);
    }

    // Armazenar os dados do aluno atual, num array associativo

    $aDadosProfessorAtual = array();
    $aDadosProfessorAtual["codigo"] = getProximoCodigo($arDadosProfessor);
    $aDadosProfessorAtual["nome"] = $_POST["nome"];
    $aDadosProfessorAtual["email"] = $_POST["email"];
    $aDadosProfessorAtual["senha"] = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    // Pega os dados atuais do professor e armazena no array que foi lido
    $arDadosProfessor[] = $aDadosProfessorAtual;

    // Gravar os dados no arquivo
    file_put_contents("professor.json", json_encode($arDadosProfessor));
}

function getProximoCodigo($arDadosProfessor){
    $ultimoCodigo = 0;
    foreach($arDadosProfessor as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoAtual > $ultimoCodigo){
            $ultimoCodigo = $codigoAtual;
        }      
    }

    return $ultimoCodigo + 1;
}

// PROCESSAMENTO DA PAGINA
// echo "<pre>" . print_r($_POST, true) . "</pre>";return true;
// echo "<pre>" . print_r($_GET, true) . "</pre>";return true;

// Verificar se esta setado o $_POST
if(isset($_POST["ACAO"])){
    $acao = $_POST["ACAO"];
    if($acao == "INCLUIR"){
        incluir_professor();

        // Redireciona para a pagina de consulta de professor
        header('Location: consulta_professor.php');
    } else if($acao == "ALTERAR"){        
        alterar_professor();

        // Redireciona para a pagina de consulta de professor
        header('Location: consulta_professor.php');
    }
} else if(isset($_GET["ACAO"])){
    $acao = $_GET["ACAO"];
    if($acao == "EXCLUIR"){
        excluir_professor();

        
        // Redireciona para a pagina de consulta de professor
        header('Location: consulta_professor.php');
    } else if($acao == "ALTERAR"){
        $codigoProfessorAlterar = $_GET["codigo"];

        // Redireciona para a pagina de professor
        header('Location: professor.php?ACAO=ALTERAR&codigo=' . $codigoProfessorAlterar);
    }
} else {
    // Redireciona para a pagina de consulta de professor
    header('Location: consulta_professor.php');
}
