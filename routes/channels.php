<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('presence.chat', function ($user)
{
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('chat', function (string $response)
{
    return $response;
});
