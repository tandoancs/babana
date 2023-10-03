<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Babana Printer</title>

    <link rel="stylesheet" href="frontend/css/printer.css">

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- google font Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <!-- google font Open+Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@500&display=swap" rel="stylesheet">
    <!-- google font Lato -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

</head>

<body>
    <div class="container">

        <div class="ticket">
            <!-- header -->
            <div class="header">
                <img src="frontend/images/icon/logo-icon.png" width="30px" alt="Logo">
                <span class="centered">BABANA</span>
            </div>

            <!-- address -->
            <div class="address">
                Dốc Quýt (đầu đường xuống Phước Hậu)
            </div>

            <!-- table-order -->
            <div class="table-order">
                BÀN: <span class="fw-bolder fs-4">01</span>
            </div>

            <!-- table-order -->
            <div id="detail">

                <div class="container text-start">
                    <div class="row">
                        <div class="col-4">
                            Thời gian:
                        </div>
                        <div class="col-8">
                            28-09-2023 13:45:12
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            T.Ngân:
                        </div>
                        <div class="col">
                            Admin
                        </div>
                        <div class="col">
                            Số bill:
                        </div>
                        <div class="col">
                            10000001234
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            Khách hàng
                        </div>
                        <div class="col-8">
                            Guest
                        </div>
                    </div>

                </div>
                
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th class="no">TT</th>
                        <th class="description">Tên món</th>
                        <th class="quantity">SL</th>
                        <th class="price">Đ.Giá</th>
                        <th class="total-detail">T.Tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="no">1</td>
                        <td class="description">Trà sữa truyền thống</td>
                        <td class="quantity">1.00</td>
                        <td class="price">15,000</td>
                        <td class="total-detail">15,000</td>
                    </tr>

                    <tr>
                        <td class="no">2</td>
                        <td class="description">Trà sữa Matcha</td>
                        <td class="quantity">1.00</td>
                        <td class="price">15,000</td>
                        <td class="total-detail">15,000</td>
                    </tr>

                    <tr>
                        <td class="no">3</td>
                        <td class="description">Sinh tố dưa hấu</td>
                        <td class="quantity">2.00</td>
                        <td class="price">15,000</td>
                        <td class="total-detail">30,000</td>
                    </tr>

                    <tr>
                        <td class="no">4</td>
                        <td class="description">Nước ép bưởi</td>
                        <td class="quantity">2.00</td>
                        <td class="price">20,000</td>
                        <td class="total-detail">40,000</td>
                    </tr>

                    <tr>
                        <td class="no"></td>
                        <td class="description bill-total" colspan="3">Thanh toán:</td>
                        <!-- <td class="quantity"></td>
                        <td class="price"></td> -->
                        <td class="total-detail fw-bolder">120,000</td>
                    </tr>

                    <tr>
                        <td class="no"></td>
                        <td class="description bill-total" colspan="3">Tiền khách đưa:</td>
                        <!-- <td class="quantity"></td>
                        <td class="price"></td> -->
                        <td class="total-detail fw-bolder">120,000</td>
                    </tr>

                    <tr class="border-bottom border-success">
                        <td class="no"></td>
                        <td class="description give-back-cust" colspan="3">Tiền thừa:</td>
                        <!-- <td class="quantity"></td>
                        <td class="price"></td> -->
                        <td class="total-detail">0</td>
                    </tr>



                </tbody>
            </table>
            <p class="centered">
                Liên hệ đặt hàng: 0986 486 602
                <br>
                Theo dõi facebook để đón ưu đãi mới!
                <br>
                <img src="<?= base_url('frontend/images/Babana_fb_qrcode.png'); ?>" width="200px" alt="Babana Facebook">
                <br>
                Cám ơn Quý khách, hẹn gặp lại!

            </p>
        </div>

    </div>



    <!-- <button id="btnPrint" class="hidden-print">Print</button> -->
    <script>
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.close();
            }, 100);
        }

        // const $btnPrint = document.querySelector("#btnPrint");
        // $btnPrint.addEventListener("click", () => {
        //     window.print();
        // });
    </script>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>