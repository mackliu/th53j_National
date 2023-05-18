<div class="container p-3">
    <a href="?target=admin_bus" class="col-2 btn btn-light btn-lg active">接駁車管理</a>
    <a href="?target=admin_site" class="col-2 btn btn-light btn-lg">站點管理</a>
</div>
<div class="container">
    <h1 class="border p-3 text-center">
        接駁車管理
        <button class="btn btn-success" onclick="$('.list').hide();$('.add').show();$('.edit').hide()">新增</button>
    </h1>
    
    <div class="list">
        <table class="table table-bordered text-center">
            <tr class='table-primary'>
                <td class=' border-light'>車牌</td>
                <td class=' border-light'>已行駛時間</td>
                <td class=' border-light'>操作</td>
            </tr>
            <tr class='table-primary'>
                <td class=' border-light'>A1234</td>
                <td class=' border-light'>15</td>
                <td class=' border-light'>
                    <button class="btn btn-warning" onclick="$('.list').hide();$('.add').hide();$('.edit').show()">編輯</button>
                    <button class="btn btn-danger">刪除</button>
                </td>
            </tr>
        </table>
    </div>
    <div class="add" style="display:none">
        <h1 class="border text-center p-3">新增接駁車</h1>
        <form action="./api/add_bus.php">
            <div class="form-group row">
                <label for="" class="col-3 col-form-label">車牌</label>
                <input type="text" name='plate' class="form-control col-9">
            </div>
            <div class="form-group row">
                <label for="" class="col-3 col-form-label">已行駛時間(分鐘)</label>
                <input type="number" name='minute' class="form-control col-9">
            </div>
            <div class="form-group row">
                <input type="submit" class="col-12 my-1 btn btn-success" value="新增">
                <input type="button" class="col-12 my-1 btn btn-dark" value="回上頁">
            </div>
        </form>
    </div>
    <div class="edit" style="display:none">
        <h1 class="border text-center p-3">修改"XXXX"接駁車</h1>
        <form action="./api/edit_bus.php">
            <div class="form-group row">
                <label for="" class="col-3 col-form-label">車牌</label>
                <input type="text" name='plate' class="form-control col-9">
            </div>
            <div class="form-group row">
                <label for="" class="col-3 col-form-label">已行駛時間(分鐘)</label>
                <input type="number" name='minute' class="form-control col-9">
            </div>
            <div class="form-group row">
                <input type="hidden" name="id" value="1">
                <input type="submit" class="col-12 my-1 btn btn-success" value="修改">
                <input type="button" class="col-12 my-1 btn btn-dark" value="回上頁">
            </div>
        </form>
    </div>
</div>