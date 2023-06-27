<?php $all_customer = $con->query("SELECT * FROM tb_customer"); ?>


<div class="portlet-header portlet-header-bordered">
    <h3 class="portlet-title">ประวัติการซื้อ</h3>
</div>

<div class="d-flex justify-content-end mt-3 me-3">
    <div class="d-flex gap-2">
        <!-- <button class="btn btn-danger py-0" onclick="showmange()">แสดงปุ่มลบ</button> -->
    </div>
</div>

<div class="portlet-body">
    <div class="table-responsive">
        <table id="cc-table" class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-start col-4">ชื่อลูกค้า</th>
                    <th class="text-end col-4">ดู</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($all_customer as $row) : ?>
                    <tr>
                        <td class="text-start col-4"><?= $row['cus_name']." ".$row['cus_lastname'] ?></td>
                        <td class="text-end col-4 ">
                            <a href="?p=storyByCustomer&id=<?= $row['cus_id']?>" class="btn btn-primary btn-sm">ดู</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    <!-- END Table -->
</div>
