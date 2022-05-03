<?php 
    session_start();

    if(
        !isset($_SESSION['usuario_details']) 
        && basename($_SERVER['PHP_SELF']) != 'recuperar_senha.php'
        && basename($_SERVER['PHP_SELF']) != 'user.register.php'
    ) {
        $_SESSION['error'] = 'Faça o login primeiro';
        header('location: /escola/login');
        exit;
    }

    # https://www.php.net/manual/en/function.date-default-timezone-set
    # https://www.php.net/manual/pt_BR/function.spl-autoload-register.php

    date_default_timezone_set('America/Sao_Paulo');

    spl_autoload_register(function($usuario){
        
        $files = array(
            # incluir as classes do diretório php/model
            "php" . DIRECTORY_SEPARATOR . "model" . DIRECTORY_SEPARATOR . "Usuario.php",
            # incluir as classes do diretório php/repository
            "php" . DIRECTORY_SEPARATOR . "repository" . DIRECTORY_SEPARATOR . "UsuarioRepository.php",
            # incluir as classes do diretório php/service
            "php" . DIRECTORY_SEPARATOR . "service" . DIRECTORY_SEPARATOR . "UsuarioService.php",
        );

        foreach ($files as $usuario) {
            if(file_exists($usuario)) {
                require_once($usuario);
            }
        }
    });