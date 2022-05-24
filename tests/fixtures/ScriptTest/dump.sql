INSERT INTO users(id, first_name, last_name, email, password, remember_token, role_id, created_at, updated_at) VALUES
 (1, 'Alien South1',  'dffdfdfdssfd1', '1fidel.kutch@example.com', '$2a$12$b.zlOt1gxlQBy5c8LBV2B.r6x70he0721wBnegmAdKwP9pdZLkcCe', null, 1, '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
 (2, 'Alien South2',  'dffdfdfdssfd2', '2fidel.kutch@example.com', '$2a$12$b.zlOt1gxlQBy5c8LBV2B.r6x70he0721wBnegmAdKwP9pdZLkcCe', null, 2, '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
 (3, 'Alien South3',  'dffdfdfdssfd3', '3fidel.kutch@example.com', '$2a$12$b.zlOt1gxlQBy5c8LBV2B.r6x70he0721wBnegmAdKwP9pdZLkcCe', null, 3, '2016-10-20 11:05:00', '2016-10-20 11:05:00');

INSERT INTO media(name, user_id, link, created_at, updated_at) VALUES
 ('file.png', 1 , 'file.png', '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
 ('Category Photo photo', 1, 'http://localhost/test1.jpg', '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
 ('Deleted photo', 2, 'http://localhost/test3.jpg', '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
 ('Photo', 2, 'http://localhost/test4.jpg', '2016-10-20 11:05:00', '2016-10-20 11:05:00');

INSERT INTO scripts(id, title, description, cover_id, created_at, updated_at) VALUES
 (1, 'title', 'description', 1,  null, null),
 (2, 'title1', 'description', 1,  null, null),
 (3, 'title2', 'description', 1,  null, null);

INSERT INTO achievements(id, script_id, title, incomplete_cover_id, complete_cover_id, incomplete_message, complete_message, created_at, updated_at) VALUES
 (1, 1, 'title', 1, 2, 'msg', 'msg',  null, null),
 (2, 1, 'title1', 1, 2, 'msg', 'msg',  null, null),
 (3, 1, 'title2', 1, 2, 'msg', 'msg',  null, null),
 (4, 2, 'title3', 1, 2, 'msg', 'msg',  null, null),
 (5, 1, 'title4', 1, 2, 'msg', 'msg',  null, null);
