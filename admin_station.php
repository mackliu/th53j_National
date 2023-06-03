<div class="list">
    <h1 class="border p-3 text-center my-3">站點管理 
        <button class="btn btn-success" onclick="$('.add').show();$('.list,.edit').hide()">新增</button>
    </h1>
    <table class="table table-bordered text-center">
    <tr>
        <td style="width:40%">站點名稱</td>
        <td style="width:20%">行駛時間(分鐘)</td>
        <td style="width:20%">停留時間(分鐘)</td>
        <td style="width:20%">操作</td>
    </tr>
    <?php 
    $sql="select * from `station`";
    $rows=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    foreach($rows as $row){
    ?>
    <tr>
        <td><?=$row['name'];?></td>
        <td><?=$row['minute'];?></td>
        <td><?=$row['waiting'];?></td>
        <td>
            <button class="btn btn-warning" onclick="edit(<?=$row['id'];?>);$('.edit').show();$('.list,.add').hide()">編輯</button>
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
        <input  type="number" name="minute" id="addMinute" class='form-group form-control col-10'>
    </div>
    <div class="row w-100">
        <label for="" class="col-2">停留時間(分鐘)</label>   
        <input  type="number" name="waiting" id="addWaiting" class='form-group form-control col-10'>
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
        <input  type="number" name="minute" id="editMinute" class='form-group form-control col-10'>
    </div>
    <div class="row w-100">
        <label for="" class="col-2">停留時間(分鐘)</label>   
        <input  type="number" name="waiting" id="editWaiting" class='form-group form-control col-10'>
    </div>
    <div class="row w-100">
        <input type="hidden" name="id" id="editId">
        <input  type="submit" value="修改" class='col-12 btn btn-success my-1'>
        <input  type="button" value="回上頁" class='col-12 btn btn-secondary my-1' onclick="$('.list').show();$('.edit,.add').hide()">
    </div>
    </form>

 </div>
 <script>
    //前端編輯資料用的函式
    function edit(id){

        //使用getJSON向後端api get_bus.php發出取得資料的請求
        $.getJSON('./api/get_station.php',{id},(station)=>{
            //api 回傳的資料會是一個json格式的物件
            console.log(station)
            //將station物件中的name資料寫入到頁面上id為title的tag中
            $("#title").html(station.name);

            //將station物件中的minute資料寫入到頁面上id為editMinute的input欄位的值
            $("#editMinute").val(station.minute);

            //將station物件中的waiting資料寫入到頁面上id為editMinute的input欄位的值
            $("#editWaiting").val(station.waiting);

            //將station物件中的id資料寫入到頁面上id為editId的input欄位的值
            $("#editId").val(station.id);
        })
    }

    function del(table,id){
        $.post("./api/del.php",{table,id},()=>{
            location.reload();
        })
    }
 </script>