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
        ['行削除', '行追加', '----0', '---aa', '---ab', '---ac', '---ad'],
        ['行削除', '行追加', '----1', '---ba', '---bb', '---bc', '---bd'],
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
            htmlTxt += `<th><button name='colDelBtn' id='colDelBtn_${col}' value='${col}'>列削除</button></th>`;
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
            htmlTxt += `<th><button name='colAddBtn' id='colAddBtn_${col}' value='${col}'>列追加</button></th>`;
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
            htmlTxt += `<th><button name='rowDelBtn' id='rowDelBtn_${row}' value='${row}'>行削除</button></th>`;

            //行追加ボタン
            htmlTxt += `<th><button name='rowAddBtn' id='rowAddBtn_${row}' value='${row}'>行追加</button></th>`;

            //行インデックス
            htmlTxt += `<th>${row-2}</th>`;

            //実際のCSVデータ
            for (col = 3; col < csvArray[row].length; col++) {
                htmlTxt += `<td><form action = "" name = ${row}_${col}><input type = "text" value=${csvArray[row][col]}> </form></td>`;
            }

            htmlTxt += `</tr>`;

        }

        htmlTxt += `</table>`;

        $('#createTable').html(htmlTxt);
    }

    // 列削除ボタン押下イベント
    $('#createTable').on('click', 'button[name="colDelBtn"]', function() {
        //削除する列は
        let colNo = $(this).val();
        console.log(`削除する列は${colNo}`);

        //列削除
        for (let rowNo = 0; rowNo < csvArray.length; rowNo++) {
            let resultAry = csvArray[rowNo].splice(colNo, 1);
        }
        createHtmlFromCsv();
    });
    // 列追加ボタン押下イベント
    $('#createTable').on('click', 'button[name="colAddBtn"]', function() {
        //追加する列は
        let colNo = $(this).val();
        console.log(`追加する列は${colNo}`);

        //列追加
        for (let rowNo = 0; rowNo < csvArray.length; rowNo++) {
            let resultAry = csvArray[rowNo].splice(colNo, 0, "");
        }
        createHtmlFromCsv();

    });
    // 行削除ボタン押下イベント
    $('#createTable').on('click', 'button[name="rowDelBtn"]', function() {
        //削除する行は
        let rowNo = $(this).val();
        console.log(`削除する行は${rowNo}`);

        //行削除
        let resultAry = csvArray.splice(rowNo, 1);
        createHtmlFromCsv();
    });
    // 列追加ボタン押下イベント
    $('#createTable').on('click', 'button[name="rowAddBtn"]', function() {
        //追加する行は
        let rowNo = $(this).val();
        console.log(`削除する行は${rowNo}`);

        //行追加
        let newRow = [];
        for (let colNo = 0; colNo < csvArray[rowNo].length; colNo++) {
            newRow.push("");
        }
        let resultAry = csvArray.splice(rowNo, 0, newRow);
        createHtmlFromCsv();
    });

    //CSVデータからHTMLテーブル作成
    createHtmlFromCsv();
</script>

</html>