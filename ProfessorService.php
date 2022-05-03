<?php

    class ProfessorService {
        
        private $repository;

        public function __construct() {
            $this->repository = new DisciplinaRepository();
        }

        public function cadastrar(Professor $professor): bool {
            return $this->repository->fnAddProfessor($professor);
        }
        
        public function atualizar(Professor $professor): bool {
            return $this->repository->fnUpdateProfessor($professor);
        }
        
        public function atualizarAluno(Professor $professor): bool {
            return $this->repository->fnUpdateAlunoProfessor($professor);
        }
        
        public function listar($limit = 9999) {
            return $this->repository->fnListProfessor($limit);
        }
        
        public function localizar($id) {
            return $this->repository->fnLocalizarProfessor($id);
        }
    } 
