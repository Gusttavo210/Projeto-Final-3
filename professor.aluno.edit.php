<?php 
    require_once('config/config.php');

    $service = new ProfessorService();

    $id = filter_input(INPUT_POST, 'inputId', FILTER_SANITIZE_NUMBER_INT);
    $alunoId = filter_input(INPUT_POST, 'inputAluno', FILTER_SANITIZE_NUMBER_INT);

    $professor = new Professor();
    $professor->setId($id);
    $professor->setAlunoId($alunoId);

    if ($service->atualizarAluno($professor)) {
        $notificacao = new stdClass();
        $notificacao->status = "success";
        $notificacao->acao = "Atualizar";
        $notificacao->pagina = "Professor";
        $notificacao->msg = "Categoria do professor atualizado com sucesso";
        $_SESSION['status'] = serialize($notificacao);
    } else {
        $notificacao = new stdClass();
        $notificacao->status = "danger";
        $notificacao->acao = "Atualizar";
        $notificacao->pagina = "Professor";
        $notificacao->msg = "Falha ao atualizar a categoria do professor";
        $_SESSION['status'] = serialize($notificacao);
    }

    header("location: load.php/load-professor/{$professor->getId()}");
    exit;