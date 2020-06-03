<?php

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/encoding-japanese/1.0.30/encoding.js"></script>
    <title>C.S.V.E</title>
</head>

<header>
    <!-- タイトルと説明 -->
    <h1 id='aboutTitle' class='title'>C.S.V.E</h1>
    <p id='aboutCsve'>online CSV Editor</p>
    <form action="">
        <input type="file" id='localCsvFile' />
    </form>
    <button id=localSaveBtn>一時保存</button>
    <button id=localSaveReadBtn>再読み込み</button>
    <button id=localSaveClearBtn>クリア</button>
    <button id=csvDownLoadBtn>ダウンロード</button>
</header>

<body>
    <div class='tableArea' id='createTable'></div>
</body>

<footer>
</footer>

<script>
    //
    // CSVデータの元データ [row][col]
    //
    let csvArray = [
        ['00', '01', '02', '03', '04', '05'],
        ['10', '11', '12', '13', '14', '15'],
        ['20', '21', '22', '23', '24', '25'],
        ['30', '31', '32', '33', '34', '35'],
        ['40', '41', '42', '43', '44', '45'],
    ];

    function createArray(csvData) {
        //CSVデータの元データを初期化
        csvArray = [];

        let tempArray = csvData.split("\n");
        let tempCsvArray = new Array();
        for (let i = 0; i < tempArray.length; i++) {
            tempCsvArray[i] = tempArray[i].split(",");
        }
        // console.log(tempCsvArray);
        csvArray = tempCsvArray;
        // console.log('createArray直後');
        // console.log(csvArray);
    }

    //
    // ファイル選択されたとき
    //
    let obj1 = document.getElementById("localCsvFile");
    obj1.addEventListener("change", function(evt) {
        let file = evt.target.files;
        // alert(file[0].name + "を取得しました。");

        //FileReaderの作成
        let reader = new FileReader();

        //テキスト形式で読み込む
        reader.readAsText(file[0]);
        reader.onload = function(ev) {
            // let utf8Array = Encoding.convert(reader.result, 'UTF8', 'AUTO');
            // document.test.txt.value = reader.result;
            // console.log(utf8Array);
            // console.log(reader.result);
            createArray(reader.result);
            // alert('aaa');
            // console.log('createArray呼び終わったあと');
            // console.log(csvArray);
            createHtmlFromCsv();

        }



    }, false);

    //
    // CSVからHTMLのデータを作成する
    //
    function createHtmlFromCsv() {
        let col;
        let row;

        let htmlTxt;
        htmlTxt = `<table>`;

        // console.log('読み込み直後');
        // console.log(csvArray);

        // alert('bbb');

        //
        // 0行目 列削除ボタン
        //
        htmlTxt += `<tr>`;
        for (col = 0; col < 3; col++) {
            htmlTxt += `<th></th>`;
        }
        for (col = 0; col < csvArray[0].length; col++) {
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
        for (col = 0; col < csvArray[0].length; col++) {
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
        for (col = 0; col < csvArray[0].length; col++) {
            //列インデックス
            htmlTxt += `<th>${col}</th>`;
        }
        //
        // 3行目移行 実データ
        //
        for (row = 0; row < csvArray.length; row++) {
            htmlTxt += `<tr>`;
            //行削除ボタン
            htmlTxt += `<th><button name='rowDelBtn' id='rowDelBtn_${row}' value='${row}'>行削除</button></th>`;

            //行追加ボタン
            htmlTxt += `<th><button name='rowAddBtn' id='rowAddBtn_${row}' value='${row}'>行追加</button></th>`;

            //行インデックス
            htmlTxt += `<th>${row}</th>`;

            //実際のCSVデータ
            for (col = 0; col < csvArray[row].length; col++) {
                htmlTxt += `<td><form action = "" name = ${row}_${col}><input type = "text" id="form_${row}_${col}" value=${csvArray[row][col]}> </form></td>`;
            }

            htmlTxt += `</tr>`;

        }

        htmlTxt += `</table>`;
        // alert('ccc');
        $('#createTable').html(htmlTxt);
    }

    //
    // 列削除ボタン押下イベント
    //
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
    //
    // 列追加ボタン押下イベント
    //
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

    //
    // 行削除ボタン押下イベント
    //
    $('#createTable').on('click', 'button[name="rowDelBtn"]', function() {
        //削除する行は
        let rowNo = $(this).val();
        console.log(`削除する行は${rowNo}`);

        //行削除
        let resultAry = csvArray.splice(rowNo, 1);
        createHtmlFromCsv();
    });

    //
    // 列追加ボタン押下イベント
    //
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

        //CSVデータからHTMLテーブル作成
        createHtmlFromCsv();
    });

    //
    // ローカルストレージ保存共通関数
    //
    function saveLocalStrage() {
        //フォームの値を配列に保存
        for (let rowNo = 0; rowNo < csvArray.length; rowNo++) {
            for (let colNo = 0; colNo < csvArray[rowNo].length; colNo++) {
                csvArray[rowNo][colNo] = $(`#form_${rowNo}_${colNo}`).val();
            }
        }
        //ローカルストレージに保存
        const csvArrayJson = JSON.stringify(csvArray);
        localStorage.setItem('csvdata', csvArrayJson);
    }
    //
    // 一時保存ボタン押下イベント
    //
    $('#localSaveBtn').on('click', function() {
        //ローカルストレージに保存
        saveLocalStrage();
    });

    //
    // 再読み込みボタン押下イベント
    //
    $('#localSaveReadBtn').on('click', function() {
        //ローカルストレージから読み出し
        if (localStorage.getItem('csvdata')) {
            const csvArrayJson = localStorage.getItem('csvdata')
            csvArray = JSON.parse(csvArrayJson);
        }
        //CSVデータからHTMLテーブル作成
        createHtmlFromCsv();
    });

    //
    // クリアボタン押下イベント
    //
    $('#localSaveClearBtn').on('click', function() {
        //ローカルストレージからクリア
        if (localStorage.getItem('csvdata')) {
            localStorage.clear('csvdata')
        }
        //CSVデータからHTMLテーブル作成
        createHtmlFromCsv();
    });

    //
    // ダウンロードボタン押下イベント
    //
    $('#csvDownLoadBtn').on('click', function() {
        //ローカルストレージに保存
        saveLocalStrage();
        //読み出し
        const csvArrayJson = localStorage.getItem('csvdata')
        //PHPに処理を渡す
        axios.post('./create.php', csvArrayJson)
            .then(function(response) {
                console.log('ok!');
                // リクエスト成功時の処理(responseに結果が入っている)
            }).catch(function(error) {
                // リクエスト失敗時の処理(errorにエラー内容が入っている)
                console.log(error);
            }).finally(function() {
                // 成功失敗に関わらず必ず実行
                console.log('done!');
            });

    });

    //
    // 初回読み込み動作
    //

    //ローカルストレージから読み出し
    if (localStorage.getItem('csvdata')) {
        const csvArrayJson = localStorage.getItem('csvdata')
        csvArray = JSON.parse(csvArrayJson);
    }

    //CSVデータからHTMLテーブル作成
    createHtmlFromCsv();
</script>

</html>