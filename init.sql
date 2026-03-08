CREATE DATABASE IF NOT EXISTS real_estate_db CHARACTER
SET
    utf8mb4 COLLATE utf8mb4_unicode_ci;

USE real_estate_db;

CREATE TABLE
    IF NOT EXISTS estate_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category_name VARCHAR(255) NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS estate_types (
        id INT AUTO_INCREMENT PRIMARY KEY,
        type_name VARCHAR(255) NOT NULL,
        category_id INT NOT NULL,
        FOREIGN KEY (category_id) REFERENCES estate_categories (id)
    );

CREATE TABLE
    IF NOT EXISTS estate_status (
        id INT AUTO_INCREMENT PRIMARY KEY,
        status_name VARCHAR(255) NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS listing_types (
        id INT AUTO_INCREMENT PRIMARY KEY,
        type_name VARCHAR(255) NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS price_ranges (
        id INT AUTO_INCREMENT PRIMARY KEY,
        range_name VARCHAR(50) NOT NULL,
        range_value VARCHAR(50) NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS regions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        region_name_bg VARCHAR(255) NOT NULL,
        region_name_en VARCHAR(255) NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS cities (
        id INT AUTO_INCREMENT PRIMARY KEY,
        region_id INT NOT NULL,
        city_name_bg VARCHAR(255) NOT NULL,
        city_name_en VARCHAR(255) NOT NULL,
        FOREIGN KEY (region_id) REFERENCES regions (id)
    );

CREATE TABLE
    IF NOT EXISTS neighborhoods (
        id INT AUTO_INCREMENT PRIMARY KEY,
        city_id INT NOT NULL,
        neighborhood_name_bg VARCHAR(255) NOT NULL,
        neighborhood_name_en VARCHAR(255) NOT NULL,
        FOREIGN KEY (city_id) REFERENCES cities (id)
    );

CREATE TABLE
    IF NOT EXISTS user_types (
        id INT AUTO_INCREMENT PRIMARY KEY,
        type_name VARCHAR(255) NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        user_type_id INT NOT NULL,
        FOREIGN KEY (user_type_id) REFERENCES user_types (id)
    );

CREATE TABLE
    IF NOT EXISTS estates (
        id INT AUTO_INCREMENT PRIMARY KEY,
        city_id INT NOT NULL,
        neighborhood_id INT NOT NULL,
        estate_address VARCHAR(255) NOT NULL,
        estate_type_id INT,
        rooms INT NOT NULL,
        area DECIMAL(10, 2) NOT NULL,
        floor INT NOT NULL,
        exposure_type VARCHAR(255) NOT NULL,
        description TEXT,
        listing_type_id INT NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        owner_id INT NOT NULL,
        creation_date DATE NOT NULL,
        expiration_date DATE NOT NULL,
        status_id INT NOT NULL,
        FOREIGN KEY (estate_type_id) REFERENCES estate_types (id),
        FOREIGN KEY (city_id) REFERENCES cities (id),
        FOREIGN KEY (neighborhood_id) REFERENCES neighborhoods (id),
        FOREIGN KEY (owner_id) REFERENCES users (id),
        FOREIGN KEY (listing_type_id) REFERENCES listing_types (id),
        FOREIGN KEY (status_id) REFERENCES estate_status (id)
    );

CREATE TABLE
    IF NOT EXISTS estate_images (
        id INT AUTO_INCREMENT PRIMARY KEY,
        estate_id INT NOT NULL,
        is_primary BOOLEAN NOT NULL,
        image_path VARCHAR(255) NOT NULL,
        FOREIGN KEY (estate_id) REFERENCES estates (id)
    );

CREATE TABLE
    IF NOT EXISTS audit_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        table_name VARCHAR(255) NOT NULL,
        action VARCHAR(255) NOT NULL
    );

INSERT INTO
    user_types (type_name)
VALUES
    ('Админ'),
    ('Брокер'),
    ('Частно лице'),
    ('Гост');

INSERT INTO
    estate_categories (category_name)
VALUES
    ('Жилищен'),
    ('Комерсиален'),
    ('Паркинг'),
    ('Индустриален'),
    ('Земя');

INSERT INTO
    listing_types (type_name)
VALUES
    ('Продажба'),
    ('Наем');

INSERT INTO
    estate_status (status_name)
VALUES
    ('Активна'),
    ('Капарирана'),
    ('Архивирана'),
    ('Изтекла');

INSERT INTO
    price_ranges (range_name, range_value)
VALUES
    ('low', '< 50 000 €'),
    ('low_mid', '50 000 € - 100 000 €'),
    ('mid', '100 000 € - 250 000 €'),
    ('mid_high', '250 000 € - 500 000 €'),
    ('high', '500 000 € - 1 000 000 €'),
    ('very_high', '> 1 000 000 €');

INSERT INTO
    estate_types (type_name, category_id)
VALUES
    ('1-СТАЕН', '1'),
    ('2-СТАЕН', '1'),
    ('3-СТАЕН', '1'),
    ('4-СТАЕН', '1'),
    ('МНОГОСТАЕН', '1'),
    ('ГАРСОНИЕРА', '1'),
    ('СТУДИО', '1'),
    ('КЪЩА', '1'),
    ('ЕТАЖ ОТ КЪЩА', '1'),
    ('ВИЛА', '1'),
    ('МАГАЗИН', '2'),
    ('ОФИС', '2'),
    ('ЗАВЕДЕНИЕ', '2'),
    ('РЕСТОРАНТ', '2'),
    ('АТЕЛИЕ', '2'),
    ('ХОТЕЛ', '2'),
    ('МОТЕЛ', '2'),
    ('КЪЩА ЗА ГОСТИ', '2'),
    ('ПАРКИНГ МЯСТО', '3'),
    ('ГАРАЖ', '3'),
    ('СКЛАД', '4'),
    ('ЦЕХ', '4'),
    ('ФАБРИКА', '4'),
    ('РАБОТИЛНИЦА', '4'),
    ('ЗЕМЕДЕЛСКА ЗЕМЯ', '5'),
    ('ЛОЗЕ', '5'),
    ('ОВОЩНА ГРАДИНА', '5'),
    ('ПАСИЩЕ', '5');

INSERT INTO
    regions (region_name_bg, region_name_en)
VALUES
    ('обл. Благоевград', 'Blagoevgrad'),
    ('обл. Бургас', 'Burgas'),
    ('обл. Варна', 'Varna'),
    ('обл. Велико Търново', 'Veliko Tarnovo'),
    ('обл. Видин', 'Vidin'),
    ('обл. Враца', 'Vratsa'),
    ('обл. Габрово', 'Gabrovo'),
    ('обл. Добрич', 'Dobrich'),
    ('обл. Кърджали', 'Kardzhali'),
    ('обл. Кюстендил', 'Kyustendil'),
    ('обл. Ловеч', 'Lovech'),
    ('обл. Монтана', 'Montana'),
    ('обл. Пазарджик', 'Pazardzhik'),
    ('обл. Перник', 'Pernik'),
    ('обл. Плевен', 'Pleven'),
    ('обл. Пловдив', 'Plovdiv'),
    ('обл. Разград', 'Razgrad'),
    ('обл. Русе', 'Ruse'),
    ('обл. Силистра', 'Silistra'),
    ('обл. Сливен', 'Sliven'),
    ('обл. Смолян', 'Smolyan'),
    ('обл. София (столица)', 'Sofia City'),
    ('обл. София (област)', 'Sofia'),
    ('обл. Стара Загора', 'Stara Zagora'),
    ('обл. Търговище', 'Targovishte'),
    ('обл. Хасково', 'Haskovo'),
    ('обл. Шумен', 'Shumen'),
    ('обл. Ямбол', 'Yambol');

INSERT INTO
    cities (region_id, city_name_BG, city_name_EN)
VALUES
    (1, 'Благоевград', 'Blagoevgrad'),
    (1, 'Банско', 'Bansko'),
    (1, 'Сандански', 'Sandanski'),
    (1, 'Разлог', 'Razlog'),
    (1, 'Петрич', 'Petrich'),
    (1, 'Гоце Делчев', 'Gotse Delchev'),
    (2, 'Бургас', 'Burgas'),
    (2, 'Несебър', 'Nesebar'),
    (2, 'Поморие', 'Pomorie'),
    (2, 'Созопол', 'Sozopol'),
    (2, 'Приморско', 'Primorsko'),
    (2, 'Царево', 'Tsarevo'),
    (2, 'Айтос', 'Aytos'),
    (2, 'Карнобат', 'Karnobat'),
    (3, 'Варна', 'Varna'),
    (3, 'Аксаково', 'Aksakovo'),
    (3, 'Бяла', 'Byala'),
    (3, 'Девня', 'Devnya'),
    (4, 'Велико Търново', 'Veliko Tarnovo'),
    (4, 'Горна Оряховица', 'Gorna Oryahovitsa'),
    (4, 'Лясковец', 'Lyaskovets'),
    (4, 'Елена', 'Elena'),
    (4, 'Свищов', 'Svishtov'),
    (4, 'Павликени', 'Pavlikeni'),
    (4, 'Полски Тръмбеш', 'Polski Trambesh'),
    (5, 'Видин', 'Vidin'),
    (5, 'Белоградчик', 'Belogradchik'),
    (5, 'Кула', 'Kula'),
    (5, 'Брегово', 'Bregovo'),
    (6, 'Враца', 'Vratsa'),
    (6, 'Козлодуй', 'Kozloduy'),
    (6, 'Мездра', 'Mezdra'),
    (6, 'Бяла Слатина', 'Byala Slatina'),
    (6, 'Оряхово', 'Oryahovo'),
    (6, 'Криводол', 'Krivodol'),
    (6, 'Роман', 'Roman'),
    (6, 'Мизия', 'Miziya'),
    (7, 'Габрово', 'Gabrovo'),
    (7, 'Севлиево', 'Sevlievo'),
    (7, 'Трявна', 'Tryavna'),
    (7, 'Дряново', 'Dryanovo'),
    (8, 'Добрич', 'Dobrich'),
    (8, 'Балчик', 'Balchik'),
    (8, 'Каварна', 'Kavarna'),
    (8, 'Шабла', 'Shabla'),
    (8, 'Генерал Тошево', 'General Toshevo'),
    (8, 'Тервел', 'Tervel'),
    (9, 'Кърджали', 'Kardzhali'),
    (9, 'Момчилград', 'Momchilgrad'),
    (9, 'Джебел', 'Dzhebel'),
    (9, 'Крумовград', 'Krumovgrad'),
    (9, 'Кирково', 'Kardzhali'),
    (10, 'Кюстендил', 'Kyustendil'),
    (10, 'Дупница', 'Dupnitsa'),
    (10, 'Сапарева баня', 'Sapareva Banya'),
    (10, 'Бобов дол', 'Bobov Dol'),
    (10, 'Бобошево', 'Boboshevo'),
    (10, 'Рила', 'Rila'),
    (10, 'Кочериново', 'Kocherinovo'),
    (11, 'Ловеч', 'Lovech'),
    (11, 'Троян', 'Troyan'),
    (11, 'Априлци', 'Apriltsi'),
    (11, 'Тетевен', 'Teteven'),
    (11, 'Луковит', 'Lukovit'),
    (11, 'Ябланица', 'Yablanitsa'),
    (11, 'Летница', 'Letnitsa'),
    (12, 'Монтана', 'Montana'),
    (12, 'Лом', 'Lom'),
    (12, 'Берковица', 'Berkovitsa'),
    (12, 'Вършец', 'Varshets'),
    (12, 'Чипровци', 'Chiprovtsi'),
    (12, 'Бойчиновци', 'Boychinovtsi'),
    (12, 'Вълчедръм', 'Valchedram'),
    (12, 'Брусарци', 'Brusartsi'),
    (13, 'Пазарджик', 'Pazardzhik'),
    (13, 'Панагюрище', 'Panagyurishte'),
    (13, 'Пещера', 'Peshtera'),
    (13, 'Септември', 'Septemvri'),
    (13, 'Батак', 'Batak'),
    (13, 'Стрелча', 'Strelcha'),
    (14, 'Перник', 'Pernik'),
    (14, 'Радомир', 'Radomir'),
    (14, 'Брезник', 'Breznik'),
    (15, 'Плевен', 'Pleven'),
    (15, 'Белене', 'Belene'),
    (15, 'Левски', 'Levski'),
    (15, 'Никопол', 'Nikopol'),
    (15, 'Кнежа', 'Knezha'),
    (15, 'Червен бряг', 'Cherven Bryag'),
    (15, 'Долна Митрополия', 'Dolna Mitropoliya'),
    (15, 'Гулянци', 'Gulyantsi'),
    (15, 'Пордим', 'Pordim'),
    (16, 'Пловдив', 'Plovdiv'),
    (16, 'Асеновград', 'Asenovgrad'),
    (16, 'Карлово', 'Karlovo'),
    (16, 'Сопот', 'Sopot'),
    (16, 'Раковски', 'Rakovski'),
    (16, 'Стамболийски', 'Stamboliyski'),
    (16, 'Хисаря', 'Hisarya'),
    (16, 'Съединение', 'Saedinenie'),
    (16, 'Кричим', 'Krichim'),
    (17, 'Разград', 'Razgrad'),
    (17, 'Исперих', 'Isperih'),
    (17, 'Кубрат', 'Kubrat'),
    (17, 'Цар Калоян', 'Tsar Kaloyan'),
    (17, 'Лозница', 'Loznitsa'),
    (17, 'Завет', 'Zavet'),
    (18, 'Русе', 'Ruse'),
    (18, 'Две могили', 'Dve Mogili'),
    (18, 'Сливо поле', 'Slivo Pole'),
    (19, 'Силистра', 'Silistra'),
    (19, 'Тутракан', 'Tutrakan'),
    (19, 'Дулово', 'Dulovo'),
    (19, 'Алфатар', 'Alfatar'),
    (19, 'Главиница', 'Glavinitsa'),
    (20, 'Сливен', 'Sliven'),
    (20, 'Нова Загора', 'Nova Zagora'),
    (20, 'Котел', 'Kotel'),
    (21, 'Смолян', 'Smolyan'),
    (21, 'Девин', 'Devin'),
    (21, 'Чепеларе', 'Chepelare'),
    (21, 'Мадан', 'Madan'),
    (21, 'Златоград', 'Zlatograd'),
    (21, 'Доспат', 'Dospat'),
    (22, 'София', 'Stolichna'),
    (23, 'Елин Пелин', 'Elin Pelin'),
    (23, 'Ботевград', 'Botevgrad'),
    (23, 'Ихтиман', 'Ihtiman'),
    (23, 'Костинброд', 'Kostinbrod'),
    (23, 'Своге', 'Svoge'),
    (23, 'Етрополе', 'Etropole'),
    (23, 'Златица', 'Zlatitsa'),
    (23, 'Пирдоп', 'Pirdop'),
    (23, 'Правец', 'Pravets'),
    (23, 'Долна баня', 'Dolna Banya'),
    (24, 'Стара Загора', 'Stara Zagora'),
    (24, 'Казанлък', 'Kazanlak'),
    (24, 'Чирпан', 'Chirpan'),
    (24, 'Раднево', 'Radnevo'),
    (24, 'Гълъбово', 'Galabovo'),
    (24, 'Мъглиж', 'Maglizh'),
    (24, 'Николаево', 'Nikolaevo'),
    (24, 'Павел баня', 'Pavel Banya'),
    (25, 'Търговище', 'Targovishte'),
    (25, 'Попово', 'Popovo'),
    (25, 'Омуртаг', 'Omurtag'),
    (25, 'Опака', 'Opaka'),
    (26, 'Хасково', 'Haskovo'),
    (26, 'Димитровград', 'Dimitrovgrad'),
    (26, 'Харманли', 'Harmanli'),
    (26, 'Свиленград', 'Svilengrad'),
    (26, 'Ивайловград', 'Ivaylovgrad'),
    (26, 'Любимец', 'Lyubimets'),
    (26, 'Маджарово', 'Madzharovo'),
    (26, 'Тополовград', 'Topolovgrad'),
    (27, 'Шумен', 'Shumen'),
    (27, 'Велики Преслав', 'Veliki Preslav'),
    (27, 'Нови пазар', 'Novi Pazar'),
    (27, 'Каспичан', 'Kaspichan'),
    (27, 'Смядово', 'Smyadovo'),
    (28, 'Ямбол', 'Yambol'),
    (28, 'Елхово', 'Elhovo'),
    (28, 'Стралджа', 'Straldzha'),
    (28, 'Болярово', 'Bolyarovo');

INSERT INTO
    neighborhoods (
        city_id,
        neighborhood_name_bg,
        neighborhood_name_en
    )
VALUES
    -- 1. Blagoevgrad
    (1, 'Център', 'Center'),
    (1, 'Вароша', 'Varosha'),
    (1, 'Еленово', 'Elenovo'),
    (1, 'Струмско', 'Strumsko'),
    (1, 'Грамада', 'Gramada'),
    (1, 'Ален мак', 'Alen Mak'),
    (1, 'Освобождение', 'Osvobozhdenie'),
    -- 2. Bansko
    (2, 'Център', 'Center'),
    (2, 'Стария град', 'Old Town'),
    (2, 'Грамадето', 'Gramadeto'),
    (2, 'Свети Иван', 'St. Ivan'),
    -- 3. Sandanski
    (3, 'Център', 'Center'),
    (3, 'Спартак', 'Spartak'),
    (3, 'Изток', 'Iztok'),
    (3, 'Смилово', 'Smilovo'),
    -- 4. Razlog
    (4, 'Център', 'Center'),
    (4, 'Нов път', 'Nov Pat'),
    (4, 'Вароша', 'Varosha'),
    -- 5. Petrich
    (5, 'Център', 'Center'),
    (5, 'Дълбошница', 'Dalboshnitsa'),
    (5, 'Виздол', 'Vizdol'),
    (5, 'Шарон', 'Sharon'),
    -- 6. Gotse Delchev
    (6, 'Център', 'Center'),
    (6, 'Дунав', 'Dunav'),
    (6, 'Юг', 'Yug'),
    -- 7. Burgas
    (7, 'Център', 'Center'),
    (7, 'Възраждане', 'Vazrazhdane'),
    (7, 'Лазур', 'Lazur'),
    (7, 'Зорница', 'Zornitsa'),
    (7, 'Изгрев', 'Izgrev'),
    (7, 'Славейков', 'Slaveykov'),
    (7, 'Меден рудник', 'Meden Rudnik'),
    (7, 'Сарафово', 'Sarafovo'),
    -- 8. Nesebar
    (8, 'Стария град', 'Old Town'),
    (8, 'Новия град', 'New Town'),
    (8, 'Черно море', 'Black Sea'),
    -- 9. Pomorie
    (9, 'Стария град', 'Old Town'),
    (9, 'Свети Георги', 'St. George'),
    -- 10. Sozopol
    (10, 'Стария град', 'Old Town'),
    (10, 'Новия град', 'New Town'),
    (10, 'Буджака', 'Budzhaka'),
    (10, 'Харманите', 'Harmanite'),
    (11, 'Център', 'Center'),
    (11, 'Стария град', 'Old Town'),
    (11, 'Пясъка', 'Pyasaka'),
    -- 12. Tsarevo
    (12, 'Център', 'Center'),
    (12, 'Василико', 'Vasiliko'),
    (12, 'Белият град', 'The White Town'),
    -- 13. Aytos
    (13, 'Център', 'Center'),
    (13, 'Възраждане', 'Vazrazhdane'),
    (13, 'Изгрев', 'Izgrev'),
    -- 14. Karnobat
    (14, 'Център', 'Center'),
    (14, 'Възраждане', 'Vazrazhdane'),
    (14, 'Люлин', 'Lyulin'),
    -- 15. Varna
    (15, 'Център', 'Center'),
    (15, 'Гръцка махала', 'Greek Neighborhood'),
    (15, 'Чайка', 'Chayka'),
    (15, 'Младост', 'Mladost'),
    (15, 'Трошево', 'Troshevo'),
    (15, 'Възраждане', 'Vazrazhdane'),
    (
        15,
        'Владислав Варненчик',
        'Vladislav Varnenchik'
    ),
    (15, 'Аспарухово', 'Asparuhovo'),
    (15, 'Виница', 'Vinitsa'),
    (15, 'Бриз', 'Briz'),
    -- 16. Aksakovo
    (16, 'Център', 'Center'),
    (16, 'Надежда', 'Nadezhda'),
    -- 17. Byala (Varna Region)
    (17, 'Център', 'Center'),
    (17, 'Глико', 'Gliko'),
    -- 18. Devnya
    (18, 'Център', 'Center'),
    (18, 'Река Девня', 'Reka Devnya'),
    (18, 'Повеляново', 'Povelyanovo'),
    -- 19. Veliko Tarnovo
    (19, 'Център', 'Center'),
    (19, 'Вароша', 'Varosha'),
    (19, 'Картала', 'Kartala'),
    (19, 'Акация', 'Akatsia'),
    (19, 'Колю Фичето', 'Kolyu Ficheto'),
    (19, 'Бузлуджа', 'Buzludzha'),
    (19, 'Чолаковци', 'Cholakovtsi'),
    -- 20. Gorna Oryahovitsa
    (20, 'Център', 'Center'),
    (20, 'Пролет', 'Prolet'),
    (20, 'Гарата', 'The Station'),
    (20, 'Калтинец', 'Kaltinets'),
    (21, 'Център', 'Center'),
    (21, 'Червена звезда', 'Chervena Zvezda'),
    -- 22. Elena
    (22, 'Център', 'Center'),
    (22, 'Разпоповци', 'Razpopovtsi'),
    -- 23. Svishtov
    (23, 'Център', 'Center'),
    (23, 'Колю Фичето', 'Kolyu Ficheto'),
    (23, 'Сивилоза', 'Siviloza'),
    -- 24. Pavlikeni
    (24, 'Център', 'Center'),
    (24, 'Гарата', 'The Station'),
    -- 25. Polski Trambesh
    (25, 'Център', 'Center'),
    -- 26. Vidin
    (26, 'Център', 'Center'),
    (26, 'Калето', 'Kaleto'),
    (26, 'Бонония', 'Bononia'),
    (26, 'Химик', 'Himik'),
    (26, 'Панония', 'Panonia'),
    (26, 'Васил Левски', 'Vasil Levski'),
    -- 27. Belogradchik
    (27, 'Център', 'Center'),
    (27, 'Гъбите', 'Gabite'),
    -- 28. Kula
    (28, 'Център', 'Center'),
    -- 29. Bregovo
    (29, 'Център', 'Center'),
    -- 30. Vratsa
    (30, 'Център', 'Center'),
    (30, 'Възраждане', 'Vazrazhdane'),
    (30, 'Дъбника', 'Dabnika'),
    (30, 'Младост', 'Mladost'),
    (30, 'Металург', 'Metalurg'),
    (30, 'Медков', 'Medkov'),
    -- 31. Kozloduy
    (31, 'Център', 'Center'),
    (31, '1', 'District 1'),
    (31, '2', 'District 2'),
    (31, '3', 'District 3'),
    -- 32. Mezdra
    (32, 'Център', 'Center'),
    -- 33. Byala Slatina
    (33, 'Център', 'Center'),
    -- 34. Oryahovo
    (34, 'Център', 'Center'),
    -- 35. Krivodol
    (35, 'Център', 'Center'),
    -- 36. Roman
    (36, 'Център', 'Center'),
    -- 37. Miziya
    (37, 'Център', 'Center'),
    -- 38. Gabrovo
    (38, 'Център', 'Center'),
    (38, 'Младост', 'Mladost'),
    (38, 'Бистрица', 'Bistritsa'),
    (38, 'Етъра', 'Etara'),
    (38, 'Шести участък', 'Shesti Uchastak'),
    -- 39. Sevlievo
    (39, 'Център', 'Center'),
    -- 40. Tryavna
    (40, 'Център', 'Center'),
    (40, 'Светлозар Дичев', 'Svetlozar Dichev'),
    -- 41. Dryanovo
    (41, 'Център', 'Center'),
    -- 42. Dobrich
    (42, 'Център', 'Center'),
    (42, 'Балик', 'Balik'),
    (42, 'Дружба', 'Druzhba'),
    (42, 'Добротица', 'Dobrotitsa'),
    (42, 'Христо Ботев', 'Hristo Botev'),
    -- 43. Balchik
    (43, 'Център', 'Center'),
    (43, 'Васил Левски', 'Vasil Levski'),
    (43, 'Гео Милев', 'Geo Milev'),
    -- 44. Kavarna
    (44, 'Център', 'Center'),
    (44, 'Младост', 'Mladost'),
    (44, 'Хаджи Димитър', 'Hadzhi Dimitar'),
    -- 45. Shabla
    (45, 'Център', 'Center'),
    -- 46. General Toshevo
    (46, 'Център', 'Center'),
    (46, 'Пастир', 'Pastir'),
    -- 47. Tervel
    (47, 'Център', 'Center'),
    (47, 'Изгрев', 'Izgrev'),
    -- 48. Kardzhali
    (48, 'Център', 'Center'),
    (48, 'Възрожденци', 'Vazrozhdentsi'),
    (48, 'Веселчане', 'Veselchane'),
    (48, 'Байкал', 'Baykal'),
    (48, 'Студен кладенец', 'Studen Kladenets'),
    -- 49. Momchilgrad
    (49, 'Център', 'Center'),
    (49, 'Свобода', 'Svoboda'),
    -- 50. Dzhebel
    (50, 'Център', 'Center'),
    (50, 'Изгрев', 'Izgrev'),
    (50, 'Младост', 'Mladost'),
    -- 51. Krumovgrad
    (51, 'Център', 'Center'),
    (51, 'Запад', 'Zapad'),
    -- 52. Kardzhali (Duplicate ID in list, using 52)
    (52, 'Център', 'Center'),
    (52, 'Възрожденци', 'Vazrozhdentsi'),
    (52, 'Веселчане', 'Veselchane'),
    (52, 'Гледка', 'Gledka'),
    -- 53. Kyustendil
    (53, 'Център', 'Center'),
    (53, 'Колуш', 'Kolush'),
    (53, 'Герена', 'Gerena'),
    (53, 'Запад', 'Zapad'),
    -- 54. Dupnitsa
    (54, 'Център', 'Center'),
    (54, 'Бистрица', 'Bistritsa'),
    (54, 'Развесена върба', 'Razvesena Varba'),
    -- 55. Sapareva Banya
    (55, 'Център', 'Center'),
    (55, 'Гюргево', 'Gyurgevo'),
    -- 56. Bobov Dol
    (56, 'Център', 'Center'),
    (56, 'Миньор', 'Minyor'),
    -- 57. Boboshevo
    (57, 'Център', 'Center'),
    -- 58. Rila
    (58, 'Център', 'Center'),
    -- 59. Kocherinovo
    (59, 'Център', 'Center'),
    -- 60. Lovech
    (60, 'Център', 'Center'),
    (60, 'Вароша', 'Varosha'),
    (60, 'Младост', 'Mladost'),
    (60, 'Здравец', 'Zdravets'),
    -- 61. Troyan
    (61, 'Център', 'Center'),
    (61, 'Лъгът', 'Lagat'),
    (61, 'Велчевско', 'Velchevsko'),
    -- 62. Apriltsi
    (62, 'Център (Ново село)', 'Center (Novo Selo)'),
    (62, 'Острец', 'Ostretz'),
    (62, 'Видима', 'Vidima'),
    -- 63. Teteven
    (63, 'Център', 'Center'),
    (63, 'Пеновото', 'Penovoto'),
    (63, 'Полатен', 'Polaten'),
    -- 64. Lukovit
    (64, 'Център', 'Center'),
    -- 65. Yablanitsa
    (65, 'Център', 'Center'),
    -- 66. Letnitsa
    (66, 'Център', 'Center'),
    -- 67. Montana
    (67, 'Център', 'Center'),
    (67, 'Младост', 'Mladost'),
    (67, 'Плиска', 'Pliska'),
    (67, 'Мала Кутловица', 'Mala Kutlovitsa'),
    -- 68. Lom
    (68, 'Център', 'Center'),
    (68, 'Боруна', 'Boruna'),
    (68, 'Младост', 'Mladost'),
    -- 69. Berkovitsa
    (69, 'Център', 'Center'),
    (69, 'Заножене', 'Zanozhene'),
    -- 70. Varshets
    (70, 'Център', 'Center'),
    -- 71. Chiprovtsi
    (71, 'Център', 'Center'),
    -- 72. Boychinovtsi
    (72, 'Център', 'Center'),
    -- 73. Valchedram
    (73, 'Център', 'Center'),
    -- 74. Brusartsi
    (74, 'Център', 'Center'),
    -- 75. Pazardzhik
    (75, 'Център', 'Center'),
    (75, 'Вароша', 'Varosha Quarter'),
    (75, 'Младост', 'Mladost Quarter'),
    (75, 'Запад', 'Zapad Quarter'),
    (75, 'Устрем', 'Ustrem Quarter'),
    (75, 'Ставропол', 'Stavropol Quarter'),
    (75, 'Моста', 'Mosta Quarter'),
    (75, 'Острова', 'Ostrova Quarter'),
    -- 76. Panagyurishte
    (76, 'Център', 'Center'),
    -- 77. Peshtera
    (77, 'Център', 'Center'),
    -- 78. Septemvri
    (78, 'Център', 'Center'),
    -- 79. Batak
    (79, 'Център', 'Center'),
    -- 80. Strelcha
    (80, 'Център', 'Center'),
    -- 81. Pernik
    (81, 'Център', 'Center'),
    (81, 'Изток', 'Iztok Quarter'),
    (81, 'Мошино', 'Moshino Quarter'),
    (81, 'Тева', 'Teva Quarter'),
    (81, 'Твърди ливади', 'Tvardi Livadi Quarter'),
    (81, 'Иван Пашов', 'Ivan Pashov Quarter'),
    (81, 'Проучване', 'Prouchvane Quarter'),
    (81, 'Клепало', 'Klepalo Quarter'),
    (81, 'Калкас', 'Kalkas Quarter'),
    (81, 'Бела вода', 'Bela Voda Quarter'),
    (81, 'Църква', 'Tsarkva Quarter'),
    -- 82. Radomir
    (82, 'Център', 'Center'),
    (82, 'Гърляница', 'Garlyanitsa Quarter'),
    -- 83. Breznik
    (83, 'Център', 'Center'),
    -- 84. Pleven
    (84, 'Център', 'Center'),
    (84, 'Сторгозия', 'Storgozia Quarter'),
    (84, 'Дружба', 'Druzhba Quarter'),
    (84, 'Мара Денчева', 'Mara Dencheva Quarter'),
    (84, 'Кайлъка', 'Kaylaka Quarter'),
    (84, 'Девети квартал', 'Deveti Quarter'),
    (84, 'Индустриална зона', 'Industrial Zone'),
    -- 85. Belene
    (85, 'Център', 'Center'),
    -- 86. Levski
    (86, 'Център', 'Center'),
    -- 87. Nikopol
    (87, 'Център', 'Center'),
    -- 88. Knezha
    (88, 'Център', 'Center'),
    -- 89. Cherven Bryag
    (89, 'Център', 'Center'),
    (89, 'Пети квартал', 'Peti Quarter'),
    -- 90. Dolna Mitropoliya
    (90, 'Център', 'Center'),
    -- Gulyantsi (91)
    (91, 'Център', 'Center'),
    -- Pordim (92)
    (92, 'Център', 'Center'),
    -- Plovdiv (93)
    (93, 'Център', 'Center'),
    (93, 'Тракия', 'Trakia'),
    (93, 'Кючук Париж', 'Kyuchuk Parish'),
    (93, 'Кършияка', 'Karshiyaka'),
    (93, 'Христо Смирненски', 'Hristo Smirnenski'),
    (93, 'Стария град', 'Old Town'),
    -- Asenovgrad (94)
    (94, 'Център', 'Center'),
    (94, 'Бахча махала', 'Bahcha quarter'),
    (94, 'Метошка махала', 'Metoshki neighborhood'),
    (94, 'Амбелино', 'Ambelino'),
    (94, 'Свети Георги', 'Sveti Georgi'),
    -- Karlovo (95)
    (95, 'Център', 'Center'),
    (95, 'Васил Левски', 'Vasil Levski'),
    (95, 'Розова долина', 'Rozova dolina'),
    (95, 'Възрожденски', 'Vazrazhdenski'),
    (95, 'Полигона', 'Poligona'),
    -- Sopot (96)
    (96, 'Център', 'Center'),
    (96, 'Манастирска река', 'Manastirska reka'),
    (96, 'Бозово', 'Bozovo'),
    -- Rakovski (97)
    (97, 'Генерал Николаево', 'General Nikolaevo'),
    (97, 'Секирово', 'Sekirovo'),
    (97, 'Парчевич', 'Parchevich'),
    -- Stamboliyski (98)
    (98, 'Център', 'Center'),
    -- Hisarya (99)
    (99, 'Момина сълза', 'Momina salza'),
    (99, 'Веригово', 'Verigovo'),
    (99, 'Миромир', 'Miromir'),
    -- Saedinenie (100)
    (100, 'Център', 'Center'),
    -- Krichim (101)
    (101, 'Център', 'Center'),
    -- Razgrad (102)
    (102, 'Център', 'Center'),
    (102, 'Орел', 'Orel'),
    (102, 'Варош', 'Varosh'),
    (102, 'Абритус', 'Abritus'),
    -- Isperih (103)
    (103, 'Център', 'Center'),
    (103, 'Васил Левски', 'Vasil Levski'),
    -- Kubrat (104)
    (104, 'Център', 'Center'),
    (104, 'Дружба', 'Druzhba'),
    -- Tsar Kaloyan (105)
    (105, 'Център', 'Center'),
    -- Loznitsa (106)
    (106, 'Център', 'Center'),
    -- Zavet (107)
    (107, 'Център', 'Center'),
    -- Ruse (108)
    (108, 'Център', 'Center'),
    (108, 'Възраждане', 'Vazrazhdane'),
    (108, 'Здравец', 'Zdravets'),
    (108, 'Чародейка', 'Charodeyka'),
    (108, 'Дружба', 'Druzhba'),
    (108, 'Родина', 'Rodina'),
    -- Dve Mogili (109)
    (109, 'Център', 'Center'),
    -- Slivo Pole (110)
    (110, 'Център', 'Center'),
    -- Silistra (111)
    (111, 'Център', 'Center'),
    (111, 'Деленките', 'Delenkite'),
    -- Tutrakan (112)
    (112, 'Център', 'Center'),
    -- Dulovo (113)
    (113, 'Център', 'Center'),
    -- Alfatar (114)
    (114, 'Център', 'Center'),
    -- Glavinitsa (115)
    (115, 'Център', 'Center'),
    -- Sliven (116)
    (116, 'Център', 'Center'),
    (116, 'Сини камъни', 'Sini kamani'),
    (116, 'Дружба', 'Druzhba'),
    (116, 'Българка', 'Balgarka'),
    (116, 'Даме Груев', 'Dame Gruev'),
    (116, 'Младост', 'Mladost'),
    -- Nova Zagora (117)
    (117, 'Център', 'Center'),
    (117, 'Загоре', 'Zagore'),
    -- Kotel (118)
    (118, 'Център', 'Center'),
    (118, 'Галата', 'Galata'),
    -- Smolyan (119)
    (119, 'Смолян', 'Smolyan Center'),
    (119, 'Райково', 'Raykovo'),
    (119, 'Устово', 'Ustovo'),
    (119, 'Каптажа', 'Kaptazha'),
    -- Devin (120)
    (120, 'Център', 'Center'),
    -- Chepelare (121)
    (121, 'Център', 'Center'),
    -- Madan (122)
    (122, 'Център', 'Center'),
    -- Zlatograd (123)
    (123, 'Център', 'Center'),
    -- Dospat (124)
    (124, 'Център', 'Center'),
    -- Sofia (125)
    (125, 'Център', 'Center'),
    (125, 'Младост', 'Mladost'),
    (125, 'Люлин', 'Lyulin'),
    (125, 'Лозенец', 'Lozenets'),
    (125, 'Дружба', 'Druzhba'),
    (125, 'Надежда', 'Nadezhda'),
    (125, 'Витоша', 'Vitosha'),
    (125, 'Овча купел', 'Ovcha kupel'),
    (125, 'Студентски град', 'Studentski grad'),
    -- Elin Pelin (126)
    (126, 'Център', 'Center'),
    -- Botevgrad (127)
    (127, 'Център', 'Center'),
    (127, 'Саранск', 'Saransk'),
    -- Ihtiman (128)
    (128, 'Център', 'Center'),
    -- Kostinbrod (129)
    (129, 'Център', 'Center'),
    (129, 'Маслово', 'Maslovo'),
    (129, 'Шияковци', 'Shiyakovtsi'),
    -- Svoge (130)
    (130, 'Център', 'Center'),
    -- Etropole (131)
    (131, 'Център', 'Center'),
    -- Zlatitsa (132)
    (132, 'Център', 'Center'),
    -- Pirdop (133)
    (133, 'Център', 'Center'),
    -- Pravets (134)
    (134, 'Център', 'Center'),
    -- Dolna Banya (135)
    (135, 'Център', 'Center'),
    -- Stara Zagora (136)
    (136, 'Център', 'Center'),
    (136, 'Казански', 'Kazanski'),
    (136, 'Три чучура', 'Tri chuchura'),
    (136, 'Самара', 'Samara'),
    (136, 'Железник', 'Zheleznik'),
    (136, 'Кольо Ганчев', 'Kolyo Ganchev'),
    -- Kazanlak (137)
    (137, 'Център', 'Center'),
    (137, 'Васил Левски', 'Vasil Levski'),
    (137, 'Изток', 'Iztok'),
    (137, 'Кулата', 'Kulata'),
    -- Chirpan (138)
    (138, 'Център', 'Center'),
    -- Radnevo (139)
    (139, 'Център', 'Center'),
    -- Galabovo (140)
    (140, 'Център', 'Center'),
    -- Maglizh (141)
    (141, 'Център', 'Center'),
    -- Nikolaevo (142)
    (142, 'Център', 'Center'),
    -- Pavel Banya (143)
    (143, 'Център', 'Center'),
    -- Targovishte (144)
    (144, 'Център', 'Center'),
    (144, 'Варош', 'Varosh'),
    (144, 'Запад', 'Zapad'),
    (144, 'Боровец', 'Borovets'),
    -- Popovo (145)
    (145, 'Център', 'Center'),
    (145, 'Младост', 'Mladost'),
    -- Omurtag (146)
    (146, 'Център', 'Center'),
    -- Opaka (147)
    (147, 'Център', 'Center'),
    -- Haskovo (148)
    (148, 'Център', 'Center'),
    (148, 'Орфей', 'Orfey'),
    (148, 'Баден Баден', 'Baden Baden'),
    (148, 'Куба', 'Kuba'),
    (148, 'Любен Каравелов', 'Lyuben Karavelov'),
    -- Dimitrovgrad (149)
    (149, 'Център', 'Center'),
    (149, 'Славянски', 'Slavyanski'),
    (149, 'Раковски', 'Rakovski'),
    -- Harmanli (150)
    (150, 'Център', 'Center'),
    -- Svilengrad (151)
    (151, 'Център', 'Center'),
    (151, 'Гео Милев', 'Geo Milev'),
    (
        151,
        'Капитан Петко Войвода',
        'Kapitan Petko Voyvoda'
    ),
    -- Ivaylovgrad (152)
    (152, 'Център', 'Center'),
    -- Lyubimets (153)
    (153, 'Център', 'Center'),
    -- Madzharovo (154)
    (154, 'Център', 'Center'),
    -- Topolovgrad (155)
    (155, 'Център', 'Center'),
    -- Shumen (156)
    (156, 'Център', 'Center'),
    (156, 'Тракия', 'Trakia'),
    (156, 'Добруджа', 'Dobrudzha'),
    (156, 'Боян Българанов', 'Boyan Balgaranov'),
    (156, 'Еверест', 'Everest'),
    (156, 'Дивдядово', 'Divdyadovo'),
    -- Veliki Preslav (157)
    (157, 'Център', 'Center'),
    (157, 'Кирково', 'Kirkovo'),
    -- Novi Pazar (158)
    (158, 'Център', 'Center'),
    -- Kaspichan (159)
    (159, 'Център', 'Center'),
    (159, 'Калугерица', 'Kalugeritsa'),
    -- Smyadovo (160)
    (160, 'Център', 'Center'),
    -- Yambol (161)
    (161, 'Център', 'Center'),
    (161, 'Георги Бенковски', 'Georgi Benkovski'),
    (161, 'Диана', 'Diana'),
    (161, 'Златен рог', 'Zlaten rog'),
    (161, 'Граф Игнатиев', 'Graf Ignatiev'),
    (161, 'Хале', 'Hale'),
    -- Elhovo (162)
    (162, 'Център', 'Center'),
    -- Straldzha (163)
    (163, 'Център', 'Center'),
    -- Bolyarovo (164)
    (164, 'Център', 'Center');

/*Adding some users as dummy data*/
INSERT INTO
    users (username, email, password, user_type_id)
VALUES
    (
        'admin',
        'admin@a.a',
        '$2y$10$yyBWf3MoblV24c3tEtukl.QCp3zx28ocoj1MWIdK/kFdGRXEmfQXe' /*admin*/,
        1
    ),
    (
        'john_doe',
        'john.doe@example.com',
        '$2y$10$ubtVQEGV/Cd46lGe6Z0DlO6Sa3JTWGUuvxyGShGHpPfKSVHY4leJ2' /*john_doe*/,
        3
    ),
    (
        'someone',
        'some.one@some.one',
        '$2y$10$PKg/or4m9dVh9LzP3Z67KukIlDn0nPNvhzASOHgJleTNH94mCAo3a' /*someone*/,
        2
    ),
    (
        'Georgi',
        'gecata@g.g',
        '$2y$10$ClNEp4qyehEXml50nzBqB.QJHr6dk7/N1PrMbyZf4ceUzZjB7uRW.' /*gecata*/,
        3
    ),
    (
        'BurgasBroker',
        'burgas.broker@b.b',
        '$2y$10$V/h/hPMK1UuinSIQBpRg6OizFrFa0LJ2u3VR9SnsK1GmIf1si76jG' /*burgas*/,
        2
    );

INSERT INTO
    estates (
        city_id,
        neighborhood_id,
        estate_address,
        estate_type_id,
        rooms,
        area,
        floor,
        exposure_type,
        description,
        listing_type_id,
        price,
        owner_id,
        creation_date,
        expiration_date,
        status_id
    )
VALUES
    (
        15,
        55,
        'ул. Шипка 15',
        2,
        2,
        60.0,
        2,
        'Юг',
        'Апартамент в центъра на Варна',
        1,
        120000.00,
        3,
        SUBDATE(NOW(), INTERVAL 10 DAY),
        DATE_ADD(NOW(), INTERVAL 20 DAY),
        1
    ),
    (
        15,
        64,
        'ул. Свети Никола 12',
        3,
        3,
        85.0,
        5,
        'Север',
        'Апартамент в Бриз',
        2,
        250000.00,
        2,
        NOW(),
        DATE_ADD(NOW(), INTERVAL 30 DAY),
        1
    ),
    (
        15,
        64,
        'ул. Максим Жеков 4',
        3,
        3,
        120.0,
        8,
        'Северо-Изток',
        'Апартамент в Бриз',
        2,
        350000.00,
        2,
        SUBDATE(NOW(), INTERVAL 3 DAY),
        DATE_ADD(NOW(), INTERVAL 27 DAY),
        1
    ),
    (
        15,
        55,
        'ул. Воден 7',
        5,
        5,
        200.0,
        1,
        'Север',
        'Апартамент в центъра на Варна',
        1,
        700000.00,
        3,
        SUBDATE(NOW(), INTERVAL 6 DAY),
        DATE_ADD(NOW(), INTERVAL 24 DAY),
        1
    ),
    (
        15,
        57,
        'бл. 54, вх. Б',
        1,
        1,
        45.0,
        6,
        'Запад',
        'Апартамент в Чайка',
        1,
        150000.00,
        3,
        SUBDATE(NOW(), INTERVAL 15 DAY),
        DATE_ADD(NOW(), INTERVAL 15 DAY),
        1
    ),
    (
        15,
        59,
        'ул. Тихомир 22',
        7,
        1,
        30.0,
        1,
        'Юго-Изток',
        'Апартамент в Трошево',
        1,
        80000.00,
        3,
        NOW(),
        DATE_ADD(NOW(), INTERVAL 30 DAY),
        1
    ),
    (
        15,
        63,
        'ул. Цар Борис III 58',
        8,
        6,
        180.0,
        3,
        'Изток',
        'Къща в Виница',
        1,
        850000.00,
        3,
        SUBDATE(NOW(), INTERVAL 2 DAY),
        DATE_ADD(NOW(), INTERVAL 28 DAY),
        1
    ),
    (
        15,
        63,
        'ул. Морска Звезда 11',
        3,
        3,
        110.0,
        3,
        'Север',
        'Апартамент в Виница',
        1,
        250000.00,
        3,
        SUBDATE(NOW(), INTERVAL 8 DAY),
        DATE_ADD(NOW(), INTERVAL 22 DAY),
        1
    ),
    (
        15,
        56,
        'ул. Граф Игнатиев 24',
        4,
        4,
        120.0,
        2,
        'Юго-Запад',
        'Апартамент в Гръцка махала',
        1,
        350000.00,
        3,
        NOW(),
        DATE_ADD(NOW(), INTERVAL 30 DAY),
        1
    ),
    (
        15,
        58,
        'бл. 124, вх. В',
        2,
        2,
        80.0,
        1,
        'Изток',
        'Апартамент в Младост',
        1,
        270000.00,
        3,
        NOW(),
        DATE_ADD(NOW(), INTERVAL 30 DAY),
        1
    ),
    (
        7,
        26,
        'Васил Левски 18',
        3,
        3,
        80.0,
        4,
        'Изток',
        'Апартамент в центъра на Бургас',
        1,
        200000.00,
        4,
        NOW(),
        DATE_ADD(NOW(), INTERVAL 30 DAY),
        1
    ),
    (
        7,
        26,
        'Адам Мицкевич 5',
        2,
        2,
        65.0,
        2,
        'Запад',
        'Апартамент в центъра на Бургас',
        1,
        180000.00,
        4,
        SUBDATE(NOW(), INTERVAL 1 DAY),
        DATE_ADD(NOW(), INTERVAL 29 DAY),
        1
    ),
    (
        7,
        26,
        'Фотинов 22',
        4,
        4,
        130.0,
        5,
        'Изток',
        'Апартамент в центъра на Бургас',
        2,
        330000.00,
        5,
        SUBDATE(NOW(), INTERVAL 29 DAY),
        DATE_ADD(NOW(), INTERVAL 1 DAY),
        1
    ),
    (
        7,
        28,
        'Копривщица 14',
        7,
        1,
        25.0,
        3,
        'Север',
        'Апартамент в Лазур',
        1,
        42000.00,
        5,
        NOW(),
        DATE_ADD(NOW(), INTERVAL 30 DAY),
        1
    ),
    (
        7,
        30,
        'бл 15',
        2,
        2,
        45.0,
        1,
        'Юго-Запад',
        'Апартамент в Изгрев',
        1,
        62000.00,
        3,
        SUBDATE(NOW(), INTERVAL 18 DAY),
        DATE_ADD(NOW(), INTERVAL 12 DAY),
        1
    ),
    (
        7,
        30,
        'бл 122',
        3,
        3,
        90.0,
        8,
        'Север',
        'Апартамент в Изгрев',
        1,
        140000.00,
        3,
        SUBDATE(NOW(), INTERVAL 8 DAY),
        DATE_ADD(NOW(), INTERVAL 22 DAY),
        1
    ),
    (
        7,
        33,
        'Ангел Димитров 32',
        5,
        5,
        190.0,
        10,
        'Северо-Изток',
        'Апартамент в Сарафово',
        2,
        600000.00,
        5,
        NOW(),
        DATE_ADD(NOW(), INTERVAL 30 DAY),
        1
    ),
    (
        7,
        31,
        'бл. 70',
        2,
        2,
        80.0,
        4,
        'Юг',
        'Апартамент в Славейков',
        1,
        110000.00,
        3,
        SUBDATE(NOW(), INTERVAL 28 DAY),
        DATE_ADD(NOW(), INTERVAL 2 DAY),
        1
    ),
    (
        7,
        29,
        'бл. 47',
        2,
        2,
        70.0,
        2,
        'Запад',
        'Апартамент в Зорница',
        1,
        100000.00,
        5,
        SUBDATE(NOW(), INTERVAL 3 DAY),
        DATE_ADD(NOW(), INTERVAL 27 DAY),
        1
    ),
    (
        7,
        27,
        'Княз Борис I 62',
        1,
        1,
        15.0,
        2,
        'Север',
        'Апартамент в Възраждане',
        1,
        34000.00,
        4,
        NOW(),
        DATE_ADD(NOW(), INTERVAL 30 DAY),
        1
    );