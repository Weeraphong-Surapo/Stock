<?php
$id = $_GET['id'];
$sql = "SELECT * FROM tb_sale_product WHERE customer_id ='$id'";
$query = $con->query($sql);
?>


<div class="portlet-header portlet-header-bordered">
    <h3 class="portlet-title">ประวัติการซื้อ</h3>
</div>

<div class=" mt-3 ms-3">
    <div class="d-flex gap-2">
        <button class="btn btn-danger py-0" onclick="history.back()">กลับ</button>
    </div>
</div>

<div class="portlet-body">
    <div class="table-responsive">
        <table id="cc-table" class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-start col-4">รหัสรายการ</th>
                    <th class="text-center col-4">วันที่สั่งซื้อ</th>
                    <th class="text-end col-4">ดูรายการ</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if($query->num_rows >=1 ):
                 foreach ($query as $row) :
                  ?>
                    <tr>
                        <td class="text-start col-4"><?= $row['order_code']; ?></td>
                        <td class="text-center col-4"><?= $row['sell_date']; ?></td>
                        <td class="text-end col-4 ">
                            <a href="#" onclick="ModalOrder(<?= $row['sp_id']; ?>)" class="btn btn-primary btn-sm">ดู</a>
                        </td>
                    </tr>
                <?php 
            endforeach;
        else:
            echo '<tr><td colspan="3" class="text-center">ยังไม่ประวัติการซื้อ</td></tr>';
        endif; 
            ?>

            </tbody>
        </table>
    </div>
    <!-- END Table -->
</div>


<!-- Modal-->
<div class="modal fade" id="ModalOrder" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="head-modal">รายการสินค้า</h5>
                <button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">

                <div id="result_order"></div>

            </div>

            <div class="modal-footer">
                <button onclick="$('#ModalOrder').modal('hide')" type="button" class="btn btn-primary">ปิด</button>
            </div>
        </div>
    </div>
</div>


<script>
    function ModalOrder(id) {
        let option = {
            url: "controller/action.php",
            type: 'post',
            data: {
                id: id,
                findOrder: 1
            },
            success: function(res) {
                $('#result_order').html(res)
                $('#ModalOrder').modal('show')
            }
        }
        $.ajax(option)
    }

    $(function() {})
</script>