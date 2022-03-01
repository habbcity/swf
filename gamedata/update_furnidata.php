<?php
ini_set('user_agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36');

$hashes = array(
    'en' => array(
        array(
            'name'      => 'furnidata',
            'hash'      => file_get_contents('hashes/com/furnidata'),
            'hash_path' => 'hashes/com/furnidata',
            'file_path' => 'furnidata_en.xml'
        ),
        array(
            'name'      => 'figurepartlist',
            'hash'      => file_get_contents('hashes/com/figurepartlist'),
            'hash_path' => 'hashes/com/figurepartlist',
            'file_path' => 'figuremap.xml'
        ),
    ),
    'br' => array(
        array(
            'name'      => 'furnidata',
            'hash'      => file_get_contents('hashes/br/furnidata'),
            'hash_path' => 'hashes/br/furnidata',
            'file_path' => 'furnidata_br.xml'
        ),
        array(
            'name'      => 'productdata',
            'hash'      => file_get_contents('hashes/br/productdata'),
            'hash_path' => 'hashes/br/productdata',
            'file_path' => 'productdata.txt'
        ),
        array(
            'name'      => 'external_texts',
            'hash'      => file_get_contents('hashes/br/external_texts'),
            'hash_path' => 'hashes/br/external_texts',
            'file_path' => 'external_flash_texts.txt'
        ),
    )
);

$hashes = (object) $hashes;

/* UPDATE HABBO.COM */
$json = json_decode(file_get_contents('https://www.habbo.com/gamedata/hashes'));
foreach ($json->hashes as $j) {

    foreach ($hashes->en as $hash) {

        if ($j->name == $hash['name']) {

            if ($j->hash !== $hash['hash']) {

                /* UPDATE HASH */
                file_put_contents($hash['hash_path'], $j->hash);

                /* DOWNLOAD FILE */
                copy($j->url . '/' . $j->hash, $hash['file_path']);
            } else {

                continue;
            }
        } else {
            continue;
        }
    }
}

/* UPDATE HABBO.COM.BR */
$json = json_decode(file_get_contents('https://www.habbo.com.br/gamedata/hashes'));
foreach ($json->hashes as $j) {

    foreach ($hashes->br as $hash) {

        if ($j->name == $hash['name']) {

            if ($j->hash !== $hash['hash']) {

                /* UPDATE HASH */
                file_put_contents($hash['hash_path'], $j->hash);

                /* DOWNLOAD FILE */
                copy($j->url . '/' . $j->hash, $hash['file_path']);
            } else {

                continue;
            }
        } else {
            continue;
        }
    }
}
