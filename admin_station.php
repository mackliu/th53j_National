<div class="list">
    <h1 class="border p-3 text-center my-3">站點管理 
        <button class="btn btn-success" onclick="$('.add').show();$('.list,.edit').hide()">新增</button>
    </h1>
    <table class="table table-bordered text-center">
    <tr>
        <td style="width:30%">站點名稱</td>
        <td style="width:20%">行駛時間(分鐘)</td>
        <td style="width:20%">停留時間(分鐘)</td>
        <td style="width:30%">操作</td>
    </tr>
    <?php 
    //取出所有站點資料並依照before欄位進行排序
    $sql="select * from `station` order by `before`";
    $rows=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    foreach($rows as $key => $row){
        if($key !==0 ){
            $up=$row['id'] . '-' . $rows[$key-1]['id'];
        }else{
            $up=$row['id'] . '-' . $row['id'];
            $down=$row['id'] . '-' . $rows[$key+1]['id'];
        }

        if($key != array_key_last($rows)){
            $down=$row['id']. '-' . $rows[$key+1]['id'];
        }else{
            $down=$row['id'] . '-' . $row['id'];
            $up=$row['id'] . '-' . $rows[$key-1]['id'];
        }

    ?>
    <tr>
        <td><?=$row['name'];?></td>
        <td><?=$row['minute'];?></td>
        <td><?=$row['waiting'];?></td>
        <td>
            <?php
                if($key != 0 ){
                    echo "<button class='sw btn btn-info' data-id='$up'>往上</button>"   ;
                }
            ?>
            <?php
                if($key != array_key_last($rows)){
                    echo "<button class='sw btn btn-info' data-id='$down'>往下</button>";
                }
            ?>
            <button class="btn btn-warning" onclick="edit('station',<?=$row['id'];?>);$('.edit').show();$('.list,.add').hide()">編輯</button>
            <button class="btn btn-danger" onclick="del('station',<?=$row['id'];?>)">刪除</button>
        </td>
    </tr>    
    <?php 
    }
    ?>    
    </table>
</div>
<div class="add" style="display:none">
 <h1 class="border p-3 my-3 text-center">新增站點</h1>
    <form action="./api/add_station.php" method="post">

    <div class="row w-100">
        <label for="" class="col-2">站點名稱</label>   
        <input  type="text" name="name" id="name" class='form-group form-control col-10'>
    </div>
    <div class="row w-100">
        <label for="" class="col-2">行駛時間(分鐘)</label>   
        <input  type="number" name="minute" id="addMinute" class='form-group form-control col-10'
                min='0' step="1" required>
    </div>
    <div class="row w-100">
        <label for="" class="col-2">停留時間(分鐘)</label>   
        <input  type="number" name="waiting" id="addWaiting" class='form-group form-control col-10'
                min='0' step="1" required>
    </div>
    <div class="row w-100">
        <input  type="submit" value="新增" class='col-12 btn btn-success my-1'>
        <input  type="button" value="回上頁" class='col-12 btn btn-secondary my-1' onclick="$('.list').show();$('.edit,.add').hide()">
    </div>
    </form>

 </div>
 <div class="edit" style="display:none">
 <h1 class="border p-3 my-3 text-center">修改「<span id='title'></span>」</h1>
    <form action="./api/edit_station.php" method="post">
    <div class="row w-100">
        <label for="" class="col-2">行駛時間(分鐘)</label>   
        <input  type="number" name="minute" id="editMinute" class='form-group form-control col-10'
                min='0' step="1" required>
    </div>
    <div class="row w-100">
        <label for="" class="col-2">停留時間(分鐘)</label>   
        <input  type="number" name="waiting" id="editWaiting" class='form-group form-control col-10'
                min='0' step="1" required>
    </div>
    <div class="row w-100">
        <input type="hidden" name="id" id="editId">
        <input  type="submit" value="修改" class='col-12 btn btn-success my-1'>
        <input  type="button" value="回上頁" class='col-12 btn btn-secondary my-1' onclick="$('.list').show();$('.edit,.add').hide()">
    </div>
    </form>

 </div>
