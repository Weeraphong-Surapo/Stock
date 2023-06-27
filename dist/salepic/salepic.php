<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    .main-cart {
        height: 400px;
    }

    .cc-box-cart {
        overflow-y: scroll;
        max-height: 300px;
        height: 100%;
    }

    .pagination {
        display: inline-block;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .pagination li {
        display: inline-block;
    }

    .pagination li a {
        color: #337ab7;
        padding: 5px 10px;
        border: 1px solid #ddd;
    }

    .pagination li.active a {
        background-color: #337ab7;
        color: white;
        border: 1px solid #337
    }
</style>
<div id="salepic">
    <input type="hidden" name="sp_id" id="sp_id" :value="sp_id">
    <div class="row">
     
        <div class="col-md-8 p-4">
            <div class="row">

                <div class="d-flex justify-content-lg-between mb-4">
                    <select class="form-control" v-model="searchCategory">
                        <option value="" selected>ทั้งหมด</option>
                        <option :value="category.cat_id" v-for="(category,index) in AllCategory" :key="index">{{ category.cat_name_categorie }}</option>
                    </select>
                    <input type="text" disabled id="cc-search" class="form-control" :value="custoemr != '' ? custoemr.cus_name + ' ' + custoemr.cus_lastname : 'ค้นหาลูกค้า'">
                    <button class="btn btn-primary" @click="showModalCustomer">ค้นหา</button>
                </div>
                <nav v-if="totalPages > 1">
                    <ul class="pagination">
                        <!-- <li :class="{ disabled: currentPage === 1 }">
                            <a @click.prevent="currentPage -= 1" href="#">Prev</a>
                        </li> -->
                        <li v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
                            <a @click.prevent="currentPage = page" href="#">{{ page }}</a>
                        </li>
                        <!-- <li v-if="currentPage === totalPages ? deisabled : ''">
                            <a @click.prevent="currentPage += 1" href="#">Next</a>
                        </li> -->
                    </ul>
                </nav>
                <div class="col-2 mb-3 cc-show" v-for="(product,index) in currentPageProducts" :key="index">
                    <div class="card card-body h-100" @click="additem(product)">
                        <img class="img-fluid" :src="arrayimg[index]" alt="">
                        <p class="cc-name">{{ product.pl_name_product }}</p>
                        <p>{{ new Intl.NumberFormat().format(product.pl_price1) }} บาท</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4 p-4 ">
            <form action="" method="post" @submit="addCartBarcode">
                <div class="d-flex">
                    <input type="text" v-model="searchValue" placeholder="รหัสสินค้า" autofocus class="form-control">
                    <button class="btn btn-success">ค้นหา</button>
                </div>
            </form>


            <div class="my-1"></div>
            <span>* <span class="text-danger">{{ error }}</span></span>
            <div class=" mb-2"></div>

            <div class="card card-body p-4 main-cart">
                <div class="cc-box-cart">
                    <table class="table table-bordered table-striped table-hover text-center ">
                        <thead>
                            <tr v-for="itemCart in cartProducts">
                                <td>
                                    <button class="btn" @click="minusProduct(itemCart)">-</button>
                                    <span>{{ itemCart.qty }}</span>
                                    <button class="btn" @click="plusProduct(itemCart)">+</button>
                                </td>
                                <td>{{ itemCart.pl_name_product }}</td>
                                <td>{{ new Intl.NumberFormat().format(itemCart.pl_selling_price * itemCart.qty) }}</td>
                                <td><button @click="removeProduct(itemCart)" class="btn btn-danger btn-xs">x</button></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4">{{ countCart }} ชิ้น รวม {{ new Intl.NumberFormat().format(totalPrice) }} บาท</td>
                            </tr>
                            <tr>
                                <td colspan="4"><input type="checkbox" @click="checkVat" class="float-end"></td>
                            </tr>
                            <div>
                                <tr v-if="checkvat">
                                    <td colspan="2">
                                        <div class="d-flex float-end">
                                            <span class="mt-2">vat</span>
                                            <button class="btn" @click="vat--" :disabled="vat <= 1">-</button>
                                            <input type="number" disabled :min="1" :value="vat" class="ms-3 form-control" style="width: 50px;">
                                            <button class="btn" @click="vat++">+</button>
                                            <span class="ms-3 mt-2">%</span>
                                        </div>
                                    </td>
                                    <td colspan="2">{{ new Intl.NumberFormat().format(totalPriceSumVat * vat / 100 ) }}</td>
                                </tr>
                                <tr v-if="checkvat">
                                    <td colspan="4">ราคารวม VAT {{ new Intl.NumberFormat().format(totalPrice + totalPriceSumVat * vat / 100 ) }}</td>
                                </tr>
                            </div>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div v-if="checkvat">
                    <h3 class="text-danger text-center">{{ totalPrice == 0 ? '' :  new Intl.NumberFormat().format(totalPrice + totalPriceSumVat * vat / 100 ) + ' บาท'}}</h3>
                </div>
                <div v-else>
                    <h3 class="text-danger text-center">{{ totalPrice == 0 ? '' :  new Intl.NumberFormat().format(totalPrice) + ' บาท'}}</h3>
                </div>
                <hr>
                <div class="d-flex">
                    <input id="inputmoney" v-model="getMoney" type="text" class="form-control me-2" placeholder="รับเงิน">
                    <button id="enter" class="btn btn-primary" style="min-width:120px;" @click="chageMoney">รับเงิน(Enter)</button>
                </div>
            </div>
        </div>

        <!-- BEGIN Modal -->
        <div class="modal fade" id="ModalSale" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ title }}</h5>
                        <button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <!-- <form action="" method="post" > -->
                    <div class="modal-body">
                        <h1 class="text-danger text-center" id="getchange">{{ changeMoneys }}</h1>
                        <div class="d-flex justify-content-center mt-2">
                            <button @click="closeModal" class="btn btn-secondary">ปิด</button>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button id="showbill" class="btn btn-outline-danger w-100" onclick="showBill()">ใบเสร็จอย่างย่อ</button>
                        <button type="button" onclick="printBillFull()" class="btn btn-primary w-100">ใบเสร็จฉบับบเต็ม</button>
                    </div>
                </div>
                <!-- </form> -->
            </div>
        </div>

        <!-- BEGIN Modal -->
        <div class="modal fade" id="ModalCustomer" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <!-- <form action="" method="post" > -->
                    <div class="modal-body">
                        <input type="text" name="" id="search-table" class="form-control">
                        <div class="my-2 d-flex ">
                            <button class="btn btn-success me-1 ms-1">ค้นหา</button>
                            <a href="?p=mycustomer" class="btn btn-secondary">เพิ่มลูกค้า</a>
                        </div>
                        <!-- {{custoemr}} -->
                        <div class="table-responsive">
                            <table id="table1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>เลือก</th>
                                        <th>รหัสสมาชิก</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>ที่อยู่</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(customer,index) in AllCustomer" :key="index">
                                        <td><button @click="selectCustomer(customer)" class="btn btn-success">เลือก</button></td>
                                        <td>{{ customer.code_customer }}</td>
                                        <td>{{ customer.cus_name }} {{ customer.cus_lastname }}</td>
                                        <td>{{ customer.cus_address }} {{ customer.cus_province }} {{ customer.cus_amphures }} {{ customer.cus_phone }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">

                    </div>
                </div>
                <!-- </form> -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- {{ AllSaleDay }} -->
            <div class="portlet p-3">
                <p>รายการขายวันนี้</p>
                <!-- {{ AllSaleDay }} -->
                <div class="table-responsive">
                    <table class="table table-bordered mt-3" id="Sale-table">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัสรายการ</th>
                                <th>ชื่อลูกค้า</th>
                                <th>จำนวนสินค้า</th>
                                <th>ราคาที่ซื้อรวม/บาท</th>
                                <th>vat/บาท</th>
                                <th>รวม vat/บาท</th>
                                <th>รับเงิน</th>
                                <th>ทอนเงิน</th>
                                <th>วันที่</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- END Modal -->


    <!-- BEGIN Modal -->
    <div class="modal fade modal-sm" id="smallbill">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-3">ใบเสร็จรับเงิน</h3>
                    <button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <!-- <h3 style="padding: 0; margin: 0; text-align: center;">PORNCHAI SERVICE</h3> -->
                        <h3 style="padding: 0; margin: 0; text-align: center;">xxxxxxxx xxxxxxx</h3>
                        <h6 style="padding: 0; margin: 0; text-align: center;">TAX:</h6>
                        <!-- <h6 style="padding: 0; margin: 0; text-align: center;">ราชบุรี</h6> -->
                        <h6 style="padding: 0; margin: 0; text-align: center;">xxxxx</h6>
                        <!-- <h6 style="padding: 0; margin: 0; text-align: center;">โทร: 090-526-6789 ช่างเอก</h6> -->
                        <h6 style="padding: 0; margin: 0; text-align: center;">xxxx xxxxxxxxxxxx xxxxxx</h6>
                        <h6 style="padding: 0; margin: 0; text-align: center;">----------------------------------</h6>
                        <h6 style="padding: 0; margin: 0; text-align: center;">ใบเสร็จรับเงิน/ใบกำกับภาษีอย่างย่อ</h6>
                        <h6 style="padding: 0; margin: 0; text-align: center;">(VAT Included)</h6>
                        <h6 style="padding: 0; margin: 0; text-align: center;">----------------------------------</h6>
                        <h6 style="padding: 0; margin: 0; text-align: center;">สินค้า/บริการ</h6>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <table style="width: 100%;">
                            <tr>
                                <td>1 SW 12 V/3A</td>
                                <td style="text-align: right;" id="price"></td>
                            </tr>

                            <tr>
                                <td>รวมเงิน</td>
                                <td style="text-align: right;" id="sum"></td>
                            </tr>

                            <tr>
                                <td>รับเงิน</td>
                                <td style="text-align: right;" id="get"></td>
                            </tr>

                            <tr>
                                <td>เงินทอน</td>
                                <td style="text-align: right;" id="change"></td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <h6 style="padding: 0; margin: 0; text-align: center;">----------------------------------</h6>
                        <h6 style="padding: 0; margin: 0; text-align: center;">พนักงานขาย: xxxxxxxxxxxxx</h6>
                        <h6 style="padding: 0; margin: 0; text-align: center;">
                            วันที่:<span id="date" class="ms-1"></span>
                        </h6> <br>
                        <h6 style="padding: 0; margin: 0; text-align: center;">----------------------------------</h6>
                    </div>

                </div>
                <div class="modal-footer">
                    <a @click="pdf()" href="#" class="btn btn-primary">ปริ้น</a>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN Modal -->
    <div class="modal fade modal-lg" id="ModalBillFull" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ใบเสร็จเต็ม</h5>
                    <button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                </div>



                <!-- <form action="" method="post" > -->
                <div class="modal-body" id="result_Bill_full">

                </div>
                <div class="modal-footer">
                    <a @click="pdffull()" href="#" class="btn btn-primary">ปริ้น</a>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
            <!-- </form> -->
        </div>
    </div>

</div>


<script src="vue/salepic.js"></script>



<script>

    // search
    $('#search-table').keyup(() => {
        search_table($('#search-table').val())
    })

    const search_table = (value) => {
        $('#table1 tbody tr').each((index, element) => {
            var found = false
            $(element).find('td').each((index, td) => {
                if($(td).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) found = true
            })
            if(found) $(element).show()   
            else $(element).hide()
        })
    }


    const pdf = (e) => {
        alert(e)
    }
    $('#cc-search').keyup((e) => {
        const show = document.querySelectorAll(".cc-show")
        if (e.target.value != '') {
            show.forEach(s => {
                if (s.textContent.toLocaleLowerCase().startsWith(` ${e.target.value}`)) {
                    s.classList.add("d-block")
                } else {
                    s.classList.add("d-none")
                }
            })
        } else {
            $('.cc-show').removeClass("d-none")
        }
    })

    // small bill
    let inputmoney = 0
    $('#enter').click(() => {
        inputmoney = $('#inputmoney').val()
        // $('#getchange').text(parseFloat($('#getchange').text()).toFixed(2))
    })

    $('#showbill').click(() => {
        $('#sum').text((inputmoney - $('#getchange').text()).toFixed(2))
        $('#price').text((inputmoney - $('#getchange').text()).toFixed(2))
        $('#get').text(`${(inputmoney % Math.floor(inputmoney)) == 0 ? `${inputmoney}.00` : inputmoney}`)
        changemoney()

        // current date
        let currentDate = new Date()
        let day = currentDate.getDate();
        let month = currentDate.getMonth() + 1;
        let year = currentDate.getFullYear();

        //  current time
        let hours = currentDate.getHours();
        let minutes = currentDate.getMinutes();
        let seconds = currentDate.getSeconds();
        let formattedDate = `${day < 10 ? '0' : ''}${day}/${month < 10 ? '0' : ''}${month}/${year} ${hours < 10 ? '0' : ''}${hours}:${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`
        $('#date').text(formattedDate)
    })
    const changemoney = () => $('#change').text(parseFloat($('#getchange').text()).toFixed(2))



    function showBill() {

        $('#smallbill').modal('show')
    }

    function printBillFull() {
        let sp_id = $('#sp_id').val();
        let option = {
            url: 'controller/action.php',
            type: 'post',
            data: {
                id: sp_id,
                billFull: 1
            },
            success: function(res) {
                $('#result_Bill_full').html(res)
                $('#ModalBillFull').modal('show')
            }
        }
        $.ajax(option)
    }
</script>