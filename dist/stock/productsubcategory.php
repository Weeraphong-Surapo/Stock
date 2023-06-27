<div class="portlet-header portlet-header-bordered">
    <h3 class="portlet-title">ประเภททั้งหมด</h3>
    <button class="btn btn-primary" onclick="openModal()">เพิ่มประเภท</button>
</div>
<div class="portlet-body">
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th width="10%">ลำดับ</th>
                    <th width="35%">หมวดหมู่</th>
                    <th width="35%">ประเภท</th>
                    <th width="20%">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $all_sub = $con->query("SELECT * FROM tb_sub_category");
                foreach ($all_sub as $row) :
                    $category = $con->query("SELECT * FROM tb_categorie WHERE cat_id = '$row[category_id]'");
                    $row_category = $category->fetch_array();
                ?>
                    <tr>
                        <th scope="row"><?= $i++ ?></th>
                        <td><?= $row_category['cat_name_categorie'] ?></td>
                        <td><?= $row['sub_name'] ?></td>
                        <td>
                            <button onclick="editSub(<?= $row['sub_id'] ?>)" class="btn btn-warning">แก้ไข</button>
                            <button onclick="deleteSub(<?= $row['sub_id'] ?>)" class="btn btn-danger">ลบ</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- END Table -->
</div>

<!-- BEGIN Modal -->
<div class="modal fade" id="ModalSubCategory" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="text-modal">เพิ่มประเภท</h5>
                <button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="">หมวดหมู่</label>
                        <select name="category" id="category" class="form-control">
                            <option value="" disabled selected>เลือกหมวดหมู่</option>
                            <?php
                            $all_category = $con->query("SELECT * FROM tb_categorie");
                            foreach ($all_category as $row) :
                            ?>
                                <option value="<?= $row['cat_id'] ?>"><?= $row['cat_name_categorie'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="">ชื่อประเภท</label>
                        <input class="form-control" placeholder="ระบุชื่อประเภท" id="subcategory" name="subcategory" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-danger">ปิด</a>
                    <button type="button" class="btn btn-primary" onclick="addsubcategory()">บันทึก</button>
                </div>
        </div>
    </div>
</div>
<!-- END Modal -->
</div>

<script>
    function editSub(id) {
        $('#text-modal').text('แก้ไขประเภท')
        let option = {
            url: 'controller/action.php',
            type: 'post',
            dataType: 'json',
            data: {
                id: id,
                editSub: 1
            },
            success: function(res) {
                $('#id').val(res.sub_id)
                $('#category').val(res.category_id)
                $('#subcategory').val(res.sub_name)
                $('#ModalSubCategory').modal('show')
            }
        }
        $.ajax(option)
    }

    function openModal() {
        $('#id').val('')
        $('#subcategory').val('');
        $('#category').val('');
        $('#text-modal').text('เพิ่มประเภท')
        $('#ModalSubCategory').modal('show')
    }

    function addsubcategory() {
        let id = $('#id').val()
        let subcategory = $('#subcategory').val();
        let category = $('#category').val();
        let option = {
            url: 'controller/action.php',
            type: "post",
            data: {
                category: category,
                subcategory: subcategory,
                id: id,
                addSub: 1
            },
            success: function(res) {
                if(res == 1){
                    Swal.fire(
                        'เพิ่มประเภทสำเร็จ',
                        '',
                        'success'
                    )
                    setTimeout(()=>{location.reload()},600)

                }else{
                    Swal.fire(
                        'อัพเดตประเภทสำเร็จ',
                        '',
                        'success'
                    )
                    setTimeout(()=>{location.reload()},600)
                }
            }
        }
        $.ajax(option)
    }

    function deleteSub(id) {
        let option = {
            url: "controller/action.php",
            type: 'post',
            data: {
                id: id,
                deleteSub: 1
            },
            success: function(res) {
                Swal.fire(
                    'ลบประเภทสำเร็จ',
                    '',
                    'success'
                )
                setTimeout(()=>{location.reload()},600)
            }
        }
        Swal.fire({
            title: 'ต้องการลบประเภท?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax(option)
            }
        })
    }
</script>