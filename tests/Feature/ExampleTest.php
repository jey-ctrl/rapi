<?php

test('the home page redirects to the calendar', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('calendar'));
});