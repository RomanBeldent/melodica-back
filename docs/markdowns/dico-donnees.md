# User

| Table_name   | Data type           | Field Length | Constraint                          | Description             |
| ------------ | ------------------- | ------------ | ----------------------------------- | ----------------------- |
| user_code    | int                 | 10           | PRIMAREY KEY, AUTO_INCREMENT        | user ID                 |
| firstname    | varchar             | 50           | NOT NULL                            | user's firstname        |
| lastname     | varchar             | 50           | NOT NULL                            | user's lastname         |
| role         | varchar             | 50           | NOT NULL                            | user role (admin..)     |
| birthday     | date                |              | NOT NULL                            | user's birthday         |
| email        | string              | 100          | NOT NULL                            | user's email            |
| password     | string              | 50           | NOT NULL                            | user's account password |
| phone_number | int                 | 10           | NOT NULL                            | user's phone number     |
| picture      | varchar             | 255          | NULL                                | user's picture          |
| created_at   | timestamp_immutable |              | NOT NULL, DEFAULT CURRENT_TIMESTAMP | creation date           |
| updated_at   | timestamp_immutable |              | NULL, DEFAULT CURRENT_TIMESTAMP     | last update             |

# Organizer

| Table_name     | Data type | Field Length | Constraint                          | Description                                            |
| -------------- | --------- | ------------ | ----------------------------------- | ------------------------------------------------------ |
| organizer_code | int       | 10           | PRIMAREY KEY, AUTO_INCREMENT        | organizer ID                                           |
| name           | varchar   | 50           | NOT NULL                            | organiser's name                                       |
| description    | text      |              | NOT NULL                            | whatever the organizer wants to write about themselves |
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
| area        | int       | 10           | NOT NULL                            | area where the band can perform                              |
| sample      | varchar   | 255          | NULL                                | a sample from the band (youtube, spotify, soundcloud)        |
| picture     | varchar   | 255          | NULL                                | profile's picture                                            |
| created_at  | timestamp |              | NOT NULL, DEFAULT CURRENT_TIMESTAMP | creation date                                                |
| updated_at  | timestamp |              | NULL, DEFAULT CURRENT_TIMESTAMP     | last update                                                  |

# Event

| Table_name  | Data type | Field Length | Constraint                          | Description             |
| ----------- | --------- | ------------ | ----------------------------------- | ----------------------- |
| event_code  | int       | 10           | PRIMAREY KEY, AUTO_INCREMENT        | event ID                |
| title       | varchar   | 50           | NOT NULL                            | event's name            |
| description | text      | 255          | NULL                                | event's description     |
| date_start  | date      |              | NOT NULL                            | event's starting date   |
| date_end    | date      |              | NULL                                | event's ending date     |
| hour_start  | datetime  |              | NOT NULL                            | event's time date start |
| hour_end    | datetime  |              | NULL                                | event's time date end   |
| picture     | varchar   | 255          | NULL                                | event's picture         |
| created_at  | timestamp |              | NOT NULL, DEFAULT CURRENT_TIMESTAMP | creation date           |
| updated_at  | timestamp |              | NULL, DEFAULT CURRENT_TIMESTAMP     | last update             |

# Address

| Table_name | Data type | Field Length | Constraint | Description                                       |
| ---------- | --------- | ------------ | ---------- | ------------------------------------------------- |
| street     | varchar   | 50           | NOT NULL   | event street so it can match with area of action  |
| zipcode    | int       | 10           | NOT NULL   | event zipcode so it can match with area of action |
| city       | varchar   | 50           | NOT NULL   | event city so it can match with area of action    |
| department | int       | 10           | NOT NULL   | event department 2 (first numbers of zipcode)     |


# Genre

| Table_name | Data type | Field Length | Constraint                   | Description |
| ---------- | --------- | ------------ | ---------------------------- | ----------- |
| genre_code | int       | 10           | PRIMAREY KEY, AUTO_INCREMENT | genre ID    |
| name       | varchar   | 50           | NOT NULL                     | genre name  |

# Type

| Table_name | Data type | Field Length | Constraint                   | Description                              |
| ---------- | --------- | ------------ | ---------------------------- | ---------------------------------------- |
| genre_code | int       | 10           | PRIMAREY KEY, AUTO_INCREMENT | genre ID                                 |
| name       | varchar   | 50           | NOT NULL                     | type of the organizer (bar, festival...) |

# Tag



| Table_name | Data type | Field Length | Constraint                   | Description |
| ---------- | --------- | ------------ | ---------------------------- | ----------- |
| tag_code   | int       | 10           | PRIMAREY KEY, AUTO_INCREMENT | tag ID      |
| name       | varchar   | 50           | NOT NULL                     | tag name    |

