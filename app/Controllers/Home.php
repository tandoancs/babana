<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\BillModel;
use App\Models\BillDetailModel;
use App\Models\TableOrderModel;
use App\Models\AreaModel;
use App\Models\PromotionModel;
use App\Models\FoodModel;
use App\Models\SizeUnitModel;
use App\Models\FoodSizeModel;
use App\Models\CatalogModel;
use App\Models\SizeModel;
use App\Models\UnitModel;
use App\Models\TransModel;

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Writer\Csv;

class Home extends BaseController
{
    // public function __construct()
    // {
    //     // load helpers
    //     helper(['url', 'form', 'html', 'cookie']);

    //     // load library
    //     $validation =  \Config\Services::validation();
    //     // $cache = \Config\Services::cache();

    // }

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        helper(['url', 'form', 'html', 'cookie']);
        $validation =  \Config\Services::validation();
        // $cache = \Config\Services::cache();

        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function index()
    {
        return view('index');
    }

    public function load($done)
    {
        // init
        $data = array();

        $db = db_connect();
        $BillModel = new BillModel($db);
        $TableOrderModel = new TableOrderModel($db);
        $PromotionModel = new PromotionModel($db);
        $AreaModel = new AreaModel($db);

        // get data
        // $billData = $BillModel->readOptions(array('status <>' => 'Done'), 'bill_id');
        $billData = $BillModel->readOptionsIn('status', ['In-progress', 'Delivered'], 'date_check_in');
        if ($done == "done") {
            $billData = $BillModel->readOptionsIn('status', ['Done'], 'date_check_in');
        }

        foreach ($billData as $bill) {

            $bill_id = $bill->bill_id;
            $table_id = $bill->table_id;
            $promotion_id = $bill->promotion_id;

            $tableItem = !empty($table_id) ? $TableOrderModel->readItem(array('table_id' => $table_id)) : array();
            $promotionItem = !empty($promotion_id) ? $PromotionModel->readItem(array('promotion_id' => $bill->promotion_id)) : array();

            $area_id = isset($tableItem->area_id) ? $tableItem->area_id : '';
            $areaItem = !empty($area_id) ? $AreaModel->readItem(array('area_id' => $area_id)) : array();

            $status = isset($bill->status) ? $bill->status : '';
            $status = $this->getOrderStatus($status);

            $bill_note = $bill->note;

            // // update note data
            $note = $this->getOrderNote($bill_id, $bill_note);
            $note = str_replace("Trà sữa", "TS", $note);
            $note = str_replace("trà sữa", "ts", $note);
            $BillModel->edit(['bill_id' => $bill_id], ['note' => $note]);

            $data[] = array(
                'bill_id' => $bill_id,
                'area_name' => !empty($areaItem) ? $areaItem->area_id . "__" . $areaItem->area_name : '',
                'table_order_name' => !empty($tableItem) ? $tableItem->table_id . "__" . $tableItem->table_order_name : '',
                'date_check_in' => date('d-m-y H:i:s', strtotime($bill->date_check_in)),
                'sum_orders' => $bill->sum_orders,
                'total' => $bill->total,
                'status' => $status,

                // 'area_name' => '',
                'promotion_description' => !empty($promotionItem) ? $promotionItem->description : 'Không',
                'note' => $note,
                'printed' => $bill->printed,
                // 'detail' => '<button class="btn btn-info detail-btn">Xem</button>'
            );
        }

        // close db
        $db->close();

        // $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        return $data;
    }

    public function detailLoad()
    {
        $data = array();
        $detailData = array();
        $foodOptions = array();
        $sizeUnitOptions = array();


        $request = \Config\Services::request();
        if ($request->is('get')) {

            $bill_id = $this->request->getVar('bill_id');
            $done = $this->request->getVar('done');

            $db = db_connect();
            $BillDetailModel = new BillDetailModel($db);
            $FoodModel = new FoodModel($db);
            $SizeUnitModel = new SizeUnitModel($db);

            // get data
            $billDetailData = $BillDetailModel->readOptions(array('bill_id' => $bill_id), 'food_id');
            foreach ($billDetailData as $billDetail) {

                $price = $billDetail->price;
                $count = $billDetail->count;
                $food_id = $billDetail->food_id;
                $size_unit_code = $billDetail->size_unit_code;
                $detail_total = $price * $count;

                $foodItem = !empty($food_id) ? $FoodModel->readItem(array('food_id' => $food_id)) : array();
                $sizeUnitItem = !empty($size_unit_code) ? $SizeUnitModel->readItem(array('size_unit_code' => $size_unit_code)) : array();

                $detailData[] = array(
                    'bill_detail_id' => $billDetail->bill_detail_id,
                    'detail_food_name' => !empty($foodItem) ? ($foodItem->food_id . "__" . $foodItem->food_name) : '',
                    'detail_size_unit_code' => !empty($sizeUnitItem) ? $sizeUnitItem->size_unit_code . "__" . $sizeUnitItem->description : '',
                    'detail_count' => $billDetail->count,
                    'detail_price' => $price,
                    'detail_total' => $detail_total,
                    'detail_bill_id' => $billDetail->bill_id,


                    'detail_note' => $billDetail->note
                );
            }

            if ($done != "done") {
                for ($i = 0; $i < 9; $i++) {
                    $detailData[] = array(
                        'bill_detail_id' => "",
                        'detail_food_name' => "",
                        'detail_size_unit_code' => "1:M__Ly size M",
                        'detail_count' => "",
                        'detail_price' => "",
                        'detail_total' => "",
                        'detail_bill_id' => "",

                        'detail_note' => ""
                    );
                }
            }


            // close db
            $db->close();
        }

        $foodData = $FoodModel->readOptions(array('status' => 1), 'food_id');
        if (!empty($foodData)) {
            foreach ($foodData as $value) {
                $foodOptions[] = $value->food_id . "__" . $value->food_name;
            }
        }

        $sizeUnitData = $SizeUnitModel->readAll('size_unit_code');
        foreach ($sizeUnitData as $value) {
            $sizeUnitOptions[] = $value->size_unit_code . "__" . $value->description;
        }

        $data['detailData'] = $detailData;
        $data['foodOptions'] = $foodOptions;
        $data['sizeUnitOptions'] = $sizeUnitOptions;

        // $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function getOrderNote($bill_id, $bill_note)
    {
        $result = "";
        if (!empty($bill_note)) {
            $result = $bill_note;
        } else {

            // connect database and models
            $db = db_connect();
            $BillDetailModel = new BillDetailModel($db);
            $FoodModel = new FoodModel($db);

            // // get data
            $billDetailData = $BillDetailModel->readOptions(array('bill_id' => $bill_id), 'bill_detail_id');
            foreach ($billDetailData as $billDetail) {

                $note = $billDetail->note;
                $food_id = $billDetail->food_id;
                $foodItem = !empty($food_id) ? $FoodModel->readItem(array('food_id' => $food_id)) : array();
                $detail_food_description = !empty($foodItem) ? $foodItem->description : '';
                if (!empty($note)) {
                    $result .= ($detail_food_description . ": " . $note) . "; ";
                }
            }

            $db->close();
        }

        return $result;
    }

    public function getOptionsOfOrderGrid()
    {

        // get bill id
        $done = $this->request->getVar('done');

        // init
        $data = array();
        $tableOptions = array();
        $promotionOptions = array();
        $areaOptions = array();
        $foodOtions = array();

        $db = db_connect();
        $TableOrderModel = new TableOrderModel($db);
        $PromotionModel = new PromotionModel($db);
        $AreaModel = new AreaModel($db);
        $FoodModel = new FoodModel($db);

        $tableOrderData = $TableOrderModel->readAll('table_order_name', 'asc');
        if (!empty($tableOrderData)) {
            foreach ($tableOrderData as $value) {
                $tableOptions[] = $value->table_id . "__" . $value->table_order_name;
            }
        }

        $promotionData = $PromotionModel->readOptions(array('start_date <=' => date('Y-m-d H:i:s'), 'end_date >= ' => date('Y-m-d H:i:s')), 'updated_date');
        if (!empty($promotionData)) {
            foreach ($promotionData as $value) {
                $promotionOptions[] = $value->promotion_id . "__" . $value->description;
            }
        }

        $areaData = $AreaModel->readAll('area_name');
        if (!empty($areaData)) {
            foreach ($areaData as $value) {
                $areaOptions[] = $value->area_id . "__" . $value->area_name;
            }
        }

        $foodData = $FoodModel->readOptions(array('status' => 1), 'food_name');
        if (!empty($foodData)) {
            foreach ($foodData as $value) {
                $foodOtions[] = $value->food_id . "__" . $value->food_name;
            }
        }

        $data['dataset'] = $this->load($done);
        $data['tableOptions'] = $tableOptions;
        $data['promotionOptions'] = $promotionOptions;
        $data['areaOptions'] = $areaOptions;
        $data['foodOtions'] = $foodOtions;


        $db->close();

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function getOrderStatus($status, $reverse = 0)
    {
        if ($reverse == 0) {
            switch ($status) {
                case "Done":
                    $status = "Đã thanh toán";
                    break;
                case "Delivered":
                    $status = "Đã giao món";
                    break;
                case "In-progress":
                    $status = "Đang đợi";
                    break;
                case "Cancelled":
                    $status = "Hủy";
                    break;
                default:
                    $status = "Chưa xác định";
                    break;
            }
        } else {

            switch ($status) {
                case "Đã thanh toán":
                    $status = "Done";
                    break;
                case "Đã giao món":
                    $status = "Delivered";
                    break;
                case "Đang đợi":
                    $status = "In-progress";
                    break;
                case "Hủy":
                    $status = "Cancelled";
                    break;
                default:
                    $status = "Chưa xác định";
                    break;
            }
        }

        return $status;
    }

    /**
     * *************************************** Hàm lấy dữ liệu cho thêm mới đơn hàng  ********************************
     */
    public function getDataToAddForm()
    {
        // init
        $data = array();
        $tableOptions = array();
        $promotionOptions = array();
        $areaOptions = array();
        $sizeUnitOptions = array();
        $foodDataSet = array();

        // connect and model
        $db = db_connect();
        $TableOrderModel = new TableOrderModel($db);
        $PromotionModel = new PromotionModel($db);
        $AreaModel = new AreaModel($db);
        $FoodModel = new FoodModel($db);
        $SizeUnitModel = new SizeUnitModel($db);
        $FoodSizeModel = new FoodSizeModel($db);
        $BillModel = new BillModel($db);

        // lấy các bàn đã tồn tại trong Bill đang trạng thái In-progress để loại bỏ khỏi danh sách bàn hiển thị
        $billData = $BillModel->readOptionsIn('status', ['In-progress', 'Delivered']);
        $tableInOrders = [];
        foreach ($billData as $bill) {
            $tableInOrders[] = $bill->table_id;
        }

        $tableOrderData = $TableOrderModel->readAll('table_order_name', 'asc');
        if (!empty($tableOrderData)) {
            foreach ($tableOrderData as $value) {
                if (!in_array($value->table_id, $tableInOrders)) {
                    $tableOptions[] = [
                        'value' => $value->table_order_name,
                        'id' => $value->table_id
                    ];
                }
            }
        }

        $promotionData = $PromotionModel->readOptions(array('start_date <=' => date('Y-m-d H:i:s'), 'end_date >= ' => date('Y-m-d H:i:s')), 'updated_date');
        if (!empty($promotionData)) {
            foreach ($promotionData as $value) {
                $promotionOptions[] = [
                    'value' => $value->description,
                    'id' => $value->promotion_id
                ];
            }
        }

        $areaData = $AreaModel->readAll('area_name');
        if (!empty($areaData)) {
            foreach ($areaData as $value) {
                $areaOptions[] = [
                    'value' => $value->area_name,
                    'id' => $value->area_id
                ];
            }
        }

        $sizeUnitData = $SizeUnitModel->readAll('size_unit_code');
        foreach ($sizeUnitData as $value) {
            $sizeUnitOptions[] = $value->size_unit_code . "__" . $value->description;
        }

        $foodData = $FoodModel->readOptions(array('status' => 1), 'food_id');
        if (!empty($foodData)) {
            foreach ($foodData as $food) {

                $food_id = $food->food_id;
                $catalog_id = $food->catalog_id;
                $food_size_unit_code = $catalog_id == 1 ? '1:M__Ly size M' : '';
                $promotion_price = 0;
                $price = 0;
                if (!empty($food_size_unit_code)) {
                    $foodSizeItem = $FoodSizeModel->readItem(array('food_id' => $food_id, 'size_unit_code' => '1:M'));
                    $promotion_price = !empty($foodSizeItem) ? $foodSizeItem->promotion_price : 0;
                    $price = !empty($foodSizeItem) ? $foodSizeItem->price : 0;
                    if ($promotion_price > 0) {
                        $price = $promotion_price;
                    }
                }

                $foodDataSet[] = array(
                    'food_name' => $food->food_id . '__' . $food->food_name,
                    'food_size_unit_code' => $food_size_unit_code,
                    'food_price' => $price,
                    'food_count' => 1,
                    // 'food_total' => ($food->price * 1),
                    'food_note' => ''
                );
            }
        }

        $data['tableOptions'] = $tableOptions;
        $data['promotionOptions'] = $promotionOptions;
        $data['areaOptions'] = $areaOptions;
        $data['sizeUnitOptions'] = $sizeUnitOptions;

        $data['foodDataSet'] = $foodDataSet;

        $db->close();

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }


    // dữ liệu in hóa đơn
    public function printer()
    {
        // init
        $data = [];
        $billData = [];
        $detailData = [];
        $printed = 0;

        $status = false;
        $message = "Chưa lấy được thông tin đơn hàng để in";


        // get bill id
        $bill_id = $this->request->getVar('bill_id');


        // set bill data
        $billData['bill_id'] = $bill_id;
        $billData['bill_id_show'] = '100000' . $bill_id;
        $billData['cashier'] = 'Admin';
        $billData['customer'] = 'Guest';
        $billData['address'] = 'Dốc Quýt (đầu đường xuống Phước Hậu)';
        $billData['phone'] = '0986 486 602';

        // open connection and models
        $db = db_connect();
        $BillModel = new BillModel($db);
        $BillDetailModel = new BillDetailModel($db);
        $TableOrderModel = new TableOrderModel($db);

        // check 
        $where = ['bill_id' => $bill_id];
        if ($BillModel->isAlreadyExist($where) && $BillDetailModel->isAlreadyExist($where)) {
            $billItem = $BillModel->readItem($where);

            $printed = $billItem->printed;

            $table_id = $billItem->table_id;
            $table_order_name = '';
            if ($TableOrderModel->isAlreadyExist(['table_id' => $table_id])) {
                $tableItem = $TableOrderModel->readItem(['table_id' => $table_id]);
                $table_order_name = $tableItem->table_order_name;
            }

            // set bill data
            $billData['table_order_name'] = $table_order_name;
            $billData['date_check_out'] = date('d-m-Y H:i:s', strtotime($billItem->date_check_out));
            $billData['total'] = $billItem->total;
            $billData['money_received'] = $billItem->money_received;
            $billData['money_refund'] = $billItem->money_refund;


            // bill details
            $billDetailData = $BillDetailModel->readOptions($where);

            $index = 0;
            $total_check = 0;
            foreach ($billDetailData as $detail) {

                $index++;

                $bill_detail_total = $detail->bill_detail_total;
                $total_check += $bill_detail_total;

                $detailData[] = [
                    'index' => $index,
                    'bill_detail_description' => str_replace("Trà sữa", "TS", $detail->bill_detail_description),
                    'count' => $detail->count,
                    'price' => $detail->price,
                    'bill_detail_total' => $bill_detail_total
                ];
            }

            $status = true;
            $message = "Lấy thông tin đơn hàng để in thành công";

            if ($billData['total'] != $total_check) {
                $message = "Đơn hàng không đúng tổng số tiền, vui lòng kiểm tra lại";
                $status = false;
            }
        }

        $printed++;

        // update print
        $BillModel->edit($where, ['printed' => $printed]);

        return view('printer', ['status' => $status, 'message' => $message, 'billData' => $billData, 'detailData' => $detailData]);
    }

    public function getDetailDataToAdd()
    {
        // init
        $price = 0;

        $request = \Config\Services::request();
        if ($request->is('get')) {

            $detail_food_name = $this->request->getVar('detail_food_name');
            $detail_size_unit_code = $this->request->getVar('detail_size_unit_code');

            $food_id = (!empty($detail_food_name) && strpos($detail_food_name, "__") !== false) ? explode("__", $detail_food_name)[0] : 0;
            $size_unit_code = (!empty($detail_size_unit_code) && strpos($detail_size_unit_code, "__") !== false) ? explode("__", $detail_size_unit_code)[0] : 0;


            if (!empty($food_id) && !empty($size_unit_code)) {

                // connect and model
                $db = db_connect();
                $FoodSizeModel = new FoodSizeModel($db);

                $where = ['food_id' => $food_id, 'size_unit_code' => $size_unit_code];
                if ($FoodSizeModel->isAlreadyExist($where)) {
                    $foodSizeData = $FoodSizeModel->readItem($where);
                    if (!empty($foodSizeData)) {
                        $promotion_price = $foodSizeData->promotion_price;
                        $price = ($promotion_price > 0) ? $promotion_price : $foodSizeData->price;
                    }
                }

                $db->close();
            }
        }

        return json_encode(['price' => $price], JSON_UNESCAPED_UNICODE);
    }

    public function saveOrder()
    {
        $status = false;
        $message = 'Đơn hàng chưa lưu';

        // $data = '{"formData":{"table_order_name":"3","area_id":"1","promotion_description":"","count_orders":1,"total":"16,000","sum_orders":1},"gridData":[{"detail_food_name_add":"2__Trà+sữa+trân+châu+đường+đen","detail_size_unit":"1:M__Ly+size+M","detail_price_add":"16000","detail_count_add":1,"detail_total_add":16000,"detail_note_add":"","id":"u1696221244600"}]}';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $db = db_connect();
            $BillModel = new BillModel($db);
            $BillDetailModel = new BillDetailModel($db);
            $FoodSizeModel = new FoodSizeModel($db);

            /** -----------------------------------------------------------------------------------------
             * save thông tin chung đơn hàng
             */

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);
            // print_r($formData); exit();

            $formData = $data['formData'];
            $gridData = $data['gridData'];


            $table_id = $formData['table_order_name'];
            $promotion_id = $formData['promotion_description'];
            $count_orders = $formData['count_orders'];
            $total = (int)str_replace(",", "", $formData['total']);
            $sum_orders = $formData['sum_orders'];
            // save
            $formSave = array(
                'date_check_in' => date('Y-m-d H:i:s'),
                'count_orders' => $count_orders,
                'sum_orders' => $sum_orders,
                'total' => $total,
                'status' => 'In-progress',
                'table_id' => $table_id,
                'promotion_id' => $promotion_id
            );

            $result = $BillModel->create($formSave);
            if (!$result) {
                $message = 'Đơn hàng có lỗi khi lưu, vui lòng kiểm tra lại thông tin đơn hàng ';
            } else {

                // get bill id 
                $billItem = $BillModel->readLastItem();
                $bill_id = $billItem->bill_id;
                /** -----------------------------------------------------------------------------------------
                 * save chi tiết đơn hàng
                 */

                // $gridData = $this->request->getVar('gridData');
                foreach ($gridData as $item) {

                    $count = $item['detail_count_add'];
                    $price = $item['detail_price_add'];

                    $bill_detail_total = is_int($item['detail_total_add']) ? (int)$item['detail_total_add'] : 0;
                    $size_unit_code = (strpos($item['detail_size_unit'], "__") !== false) ? explode("__", $item['detail_size_unit'])[0] : "1:M";


                    $food_id = (strpos($item['detail_food_name_add'], "__") !== false) ? explode("__", $item['detail_food_name_add'])[0] : 0;
                    $food_id = (int)$food_id;
                    $note = $item['detail_note_add'];

                    // Cập nhật detail description để in bill, có dạng: TS truyền thống (Vừa), Trà sữa Matcha (Lớn)
                    // dữ liệu này lấy từ cột description trong bảng food_size
                    $foodSizeItem = $FoodSizeModel->readItem(['food_id' => $food_id, 'size_unit_code' => $size_unit_code]);
                    $bill_detail_description = !empty($foodSizeItem) ? $foodSizeItem->description : "";

                    // check data
                    if ($count == 0) {
                        $message = 'Số lượng của sản phẩm ' . $item['detail_food_name_add'] . ' bằng 0. Kiểm tra lại đơn hàng hoặc liên hệ Kỹ thuật';
                    } else if ($price == 0) {
                        $message = 'Giá của sản phẩm ' . $item['detail_food_name_add'] . ' bằng 0. Kiểm tra lại đơn hàng hoặc liên hệ Kỹ thuật';
                    } else if ($food_id == 0) {
                        $message = 'Mã của sản phẩm ' . $item['detail_food_name_add'] . ' bằng 0. Kiểm tra lại đơn hàng hoặc liên hệ Kỹ thuật';
                    } else if ($bill_detail_total == 0) {
                        $message = 'Tổng tiền của sản phẩm ' . $item['detail_food_name_add'] . ' bằng 0. Kiểm tra lại đơn hàng hoặc liên hệ Kỹ thuật';
                    } else if ($bill_detail_total == 0) {
                        $message = 'Tổng tiền của sản phẩm ' . $item['detail_food_name_add'] . ' bằng 0. Kiểm tra lại đơn hàng hoặc liên hệ Kỹ thuật';
                    } else {
                        $where = array('bill_id' => $bill_id, 'food_id' => $food_id);
                        $billDetailSave = array(
                            'count' => $count,
                            'price' => $price,
                            'status' => 1,
                            'bill_detail_total' => $bill_detail_total,
                            'size_unit_code' => $size_unit_code,
                            'bill_detail_description' => $bill_detail_description,
                            'bill_id' => $bill_id,
                            'food_id' => $food_id,
                            'note' => $note,

                        );

                        // Nếu mà sản phẩm đã có trong bill id thì: lấy sản phẩm đã có này cộng thêm sản phẩm chuẩn bị thêm vào hệ thống. 
                        // Sau đó xóa dữ liệu đã tồn tại này đi
                        // Rồi mới thêm vào trở lại
                        if ($BillDetailModel->isAlreadyExist($where)) {

                            // lấy dữ liệu tồn tại này
                            $billDetailItem = $BillDetailModel->readItem($where);
                            $count_new = $count + $billDetailItem->count;
                            $bill_detail_total_new =  $count_new * $price;

                            // xóa bỏ dữ liệu đã tồn tại
                            $BillDetailModel->del($where);

                            // cập nhật lại count và total của sản phẩm
                            $billDetailSave['count'] = $count_new;
                            $billDetailSave['bill_detail_total'] = $bill_detail_total_new;
                        }

                        // thêm dữ liệu vào hệ thống
                        $result = $BillDetailModel->create($billDetailSave);
                        if (!$result) {
                            // xóa bỏ dữ liệu đã lưu trước đó
                            $BillModel->del(array('bill_id' => $bill_id));
                            $BillDetailModel->del(array('bill_id' => $bill_id));

                            // return error message
                            $status = false;
                            $message = 'Đơn hàng có lỗi khi lưu sản phẩm ' . $item['food_name'] . ', vui lòng kiểm tra lại thông tin đơn hàng ';
                            break;
                        } else {
                            $status = true;
                            $message = 'Đơn hàng đã tạo thành công';
                        }
                    }
                }
            }

            $db->close();
        }

        // return view('save_order');
        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    // * *************************************** Lưu thông tin chung đơn hàng  ********************************
    public function saveMainOrder()
    {
        $status = false;
        $message = 'Đơn hàng chưa lưu';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            $db = db_connect();
            $BillModel = new BillModel($db);

            $bill_id = $data['bill_id'];

            $status = $this->getOrderStatus($data['status'], 1);
            $note = $data['note'];

            $saveData = [
                'date_check_out' => date('Y-m-d H:i:s'),
                'status' => $status,
                'money_received' => isset($data['money_received']) ? $data['money_received'] : 0,
                'money_refund' => isset($data['money_refund']) ? $data['money_refund'] : 0,
                'note' => $note
            ];

            $where = ['bill_id' => $bill_id];
            if ($BillModel->isAlreadyExist($where)) {
                $result = $BillModel->edit($where, $saveData);
                if (!$result) {
                    // return error message
                    $message = 'Có lỗi khi lưu dữ liệu đơn hàng';
                } else {
                    $status = true;
                    $message = 'Đơn hàng đã cập nhật thành công';
                }
            }

            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    // * *************************************** Lưu chi tiết đơn hàng  ********************************
    public function saveDetail()
    {
        $status = false;
        $message = 'Đơn hàng chưa lưu';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $BillModel = new BillModel($db);
            $BillDetailModel = new BillDetailModel($db);
            $FoodSizeModel = new FoodSizeModel($db);


            $count = count($data);

            $error_count = 0;
            foreach ($data as $key => $value) {

                // check 
                if (empty($value['detail_food_name']) || empty($value['detail_size_unit_code'])) {
                    if ($error_count <= 3) {
                        $error_count++;
                        continue;
                    } else {
                        break;
                    }
                }

                $count = $value['detail_count'];
                $price = $value['detail_price'];
                $bill_detail_total = $value['detail_total'];
                $size_unit_code = (!empty($value['detail_size_unit_code']) && strpos($value['detail_size_unit_code'], '__') !== false) ? explode('__', $value['detail_size_unit_code'])[0] : "1:M";


                $bill_id = $value['detail_bill_id'];
                $food_id = (!empty($value['detail_food_name']) && strpos($value['detail_food_name'], '__') !== false) ? explode('__', $value['detail_food_name'])[0] : 0;
                $note = $value['detail_note'];

                // Cập nhật detail description để in bill, có dạng: TS truyền thống (Vừa), Trà sữa Matcha (Lớn)
                // dữ liệu này lấy từ cột description trong bảng food_size
                $foodSizeItem = $FoodSizeModel->readItem(['food_id' => $food_id, 'size_unit_code' => $size_unit_code]);
                $bill_detail_description = !empty($foodSizeItem) ? $foodSizeItem->description : "";

                // cập nhật lại tổng đơn và ghi chú đơn
                // $bill_total += $bill_detail_total;
                // $bill_note .= !empty($note) ? ($note . "; ") : "";

                $saveData = [
                    'count' => $count,
                    'price' => $price,
                    'bill_detail_total' => $bill_detail_total,
                    'size_unit_code' => $size_unit_code,
                    'bill_detail_description' => $bill_detail_description,
                    'bill_id' => $bill_id,
                    'food_id' => $food_id,
                    'note' => $note
                ];

                $where = ['bill_id' => $bill_id, 'food_id' => $food_id];
                if ($BillDetailModel->isAlreadyExist($where)) {
                    $sub = "(Update)";
                    $result = $BillDetailModel->edit($where, $saveData);
                } else {
                    $sub = "(Insert)";
                    $result = $BillDetailModel->create($saveData);
                }

                if (!$result) {
                    // return error message
                    $status = false;
                    $message = 'Có lỗi khi lưu dữ liệu đơn hàng' . $sub;
                    break;
                } else {
                    $status = true;
                    $message = 'Đơn hàng đã cập nhật thành công';
                }
            }

            // close connection
            $db->close();

            // update lại tổng và các thông số khác cho bill
            $result = $this->billUpdateAuto($bill_id);
            if (!$result) {
                // return error message
                $status = false;
                $message = 'Có lỗi khi lưu dữ liệu đơn hàng (Bill)';
            }
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    public function deleteDetail()
    {
        $status = false;
        $message = 'Đơn hàng chưa lưu';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            if (!empty($data['bill_detail_id'])) {

                // open connection and models
                $db = db_connect();
                $BillDetailModel = new BillDetailModel($db);

                $bill_id = $data['detail_bill_id'];
                $bill_detail_id = $data['bill_detail_id'];

                if ($BillDetailModel->isAlreadyExist(['bill_detail_id' => $bill_detail_id])) {
                    $result = $BillDetailModel->del(['bill_detail_id' => $bill_detail_id]);
                    if (!$result) {
                        $status = false;
                        $message = 'Có lỗi khi xóa sản phẩm trong đơn hàng';
                    } else {
                        // update lại tổng và các thông số khác cho bill
                        $result = $this->billUpdateAuto($bill_id);
                        if (!$result) {
                            $message = 'Có lỗi khi xóa sản phẩm trong đơn hàng (Bill)';
                        } else {
                            $status = true;
                            $message = 'Sản phẩm đã xóa thành công';
                        }
                    }
                }

                // close connection
                $db->close();
            }
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    public function deleteMainOrder()
    {
        $status = false;
        $message = 'Đơn hàng chưa lưu';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            if (!empty($data['bill_id'])) {

                // open connection and models
                $db = db_connect();
                $BillModel = new BillModel($db);
                $BillDetailModel = new BillDetailModel($db);

                $where = ['bill_id' => $data['bill_id']];
                if ($BillModel->isAlreadyExist($where)) {
                    $result = $BillModel->del($where);
                    if (!$result) {
                        $status = false;
                        $message = 'Có lỗi khi xóa đơn hàng';
                    } else {
                        if ($BillDetailModel->isAlreadyExist($where)) {
                            $result = $BillDetailModel->del($where);
                            if (!$result) {
                                $status = false;
                                $message = 'Có lỗi khi xóa các sản phẩm của đơn hàng (Details)';
                            } else {
                                $status = true;
                                $message = 'Đơn hàng đã xóa thành công';
                            }
                        }
                    }
                }

                // close connection
                $db->close();
            }
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    public function getAreaId()
    {
        $area_id = '';
        $area_name = '';
        $status = false;
        $message = 'Không lấy được Khu vực của Bàn đã chọn';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            // get and set form data
            $table_id = $this->request->getVar('table_id');
            if (!empty($table_id)) {

                $db = db_connect();
                $TableOrderModel = new TableOrderModel($db);
                $AreaModel = new AreaModel($db);
                $BillModel = new BillModel($db);

                $tableItem = $TableOrderModel->readItem(array('table_id' => $table_id));

                // lấy các bàn có trạng thái Delivered và In-progress
                $tableList = [];
                $billData = $BillModel->readOptionsIn('status', ['Delivered', 'In-progress']);
                foreach ($billData as $bill) {
                    $tableList[] = $bill->table_id;
                }

                // check 
                if (in_array($table_id, $tableList)) {
                    $table_order_name = !empty($tableItem) ? $tableItem->table_order_name : '';
                    $message = "Bàn $table_order_name đã được đặt chổ";
                } else {

                    $area_id = !empty($tableItem) ? $tableItem->area_id : '';
                    $areaItem = $AreaModel->readItem(array('area_id' => $area_id));
                    $area_name = !empty($areaItem) ? $areaItem->area_name : '';
                    $status = true;
                }

                $db->close();
            }
        }

        return json_encode(['status' => $status, 'message' => $message, 'data' => ['area_id' => $area_id, 'area_name' => $area_name]], JSON_UNESCAPED_UNICODE);
    }

    public function getFoodPrice()
    {
        $price = 0;
        $promotion_price = 0;

        $request = \Config\Services::request();
        if ($request->is('post')) {

            // get and set form data
            $food_name = $this->request->getVar('food_name');
            $food_size_unit_code = $this->request->getVar('food_size_unit_code');
            if (!empty($food_name) && !empty($food_size_unit_code)) {
                $db = db_connect();
                $FoodSizeModel = new FoodSizeModel($db);

                $food_id = (strpos($food_name, "__") !== false) ? explode("__", $food_name)[0] : 0;
                $size_unit_code = (strpos($food_size_unit_code, "__") !== false) ? explode("__", $food_size_unit_code)[0] : 0;

                $foodSizeItem = $FoodSizeModel->readItem(array('food_id' => $food_id, 'size_unit_code' => $size_unit_code));
                if (!empty($foodSizeItem)) {
                    $promotion_price = $foodSizeItem->promotion_price;
                    $price = ($promotion_price > 0) ? $promotion_price : $foodSizeItem->price;
                }

                $db->close();
            }
        }

        return json_encode(array('price' => $price), JSON_UNESCAPED_UNICODE);
    }

    // Sử dụng để cập nhật lại các thông tin trong bảng bill khi các thông tin bill detail thay đổi
    public function billUpdateAuto($bill_id)
    {
        $result = false;

        $db = db_connect();
        $BillModel = new BillModel($db);
        $BillDetailModel = new BillDetailModel($db);

        $where = ['bill_id' => $bill_id];
        if ($BillDetailModel->isAlreadyExist($where)) {

            $detailData = $BillDetailModel->readOptions($where, 'bill_detail_id');
            $total = 0;
            $count_orders = count($detailData);
            $sum_orders = 0;
            $note = '';
            foreach ($detailData as $item) {
                $total += $item->bill_detail_total;
                $sum_orders += $item->count;
                if (!empty($item->note)) {
                    $note .= ($item->bill_detail_description . ": " . $item->note) . "; ";
                }
            }

            // update bill table
            $result = $BillModel->edit($where, ['total' => $total, 'count_orders' => $count_orders, 'sum_orders' => $sum_orders]);
        } else {
            // trường hợp này là không còn sản phẩm nào của đơn ==> xóa bỏ đơn này luôn
            $result = $BillModel->del($where);
        }

        $db->close();

        return $result;
    }

    /* ------------------------------------------------------------------------------------------------
        |
        | Master data
        |

    */

    // area --------------------------------------------------------------------------------------------------------------------
    public function area()
    {
        $data = [];
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $db = db_connect();
        $AreaModel = new AreaModel($db);

        $areaData = $AreaModel->readAll('area_id', 'asc');
        if (!empty($areaData)) {
            foreach ($areaData as $area) {
                $data[] = [
                    'area_id' => $area->area_id,
                    'area_name' => $area->area_name
                ];
            }
        }

        // thêm 5 dòng trống để User thêm area mới
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'area_id' => 'new',
                'area_name' => ''
            ];
        }

        $db->close();

        return json_encode(['status' => $status, 'message' => $message, 'data' => $data], JSON_UNESCAPED_UNICODE);
    }

    public function saveArea()
    {
        $result = false;
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $AreaModel = new AreaModel($db);

            $area_id = $data['area_id'];
            $area_name = $data['area_name'];

            if (empty($area_name)) {
                $message = 'Dữ liệu không được trống';
            } else {
                $saveData = [
                    'area_name' => $area_name
                ];

                if ($area_id != 'new') {
                    $where = ['area_id' => $area_id];
                    if ($AreaModel->isAlreadyExist($where)) {
                        $sub = "(Update)";
                        $result = $AreaModel->edit($where, $saveData);
                    }
                } else {
                    $sub = "(Insert)";
                    $result = $AreaModel->create($saveData);
                }


                if (!$result) {
                    $message = 'Có lỗi khi lưu dữ liệu' . $sub;
                } else {
                    $status = true;
                    $message = 'Cập nhật dữ liệu thành công';
                }
            }

            // close connection
            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    public function deleteArea()
    {
        $result = false;
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $AreaModel = new AreaModel($db);

            $area_id = $data['area_id'];

            if ($area_id == 'new') {
                $message = 'Dữ liệu không tồn tại trong hệ thống';
            } else {
                $where = ['area_id' => $area_id];
                if ($AreaModel->isAlreadyExist($where)) {
                    $result = $AreaModel->del($where);
                    if (!$result) {
                        $message = 'Có lỗi khi xóa dữ liệu';
                    } else {
                        $status = true;
                        $message = 'Xóa dữ liệu thành công';
                    }
                }
            }

            // close connection
            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    // table --------------------------------------------------------------------------------------------------------------------
    public function tableOrder()
    {
        $data = [];
        $areaOptions = [];
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $db = db_connect();
        $AreaModel = new AreaModel($db);
        $TableOrderModel = new TableOrderModel($db);

        $tableOrderData = $TableOrderModel->readAll('table_id', 'asc');
        if (!empty($tableOrderData)) {
            foreach ($tableOrderData as $item) {

                $area_id = $item->area_id;
                $where = ['area_id' => $area_id];
                $area_name = '';
                if ($AreaModel->isAlreadyExist($where)) {
                    $areaItem = $AreaModel->readItem($where);
                    $area_name = $areaItem->area_id . "__" . $areaItem->area_name;
                }
                $data[] = [
                    'table_id' => $item->table_id,
                    'table_order_name' => $item->table_order_name,
                    'area_name' => $area_name
                ];
            }
        }

        // thêm 5 dòng trống để User thêm area mới
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'table_id' => 'new',
                'table_order_name' => '',
                'area_name' => ''
            ];
        }

        // area all
        $areaData = $AreaModel->readAll('area_id', 'asc');
        foreach ($areaData as $value) {
            $areaOptions[] = $value->area_id . "__" . $value->area_name;
        }

        $db->close();

        return json_encode(['status' => $status, 'message' => $message, 'data' => $data, 'areaOptions' => $areaOptions], JSON_UNESCAPED_UNICODE);
    }

    public function saveTableOrder()
    {
        $result = false;
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $TableOrderModel = new TableOrderModel($db);

            $table_id = $data['table_id'];
            $table_order_name = $data['table_order_name'];
            $area_name = $data['area_name'];

            if (empty($table_order_name) || empty($area_name)) {
                $message = 'Dữ liệu không được trống';
            } else {

                $area_id = (strpos($area_name, '__') !== false) ? explode('__', $area_name)[0] : 0;
                $saveData = [
                    'table_order_name' => $table_order_name,
                    'area_id' => $area_id
                ];

                if ($table_id != 'new') {
                    $where = ['table_id' => $table_id];
                    if ($TableOrderModel->isAlreadyExist($where)) {
                        $sub = "(Update)";
                        $result = $TableOrderModel->edit($where, $saveData);
                    }
                } else {
                    $sub = "(Insert)";
                    $result = $TableOrderModel->create($saveData);
                }

                if (!$result) {
                    $message = 'Có lỗi khi lưu dữ liệu' . $sub;
                } else {
                    $status = true;
                    $message = 'Cập nhật dữ liệu thành công';
                }
            }

            // close connection
            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    public function deleteTableOrder()
    {
        $result = false;
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $TableOrderModel = new TableOrderModel($db);

            $table_id = $data['table_id'];

            if ($table_id == 'new') {
                $message = 'Dữ liệu không tồn tại trong hệ thống';
            } else {
                $where = ['table_id' => $table_id];
                if ($TableOrderModel->isAlreadyExist($where)) {
                    $result = $TableOrderModel->del($where);
                    if (!$result) {
                        $message = 'Có lỗi khi xóa dữ liệu';
                    } else {
                        $status = true;
                        $message = 'Xóa dữ liệu thành công';
                    }
                }
            }

            // close connection
            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    // food --------------------------------------------------------------------------------------------------------------------
    public function food()
    {
        $data = [];
        $catalogOptions = [];
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $db = db_connect();
        $FoodModel = new FoodModel($db);
        $CatalogModel = new CatalogModel($db);

        $result = $FoodModel->readAll('food_id', 'asc');
        if (!empty($result)) {
            foreach ($result as $item) {

                $where = ['catalog_id' => $item->catalog_id];
                $catalog_name = '';
                if ($CatalogModel->isAlreadyExist($where)) {
                    $catalogItem = $CatalogModel->readItem($where);
                    $catalog_name = $catalogItem->catalog_id . "__" . $catalogItem->catalog_name;
                }
                $data[] = [
                    'food_id' => $item->food_id,
                    'food_name' => $item->food_name,
                    'description' => $item->description,
                    'catalog' => $catalog_name
                ];
            }
        }

        // thêm 5 dòng trống để User thêm area mới
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'food_id' => 'new',
                'food_name' => '',
                'description' => '',
                'catalog' => ''
            ];
        }

        // area all
        $catalogData = $CatalogModel->readAll('catalog_id', 'asc');
        foreach ($catalogData as $value) {
            $catalogOptions[] = $value->catalog_id . "__" . $value->catalog_name;
        }

        $db->close();

        return json_encode(['status' => $status, 'message' => $message, 'data' => $data, 'catalogOptions' => $catalogOptions], JSON_UNESCAPED_UNICODE);
    }

    public function saveFood()
    {
        $result = false;
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $FoodModel = new FoodModel($db);

            $food_id = $data['food_id'];
            $food_name = $data['food_name'];
            $description = $data['description'];
            $catalog =  $data['catalog'];

            if (empty($food_name) || empty($description) || empty($catalog)) {
                $message = 'Dữ liệu không được trống';
            } else {

                $catalog_id = (strpos($catalog, '__') !== false) ? explode('__', $catalog)[0] : 0;
                $saveData = [
                    'food_name' => $food_name,
                    'description' => $description,
                    'catalog_id' => $catalog_id
                ];

                if ($food_id != 'new') {
                    $where = ['food_id' => $food_id];
                    if ($FoodModel->isAlreadyExist($where)) {
                        $sub = "(Update)";
                        $result = $FoodModel->edit($where, $saveData);
                    }
                } else {
                    $sub = "(Insert)";
                    $result = $FoodModel->create($saveData);
                }

                if (!$result) {
                    $message = 'Có lỗi khi lưu dữ liệu' . $sub;
                } else {
                    $status = true;
                    $message = 'Cập nhật dữ liệu thành công';
                }
            }

            // close connection
            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    public function deleteFood()
    {
        $result = false;
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $FoodModel = new FoodModel($db);

            $food_id = $data['food_id'];

            if ($food_id == 'new') {
                $message = 'Dữ liệu không tồn tại trong hệ thống';
            } else {
                $where = ['food_id' => $food_id];
                if ($FoodModel->isAlreadyExist($where)) {
                    $result = $FoodModel->del($where);
                    if (!$result) {
                        $message = 'Có lỗi khi xóa dữ liệu';
                    } else {
                        $status = true;
                        $message = 'Xóa dữ liệu thành công';
                    }
                }
            }

            // close connection
            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }


    // promotion --------------------------------------------------------------------------------------------------------------------
    public function promotion()
    {
        $data = [];
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $db = db_connect();
        $PromotionModel = new PromotionModel($db);

        $results = $PromotionModel->readAll('promotion_id', 'asc');
        if (!empty($results)) {
            foreach ($results as $item) {
                $data[] = [
                    'promotion_id' => $item->promotion_id,
                    'promotion_type' => $item->promotion_type,
                    'promotion_code' => $item->promotion_code,
                    'promotion_condition' => $item->promotion_condition,
                    'parameter' => $item->parameter,
                    'start_date' => date('d-m-Y H:i:s', strtotime($item->start_date)),
                    'end_date' => date('d-m-Y H:i:s', strtotime($item->start_date)),
                    'description' => $item->description,
                    'calculate_by' => $item->calculate_by,
                    'status' => ($item->status) ? 'Bật' : 'Tắt'
                ];
            }
        }

        // thêm 5 dòng trống để User thêm area mới
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'promotion_id' => 'new',
                'promotion_type' => '',
                'promotion_code' => '',
                'promotion_condition' => '',
                'parameter' => 0,
                'start_date' => '',
                'end_date' => '',
                'description' => '',
                'calculate_by' => '',
                'status' => ''
            ];
        }

        $db->close();

        $statusOptions[] = 'Bật';
        $statusOptions[] = 'Tắt';

        return json_encode(['status' => $status, 'message' => $message, 'data' => $data, 'statusOptions' => $statusOptions], JSON_UNESCAPED_UNICODE);
    }
    public function savePromotion()
    {
        $result = false;
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $PromotionModel = new PromotionModel($db);

            $promotion_id = $data['promotion_id'];
            $start_date = date('Y-m-d H:i:s', strtotime($data['start_date']));
            $end_date = date('Y-m-d H:i:s', strtotime($data['end_date']));

            $current = date('Y-m-d H:i:s');
            $promotion_status = ($current >= $start_date && $current <= $end_date) ? 'Bật' : 'Tắt';

            $promotion_status = $data['status'];
            if (!empty($promotion_status)) {
                $promotion_status = ($promotion_status == "Bật") ? 1 : 0;
            } else {
                $promotion_status = 1;
            }

            $saveData = [
                'promotion_type' => $data['promotion_type'],
                'promotion_code' => $data['promotion_code'],
                'promotion_condition' => $data['promotion_condition'],
                'parameter' => $data['parameter'],
                'start_date' => $start_date,
                'end_date' => $end_date,
                'description' => $data['description'],
                'calculate_by' => $data['calculate_by'],
                'status' => 1
            ];

            if ($promotion_id != 'new') {
                $where = ['promotion_id' => $promotion_id];
                if ($PromotionModel->isAlreadyExist($where)) {
                    $sub = "(Update)";
                    $result = $PromotionModel->edit($where, $saveData);
                }
            } else {
                $sub = "(Insert)";
                $result = $PromotionModel->create($saveData);
            }

            if (!$result) {
                $message = 'Có lỗi khi lưu dữ liệu' . $sub;
            } else {
                $status = true;
                $message = 'Cập nhật dữ liệu thành công';
            }

            // close connection
            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    public function deletePromotion()
    {
        $result = false;
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $PromotionModel = new PromotionModel($db);

            $promotion_id = $data['promotion_id'];
            if ($promotion_id == 'new') {
                $message = 'Dữ liệu không tồn tại trong hệ thống';
            } else {
                $where = ['promotion_id' => $promotion_id];
                if ($PromotionModel->isAlreadyExist($where)) {
                    $result = $PromotionModel->del($where);
                    if (!$result) {
                        $message = 'Có lỗi khi xóa dữ liệu';
                    } else {
                        $status = true;
                        $message = 'Xóa dữ liệu thành công';
                    }
                }
            }

            // close connection
            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }


    // promotion --------------------------------------------------------------------------------------------------------------------
    public function size()
    {
        $data = [];
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $db = db_connect();
        $SizeModel = new SizeModel($db);

        $results = $SizeModel->readAll('size', 'asc');
        if (!empty($results)) {
            foreach ($results as $item) {
                $data[] = [
                    'size' => $item->size,
                    'description' => $item->description
                ];
            }
        }

        // thêm 5 dòng trống để User thêm area mới
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'size' => '',
                'description' => ''
            ];
        }

        $db->close();

        return json_encode(['status' => $status, 'message' => $message, 'data' => $data], JSON_UNESCAPED_UNICODE);
    }

    public function saveSize()
    {
        $result = false;
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $SizeModel = new SizeModel($db);

            $size = $data['size'];
            $saveData = [
                'size' => $size,
                'description' => $data['description']
            ];

            if (!empty($size)) {
                $where = ['size' => $size];
                if ($SizeModel->isAlreadyExist($where)) {
                    $sub = "(Update)";
                    unset($saveData['size']);
                    $result = $SizeModel->edit($where, $saveData);
                } else {
                    $sub = "(Insert)";
                    $result = $SizeModel->create($saveData);
                }

                if (!$result) {
                    $message = 'Có lỗi khi lưu dữ liệu' . $sub;
                } else {
                    $status = true;
                    $message = 'Cập nhật dữ liệu thành công';
                }
            }

            // close connection
            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    public function deleteSize()
    {
        $result = false;
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $SizeModel = new SizeModel($db);

            $size = $data['size'];
            $where = ['size' => $size];
            if ($SizeModel->isAlreadyExist($where)) {
                $result = $SizeModel->del($where);
                if (!$result) {
                    $message = 'Có lỗi khi xóa dữ liệu';
                } else {
                    $status = true;
                    $message = 'Xóa dữ liệu thành công';
                }
            }

            // close connection
            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    // unit --------------------------------------------------------------------------------------------------------------------
    public function unit()
    {
        $data = [];
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $db = db_connect();
        $UnitModel = new UnitModel($db);

        $results = $UnitModel->readAll('unit_id', 'asc');
        if (!empty($results)) {
            foreach ($results as $item) {
                $data[] = [
                    'unit_id' => $item->unit_id,
                    'unit_name' => $item->unit_name,
                    'description' => $item->description
                ];
            }
        }

        // thêm 5 dòng trống để User thêm area mới
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'unit_id' => 'new',
                'unit_name' => '',
                'description' => ''
            ];
        }

        $db->close();

        return json_encode(['status' => $status, 'message' => $message, 'data' => $data], JSON_UNESCAPED_UNICODE);
    }

    public function saveUnit()
    {
        $result = false;
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $UnitModel = new UnitModel($db);

            $unit_id = $data['unit_id'];

            $saveData = [
                'unit_name' => $data['unit_name'],
                'description' => $data['description']
            ];

            if ($unit_id != 'new') {
                $where = ['unit_id' => $unit_id];
                if ($UnitModel->isAlreadyExist($where)) {
                    $sub = "(Update)";
                    $result = $UnitModel->edit($where, $saveData);
                }
            } else {
                $sub = "(Insert)";
                $result = $UnitModel->create($saveData);
            }

            if (!$result) {
                $message = 'Có lỗi khi lưu dữ liệu' . $sub;
            } else {
                $status = true;
                $message = 'Cập nhật dữ liệu thành công';
            }

            // close connection
            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    public function deleteUnit()
    {
        $result = false;
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $UnitModel = new UnitModel($db);

            $unit_id = $data['unit_id'];
            $where = ['unit_id' => $unit_id];
            if ($UnitModel->isAlreadyExist($where)) {
                $result = $UnitModel->del($where);
                if (!$result) {
                    $message = 'Có lỗi khi xóa dữ liệu';
                } else {
                    $status = true;
                    $message = 'Xóa dữ liệu thành công';
                }
            }

            // close connection
            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    // update size unit auto  --------------------------------------------------------------------------------------------------------------
    public function updateUnitSizeAuto()
    {
        $data = [];

        $db = db_connect();
        $SizeModel = new SizeModel($db);
        $UnitModel = new UnitModel($db);
        $SizeUnitModel = new SizeUnitModel($db);

        $sizeData = $SizeModel->readAll('size', 'asc');
        $unitData = $UnitModel->readAll('unit_id', 'asc');
        if (!empty($sizeData) && !empty($unitData)) {
            foreach ($sizeData as $sizeItem) {
                $size = $sizeItem->size;
                foreach ($unitData as $unitItem) {

                    $unit_id = $unitItem->unit_id;
                    $size_unit_code = $unit_id . ":" . $size;
                    $unit_name = $unitItem->unit_name;
                    $data = [
                        'size' => $size,
                        'unit_id' => $unit_id,
                        'size_unit_code' => $size_unit_code,
                        'description' => $unit_name . " size " . $size
                    ];

                    // save size unit tăble
                    $where = ['size_unit_code' => $size_unit_code];
                    if ($SizeUnitModel->isAlreadyExist($where)) {
                        unset($data['size_unit_code']);
                        $result = $SizeUnitModel->edit($where, $data);
                    } else {
                        $result = $SizeUnitModel->create($data);
                    }

                    if (!$result)
                        return false;
                }
            }
        }


        $db->close();

        return true;
    }

    // unit --------------------------------------------------------------------------------------------------------------------
    public function sizeUnit()
    {
        $data = [];
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $db = db_connect();
        $SizeUnitModel = new SizeUnitModel($db);
        $UnitModel = new UnitModel($db);

        // update auto size unit
        if ($this->updateUnitSizeAuto()) {
            $results = $SizeUnitModel->readAll('size_unit_code', 'asc');
            if (!empty($results)) {
                foreach ($results as $item) {

                    $unit_id = $item->unit_id;
                    $unitItem = $UnitModel->readItem(['unit_id' => $unit_id]);

                    $unit = !empty($unitItem) ? $unit_id . "__" . $unitItem->unit_name : '';
                    $data[] = [
                        'unit' => $unit,
                        'size' => $item->size,
                        'size_unit_code' => $item->size_unit_code,
                        'description' => $item->description
                    ];
                }
            }
        }



        $db->close();

        return json_encode(['status' => $status, 'message' => $message, 'data' => $data], JSON_UNESCAPED_UNICODE);
    }

    // unit --------------------------------------------------------------------------------------------------------------------
    public function transaction()
    {
        $data = [];
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';
        $transNameOptions = [];

        $db = db_connect();
        $TransModel = new TransModel($db);

        $results = $TransModel->readAll('trans_id', 'asc');
        if (!empty($results)) {
            foreach ($results as $item) {
                $data[] = [
                    'trans_id' => $item->trans_id,
                    'trans_type' => $item->trans_type,
                    'trans_name' => $item->trans_name,
                    'trans_form' => $item->trans_form,
                    'trans_money' => $item->money,
                    'status' => $item->status ? 'Xong' : 'Hủy',
                    'description' => $item->description
                ];
            }
        }

        // thêm 5 dòng trống để User thêm area mới
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'trans_id' => 'new',
                'trans_type' => '',
                'trans_name' => '',
                'trans_form' => '1__Tiền mặt',
                'trans_money' => '',
                'status' => 'Xong',
                'description' => ''
            ];
        }

        $db->close();

        // loại giao dịch
        $transTypeOptions[] = 'Thu';
        $transTypeOptions[] = 'Chi';

        // hình thức giao dịch
        $transFormOptions[] = '1__Tiền mặt';
        $transFormOptions[] = '2__Chuyển khoản';
        $transFormOptions[] = '3__Thanh toán Momo';

        // trạng thái
        $transStatusOptions[] = 'Xong';
        $transStatusOptions[] = 'Hủy';

        //  trans name options
        $transNameData = $TransModel->readDistince('trans_name', 'asc');
        foreach ($transNameData as $item) {
            $transNameOptions[] = $item->trans_name;
        }

        return json_encode(['status' => $status, 'message' => $message, 'data' => $data, 'transTypeOptions' => $transTypeOptions, 'transFormOptions' => $transFormOptions, 'transStatusOptions' => $transStatusOptions, 'transNameOptions' => $transNameOptions], JSON_UNESCAPED_UNICODE);
    }

    /// dang lam 20231008
    public function saveTransaction()
    {
        $result = false;
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $TransModel = new TransModel($db);

            $trans_id = $data['trans_id'];

            $saveData = [
                'trans_type' => $data['trans_type'],
                'trans_name' => $data['trans_name'],
                'trans_form' => $data['trans_form'],
                'money' => $data['trans_money'],
                'status' => $data['status'] == 'Xong' ? 1 : 0,
                'description' => $data['description']
            ];

            if ($trans_id != 'new') {
                $where = ['trans_id' => $trans_id];
                if ($TransModel->isAlreadyExist($where)) {
                    $sub = "(Update)";
                    $result = $TransModel->edit($where, $saveData);
                }
            } else {
                $sub = "(Insert)";
                $result = $TransModel->create($saveData);
            }

            if (!$result) {
                $message = 'Có lỗi khi lưu dữ liệu' . $sub;
            } else {
                $status = true;
                $message = 'Cập nhật dữ liệu thành công';
            }

            // close connection
            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    public function deleteTransaction()
    {
        $result = false;
        $status = false;
        $message = 'Chưa lấy được thông tin xử lý';

        $request = \Config\Services::request();
        if ($request->is('post')) {

            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            // open connection and models
            $db = db_connect();
            $TransModel = new TransModel($db);

            $trans_id = $data['trans_id'];
            $where = ['trans_id' => $trans_id];
            if ($TransModel->isAlreadyExist($where)) {
                $result = $TransModel->del($where);
                if (!$result) {
                    $message = 'Có lỗi khi xóa dữ liệu';
                } else {
                    $status = true;
                    $message = 'Xóa dữ liệu thành công';
                }
            }

            // close connection
            $db->close();
        }

        return json_encode(array('status' => $status, 'message' => $message), JSON_UNESCAPED_UNICODE);
    }

    public function getDateToReports($type, $from_date, $to_date)
    {

        $current_date = date("Y-m-d");
        $to_date = date("Y-m-d H:i:s");

        $month_31 = ['1', '3', '5', '7', '8', '10', '12'];

        if ($type == 'daily') {
            $from_date = $current_date;
        } else if ($type == 'weekly') {
            $from_date = date("Y-m-d", strtotime(date('Y-m-d H:i:s') . "-7 days"));
        } else if ($type == 'monthly') {
            $date_count = 30;
            $month = date('m');
            if ($month == '2') {
                $date_count = ((int)date('Y') / 4 == 0) ? 29 : 28;
            } else if (in_array($month, $month_31)) {
                $date_count = 31;
            }

            $from_date = date("Y-m-d", strtotime(date('Y-m-d H:i:s') . "- $date_count days"));
        } else if ($type == 'yearly') {
            $from_date = date('Y') . '-01-01 00:00:00';
        }
        //  else if ($type == 'search-distance') {

        // }

        $from_date .= ' 00:00:00';

        return ['from_date' => $from_date, 'to_date' => $to_date];
    }

    public function reports()
    {
        $status = true;
        $message = "OK";
        $html = '';

        // open connection and models
        $db = db_connect();
        $BillModel = new BillModel($db);
        $BillDetailModel = new BillDetailModel($db);
        $TransModel = new TransModel($db);
        $FoodModel = new FoodModel($db);

        $data = [];
        $request = \Config\Services::request();
        if ($request->is('post')) {
            $data = $this->request->getVar('data');
            $data = json_decode($data, true);

            $type = $data['type'];
            $from_date = ($data['from_date'] == null) ? (date('Y-m-d') . ' 00:00:00') : (date("Y-m-d", strtotime($data['from_date'])) . ' 00:00:00');
            $to_date = ($data['to_date'] == null)  ? date("Y-m-d H:i:s") : date("Y-m-d H:i:s", strtotime($data['to_date']));

            // echo "<br>\n from_date: $from_date -- to_date: $to_date";

            $date_from_to = $this->getDateToReports($type, $from_date, $to_date);
            $from_date = $date_from_to['from_date'];
            $to_date = $date_from_to['to_date'];

            // echo "<br>\n from_date: $from_date -- to_date: $to_date";
            // // test
            // $from_date = date("Y-m-d H:i:s", strtotime('2023-10-01 10:00:00'));

            // lượng khách hàng, sản phẩm bán, dư có, doanh thu ----------------------------------------------------------------
            $count_customer = 0;
            $food_sum = 0;
            $total_in_bill = 0;

            $where = ['status' => 'Done', 'date_check_out >= ' => $from_date, 'date_check_out <= ' => $to_date];
            if ($BillModel->isAlreadyExist($where)) {

                $billData = $BillModel->readOptions($where);

                // số lượng khách hàng trong khoảng thời gian đã chọn
                $count_customer = $BillModel->countOptions('bill_id', $where);

                // số sản phẩm đã bán trong khoảng thời gian đã chọn
                $food_sum = $BillModel->sumOptions('sum_orders', $where);

                // tổng doanh thu trong hóa đơn trong khoảng thời gian đã chọn
                $total_in_bill = $BillModel->sumOptions('total', $where);
            }

            // lấy dữ liệu từ trans (các giao dịch ngoài hóa đơn)
            // tổng Thu trong các giao dịch ngoài hóa đơn
            $where = ['trans_type' => 'Thu', 'status' => 1, 'trans_date >= ' => $from_date, 'trans_date <= ' => $to_date];
            $total_trans_income = ($TransModel->isAlreadyExist($where)) ? $TransModel->sumOptions('money', $where) : 0;

            // tổng Chi trong các giao dịch ngoài hóa đơn
            $where = ['trans_type' => 'Chi', 'status' => 1, 'trans_date >= ' => $from_date, 'trans_date <= ' => $to_date];
            $total_trans_spend = ($TransModel->isAlreadyExist($where)) ? $TransModel->sumOptions('money', $where) : 0;

            // tổng doanh thu
            $total = $total_in_bill + $total_trans_income;

            // tổng dư có là số tiền còn lại của doanh thu trừ đi chi tiêu
            $total_temporary_profit = $total - $total_trans_spend;

            // show 
            $count_customer_show = number_format($count_customer);
            $food_sum_show = number_format($food_sum);
            $total_show = number_format($total);
            $total_temporary_profit_show = number_format($total_temporary_profit);



            $html = '
                <div class="row m-t-25">
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c1">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-account-o"></i>
                                    </div>
                                    <div class="text">
                                        <h2>' . $count_customer_show . '</h2>
                                        <span>Lượt khách hàng</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c2">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-shopping-cart"></i>
                                    </div>
                                    <div class="text">
                                        <h2>' . $food_sum_show . '</h2>
                                        <span>Sản phẩm đã bán</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c3">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-flower"></i>
                                    </div>
                                    <div class="text">
                                        <h2>' . $total_temporary_profit_show . '</h2>
                                        <span>Dư có</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart3"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c4">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-money"></i>
                                    </div>
                                    <div class="text">
                                        <h2>' . $total_show . '</h2>
                                        <span>Doanh thu</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart4"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';


            // treemap ----------------------------------------------------------------
            $treeMapData = [];

            if (!empty($billData)) {
                $bill_id_list = [];
                $food_id_list = [];
                foreach ($billData as $bill) {
                    $bill_id_list[] = $bill->bill_id;

                    $billDetailData = $BillDetailModel->readOptions(['bill_id' => $bill->bill_id]);
                    foreach ($billDetailData as $billDetailItem) {
                        $food_id_list[] = $billDetailItem->food_id;
                    }
                }

                $foodData = $FoodModel->readAll();
                foreach ($foodData as $food) {
                    if (in_array($food->food_id, $food_id_list)) {
                        $bill_id_string = "('" . implode("','", $bill_id_list) . "')";
                        $w = ['food_id' => $food->food_id];

                        // $w = "food_id = '$food->food_id' AND bill_id IN ( $bill_id_string )" ;
                        $food_sum = $BillDetailModel->isAlreadyExist2($w, 'bill_id', $bill_id_list) ? $BillDetailModel->sumOptions2('count', $w, 'bill_id', $bill_id_list) : 0;
                        $food_sum_show = number_format($food_sum);
                        $treeMapData[] = ['food' => $food->food_name, 'radius' => $food_sum_show];
                    }
                }
            }


            // donut chart data
            $pieData = [];
            // { id: "Dư có", value: 5000000, color: "#49be25", type: "Dư có" }
            // { id: "Chi", value: 3450000, color: "#be4d25", type: "Chi" }
            $pieData[] = ['id' => 'Dư có', "value" => $total_temporary_profit, "color" => "#49be25", "type" => "Dư có"];
            $pieData[] = ['id' => 'Chi', "value" => $total_trans_spend, "color" => "#be4d25", "type" => "Chi"];
        }

        return json_encode(array('status' => $status, 'message' => $message, 'html' => $html, 'treeMapData' => $treeMapData, 'pieData' => $pieData), JSON_UNESCAPED_UNICODE);
    }


    public function imports()
    {
        // set time out
        ini_set('max_execution_time', 1800);

        // get title
        $data['title'] = "Import Data";

        // get data
        /* Một số trường hợp file excel có dạng: application/zip hoặc application/octet-stream  */
        $input = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,application/vnd.ms-excel,application/octet-stream,application/zip,text/xls,text/xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet]',
            ]
        ]);

        $file = $this->request->getFile('file');

        // set init
        $message = "No Import data has been updated";
        $log_error = '';

        // Count success and error
        $count_success = 0;
        $count_error = 0;


        // $file = $this->request->getFile('file');
        if (!$file->isValid()) {
            throw new RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
        } else {

            $type = $this->request->getVar('type');
            $file_name_type = '';
            if ($type == 'food' ) {
                $file_name_type = 'Food_';
            }

            $file_name = 'Babana_' . $file_name_type . date('Ymd') . '_' . $_SERVER['REMOTE_ADDR'] . date('Ymd_His') . '.xlsx';

            // move this file to writable/uploads folder
            $file->move(WRITEPATH . 'uploads/', $file_name);


            // get file
            $file_data = WRITEPATH . 'uploads/' . $file_name;

            // init PhpSpreadsheet Xlsx
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($file_data);

            // Lấy từng sheet để import
            $fileData = array();
            if ($type == 'food') {
                $fileData = $spreadsheet->getSheetByName('Food');
            }

            if (!empty($fileData)) {

                $allDataInSheet = $fileData->toArray(null, true, true, true);
                // print_r($mainMasterData); exit();

                /* ---------------------------------------------------------------------------------------------------------------------
                    | header check
                    | 
                -----------------------------------------------------------------------------------------------------------------------*/
                $createArray = array(
                    'form_type', 'active', 'internal_item', 'order_item', 'rbo', 'product_type', 'cbs', 'two_sides_printing', 'dual_machine', 'width',
                    'length', 'blank_gap', 'build_stock_cbs_item', 'material_code', 'inlay_type', 'material_description', 'front_ink', 'front_ink_description', 'back_ink', 'back_ink_description', 'approved_sample_card',
                    'machine', 'print_system', 'system', 'packing_form', 'pcs_per_sheet', 'combo', 'combine', 'combo_at', 'fsc', 'brand_protection',
                    'baseroll_in_1_kit', 'qty_pcs_in_1_roll', 'ribbon_in_1_kit', 'ribbon_length', 'process', 'print_speed', 'print_output', 'remark_1', 'remark_2', 'remark_3',
                    'remark_4', 'remark_5'

                );
                $makeArray = array(
                    // 1 - 10
                    'form_type' => 'form_type',
                    'active' => 'active',
                    'internal_item' => 'internal_item',
                    'order_item' => 'order_item',
                    'rbo' => 'rbo',
                    'product_type' => 'product_type',
                    'cbs' => 'cbs',
                    'two_sides_printing' => 'two_sides_printing',
                    'dual_machine' => 'dual_machine',
                    'width' => 'width',
                    // 11 - 20
                    'length' => 'length',
                    'blank_gap' => 'blank_gap',
                    'build_stock_cbs_item' => 'build_stock_cbs_item',
                    'material_code' => 'material_code',
                    'inlay_type' => 'inlay_type',
                    'material_description' => 'material_description',
                    'front_ink' => 'front_ink',
                    'front_ink_description' => 'front_ink_description',
                    'back_ink' => 'back_ink',
                    'back_ink_description' => 'back_ink_description',

                    // 21 - 30
                    'approved_sample_card' => 'approved_sample_card',
                    'machine' => 'machine',
                    'print_system' => 'print_system',
                    'system' => 'system',
                    'packing_form' => 'packing_form',
                    'pcs_per_sheet' => 'pcs_per_sheet',
                    'combo' => 'combo',
                    'combine' => 'combine',
                    'combo_at' => 'combo_at',
                    'fsc' => 'fsc',
                    // 31 - 40
                    'brand_protection' => 'brand_protection',
                    'baseroll_in_1_kit' => 'baseroll_in_1_kit',
                    'qty_pcs_in_1_roll' => 'qty_pcs_in_1_roll',
                    'ribbon_in_1_kit' => 'ribbon_in_1_kit',
                    'ribbon_length' => 'ribbon_length',
                    'process' => 'process',
                    'print_speed' => 'print_speed',
                    'print_output' => 'print_output',
                    'remark_1' => 'remark_1',
                    'remark_2' => 'remark_2',
                    // 41 - 43
                    'remark_3' => 'remark_3',
                    'remark_4' => 'remark_4',
                    'remark_5' => 'remark_5'

                );

                $SheetDataKey = array();
                foreach ($allDataInSheet[1] as $key => $value) {
                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $SheetDataKey[trim($value)] = $key;
                    }
                }

                // check data
                $data = array_diff_key($makeArray, $SheetDataKey);
                $flag = (empty($data)) ? 1 : 0;

                /* ---------------------------------------------------------------------------------------------------------------------
                    | get data
                    | 
                -----------------------------------------------------------------------------------------------------------------------*/
                if ($flag == 1) {

                    // open db and models
                    $db = db_connect();
                    $MasterDataModel = new MasterDataModel($db);
                    $PlanningRFIDSBMultiInkQty = new PlanningRFIDSBMultiInkQty($db);


                    // $MSColorModel = new MSColorModel($db);

                    // get col key
                    // 1 - 10
                    $form_type_col = $SheetDataKey['form_type'];
                    $active_col = $SheetDataKey['active'];
                    $internal_item_col = $SheetDataKey['internal_item'];
                    $order_item_col = $SheetDataKey['order_item'];
                    $rbo_col = $SheetDataKey['rbo'];
                    $product_type_col = $SheetDataKey['product_type'];
                    $cbs_col = $SheetDataKey['cbs'];
                    $two_sides_printing_col = $SheetDataKey['two_sides_printing'];
                    $dual_machine_col = $SheetDataKey['dual_machine'];
                    $width_col = $SheetDataKey['width'];
                    // 11 - 20
                    $length_col = $SheetDataKey['length'];
                    $blank_gap_col = $SheetDataKey['blank_gap'];
                    $build_stock_cbs_item_col = $SheetDataKey['build_stock_cbs_item'];
                    $material_code_col = $SheetDataKey['material_code'];
                    $inlay_type_col = $SheetDataKey['inlay_type'];
                    $material_description_col = $SheetDataKey['material_description'];
                    $front_ink_col = $SheetDataKey['front_ink'];
                    $front_ink_description_col = $SheetDataKey['front_ink_description'];
                    $back_ink_col = $SheetDataKey['back_ink'];
                    $back_ink_description_col = $SheetDataKey['back_ink_description'];
                    // 21 - 30
                    $approved_sample_card_col = $SheetDataKey['approved_sample_card'];
                    $machine_col = $SheetDataKey['machine'];
                    $print_system_col = $SheetDataKey['print_system'];
                    $system_col = $SheetDataKey['system'];
                    $packing_form_col = $SheetDataKey['packing_form'];
                    $pcs_per_sheet_col = $SheetDataKey['pcs_per_sheet'];
                    $combo_col = $SheetDataKey['combo'];
                    $combine_col = $SheetDataKey['combine'];
                    $combo_at_col = $SheetDataKey['combo_at'];
                    $fsc_col = $SheetDataKey['fsc'];
                    // 31 - 40
                    $brand_protection_col = $SheetDataKey['brand_protection'];
                    $baseroll_in_1_kit_col = $SheetDataKey['baseroll_in_1_kit'];
                    $qty_pcs_in_1_roll_col = $SheetDataKey['qty_pcs_in_1_roll'];
                    $ribbon_in_1_kit_col = $SheetDataKey['ribbon_in_1_kit'];
                    $ribbon_length_col = $SheetDataKey['ribbon_length'];
                    $process_col = $SheetDataKey['process'];
                    $print_speed_col = $SheetDataKey['print_speed'];
                    $print_output_col = $SheetDataKey['print_output'];
                    $remark_1_col = $SheetDataKey['remark_1'];
                    $remark_2_col = $SheetDataKey['remark_2'];
                    // 41 -43
                    $remark_3_col = $SheetDataKey['remark_3'];
                    $remark_4_col = $SheetDataKey['remark_4'];
                    $remark_5_col = $SheetDataKey['remark_5'];

                    // list check number
                    $listName[] = 'active';
                    $listName[] = 'width';
                    $listName[] = 'length';
                    $listName[] = 'blank_gap';
                    $listName[] = 'pcs_per_sheet';
                    $listName[] = 'baseroll_in_1_kit';
                    $listName[] = 'qty_pcs_in_1_roll';
                    $listName[] = 'ribbon_in_1_kit';
                    $listName[] = 'ribbon_length';
                    $listName[] = 'print_speed';
                    $listName[] = 'print_output';

                    // load
                    $data = array();
                    $index = 0;
                    for ($i = 2; $i <= count($allDataInSheet); $i++) {

                        $index++;

                        // get data
                        // 1 - 10
                        $form_type = filter_var(trim($allDataInSheet[$i][$form_type_col]));
                        $active = filter_var(trim($allDataInSheet[$i][$active_col]));
                        $internal_item = filter_var(trim($allDataInSheet[$i][$internal_item_col]));
                        $order_item = filter_var(trim($allDataInSheet[$i][$order_item_col]));
                        $rbo = filter_var(trim($allDataInSheet[$i][$rbo_col]));
                        $product_type = filter_var(trim($allDataInSheet[$i][$product_type_col]));
                        $cbs = filter_var(trim($allDataInSheet[$i][$cbs_col]));
                        $two_sides_printing = filter_var(trim($allDataInSheet[$i][$two_sides_printing_col]));
                        $dual_machine = filter_var(trim($allDataInSheet[$i][$dual_machine_col]));
                        $width = filter_var(trim($allDataInSheet[$i][$width_col]));
                        // 11 - 20
                        $length = filter_var(trim($allDataInSheet[$i][$length_col]));
                        $blank_gap = filter_var(trim($allDataInSheet[$i][$blank_gap_col]));
                        $build_stock_cbs_item = filter_var(trim($allDataInSheet[$i][$build_stock_cbs_item_col]));
                        $material_code = filter_var(trim($allDataInSheet[$i][$material_code_col]));
                        $inlay_type = filter_var(trim($allDataInSheet[$i][$inlay_type_col]));
                        $material_description = filter_var(trim($allDataInSheet[$i][$material_description_col]));
                        $front_ink = filter_var(trim($allDataInSheet[$i][$front_ink_col]));
                        $front_ink_description = filter_var(trim($allDataInSheet[$i][$front_ink_description_col]));
                        $back_ink = filter_var(trim($allDataInSheet[$i][$back_ink_col]));
                        $back_ink_description = filter_var(trim($allDataInSheet[$i][$back_ink_description_col]));

                        // 21 -30
                        $approved_sample_card = filter_var(trim($allDataInSheet[$i][$approved_sample_card_col]));
                        $machine = filter_var(trim($allDataInSheet[$i][$machine_col]));
                        $print_system = filter_var(trim($allDataInSheet[$i][$print_system_col]));
                        $system = filter_var(trim($allDataInSheet[$i][$system_col]));
                        $packing_form = filter_var(trim($allDataInSheet[$i][$packing_form_col]));
                        $pcs_per_sheet = filter_var(trim($allDataInSheet[$i][$pcs_per_sheet_col]));
                        $combo = filter_var(trim($allDataInSheet[$i][$combo_col]));
                        $combine = filter_var(trim($allDataInSheet[$i][$combine_col]));
                        $combo_at = filter_var(trim($allDataInSheet[$i][$combo_at_col]));
                        $fsc = filter_var(trim($allDataInSheet[$i][$fsc_col]));
                        // 31 - 40
                        $brand_protection = filter_var(trim($allDataInSheet[$i][$brand_protection_col]));
                        $baseroll_in_1_kit = filter_var(trim($allDataInSheet[$i][$baseroll_in_1_kit_col]));
                        $qty_pcs_in_1_roll = filter_var(trim($allDataInSheet[$i][$qty_pcs_in_1_roll_col]));
                        $ribbon_in_1_kit = filter_var(trim($allDataInSheet[$i][$ribbon_in_1_kit_col]));
                        $ribbon_length = filter_var(trim($allDataInSheet[$i][$ribbon_length_col]));
                        $process = filter_var(trim($allDataInSheet[$i][$process_col]));
                        $print_speed = filter_var(trim($allDataInSheet[$i][$print_speed_col]));
                        $print_output = filter_var(trim($allDataInSheet[$i][$print_output_col]));
                        $remark_1 = filter_var(trim($allDataInSheet[$i][$remark_1_col]));
                        $remark_2 = filter_var(trim($allDataInSheet[$i][$remark_2_col]));

                        // 41 - 43
                        $remark_3 = filter_var(trim($allDataInSheet[$i][$remark_3_col]));
                        $remark_4 = filter_var(trim($allDataInSheet[$i][$remark_4_col]));
                        $remark_5 = filter_var(trim($allDataInSheet[$i][$remark_5_col]));

                        // reset data to save to database
                        // boolean
                        $cbs = (strtolower($cbs) == 'yes') ? 1 : 0;
                        $two_sides_printing = (strtolower($two_sides_printing) == 'yes') ? 1 : 0;
                        $dual_machine = (strtolower($dual_machine) == 'yes') ? 1 : 0;
                        $build_stock_cbs_item = (strtolower($build_stock_cbs_item) == 'yes') ? 1 : 0;
                        $brand_protection = (strtolower($brand_protection) == 'yes') ? 1 : 0;

                        // check empty
                        if (empty($internal_item)) {
                            $count_error++;
                            if ($count_error < 5)
                                continue;
                            else
                                break;
                        }

                        // check numberic
                        $list = array($active, $width, $length, $blank_gap, $pcs_per_sheet, $baseroll_in_1_kit, $qty_pcs_in_1_roll, $ribbon_in_1_kit, $ribbon_length, $print_speed, $print_output);
                        $check_number = $this->isNumberic($list);
                        if ($check_number != 100) {
                            $message = $listName[$check_number] . " nhập sai định dạng dòng internal_item: $internal_item. (Các dữ liệu còn lại chưa được imports)";
                            // dừng import
                            break;
                        }

                        // int, float
                        $active = ((int)$active == 1) ? 1 : 0;
                        $width = (float)$width;
                        $length = (float)$length;
                        $blank_gap = (float)$blank_gap;
                        $pcs_per_sheet = (int)$pcs_per_sheet;

                        $baseroll_in_1_kit = (float)$baseroll_in_1_kit;
                        $qty_pcs_in_1_roll = (float)$qty_pcs_in_1_roll;
                        $ribbon_in_1_kit = (float)$ribbon_in_1_kit;
                        $ribbon_length = (float)$ribbon_length;
                        $print_speed = (float)$print_speed;
                        $print_output = (float)$print_output;



                        // get data
                        $data = array(
                            // 1 - 10
                            'form_type' => $form_type,
                            'active' => $active,
                            'internal_item' => $internal_item,
                            'order_item' => $order_item,
                            'rbo' => $rbo,
                            'product_type' => $product_type,
                            'cbs' => $cbs,
                            'two_sides_printing' => $two_sides_printing,
                            'dual_machine' => $dual_machine,
                            'width' => $width,
                            // 11 - 20
                            'length' => $length,
                            'blank_gap' => $blank_gap,
                            'build_stock_cbs_item' => $build_stock_cbs_item,
                            'material_code' => $material_code,
                            'inlay_type' => $inlay_type,
                            'material_description' => $material_description,
                            'front_ink' => $front_ink,
                            'front_ink_description' => $front_ink_description,
                            'back_ink' => $back_ink,
                            'back_ink_description' => $back_ink_description,

                            // 21 - 30
                            'approved_sample_card' => $approved_sample_card,
                            'machine' => $machine,
                            'print_system' => $print_system,
                            'system' => $system,
                            'packing_form' => $packing_form,
                            'pcs_per_sheet' => $pcs_per_sheet,
                            'combo' => $combo,
                            'combine' => $combine,
                            'combo_at' => $combo_at,
                            'fsc' => $fsc,

                            // 31 - 40 
                            'brand_protection' => $brand_protection,
                            'baseroll_in_1_kit' => $baseroll_in_1_kit,
                            'qty_pcs_in_1_roll' => $qty_pcs_in_1_roll,
                            'ribbon_in_1_kit' => $ribbon_in_1_kit,
                            'ribbon_length' => $ribbon_length,
                            'process' => $process,
                            'print_speed' => $print_speed,
                            'print_output' => $print_output,
                            'remark_1' => $remark_1,
                            'remark_2' => $remark_2,
                            // 41 - 43
                            'remark_3' => $remark_3,
                            'remark_4' => $remark_4,
                            'remark_5' => $remark_5,
                            // update by, date
                            'updated_by' => $updated_by
                        );

                        $dataTmp = $data;


                        if (empty($internal_item)) {
                            continue;
                        }

                        $where = array('internal_item' => $internal_item);
                        if ($MasterDataModel->isAlreadyExist($where)) {

                            unset($data['internal_item']); // xóa điều kiện
                            $data['updated_date'] = date('Y-m-d H:i:s');
                            $dataTmp['updated_date'] = date('Y-m-d H:i:s');


                            $mess_sub = "(Update)";
                            $result = $MasterDataModel->edit($where, $data);
                        } else {
                            $mess_sub = "(Insert)";
                            $result = $MasterDataModel->create($data);
                        }

                        // check
                        if (!$result) {
                            $message = "ERROR. Import lỗi dòng Internal Item: $internal_item $mess_sub";
                            break;
                        } else {

                            $save_to_db = $this->setSaveModel(strtolower(trim($data['form_type'])));
                            $saveModel = '';
                            if ($save_to_db == 'MSColorModel') {
                                $saveModel = new MSColorModel($db);
                            } else if ($save_to_db == 'DatabaseTrimModel') {
                                $saveModel = new DatabaseTrimModel($db);
                            } else if ($save_to_db == 'NoCBSModel') {
                                $saveModel = new NoCBSModel($db);
                            }

                            if (!empty($save_to_db)) {
                                // // // Không lưu dữ liệu MS Color. Đợi khi cập nhật Sub Material thì kiểm tra và lưu luôn (mới đủ đk kiểm tra trùng hay không)
                                // // $count_success++;
                                // // $message = "SUCCESS. Import thành công $count_success dòng dữ liệu";
                                $result = $this->saveDataToSettingForm($form_type, $internal_item);
                                if (!$result) {
                                    $mess_sub = "(Setting Convert)";
                                    $message = "ERROR. Import lỗi dòng Internal Item: $internal_item $mess_sub";
                                    break;
                                } else {
                                    $result = ($save_to_db == 'MSColorModel') ? $this->saveDataToMultiMasterData($dataTmp, $index, $saveModel, $PlanningRFIDSBMultiInkQty) : $this->saveDataToMultiMasterData($dataTmp, $index, $saveModel);
                                    if (!$result) {
                                        $mess_sub = "(Main Master Convert)";
                                        $message = "ERROR. Import lỗi dòng Internal Item: $internal_item $mess_sub";
                                        break;
                                    } else {
                                        $count_success++;
                                        $message = "SUCCESS. Import thành công $count_success dòng dữ liệu";
                                    }
                                }
                            }
                        }
                    }

                    $db->close();
                }
            } else if (!empty($subMasterData)) {

                $allDataInSheet = $subMasterData->toArray(null, true, true, true);

                // print_r($allDataInSheet); exit();

                /* ---------------------------------------------------------------------------------------------------------------------
                    | header check
                    | 
                -----------------------------------------------------------------------------------------------------------------------*/
                $createArray = array('internal_item', 'color_code', 'item_color', 'sub_code', 'sub_type', 'sub_check', 'note');
                $makeArray = array('internal_item' => 'internal_item',  'color_code' => 'color_code', 'item_color' => 'item_color', 'sub_code' => 'sub_code', 'sub_type' => 'sub_type', 'sub_check' => 'sub_check', 'note' => 'note');

                $SheetDataKey = array();
                foreach ($allDataInSheet[1] as $key => $value) {
                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $SheetDataKey[trim($value)] = $key;
                    }
                }

                // check data
                $data = array_diff_key($makeArray, $SheetDataKey);
                $flag = (empty($data)) ? 1 : 0;


                /* ---------------------------------------------------------------------------------------------------------------------
                    | get data
                    | 
                -----------------------------------------------------------------------------------------------------------------------*/
                if ($flag == 1) {

                    // open db and models
                    $db = db_connect();
                    $SubMaterialModel = new SubMaterialModel($db);
                    $MasterDataModel = new MasterDataModel($db);

                    // get col key
                    $internal_item_col = $SheetDataKey['internal_item'];
                    $color_code_col = $SheetDataKey['color_code'];
                    $item_color_col = $SheetDataKey['item_color'];
                    $sub_code_col = $SheetDataKey['sub_code'];
                    $sub_type_col = $SheetDataKey['sub_type'];
                    $sub_check_col = $SheetDataKey['sub_check'];
                    $note_col = $SheetDataKey['note'];

                    // load
                    $data = array();
                    $index = 0;
                    for ($i = 2; $i <= count($allDataInSheet); $i++) {

                        $index++;

                        // get data
                        $internal_item = filter_var(trim($allDataInSheet[$i][$internal_item_col]));
                        $color_code = filter_var(trim($allDataInSheet[$i][$color_code_col]));
                        // $item_color = substr($internal_item, 0,7) . str_replace(" ", "", $color_code) . substr($internal_item, 9,2);

                        $sub_code = filter_var(trim($allDataInSheet[$i][$sub_code_col]));
                        $sub_type = filter_var(trim($allDataInSheet[$i][$sub_type_col]));
                        $sub_check = filter_var(trim($allDataInSheet[$i][$sub_check_col]));
                        $note = filter_var(trim($allDataInSheet[$i][$note_col]));

                        // reset data to save to database

                        // check empty
                        if (empty($internal_item)) {
                            $count_error++;

                            if ($count_error < 5)
                                continue;
                            else
                                break;
                        }

                        // xác định form liên quan cbs hay không
                        $form_type = '';
                        $w = ['internal_item' => $internal_item];
                        if ($MasterDataModel->isAlreadyExist($w)) {
                            $masterItem = $MasterDataModel->readItem(['internal_item' => $internal_item]);
                            $form_type = $masterItem->form_type;
                        }

                        $item_color = '';
                        $cbs_check = in_array($form_type, ['ua_cbs', 'cbs', 'pvh_rfid']) ? true : false;
                        if ($cbs_check) {
                            $internal_item_arr = explode('-', $internal_item);
                            $item_color = $internal_item_arr[0] . "-" . $internal_item_arr[1] . "-" . str_replace(" ", "", $color_code) . "- " . $internal_item_arr[3];
                        }

                        // check Sub Type and Sub Check
                        if (!$this->checkSubType($sub_type)) {
                            $message = "Kiểm tra lại dữ liệu Sub Type tại dòng thứ $index của Internal Item: $internal_item. (Các dữ liệu còn lại chưa được imports) ";
                            break;
                        }

                        if (!$this->checkSubCheck($sub_check)) {
                            $message = "Kiểm tra lại dữ liệu Sub Check tại dòng thứ $index của Internal Item: $internal_item. (Các dữ liệu còn lại chưa được imports) ";
                            break;
                        }

                        // get data
                        $data = array(
                            'internal_item' => $internal_item,
                            'color_code' => $color_code,
                            'item_color' => $item_color,
                            'sub_code' => $sub_code,
                            'sub_type' => $sub_type,
                            'sub_check' => $sub_check,
                            'note' => $note,
                            'updated_by' => $updated_by
                        );

                        $dataTmp = $data;

                        if (empty($internal_item)) {
                            continue;
                        }

                        // Xử lý theo logic binh.luong cung cấp
                        /*
                            - No Color: 
                                + Material: Dựa Item + Sub Code
                                + Ink: Dựa Item + Sub Code + Sub Type
                            - Color: 
                                + Material: Dựa vào Item + Item Color + Sub Code
                                + Ink: Dựa vào Item + Item Color + Sub Code + Sub Type
                        */

                        if (!$cbs_check) {

                            $where = array('internal_item' => $internal_item, 'sub_code' => $sub_code);
                            if (strpos(strtoupper($sub_type), "INK") !== false) {
                                $where = array('internal_item' => $internal_item, 'sub_code' => $sub_code, 'sub_type' => $sub_type);
                            }
                        } else {
                            $where = array('internal_item' => $internal_item, 'item_color' => $item_color, 'sub_code' => $sub_code);
                            if (strpos(strtoupper($sub_type), "INK") !== false) {
                                $where = array('internal_item' => $internal_item, 'item_color' => $item_color, 'sub_code' => $sub_code, 'sub_type' => $sub_type);
                            }
                        }

                        if ($SubMaterialModel->isAlreadyExist($where)) {

                            if (!$cbs_check) {

                                unset($data['internal_item']); // xóa điều kiện
                                unset($data['sub_code']); // xóa điều kiện

                                if (strpos(strtoupper($sub_type), "INK") !== false) {
                                    unset($data['sub_type']); // xóa điều kiện
                                }
                            } else {
                                unset($data['internal_item']); // xóa điều kiện
                                unset($data['item_color']); // xóa điều kiện
                                unset($data['sub_code']); // xóa điều kiện
                                if (strpos(strtoupper($sub_type), "INK") !== false) {
                                    unset($data['sub_type']); // xóa điều kiện
                                }
                            }


                            $data['updated_date'] = date('Y-m-d H:i:s');
                            $dataTmp['updated_date'] = date('Y-m-d H:i:s');

                            $mess_sub = "(Sub Update)";
                            $result = $SubMaterialModel->edit($where, $data);
                        } else {
                            $mess_sub = "(Sub Insert)";
                            $result = $SubMaterialModel->create($data);
                        }

                        // check
                        if (!$result) {
                            $message = "ERROR. Import lỗi dòng thứ $index của Internal Item: $internal_item $mess_sub";
                            break;
                        } else {

                            $result = $this->saveDataToMultiSubMaterial($dataTmp, $index);
                            if (!$result) {
                                $mess_sub = "(Sub Convert)";
                                $message = "ERROR. Import lỗi dòng thứ $index của Internal Item: $internal_item $mess_sub";
                                break;
                            } else {
                                $count_success++;
                                $message = "SUCCESS. Import thành công $count_success dòng dữ liệu";
                            }
                        }
                    }

                    $db->close();
                }
            }
        }


        // results
        $results['message'] = $message;

        return view('imports/display', $results);
    }


    public function exports()
    {
        // set time out
        ini_set('max_execution_time', 1800);
        // check login
        if (!get_cookie('VNRISIntranet')) return view('errors/html/error_access');

        // spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        // Add some data
        $spreadsheet->setActiveSheetIndex(0);



        $master_type = $this->request->getVar('type');
        if ($master_type == 'main_master_exports') {

            // active and set title
            $spreadsheet->getActiveSheet()->setTitle('Main_Master');

            // set the names of header cells
            // set Header, width
            $columns = [
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS'
            ];


            $headers = [
                'form_type', 'active', 'internal_item', 'order_item', 'rbo', 'product_type', 'cbs', 'two_sides_printing', 'dual_machine', 'width',
                'length', 'blank_gap', 'build_stock_cbs_item', 'material_code', 'inlay_type', 'material_description', 'front_ink', 'front_ink_description', 'back_ink', 'back_ink_description',
                'approved_sample_card', 'machine', 'print_system', 'system', 'packing_form', 'pcs_per_sheet', 'combo', 'combine', 'combo_at', 'fsc',
                'brand_protection', 'baseroll_in_1_kit', 'qty_pcs_in_1_roll', 'ribbon_in_1_kit', 'ribbon_length', 'process', 'print_speed', 'print_output', 'remark_1',
                'remark_2', 'remark_3', 'remark_4', 'remark_5', 'updated_by', 'updated_date'
            ];

            foreach ($headers as $key => $header) {
                // width
                $spreadsheet->getActiveSheet()->getColumnDimension($columns[$key])->setWidth(20);
                // headers
                $spreadsheet->getActiveSheet()->setCellValue($columns[$key] . '1', $header);
            }

            // Font
            $spreadsheet->getActiveSheet()->getStyle('A1:AS1')->getFont()->setBold(true)->setName('Arial')->setSize(10);
            $spreadsheet->getActiveSheet()->getStyle('A1:AS1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('3399ff');
            $spreadsheet->getActiveSheet()->getStyle('A:AS')->getFont()->setName('Arial')->setSize(10);

            // open db and models
            $db = db_connect();
            $MasterDataModel = new MasterDataModel($db);

            $data = $MasterDataModel->readAll('form_type');

            // print_r($data); exit();
            if (!empty($data)) {
                $index = 0;
                $rowCount = 1;
                // $data (array)$data;
                foreach ($data as $element) {
                    $index++;
                    $rowCount++;

                    $element = (array) $element;
                    // add to excel file
                    $spreadsheet->getActiveSheet()->SetCellValue('A' . $rowCount, trim($element['form_type']));
                    $spreadsheet->getActiveSheet()->SetCellValue('B' . $rowCount, trim($element['active']));
                    $spreadsheet->getActiveSheet()->SetCellValue('C' . $rowCount, trim($element['internal_item']));
                    $spreadsheet->getActiveSheet()->SetCellValue('D' . $rowCount, trim($element['order_item']));
                    $spreadsheet->getActiveSheet()->SetCellValue('E' . $rowCount, trim($element['rbo']));
                    $spreadsheet->getActiveSheet()->SetCellValue('F' . $rowCount, trim($element['product_type']));
                    $spreadsheet->getActiveSheet()->SetCellValue('G' . $rowCount, trim($element['cbs']));
                    $spreadsheet->getActiveSheet()->SetCellValue('H' . $rowCount, trim($element['two_sides_printing']));
                    $spreadsheet->getActiveSheet()->SetCellValue('I' . $rowCount, trim($element['dual_machine']));
                    $spreadsheet->getActiveSheet()->SetCellValue('J' . $rowCount, trim($element['width']));

                    $spreadsheet->getActiveSheet()->SetCellValue('K' . $rowCount, trim($element['length']));
                    $spreadsheet->getActiveSheet()->SetCellValue('L' . $rowCount, trim($element['blank_gap']));
                    $spreadsheet->getActiveSheet()->SetCellValue('M' . $rowCount, trim($element['build_stock_cbs_item']));
                    $spreadsheet->getActiveSheet()->SetCellValue('N' . $rowCount, trim($element['material_code']));
                    $spreadsheet->getActiveSheet()->SetCellValue('O' . $rowCount, trim($element['inlay_type']));
                    $spreadsheet->getActiveSheet()->SetCellValue('P' . $rowCount, trim($element['material_description']));
                    $spreadsheet->getActiveSheet()->SetCellValue('Q' . $rowCount, trim($element['front_ink']));
                    $spreadsheet->getActiveSheet()->SetCellValue('R' . $rowCount, trim($element['front_ink_description']));
                    $spreadsheet->getActiveSheet()->SetCellValue('S' . $rowCount, trim($element['back_ink']));
                    $spreadsheet->getActiveSheet()->SetCellValue('T' . $rowCount, trim($element['back_ink_description']));

                    $spreadsheet->getActiveSheet()->SetCellValue('U' . $rowCount, trim($element['approved_sample_card']));
                    $spreadsheet->getActiveSheet()->SetCellValue('V' . $rowCount, trim($element['machine']));
                    $spreadsheet->getActiveSheet()->SetCellValue('W' . $rowCount, trim($element['print_system']));
                    $spreadsheet->getActiveSheet()->SetCellValue('X' . $rowCount, trim($element['system']));
                    $spreadsheet->getActiveSheet()->SetCellValue('Y' . $rowCount, trim($element['packing_form']));
                    $spreadsheet->getActiveSheet()->SetCellValue('Z' . $rowCount, trim($element['pcs_per_sheet']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AA' . $rowCount, trim($element['combo']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AB' . $rowCount, trim($element['combine']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AC' . $rowCount, trim($element['combo_at']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AD' . $rowCount, trim($element['fsc']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AE' . $rowCount, trim($element['brand_protection']));

                    $spreadsheet->getActiveSheet()->SetCellValue('AF' . $rowCount, trim($element['baseroll_in_1_kit']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AG' . $rowCount, trim($element['qty_pcs_in_1_roll']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AH' . $rowCount, trim($element['ribbon_in_1_kit']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AI' . $rowCount, trim($element['ribbon_length']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AJ' . $rowCount, trim($element['process']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AK' . $rowCount, trim($element['print_speed']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AL' . $rowCount, trim($element['print_output']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AM' . $rowCount, trim($element['remark_1']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AN' . $rowCount, trim($element['remark_2']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AO' . $rowCount, trim($element['remark_3']));

                    $spreadsheet->getActiveSheet()->SetCellValue('AP' . $rowCount, trim($element['remark_4']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AQ' . $rowCount, trim($element['remark_5']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AR' . $rowCount, trim($element['updated_by']));
                    $spreadsheet->getActiveSheet()->SetCellValue('AS' . $rowCount, trim($element['updated_date']));
                }
            }

            $db->close();
        } else if ($master_type == 'sub_material_exports') {

            // active and set title
            $spreadsheet->getActiveSheet()->setTitle('Sub_Material');

            // set the names of header cells
            // set Header, width
            $columns = [
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS'
            ];

            $headers = array('internal_item', 'color_code', 'item_color', 'sub_code', 'sub_type', 'sub_check', 'note');

            foreach ($headers as $key => $header) {
                // width
                $spreadsheet->getActiveSheet()->getColumnDimension($columns[$key])->setWidth(20);
                // headers
                $spreadsheet->getActiveSheet()->setCellValue($columns[$key] . '1', $header);
            }

            // Font
            $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true)->setName('Arial')->setSize(10);
            $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('3399ff');
            $spreadsheet->getActiveSheet()->getStyle('A:G')->getFont()->setName('Arial')->setSize(10);

            // open db and models
            $db = db_connect();
            $SubMaterialModel = new SubMaterialModel($db);
            $data = $SubMaterialModel->readAll('internal_item, sub_type, sub_check');

            // print_r($data); exit();
            if (!empty($data)) {
                $index = 0;
                $rowCount = 1;
                // $data (array)$data;
                foreach ($data as $element) {
                    $index++;
                    $rowCount++;

                    $element = (array) $element;
                    // add to excel file
                    $spreadsheet->getActiveSheet()->SetCellValue('A' . $rowCount, trim($element['internal_item']));
                    $spreadsheet->getActiveSheet()->SetCellValue('B' . $rowCount, trim($element['color_code']));
                    $spreadsheet->getActiveSheet()->SetCellValue('C' . $rowCount, trim($element['item_color']));
                    $spreadsheet->getActiveSheet()->SetCellValue('D' . $rowCount, trim($element['sub_code']));
                    $spreadsheet->getActiveSheet()->SetCellValue('E' . $rowCount, trim($element['sub_type']));
                    $spreadsheet->getActiveSheet()->SetCellValue('F' . $rowCount, trim($element['sub_check']));
                    $spreadsheet->getActiveSheet()->SetCellValue('G' . $rowCount, trim($element['note']));
                }
            }

            $db->close();
        }

        // output 
        // set filename for excel file to be exported
        $file_name_type = "All_Master__";
        if ($master_type == 'main_master_exports') {
            $file_name_type = "MainMaster__";
        } else if ($master_type == 'sub_material_exports') {
            $file_name_type = "SubMaster__";
        }
        $filename = 'SB_' . $file_name_type . '_' . date('Y_m_d__H_i_s');

        // header: generate excel file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        // writer
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        // $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }




}
