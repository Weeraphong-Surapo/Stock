// const url = 'api/SaleList.php';
// new Vue({
//     el: '#salelist',
//     data: {
//         path: "controller/SaleListController.php",
//         AllsaleList: [],
//     },
//     methods: {
//         removeRow(index) {
//             this.myDataTable.splice(index, 1);
//         },
//         getAllSaleList() {
//             axios.post(this.path, {
//                 action: "getAllSaleList"
//             }).then((res) => { this.AllsaleList = res.data })
//         }
//     },
//     mounted() {
//         this.getAllSaleList()
//         this.dataTable = $('#myTable').DataTable({});
//         fetch(url)
//             .then(res => res.json())
//             .then(data => {
//                 data.forEach(item => {
//                     this.AllsaleList.push(item);
//                 });
//                 this.dataTable.clear().draw(false);

//                 this.AllsaleList.forEach(row => {
//                     this.dataTable.row.add([
//                         row.sp_id,
//                         row.order_code,
//                         row.sp_id,
//                         row.sp_qty_sale,
//                         row.sp_sell,
//                         row.vat,
//                         row.total_sum_vat,
//                         row.get_money,
//                         row.change_money,
//                         row.sell_date
//                     ]).draw(false)
//                 })

//             });
//     }
// });