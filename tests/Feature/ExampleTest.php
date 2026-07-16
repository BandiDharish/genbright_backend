<?php

test('the application redirects to the admin login page', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('admin.login'));
});
