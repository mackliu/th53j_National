<?php
//$dsn="mysql:host=localhost;charset=utf8;dbname=db15";
$dsn="mysql:host=localhost;charset=utf8;dbname=db77";
$pdo=new PDO($dsn,'root','');

session_start();

function get_station($id){
    global $pdo;
    
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
    
    //巡訪每一部接駁車，計算接駁車和此站點的時間關係
    //建立一個陣列用來儲存每部接駁車目前和此一站點的到站時間及離站時間差距
    $busInfo=[];
    
    foreach($buses as $bus){
        $bus['arrive']=$bus['minute']-$arrive;
        $bus['leave']=$bus['minute']-$leave;
        if($bus['arrive']<0){
            $bus['status']='wait';
            $bus['show']='約'.abs($bus['arrive']).'分鐘';
        }else if($bus['arrive']>=0 && $bus['leave'] <=0){
            $bus['status']='arrive';
            $bus['show']='已到站';
        }else{
            $bus['status']='passed';
            $bus['show']='已過站';
        }
    
        $busInfo[$bus['name']]=$bus;
    }   
    
    //建立一個二維陣列，依，己到站，未到站，已過站順序分類接駁車
    $sortBus=[
        0=>[],
        1=>[],
        2=>[],
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
     * 未到站：依大->小排序，表示快到站的時間
     * 已過站：依小->大排序，表示離站的時間
     */
    
     if(!empty($sortBus[1])){
        uasort($sortBus[1],function($a,$b){
            return $b['arrive'] - $a['arrive'];
        });
     }
    
    if(!empty($sortBus[2])){
        uasort($sortBus[2],function($a,$b){
            return $a['leave'] - $b['leave'];
        });  
    }

    $busInfo=[];
    
    foreach($sortBus as $group){
        $busInfo=array_merge($busInfo,$group);
    }
    
    return ['name'=>$station['name'],
            'buses'=>$busInfo];
        }
?>