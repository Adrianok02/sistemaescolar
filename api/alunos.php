<?php
require_once("header.php");

$sHTML = '<div> <link rel="stylesheet" href="formulario.css">';

// FORMULARIO DE CADASTRO DE ALUNOS
$sHTML .= '<h2 style="text-align:center;">Formulário de Aluno</h2>
    <form action="processar_formulario.php" method="post">
        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" value="1" required>

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required value="Gelvazio">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required value="geo@email.com">

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required value="123456">

        <input type="submit" value="Enviar">
    </form>';

// CONSULTA DE ALUNOS

$sHTML .= '<h2 style="text-align:center;">Consulta de Aluno</h2>
</div>';

echo $sHTML;

require_once("footer.php");