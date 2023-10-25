
# FRONT ROUTES

## FrontOffice

| url                          | Verb HTTP | Controller | Method | constraint | comment                             |
| ---------------------------- | --------- | ---------- | ------ | ---------- | ----------------------------------- |
| /                            | GET       |            |        |            | home page                           |
| /signup                      | GET       |            |        |            | signup page                         |
| /user/{id}                   | GET       |            |        |            | user page                           |
| /user/{id}/edit              | GET       |            |        |            | user edit page                      |
| /user/{id}/band/new          | GET       |            |        |            | band creation                       |
| /user/{id}/band/{id}/edit    | GET       |            |        |            | band profil edit                    |
| /user/{id}organizer/{id}/new | GET       |            |        |            | organizers creation                 |
| /user/{id}/organizer/edit    | GET       |            |        |            | organizers creation                 |
| /user/{id}/fav               | GET       |            |        |            | user fav page                       |
| /search                      | GET       |            |        |            | search page for band and organizers |
| /organizer/{id}              | GET       |            |        |            | organizer profil page               |
| /band/{id}                   | GET       |            |        |            | band profil page                    |
| /user/{id}/messages          | GET       |            |        |            | messages page                       |
| /user/{id}/message/{id}      | GET       |            |        |            | message with band/org page          |
| /legal-notice                | GET       |            |        |            | legal notice page                   |
| /contact                     | GET       |            |        |            | contact page                        |
| /about                       | GET       |            |        |            | about us page                       |

# BACK ROUTES

## API

### User

| url            | Verb HTTP | Controller | Method | constraint | comment            |
| -------------- | --------- | ---------- | ------ | ---------- | ------------------ |
| /api/user/     | GET       | Api\User   | list   |            | user list          |
| /api/user/{id} | GET       | Api\User   | show   | id = \d+   | show specific user |
| /api/user/     | POST      | Api\User   | create |            | create a new user  |
| /api/user/{id} | PUT       | Api\User   | edit   | id = \d+   | update a user      |
| /api/user/{id} | DELETE    | Api\User   | delete | id = \d+   | delete a user      |

### Band

| url              | Verb HTTP | Controller | Method | constraint | comment            |
| ---------------- | --------- | ---------- | ------ | ---------- | ------------------ |
| /api/band/       | GET       | Api\Band   | list   |            | band list          |
| /api/band/{id}   | GET       | Api\Band   | show   | id = \d+   | show specific band |
| /api/band/random | GET       | Api\Band   | random |            | get a random band  |
| /api/band/       | POST      | Api\Band   | create |            | create a new band  |
| /api/band/{id}   | PUT       | Api\Band   | edit   | id = \d+   | update a band      |
| /api/band/{id}   | DELETE    | Api\Band   | delete | id = \d+   | delete a band      |

### Organizer

| url                   | Verb HTTP | Controller    | Method | constraint | comment                 |
| --------------------- | --------- | ------------- | ------ | ---------- | ----------------------- |
| /api/organizer/       | GET       | Api\Organizer | list   |            | organizer list          |
| /api/organizer/{id}   | GET       | Api\Organizer | show   | id = \d+   | show specific organizer |
| /api/organizer/random | GET       | Api\Organizer | random |            | get a random organizer  |
| /api/organizer/       | POST      | Api\Organizer | create |            | create a new organizer  |
| /api/organizer/{id}   | PUT       | Api\Organizer | edit   | id = \d+   | update a organizer      |
| /api/organizer/{id}   | DELETE    | Api\Organizer | delete | id = \d+   | delete a organizer      |

### Event

| url               | Verb HTTP | Controller | Method | constraint | comment             |
| ----------------- | --------- | ---------- | ------ | ---------- | ------------------- |
| /api/event/       | GET       | Api\Event  | list   |            | event list          |
| /api/event/{id}   | GET       | Api\Event  | show   | id = \d+   | show specific event |
| /api/event/random | GET       | Api\Event  | random |            | get a random event  |
| /api/event/       | POST      | Api\Event  | create |            | create a new event  |
| /api/event/{id}   | PUT       | Api\Event  | edit   | id = \d+   | update a event      |
| /api/event/{id}   | DELETE    | Api\Event  | delete | id = \d+   | delete a event      |

### Genre

| url             | Verb HTTP | Controller | Method | constraint | comment             |
| --------------- | --------- | ---------- | ------ | ---------- | ------------------- |
| /api/genre/     | GET       | Api\Genre  | list   |            | genre list          |
| /api/genre/{id} | GET       | Api\Genre  | show   | id = \d+   | show specific genre |
| /api/genre/     | POST      | Api\Genre  | create |            | create a new genre  |
| /api/genre/{id} | PUT       | Api\Genre  | edit   | id = \d+   | update a genre      |
| /api/genre/{id} | DELETE    | Api\Genre  | delete | id = \d+   | delete a genre      |

### Role

| url            | Verb HTTP | Controller | Method | constraint | comment            |
| -------------- | --------- | ---------- | ------ | ---------- | ------------------ |
| /api/role/     | GET       | Api\Role   | list   |            | role list          |
| /api/role/{id} | GET       | Api\Role   | show   | id = \d+   | show specific role |
| /api/role/     | POST      | Api\Role   | create |            | create a new role  |
| /api/role/{id} | PUT       | Api\Role   | edit   | id = \d+   | update a role      |
| /api/role/{id} | DELETE    | Api\Role   | delete | id = \d+   | delete a role      |

### Tag

| url           | Verb HTTP | Controller | Method | constraint | comment           |
| ------------- | --------- | ---------- | ------ | ---------- | ----------------- |
| /api/tag/     | GET       | Api\Tag    | list   |            | tag list          |
| /api/tag/{id} | GET       | Api\Tag    | show   | id = \d+   | show specific tag |
| /api/tag/     | POST      | Api\Tag    | create |            | create a new tag  |
| /api/tag/{id} | PUT       | Api\Tag    | edit   | id = \d+   | update a tag      |
| /api/tag/{id} | DELETE    | Api\Tag    | delete | id = \d+   | delete a tag      |


## BackOffice

### User

| url                    | Verb HTTP | Controller | Method | constraint | comment                    |
| ---------------------- | --------- | ---------- | ------ | ---------- | -------------------------- |
| /back/user/            | GET       | Back\User  | list   |            | user list                  |
| /back/user/{id}        | GET       | Back\User  | read   | id = \d+   | user read                  |
| /back/user/{id}/edit   | GET       | Back\User  | edit   | id = \d+   | user edit : display form   |
| /back/user/{id}/edit   | PUT       | Back\User  | edit   | id = \d+   | user edit : manage form    |
| /back/user/create      | GET       | Back\User  | create |            | user create : display form |
| /back/user/create      | POST      | Back\User  | create |            | user create : manage form  |
| /back/user/{id}/delete | DELETE    | Back\User  | delete | id = \d+   | user delete                |

### Band

| url                    | Verb HTTP | Controller | Method | constraint | comment                                                |
| ---------------------- | --------- | ---------- | ------ | ---------- | ------------------------------------------------------ |
| /back/                 | GET       | Back\Main  | home   |            | home where you can choose between different categories |
| /back/band/            | GET       | Back\Band  | list   |            | band list                                              |
| /back/band/{id}        | GET       | Back\Band  | read   | id = \d+   | band read                                              |
| /back/band/{id}/edit   | GET       | Back\Band  | edit   | id = \d+   | band edit : display form                               |
| /back/band/{id}/edit   | PUT       | Back\Band  | edit   | id = \d+   | band edit : manage form                                |
| /back/band/create      | GET       | Back\Band  | create |            | band create : display form                             |
| /back/band/create      | POST      | Back\Band  | create |            | band create : manage form                              |
| /back/band/{id}/delete | DELETE    | Back\Band  | delete | id = \d+   | band delete                                            |

### Organizer

| url                         | Verb HTTP | Controller     | Method | constraint | comment                         |
| --------------------------- | --------- | -------------- | ------ | ---------- | ------------------------------- |
| /back/organizer/            | GET       | Back\Organizer | list   |            | organizer list                  |
| /back/organizer/{id}        | GET       | Back\Organizer | read   | id = \d+   | organizer read                  |
| /back/organizer/{id}/edit   | GET       | Back\Organizer | edit   | id = \d+   | organizer edit : display form   |
| /back/organizer/{id}/edit   | PUT       | Back\Organizer | edit   | id = \d+   | organizer edit : manage form    |
| /back/organizer/create      | GET       | Back\Organizer | create |            | organizer create : display form |
| /back/organizer/create      | POST      | Back\Organizer | create |            | organizer create : manage form  |
| /back/organizer/{id}/delete | DELETE    | Back\Organizer | delete | id = \d+   | organizer delete                |

### Event

| url                     | Verb HTTP | Controller | Method | constraint | comment                     |
| ----------------------- | --------- | ---------- | ------ | ---------- | --------------------------- |
| /back/event/            | GET       | Back\Event | list   |            | event list                  |
| /back/event/{id}        | GET       | Back\Event | read   | id = \d+   | event read                  |
| /back/event/{id}/edit   | GET       | Back\Event | edit   | id = \d+   | event edit : display form   |
| /back/event/{id}/edit   | PUT       | Back\Event | edit   | id = \d+   | event edit : manage form    |
| /back/event/create      | GET       | Back\Event | create |            | event create : display form |
| /back/event/create      | POST      | Back\Event | create |            | event create : manage form  |
| /back/event/{id}/delete | DELETE    | Back\Event | delete | id = \d+   | event delete                |

### Genre

| url                     | Verb HTTP | Controller | Method | constraint | comment                     |
| ----------------------- | --------- | ---------- | ------ | ---------- | --------------------------- |
| /back/genre/            | GET       | Back\Genre | list   |            | genre list                  |
| /back/genre/{id}        | GET       | Back\Genre | read   | id = \d+   | genre read                  |
| /back/genre/{id}/edit   | GET       | Back\Genre | edit   | id = \d+   | genre edit : display form   |
| /back/genre/{id}/edit   | PUT       | Back\Genre | edit   | id = \d+   | genre edit : manage form    |
| /back/genre/create      | GET       | Back\Genre | create |            | genre create : display form |
| /back/genre/create      | POST      | Back\Genre | create |            | genre create : manage form  |
| /back/genre/{id}/delete | DELETE    | Back\Genre | delete | id = \d+   | genre delete                |

### Tag

| url                   | Verb HTTP | Controller | Method | constraint | comment                   |
| --------------------- | --------- | ---------- | ------ | ---------- | ------------------------- |
| /back/tag/            | GET       | Back\Tag   | list   |            | tag list                  |
| /back/tag/{id}        | GET       | Back\Tag   | read   | id = \d+   | tag read                  |
| /back/tag/{id}/edit   | GET       | Back\Tag   | edit   | id = \d+   | tag edit : display form   |
| /back/tag/{id}/edit   | PUT       | Back\Tag   | edit   | id = \d+   | tag edit : manage form    |
| /back/tag/create      | GET       | Back\Tag   | create |            | tag create : display form |
| /back/tag/create      | POST      | Back\Tag   | create |            | tag create : manage form  |
| /back/tag/{id}/delete | DELETE    | Back\Tag   | delete | id = \d+   | tag delete                |