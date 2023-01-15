<?php

return [
    'name_singular' => 'Spieler',
    'name_plural' => 'Spieler',
    'attributes' => [
        'power' => 'Land',
        'nmr_count' => 'NMRs',
        'sc_count' => 'VZs',
        'rank' => 'Platz',
    ],
    'actions' => [
        'ban' => 'Rausschmeißen',
        'nmr' => 'NMR',
        'assign' => 'Zuweisen',
    ],
    'assign_users' => [
        'title' => 'Spieler zuweisen',
        'show_all_users' => sprintf('Zeige alle %s', __('users/user.name_plural')),
        'show_all_users_hint' => sprintf('Zeige alle %s, auch wenn sie sich nicht für dieses %s angemeldet haben', __('users/user.name_plural'), __('core/game.name_singular')),
    ],
];
