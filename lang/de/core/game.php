<?php

use Domain\Core\Enums\GameEndTypeEnum;

return [
    'name_singular' => 'Spiel',
    'name_plural' => 'Spiele',
    'attributes' => [
        'name' => 'Name',
        'description' => 'Beschreibung',
        'signed_up_users' => 'Anmeldungen',
        'game_master' => 'Spielleiter',
        'phase' => 'Phase',
        'game_end_type' => 'Art des Endes',
    ],
    'actions' => [
        'finish' => 'Spiel beenden',
        'finish_confirmation' => 'Soll das Spiel wirklich beendet werden? Du kannst dann keine Änderungen wie VZ-Anzahl oder NMRs mehr vornehmen.',
        //'finish_success' => "Das Spiel wurde beendet.",
    ],
    'states' => [
        'game_end_type' => [
            GameEndTypeEnum::DRAW->name => 'Unentschieden',
            GameEndTypeEnum::VICTORY->name => 'Sieg',
        ],
    ],
];
