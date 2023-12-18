<?php

return [
    /* configuració de connexió a la base dades */
    /* Path on guardarem el fitxer sqlite */
    "sqlite" => [
        "path" => Emeset\Env::get("sqlite_path", "../"),
        "name" => Emeset\Env::get("sqlite_name", "db.sqlite")
    ],

    "app" => [
        "name" => Emeset\Env::get("app_name", "Orlify"),
        "version" => Emeset\Env::get("app_version", "0.2.5")
    ],
    "database" => [
        "server" => "localhost",
        "username" => "root",
        "password" => "",
        "database" => "orles"
    ]
];
