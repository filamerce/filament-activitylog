<?php
return [
    'title' => [
        'modifiedTitle' => 'Zasób <strong>%s</strong> został <strong>%s</strong> przez <strong>%s</strong>. <br><small> Data aktualizacji: <strong>%s</strong></small>',
    ],
    'event' => [
        'created'      => 'utworzony',
        'updated'      => 'zaktualizowany',
        'deleted'      => 'usunięty',
        'restored'     => 'przywrócony',
        'forceDeleted' => 'trwale usunięty',
        'byperson'     => [
            'created'      => 'utworzył',
            'updated'      => 'zmienił',
            'deleted'      => 'usunął',
            'restored'     => 'przywrócił',
            'forceDeleted' => 'trwale usunął',
        ],
    ],
    'properties' => [
        'modifiedProperties'     => '<strong>%s</strong> %s dane: <br>%s',
        'compareOldAndNewValues' => [
            'notEquals' => '- %s z <strong>%s</strong> na <strong>%s</strong>',
            'equals'    => '- %s na <strong>%s</strong>',
        ],
        'getNewValues' => '- %s <strong>%s</strong>',
    ],
];
