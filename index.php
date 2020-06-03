<?php

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>C.S.V.E</title>
</head>

<body>
    <h1>C.S.V.E</h1>
    <!-- <button >作成</button> -->
    <div id='createTable'></div>
</body>

<footer>
</footer>

<script>
    //
    // CSVデータの元データ [row][col]
    //
    let csvArray = [
        ['-----', '-----', '-----', '列削除', '列削除', '列削除', '列削除'],
        ['-----', '-----', '-----', '列追加', '列追加', '列追加', '列追加'],
        ['-----', '-----', '-----', '----0', '----1', '----2', '----3'],
        ['行削除', '行追加', '----0', '-----', '-----', '-----', '-----'],
        ['行削除', '行追加', '----1', '-----', '-----', '-----', '-----'],
    ];

    //
    // CSVからHTMLのデータを作成する
    //
    function createHtmlFromCsv() {
        let col;
        let row;

        let htmlTxt;
        htmlTxt = `<table>`;

        //
        // 0行目 列削除ボタン
        //
        htmlTxt += `<tr>`;
        for (col = 0; col < 3; col++) {
            htmlTxt += `<th></th>`;
        }
        for (col = 3; col < csvArray[0].length; col++) {
            //列削除ボタン
            htmlTxt += `<th><button>列削除</button></th>`;
        }
        //
        // 1行目 列追加ボタン
        //
        htmlTxt += `<tr>`;
        for (col = 0; col < 3; col++) {
            htmlTxt += `<th></th>`;
        }
        for (col = 3; col < csvArray[1].length; col++) {
            //列追加ボタン
            htmlTxt += `<th><button>列追加</button></th>`;
        }
        //
        // 2行目 列インデックス
        //
        htmlTxt += `<tr>`;
        for (col = 0; col < 3; col++) {
            htmlTxt += `<th></th>`;
        }
        for (col = 3; col < csvArray[2].length; col++) {
            //列追加ボタン
            htmlTxt += `<th>${col-2}</th>`;
        }
        //
        // 3行目移行 実データ
        //
        for (row = 3; row < csvArray.length; row++) {
            htmlTxt += `<tr>`;
            //行削除ボタン
            htmlTxt += `<th><button>行削除</button></th>`;

            //行追加ボタン
            htmlTxt += `<th><button>行追加</button></th>`;

            //行インデックス
            htmlTxt += `<th>${row-2}</th>`;

            //実際のCSVデータ
            for (col = 3; col < csvArray[row].length; col++) {
                htmlTxt += `<td><form action = "" name = ${row}_${col}><input type = "text" > </form></td>`;
            }

            htmlTxt += `</tr>`;

        }

        htmlTxt += `</table>`;

        $('#createTable').html(htmlTxt);
    }

    //CSVデータからHTMLテーブル作成
    createHtmlFromCsv();
</script>

</html>