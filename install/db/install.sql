CREATE TABLE IF NOT EXISTS up_tasks_priority
(
	ID INT NOT NULL AUTO_INCREMENT,
	TITLE VARCHAR(80) NOT NULL,
	COLOR_SCHEME VARCHAR(6) NULL,

	PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS up_tasks_task
(
	ID INT NOT NULL AUTO_INCREMENT,
	TITLE VARCHAR(80) NOT NULL,
	DESCRIPTION VARCHAR(255) NOT NULL,
	IS_COMPLETED BOOLEAN NOT NULL,
	ID_PRIORITY INT NOT NULL,

	FOREIGN KEY (ID_PRIORITY) REFERENCES up_tasks_priority (ID),

	PRIMARY KEY(ID)
);


-- СТОИТ СОЗДАТЬ ОТДЕЛЬНУЮ ТАБЛИЦУ КОММЕНТАРИИ_ЗАДАЧИ! 
CREATE TABLE IF NOT EXISTS up_tasks_comment
(
	ID INT NOT NULL AUTO_INCREMENT,
	ID_TASK INT NOT NULL,
	COMMENT VARCHAR(255) NOT NULL,

	FOREIGN KEY (ID_TASK) REFERENCES up_tasks_task (ID),

	PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS up_tasks_metadata
(
	ID_TASK INT NOT NULL,
	DEADLINE DATETIME NULL,
	CREATING_DATE DATETIME NOT NULL,
	UPDATING_DATE DATETIME NOT NULL,
	LAST_ACTIVITY DATETIME NULL,

	FOREIGN KEY (ID_TASK) REFERENCES up_tasks_task(ID),

	PRIMARY KEY (ID_TASK)
);



-- ТЕСТОВЫЕ ДАННЫЕ --

INSERT INTO up_tasks_priority()
VALUES  (1, 'Low', 'BEBEBE'),
		(2, 'Normal', '0000FF'),
		(3, 'High', 'FF0000');
    	
INSERT INTO up_tasks_task()
VALUES  
(
	1, 
	'Десятичная система счисления', 
	'Учительница по математике сказала, что я должен подготовится к контрольной. Стоит научится решать типовые задания на сайте, чтобы я смог получить 5!', 
	0,
	2
),
(
	2, 
	'Язык и речь', 
	'Странно, что все мои задачи называются, как школьные темы для 5 классов. Ну в общем, нужно сделать домашнее по язык и речи. Это Монолог, Диалог и Полилог и т.д. Если быть точным 12 параграф.', 
	0,
	1
),
(
	3, 
	'Лабораторная работа по физике', 
	'Задача звучит так: Проведите эксперимент, измерив время, которое понадобится мячику для скатывания по наклонной плоскости разной высоты. Сделайте выводы о скорости... Мне не хватает места, чтобы записать лабораторную :(', 
	0,	
	2
),
(
	4, 
	'Лабораторная работа по химии', 
	'Изучить свойства красок и основные понятия об их смешении. Изучить свойства красок и основные понятия об их смешении. *НАПОМИНАЛКА БЛИН* материалы скинул себе в вк, тут говорю чтобы не забыть, привет будущему мне! ', 
	0,
	2
);

INSERT INTO up_tasks_metadata
VALUES 
	(1, DATE_ADD(NOW(), INTERVAL 2 DAY), NOW(), NOW(), null),
	(2, DATE_ADD(NOW(), INTERVAL 1 MONTH), NOW(), NOW(), null),
    (3, DATE_ADD(NOW(), INTERVAL 1 DAY), NOW(), NOW(), null),
    (4, DATE_SUB(NOW(), INTERVAL 4 DAY), DATE_SUB(NOW(), INTERVAL 1 MONTH), DATE_SUB(NOW(), INTERVAL 1 MONTH), null);

INSERT INTO up_tasks_comment
VALUES
	(1, 1, 'БЛАБЛАБЛА ЭТА ЗАДАЧА СЛОЖНАЯ'),
	(2, 1, 'БЛА БЛА Это 2 комментарий');