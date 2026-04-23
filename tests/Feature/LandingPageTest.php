<?php

test('landing page shows question bank messaging for teachers and learners', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('শিক্ষকদের জন্য পাওয়ারফুল টুলস');
    $response->assertSee('শিক্ষার্থী ও চাকরিপ্রার্থীদের জন্য স্মার্ট প্র্যাকটিস');
    $response->assertSee('id="theme-toggle"', false);
});
