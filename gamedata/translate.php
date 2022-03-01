<?php

$start = microtime(true);

ini_set('display_errors', false);
ini_set('display_startup_errors', false);

if (!file_exists('./furnidata.xml')) {
    throw new RuntimeException('furnidata.xml is does not exist or is not readable');
}

if (!file_exists('./furnidata_br.xml')) {
    throw new RuntimeException('furnidata_br.xml is does not exist or is not readable');
}

$furnidata = new SimpleXMLElement(file_get_contents('./furnidata_en.xml'));
$translate = new SimpleXMLElement(file_get_contents('./furnidata_br.xml'));
$translate = array_merge_recursive(
    (array) $translate->roomitemtypes,
    (array) $translate->wallitemtypes
);

foreach ($translate['furnitype'] as $furni) {
    $file         = (string) $furni->attributes()['classname'];
    $trans[$file] = [
        $furni->name,
        $furni->description,
    ];
}

foreach ($furnidata->roomitemtypes->furnitype as $furni) {
    $file = (string) $furni->attributes()['classname'];

    if (!isset($trans[$file])) {
        continue;
    }

    list($name, $desc) = $trans[$file];

    $furni->name        = $name;
    $furni->description = $desc;
}

foreach ($furnidata->wallitemtypes->furnitype as $furni) {
    $file = (string) $furni->attributes()['classname'];

    if (!isset($trans[$file])) {
        continue;
    }

    list($name, $desc) = $trans[$file];

    $furni->name        = $name;
    $furni->description = $desc;
}

$furnidata->asXML('./furnidata_en.xml');

echo 'Finished, execution time: ' . (microtime(true) - $start) . ' seconds';
