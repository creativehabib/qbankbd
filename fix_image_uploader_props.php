<?php

$file = 'resources/views/components/modern-image-uploader.blade.php';
$content = file_get_contents($file);

$content = str_replace(
    [
        '$upload = $this->getPropertyValue($uploadModel);',
        '$existing = $this->getPropertyValue($existingModel);',
    ],
    '',
    $content
);

$content = str_replace(
    "'uploadModel',",
    "'uploadModel',\n    'upload' => null,",
    $content
);
$content = str_replace(
    "'existingModel',",
    "'existingModel',\n    'existing' => null,",
    $content
);

file_put_contents($file, $content);
