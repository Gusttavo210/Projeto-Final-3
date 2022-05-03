<?php
    require_once('config/config.php');

    $alunoService = new AlunoService();
    $professorService = new ProfessorService();
    $usuarioService = new UsuarioService();

    $pathUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $urlSegments = explode('/', substr($pathUri, 1));

    if($urlSegments[count($urlSegments) - 1] == 'load-alunos') {
        $_SESSION['alunos'] = serialize($alunoService->listar(10));

        header('location: /disciplina/alunos');
        exit;
    }
    
    if($urlSegments[count($urlSegments) - 1] == 'load-professores') {
        $_SESSION['professores'] = serialize($professorService->listar(10));

        header('location: /disciplina/professores');
        exit;
    }
    
    if($urlSegments[count($urlSegments) - 1] == 'load-usuarios') {
        $_SESSION['usuarios'] = serialize($usuarioService->listar(10));

        header('location: /disciplina/usuarios');
        exit;
    }

    if($urlSegments[count($urlSegments) - 2] == 'load-aluno') {
        $id = $urlSegments[count($urlSegments) - 1];
        $_SESSION['aluno'] = serialize($alunoService->LocalizarPorId($id));

        header('location: /disciplina/aluno.details');
        exit;
    }

    if($urlSegments[count($urlSegments) - 2] == 'load-usuario') {
        $id = $urlSegments[count($urlSegments) - 1];
        $_SESSION['usuario'] = serialize($usuarioService->LocalizarPorId($id));

        header('location: /disciplina/usuario.details');
        exit;
    }

    if($urlSegments[count($urlSegments) - 1] == 'load-home') {
        $_SESSION['professores'] = serialize($professorService->listar(3));
        $_SESSION['alunos'] = serialize($alunoService->listarComQuantidade(3));
        
        header('location: /disciplina/home');
        exit;
    }