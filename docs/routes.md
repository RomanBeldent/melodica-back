# Routes

## FrontOffice

| url             | Verb HTTP | Controller | Method | constraint | comment           |
| --------------- | --------- | ---------- | ------ | ---------- | ----------------- |
|                 | GET       |            |        |            | home page         |
| /signup         | GET       |            |        |            | signup page       |
| /login          | GET       |            |        |            |                   |
| /logout         | GET       |            |        |            |                   |
| /profil         | GET       |            |        |            | profil page       |
| /artist         | GET       |            |        |            | artists list      |
| /artist/{id}    | GET       |            |        |            | artist profil     |
| /organizer      | GET       |            |        |            | organizers list   |
| /organizer/{id} | GET       |            |        |            | organizer profil  |
| /contract       | GET       |            |        |            | contract page     |
| /legal-notice   | GET       |            |        |            | legal notice page |
| /contact        | GET       |            |        |            | contact page      |
| /about          | GET       |            |        |            | about us page     |


## BackOffice

| url                         | Verb HTTP | Controller     | Method | constraint | comment                                                |
| --------------------------- | --------- | -------------- | ------ | ---------- | ------------------------------------------------------ |
| /back/                      | GET       | Back\Main      | home   |            | home where you can choose between different categories |
| /back/artist/               | GET       | Back\Artist    | list   |            | artist list                                            |
| /back/artist/{id}           | GET       | Back\Artist    | read   | id = \d+   | artist read                                            |
| /back/artist/{id}/edit      | GET       | Back\Artist    | edit   | id = \d+   | artist edit : display form                             |
| /back/artist/{id}/edit      | PATCH     | Back\Artist    | edit   | id = \d+   | artist edit : manage form                              |
| /back/artist/create         | GET       | Back\Artist    | create |            | artist create : display form                           |
| /back/artist/create         | POST      | Back\Artist    | create |            | artist create : manage form                            |
| /back/artist/{id}/delete    | GET       | Back\Artist    | delete | id = \d+   | artist delete                                          |
| /back/organizer/            | GET       | Back\Organizer | list   |            | organizer list                                         |
| /back/organizer/{id}        | GET       | Back\Organizer | read   | id = \d+   | organizer read                                         |
| /back/organizer/{id}/edit   | GET       | Back\Organizer | edit   | id = \d+   | organizer edit : display form                          |
| /back/organizer/{id}/edit   | PATCH     | Back\Organizer | edit   | id = \d+   | organizer edit : manage form                           |
| /back/organizer/create      | GET       | Back\Organizer | create |            | organizer create : display form                        |
| /back/organizer/create      | POST      | Back\Organizer | create |            | organizer create : manage form                         |
| /back/organizer/{id}/delete | GET       | Back\Organizer | delete | id = \d+   | organizer delete                                       |
| /back/role/                 | GET       | Back\Role      | list   |            | role list                                              |
| /back/role/{id}             | GET       | Back\Role      | read   | id = \d+   | role read                                              |
| /back/role/{id}/edit        | GET       | Back\Role      | edit   | id = \d+   | role edit : display form                               |
| /back/role/{id}/edit        | PATCH     | Back\Role      | edit   | id = \d+   | role edit : manage form                                |
| /back/role/create           | GET       | Back\Role      | create |            | role create : display form                             |
| /back/role/create           | POST      | Back\Role      | create |            | role create : manage form                              |
| /back/role/{id}/delete      | GET       | Back\Role      | delete | id = \d+   | role delete                                            |
| /back/genre/                | GET       | Back\Genre     | list   |            | genre list                                             |
| /back/genre/{id}            | GET       | Back\Genre     | read   | id = \d+   | genre read                                             |
| /back/genre/{id}/edit       | GET       | Back\Genre     | edit   | id = \d+   | genre edit : display form                              |
| /back/genre/{id}/edit       | PATCH     | Back\Genre     | edit   | id = \d+   | genre edit : manage form                               |
| /back/genre/create          | GET       | Back\Genre     | create |            | genre create : display form                            |
| /back/genre/create          | POST      | Back\Genre     | create |            | genre create : manage form                             |
| /back/genre/{id}/delete     | GET       | Back\Genre     | delete | id = \d+   | genre delete                                           |
| /back/tag/                  | GET       | Back\Tag       | list   |            | tag list                                               |
| /back/tag/{id}              | GET       | Back\Tag       | read   | id = \d+   | tag read                                               |
| /back/tag/{id}/edit         | GET       | Back\Tag       | edit   | id = \d+   | tag edit : display form                                |
| /back/tag/{id}/edit         | PATCH     | Back\Tag       | edit   | id = \d+   | tag edit : manage form                                 |
| /back/tag/create            | GET       | Back\Tag       | create |            | tag create : display form                              |
| /back/tag/create            | POST      | Back\Tag       | create |            | tag create : manage form                               |
| /back/tag/{id}/delete       | GET       | Back\Tag       | delete | id = \d+   | tag delete                                             |
| /back/event/                | GET       | Back\Event     | list   |            | event list                                             |
| /back/event/{id}            | GET       | Back\Event     | read   | id = \d+   | event read                                             |
| /back/event/{id}/edit       | GET       | Back\Event     | edit   | id = \d+   | event edit : display form                              |
| /back/event/{id}/edit       | PATCH     | Back\Event     | edit   | id = \d+   | event edit : manage form                               |
| /back/event/create          | GET       | Back\Event     | create |            | event create : display form                            |
| /back/event/create          | POST      | Back\Event     | create |            | event create : manage form                             |
| /back/event/{id}/delete     | GET       | Back\Event     | delete | id = \d+   | event delete                                           |
| /back/user/                 | GET       | Back\User      | list   |            | user list                                              |
| /back/user/{id}             | GET       | Back\User      | read   | id = \d+   | user read                                              |
| /back/user/{id}/edit        | GET       | Back\User      | edit   | id = \d+   | user edit : display form                               |
| /back/user/{id}/edit        | PATCH     | Back\User      | edit   | id = \d+   | user edit : manage form                                |
| /back/user/create           | GET       | Back\User      | create |            | user create : display form                             |
| /back/user/create           | POST      | Back\User      | create |            | user create : manage form                              |
| /back/user/{id}/delete      | GET       | Back\User      | delete | id = \d+   | user delete                                            |
