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
        $sql="select * from `bus`";
        $rows=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row){
     ?>
     <tr>
         <td><?=$row['name'];?></td>
         <td><?=mb_substr($row['minute'],-2);?>分鐘</td>
         <td>
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
        <input  type="number" name="minute" id="minute1" class='form-group form-control col-10'>
    </div>
    <div class="row w-100">
        <input  type="submit" value="新增" class='col-12 btn btn-success my-1'>
        <input  type="button" value="回上頁" class='col-12 btn btn-secondary my-1'  onclick="$('.list').show();$('.edit,.add').hide()">
    </div>
    </form>

 </div>
 <div class="edit" style="display:none">
 <h1 class="border p-3 my-3 text-center">修改「<span id="title"></span>」接駁車</h1>
    <form action="./api/edit_bus.php" method="post">
    <div class="row w-100">
        <label for="" class="col-2">已行駛時間(分鐘)</label>   
        <input  type="number" name="minute" id="minute2" class='form-group form-control col-10'>
    </div>
    <div class="row w-100">
        <input  type="submit" value="修改" class='col-12 btn btn-success my-1'>
        <input  type="button" value="回上頁" class='col-12 btn btn-secondary my-1' onclick="$('.list').show();$('.edit,.add').hide()">
    </div>
    </form>

 </div>


 <script>
    function edit(id){
        $.getJSON('./api/get_bus.php',{id},(bus)=>{
            console.log(bus)
            $("#title").html(bus.name);
            $("#minute2").val(bus.minute);
        })
    }
 </script>