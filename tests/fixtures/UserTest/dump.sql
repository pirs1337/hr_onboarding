ALTER TABLE users DISABLE TRIGGER ALL;

INSERT INTO users(id, first_name, last_name, email, password, remember_token, role_id, created_at, updated_at, date_of_birth, phone, position, starts_on, is_onboarding_required, hr_id, manager_id, lead_id, avatar_id) VALUES
    (1, 'Billy', 'Coleman', 'billy.coleman@example.com', '$2a$12$b.zlOt1gxlQBy5c8LBV2B.r6x70he0721wBnegmAdKwP9pdZLkcCe', null, 1, null, null, '1986-05-20', '+79535482530', 'admin', '2022-04-16 00:00:00', false, null, null, null, null),
    (2, 'Charlotte', 'Lyons', 'flavell@example.com', '$2a$12$h.zlOt1gxlQBy5c8LBV2F.r6x70he0721wBnegmAdKwP9pdZLkcCe', null, 2, null, null, '1992-12-04', '89255892221', 'manager', '2022-04-21 00:00:00', false, 1, 1, 1, 1),
    (3, 'Andrew',  'Montgomery', 'retoh@example.com', '$2a$12$b.zlOt1gxlQBy5c8LBV2B.r6x70he0789wBnegmAdKwP9pdZLkmCe', null, 3, null, null, '2001-06-30', '89162002943', 'intern', '2022-04-26 00:00:00', true, 2, 2, 1, 2);

INSERT INTO media(name, user_id, link, created_at, updated_at) VALUES
    ('Charlotte Avatar', 1 , 'avatar_1.png', '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
    ('Andrew Avatar', 1, 'avatar_2.jpg', '2016-10-20 11:05:00', '2016-10-20 11:05:00');

ALTER TABLE users ENABLE TRIGGER ALL;

INSERT INTO media(name, user_id, link, created_at, updated_at) VALUES
    ('file.png', 1 , 'file.png', '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
    ('Category Photo photo', 1, 'http://localhost/test1.jpg', '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
    ('Deleted photo', 2, 'http://localhost/test3.jpg', '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
    ('Photo', 2, 'http://localhost/test4.jpg', '2016-10-20 11:05:00', '2016-10-20 11:05:00');

INSERT INTO scripts(id, title, description, cover_id, created_at, updated_at) VALUES
    (1, 'title', 'description', 1,  null, null),
    (2, 'title1', 'description', 1,  null, null),
    (3, 'title2', 'description', 1,  null, null);

INSERT INTO script_user(id, user_id, script_id, created_at, updated_at) VALUES
    (1, 1, 1, null, null),
    (2, 1, 2, null, null),
    (3, 2, 3, null, null);
