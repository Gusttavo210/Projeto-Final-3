drop table if exists aluno cascade;
create table if not exists aluno(
    id serial primary key,
    nome varchar(50) unique not null,
    criado_em timestamp not null default current_timestamp
);

drop table if exists professor cascade;
create table if not exists professor(
    id serial primary key,
    nome varchar(255) unique not null,
    descricao text not null,
    status int not null,
	aluno_id int not null,
    criado_em timestamp not null default current_timestamp,
	foreign key(aluno_id) references aluno(id)
);

drop table if exists disciplina cascade;
create table if not exists disciplina(
    id serial primary key,
    data_cadastro timestamp not null default current_timestamp,
    nome varchar(50) unique not null,
	professor_id int not null,
    criado_em timestamp not null default current_timestamp,
	foreign key(professor_id) references professor(id)
);

drop table if exists usuario cascade;
create table if not exists usuario(
    id serial primary key,
    nome varchar(150) not null,
    email varchar(150) not null,
    senha varchar(150) not null
);

drop table auth_token;
create table auth_token(
    id serial not null,
    usuario_id int not null unique,
    token text not null,
    encryption_key text not null,
    ultimo_acesso timestamp not null default current_timestamp,
    atualizado_em timestamp not null default current_timestamp,
    criado_em timestamp not null default current_timestamp,
    primary key(id)
);