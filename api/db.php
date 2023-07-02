<?php
//$dsn="mysql:host=localhost;charset=utf8;dbname=db15";
$dsn="mysql:host=localhost;charset=utf8;dbname=th53j_National";
$pdo=new PDO($dsn,'root','');

session_start();

/**
 * 這個函式用來計算單一站點上的接駁車狀態，
 * $id 站點的id
 */
function get_station($id){
    global $pdo;  //取得外部的$pdo變數
    
    //撈出站點資料
    $station=$pdo->query("select * from `station` where `id`='$id'")->fetch(PDO::FETCH_ASSOC);
    
    //計算站點前的所有站點行駛時間總計(到達時間＋停等時間)
    $prev_time=$pdo->query("select sum(`minute`+`waiting`) from `station` where `before`< {$station['before']}")->fetchColumn();
    
    //計算當前站點的到站時間
    $arrive=$prev_time+$station['minute'];
    
    //計算當前站點的離站時間
    $leave=$arrive+$station['waiting'];
    
    //撈出所有的接駁車資訊
    $buses=$pdo->query("select * from bus")->fetchAll(PDO::FETCH_ASSOC);
    
    //建立一個陣列用來儲存每部接駁車目前和此一站點的到站時間及離站時間差距
    $busInfo=[];
    
    //巡訪每一部接駁車，計算接駁車和此站點的時間關係
    foreach($buses as $bus){

        /**
         * 計算接駁車的行駛時間和站點的到站時間差異
         * 時間差異小於0 => 接駁車還沒到站
         * 時間差異等於0 => 接駁車剛到站
         * 時間差異大於0 => 接駁車在站點等待或離站
         **/
        $bus['arrive']=$bus['minute']-$arrive;

        /**
         * 計算接駁車的行駛時間和站點的離站時間差異
         * 時間差異小於0 => 接駁車還沒離站
         * 時間差異等於0 => 接駁車開始離站
         * 時間差異大於0 => 接駁車已離站
         **/
        $bus['leave']=$bus['minute']-$leave;

        if($bus['arrive']<0){ 

            //到站時間差異小於0表示未到站，
            //此時在接駁車的資料中加上status和show的文字
            $bus['status']='wait';
            $bus['show']='約'.abs($bus['arrive']).'分鐘';

        }else if($bus['arrive']>=0 && $bus['leave'] <=0){
            
            //到站時間差異大於等於0表示已到站，
            //同時離站時間<=0表示未離站，綜合兩個條件可以判斷出接駁站在等待中
            //此時在接駁車的資料中加上status和show的文字
            $bus['status']='arrive';
            $bus['show']='已到站';

        }else{
            //排除以上的狀況則是已過站的情形
            //此時在接駁車的資料中加上status和show的文字
            $bus['status']='passed';
            $bus['show']='已過站';
        }
        
        //把改造好的接駁車資料以接駁車名字為KEY放入到$busInfo陣列中
        $busInfo[$bus['name']]=$bus;
    }   
    
    //建立一個二維陣列，依，己到站，未到站，已過站順序分類接駁車
    $sortBus=[
        0=>[],  //用來放已到站的接駁車
        1=>[],  //用來放未到站的接駁車
        2=>[],  //用來放已過站的接駁車
    ];
    
    //將接駁車分類到三個不同的陣列進行不同的處理
    foreach($busInfo as $name => $bus){
    
        switch($bus['status']){
            case 'arrive':
                $sortBus[0][]=$bus;
            break;
            case 'wait':
                $sortBus[1][]=$bus;
            break;
            case 'passed':
                $sortBus[2][]=$bus;
            break;
        }
    }
    
    /**
     * 排序接駁車：
     * 已到站：應該是只有一筆，而且會在陣列最前面
     * 未到站：依大->小排序，表示快到站的時間，如:-4,-10,-23
     * 已過站：依小->大排序，表示離站的時間，如:4,10,23
     */

    //判斷未到站的陣列是否有內容，有的話就進行排序
     if(!empty($sortBus[1])){

        //使用uasort排序可以保留陣列Key值
        uasort($sortBus[1],function($a,$b){

            //使用$b-$a來做成由大到小的排序結果
            return $b['arrive'] - $a['arrive'];
        });
     }

    //判斷未到站的陣列是否有內容，有的話就進行排序    
    if(!empty($sortBus[2])){

        //使用$a-$b來做成由小到大的排序結果
        uasort($sortBus[2],function($a,$b){
            return $a['leave'] - $b['leave'];
        });  
    }

    //清空$busInfo陣列的內容
    $busInfo=[];
    
    //把$sortBus的三個陣列合併做成已到站->未到站->已過站順序的一維陣列
    /**
     * 如此可以很確認陣列的第一個資料就是畫面上要顯示的接駁車資料,
     * 而前三筆資料也是彈出視窗要顯示的資料
     * [已到站,
     *  未到站1(-4),
     *  未到站2(-10),
     *  未到站3(-23),
     *  已過站1(4),
     *  已過站2(10),
     *  已過站3(23)]
     */
    foreach($sortBus as $group){
        $busInfo=array_merge($busInfo,$group);
    }
    
    //以陣列的方式回傳資料，
    //陣列的內容包含站點的名字及所有接駁車與此站點的狀態及時間資料
    return ['name'=>$station['name'],
            'buses'=>$busInfo];
        }
?>