# User

| Table_name   | Data type | Field Length | Constraint                          | Description             |
| ------------ | --------- | ------------ | ----------------------------------- | ----------------------- |
| user_code    | int       | 10           | PRIMAREY KEY, AUTO_INCREMENT        | user ID                 |
| firstname    | varchar   | 50           | NOT NULL                            | user's firstname        |
| lastname     | varchar   | 50           | NOT NULL                            | user's lastname         |
| birthday     | date      |              | NOT NULL                            | user's birthday         |
| email        | text      | 255          | NOT NULL                            | user's email            |
| password     | datetime  |              | NOT NULL                            | user's account password |
| phone_number | datetime  |              | NULL                                | user's phone number     |
| picture      | varchar   | 255          | NULL                                | user's picture          |
| created_at   | timestamp |              | NOT NULL, DEFAULT CURRENT_TIMESTAMP | creation date           |
| updated_at   | timestamp |              | NULL, DEFAULT CURRENT_TIMESTAMP     | last update             |

# Organizer

| Table_name     | Data type | Field Length | Constraint                          | Description                                            |
| -------------- | --------- | ------------ | ----------------------------------- | ------------------------------------------------------ |
| organizer_code | int       | 10           | PRIMAREY KEY, AUTO_INCREMENT        | organizer ID                                           |
| organizer_name | varchar   | 50           | NOT NULL                            | organiser's name                                       |
| description    | text      |              | NOT NULL                            | whatever the organizer wants to write about themselves |
| adress         | varchar   | 50           | NOT NULL                            | artist adress so it can match with area of action      |
| zipcode        | int       | 10           | NOT NULL                            | artist zipcode so it can match with area of action     |
| city           | varchar   | 50           | NOT NULL                            | artist city so it can match with area of action        |
| website        | varchar   | 255          | NULL                                | organizer's website                                    |
| picture        | varchar   | 255          | NULL                                | organizer's picture                                    |
| created_at     | timestamp |              | NOT NULL, DEFAULT CURRENT_TIMESTAMP | creation date                                          |
| updated_at     | timestamp |              | NULL, DEFAULT CURRENT_TIMESTAMP     | last update                                            |

# Band

| Table_name  | Data type | Field Length | Constraint                          | Description                                                  |
| ----------- | --------- | ------------ | ----------------------------------- | ------------------------------------------------------------ |
| band_code   | int       | 10           | PRIMAREY KEY, AUTO_INCREMENT        | band ID                                                      |
| stage_name  | varchar   | 50           | NOT NULL                            | stage name or band name                                      |
| description | text      |              | NOT NULL                            | whatever the band or the band want to write about themselves |
| adress      | varchar   | 50           | NOT NULL                            | artist adress so it can match with area of action            |
| zipcode     | int       | 10           | NOT NULL                            | artist zipcode so it can match with area of action           |
| city        | varchar   | 50           | NOT NULL                            | artist city so it can match with area of action              |
| area        | int       | 10           | NOT NULL                            | area where the band can perform                              |
| sample      | varchar   | 255          | NULL                                | a sample from the band (youtube, spotify, soundcloud)        |
| picture     | varchar   | 255          | NULL                                | profile's picture                                            |
| created_at  | timestamp |              | NOT NULL, DEFAULT CURRENT_TIMESTAMP | creation date                                                |
| updated_at  | timestamp |              | NULL, DEFAULT CURRENT_TIMESTAMP     | last update                                                  |

# Event

| Table_name  | Data type | Field Length | Constraint                          | Description                                        |
| ----------- | --------- | ------------ | ----------------------------------- | -------------------------------------------------- |
| event_code  | int       | 10           | PRIMAREY KEY, AUTO_INCREMENT        | event ID                                           |
| title       | varchar   | 50           | NOT NULL                            | event's name                                       |
| description | text      | 255          | NOT NULL                            | event's description                                |
| adress      | varchar   | 50           | NOT NULL                            | artist adress so it can match with area of action  |
| zipcode     | int       | 10           | NOT NULL                            | artist zipcode so it can match with area of action |
| city        | varchar   | 50           | NOT NULL                            | artist city so it can match with area of action    |
| date_start  | date  |              | NOT NULL                            | event's starting date                              |
| date_end    | date  |              | NULL                                | event's ending date                                |
| hour_start  | int       | 10           | NOT NULL                            | event's time date start                            |
| hour_end    | int       | 10           | NULL                                | event's time date end                              |
| picture     | varchar   | 255          | NULL                                | event's picture                                    |
| created_at  | timestamp |              | NOT NULL, DEFAULT CURRENT_TIMESTAMP | creation date                                      |
| updated_at  | timestamp |              | NULL, DEFAULT CURRENT_TIMESTAMP     | last update                                        |

# County

| Table_name  | Data type | Field Length | Constraint                   | Description   |
| ----------- | --------- | ------------ | ---------------------------- | ------------- |
| county_code | int       | 10           | PRIMAREY KEY, AUTO_INCREMENT | event ID      |
| name        | varchar   | 50           | NOT NULL                     | county name   |
| number      | int       | 10           | NOT NULL                     | county number |

# Genre

| Table_name | Data type | Field Length | Constraint                   | Description |
| ---------- | --------- | ------------ | ---------------------------- | ----------- |
| genre_code | int       | 10           | PRIMAREY KEY, AUTO_INCREMENT | genre ID    |
| name       | varchar   | 50           | NOT NULL                     | genre name  |

# Tag

| Table_name | Data type | Field Length | Constraint                   | Description |
| ---------- | --------- | ------------ | ---------------------------- | ----------- |
| tag_code   | int       | 10           | PRIMAREY KEY, AUTO_INCREMENT | tag ID      |
| name       | varchar   | 50           | NOT NULL                     | tag name    |

