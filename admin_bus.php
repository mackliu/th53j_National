<h1 class="border p-3 text-center my-3">接駁車管理 <button class="btn btn-success">新增</button></h1>
<div class="list">
     <table class="table table-bordered text-center">
     <tr>
         <td class="col-4">車牌</td>
         <td class="col-4">已行駛時間</td>
         <td class="col-4">操作</td>
     </tr>
     <tr>
         <td>dfasfs</td>
         <td>dfasfasf</td>
         <td>
             <button class="btn btn-warning">編輯</button>
             <button class="btn btn-danger">刪除</button>
         </td>
     </tr>
     </table>
 </div>
 <div class="add">
 <h1 class="border p-3 my-3 text-center">新增接駁車</h1>
    <form action="./api/add_bus.php" method="post">

    <div class="row w-full">
        <label for="" class="col-2">車牌</label>   
        <input  type="text" name="name" id="name" class='form-group form-control col-10'>
    </div>
    <div class="row w-full">
        <label for="" class="col-2">已行駛時間(分鐘)</label>   
        <input  type="number" name="minute" id="minute" class='form-group form-control col-10'>
    </div>
    <div class="row w-full">
        <input  type="submit" value="新增" class='col-12 btn btn-success my-1'>
        <input  type="button" value="回上頁" class='col-12 btn btn-secondary my-1'>
    </div>
    </form>

 </div>
 <div class="edit">
 <h1 class="border p-3 my-3 text-center">修改「XXXX」接駁車</h1>
    <form action="./api/edit_bus.php" method="post">
    <div class="row w-full">
        <label for="" class="col-2">已行駛時間(分鐘)</label>   
        <input  type="number" name="minute" id="minute" class='form-group form-control col-10'>
    </div>
    <div class="row w-full">
        <input  type="submit" value="修改" class='col-12 btn btn-success my-1'>
        <input  type="button" value="回上頁" class='col-12 btn btn-secondary my-1'>
    </div>
    </form>

 </div>