<?php

test('landing page shows requested sections and theme toggle', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('বাংলাদেশের প্রথম AI-চালিত প্রশ্নব্যাংক');
    $response->assertSee('কেন প্রশ্নব্যাংক বেছে নেবেন?');
    $response->assertSee('id="theme-toggle"', false);
    $response->assertSee('id="pricing"', false);
});
