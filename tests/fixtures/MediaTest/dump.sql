INSERT INTO users(id, first_name, last_name, email, password, remember_token, role_id, created_at, updated_at) VALUES
 (1, 'Alien South1',  'dffdfdfdssfd1', '1fidel.kutch@example.com', '$2a$12$b.zlOt1gxlQBy5c8LBV2B.r6x70he0721wBnegmAdKwP9pdZLkcCe', null, 1, '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
 (2, 'Alien South2',  'dffdfdfdssfd2', '2fidel.kutch@example.com', '$2a$12$b.zlOt1gxlQBy5c8LBV2B.r6x70he0721wBnegmAdKwP9pdZLkcCe', null, 2, '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
 (3, 'Alien South3',  'dffdfdfdssfd3', '3fidel.kutch@example.com', '$2a$12$b.zlOt1gxlQBy5c8LBV2B.r6x70he0721wBnegmAdKwP9pdZLkcCe', null, 3, '2016-10-20 11:05:00', '2016-10-20 11:05:00');

INSERT INTO media(name, user_id, link, created_at, updated_at) VALUES
  ('file.png', 1 , 'file.png', '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
  ('Category Photo photo', 1, 'http://localhost/test1.jpg', '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
  ('Deleted photo', 2, 'http://localhost/test3.jpg', '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
  ('Photo', 2, 'http://localhost/test4.jpg', '2016-10-20 11:05:00', '2016-10-20 11:05:00');
