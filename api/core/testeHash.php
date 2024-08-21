<?php 

$senha = '123456';

$password_hash = '$2y$10$aC/aml6pFXUPuDVPVftgeO4la2kZMLdwODRUDOXVNKyvzqvw1Onaq';

$verifica = password_verify($senha, $password_hash);

if($verifica){
    echo '<h1>SENHA VERIFICADA!</h1>';
} else {
    echo '<h1>SENHA INVALIDA!</h1>';
}