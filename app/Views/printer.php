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

    <?php
        if ($status == false ) {
            echo $message;
        } else {
    ?>
    <!-- start ----------------------------------------------------------------------------------------------- -->
        <div class="ticket">
            <!-- header -->
            <div class="header">
                <img src="frontend/images/icon/logo-icon.png" width="30px" alt="Logo">
                <span class="centered">BABANA</span>
            </div>

            <!-- address -->
            <div class="address">
                <?= $billData['address'] ?>
            </div>

            <!-- table-order -->
            <div class="table-order">
                BÀN: <span class="fw-bolder fs-4"><?= $billData['table_order_name'] ?></span>
            </div>

            <!-- table-order -->
            <div id="detail">

                <div class="container text-start">
                    <div class="row">
                        <div class="col-4">
                            Thời gian:
                        </div>
                        <div class="col-8">
                            <?= $billData['date_check_out'] ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            T.Ngân:
                        </div>
                        <div class="col">
                            <?= $billData['cashier'] ?>
                        </div>
                        <div class="col">
                            Số bill:
                        </div>
                        <div class="col">
                            <?= $billData['bill_id_show'] ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            Khách hàng
                        </div>
                        <div class="col-8">
                            <?= $billData['customer'] ?>
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
                    <?php
                        $total = ($billData['total']>0) ? number_format($billData['total'], 0) : $billData['total'];
                        $money_received = ($billData['money_received']>0) ? number_format($billData['money_received'], 0) : $billData['money_received'];
                        $money_refund = ($billData['money_refund']>0) ? number_format($billData['money_refund'], 0) : $billData['money_refund'];
                        

                        if (!empty($detailData) ) {
                            $total_check = 0;
                            foreach ($detailData as $detail) {

                                $total_check += $detail['bill_detail_total'];
                                $count = ($detail['count']>0) ? number_format($detail['count'], 2) : $detail['count'];
                                $price = ($detail['price']>0) ? number_format($detail['price'], 0) : $detail['price'];
                                $bill_detail_total = ($detail['bill_detail_total']>0) ? number_format($detail['bill_detail_total'], 0) : $detail['bill_detail_total'];
                                echo '<tr>';
                                    echo '<td class="no">' . $detail['index'] . '</td>';
                                    echo '<td class="description" style="width: auto;">' . $detail['bill_detail_description'] . '</td>';
                                    echo '<td class="quantity">' . $count . '</td>';
                                    echo '<td class="price">' . $price . '</td>';
                                    echo '<td class="total-detail">' . $bill_detail_total . '</td>';
                                    
                                echo '</tr>';
                            }
                            
                            // check total
                            if ($total_check != $billData['total'] ) {
                                $total = 'Checking...';
                            }
                        }

                    ?>
                    

                    <tr>
                        <td class="no"></td>
                        <td class="description bill-total" colspan="3">Thanh toán:</td>
                        <!-- <td class="quantity"></td>
                        <td class="price"></td> -->
                        <td class="total-detail fw-bolder"><?= $total ?></td>
                    </tr>

                    <tr>
                        <td class="no"></td>
                        <td class="description bill-total" colspan="3">Tiền khách đưa:</td>
                        <!-- <td class="quantity"></td>
                        <td class="price"></td> -->
                        <td class="total-detail fw-bolder"><?= $money_received ?></td>
                    </tr>

                    <tr class="border-bottom border-success">
                        <td class="no"></td>
                        <td class="description give-back-cust" colspan="3">Tiền thừa:</td>
                        <!-- <td class="quantity"></td>
                        <td class="price"></td> -->
                        <td class="total-detail"><?= $money_refund ?></td>
                    </tr>



                </tbody>
            </table>
            <p class="centered">
                Liên hệ đặt hàng: <?= $billData['phone'] ?>
                <br>
                Theo dõi facebook để đón ưu đãi mới!
                <br>
                <img src="<?= base_url('frontend/images/Babana_fb_qrcode.png'); ?>" width="200px" alt="Babana Facebook">
                <br>
                Cám ơn Quý khách, hẹn gặp lại!

            </p>
        </div>
    <!-- end ----------------------------------------------------------------------------------------------- -->
    <?php
        }
    ?>

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