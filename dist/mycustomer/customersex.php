<?php $gender = $con->query("SELECT * FROM customer_gender"); ?>


<div class="portlet-header portlet-header-bordered">
    <h3 class="portlet-title">เพศลูกค้า</h3>
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
                    <th class="text-start col-4">เพศ</th>
                    <th class="cc-note col-4">หมายเหตุ</th>
                    <th class="text-end col-4 cc-manage d-none">จัดการ</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($gender as $gender): ?>
                    <tr>
                        <td class="text-start col-4"><?=$gender['gen_gender']?></td>
                        <td class="cc-note col-4"><?=$gender['gen_note']?></td>
                        <td class="text-end col-4 cc-manage d-none">
                            <button class="btn btn-warning py-0" data-bs-toggle="modal" onclick="updategender(<?=$gender['gen_id']?>)">แก้ไข</button>
                            <button class="btn btn-danger py-0" onclick="swaldel(<?=$gender['gen_id']?>)">ลบ</button>
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
                    <input type="hidden" id="gender-id">
                    <div class="row">
                        <div class="mb-3 col-12">
                            <label style="font-size: 10px">เพศ</label>
                            <input id="gender" class="form-control" type="text" placeholder="เพศ">
                        </div>

                        <div class="mb-3 col-12">
                            <label style="font-size: 10px">หมายเหตุ</label>
                            <input id="note" class="form-control" type="text" placeholder="หมายเหตุ">
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button id="reset" type="reset" class="btn btn-outline-danger">ล้าง</button>
                <button id="btn-gender" type="button" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>




<script>
    var name = ""
    var headname = ""

    $('#btn-open-add').click(() => {
        headname = "เพิ่มเพศ"
        name = "addgender"
        $('#head-modal').text(headname)
        document.getElementById("main-form").reset()
    })

    // hidden manage button
    $('#cc-checkbox').click((e) => {
        $('.cc-manage').toggleClass("d-none")
        $('.cc-note').toggleClass("text-center")
    })

    // add customer group
    $('#btn-gender').click(e => {
        const data = new FormData();
        data.append('form_gender', name)
        data.append('id', $('#gender-id').val())
        data.append('gender', $('#gender').val())
        data.append('note', $('#note').val())

        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: (res) => {
                $('#modal3').modal('hide')
                res == 1 ? swalsuccess() : swallerror()
                setTimeout(() => location.reload(), 1200)
            }
        });
    })

    // sweet alert error
    const swalerror = () => {
        Swal.fire({
            position: 'bottom-end',
            icon: 'error',
            title: '',
            showConfirmButton: false,
            timer: 1200
        })
    }

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
    function updategender(id) {
        name = "updategender"
        headname = "แก้ไขเพศ"
        $('#head-modal').text(headname)
        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            dataType:'json',
            data: {
                id: id,
                updategender: 1
            },
            success: (res) => {
                $('#gender-id').val(res.gen_id)
                $('#gender').val(res.gen_gender)
                $('#note').val(res.gen_note)
                $('#modal3').modal('show')
            }
        });
    }

    // delete gender
    const del = (id) => {
        const data = new FormData();
        data.append('form_gender', 'delgen')
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