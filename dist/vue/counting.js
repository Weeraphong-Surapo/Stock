var app = new Vue({
    el: '#counting',
    data: {
        path: "controller/SotckController.php",
        no: 1,
        Allcounting: [],
        showModal: false,
        status: "บันทึก",
        title: "เพิ่มหน่วยนับ",
        form: {
            id: "",
            counting: "",
            isEdit: false
        }
    },
    methods: {
        addCounting(e) {
            e.preventDefault();
            if (this.form.isEdit) {
                axios.post(this.path, {
                    counting: this.form.counting,
                    id:this.form.id,
                    action: "updateCounting"
                }).then((res) => {
                    this.AllCounting()
                    this.closeModal()
                    this.swalAlert('success', 'อัพเดตข้อมูลสำเร็จ')
                })
            } else {
                axios.post(this.path, {
                    counting: this.form.counting,
                    action: "addCounting"
                }).then((res) => {
                    this.AllCounting()
                    this.closeModal()
                    this.swalAlert('success', 'เพิ่มข้อมูลสำเร็จ')
                })
            }
        },
        editCounting(id) {
            this.title = "แก้ไขหน่วยนับ"
            axios.post(this.path, {
                id:id,
                action: "editCounting"
            }).then((res) => {
                this.form.counting = res.data.ctu_name
                this.form.id = res.data.ctu_id
                this.form.isEdit = true
                $('#ModalCounting').modal('show')
            })
        },
        deleteCounting(id) {
            Swal.fire({
                title: 'ต้องการลบหน่วยนับนี้?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
              }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(this.path,{
                        action:"deleteCounting",
                        id:id
                    }).then((res)=>{
                        this.AllCounting()
                        this.swalAlert('success', 'ลบข้อมูลสำเร็จ')
                    })
                }
              })
            
        },
        resetData() {
            this.form.isEdit = false
            this.form.counting = ""
            this.form.id = ""
        },
        swalAlert(type, title) {
            Swal.fire({
                position: 'bottom-end',
                icon: type,
                text: title,
                showConfirmButton: false,
                timer: 900
            })
        },
        AllCounting() {
            axios.post(this.path, {
                action: "getAllCounting"
            }).then((res) => { this.Allcounting = res.data })
        },
        openModal() {
            this.title = "เพิ่มหน่วยนับ"
            $('#ModalCounting').modal('show')
            this.resetData()
        },
        closeModal() {
            $('#ModalCounting').modal('hide')
        }
    },
    mounted() {
        this.AllCounting()
    },
})