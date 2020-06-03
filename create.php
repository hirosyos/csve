<?php

// functions.php を読み込み
require('function.php');

// POSTされたJSON文字列を取り出し
$json = file_get_contents("php://input");

// JSON文字列をobjectに変換
//   ⇒ 第2引数をtrueにしないとハマるので注意
$contents = json_decode($json, true);

// デバッグ用にダンプ
var_dump($contents);

$timestamp = time();
$filename = date("Y_m_d_H_i_s", $timestamp);

// ファイルを開く処理
$file = fopen("data/${filename}.csv", 'a');

// ファイルロックの処理
flock($file, LOCK_EX);

// ファイル書き込み処理
for ($row = 3; $row < count($contents); $row++) {
    for ($col = 3; $col < count($contents[$row]); $col++) {
        fwrite($file, "\"{$contents[$row][$col]}\" ,");
    }
    fwrite($file, "\n");
}


// ファイルアンロックの処理
flock($file, LOCK_UN);

// ファイルを閉じる処理
fclose($file);
