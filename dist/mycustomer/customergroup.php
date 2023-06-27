<?php $group = $con->query("SELECT * FROM customer_group"); ?>


<div class="portlet-header portlet-header-bordered">
    <h3 class="portlet-title">กลุ่มลูกค้า</h3>
    <button id="btn-open-add" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal3">เพิ่ม</button>
</div>

<div class="d-flex justify-content-end mt-3 me-3">
    <div class="d-flex gap-2">
        <button class="btn btn-danger py-0" id="cc-checkbox">แสดงปุ่มจัดการ</button>
    </div>
</div>

<div class="portlet-body">
    <div class="table-responsive">
        <table id="cc-table" class="table table-striped table-hover mb-0">
            <thead >
                <tr>
                    <th class="text-start col-4">ชื่อกลุ่ม</th>
                    <th class="cc-note col-4">หมายเหตุ</th>
                    <th class="text-end col-4 cc-manage d-none">จัดการ</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($group as $group): ?>
                    <tr>
                        <td class="text-start col-4"><?=$group['cg_name']?></td>
                        <td class="cc-note col-4"><?=$group['cg_note']?></td>
                        <td class="text-end col-4 cc-manage d-none">
                            <button class="btn btn-warning py-0" data-bs-toggle="modal" onclick="updategroup(<?=$group['cg_id']?>)">แก้ไข</button>
                            <button class="btn btn-danger py-0" onclick="swaldel(<?=$group['cg_id']?>)">ลบ</button>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    <!-- END Table -->
</div>


<!-- Modal-->
<div class="modal fade" id="modal3" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="head-modal"></h5>
                <button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">

                <form id="main-form" enctype="multipart/form-data">
                    <input type="hidden" id="group-id">
                    <div class="row">
                        <div class="mb-3 col-12">
                            <label style="font-size: 10px">ชื่อกลุ่มลูกค้า</label>
                            <input id="group-name" class="form-control" type="text" placeholder="ชื่อกลุ่มลูกค้า">
                        </div>

                        <div class="mb-3 col-12">
                            <label style="font-size: 10px">หมายเหตุ</label>
                            <input id="group-note" class="form-control" type="text" placeholder="หมายเหตุ">
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button id="reset" type="reset" class="btn btn-outline-danger">ล้าง</button>
                <button id="btn-group" type="button" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>




<script>
    var name = ""
    var headname = ""

    $('#btn-open-add').click(() => {
        headname = "เพิ่มกลุ่มลูกค้า"
        name = "addgroup"
        $('#head-modal').text(headname)
        document.getElementById("main-form").reset()
    })

    // hidden manage button
    $('#cc-checkbox').click((e) => {
        $('.cc-manage').toggleClass("d-none")
        $('.cc-note').toggleClass("text-center")
    })

    // add customer group
    $('#btn-group').click(e => {
        const data = new FormData();
        data.append('form_group', name)
        data.append('id', $('#group-id').val())
        data.append('cg_name', $('#group-name').val())
        data.append('cg_note', $('#group-note').val())

        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: (res) => {
                $('#modal3').modal('hide')
                swalsuccess()
                setTimeout(() => location.reload(), 1200)
            }
        });
    })

    // sweet alert success
    const swalsuccess = () => {
        Swal.fire({
            position: 'bottom-end',
            icon: 'success',
            title: '',
            showConfirmButton: false,
            timer: 1200
        })
    }

    // update
    function updategroup(id) {
        name = "updategroup"
        headname = "แก้ไขกลุ่มลูกค้า"
        $('#head-modal').text(headname)
        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            dataType:'json',
            data: {
                id: id,
                updategroup: 1
            },
            success: (res) => {
                $('#group-id').val(res.cg_id)
                $('#group-name').val(res.cg_name)
                $('#group-note').val(res.cg_note)
                $('#modal3').modal('show')
            }
        });
    }

    // delete gender
    const del = (id) => {
        const data = new FormData();
        data.append('form_group', 'delgroup')
        data.append('id', id)

        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: (res) => {
                res == 1 ? swalsuccess() : swallerror()
                setTimeout(() => location.reload(), 1200)
            }
        });
    }

    // sweet alert delete
    const swaldel = (id) => {
        Swal.fire({
            text: "ต้องการลบหรือไม่",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'blue',
            cancelButtonColor: 'red',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                del(id)
            }
        })
    }

</script>