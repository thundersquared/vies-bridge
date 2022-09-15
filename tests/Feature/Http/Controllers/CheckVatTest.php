<?php

test('example', function () {
    $response = $this->post('/api/vies/check', [
        'body' =>
    ]);

    $response->assertStatus(200);
});
