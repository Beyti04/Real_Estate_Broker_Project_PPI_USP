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
        exposure_type VARCHAR(255) NOT NULL,
        rooms INT NOT NULL,
        description TEXT,
        listing_type_id INT NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        owner_id INT NOT NULL,
        FOREIGN KEY (estate_type_id) REFERENCES estate_types (id),
        FOREIGN KEY (city_id) REFERENCES cities (id),
        FOREIGN KEY (neighborhood_id) REFERENCES neighborhoods (id),
        FOREIGN KEY (owner_id) REFERENCES users (id),
        FOREIGN KEY (listing_type_id) REFERENCES listing_types (id)
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
    (1, 'гр. Благоевград', 'Blagoevgrad'),
    (1, 'гр. Банско', 'Bansko'),
    (1, 'гр. Сандански', 'Sandanski'),
    (1, 'гр. Разлог', 'Razlog'),
    (1, 'гр. Петрич', 'Petrich'),
    (1, 'гр. Гоце Делчев', 'Gotse Delchev'),
    (2, 'гр. Бургас', 'Burgas'),
    (2, 'гр. Несебър', 'Nesebar'),
    (2, 'гр. Поморие', 'Pomorie'),
    (2, 'гр. Созопол', 'Sozopol'),
    (2, 'гр. Приморско', 'Primorsko'),
    (2, 'гр. Царево', 'Tsarevo'),
    (2, 'гр. Айтос', 'Aytos'),
    (2, 'гр. Карнобат', 'Karnobat'),
    (3, 'гр. Варна', 'Varna'),
    (3, 'гр. Аксаково', 'Aksakovo'),
    (3, 'гр. Бяла', 'Byala'),
    (3, 'гр. Девня', 'Devnya'),
    (4, 'гр. Велико Търново', 'Veliko Tarnovo'),
    (4, 'гр. Горна Оряховица', 'Gorna Oryahovitsa'),
    (4, 'гр. Лясковец', 'Lyaskovets'),
    (4, 'гр. Елена', 'Elena'),
    (4, 'гр. Свищов', 'Svishtov'),
    (4, 'гр. Павликени', 'Pavlikeni'),
    (4, 'гр. Полски Тръмбеш', 'Polski Trambesh'),
    (5, 'гр. Видин', 'Vidin'),
    (5, 'гр. Белоградчик', 'Belogradchik'),
    (5, 'гр. Кула', 'Kula'),
    (5, 'гр. Брегово', 'Bregovo'),
    (6, 'гр. Враца', 'Vratsa'),
    (6, 'гр. Козлодуй', 'Kozloduy'),
    (6, 'гр. Мездра', 'Mezdra'),
    (6, 'гр. Бяла Слатина', 'Byala Slatina'),
    (6, 'гр. Оряхово', 'Oryahovo'),
    (6, 'гр. Криводол', 'Krivodol'),
    (6, 'гр. Роман', 'Roman'),
    (6, 'гр. Мизия', 'Miziya'),
    (7, 'гр. Габрово', 'Gabrovo'),
    (7, 'гр. Севлиево', 'Sevlievo'),
    (7, 'гр. Трявна', 'Tryavna'),
    (7, 'гр. Дряново', 'Dryanovo'),
    (8, 'гр. Добрич', 'Dobrich'),
    (8, 'гр. Балчик', 'Balchik'),
    (8, 'гр. Каварна', 'Kavarna'),
    (8, 'гр. Шабла', 'Shabla'),
    (8, 'гр. Генерал Тошево', 'General Toshevo'),
    (8, 'гр. Тервел', 'Tervel'),
    (9, 'гр. Кърджали', 'Kardzhali'),
    (9, 'гр. Момчилград', 'Momchilgrad'),
    (9, 'гр. Джебел', 'Dzhebel'),
    (9, 'гр. Крумовград', 'Krumovgrad'),
    (9, 'гр. Кирково', 'Kardzhali'),
    (10, 'гр. Кюстендил', 'Kyustendil'),
    (10, 'гр. Дупница', 'Dupnitsa'),
    (10, 'гр. Сапарева баня', 'Sapareva Banya'),
    (10, 'гр. Бобов дол', 'Bobov Dol'),
    (10, 'гр. Бобошево', 'Boboshevo'),
    (10, 'гр. Рила', 'Rila'),
    (10, 'гр. Кочериново', 'Kocherinovo'),
    (11, 'гр. Ловеч', 'Lovech'),
    (11, 'гр. Троян', 'Troyan'),
    (11, 'гр. Априлци', 'Apriltsi'),
    (11, 'гр. Тетевен', 'Teteven'),
    (11, 'гр. Луковит', 'Lukovit'),
    (11, 'гр. Ябланица', 'Yablanitsa'),
    (11, 'гр. Летница', 'Letnitsa'),
    (12, 'гр. Монтана', 'Montana'),
    (12, 'гр. Лом', 'Lom'),
    (12, 'гр. Берковица', 'Berkovitsa'),
    (12, 'гр. Вършец', 'Varshets'),
    (12, 'гр. Чипровци', 'Chiprovtsi'),
    (12, 'гр. Бойчиновци', 'Boychinovtsi'),
    (12, 'гр. Вълчедръм', 'Valchedram'),
    (12, 'гр. Брусарци', 'Brusartsi'),
    (13, 'гр. Пазарджик', 'Pazardzhik'),
    (13, 'гр. Панагюрище', 'Panagyurishte'),
    (13, 'гр. Пещера', 'Peshtera'),
    (13, 'гр. Септември', 'Septemvri'),
    (13, 'гр. Батак', 'Batak'),
    (13, 'гр. Стрелча', 'Strelcha'),
    (14, 'гр. Перник', 'Pernik'),
    (14, 'гр. Радомир', 'Radomir'),
    (14, 'гр. Брезник', 'Breznik'),
    (15, 'гр. Плевен', 'Pleven'),
    (15, 'гр. Белене', 'Belene'),
    (15, 'гр. Левски', 'Levski'),
    (15, 'гр. Никопол', 'Nikopol'),
    (15, 'гр. Кнежа', 'Knezha'),
    (15, 'гр. Червен бряг', 'Cherven Bryag'),
    (15, 'гр. Долна Митрополия', 'Dolna Mitropoliya'),
    (15, 'гр. Гулянци', 'Gulyantsi'),
    (15, 'гр. Пордим', 'Pordim'),
    (16, 'гр. Пловдив', 'Plovdiv'),
    (16, 'гр. Асеновград', 'Asenovgrad'),
    (16, 'гр. Карлово', 'Karlovo'),
    (16, 'гр. Сопот', 'Sopot'),
    (16, 'гр. Раковски', 'Rakovski'),
    (16, 'гр. Стамболийски', 'Stamboliyski'),
    (16, 'гр. Хисаря', 'Hisarya'),
    (16, 'гр. Съединение', 'Saedinenie'),
    (16, 'гр. Кричим', 'Krichim'),
    (17, 'гр. Разград', 'Razgrad'),
    (17, 'гр. Исперих', 'Isperih'),
    (17, 'гр. Кубрат', 'Kubrat'),
    (17, 'гр. Цар Калоян', 'Tsar Kaloyan'),
    (17, 'гр. Лозница', 'Loznitsa'),
    (17, 'гр. Завет', 'Zavet'),
    (18, 'гр. Русе', 'Ruse'),
    (18, 'гр. Две могили', 'Dve Mogili'),
    (18, 'гр. Сливо поле', 'Slivo Pole'),
    (19, 'гр. Силистра', 'Silistra'),
    (19, 'гр. Тутракан', 'Tutrakan'),
    (19, 'гр. Дулово', 'Dulovo'),
    (19, 'гр. Алфатар', 'Alfatar'),
    (19, 'гр. Главиница', 'Glavinitsa'),
    (20, 'гр. Сливен', 'Sliven'),
    (20, 'гр. Нова Загора', 'Nova Zagora'),
    (20, 'гр. Котел', 'Kotel'),
    (21, 'гр. Смолян', 'Smolyan'),
    (21, 'гр. Девин', 'Devin'),
    (21, 'гр. Чепеларе', 'Chepelare'),
    (21, 'гр. Мадан', 'Madan'),
    (21, 'гр. Златоград', 'Zlatograd'),
    (21, 'гр. Доспат', 'Dospat'),
    (22, 'гр. София', 'Stolichna'),
    (23, 'гр. Елин Пелин', 'Elin Pelin'),
    (23, 'гр. Ботевград', 'Botevgrad'),
    (23, 'гр. Ихтиман', 'Ihtiman'),
    (23, 'гр. Костинброд', 'Kostinbrod'),
    (23, 'гр. Своге', 'Svoge'),
    (23, 'гр. Етрополе', 'Etropole'),
    (23, 'гр. Златица', 'Zlatitsa'),
    (23, 'гр. Пирдоп', 'Pirdop'),
    (23, 'гр. Правец', 'Pravets'),
    (23, 'гр. Долна баня', 'Dolna Banya'),
    (24, 'гр. Стара Загора', 'Stara Zagora'),
    (24, 'гр. Казанлък', 'Kazanlak'),
    (24, 'гр. Чирпан', 'Chirpan'),
    (24, 'гр. Раднево', 'Radnevo'),
    (24, 'гр. Гълъбово', 'Galabovo'),
    (24, 'гр. Мъглиж', 'Maglizh'),
    (24, 'гр. Николаево', 'Nikolaevo'),
    (24, 'гр. Павел баня', 'Pavel Banya'),
    (25, 'гр. Търговище', 'Targovishte'),
    (25, 'гр. Попово', 'Popovo'),
    (25, 'гр. Омуртаг', 'Omurtag'),
    (25, 'гр. Опака', 'Opaka'),
    (26, 'гр. Хасково', 'Haskovo'),
    (26, 'гр. Димитровград', 'Dimitrovgrad'),
    (26, 'гр. Харманли', 'Harmanli'),
    (26, 'гр. Свиленград', 'Svilengrad'),
    (26, 'гр. Ивайловград', 'Ivaylovgrad'),
    (26, 'гр. Любимец', 'Lyubimets'),
    (26, 'гр. Маджарово', 'Madzharovo'),
    (26, 'гр. Тополовград', 'Topolovgrad'),
    (27, 'гр. Шумен', 'Shumen'),
    (27, 'гр. Велики Преслав', 'Veliki Preslav'),
    (27, 'гр. Нови пазар', 'Novi Pazar'),
    (27, 'гр. Каспичан', 'Kaspichan'),
    (27, 'гр. Смядово', 'Smyadovo'),
    (28, 'гр. Ямбол', 'Yambol'),
    (28, 'гр. Елхово', 'Elhovo'),
    (28, 'гр. Стралджа', 'Straldzha'),
    (28, 'гр. Болярово', 'Bolyarovo');

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
    (11, 'кв. Пясъка', 'Pyasaka'),
    -- 12. Tsarevo
    (12, 'Център', 'Center'),
    (12, 'кв. Василико', 'Vasiliko'),
    (12, 'кв. Белият град', 'The White Town'),
    -- 13. Aytos
    (13, 'Център', 'Center'),
    (13, 'кв. Възраждане', 'Vazrazhdane'),
    (13, 'кв. Изгрев', 'Izgrev'),
    -- 14. Karnobat
    (14, 'Център', 'Center'),
    (14, 'кв. Възраждане', 'Vazrazhdane'),
    (14, 'кв. Люлин', 'Lyulin'),
    -- 15. Varna
    (15, 'Център', 'Center'),
    (15, 'Гръцка махала', 'Greek Neighborhood'),
    (15, 'ж.к. Чайка', 'Chayka'),
    (15, 'ж.к. Младост', 'Mladost'),
    (15, 'ж.к. Трошево', 'Troshevo'),
    (15, 'ж.к. Възраждане', 'Vazrazhdane'),
    (
        15,
        'ж.к. Владислав Варненчик',
        'Vladislav Varnenchik'
    ),
    (15, 'кв. Аспарухово', 'Asparuhovo'),
    (15, 'кв. Виница', 'Vinitsa'),
    (15, 'кв. Бриз', 'Briz'),
    -- 16. Aksakovo
    (16, 'Център', 'Center'),
    (16, 'кв. Надежда', 'Nadezhda'),
    -- 17. Byala (Varna Region)
    (17, 'Център', 'Center'),
    (17, 'Глико', 'Gliko'),
    -- 18. Devnya
    (18, 'Център', 'Center'),
    (18, 'кв. Река Девня', 'Reka Devnya'),
    (18, 'кв. Повеляново', 'Povelyanovo'),
    -- 19. Veliko Tarnovo
    (19, 'Център', 'Center'),
    (19, 'кв. Вароша', 'Varosha'),
    (19, 'кв. Картала', 'Kartala'),
    (19, 'кв. Акация', 'Akatsia'),
    (19, 'кв. Колю Фичето', 'Kolyu Ficheto'),
    (19, 'кв. Бузлуджа', 'Buzludzha'),
    (19, 'кв. Чолаковци', 'Cholakovtsi'),
    -- 20. Gorna Oryahovitsa
    (20, 'Център', 'Center'),
    (20, 'кв. Пролет', 'Prolet'),
    (20, 'кв. Гарата', 'The Station'),
    (20, 'кв. Калтинец', 'Kaltinets'),
    (21, 'Център', 'Center'),
    (21, 'кв. Червена звезда', 'Chervena Zvezda'),
    -- 22. Elena
    (22, 'Център', 'Center'),
    (22, 'кв. Разпоповци', 'Razpopovtsi'),
    -- 23. Svishtov
    (23, 'Център', 'Center'),
    (23, 'кв. Колю Фичето', 'Kolyu Ficheto'),
    (23, 'кв. Сивилоза', 'Siviloza'),
    -- 24. Pavlikeni
    (24, 'Център', 'Center'),
    (24, 'кв. Гарата', 'The Station'),
    -- 25. Polski Trambesh
    (25, 'Център', 'Center'),
    -- 26. Vidin
    (26, 'Център', 'Center'),
    (26, 'кв. Калето', 'Kaleto'),
    (26, 'кв. Бонония', 'Bononia'),
    (26, 'кв. Химик', 'Himik'),
    (26, 'кв. Панония', 'Panonia'),
    (26, 'кв. Васил Левски', 'Vasil Levski'),
    -- 27. Belogradchik
    (27, 'Център', 'Center'),
    (27, 'кв. Гъбите', 'Gabite'),
    -- 28. Kula
    (28, 'Център', 'Center'),
    -- 29. Bregovo
    (29, 'Център', 'Center'),
    -- 30. Vratsa
    (30, 'Център', 'Center'),
    (30, 'кв. Възраждане', 'Vazrazhdane'),
    (30, 'ж.к. Дъбника', 'Dabnika'),
    (30, 'ж.к. Младост', 'Mladost'),
    (30, 'ж.к. Металург', 'Metalurg'),
    (30, 'кв. Медков', 'Medkov'),
    -- 31. Kozloduy
    (31, 'Център', 'Center'),
    (31, 'кв. 1', 'District 1'),
    (31, 'кв. 2', 'District 2'),
    (31, 'кв. 3', 'District 3'),
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
    (38, 'кв. Младост', 'Mladost'),
    (38, 'кв. Бистрица', 'Bistritsa'),
    (38, 'кв. Етъра', 'Etara'),
    (38, 'кв. Шести участък', 'Shesti Uchastak'),
    -- 39. Sevlievo
    (39, 'Център', 'Center'),
    -- 40. Tryavna
    (40, 'Център', 'Center'),
    (40, 'кв. Светлозар Дичев', 'Svetlozar Dichev'),
    -- 41. Dryanovo
    (41, 'Център', 'Center'),
    -- 42. Dobrich
    (42, 'Център', 'Center'),
    (42, 'ж.к. Балик', 'Balik'),
    (42, 'ж.к. Дружба', 'Druzhba'),
    (42, 'ж.к. Добротица', 'Dobrotitsa'),
    (42, 'ж.к. Христо Ботев', 'Hristo Botev'),
    -- 43. Balchik
    (43, 'Център', 'Center'),
    (43, 'кв. Васил Левски', 'Vasil Levski'),
    (43, 'кв. Гео Милев', 'Geo Milev'),
    -- 44. Kavarna
    (44, 'Център', 'Center'),
    (44, 'кв. Младост', 'Mladost'),
    (44, 'кв. Хаджи Димитър', 'Hadzhi Dimitar'),
    -- 45. Shabla
    (45, 'Център', 'Center'),
    -- 46. General Toshevo
    (46, 'Център', 'Center'),
    (46, 'кв. Пастир', 'Pastir'),
    -- 47. Tervel
    (47, 'Център', 'Center'),
    (47, 'кв. Изгрев', 'Izgrev'),
    -- 48. Kardzhali
    (48, 'Център', 'Center'),
    (48, 'кв. Възрожденци', 'Vazrozhdentsi'),
    (48, 'кв. Веселчане', 'Veselchane'),
    (48, 'кв. Байкал', 'Baykal'),
    (48, 'кв. Студен кладенец', 'Studen Kladenets'),
    -- 49. Momchilgrad
    (49, 'Център', 'Center'),
    (49, 'кв. Свобода', 'Svoboda'),
    -- 50. Dzhebel
    (50, 'Център', 'Center'),
    (50, 'кв. Изгрев', 'Izgrev'),
    (50, 'кв. Младост', 'Mladost'),
    -- 51. Krumovgrad
    (51, 'Център', 'Center'),
    (51, 'кв. Запад', 'Zapad'),
    -- 52. Kardzhali (Duplicate ID in list, using 52)
    (52, 'Център', 'Center'),
    (52, 'кв. Възрожденци', 'Vazrozhdentsi'),
    (52, 'кв. Веселчане', 'Veselchane'),
    (52, 'кв. Гледка', 'Gledka'),
    -- 53. Kyustendil
    (53, 'Център', 'Center'),
    (53, 'кв. Колуш', 'Kolush'),
    (53, 'кв. Герена', 'Gerena'),
    (53, 'кв. Запад', 'Zapad'),
    -- 54. Dupnitsa
    (54, 'Център', 'Center'),
    (54, 'ж.к. Бистрица', 'Bistritsa'),
    (54, 'кв. Развесена върба', 'Razvesena Varba'),
    -- 55. Sapareva Banya
    (55, 'Център', 'Center'),
    (55, 'кв. Гюргево', 'Gyurgevo'),
    -- 56. Bobov Dol
    (56, 'Център', 'Center'),
    (56, 'кв. Миньор', 'Minyor'),
    -- 57. Boboshevo
    (57, 'Център', 'Center'),
    -- 58. Rila
    (58, 'Център', 'Center'),
    -- 59. Kocherinovo
    (59, 'Център', 'Center'),
    -- 60. Lovech
    (60, 'Център', 'Center'),
    (60, 'кв. Вароша', 'Varosha'),
    (60, 'кв. Младост', 'Mladost'),
    (60, 'кв. Здравец', 'Zdravets'),
    -- 61. Troyan
    (61, 'Център', 'Center'),
    (61, 'кв. Лъгът', 'Lagat'),
    (61, 'кв. Велчевско', 'Velchevsko'),
    -- 62. Apriltsi
    (62, 'Център (Ново село)', 'Center (Novo Selo)'),
    (62, 'кв. Острец', 'Ostretz'),
    (62, 'кв. Видима', 'Vidima'),
    -- 63. Teteven
    (63, 'Център', 'Center'),
    (63, 'кв. Пеновото', 'Penovoto'),
    (63, 'кв. Полатен', 'Polaten'),
    -- 64. Lukovit
    (64, 'Център', 'Center'),
    -- 65. Yablanitsa
    (65, 'Център', 'Center'),
    -- 66. Letnitsa
    (66, 'Център', 'Center'),
    -- 67. Montana
    (67, 'Център', 'Center'),
    (67, 'ж.к. Младост', 'Mladost'),
    (67, 'ж.к. Плиска', 'Pliska'),
    (67, 'кв. Мала Кутловица', 'Mala Kutlovitsa'),
    -- 68. Lom
    (68, 'Център', 'Center'),
    (68, 'кв. Боруна', 'Boruna'),
    (68, 'кв. Младост', 'Mladost'),
    -- 69. Berkovitsa
    (69, 'Център', 'Center'),
    (69, 'кв. Заножене', 'Zanozhene'),
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
    (75, 'кв. Вароша', 'Varosha Quarter'),
    (75, 'кв. Младост', 'Mladost Quarter'),
    (75, 'кв. Запад', 'Zapad Quarter'),
    (75, 'кв. Устрем', 'Ustrem Quarter'),
    (75, 'кв. Ставропол', 'Stavropol Quarter'),
    (75, 'кв. Моста', 'Mosta Quarter'),
    (75, 'кв. Острова', 'Ostrova Quarter'),
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
    (81, 'кв. Изток', 'Iztok Quarter'),
    (81, 'кв. Мошино', 'Moshino Quarter'),
    (81, 'кв. Тева', 'Teva Quarter'),
    (81, 'кв. Твърди ливади', 'Tvardi Livadi Quarter'),
    (81, 'кв. Иван Пашов', 'Ivan Pashov Quarter'),
    (81, 'кв. Проучване', 'Prouchvane Quarter'),
    (81, 'кв. Клепало', 'Klepalo Quarter'),
    (81, 'кв. Калкас', 'Kalkas Quarter'),
    (81, 'кв. Бела вода', 'Bela Voda Quarter'),
    (81, 'кв. Църква', 'Tsarkva Quarter'),
    -- 82. Radomir
    (82, 'Център', 'Center'),
    (82, 'кв. Гърляница', 'Garlyanitsa Quarter'),
    -- 83. Breznik
    (83, 'Център', 'Center'),
    -- 84. Pleven
    (84, 'Център', 'Center'),
    (84, 'кв. Сторгозия', 'Storgozia Quarter'),
    (84, 'кв. Дружба', 'Druzhba Quarter'),
    (84, 'кв. Мара Денчева', 'Mara Dencheva Quarter'),
    (84, 'кв. Кайлъка', 'Kaylaka Quarter'),
    (84, 'кв. Девети квартал', 'Deveti Quarter'),
    (84, 'кв. Индустриална зона', 'Industrial Zone'),
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
    (89, 'кв. Пети квартал', 'Peti Quarter'),
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