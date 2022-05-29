use luigi_branchina_hw1;
create table utente(
id integer auto_increment primary key,
username varchar(50) unique,
pswd varchar(50),
nome varchar(50),
cognome varchar(50),
data_nascita date,
email varchar(50) unique);

create table playlist(
id integer auto_increment primary key,
creatore integer,
index index_id(creatore),
nome varchar(50),
thumbnail varchar(150) default' ' NOT NULL,
foreign key (creatore) references utente(id),
unique(creatore, nome));

create table video(
id varchar(50) primary key,
titolo varchar(100) unique,
descrizione varchar(1000),
thumbnail varchar(150));

create table associato(
id_playlist integer,
id_video varchar(50),
index index_playlist(id_playlist),
index index_video(id_video),
foreign key (id_playlist) references playlist(id),
foreign key (id_video) references video(id),
primary key(id_playlist, id_video));