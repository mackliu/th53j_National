<div class="list">
    <h1 class="border p-3 text-center my-3">表單設定 
        <button class="btn btn-success" onclick="$('.add').show();$('.list,.edit').hide()">新增</button>
    </h1>
    
</div>
<div class="add" style="display:none">
 <h1 class="border p-3 my-3 text-center">新增表單</h1>
    <form>
    <div class="row w-100">
        <input type="hidden" name="id" id="editId">
        <input  type="submit" value="修改" class='col-12 btn btn-success my-1'>
        <input  type="button" value="回上頁" class='col-12 btn btn-secondary my-1' onclick="$('.list').show();$('.edit,.add').hide()">
    </div>
    </form>

 </div>
