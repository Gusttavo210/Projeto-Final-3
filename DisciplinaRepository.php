<?php
class DisciplinaRepository
{
    private $conn;

    public function __construct() {

        $connection = new Connection();
        $this->conn = $connection->getConnection();
    }
    
    function fnAddAluno(Aluno $aluno): bool
    {
        try {

            $query = "insert into aluno (nome) values (:pnome) on conflict do nothing";

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":pnome", $aluno->getNome());

            if ($stmt->execute())
                return true;

            return false;
        } catch (PDOException $error) {
            echo "Erro ao inserir o aluno no banco. Erro: {$error->getMessage()}";
            return false;
        } finally {
            unset($this->conn);
            unset($stmt);
        }
    }
    
    function fnUpdateAluno(Aluno $aluno): bool
    {
        try {

            $query = "update aluno set nome = :pnome where id = :pid";

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":pid", $aluno->getId());
            $stmt->bindValue(":pnome", $aluno->getNome());

            if ($stmt->execute())
                return true;

            return false;
        } catch (PDOException $error) {
            echo "Erro ao atualizar aluno no banco. Erro: {$error->getMessage()}";
            return false;
        } finally {
            unset($this->conn);
            unset($stmt);
        }
    }

    function fnAddProfessor($professor): bool
    {
        try {

            $query = "insert into produto (nome, descricao, status, aluno_id) ";
            $query .= "values (:pnome, :pdescricao, :pstatus, :palunoId)";
            $query .= " on conflict do nothing";

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":pnome", $professor->getNome());
            $stmt->bindValue(":pdescricao", $professor->getDescricao());
            $stmt->bindValue(":pstatus", $professor->getStatus());
            $stmt->bindValue(":pALUNOId", $professor->getAlunoId());

            if ($stmt->execute())
                return true;

            return false;
        } catch (PDOException $error) {
            echo "Erro ao inserir o professor no banco. Erro: {$error->getMessage()}";
            return false;
        } finally {
            unset($this->conn);
            unset($stmt);
        }
    }
    
    function fnUpdateProfessor($professor): bool
    {
        try {

            $query = "update produto set nome = :pnome, descricao = :pdescricao, status = :pstatus ";
            $query .= "where id = :pid";

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":pnome", $professor->getNome());
            $stmt->bindValue(":pdescricao", $professor->getDescricao());
            $stmt->bindValue(":pstatus", $professor->getStatus());
            $stmt->bindValue(":pid", $professor->getId());

            if ($stmt->execute())
                return true;

            return false;
        } catch (PDOException $error) {
            echo "Erro ao inserir o professor no banco. Erro: {$error->getMessage()}";
            return false;
        } finally {
            unset($this->conn);
            unset($stmt);
        }
    }
    
    function fnUpdateAlunoProfesssor($professor): bool
    {
        try {

            $query = "update professor set aluno_id = :palunoId ";
            $query .= "where id = :pid";

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":palunoId", $professor->getAlunoId());
            $stmt->bindValue(":pid", $professor->getId());

            if ($stmt->execute())
                return true;

            return false;
        } catch (PDOException $error) {
            echo "Erro ao inserir o professor no banco. Erro: {$error->getMessage()}";
            return false;
        } finally {
            unset($this->conn);
            unset($stmt);
        }
    }

    function fnAddDisciplina($disciplina): bool
    {
        try {

            $query = "insert into estoque (data_cadastro, nome, professor_id) ";
            $query .= "values (:pdataCadastro, :pnome, :pprofessorId)";
            $query .= " on conflict do nothing";

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":pdataCadastro", $disciplina->getDataCadastro());
            $stmt->bindValue(":pnome", $disciplina->getNome());
            $stmt->bindValue(":pprofessorId", $disciplina->getProfessorId());

            if ($stmt->execute())
                return true;

            return false;
        } catch (PDOException $error) {
            echo "Erro ao inserir a disciplina no banco. Erro: {$error->getMessage()}";
            return false;
        } finally {
            unset($this->conn);
            unset($stmt);
        }
    }

    public function fnListAluno($limit) {
        try {

            $query = "select id, nome, criado_em criadoem from aluno limit :plimit";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':plimit', $limit);

            if($stmt->execute()) {
                $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Aluno');
                return  $stmt->fetchAll();
            }

            return false;
        } catch (PDOException $error) {
            echo "Erro ao listar os alunos no banco. Erro: {$error->getMessage()}";
            return false;
        } finally {
            unset($this->conn);
            unset($stmt);
        }
    }

    public function fnLocalizarAluno($id) {
        try {
            $query = "select * from aluno where id = :pid";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':pid', $id);

            if ($stmt->execute()) {
                $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Aluno');
                return  $stmt->fetch();
            }

            return false;
        } catch (PDOException $error) {
            echo "Erro ao listar as alunos no banco. Erro: {$error->getMessage()}";
            return false;
        } finally {
            unset($this->conn);
            unset($stmt);
        }
    }
    
    public function fnListAlunoIn($ids) {
        try {

            $inQuery = implode(',', array_fill(0, count($ids), '?'));
            $query = "select * from aluno where id in ({$inQuery})";
            
            $stmt = $this->conn->prepare($query);
            foreach ($ids as $k => $id)
                $stmt->bindValue(($k + 1), $id);

            if ($stmt->execute()) {
                $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Aluno');
                return  $stmt->fetchAll();
            }

            return false;
        } catch (PDOException $error) {
            echo "Erro ao listar as alunos no banco. Erro: {$error->getMessage()}";
            return false;
        } finally {
            unset($this->conn);
            unset($stmt);
        }
    }
    
    public function fnListProfessor($limit) {
        try {

            $query = "select id, nome, descricao, status, aluno_id alunoId, criado_em criadoEm from professor order by criado_em desc limit :plimit";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':plimit', $limit);

            if ($stmt->execute()) {
                $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Professor');
                return  $stmt->fetchAll();
            }

            return false;
        } catch (PDOException $error) {
            echo "Erro ao listar os professores no banco. Erro: {$error->getMessage()}";
            return false;
        } finally {
            unset($this->conn);
            unset($stmt);
        }
    }

    public function fnLocalizarProfessor($id) {
        try {

            $query = "select id, nome, descricao, status, aluno_id alunoId, criado_em criadoEm from professor where id = :pid";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':pid', $id);

            if ($stmt->execute()) {
                $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Professor');
                return  $stmt->fetch();
            }

            return false;
        } catch (PDOException $error) {
            echo "Erro ao listar os professores no banco. Erro: {$error->getMessage()}";
            return false;
        } finally {
            unset($this->conn);
            unset($stmt);
        }
    }

    public function fnListDisciplina($limit = 9999) {
        try {

            $query = "id, data_cadastro datacadastro, nome, professor_id  professorid from disciplina order by criado_em desc limit :plimit";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':plimit', $limit);

            if ($stmt->execute()) {
                $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Disciplina');
                return  $stmt->fetch();
            }

            return false;
        } catch (PDOException $error) {
            echo "Erro ao listar as disciplinas do estoque no banco. Erro: {$error->getMessage()}";
            return false;
        } finally {
            unset($this->conn);
            unset($stmt);
        }
    }

    public function fnListAlunosQuantidade($limit = 9999) {
        try {

            $query = "select aluno.nome aluno, count(aluno_id) quantidade from professor " .
            "join aluno on aluno.id = aluno_id group by (aluno.nome, aluno_id) " .
            "order by count(aluno_id) desc limit :plimit;";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':plimit', $limit);

            if ($stmt->execute())
                return $stmt->fetchAll(PDO::FETCH_OBJ);

            return false;
        } catch (PDOException $error) {
            echo "Erro ao listar os alunos com quantidade no banco. Erro: {$error->getMessage()}";
            return false;
        } finally {
            unset($this->conn);
            unset($stmt);
        }
    }
}