<?php $all_lavel = $con->query("SELECT * FROM customer_level"); ?>


<div class="portlet-header portlet-header-bordered">
    <h3 class="portlet-title">กลุ่มลูกค้า</h3>
    <button onclick="addLavel()" class="btn btn-primary">เพิ่ม</button>
</div>

<div class="d-flex justify-content-end mt-3 me-3">
    <div class="d-flex gap-2">
        <button class="btn btn-danger py-0" onclick="showmange()">แสดงปุ่มลบ</button>
    </div>
</div>

<div class="portlet-body">
    <div class="table-responsive">
        <table id="cc-table" class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-start col-4">ชื่อระดับ</th>
                    <th class="cc-note col-4">หมายเหตุ</th>
                    <th class="text-end col-4">จัดการ</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($all_lavel as $row) : ?>
                    <tr>
                        <td class="text-start col-4"><?= $row['lv_level'] ?></td>
                        <td class="cc-note col-4"><?= $row['lv_note'] ?></td>
                        <td class="text-end col-4 ">
                            <button class="btn btn-warning py-0" onclick="editlavel(<?= $row['lv_id'] ?>)">แก้ไข</button>
                            <button class="btn btn-danger py-0 show-mange d-none" onclick="deletelavel(<?= $row['lv_id'] ?>)">ลบ</button>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    <!-- END Table -->
</div>


<!-- Modal-->
<div class="modal fade" id="ModalLavel" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="head-modal"></h5>
                <button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="lavel-id">
                <div class="row">
                    <div class="mb-3 col-12">
                        <label style="font-size: 10px">ชื่อระดับ</label>
                        <input id="lavel" class="form-control" type="text" required placeholder="ชื่อระดับ">
                    </div>

                    <div class="mb-3 col-12">
                        <label style="font-size: 10px">หมายเหตุ</label>
                        <input id="des" class="form-control" type="text" required placeholder="หมายเหตุ">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button id="reset" type="reset" class="btn btn-outline-danger">ล้าง</button>
                <button onclick="saveLavel()" type="button" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>




<script>
    function addLavel() {
        $('#head-modal').text('เพิ่มระดับ')
        $('#lavel').val('')
        $('#lavel-id').val('')
        $('#des').val('')
        $('#ModalLavel').modal('show')
    }

    function saveLavel() {
        let lavel = $('#lavel').val()
        let id = $('#lavel-id').val()
        let des = $('#des').val()
        let option = {
            url: 'controller/action.php',
            type: 'post',
            data: {
                lavel: lavel,
                des: des,
                id: id,
                addLavel: 1
            },
            success: function(res) {
                if (res == 1) {
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'บันทึกสำเร็จ',
                        showConfirmButton: false,
                        timer: 1200
                    })
                    setTimeout(() => {
                        location.reload()
                    }, 900)
                } else if (res == 2) {
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'อัพเดตสำเร็จ',
                        showConfirmButton: false,
                        timer: 1200
                    })
                    setTimeout(() => {
                        location.reload()
                    }, 900)
                } else {
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: 'บันทึกไม่สำเร็จ',
                        showConfirmButton: false,
                        timer: 1200
                    })
                    setTimeout(() => {
                        location.reload()
                    }, 900)
                }
            }
        }
        $.ajax(option)
    }

    function editlavel(id) {
        let option = {
            url: 'controller/action.php',
            type: 'post',
            dataType: 'json',
            data: {
                id: id,
                editLavel: 1
            },
            success(res) {
                $('#head-modal').text('แก้ไขระดับ')
                $('#lavel-id').val(res.lv_id)
                $('#lavel').val(res.lv_level)
                $('#des').val(res.lv_note)
                $('#ModalLavel').modal('show')
            }
        }
        $.ajax(option)
    }

    function deletelavel(id) {
        let option = {
            url: 'controller/action.php',
            type: 'post',
            data: {
                id: id,
                deleteLavel: 1
            },
            success: function(res) {
                Swal.fire({
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'ลบระดับสำเร็จ',
                    showConfirmButton: false,
                    timer: 1200
                })
                setTimeout(() => {
                    location.reload()
                }, 900)
            }
        }
        Swal.fire({
  title: 'ต้องการลบระดับ?',
  text: "",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'ตกลง',
  cancelButtonText: 'ยกเลิก',
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax(option)
  }
})

    }

    function showmange() {
        $('.show-mange').toggleClass('d-none')
    }
</script>