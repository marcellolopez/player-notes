<?php


test('registration screen is not available', function () {
    $response = $this->get('/register');


    $response->assertNotFound();
});
