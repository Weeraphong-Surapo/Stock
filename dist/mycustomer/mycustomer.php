<?php 
    $customer = $con->query("SELECT * FROM tb_customer"); 
    $qty_cus = mysqli_num_rows($customer);
    $provinces = $con->query("SELECT * FROM provinces");
    $amphures = $con->query("SELECT * FROM amphures");
    $districts = $con->query("SELECT * FROM districts");
    $cus_group = $con->query("SELECT * FROM customer_group");
    $cus_gender = $con->query("SELECT * FROM customer_gender");
    $cus_level = $con->query("SELECT * FROM customer_level");
?>


<div class="portlet-header portlet-header-bordered">
    <h3 class="portlet-title">รายชื่อลูกค้า (<?=$qty_cus?> คน)</h3>
    <button id="btn-open-add" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal3">เพิ่ม</button>
</div>

<div class="ms-3 mt-3 d-flex gap-2">
    <input style="width: 200px;" type="text" placeholder="ค้นหา" id="search-table" class="form-control cc-input2" >
    <button class="btn btn-secondary" id="btn-reset">รีเฟรช</button>
</div>

<div class="d-flex justify-content-end me-3">
    <div class="d-flex gap-2">
        <button class="btn btn-danger py-0" id="cc-checkbox">แสดงปุ่มจัดการ</button>
    </div>
</div>

<div class="portlet-body">
    <div class="table-responsive">
        <table id="cc-table" class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <!-- <th>จังหวัด</th>
                    <th>อำเภอ</th>
                    <th>ตำบล</th> -->
                    <th>เบอร์โทร</th>
                    <th>วัน-เดือน-ปี เกิด</th>
                    <th>บัตรสมาชิก</th>
                    <th style="width: 150px;" class="cc-manage d-none">จัดการ</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                    $num = 0; 
                    foreach($customer as $cus): 
                        $num++; 
                        // $province = $con->query("SELECT * FROM provinces WHERE id = '$cus[cus_province]'");
                        // $pv = $province->fetch_array();

                        // $amphoe = $con->query("SELECT * FROM amphures WHERE id = '$cus[cus_amphoe]'");
                        // $amp = $amphoe->fetch_array();

                        // $tambon = $con->query("SELECT * FROM districts WHERE id = '$cus[cus_tambon]'");
                        // $tam = $tambon->fetch_array();
                ?>
                    <tr>
                        <td><?=$num?></td>
                        <td><?=$cus['cus_name']?></td>
                        <td><?=$cus['cus_lastname']?></td>
                        <!-- <td><?=$pv['name_th']?></td>
                        <td><?=$amp['name_th']?></td>
                        <td><?=$tam['name_th']?></td> -->
                        <td><?=$cus['cus_phone']?></td>
                        <td><?=$cus['cus_date']?></td>
                        <td>
                            <button class="btn btn-secondary py-0" style="width: 100px;"><?=$cus['cus_member_card']?></button>
                        </td>
                        <td style="width: 150px;" class="cc-manage d-none">
                            <button class="btn btn-info text-light py-0" onclick="showdata(<?=$cus['cus_id']?>)">ดู</button>
                            <button class="btn btn-warning py-0" data-bs-toggle="modal" onclick="updatecus(<?=$cus['cus_id']?>)">แก้ไข</button>
                            <button class="btn btn-danger py-0" onclick="swaldel(<?=$cus['cus_id']?>)">ลบ</button>
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
                    <input type="hidden" id="cus-id">
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">ชื่อ</label>
                            <input id="cus-name" class="form-control" type="text" placeholder="ชื่อ">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">นามสกุล</label>
                            <input id="cus-lastname" class="form-control" type="text" placeholder="นามสกุล">
                        </div>

                        <div class="mb-3 col-12">
                            <label style="font-size: 10px">ที่อยู่</label>
                            <textarea id="cus-address" class="form-control"></textarea>
                        </div>

                        <div class="mb-3 col-4">
                            <label style="font-size: 10px">จังหวัด</label>
                            <select id="cus-province" class="form-control">
                                <option hidden selected value="">เลือกจังหวัด</option>
                                <?php foreach($provinces as $pv): ?>
                                    <option value="<?=$pv['id']?>"><?=$pv['name_th']?></option>
                                <?php endforeach; ?>  
                            </select>
                        </div>

                        <div class="mb-3 col-4">
                            <label style="font-size: 10px">อำเภอ</label>
                            <select id="cus-amphoe" class="form-control">
                                <option id="opt-amphoe" hidden selected value="">เลือกอำเภอ</option>  
                            </select>
                        </div>

                        <div class="mb-3 col-4">
                            <label style="font-size: 10px">ตำบล</label>
                            <select id="cus-tambon" class="form-control">
                                <option id="opt-tambon" hidden selected value="">เลือกตำบล</option>
                            </select>
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">เบอร์โทร</label>
                            <input id="cus-phone" class="form-control" type="text" placeholder="เบอร์โทร">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">วัน-เดือน-ปี เกิด</label>
                            <input id="cus-date" class="form-control" type="date">
                        </div>

                        <div class="mb-3 col-12">
                            <label style="font-size: 10px">อีเมลล์</label>
                            <input id="cus-email" class="form-control" type="email" placeholder="อีเมลล์">
                        </div>

                        <div class="mb-3 col-4">
                            <label style="font-size: 10px">เพศ</label>
                            <select id="cus-gender" class="form-control">
                                <option hidden selected value="">เลือกเพศ</option>
                                <?php foreach($cus_gender as $gen): ?>
                                    <option value="<?=$gen['gen_id']?>"><?=$gen['gen_gender']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3 col-4">
                            <label style="font-size: 10px">กลุ่ม</label>
                            <select id="cus-group" class="form-control">
                                <option hidden selected value="">เลือกกลุ่ม</option>
                                <?php foreach($cus_group as $cg): ?>
                                    <option value="<?=$cg['cg_id']?>"><?=$cg['cg_name']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3 col-4">
                            <label style="font-size: 10px">ระดับ</label>
                            <select id="cus-level" class="form-control">
                                <option hidden selected value="">เลือกระดับ</option>
                                <?php foreach($cus_level as $lv): ?>
                                    <option value="<?=$lv['lv_id']?>"><?=$lv['lv_level']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3 col-12">
                            <label style="font-size: 10px">หมายเหตุ</label>
                            <input id="cus-note" class="form-control" type="text" placeholder="หมายเหตุ">
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button id="reset" type="reset" class="btn btn-outline-danger">ล้าง</button>
                <button id="btn-mycustomer" type="button" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>



<script>
    var name = ""
    var headname = ""

    $('#hide-amphoe').hide()
    // clear form
    $('#btn-open-add').click(() => {
        $('#opt-amphoe').text('')
        $('#opt-amphoe').val('')
        $('#opt-tambon').val('')
        $('#opt-tambon').text('')
        headname = "เพิ่มลูกค้า"
        $('#head-modal').text(headname)
        name = "addcus"
        document.getElementById("main-form").reset()
        $('#cus-address').text('')
        $('#cus-name').attr("disabled", false)
        $('#cus-lastname').attr("disabled", false)
        $('#cus-address').attr("disabled", false)
        $('#cus-province').attr("disabled", false)
        $('#cus-amphoe').attr("disabled", true)
        $('#cus-tambon').attr("disabled", true)
        $('#cus-phone').attr("disabled", false)
        $('#cus-date').attr("disabled", false)
        $('#cus-email').attr("disabled", false)
        $('#cus-gender').attr("disabled", false)
        $('#cus-group').attr("disabled", false)
        $('#cus-level').attr("disabled", false)
        $('#cus-note').attr("disabled", false)
        $('#btn-mycustomer').show()
        $('#reset').show()
    })

    // reset
    $('#reset').click(() => {
        document.getElementById("main-form").reset()
        $('#cus-address').text('')
    })

    // add customer
    $('#btn-mycustomer').click(e => {
        const data = new FormData();
        data.append('form_mycustomer', name)
        data.append('id', $('#cus-id').val())
        data.append('cus_name', $('#cus-name').val())
        data.append('cus_lastname', $('#cus-lastname').val())
        data.append('cus_address', $('#cus-address').val())
        data.append('cus_province', $('#cus-province').val())
        data.append('cus_amphoe', $('#cus-amphoe').val())
        data.append('cus_tambon', $('#cus-tambon').val())
        data.append('cus_phone', $('#cus-phone').val())
        data.append('cus_date', $('#cus-date').val())
        data.append('cus_email', $('#cus-email').val())
        data.append('cus_gender', $('#cus-gender').val())
        data.append('cus_group', $('#cus-group').val())
        data.append('cus_level', $('#cus-level').val())
        data.append('cus_note', $('#cus-note').val())

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


    // update
    function updatecus(id) {
        $('#opt-amphoe').text('')
        $('#opt-amphoe').val('')
        $('#opt-tambon').val('')
        $('#opt-tambon').text('')
        name = "updatecus"
        headname = "แก้ไขข้อมูลลูกค้า"
        $('#head-modal').text(headname)
        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            dataType:'json',
            data: {
                id: id,
                updatecus: 'getid'
            },
            success: (res) => {
                $('#cus-name').attr("disabled", false)
                $('#cus-lastname').attr("disabled", false)
                $('#cus-address').attr("disabled", false)
                $('#cus-province').attr("disabled", false)
                $('#cus-amphoe').attr("disabled", true)
                $('#cus-tambon').attr("disabled", true)
                $('#cus-phone').attr("disabled", false)
                $('#cus-date').attr("disabled", false)
                $('#cus-email').attr("disabled", false)
                $('#cus-gender').attr("disabled", false)
                $('#cus-group').attr("disabled", false)
                $('#cus-level').attr("disabled", false)
                $('#cus-note').attr("disabled", false)
                $('#cus-id').val(res.cus_id)
                $('#cus-name').val(res.cus_name)
                $('#cus-lastname').val(res.cus_lastname)
                $('#cus-address').text(res.cus_address)
                $('#cus-province').val(res.cus_province)
                getamphoe(res.cus_amphoe)
                gettambon(res.cus_tambon)
                $('#cus-phone').val(res.cus_phone)
                $('#cus-date').val(res.cus_date)
                $('#cus-email').val(res.cus_email)
                $('#cus-gender').val(res.cus_gender)
                $('#cus-group').val(res.cus_group)
                $('#cus-level').val(res.cus_level)
                $('#cus-note').val(res.cus_note)
                $('#btn-mycustomer').show()
                $('#reset').show()
                $('#modal3').modal('show')
            }
        });
    }

    // getamphoe
    const getamphoe = (id) => {
        $('#opt-amphoe').val('')
        $('#opt-amphoe').text('')
        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            dataType:'json',
            data: {
                id: id,
                getamphoe: 1
            },
            success: (res) => {
                $('#opt-amphoe').val(res.id)
                $('#opt-amphoe').text(res.name_th)
            }
        }) 
    }

    // gettambon
    const gettambon = (id) => {
        $('#opt-tambon').val('')
        $('#opt-tambon').text('')

        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            dataType:'json',
            data: {
                id: id,
                gettambon: 1
            },
            success: (res) => {
                $('#opt-tambon').val(res.id)
                $('#opt-tambon').text(res.name_th)
            }
        })
    }


    // delete productlist
    const delcus = (id) => {
        const data = new FormData()
        data.append('form_mycustomer', "deletecus")
        data.append('id', id)

        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: (res) => {
                swalsuccess()
                setTimeout(() => location.reload(), 1200)
            }
        })
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
                delcus(id)
            }
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


    // hidden manage button
    $('#cc-checkbox').click((e) => $('.cc-manage').toggleClass("d-none"))

    // select province
    $('#cus-province').change(function() {
        var id_province = $(this).val();

        $.ajax({
            type: "POST",
            url: "controller/action.php",
            data: {id:id_province,function:'provinces'},
            success: function(data){
                $('#cus-amphoe').html(data); 
            }
        });
    });

    $('#cus-amphoe').change(function() {
        var id_amphures = $(this).val();

        $.ajax({
            type: "POST",
            url: "controller/action.php",
            data: {id:id_amphures,function:'amphures'},
            success: function(data){
                $('#cus-tambon').html(data);  
            }
        });
    });


    // search
    $('#search-table').keyup(() => {
        search_table($('#search-table').val())
    })

    const search_table = (value) => {
        $('#cc-table tbody tr').each((index, element) => {
            var found = false
            $(element).find('td').each((index, td) => {
                if($(td).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) found = true
            })
            if(found) $(element).show()   
            else $(element).hide()
        })
    }
    $('#btn-reset').click(() => {
        $('#search-table').val('')
        search_table('')
    })

    // show data
    const  showdata = (id) => {
        headname = "ข้อมูลลูกค้า"
        $('#head-modal').text(headname)
        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            dataType:'json',
            data: {
                id: id,
                updatecus: 'getid'
            },
            success: (res) => {
                $('#cus-name').attr("disabled", true)
                $('#cus-lastname').attr("disabled", true)
                $('#cus-address').attr("disabled", true)
                $('#cus-province').attr("disabled", true)
                $('#cus-amphoe').attr("disabled", true)
                $('#cus-tambon').attr("disabled", true)
                $('#cus-phone').attr("disabled", true)
                $('#cus-date').attr("disabled", true)
                $('#cus-email').attr("disabled", true)
                $('#cus-gender').attr("disabled", true)
                $('#cus-group').attr("disabled", true)
                $('#cus-level').attr("disabled", true)
                $('#cus-note').attr("disabled", true)
                $('#cus-name').val(res.cus_name)
                $('#cus-lastname').val(res.cus_lastname)
                $('#cus-address').text(res.cus_address)
                $('#cus-province').val(res.cus_province)
                $('#cus-amphoe').val(res.cus_amphoe)
                $('#cus-tambon').val(res.cus_tambon)
                $('#cus-phone').val(res.cus_phone)
                $('#cus-date').val(res.cus_date)
                $('#cus-email').val(res.cus_email)
                $('#cus-gender').val(res.cus_gender)
                $('#cus-group').val(res.cus_group)
                $('#cus-level').val(res.cus_level)
                $('#cus-note').val(res.cus_note)
                $('#btn-mycustomer').hide()
                $('#reset').hide()
                $('#modal3').modal('show')
            }
        });
    }


    // disabled select
    $('#cus-province').change(() => {
        $('#cus-amphoe').attr("disabled", false)
    })
    $('#cus-amphoe').change(() => {
        $('#cus-tambon').attr("disabled", false)
    })


</script>



