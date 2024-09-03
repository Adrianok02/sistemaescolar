<?php
function alterar_materia(){

    $codigoMateriaAlterar = $_POST["codigo"];    
    $turma       = $_POST["turma"];
    $nome         = $_POST["nome"];
    
    $dadosMateria = @file_get_contents("materia.json");
    $arDadosMateria = json_decode($dadosMateria, true);

    $arDadosMateriaNovo = array();
    foreach($arDadosMateria as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoMateriaAlterar == $codigoAtual){
            $aDados["nome"] = $nome;
            $aDados["turma"] = (int)$turma;
        }

        $arDadosMateriaNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("materia.json", json_encode($arDadosMateriaNovo));
}

function excluir_materia(){
    $codigoMateriaExcluir = $_GET["codigo"];

    $dadosMateria = @file_get_contents("materia.json");
    $arDadosMateria = json_decode($dadosMateria, true);

    $arDadosMateriaNovo = array();
    foreach($arDadosMateria as $aDados){
        $codigoAtual = $aDados["codigo"];
        if($codigoMateriasExcluir == $codigoAtual){
            continue;
        }

        $arDadosMateriaNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("materia.json", json_encode($arDadosMateriaNovo));
}

function incluir_materia(){
    $arDadosMateria = array();

    // Primeiro, verifica se existe dados no arquivo json
    // @ na frente do metodo, remove o warning
    $dadosMateria = @file_get_contents("materia.json");
    if($dadosMateria){
        // transforma os dados lidos em ARRAY, que estavam em JSON
        $arDadosMateria = json_decode($dadosMateria, true);
    }

    // Armazenar os dados do turma atual, num array associativo

    $aDadosMateriaAtual = array();
    $aDadosMateriaAtual["codigo"] = getProximoCodigo($arDadosMateria);

    $aDadosMateriaAtual["turma"]       = $_POST["turma"];
    $aDadosMateriaAtual["nome"]         = $_POST["nome"];

    
    // Pega os dados atuais do turma e armazena no array que foi lido
    $arDadosMateria[] = $aDadosMateriaAtual;

    // Gravar os dados no arquivo
    file_put_contents("materia.json", json_encode($arDadosMateria));
}

function getProximoCodigo($arDadosMateria){
    $ultimoCodigo = 0;
    foreach($arDadosMateria as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoAtual > $ultimoCodigo){
            $ultimoCodigo = $codigoAtual;
        }      
    }

    return $ultimoCodigo + 1;
}

// echo "<pre>" . print_r($_POST, true) . "</pre>";return true;

// Verificar se esta setado o $_POST
if(isset($_POST["ACAO"])){
    $acao = $_POST["ACAO"];
    if($acao == "INCLUIR"){
        incluir_materia();

        // Redireciona para a pagina de consulta de turma
        header('Location: consulta_materia.php');
    } else if($acao == "ALTERAR"){        
        alterar_materia();

        // Redireciona para a pagina de consulta de turma
        header('Location: consulta_materia.php');
    }
} else if(isset($_GET["ACAO"])){
    $acao = $_GET["ACAO"];
    if($acao == "EXCLUIR"){
        excluir_materia();
        
        // Redireciona para a pagina de consulta de turma
        header('Location: consulta_materia.php');
    } else if($acao == "ALTERAR"){
        // CAMEL CASE
        $codigoMateriaAlterar = $_GET["codigo"];
        
        // Redireciona para a pagina de turma
        header('Location: materia.php?ACAO=ALTERAR&codigo=' . $codigoMateriaAlterar);
    }
} else {
    // Redireciona para a pagina de consulta de turma
    header('Location: consulta_materia.php');
}
