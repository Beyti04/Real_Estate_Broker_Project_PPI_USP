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
        estate_type_id INT,
        exposure_type VARCHAR(255) NOT NULL,
        rooms INT NOT NULL,
        description TEXT,
        listing_type_id INT NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        owner_id INT NOT NULL,
        FOREIGN KEY (estate_type_id) REFERENCES estate_types (id),
        FOREIGN KEY (city_id) REFERENCES cities (id),
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
    (22, 'гр. София', 'Sofia'),
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