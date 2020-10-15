<?php
    // 定義頁面與編碼
    header('Content-type:text/html;charset=utf-8');
    // 跨域設定
    header('Access-Control-Allow-Origin: *');

    $host;

    $admin;
    $pwd;

    $db;

    // 與mySql的指定資料庫建立連線 ->  mysqli(主機,帳號,密碼,資料庫)
    $connect = new mysqli($host,$admin,$pwd,$db);

    // 若連接資料庫錯誤則使用die()直接停止不再往下執行,並出現錯誤訊息
    if($connect->connect_error){
        die("連線失敗!".$connect->connect_error);
    }

    // 若連接上資料庫則往下執行

    // 首先將執行結果(是否有執行錯誤)放入陣列($result),使其成為陣列第一個物件。使用=>給予陣列中的項目賦值
    // 要執行的行為(CRUD)設為變數 -> $action
    $result = array('error'=>false);
    $action = '';

    // 利用isset檢查$_GET是否有值
    // 若GET到的不是空值則將他指派給$action
    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }

    //*************//
    // CRUD處理部分 //
    //*************//

    // (C)Create -> 建立資料部分

    // 若$action值為create則將指定的資料寫入users(table)裡面
    if($action == 'create'){
        $name = $_POST['name'];
        $email = $_POST['email'];

        $sql = $connect->query("INSERT INTO users (name,email) VALUES('$name','$email')");

        if($sql){
            $result['message'] = '使用者增加成功!';
        }else{
            $result['error'] = true;
            $result['message'] = '使用者增加失敗!';
        }
    }

    // (R)Read -> 讀取資料部分

    // 若$action值為read則將資料庫中的table(users)調用出來,並將結果寫入users陣列，最後將所有的結果寫入到$result中的users物件
    if($action == 'read'){
        // 取得查詢users表單的內容
        $sql = $connect->query("SELECT * FROM users");
        $users = array();

        // 將資料依序寫入$result陣列中。
        // 使用fetch_assoc()讀取資料,並以欄位名稱為索引(此例為name,email)，進行持續查詢直到最後一筆。
        while($row = $sql->fetch_assoc()){
            // array_push(陣列,值),將資料($row)寫入陣列($users)
            array_push($users,$row);
        }
        // 最後將$result中的users物件指向$users陣列
        $result['users'] = $users;
    }

    // (U)Update -> 更新資料部分

    // 若$action值為update則根據id將修改的資料寫入對應的欄位
    if($action == 'update'){
        $id = $_POST['ID'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        $sql = $connect->query("UPDATE users SET name = '$name' ,email = '$email' WHERE id = '$id'");

        if($sql){
            $result['message'] = '使用者資料修改成功!';
        }else{
            $result['error'] = true;
            $result['message'] = '使用者資料修改失敗!';
        }
    }

    // (D)Delete -> 刪除資料部分

    // 若$action值為delete則根據id刪除users中對應的資料
    if($action == 'delete'){
        $id = $_POST['ID'];

        $sql = $connect->query("DELETE FROM users WHERE id = '$id'");

        if($sql){
            $result['message'] = '使用者資料刪除成功!';
        }else{
            $result['error'] = true;
            $result['message'] = '使用者資料刪除失敗!';
        }
    }

    // 處理完後關閉資料庫的連線
    $connect->close();
    
    // 處理後將資料打包成json格式(json_encode()),然後輸出
    echo json_encode($result)
?>