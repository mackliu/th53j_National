<div class="list">
    <h1 class="border p-3 text-center my-3">接駁車管理 
        <button class="btn btn-success" onclick="$('.add').show();$('.list,.edit').hide()">新增</button>
    </h1>
     <table class="table table-bordered text-center">
     <tr>
         <td class="col-4">車牌</td>
         <td class="col-4">已行駛時間</td>
         <td class="col-4">操作</td>
     </tr>
     <?php 

        //建立取得所有接駁車的sql語法
        $sql="select * from `bus`";

        //向資料表發出請求，並取回所有接駁車的資料
        $rows=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        //使用迴圈foreach來將每一筆資料印出在頁面上
        foreach($rows as $row){
     ?>
     <tr>
         <td><?=$row['name'];?></td>
         <td><?=$row['minute'];?>分鐘</td>
         <td>
                                        <!-- 在按鈕標籤中直接觸發onclick事件，並在事件發生時執行：
                                            1.使用ajax向後端取得資料(edit())
                                            2.使用jquery來切換畫面上各區塊的顯示狀態 -->
             <button class="btn btn-warning" onclick="edit(<?=$row['id'];?>);$('.edit').show();$('.list,.add').hide()">編輯</button>
             <button class="btn btn-danger">刪除</button>
         </td>
     </tr>
     <?php 
        }
     ?>     
     </table>
 </div>
 <div class="add" style="display:none">
 <h1 class="border p-3 my-3 text-center w-100">新增接駁車</h1>
    <form action="./api/add_bus.php" method="post">

    <div class="row w-100">
        <label for="" class="col-2">車牌</label>   
        <input  type="text" name="name" id="name" class='form-group form-control col-10'>
    </div>
    <div class="row w-100">
        <label for="" class="col-2">已行駛時間(分鐘)</label>   
        <input  type="number" name="minute" id="addMinute" class='form-group form-control col-10'>
    </div>
    <div class="row w-100">
        <input  type="submit" value="新增" class='col-12 btn btn-success my-1'>
                                                                                <!-- 在按鈕標籤中直接觸發onclick事件，並在事件發生時執行：
                                                                                     1.使用jquery來切換畫面上各區塊的顯示狀態 -->
        <input  type="button" value="回上頁" class='col-12 btn btn-secondary my-1'  onclick="$('.list').show();$('.edit,.add').hide()">
    </div>
    </form>

 </div>
 <div class="edit" style="display:none">
 <h1 class="border p-3 my-3 text-center">修改「<span id="title"></span>」接駁車</h1>
    <form action="./api/edit_bus.php" method="post">
    <div class="row w-100">
        <label for="" class="col-2">已行駛時間(分鐘)</label>   
        <input  type="number" name="minute" id="editMminute" class='form-group form-control col-10'>
    </div>
    <div class="row w-100">
        <input  type="submit" value="修改" class='col-12 btn btn-success my-1'>
                                                                           <!-- 在按鈕標籤中直接觸發onclick事件，並在事件發生時執行：
                                                                                1.使用jquery來切換畫面上各區塊的顯示狀態 -->
        <input  type="button" value="回上頁" class='col-12 btn btn-secondary my-1' onclick="$('.list').show();$('.edit,.add').hide()">
    </div>
    </form>

 </div>


 <script>
    //前端編輯資料用的函式
    function edit(id){

        //使用getJSON向後端api get_bus.php發出取得資料的請求
        $.getJSON('./api/get_bus.php',{id},(bus)=>{
            //api 回傳的資料會是一個json格式的物件

            //將bus物件中的name資料寫入到頁面上id為title的tag中
            $("#title").html(bus.name);

            //將bus物件中的minute資料寫入到頁面上id為editMinute的input欄位的值
            $("#editMinute").val(bus.minute);
        })
    }
 </script>