create table users(
    id MEDIUMINT UNSIGNED not null auto_increment,
    username VARCHAR(50) not null,
    hashed_password VARCHAR(255) not null,
    primary key (id)
);

create table stories(
    id INT UNSIGNED not null auto_increment,
    title VARCHAR(255) not null,
    contents LONGTEXT not null,
    author_id MEDIUMINT UNSIGNED not null,
    likes MEDIUMINT UNSIGNED not null default 0,
    likes_user_id_string LONGTEXT default '',
    link VARCHAR(255),
    primary key (id),
    foreign key (author_id) references users (id)
);

create table comments(
    id INT UNSIGNED not null auto_increment,
    contents TEXT not null,
    commenter_id MEDIUMINT UNSIGNED not null,
    story_id INT UNSIGNED not null,
    primary key (id),
    foreign key (commenter_id) references users (id),
    foreign key (story_id) references stories (id)
);
