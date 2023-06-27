
<style>
    .portlet{
        border: none !important;
    }
    .cc-main-menu{
        display: flex;
        justify-content: center;
        /* align-items: center; */
        width: 100%;
        height: 80vh;
    }
    .cc-block-center{
        width: 33%;
    }
    .cc-item{
        display: flex;
        justify-content: space-between;
        row-gap: 10px;
        flex-wrap: wrap;
    }
    .cc-menu{
        width: 49%;
        /* background: red; */
        background: #3498DB;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        border-radius: 6px;
        transition: 300ms ease;
    }
    .cc-bottom-menu{
        width: 150px;
        background: #ff7200;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0 auto;
        margin-top: 10px;
        padding-bottom: 10px;
        border-radius: 6px;
        transition: 300ms ease;
    }
    .cc-bottom-menu img{
        width: 70px;
    }
    .cc-bottom-menu:hover,
    .cc-menu:hover{
        transform: scale(1.02);
    }
    .cc-menu img{
        width: 70%;
    }
    .cc-menu span{
        font-size: 18px;
        color: #fff;
        margin-top: 10px;
    }
    .cc-head-stock{
        text-align: center;
        font-size: 28px;
        margin-bottom: 20px;
    }
    @media (max-width: 1159px) {
        .cc-block-center{
            width: 40%;
        }
    }
    @media (max-width: 969px) {
        .cc-block-center{
            width: 50%;
        }
    }
    @media (max-width: 785px) {
        .cc-block-center{
            width: 70%;
        }
    }
    @media (max-width: 570px) {
        .cc-item{
            display: block;
        }
        .cc-menu{
            width: 100%;
            margin-top: 20px;
        }
        .cc-main-menu{
            align-items: start;
            padding-bottom: 20px;
            height: auto !important;
        }
    }
</style>

<div class="cc-main-menu">
    <div class="cc-block-center">
        <h1 class="cc-head-stock">System stock</h1>
        <div class="cc-item">
            <a class="cc-menu" href="?p=salepic">
                <img src="assets/images/picture.png" alt="">
                <span>ขายจอแบบรูปภาพ</span>
            </a>

            <a class="cc-menu" href="?p=stock">
                <img src="assets/images/in-stock.png" alt="">
                <span>คลังสต๊อกสินค้า</span>
            </a>  
            
            <a class="cc-menu" href="?p=mycustomer">
                <img src="assets/images/customer-service-agent.png" alt="">
                <span>ลูกค้าและการติดต่อ</span>
            </a>
            
            <a class="cc-menu" href="?p=salelist">
                <img src="assets/images/to-do-list.png" alt="">
                <span>รายการขาย</span>
            </a>
        </div>
        <a class="cc-bottom-menu" href="?p=setting-coupon">
            <img src="assets/images/coupon.png" alt="">
            <span class="text-light">ตั่งค่าการขาย</span>
        </a>
    </div>
</div>