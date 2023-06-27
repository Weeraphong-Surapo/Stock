const url = 'api/SaleDate.php';
var app = new Vue({
    el: '#salepic',
    data: {
        path: "controller/SalePicController.php",
        no: 1,
        status: "",
        showModal: false,
        AllProduct: [],
        arrayimg: [],
        cartProducts: [],
        AllCategory: [],
        AllSaleDay: [],
        logCart: [],
        AllCustomer: [],
        title: "เงินทอน",
        checkvat: false,
        itemCount: 0,
        vat: 7,
        error: "",
        check_find: 0,
        searchValue: "",
        searchCategory: "",
        custoemr: "",
        cus_id: "",
        getMoney: "",
        sp_id: "",
        changeMoneys: 0,
        totalVat: 0,
        totalsumVat: 0,
        currentPage: 1, // Current page number
        pageSize: 12, // Number of products to display per page
        form: {
            id: "",
            counting: "",
            isEdit: false
        }
    },
    methods: {
        swalAlert(type, title) {
            Swal.fire({
                position: 'bottom-end',
                icon: type,
                text: title,
                showConfirmButton: false,
                timer: 900
            })
        },
        additem(product) {
            this.cartProducts.push(
                {
                    "id": product.id,
                    "pl_product_id": product.pl_product_id,
                    "pl_name_product": product.pl_name_product,
                    "pl_selling_price": product.pl_price1,
                    "pl_discount": product.pl_discount,
                    "pl_cost": product.pl_cost,
                    "qty": 1,
                }
            );
        },
        removeProduct(item) {
            var index = this.cartProducts.indexOf(item);
            this.cartProducts.splice(index, 1);
        },
        Allproduct() {
            axios.post(this.path, {
                action: "getAllProduct"
            }).then((res) => {
                this.AllProduct = res.data
                for (let i = 0; i < this.AllProduct.length; i++) {
                    this.arrayimg.push('controller/img/' + this.AllProduct[i].pl_img);
                }
            })
        },
        openModal() {
            $('#ModalSale').modal('show')
        },
        closeModal() {
            $('#ModalSale').modal('hide')
        },
        findItem() {
            this.AllProduct.find(function (item) {
                if (item.pl_product_id === app.searchValue) {
                    app.cartProducts.push({
                        "id": item.id,
                        "pl_product_id": item.pl_product_id,
                        "pl_name_product": item.pl_name_product,
                        "pl_selling_price": item.pl_price1,
                        "pl_discount": item.pl_discount,
                        "pl_cost": item.pl_cost,
                        "qty": 1,
                    });
                    app.searchValue = ""
                    app.error = "เพิ่มสินค้าแล้ว"
                } else {
                    app.searchValue = ""
                }
            });
        },
        plusProduct(product) {
            this.cartProducts.find(function (item) {
                if (item.id === product.id) {
                    item.qty += 1
                }
            })
        },
        minusProduct(product) {
            var item = this.cartProducts.find(function (item) {
                return item.id === product.id;
            });

            if (item.qty > 1) {
                item.qty -= 1;
            } else {
                var index = this.cartProducts.indexOf(item);
                if (index !== -1) {
                    this.cartProducts.splice(index, 1);
                }
            }
        },
        addCartBarcode(e) {
            e.preventDefault();
            this.AllProduct.find(function (item) {
                if (item.pl_product_id == app.searchValue) {
                    let index = app.cartProducts.findIndex(product => product.pl_product_id == app.searchValue);

                    if (index !== -1) {
                        app.cartProducts[index].qty += 1;
                    } else {
                        app.cartProducts.push({
                            "id": item.id,
                            "pl_product_id": item.pl_product_id,
                            "pl_name_product": item.pl_name_product,
                            "pl_selling_price": item.pl_selling_price,
                            "pl_discount": item.pl_discount,
                            "pl_cost": item.pl_cost,
                            "qty": 1,
                        });
                    }

                    app.check_find += 1;
                } else {
                    app.check_find += 0;
                }
            });
            if (app.check_find == 0) {
                app.error = "ไม่พบสินค้า"
            } else {
                app.error = "เพิ่มสินค้าแล้ว"
                app.check_find = 0
            }
            app.searchValue = ""
        },
        chageMoney() {

            if (app.getMoney < app.totalPrice) {
                this.swalAlert('warning', 'กรุณารับเงินให้เท่ากับหรือมากกว่าราคาขาย')
            } else {
                if (app.checkvat) {
                    app.totalVat = app.totalPriceSumVat * app.vat / 100;
                    app.totalsumVat = app.totalPriceSumVat + app.totalVat
                } else {
                    app.totalVat = 0;
                    app.totalsumVat = app.totalPriceSumVat + app.totalVat
                }
                app.changeMoneys = app.getMoney - app.totalsumVat
                axios.post(this.path, {
                    action: "SaleProduct",
                    Cart: app.cartProducts,
                    Cus_id: app.cus_id,
                    vatproduct: app.totalVat,
                    totelPriceVat: app.totalsumVat,

                    getMo: app.getMoney
                }).then((res) => {
                    app.checkvat = false
                    this.openModal()
                    app.getAllSaleDay()
                    app.logCart = app.cartProducts
                    app.cartProducts = [];
                    app.sp_id = res.data.sp_id
                    this.addrow(res.data.id, res.data.code, res.data.name + ' ' + res.data.lastname, res.data.qty, res.data.total, res.data.vat, res.data.vat_total_price, res.data.getMoney, res.data.changeMoney, res.data.time)
                    app.getMoney = ""
                })
            };
        },
        swalAlert(type, title) {
            Swal.fire({
                position: 'top-right',
                icon: type,
                text: title,
                showConfirmButton: false,
                timer: 900
            })
        },
        getAllCategory() {
            axios.post(this.path, {
                action: "getAllCategory"
            }).then((res) => { this.AllCategory = res.data; })
        },
        getAllSaleDay() {
            axios.post(this.path, {
                action: "getAllSaleDay"
            }).then((res) => {
                this.AllSaleDay = res.data

            })
        },
        addrow(r1, r2, r3, r4, r5, r6, r7, r8, r9, r10) {
            this.dataTable.row.add([
                r1,
                r2,
                r3,
                r4,
                new Intl.NumberFormat().format(r5),
                new Intl.NumberFormat().format(r6),
                new Intl.NumberFormat().format(r7),
                new Intl.NumberFormat().format(r8),
                new Intl.NumberFormat().format(r9),
                r10,

            ]).draw(false)
        },
        pdf() {
            let sp_id = $('#sp_id').val();
            var pdfWindow = window.open('salepic/bill.php?p=' + sp_id, '');
            pdfWindow.onload = function () {
                pdfWindow.print();
            }
        },
        pdffull() {
            let sp_id = $('#sp_id').val();
            var pdfWindow = window.open('salepic/billfull.php?p=' + sp_id, '');
            pdfWindow.onload = function () {
                pdfWindow.print();
            }
        },
        showModalCustomer() {
            $('#ModalCustomer').modal('show')
        },
        getAllCustomer() {
            axios.post(this.path, {
                action: "getAllCustomer"
            }).then((res) => {
                app.AllCustomer = res.data
            })
        },
        selectCustomer(customer) {
            this.cus_id = customer.cus_id
            this.custoemr = customer;
            $('#ModalCustomer').modal('hide')
        },
        checkVat() {
            this.checkvat = !this.checkvat;
        }
    },
    computed: {
        totalPrice: function () {
            return this.cartProducts.reduce(function (sum, item) {
                return sum + item.pl_selling_price * item.qty;
            }, 0);
        },
        totalPriceSumVat: function () {
            return this.cartProducts.reduce(function (sum, item) {
                return sum + (item.pl_selling_price * item.qty);
            }, 0);
        },
        countCart: function () {
            return parseFloat(this.cartProducts.length);
        },
        filteredProducts() {
            if (!this.searchCategory) {
                return this.AllProduct;
            }
            const searchRegex = new RegExp(this.searchCategory, 'i');
            return this.AllProduct.filter((product) => searchRegex.test(product.c_id));
        },
        // Calculate the total number of pages
        totalPages() {
            return Math.ceil(this.filteredProducts.length / this.pageSize);
        },
        // Get the products to display on the current page
        currentPageProducts() {
            const startIndex = (this.currentPage - 1) * this.pageSize;
            const endIndex = startIndex + this.pageSize;
            return this.filteredProducts.slice(startIndex, endIndex);
        },
    },
    filters: {
        number: function (value) {
            return new Intl.NumberFormat().format(value);
        }
    },
    mounted() {
        this.getAllCategory()
        this.Allproduct()
        this.dataTable = $('#Sale-table').DataTable({});
        this.getAllCustomer()
        fetch(url)
            .then(res => res.json())
            .then(data => {
                data.forEach(item => {
                    this.AllSaleDay.push(item);
                });
                // this.dataTable.clear().draw(false);
                this.AllSaleDay.forEach(row => {
                    this.dataTable.row.add([
                        row.sp_id,
                        row.order_code,
                        row.customer,
                        row.sp_qty_sale,
                        new Intl.NumberFormat().format(row.sp_sell),
                        new Intl.NumberFormat().format(row.vat),
                        new Intl.NumberFormat().format(row.total_sum_vat),
                        new Intl.NumberFormat().format(row.get_money),
                        new Intl.NumberFormat().format(row.change_money),
                        row.sell_date
                    ]).draw(false)
                })

            });




    },
})
