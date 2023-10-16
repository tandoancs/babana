"use strict";

var layout, detailLayout, addLayout, doneLayout;
var toolbar, detailToolbar;
var dhxWindow, doneWindow, detailDoneWindow;
var grid, detailGrid, leftGrid, rightGrid, doneGrid, detailDoneGrid;
var addForm;
var form;
var BDate;
var treeGrid;
var treeChart, donutChart;

function isNumber(value) {
    return typeof value === 'number';
}

function layout() {
    // Layout initialization
    layout = new dhx.Layout("layout", {
        type: "line",
        cols: [
            {
                rows: [
                    { id: "toolbar", height: "content", },
                    {
                        type: "space",
                        rows: [
                            { id: "grid", },
                        ],
                    },
                ],
            },
            {
                id: "edit-cell", css: "", hidden: true, width: 240,
                rows: [
                    { id: "edit-toolbar", height: "content", },
                    { id: "edit-form" },
                ],
            },
        ],
    });

    // attaching widgets to Layout cells
    // layout.getCell("toolbar").attach(toolbar)
    // layout.getCell("grid").attach(grid)
    // layout.getCell("edit-toolbar").attach(editToolbar)
}

function toolbar() {
    const toolbarData = [
        { type: "button", view: "flat", color: "primary", circle: true, icon: "mdi mdi-menu", },
        { id: "dashboard", value: "Dashboard", icon: "mdi mdi-view-dashboard", group: "page", twoState: true, active: true, },
        { type: "spacer", },
        { id: "done_order", type: "button", circle: false, value: "Đơn hàng đã thanh toán", size: "small", icon: "mdi mdi-check-outline", full: true, },
        { type: "separator" },
        { type: "separator" },
        { id: "add_order", type: "button", circle: false, value: "Thêm đơn hàng (order)", size: "small", icon: "mdi mdi-plus", full: true, },
        { id: "settings2", icon: "mdi mdi-cog", type: "button", view: "link", color: "secondary", circle: true, },
        { type: "text", icon: "mdi mdi-help-circle", value: "Hướng dẫn", tooltip: "Chức năng:: (1) Thêm đơn hàng (order): Tạo một đơn hàng mới. (2) Đơn hàng đã thanh toán: Hiển thị danh sách đơn hàng đã thanh toán xong", },
    ];

    // Toolbar initialization
    toolbar = new dhx.Toolbar("toolbar_container", {});
    // loading structure into Toolbar
    toolbar.data.parse(toolbarData);

    toolbar.events.on("click", function (id, e) {
        if (id == "add_order") {
            windows(id);
        } else if (id == "done_order") {
            orderDoneWindow();
        } else {
            dhx.alert({
                header: "Alert Header",
                text: "Chưa có chức năng xử lý",
                buttonsAlignment: "center",
            });
        }
    });
}

function orderGrid() {
    // to get data
    $.ajax("./getOptionsOfOrderGrid")
        .done(function (data) {
            var data = JSON.parse(data);

            // console.log("data options: " + JSON.stringify(data));

            // creating DHTMLX Grid
            grid = new dhx.Grid("grid_container", {
                css: "dhx_demo-grid",
                columns: [
                    { width: 70, id: "bill_id", header: [{ text: "Mã Bill", align: "center" }], align: "center" },
                    {
                        width: 110, id: "area_name", header: [{ text: "Khu vực" }, { content: "comboFilter" }], editorType: "combobox", editorConfig: {
                            template: ({ value }) => getOptionsTemplate(value)
                        },
                        options: data.areaOptions,
                        template: (value) => getOptionsTemplate(value),
                        htmlEnable: true
                    },
                    {
                        width: 150, id: "table_order_name", header: [{ text: "Bàn" }, { content: "comboFilter" }], editorType: "combobox", editorConfig: {
                            template: ({ value }) => getOptionsTemplate(value)
                        },
                        options: data.tableOptions,
                        template: (value) => getOptionsTemplate(value),
                        htmlEnable: true
                    },
                    { width: 150, id: "date_check_in", header: [{ text: "Giờ vào", align: "center" }, { content: "comboFilter" }], align: "center", editable: false },
                    { width: 100, id: "sum_orders", header: [{ text: "Số món", align: "center" }, { content: "comboFilter" }], align: "center", editable: false },
                    { width: 100, id: "total", header: [{ text: "Thành tiền", align: "center" }, { content: "comboFilter" }], align: "right", type: "number", format: "#,#", editable: false },
                    { width: 100, id: "money_received", header: [{ text: "Tiền nhận", align: "center" }, { content: "comboFilter" }], type: "number", format: "#,#", align: "left", autoHeight: true, editable: true },
                    { width: 100, id: "money_refund", header: [{ text: "Tiền thừa", align: "center" }, { content: "comboFilter" }], type: "number", format: "#,#", align: "left", autoHeight: true, editable: false },
                    {
                        width: 150, id: "status", header: [{ text: "Trạng thái" }, { content: "comboFilter" }], editorType: "combobox", editorConfig: {
                            template: ({ value }) => getPriorityTemplate(value)
                        },
                        options: ["Đã thanh toán", "Đã giao món", "Đang đợi", "Hủy"],
                        template: (value) => getPriorityTemplate(value),
                        htmlEnable: true,
                        minWidth: 100
                    },

                    {
                        width: 200, id: "promotion_description", header: [{ text: "Khuyến mãi" }, { content: "comboFilter" }], editorType: "combobox", editorConfig: {
                            template: ({ value }) => getOptionsTemplate(value)
                        },
                        options: data.promotionOptions,
                        template: (value) => getOptionsTemplate(value),
                        htmlEnable: true,
                        minWidth: 100,
                    },
                    { id: "note", header: [{ text: "Ghi chú", align: "center" }], type: "textarea", align: "left", editorType: "textarea", autoHeight: true, editable: true },
                    // { id: "note", header: [{ text: "Ghi chú" }, { content: "comboFilter" }], align: "left", type: "textarea", editorType: "textarea", editable: true },

                    {
                        width: 70, id: "detail", gravity: 1.5, header: [{ text: "Chi tiết", align: "center" }], htmlEnable: true, align: "center", editable: false,
                        template: function () {
                            return "<span class='action-buttons'><a class='btn btn-info detail-btn detail-button'>Xem</a></span>";
                        },
                    },
                    {
                        width: 200, id: "action", gravity: 1.5, header: [{ text: "Actions", align: "center" }], htmlEnable: true, align: "center", editable: false,
                        template: function () {
                            return "<span class='action-buttons'><a class='btn btn-primary print-button'>In Hóa đơn</a><a class='btn btn-warning edit-button save-button'>Lưu</a><a class='btn btn-danger remove-button'>Xóa</a></span>";
                        },
                    },
                ],
                editable: true,
                autoWidth: true,
                autoHeight: true,
                resizable: true,
                eventHandlers: {
                    onclick: {
                        "detail-button": function (e, data) {
                            windows("detail_order", data.row);
                        },
                        "remove-button": function (e, dataR) {

                            console.log(`data saved: ${JSON.stringify(dataR.row)}`);
                            getAjaxData2(function (data) {

                                var result = JSON.parse(data)
                                var css = 'dhx_message--error'
                                if (result.status) {
                                    css = 'dhx_message--success'
                                    grid.data.remove(dataR.row.id)
                                }
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-delete-empty-outline", css: css, expire: 5000 })

                                // // đợi 4s sau đó load lại trang
                                // setTimeout(function () {
                                //     location.reload();
                                // }, 4000)

                            }, "deleteMainOrder", dataR.row)
                        },
                        "save-button": function (e, data) {

                            console.log(`data saved: ${JSON.stringify(data.row)}`);
                            console.log(`Đang cập nhật main order ... `);

                            if (data.row.status == "Đã thanh toán") {
                                if (!data.row.money_received) {
                                    dhx.alert({ header: "Cập nhật Đơn hàng", text: "Bạn phải nhập số Tiền nhận mới cập nhật Đã thanh toán xong", buttonsAlignment: "center", buttons: ["Đồng ý"] })
                                    return
                                }
                            }

                            getAjaxData2(function (data) {

                                var result = JSON.parse(data);
                                let css = (result.status == true) ? 'dhx_message--success' : 'dhx_message--error';
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "dxi dxi-content-save", css: css, expire: 5000 });

                                // đợi 4s sau đó load lại trang
                                setTimeout(function () {
                                    // location.reload();
                                    let selectedCell = grid.selection.getCell();
                                    let bill_id = selectedCell.row.bill_id;
                                    window.open("printer?bill_id=" + bill_id, "blank");
                                }, 500)

                            }, "saveMainOrder", data.row);

                        },
                        "print-button": function (e, data) {
                            let selectedCell = grid.selection.getCell();
                            let bill_id = selectedCell.row.bill_id;
                            window.open("printer?bill_id=" + bill_id, "blank");
                        },
                    },
                },
                data: data.dataset
            });


            // grid.events.on("cellMouseOver", function (row, column, e) {
            //     windows('detail_order')
            // })

            grid.selection.enable();

            grid.selection.events.on("AfterSelect", function (row, col) {
                console.log("afterSelect", row, col);
            });

            // edit events
            grid.events.on("afterEditEnd", function (value, row, column) {

                // console.log('Đang cập nhật dữ liệu chung ... ');
                var money_received = row.money_received
                if (money_received) {
                    if (!isNumber(money_received)) {
                        dhx.alert({ header: "Cập nhậ Đơn hàng", text: "Vui nhập nhập kiểu số", buttonsAlignment: "center", buttons: ["Đồng ý"] });
                        // dhx.alert({ header: "Cập nhậ Đơn hàng", text: "Vui nhập nhập kiểu số", buttonsAlignment: "center", buttons: ["Đồng ý"] });
                        row.money_refund = 0
                    } else {
                        let money_received_check = row.money_received
                        // trường hợp nhập số tiền đơn vị là 1000 đồng
                        if (money_received_check.toString().length >= 1 && money_received_check.toString().length <= 3) {
                            money_received = money_received * 1000
                            row.money_received = money_received
                        }


                        if (money_received < row.total) {
                            dhx.alert({
                                header: "Cập nhật Đơn hàng",
                                text: "Số tiền khách đưa phải lớn hơn hoặc bằng tổng thanh toán",
                                buttonsAlignment: "center",
                                buttons: ["Đồng ý"]
                            });
                            dhx.alert({
                                header: "Cập nhật đơn hàng",
                                text: "Số tiền khách đưa phải lớn hơn hoặc bằng tổng thanh toán",
                                buttonsAlignment: "center",
                            });

                            // row.money_refund = 0
                        } else {
                            row.money_refund = money_received - row.total
                        }
                    }
                }


            });
        })
        .fail(function () {
            alert("Không lấy được dữ liệu từ hệ thống");
        })
        .always(function () {
            console.log("Done!");
        });
}


function openEditor(id) {
    dhx.alert({
        header: "Alert Header",
        text: "Alert text",
        buttonsAlignment: "center",
    });
}

function getOptionsTemplate(value) {
    if (!value) return;
    return `
        <div class='dhx-demo_grid-template'>
            <div class='dhx-demo_grid-status'></div>
            <span>${value}</span>
        </div>
    `;
}

function getPriorityTemplate(value) {
    if (!value) return;
    let status = "dhx-demo_grid-status--not-started";
    if (value === "Đã thanh toán") status = "dhx-demo_grid-status--done";
    if (value === "Đã giao món") status = "dhx-demo_grid-status--delivered";
    if (value === "Đang đợi") status = "dhx-demo_grid-status--in-progress";
    if (value === "Hủy") status = "dhx-demo_grid-status--cancelled";
    return `
        <div class='dhx-demo_grid-template'>
            <div class='dhx-demo_grid-status ${status}'></div>
            <span>${value}</span>
        </div>
    `;
}

function windows(id, data = null) {

    // get date now
    let date = dateNow();

    // get form data
    let bill_id = "";
    let table_order_name = "";
    let date_check_in = date[3] + ":" + date[4] + ":" + date[5];
    // let date_check_out = "";
    let total = "";
    let status = "";
    let area_name = "";
    let promotion_description = "";
    let note = "";

    if (data) {
        bill_id = data.bill_id.trim();
        table_order_name = data.table_order_name.trim();
        date_check_in = data.date_check_in.trim();
        // date_check_out = data.date_check_out.trim();
        total = data.total.trim();
        status = statusChange(data.status.trim());

        area_name = data.area_name.trim();
        promotion_description = data.promotion_description.trim();
        note = data.note.trim();
    }

    if (id == "add_order") {
        getWindowData(function (data) {

            var data = JSON.parse(data);

            // get form structure

            /*  window -------------------------------------------------------------------------------------- */
            dhxWindow = new dhx.Window({ width: 1548, height: 620, closable: true, movable: true, modal: true, title: "Thêm Đơn hàng (order)", });

            /*  add layout -------------------------------------------------------------------------------------- */
            addLayout = new dhx.Layout(null, {
                type: "space",
                cols: [
                    { id: "С1", html: "1", width: 820, header: "Tất cả sản phẩm có sẵn", resizable: true },
                    {
                        type: "line",
                        rows: [
                            { id: "С2", html: "2", header: "Đơn hàng đang được xử lý", resizable: true },
                            { id: "С3", html: "3", resizable: true },
                        ],
                    }
                ]
            });

            /*  add grid -------------------------------------------------------------------------------------- */
            leftGrid = new dhx.Grid(null, {
                // css: "dhx_demo-grid",
                columns: [
                    { width: 220, id: "food_name", header: [{ text: "Sản phẩm" }, { content: "comboFilter" }], },
                    {
                        width: 170, id: "food_size_unit_code", header: [{ text: "Đơn vị: Size" }], editorType: "combobox", editorConfig: {
                            template: ({ value }) => getOptionsTemplate(value)
                        },
                        options: data.sizeUnitOptions,
                        template: (value) => getOptionsTemplate(value),
                        htmlEnable: true
                    },
                    { width: 100, id: "food_price", header: [{ text: "Đơn giá" }], type: "number", format: "#,#" },
                    { width: 90, id: "food_count", header: [{ text: "Số lượng" }] },

                    { id: "food_note", header: [{ text: "Ghi chú" }] },
                    {
                        width: 100,
                        id: "food_action",
                        gravity: 1.5,
                        header: [{ text: "Actions", align: "center" }],
                        htmlEnable: true,
                        align: "center",
                        template: function () {
                            return "<div class='food-action-buttons'><a class='btn btn-primary btn-add-food detail-add-button'>Thêm</a></div>";
                        },
                    },
                ],
                editable: true,
                autoWidth: true,
                resizable: true,
                eventHandlers: {
                    onclick: {
                        "detail-add-button": function (e, data) {
                            let food_total = data.row.food_count * data.row.food_price;
                            let rowData = {
                                detail_food_name_add: data.row.food_name,
                                detail_size_unit: data.row.food_size_unit_code,
                                detail_price_add: data.row.food_price,
                                detail_count_add: data.row.food_count,
                                detail_total_add: food_total,
                                detail_note_add: data.row.food_note,
                            }

                            // reset leftGrid data
                            data.row.food_count = 1

                            addNewItem(rowData);
                            setAddFormData();
                        },
                    },
                },
                data: data.foodDataSet
            });

            leftGrid.selection.enable();

            // Khi người dùng chọn kích thước ==> lấy giá của sản phẩm
            leftGrid.events.on("afterEditEnd", function (value, row, column) {
                console.log('Đang lấy giá sản phẩm ... ');
                let food_name = row.food_name;
                let food_size_unit_code = row.food_size_unit_code;
                $.post("getFoodPrice", { food_name: food_name, food_size_unit_code: food_size_unit_code })
                    .done(function (data) {
                        let foodSizeData = JSON.parse(data)
                        row.food_price = foodSizeData.price

                    }).fail(function () {
                        dhx.alert({ header: "Tạo Đơn hàng", text: "Không lấy được giá sản phẩm, Vui lòng nhập giá", buttonsAlignment: "center", });
                    })
                    .always(function () {
                        console.log("finished");
                    });




            });

            rightGrid = new dhx.Grid(null, {
                // css: "dhx_demo-grid",
                columns: [
                    { width: 200, id: "detail_food_name_add", header: [{ text: "Sản phẩm" }], },
                    { width: 100, id: "detail_size_unit", header: [{ text: "Đơn vị:Size" }] },
                    { width: 100, id: "detail_price_add", header: [{ text: "Đơn giá" }], type: "number", format: "#,#" },
                    { width: 90, id: "detail_count_add", header: [{ text: "Số lượng" }] },
                    { width: 120, id: "detail_total_add", editable: false, header: [{ text: "Tổng" }], type: "number", format: "#,#" },
                    { id: "detail_note_add", header: [{ text: "Ghi chú" }] },
                    {
                        width: 100,
                        id: "detail_action_add",
                        gravity: 1.5,
                        header: [{ text: "Actions", align: "center" }],
                        htmlEnable: true,
                        align: "center",
                        template: function () {
                            return "<span class='action-buttons'><a class='btn btn-danger detail-remove-button'>Xóa</a></span>";
                        },
                    },
                ],
                editable: true,
                autoWidth: true,
                selection: "row",
                resizable: true,
                multiselection: true,
                eventHandlers: {
                    onclick: {
                        "detail-remove-button": function (e, data) {
                            rightGrid.data.remove(data.row.id);
                            setAddFormData();
                        },
                    },
                },
            });

            rightGrid.selection.enable();


            /*  --------------------------------------------------------------------------------------
                    | add form
                    |
                */

            addForm = new dhx.Form(null, {
                css: "dhx_widget--bordered",
                padding: 20,
                rows: [
                    {
                        type: "fieldset", name: "general", label: "Thông tin chung", labelAlignment: "left",
                        rows: [
                            {
                                align: "around", width: "900px", padding: "20px", cols: [
                                    {
                                        rows: [
                                            {
                                                type: "combo", name: "table_order_name", required: true, label: "Bàn", placeholder: "Chọn Bàn", listHeight: "100px", newOptions: true, labelWidth: "270px", padding: "10px", helpMessage: "Bạn có thể chọn danh sách sẵn có hoặc có thể thêm dữ liệu mới",
                                                data: data.tableOptions
                                            },
                                            {
                                                type: "combo", name: "area_id", required: true, label: "Khu vực", placeholder: "Khu vực bàn được đặt", listHeight: "100px", newOptions: true, labelWidth: "270px", padding: "10px", helpMessage: "Bạn có thể chọn danh sách sẵn có hoặc có thể thêm dữ liệu mới",
                                                data: data.areaOptions
                                            },
                                            // { type: "input", inputType: "text", name: "area_name", required: true, label: "Khu vực", placeholder: "Khu vực bàn được đặt", labelWidth: "270px", padding: "10px", readOnly: true },
                                        ]
                                    },
                                    {
                                        rows: [
                                            {
                                                type: "combo", name: "promotion_description", label: "Khuyến mãi", placeholder: "Khuyến mãi", listHeight: "100px", labelWidth: "270px", labelWidth: "270px", padding: "10px", helpMessage: "Khuyến mãi chỉ được thêm vào từ chức năng Quản lý Khuyến mãi",
                                                data: data.promotionOptions
                                            },
                                            { type: "input", inputType: "number", name: "count_orders", required: true, label: "Số món (khác nhau)", placeholder: "Số món khác nhau", labelWidth: "270px", padding: "10px", readOnly: true, helpMessage: "Dữ liệu này được tính từ hệ thống, không được thay đổi" },
                                        ]
                                    },
                                    {
                                        rows: [
                                            { labelWidth: "220px", type: "input", name: "total", required: true, label: "Tạm tính", placeholder: "Số tiền tạm tính", labelWidth: "270px", padding: "10px", helpMessage: "Bạn có thể thay đổi số tiền tạm tính", },
                                            { type: "input", name: "sum_orders", inputType: "number", required: true, label: "Số lượng món", placeholder: "Tổng số món trong đơn", labelWidth: "270px", padding: "10px", readOnly: true, helpMessage: "Dữ liệu này được tính từ hệ thống, không được thay đổi", },
                                        ]
                                    }
                                ]
                            },
                        ]
                    },
                    {
                        align: "end",
                        cols: [
                            { type: "button", name: "cancel", view: "link", text: "Xóa" },
                            { type: "button", name: "save_add", view: "flat", text: "Lưu", submit: true, url: "saveOrder" }
                        ],
                    }
                ],
            });

            // addForm.setValue({
            //     "area_name": ["1"]
            // });

            // attaching widgets to Layout cells
            addLayout.getCell("С1").attach(leftGrid);

            addLayout.getCell("С2").attach(rightGrid);
            addLayout.getCell("С3").attach(addForm);

            /*  detail attach to layout -------------------------------------------------------------------------------------- */
            dhxWindow.attach(addLayout);

            dhxWindow.setFullScreen();
            dhxWindow.show();

            addForm.events.on("click", function (name, new_value) {
                if (name == "cancel") {
                    addForm.clear("value");
                } else if (name == "save_add") {
                    // var formData = addForm.getValue();
                    // console.log(`formData: ${JSON.stringify(formData)}`);

                    var formData = {
                        table_order_name: addForm.getItem('table_order_name').getValue(),
                        area_id: addForm.getItem('area_id').getValue(),
                        promotion_description: addForm.getItem('promotion_description').getValue(),
                        count_orders: addForm.getItem('count_orders').getValue(),
                        total: addForm.getItem('total').getValue(),
                        sum_orders: addForm.getItem('sum_orders').getValue()
                    }

                    var gridData = rightGrid.data.serialize();
                    if (gridData.length == 0) {
                        dhx.alert({ header: "Tạo Đơn hàng", text: "Đơn hàng bạn tạo chưa có món nào", buttonsAlignment: "center", });
                        return
                    } else {

                        if (!formData.table_order_name) {
                            dhx.alert({ header: "Tạo Đơn hàng", text: "Bạn chưa chọn Bàn của đơn hàng", buttonsAlignment: "center", });
                            return
                        } else if (!formData.area_id) {
                            dhx.alert({ header: "Tạo Đơn hàng", text: "Bạn chưa chọn Khu vực của đơn hàng", buttonsAlignment: "center", });
                            return
                        } else {

                            console.log(`formData: ${JSON.stringify(formData)}`);
                            console.log(`gridData: ${JSON.stringify(gridData)}`);

                            var formSave = [];
                            formSave.push({
                                'table_order_name': formData.table_order_name,
                                'area_id': formData.area_id,
                                'promotion_description': formData.promotion_description,
                                'count_orders': formData.count_orders,
                                'total': formData.total,
                                'sum_orders': formData.sum_orders
                            })

                            console.log(`formSave: ${JSON.stringify(formSave)}`)

                            var obj = { formData: formData, gridData: gridData }
                            $.post("saveOrder", { data: JSON.stringify(obj) })
                                .done(function (data) {

                                    // creating DHTMLX Message 
                                    dhx.message({
                                        node: "message_container",
                                        text: "Tạo đơn hàng thành công",
                                        icon: "dxi dxi-content-save",
                                        css: "dhx_message--success",
                                        expire: 5000
                                    });

                                    location.reload();

                                }).fail(function () {
                                    dhx.alert({ header: "Tạo Đơn hàng", text: "Chưa lấy được dữ liệu để lưu", buttonsAlignment: "center", });
                                })
                                .always(function () {
                                    console.log("finished");
                                });
                        }
                    }
                }

            })

            // get area id for form
            addForm.getItem("table_order_name").events.on("change", function (ids) {
                addForm.getItem("table_order_name").events.on("afterValidate", function (ids, isValidate) {
                    if (isValidate) {
                        $.post("getAreaId", { table_id: ids })
                            .done(function (result) {

                                let areaData = JSON.parse(result);
                                if (areaData.status == false) {
                                    dhx.alert({ header: "Tạo Đơn hàng", text: areaData.message, buttonsAlignment: "center", });
                                } else {
                                    // creating DHTMLX Message 
                                    dhx.message({ node: "message_container", text: "Lấy Khu vực Bàn thành công", icon: "dxi dxi-content-save", css: "dhx_message--success", expire: 3000 });
                                    // set area data
                                    addForm.setValue({
                                        "area_id": areaData.data.area_id
                                    });
                                }


                            }).fail(function () {
                                dhx.alert({ header: "Tạo Đơn hàng", text: "Chưa lấy được dữ liệu Bàn để tìm Khu vực", buttonsAlignment: "center", });
                            })
                            .always(function () {
                                console.log("finished");
                            });
                    }

                });

            });
        });
    } else {
        if (id == "description") {
            const windowHtml =
                "<p>Here is a neat and flexible JavaScript window system with a fast and simple initialization.</p><p>Inspect all the DHTMLX window samples to discover each and every feature.</p><img style='display: block; width: 200px; height: 200px; margin-top: 20px; margin-left: auto; margin-right: auto' src='https://snippet.dhtmlx.com/codebase/data/common/img/01/developer-01.svg'>";
            dhxWindow = new dhx.Window({
                width: 360,
                height: 520,
                closable: true,
                movable: true,
                modal: true,
                title: "Window",
                html: windowHtml,
            });
        } else if (id == "detail_order") {

            $.ajax("./detailLoad?bill_id=" + bill_id).done(function (data) {

                var data = JSON.parse(data);
                // console.log("detail data options: " + JSON.stringify(data));

                /*  Window -------------------------------------------------------------------------------------- */
                dhxWindow = new dhx.Window({ width: 1280, height: 520, closable: true, movable: true, modal: true, title: "Chi tiết đơn hàng", });

                /*  detail toolbar-------------------------------------------------------------------------------------- */
                var toolbarData = [
                    { type: "button", view: "flat", color: "primary", circle: true, icon: "mdi mdi-menu" },
                    { id: "dashboard", value: "Dashboard", icon: "mdi mdi-view-dashboard", group: "page", twoState: true, active: true },
                    { type: "spacer" },
                    { id: "detail-save", type: "button", circle: true, value: "Lưu tất cả", size: "small", icon: "mdi mdi-content-save-all", full: true },
                    { id: "settings2", icon: "mdi mdi-cog", type: "button", view: "link", color: "secondary", circle: true },
                    { type: "text", icon: "mdi mdi-help-circle", value: "Hướng dẫn", tooltip: "Chức năng:: Lưu tất cả các sản phẩm đã sửa." },
                ];

                // Toolbar initialization
                detailToolbar = new dhx.Toolbar(null, {})

                // loading structure into Toolbar
                detailToolbar.data.parse(toolbarData)

                detailToolbar.events.on("click", function (id, e) {
                    if (id == "detail-save ") {
                        var detailData = detailGrid.data.serialize()
                        getAjaxData2(function (data) {

                            var result = JSON.parse(data)
                            let css = (result.status == true) ? 'dhx_message--success' : 'dhx_message--error'

                            // creating DHTMLX Message 
                            dhx.message({ node: "message_container", text: result.message, icon: "dxi dxi-content-save", css: css, expire: 5000 });

                            // đợi 4s sau đó load lại trang
                            setTimeout(function () { location.reload() }, 4000)

                        }, "saveDetail", detailData)
                    }

                    // dhx.alert({ header: "Alert Header", text: "Alert text", buttonsAlignment: "center", });
                });

                /*  detail grid-------------------------------------------------------------------------------------- */
                detailGrid = new dhx.Grid(null, {
                    css: "dhx_demo-grid",

                    columns: [
                        { width: 50, id: "bill_detail_id", header: [{ text: "Mã" }], type: "number", format: "#,#" },
                        {
                            width: 270, id: "detail_food_name", header: [{ text: "Sản phẩm" }], editorType: "combobox", editorConfig: {
                                template: ({ value }) => getOptionsTemplate(value)
                            },
                            options: data.foodOptions,
                            template: (value) => getOptionsTemplate(value),
                            htmlEnable: true
                        },
                        {
                            width: 270, id: "detail_size_unit_code", header: [{ text: "Đơn vị: Size" }], editorType: "combobox", editorConfig: {
                                template: ({ value }) => getOptionsTemplate(value)
                            },
                            options: data.sizeUnitOptions,
                            template: (value) => getOptionsTemplate(value),
                            htmlEnable: true
                        },
                        { width: 90, id: "detail_count", header: [{ text: "Số lượng" }], type: "number", format: "#,#" },
                        { width: 100, id: "detail_price", header: [{ text: "Đơn giá" }], type: "number", format: "#,#" },
                        { width: 120, id: "detail_total", editable: false, header: [{ text: "Tổng" }], type: "number", format: "#,#" },
                        { width: 100, id: "detail_bill_id", editable: false, header: [{ text: "Thuộc Bill" }] },
                        { id: "detail_note", header: [{ text: "Ghi chú" }] },
                        {
                            width: 120, id: "detail_action", gravity: 1.5, header: [{ text: "Actions", align: "center" }], htmlEnable: true, align: "center",
                            template: function () {
                                return "<span class='action-buttons'><a class='btn btn-warning detail-edit-button'>Lưu</a><a class='btn btn-danger detail-remove-button'>Xóa</a></span>";
                            }
                        }
                    ],
                    editable: true,
                    autoWidth: true,
                    resizable: true,
                    selection: "row",
                    multiselection: true,
                    eventHandlers: {
                        onclick: {
                            "detail-remove-button": function (e, dataR) {

                                console.log(`data removed: ${JSON.stringify(dataR.row)}`);

                                getAjaxData2(function (data) {

                                    var result = JSON.parse(data);

                                    var css = 'dhx_message--error';
                                    if (result.status) {
                                        css = 'dhx_message--success';
                                        detailGrid.data.remove(dataR.row.id);
                                    }
                                    // creating DHTMLX Message 
                                    dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-delete-empty-outline", css: css, expire: 5000 });

                                    // đợi 3s sau đó load lại trang
                                    setTimeout(function () {
                                        location.reload();
                                    }, 5000)
                                }, "deleteDetail", dataR.row);

                            },
                            "detail-edit-button": function (e, data) {

                                getAjaxData2(function (data) {

                                    var result = JSON.parse(data);
                                    let css = (result.status == true) ? 'dhx_message--success' : 'dhx_message--error';
                                    // creating DHTMLX Message 
                                    dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-square-edit-outline", css: css, expire: 5000 });

                                    // đợi 4s sau đó load lại trang
                                    setTimeout(function () {
                                        location.reload();
                                    }, 4000)
                                }, "saveDetail", [data.row]);

                                // // creating DHTMLX Message 
                                // dhx.message({ node: "message_container", text: "Lưu sản phẩm thành công", icon: "dxi dxi-content-save", css: "dhx_message--success", expire: 3000 });
                            },
                        },
                    },
                    data: data.detailData
                });

                detailGrid.selection.enable();

                detailGrid.events.on("afterEditEnd", function (value, row, column) {

                    if ((column.id == "detail_count" && row.detail_count > 0) || (column.id == "detail_price" && row.detail_price > 0)) {

                        row.detail_total = row.detail_count * row.detail_price

                    } else if ((column.id == "detail_size_unit_code") && (row.detail_size_unit_code)) {

                        if (row.detail_food_name) {

                            row.detail_count = 1;

                            getAjaxData(function (data) {

                                var result = JSON.parse(data);
                                var price = Number(result.price);

                                console.log(`Đang cập nhật lại giá ... `);
                                if (price == '0') {
                                    dhx.alert({ header: "Cập nhật đơn hàng", text: "Chưa lấy được giá của sản phẩm", buttonsAlignment: "center", });
                                }

                                row.detail_price = price
                                row.detail_total = row.detail_count * price
                                row.detail_bill_id = bill_id

                            }, "getDetailDataToAdd?detail_food_name=" + row.detail_food_name + "&detail_size_unit_code=" + row.detail_size_unit_code);
                        }

                    } else if ((column.id == "detail_food_name") && (row.detail_food_name)) {


                        if (row.detail_size_unit_code) {

                            row.detail_count = 1;

                            getAjaxData(function (data) {

                                var result = JSON.parse(data);
                                var price = Number(result.price);

                                if (price == '0') {
                                    dhx.alert({ header: "Cập nhật đơn hàng", text: "Chưa lấy được giá của sản phẩm", buttonsAlignment: "center", });
                                }

                                row.detail_price = price
                                row.detail_total = row.detail_count * price
                                row.detail_bill_id = bill_id

                            }, "getDetailDataToAdd?detail_food_name=" + row.detail_food_name + "&detail_size_unit_code=" + row.detail_size_unit_code);
                        }

                    }

                });

                /*  detail layout -------------------------------------------------------------------------------------- */
                // Layout initialization
                detailLayout = new dhx.Layout(null, {
                    type: "line",
                    cols: [
                        {
                            rows: [
                                { id: "detail-toolbar", height: "content" },
                                { type: "space", rows: [{ id: "detail-grid" }] }
                            ],
                        },
                    ],
                });

                // attaching widgets to Layout cells
                detailLayout.getCell("detail-toolbar").attach(detailToolbar);
                detailLayout.getCell("detail-grid").attach(detailGrid);

                /*  detail attach to layout -------------------------------------------------------------------------------------- */
                dhxWindow.attach(detailLayout);
                dhxWindow.show();

            })
                .fail(function () {
                    alert("Không lấy được dữ liệu từ hệ thống");
                })
                .always(function () {
                    console.log("Done!");
                });

        }


    }

}

function statusChange(status) {
    if (status == "Đã thanh toán") {
        status = "Done";
    } else if (status == "Đã thanh toán") {
        status = "Delivered";
    } else if (status == "Đã giao món") {
        status = "Delivered";
    } else if (status == "Đang đợi") {
        status = "In-progress";
    } else if (status == "Hủy") {
        status = "Cancelled";
    } else {
        status = "Undefined";
    }

    return status;
}

function dateNow() {
    let date = new Date();

    console.log(`date: ${date}`);
    let year = date.getFullYear();
    let month = date.getMonth();
    let day = date.getDay();
    let hour = date.getHours();
    let minute = date.getMinutes();
    let second = date.getSeconds();

    return [year, month, day, hour, minute, second];
}

function addNewItem(rowData) {

    // var data = rightGrid.data
    rightGrid.data.add({
        detail_food_name_add: rowData.detail_food_name_add,
        detail_size_unit: rowData.detail_size_unit,
        detail_price_add: rowData.detail_price_add,
        detail_count_add: rowData.detail_count_add,
        detail_total_add: rowData.detail_total_add,
        detail_note_add: rowData.detail_note_add
    });

}

function setAddFormData() {
    var rightGridData = rightGrid.data.serialize();

    var sum_orders = 0;
    var count_orders_arr = [];
    var total = 0;
    for (var index = 0; index < rightGridData.length; index++) {
        sum_orders += Number(rightGridData[index].detail_count_add);
        if (count_orders_arr.indexOf(rightGridData[index].detail_food_name_add) == -1) {
            count_orders_arr.push(rightGridData[index].detail_food_name_add);
        }

        total += Number(rightGridData[index].detail_price_add) * Number(rightGridData[index].detail_count_add);
    }

    var count_orders = count_orders_arr.length;

    total = total.toLocaleString();

    addForm.setValue({
        "sum_orders": sum_orders,
        "count_orders": count_orders,
        "total": total
    });

    // return { "sum_orders": sum_orders, "count_orders": count_orders, "total": total }

}

function orderDoneWindow() {

    // to get data
    $.ajax("./getOptionsOfOrderGrid?done=done")
        .done(function (data) {
            var data = JSON.parse(data);

            // creating DHTMLX Grid
            doneGrid = new dhx.Grid(null, {
                css: "dhx_demo-grid",
                columns: [
                    { width: 70, id: "bill_id", header: [{ text: "Mã Bill", align: "center" }], align: "center" },
                    {
                        width: 110, id: "area_name", header: [{ text: "Khu vực" }, { content: "comboFilter" }], editorType: "combobox", editorConfig: {
                            template: ({ value }) => getOptionsTemplate(value)
                        },
                        options: data.areaOptions,
                        template: (value) => getOptionsTemplate(value),
                        htmlEnable: true
                    },
                    {
                        width: 150, id: "table_order_name", header: [{ text: "Bàn" }, { content: "comboFilter" }], editorType: "combobox", editorConfig: {
                            template: ({ value }) => getOptionsTemplate(value)
                        },
                        options: data.tableOptions,
                        template: (value) => getOptionsTemplate(value),
                        htmlEnable: true
                    },
                    { width: 150, id: "date_check_in", header: [{ text: "Giờ vào", align: "center" }, { content: "comboFilter" }], align: "center", editable: false },
                    { width: 100, id: "sum_orders", header: [{ text: "Số món", align: "center" }, { content: "comboFilter" }], align: "center", editable: false },
                    { width: 100, id: "total", header: [{ text: "Thành tiền", align: "center" }, { content: "comboFilter" }], align: "right", type: "number", format: "#,#", editable: false },
                    { width: 100, id: "money_received", header: [{ text: "Tiền nhận", align: "center" }, { content: "comboFilter" }], type: "number", format: "#,#", align: "left", autoHeight: true, editable: true },
                    { width: 100, id: "money_refund", header: [{ text: "Tiền thừa", align: "center" }, { content: "comboFilter" }], type: "number", format: "#,#", align: "left", autoHeight: true, editable: false },
                    {
                        width: 150, id: "status", header: [{ text: "Trạng thái" }, { content: "comboFilter" }], editorType: "combobox", editorConfig: {
                            template: ({ value }) => getPriorityTemplate(value)
                        },
                        options: ["Đã thanh toán", "Đã giao món", "Đang đợi", "Hủy"],
                        template: (value) => getPriorityTemplate(value),
                        htmlEnable: true,
                        minWidth: 100
                    },

                    {
                        width: 200, id: "promotion_description", header: [{ text: "Khuyến mãi" }, { content: "comboFilter" }], editorType: "combobox", editorConfig: {
                            template: ({ value }) => getOptionsTemplate(value)
                        },
                        options: data.promotionOptions,
                        template: (value) => getOptionsTemplate(value),
                        htmlEnable: true,
                        minWidth: 100,
                    },
                    { id: "note", header: [{ text: "Ghi chú", align: "center" }], type: "textarea", align: "left", editorType: "textarea", autoHeight: true, editable: true },
                    { width: 80, id: "printed", header: [{ text: "Lần in", align: "center" }], align: "center", autoHeight: true, editable: false },
                    // { id: "note", header: [{ text: "Ghi chú" }, { content: "comboFilter" }], align: "left", type: "textarea", editorType: "textarea", editable: true },

                    {
                        width: 70, id: "detail", gravity: 1.5, header: [{ text: "Chi tiết", align: "center" }], htmlEnable: true, align: "center",
                        template: function () {
                            return "<span class='action-buttons'><a class='btn btn-info detail-btn detail-button'>Xem</a></span>";
                        },
                    },
                    {
                        width: 110, id: "action", gravity: 1.5, header: [{ text: "Actions", align: "center" }], htmlEnable: true, align: "center", editable: false,
                        template: function () {
                            return "<span class='action-buttons'><a class='btn btn-primary print-button-done'>In Hóa đơn</a></span>";
                        },
                    },
                ],
                editable: true,
                autoWidth: true,
                autoHeight: true,
                resizable: true,
                eventHandlers: {
                    onclick: {
                        "detail-button": function (e, data) {
                            // console.log(`done detail button: ${JSON.stringify(data)}`);
                            $.ajax("./detailLoad?bill_id=" + data.row.bill_id + "&done=done")
                                .done(function (data) {

                                    var data = JSON.parse(data);
                                    // console.log("detail data options: " + JSON.stringify(data));

                                    /*  Window -------------------------------------------------------------------------------------- */
                                    detailDoneWindow = new dhx.Window({ width: 1280, height: 520, closable: true, movable: true, modal: true, title: "Chi tiết đơn hàng", });

                                    /*  detail grid-------------------------------------------------------------------------------------- */
                                    detailDoneGrid = new dhx.Grid(null, {
                                        css: "dhx_demo-grid",

                                        columns: [
                                            { width: 50, id: "bill_detail_id", header: [{ text: "Mã" }], type: "number", format: "#,#" },
                                            {
                                                width: 270, id: "detail_food_name", header: [{ text: "Sản phẩm" }], editorType: "combobox", editorConfig: {
                                                    template: ({ value }) => getOptionsTemplate(value)
                                                },
                                                options: data.foodOptions,
                                                template: (value) => getOptionsTemplate(value),
                                                htmlEnable: true
                                            },
                                            {
                                                width: 270, id: "detail_size_unit_code", header: [{ text: "Đơn vị: Size" }], editorType: "combobox", editorConfig: {
                                                    template: ({ value }) => getOptionsTemplate(value)
                                                },
                                                options: data.sizeUnitOptions,
                                                template: (value) => getOptionsTemplate(value),
                                                htmlEnable: true
                                            },
                                            { width: 90, id: "detail_count", header: [{ text: "Số lượng" }], type: "number", format: "#,#" },
                                            { width: 100, id: "detail_price", header: [{ text: "Đơn giá" }], type: "number", format: "#,#" },
                                            { width: 120, id: "detail_total", editable: false, header: [{ text: "Tổng" }], type: "number", format: "#,#" },
                                            { width: 100, id: "detail_bill_id", editable: false, header: [{ text: "Thuộc Bill" }] },
                                            { id: "detail_note", header: [{ text: "Ghi chú" }] },
                                        ],
                                        editable: true,
                                        autoWidth: true,
                                        resizable: true,
                                        selection: "row",
                                        multiselection: true,
                                        data: data.detailData
                                    });

                                    detailDoneGrid.selection.enable();

                                    /*  detail attach to layout -------------------------------------------------------------------------------------- */
                                    detailDoneWindow.attach(detailDoneGrid);
                                    detailDoneWindow.show();

                                })
                                .fail(function () {
                                    alert("Không lấy được dữ liệu từ hệ thống");
                                })
                                .always(function () {
                                    console.log("Done!");
                                });
                        },
                        "print-button-done": function (e, data) {
                            let selectedCell = doneGrid.selection.getCell();
                            let bill_id = selectedCell.row.bill_id;
                            window.open("printer?bill_id=" + bill_id, "blank");
                        },
                    },
                },
                data: data.dataset
            });

            doneGrid.selection.enable();

            /*  window -------------------------------------------------------------------------------------- */
            doneWindow = new dhx.Window({ width: 1548, height: 620, closable: true, movable: true, modal: true, title: "Đơn hàng đã thanh toán", });

            /*  detail attach to layout -------------------------------------------------------------------------------------- */
            doneWindow.attach(doneGrid);
            doneWindow.setFullScreen();
            doneWindow.show();
        })
        .fail(function () {
            alert("Không lấy được dữ liệu từ hệ thống");
        })
        .always(function () {
            console.log("Done!");
        });

}

/* -------------------------------------------------------------------------------------------------------------------------------------------
    |
    | master data
    |
*/

var areaWinddow, tableWindow, foodWindow, promotionWindow, sizeWindow, unitWindow, sizeUnitWindow, transWindow
var areaToolbar, tableToolbar, foodToolbar, promotionToolbar, sizeToolbar, unitToolbar, sizeUnitToolbar, transToolbar
var areaGrid, tableGrid, foodGrid, promotionGrid, sizeGrid, unitGrid, sizeUnitGrid, transGrid
var areaLayout, tableLayout, foodLayout, promotionLayout, sizeLayout, unitLayout, sizeUnitLayout, transLayout
var reportsWindow
var reportsGrid
var reportsToolbar
var reportsLayout

function area() {

    getAjaxData2(function (data) {

        var result = JSON.parse(data)


        /*  window -------------------------------------------------------------------------------------- */
        areaWinddow = new dhx.Window({ width: 1048, height: 620, closable: true, movable: true, modal: true, title: "Khu vực chổ ngồi", });

        /*  toolbar-------------------------------------------------------------------------------------- */
        var structure = [
            { type: "button", view: "flat", color: "primary", circle: true, icon: "mdi mdi-menu" },
            { id: "dashboard", value: "Dashboard", icon: "mdi mdi-view-dashboard", group: "page", twoState: true, active: true },
            { type: "spacer" },
            { id: "detail-save", type: "button", circle: true, value: "Lưu tất cả", size: "small", icon: "mdi mdi-content-save-all", full: true },
            { id: "settings2", icon: "mdi mdi-cog", type: "button", view: "link", color: "secondary", circle: true },
            { type: "text", icon: "mdi mdi-help-circle", value: "Hướng dẫn", tooltip: "Chức năng:: Lưu tất cả các sản phẩm đã sửa." },
        ];

        // Toolbar initialization
        areaToolbar = new dhx.Toolbar(null, {})

        // loading structure into Toolbar
        areaToolbar.data.parse(structure)

        areaToolbar.events.on("click", function (id, e) {
            dhx.alert({ header: "Thông báo", text: "Chức năng chưa được hỗ trợ", buttonsAlignment: "center", });
        });

        /*  grid-------------------------------------------------------------------------------------- */
        areaGrid = new dhx.Grid(null, {
            css: "dhx_demo-grid",

            columns: [
                { width: 150, id: "area_id", header: [{ text: "Mã Khu vực", align: "center" }], align: "center", editable: false },
                { id: "area_name", header: [{ text: "Tên khu vực" }], type: "text" },
                {
                    width: 200, id: "detail_action", gravity: 1.5, header: [{ text: "Actions", align: "center" }], htmlEnable: true, align: "center",
                    template: function () {
                        return "<span class='action-buttons'><a class='btn btn-warning md-edit-button'>Lưu</a><a class='btn btn-danger md-remove-button'>Xóa</a></span>";
                    }
                }
            ],
            editable: true,
            autoWidth: true,
            resizable: true,
            selection: "row",
            multiselection: true,
            eventHandlers: {
                onclick: {
                    "md-remove-button": function (e, dataR) {
                        console.log(`md data: ${JSON.stringify(dataR.row)}`);
                        let area_id = dataR.row.area_id;
                        if (area_id == 'new') {
                            dhx.alert({ header: "Thông báo", text: "Đây là dòng dữ liệu trống, vui lòng chọn lại", buttonsAlignment: "center", });
                        } else {

                            getAjaxData2(function (data) {

                                var result = JSON.parse(data)
                                var css = 'dhx_message--error'
                                if (result.status) {
                                    css = 'dhx_message--success'
                                    areaGrid.data.remove(dataR.row.id)
                                }
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-delete-empty-outline", css: css, expire: 5000 })

                            }, "deleteArea", dataR.row);
                        }

                    },
                    "md-edit-button": function (e, data) {

                        console.log(`md data: ${JSON.stringify(data.row)}`);
                        let area_name = data.row.area_name;
                        if (!data.row.area_id == 'new') {
                            dhx.alert({ header: "Thông báo", text: "Bạn đang chọn dòng dữ liệu trống", buttonsAlignment: "center", });
                        } else if (!area_name) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Tên Khu Vực không được trống", buttonsAlignment: "center", });
                        } else {

                            getAjaxData2(function (data) {

                                var result = JSON.parse(data);
                                let css = (result.status == true) ? 'dhx_message--success' : 'dhx_message--error';
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-square-edit-outline", css: css, expire: 5000 });

                                if (result.status) {
                                    area();
                                }
                                // // đợi 4s sau đó load lại trang
                                // setTimeout(function () {
                                //     location.reload();
                                // }, 4000)
                            }, "saveArea", data.row);
                        }

                    },
                },
            },
            data: result.data
        });

        areaGrid.selection.enable();

        areaGrid.events.on("afterEditEnd", function (value, row, column) { });

        /*  layout -------------------------------------------------------------------------------------- */
        areaLayout = new dhx.Layout(null, {
            type: "line",
            cols: [
                {
                    rows: [
                        { id: "toolbar", height: "content" },
                        { type: "space", rows: [{ id: "grid" }] }
                    ],
                },
            ],
        });

        // attaching widgets to Layout cells
        areaLayout.getCell("toolbar").attach(areaToolbar);
        areaLayout.getCell("grid").attach(areaGrid);


        areaWinddow.attach(areaLayout);
        // areaWinddow.setFullScreen();
        areaWinddow.show();

    }, "area")

}

function tableOrder() {

    getAjaxData2(function (data) {

        var result = JSON.parse(data)


        /*  window -------------------------------------------------------------------------------------- */
        tableWindow = new dhx.Window({ width: 1048, height: 620, closable: true, movable: true, modal: true, title: "Bàn", });

        /*  toolbar-------------------------------------------------------------------------------------- */
        var structure = [
            { type: "button", view: "flat", color: "primary", circle: true, icon: "mdi mdi-menu" },
            { id: "dashboard", value: "Dashboard", icon: "mdi mdi-view-dashboard", group: "page", twoState: true, active: true },
            { type: "spacer" },
            { id: "detail-save", type: "button", circle: true, value: "Lưu tất cả", size: "small", icon: "mdi mdi-content-save-all", full: true },
            { id: "settings2", icon: "mdi mdi-cog", type: "button", view: "link", color: "secondary", circle: true },
            { type: "text", icon: "mdi mdi-help-circle", value: "Hướng dẫn", tooltip: "Chức năng:: Lưu tất cả các sản phẩm đã sửa." },
        ];

        // Toolbar initialization
        tableToolbar = new dhx.Toolbar(null, {})

        // loading structure into Toolbar
        tableToolbar.data.parse(structure)

        tableToolbar.events.on("click", function (id, e) {
            dhx.alert({ header: "Thông báo", text: "Chức năng chưa được hỗ trợ", buttonsAlignment: "center", });
        });

        /*  grid-------------------------------------------------------------------------------------- */
        tableGrid = new dhx.Grid(null, {
            css: "dhx_demo-grid",

            columns: [
                { width: 100, id: "table_id", header: [{ text: "Mã Bàn", align: "center" }], align: "center", editable: false },
                { id: "table_order_name", header: [{ text: "Tên Bàn" }], type: "text" },
                {
                    width: 200, id: "area_name", header: [{ text: "Khu vực" }], editorType: "combobox", editorConfig: {
                        template: ({ value }) => getOptionsTemplate(value)
                    },
                    options: result.areaOptions,
                    template: (value) => getOptionsTemplate(value),
                    htmlEnable: true
                },
                {
                    width: 200, id: "detail_action", gravity: 1.5, header: [{ text: "Actions", align: "center" }], htmlEnable: true, align: "center",
                    template: function () {
                        return "<span class='action-buttons'><a class='btn btn-warning md-edit-button'>Lưu</a><a class='btn btn-danger md-remove-button'>Xóa</a></span>";
                    }
                }
            ],
            editable: true,
            autoWidth: true,
            resizable: true,
            selection: "row",
            multiselection: true,
            eventHandlers: {
                onclick: {
                    "md-remove-button": function (e, dataR) {
                        console.log(`md data: ${JSON.stringify(dataR.row)}`);
                        if (dataR.row.table_id == 'new') {
                            dhx.alert({ header: "Thông báo", text: "Đây là dòng dữ liệu trống, vui lòng chọn lại", buttonsAlignment: "center", });
                        } else {

                            getAjaxData2(function (data) {

                                var result = JSON.parse(data)
                                var css = 'dhx_message--error'
                                if (result.status) {
                                    css = 'dhx_message--success'
                                    tableGrid.data.remove(dataR.row.id)
                                }
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-delete-empty-outline", css: css, expire: 5000 })

                            }, "deleteTableOrder", dataR.row);
                        }

                    },
                    "md-edit-button": function (e, data) {

                        console.log(`md data: ${JSON.stringify(data.row)}`);
                        if (!data.row.table_order_name) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Tên Bàn không được trống", buttonsAlignment: "center", });
                        } else if (!data.row.area_name) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Khu Vực không được trống", buttonsAlignment: "center", });
                        } else {

                            getAjaxData2(function (data) {

                                var result = JSON.parse(data);
                                let css = (result.status == true) ? 'dhx_message--success' : 'dhx_message--error';
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-square-edit-outline", css: css, expire: 5000 });

                                if (result.status) {
                                    tableOrder();
                                }
                                // // đợi 4s sau đó load lại trang
                                // setTimeout(function () {
                                //     location.reload();
                                // }, 4000)
                            }, "saveTableOrder", data.row);
                        }

                    },
                },
            },
            data: result.data
        });

        tableGrid.selection.enable();

        tableGrid.events.on("afterEditEnd", function (value, row, column) { });

        /*  layout -------------------------------------------------------------------------------------- */
        tableLayout = new dhx.Layout(null, {
            type: "line",
            cols: [
                {
                    rows: [
                        { id: "toolbar", height: "content" },
                        { type: "space", rows: [{ id: "grid" }] }
                    ],
                },
            ],
        });

        // attaching widgets to Layout cells
        tableLayout.getCell("toolbar").attach(tableToolbar);
        tableLayout.getCell("grid").attach(tableGrid);


        tableWindow.attach(tableLayout);
        // tableWinddow.setFullScreen();
        tableWindow.show();

    }, "tableOrder")

}

function food() {

    getAjaxData2(function (data) {

        var result = JSON.parse(data)

        /*  window -------------------------------------------------------------------------------------- */
        foodWindow = new dhx.Window({ width: 1048, height: 620, closable: true, movable: true, modal: true, title: "Sản phẩm", })

        /*  toolbar-------------------------------------------------------------------------------------- */
        var structure = [
            { type: "button", view: "flat", color: "primary", circle: true, icon: "mdi mdi-menu" },
            { id: "dashboard", value: "Dashboard", icon: "mdi mdi-view-dashboard", group: "page", twoState: true, active: true },
            { type: "spacer" },
            { id: "imports", type: "button", circle: true, value: "Nhập File (Excel)", size: "small", icon: "mdi mdi-file-import", full: true },
            { id: "exports", type: "button", circle: true, value: "Xuất File (Excel)", size: "small", icon: "mdi mdi-file-export", full: true },
            { id: "settings2", icon: "mdi mdi-cog", type: "button", view: "link", color: "secondary", circle: true },
            { type: "text", icon: "mdi mdi-help-circle", value: "Hướng dẫn", tooltip: "Chức năng:: Lưu tất cả các sản phẩm đã sửa." },
        ]

        // Toolbar initialization
        foodToolbar = new dhx.Toolbar(null, {})

        // loading structure into Toolbar
        foodToolbar.data.parse(structure)

        foodToolbar.events.on("click", function (id, e) {
            dhx.alert({ header: "Thông báo", text: "Chức năng chưa được hỗ trợ", buttonsAlignment: "center", })
        })

        /*  grid-------------------------------------------------------------------------------------- */
        foodGrid = new dhx.Grid(null, {
            css: "dhx_demo-grid",

            columns: [
                { width: 100, id: "food_id", header: [{ text: "Mã SP", align: "center" }], align: "center", editable: false },
                { id: "food_name", header: [{ text: "Tên Sản phẩm" }], type: "text" },
                { id: "description", header: [{ text: "Mô tả Sản phẩm" }], type: "text" },
                {
                    width: 200, id: "catalog", header: [{ text: "Loại sản phẩm" }], editorType: "combobox", editorConfig: {
                        template: ({ value }) => getOptionsTemplate(value)
                    },
                    options: result.catalogOptions,
                    template: (value) => getOptionsTemplate(value),
                    htmlEnable: true
                },
                {
                    width: 200, id: "detail_action", gravity: 1.5, header: [{ text: "Actions", align: "center" }], htmlEnable: true, align: "center",
                    template: function () {
                        return "<span class='action-buttons'><a class='btn btn-warning md-edit-button'>Lưu</a><a class='btn btn-danger md-remove-button'>Xóa</a></span>";
                    }
                }
            ],
            editable: true,
            autoWidth: true,
            resizable: true,
            selection: "row",
            multiselection: true,
            eventHandlers: {
                onclick: {
                    "md-remove-button": function (e, dataR) {
                        console.log(`md data: ${JSON.stringify(dataR.row)}`);
                        if (dataR.row.food_id == 'new') {
                            dhx.alert({ header: "Thông báo", text: "Đây là dòng dữ liệu trống, vui lòng chọn lại", buttonsAlignment: "center", });
                        } else {

                            getAjaxData2(function (data) {

                                var result = JSON.parse(data)
                                var css = 'dhx_message--error'
                                if (result.status) {
                                    css = 'dhx_message--success'
                                    foodGrid.data.remove(dataR.row.id)
                                }
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-delete-empty-outline", css: css, expire: 5000 })

                            }, "deleteFood", dataR.row)
                        }

                    },
                    "md-edit-button": function (e, data) {

                        console.log(`md data: ${JSON.stringify(data.row)}`);
                        if (!data.row.food_id == 'new') {
                            dhx.alert({ header: "Thông báo", text: "Bạn đang chọn dòng dữ liệu trống", buttonsAlignment: "center", });
                        } else if (!data.row.food_name) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Tên Sản Phẩm không được trống", buttonsAlignment: "center", });
                        } else if (!data.row.description) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Mô tả Sản Phẩm không được trống", buttonsAlignment: "center", });
                        } else if (!data.row.catalog) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Loại Sản Phẩm không được trống", buttonsAlignment: "center", });
                        } else {

                            getAjaxData2(function (data) {

                                var result = JSON.parse(data);
                                let css = (result.status == true) ? 'dhx_message--success' : 'dhx_message--error';
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-square-edit-outline", css: css, expire: 5000 });

                                if (result.status) {
                                    food();
                                }
                                // // đợi 4s sau đó load lại trang
                                // setTimeout(function () {
                                //     location.reload();
                                // }, 4000)
                            }, "saveFood", data.row);
                        }

                    },
                },
            },
            data: result.data
        });

        foodGrid.selection.enable();

        foodGrid.events.on("afterEditEnd", function (value, row, column) { });

        /*  layout -------------------------------------------------------------------------------------- */
        foodLayout = new dhx.Layout(null, {
            type: "line",
            cols: [
                {
                    rows: [
                        { id: "toolbar", height: "content" },
                        { type: "space", rows: [{ id: "grid" }] }
                    ],
                },
            ],
        });

        // attaching widgets to Layout cells
        foodLayout.getCell("toolbar").attach(foodToolbar);
        foodLayout.getCell("grid").attach(foodGrid);


        foodWindow.attach(foodLayout);
        // foodWindow.setFullScreen();
        foodWindow.show();

    }, "food")

}

function promotion() {

    getAjaxData2(function (data) {

        var result = JSON.parse(data)

        /*  window -------------------------------------------------------------------------------------- */
        promotionWindow = new dhx.Window({ width: 1548, height: 620, closable: true, movable: true, modal: true, title: "Khuyến mãi", })

        /*  toolbar-------------------------------------------------------------------------------------- */
        var structure = [
            { type: "button", view: "flat", color: "primary", circle: true, icon: "mdi mdi-menu" },
            { id: "dashboard", value: "Dashboard", icon: "mdi mdi-view-dashboard", group: "page", twoState: true, active: true },
            { type: "spacer" },
            { id: "detail-save", type: "button", circle: true, value: "Lưu tất cả", size: "small", icon: "mdi mdi-content-save-all", full: true },
            { id: "settings2", icon: "mdi mdi-cog", type: "button", view: "link", color: "secondary", circle: true },
            { type: "text", icon: "mdi mdi-help-circle", value: "Hướng dẫn", tooltip: "Chức năng:: Lưu tất cả các sản phẩm đã sửa." },
        ]

        // Toolbar initialization
        promotionToolbar = new dhx.Toolbar(null, {})

        // loading structure into Toolbar
        promotionToolbar.data.parse(structure)

        promotionToolbar.events.on("click", function (id, e) {
            dhx.alert({ header: "Thông báo", text: "Chức năng chưa được hỗ trợ", buttonsAlignment: "center", })
        })

        /*  grid-------------------------------------------------------------------------------------- */
        promotionGrid = new dhx.Grid(null, {
            css: "dhx_demo-grid",
            columns: [
                { width: 70, id: "promotion_id", header: [{ text: "Mã KM", align: "center" }], align: "center", editable: false },
                { width: 100, id: "promotion_type", header: [{ text: "Loại KM", align: "center" }], type: "text", align: "center" },
                { width: 170, id: "promotion_code", header: [{ text: "Khuyến mãi", align: "center" }], type: "text", align: "center" },
                { width: 100, id: "promotion_condition", header: [{ text: "Điều kiện", align: "center" }], type: "text", align: "center" },
                { width: 100, id: "parameter", header: [{ text: "Tham số", align: "center" }], type: "text", align: "center" },

                {
                    id: "start_date", header: [{ text: "Từ ngày" }], type: "date", format: "%d-%m-%Y %H:%i:%s",
                    editorConfig: {
                        weekStart: "monday", weekNumbers: true, mode: "calendar", timePicker: true, timeFormat: 24, thisMonthOnly: false,
                        mark: (date) => { if (date.getDay() === 5) return "highlight-date"; },
                        // disabled dates
                        disabledDates: (date) => {
                            const disabled = { 2: true }
                            return disabled[date.getDay()];
                        },
                    }
                },
                {
                    id: "end_date", header: [{ text: "Đến ngày" }], type: "date", format: "%d-%m-%Y %H:%i:%s",
                    editorConfig: {
                        weekStart: "monday", weekNumbers: true, mode: "calendar", timePicker: true, timeFormat: 24, thisMonthOnly: false,
                        mark: (date) => { if (date.getDay() === 5) return "highlight-date"; },
                        // disabled dates
                        disabledDates: (date) => {
                            const disabled = { 2: true }
                            return disabled[date.getDay()];
                        },
                    }
                },
                { width: 100, id: "calculate_by", header: [{ text: "Cách tính", align: "center" }], type: "text", align: "center" },
                {
                    width: 100, id: "status", header: [{ text: "Trạng thái" }], editorType: "combobox", editorConfig: {
                        template: ({ value }) => getOptionsTemplate(value)
                    },
                    options: result.statusOptions,
                    template: (value) => getOptionsTemplate(value),
                    htmlEnable: true
                },

                // { width: 100, id: "status", header: [{ text: "Trạng thái", align: "center" }], type: "text", align: "center", editable: false },
                { id: "description", header: [{ text: "Mô tả", align: "center" }], type: "text", align: "center" },
                {
                    width: 150, id: "action", gravity: 1.5, header: [{ text: "Actions", align: "center" }], htmlEnable: true, align: "center",
                    template: function () {
                        return "<span class='action-buttons'><a class='btn btn-warning md-edit-button'>Lưu</a><a class='btn btn-danger md-remove-button'>Xóa</a></span>";
                    }
                }
            ],
            editable: true,
            autoWidth: true,
            resizable: true,
            selection: "row",
            multiselection: true,
            align: "center",
            eventHandlers: {
                onclick: {
                    "md-remove-button": function (e, dataR) {
                        console.log(`md data: ${JSON.stringify(dataR.row)}`);
                        if (dataR.row.promotion_id == 'new') {
                            dhx.alert({ header: "Thông báo", text: "Đây là dòng dữ liệu trống, vui lòng chọn lại", buttonsAlignment: "center", });
                        } else {

                            getAjaxData2(function (data) {

                                var result = JSON.parse(data)
                                var css = 'dhx_message--error'
                                if (result.status) {
                                    css = 'dhx_message--success'
                                    promotionGrid.data.remove(dataR.row.id)
                                }
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-delete-empty-outline", css: css, expire: 5000 })

                            }, "deletePromotion", dataR.row)
                        }

                    },
                    "md-edit-button": function (e, data) {

                        console.log(`md data: ${JSON.stringify(data.row)}`);
                        if (!data.row.promotion_id == 'new') {
                            dhx.alert({ header: "Thông báo", text: "Bạn đang chọn dòng dữ liệu trống", buttonsAlignment: "center", });
                        } else if (!data.row.promotion_type) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Loại KM không được trống", buttonsAlignment: "center", });
                        } else if (!data.row.promotion_code) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Khuyến Mãi không được trống", buttonsAlignment: "center", });
                        } else if (!data.row.parameter) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Tham Số không được trống", buttonsAlignment: "center", });
                        } else if (!data.row.start_date) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Từ Ngày không được trống", buttonsAlignment: "center", });
                        } else if (!data.row.end_date) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Đến Ngày không được trống", buttonsAlignment: "center", });
                        } else if (!data.row.calculate_by) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Cách Tính không được trống", buttonsAlignment: "center", });
                        } else {

                            getAjaxData2(function (data) {

                                var result = JSON.parse(data);
                                let css = (result.status == true) ? 'dhx_message--success' : 'dhx_message--error';
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-square-edit-outline", css: css, expire: 5000 });

                                if (result.status) {
                                    promotion();
                                }
                                // // đợi 4s sau đó load lại trang
                                // setTimeout(function () {
                                //     location.reload();
                                // }, 4000)
                            }, "savePromotion", data.row);
                        }

                    },
                },
            },
            data: result.data
        });

        promotionGrid.selection.enable();

        promotionGrid.events.on("afterEditEnd", function (value, row, column) { });

        /*  layout -------------------------------------------------------------------------------------- */
        promotionLayout = new dhx.Layout(null, {
            type: "line",
            cols: [
                {
                    rows: [
                        { id: "toolbar", height: "content" },
                        { type: "space", rows: [{ id: "grid" }] }
                    ],
                },
            ],
        });

        // attaching widgets to Layout cells
        promotionLayout.getCell("toolbar").attach(promotionToolbar);
        promotionLayout.getCell("grid").attach(promotionGrid);


        promotionWindow.attach(promotionLayout);
        promotionWindow.setFullScreen();
        promotionWindow.show();

    }, "promotion")

}

function size() {

    getAjaxData2(function (data) {

        var result = JSON.parse(data)

        /*  window -------------------------------------------------------------------------------------- */
        sizeWindow = new dhx.Window({ width: 848, height: 620, closable: true, movable: true, modal: true, title: "Kích cỡ (Size)", })

        /*  toolbar-------------------------------------------------------------------------------------- */
        var structure = [
            { type: "button", view: "flat", color: "primary", circle: true, icon: "mdi mdi-menu" },
            { id: "dashboard", value: "Dashboard", icon: "mdi mdi-view-dashboard", group: "page", twoState: true, active: true },
            { type: "spacer" },
            { id: "detail-save", type: "button", circle: true, value: "Lưu tất cả", size: "small", icon: "mdi mdi-content-save-all", full: true },
            { id: "settings2", icon: "mdi mdi-cog", type: "button", view: "link", color: "secondary", circle: true },
            { type: "text", icon: "mdi mdi-help-circle", value: "Hướng dẫn", tooltip: "Chức năng:: Lưu tất cả các sản phẩm đã sửa." },
        ]

        // Toolbar initialization
        sizeToolbar = new dhx.Toolbar(null, {})

        // loading structure into Toolbar
        sizeToolbar.data.parse(structure)

        sizeToolbar.events.on("click", function (id, e) {
            dhx.alert({ header: "Thông báo", text: "Chức năng chưa được hỗ trợ", buttonsAlignment: "center", })
        })

        /*  grid-------------------------------------------------------------------------------------- */
        sizeGrid = new dhx.Grid(null, {
            css: "dhx_demo-grid",
            columns: [
                { width: 150, id: "size", header: [{ text: "Kích cỡ", align: "center" }], align: "center" },
                { id: "description", header: [{ text: "Mô tả", align: "center" }], type: "text", align: "center" },
                {
                    width: 150, id: "action", gravity: 1.5, header: [{ text: "Actions", align: "center" }], htmlEnable: true, align: "center",
                    template: function () {
                        return "<span class='action-buttons'><a class='btn btn-warning md-edit-button'>Lưu</a><a class='btn btn-danger md-remove-button'>Xóa</a></span>";
                    }
                }
            ],
            editable: true,
            autoWidth: true,
            resizable: true,
            selection: "row",
            multiselection: true,
            align: "center",
            eventHandlers: {
                onclick: {
                    "md-remove-button": function (e, dataR) {
                        console.log(`md data: ${JSON.stringify(dataR.row)}`)
                        if (!dataR.row.size) {
                            dhx.alert({ header: "Thông báo", text: "Đây là dòng dữ liệu trống, vui lòng chọn lại", buttonsAlignment: "center", })
                        } else {
                            getAjaxData2(function (data) {

                                var result = JSON.parse(data)
                                var css = 'dhx_message--error'
                                if (result.status) {
                                    css = 'dhx_message--success'
                                    sizeGrid.data.remove(dataR.row.id)
                                }
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-delete-empty-outline", css: css, expire: 5000 })

                            }, "deleteSize", dataR.row)
                        }

                    },
                    "md-edit-button": function (e, data) {

                        console.log(`md data: ${JSON.stringify(data.row)}`)
                        if (!data.row.size) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Kích cỡ không được trống", buttonsAlignment: "center", })
                        } else if (!data.row.description) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Mô tả không được trống", buttonsAlignment: "center", })
                        } else {

                            getAjaxData2(function (data) {

                                var result = JSON.parse(data);
                                let css = (result.status == true) ? 'dhx_message--success' : 'dhx_message--error'
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-square-edit-outline", css: css, expire: 5000 });

                                if (result.status)
                                    size();
                                // // đợi 4s sau đó load lại trang
                                // setTimeout(function () {
                                //     location.reload();
                                // }, 4000)
                            }, "saveSize", data.row)
                        }

                    },
                },
            },
            data: result.data
        });

        sizeGrid.selection.enable();

        sizeGrid.events.on("afterEditEnd", function (value, row, column) { });

        /*  layout -------------------------------------------------------------------------------------- */
        sizeLayout = new dhx.Layout(null, {
            type: "line",
            cols: [
                {
                    rows: [
                        { id: "toolbar", height: "content" },
                        { type: "space", rows: [{ id: "grid" }] }
                    ],
                },
            ],
        });

        // attaching widgets to Layout cells
        sizeLayout.getCell("toolbar").attach(sizeToolbar);
        sizeLayout.getCell("grid").attach(sizeGrid);


        sizeWindow.attach(sizeLayout);
        // sizeWindow.setFullScreen();
        sizeWindow.show();

    }, "size")

}

function unit() {

    getAjaxData2(function (data) {

        var result = JSON.parse(data)

        /*  window -------------------------------------------------------------------------------------- */
        unitWindow = new dhx.Window({ width: 948, height: 620, closable: true, movable: true, modal: true, title: "Khuyến mãi", })

        /*  toolbar-------------------------------------------------------------------------------------- */
        var structure = [
            { type: "button", view: "flat", color: "primary", circle: true, icon: "mdi mdi-menu" },
            { id: "dashboard", value: "Dashboard", icon: "mdi mdi-view-dashboard", group: "page", twoState: true, active: true },
            { type: "spacer" },
            { id: "detail-save", type: "button", circle: true, value: "Lưu tất cả", size: "small", icon: "mdi mdi-content-save-all", full: true },
            { id: "settings2", icon: "mdi mdi-cog", type: "button", view: "link", color: "secondary", circle: true },
            { type: "text", icon: "mdi mdi-help-circle", value: "Hướng dẫn", tooltip: "Chức năng:: Lưu tất cả các sản phẩm đã sửa." },
        ]

        // Toolbar initialization
        unitToolbar = new dhx.Toolbar(null, {})

        // loading structure into Toolbar
        unitToolbar.data.parse(structure)

        unitToolbar.events.on("click", function (id, e) {
            dhx.alert({ header: "Thông báo", text: "Chức năng chưa được hỗ trợ", buttonsAlignment: "center", })
        })

        /*  grid-------------------------------------------------------------------------------------- */
        unitGrid = new dhx.Grid(null, {
            css: "dhx_demo-grid",
            columns: [
                { width: 120, id: "unit_id", header: [{ text: "Mã Đơn vị", align: "center" }], align: "center", editable: false },
                { id: "unit_name", header: [{ text: "Tên Đơn vị", align: "center" }], type: "text", align: "center" },
                { width: 250, id: "description", header: [{ text: "Mô tả", align: "center" }], type: "text", align: "left" },
                {
                    width: 150, id: "action", gravity: 1.5, header: [{ text: "Actions", align: "center" }], htmlEnable: true, align: "center",
                    template: function () {
                        return "<span class='action-buttons'><a class='btn btn-warning md-edit-button'>Lưu</a><a class='btn btn-danger md-remove-button'>Xóa</a></span>";
                    }
                }
            ],
            editable: true,
            autoWidth: true,
            resizable: true,
            selection: "row",
            multiselection: true,
            align: "center",
            eventHandlers: {
                onclick: {
                    "md-remove-button": function (e, dataR) {
                        console.log(`md data: ${JSON.stringify(dataR.row)}`);
                        if (dataR.row.unit_id == 'new') {
                            dhx.alert({ header: "Thông báo", text: "Đây là dòng dữ liệu trống, vui lòng chọn lại", buttonsAlignment: "center", });
                        } else {

                            getAjaxData2(function (data) {

                                var result = JSON.parse(data)
                                var css = 'dhx_message--error'
                                if (result.status) {
                                    css = 'dhx_message--success'
                                    unitGrid.data.remove(dataR.row.id)
                                }
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-delete-empty-outline", css: css, expire: 5000 })

                            }, "deleteUnit", dataR.row)
                        }

                    },
                    "md-edit-button": function (e, data) {
                        console.log(`md data: ${JSON.stringify(data.row)}`);
                        if (!data.row.unit_id == 'new') {
                            dhx.alert({ header: "Thông báo", text: "Bạn đang chọn dòng dữ liệu trống", buttonsAlignment: "center", });
                        } else if (!data.row.unit_name) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Tên Đơn Vị không được trống", buttonsAlignment: "center", });
                        } else if (!data.row.description) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Mô Tả không được trống", buttonsAlignment: "center", });
                        } else {
                            getAjaxData2(function (data) {

                                var result = JSON.parse(data);
                                let css = (result.status == true) ? 'dhx_message--success' : 'dhx_message--error';
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-square-edit-outline", css: css, expire: 5000 });

                                if (result.status)
                                    unit();
                                // // đợi 4s sau đó load lại trang
                                // setTimeout(function () {
                                //     location.reload();
                                // }, 4000)
                            }, "saveUnit", data.row);
                        }

                    },
                },
            },
            data: result.data
        });

        unitGrid.selection.enable();

        unitGrid.events.on("afterEditEnd", function (value, row, column) { });

        /*  layout -------------------------------------------------------------------------------------- */
        unitLayout = new dhx.Layout(null, {
            type: "line",
            cols: [
                {
                    rows: [
                        { id: "toolbar", height: "content" },
                        { type: "space", rows: [{ id: "grid" }] }
                    ],
                },
            ],
        });

        // attaching widgets to Layout cells
        unitLayout.getCell("toolbar").attach(unitToolbar);
        unitLayout.getCell("grid").attach(unitGrid);


        unitWindow.attach(unitLayout);
        // unitWindow.setFullScreen();
        unitWindow.show();

    }, "unit")

}

function sizeUnit() {

    getAjaxData2(function (data) {

        var result = JSON.parse(data)

        /*  window -------------------------------------------------------------------------------------- */
        sizeUnitWindow = new dhx.Window({ width: 948, height: 620, closable: true, movable: true, modal: true, title: "Khuyến mãi", })

        /*  toolbar-------------------------------------------------------------------------------------- */
        var structure = [
            { type: "button", view: "flat", color: "primary", circle: true, icon: "mdi mdi-menu" },
            { id: "dashboard", value: "Dashboard", icon: "mdi mdi-view-dashboard", group: "page", twoState: true, active: true },
            { type: "spacer" },
            { id: "detail-save", type: "button", circle: true, value: "Lưu tất cả", size: "small", icon: "mdi mdi-content-save-all", full: true },
            { id: "settings2", icon: "mdi mdi-cog", type: "button", view: "link", color: "secondary", circle: true },
            { type: "text", icon: "mdi mdi-help-circle", value: "Hướng dẫn", tooltip: "Chức năng:: Lưu tất cả các sản phẩm đã sửa." },
        ]

        // Toolbar initialization
        sizeUnitToolbar = new dhx.Toolbar(null, {})

        // loading structure into Toolbar
        sizeUnitToolbar.data.parse(structure)

        sizeUnitToolbar.events.on("click", function (id, e) {
            dhx.alert({ header: "Thông báo", text: "Chức năng chưa được hỗ trợ", buttonsAlignment: "center", })
        })

        /*  grid-------------------------------------------------------------------------------------- */
        sizeUnitGrid = new dhx.Grid(null, {
            css: "dhx_demo-grid",
            columns: [
                { width: 100, id: "unit", header: [{ text: "Đơn vị", align: "center" }], type: "text", align: "center" },
                { width: 120, id: "size", header: [{ text: "Kích cỡ", align: "center" }], align: "center", editable: false },
                { width: 250, id: "size_unit_code", header: [{ text: "Đơn vị: Kích cỡ", align: "center" }], type: "text", align: "center" },
                { id: "description", header: [{ text: "Mô tả", align: "center" }], type: "text", align: "left" }
            ],
            editable: true,
            autoWidth: true,
            resizable: true,
            selection: "row",
            multiselection: true,
            align: "center",
            data: result.data
        });

        sizeUnitGrid.selection.enable();

        /*  layout -------------------------------------------------------------------------------------- */
        sizeUnitLayout = new dhx.Layout(null, {
            type: "line",
            cols: [
                {
                    rows: [
                        { id: "toolbar", height: "content" },
                        { type: "space", rows: [{ id: "grid" }] }
                    ],
                },
            ],
        });

        // attaching widgets to Layout cells
        sizeUnitLayout.getCell("toolbar").attach(sizeUnitToolbar);
        sizeUnitLayout.getCell("grid").attach(sizeUnitGrid);


        sizeUnitWindow.attach(sizeUnitLayout);
        // sizeUnitWindow.setFullScreen();
        sizeUnitWindow.show();

    }, "sizeUnit");

}

function transaction() {

    getAjaxData2(function (data) {

        var result = JSON.parse(data)

        /*  window -------------------------------------------------------------------------------------- */
        transWindow = new dhx.Window({ width: 1548, height: 620, closable: true, movable: true, modal: true, title: "Giao dịch", })

        /*  toolbar-------------------------------------------------------------------------------------- */
        var structure = [
            { type: "button", view: "flat", color: "primary", circle: true, icon: "mdi mdi-menu" },
            { id: "dashboard", value: "Dashboard", icon: "mdi mdi-view-dashboard", group: "page", twoState: true, active: true },
            { type: "spacer" },
            { id: "detail-save", type: "button", circle: true, value: "Lưu tất cả", size: "small", icon: "mdi mdi-content-save-all", full: true },
            { id: "settings2", icon: "mdi mdi-cog", type: "button", view: "link", color: "secondary", circle: true },
            { type: "text", icon: "mdi mdi-help-circle", value: "Hướng dẫn", tooltip: "Chức năng:: Lưu tất cả các sản phẩm đã sửa." },
        ]

        // Toolbar initialization
        transToolbar = new dhx.Toolbar(null, {})

        // loading structure into Toolbar
        transToolbar.data.parse(structure)

        transToolbar.events.on("click", function (id, e) {
            dhx.alert({ header: "Thông báo", text: "Chức năng chưa được hỗ trợ", buttonsAlignment: "center", })
        })

        /*  grid-------------------------------------------------------------------------------------- */
        transGrid = new dhx.Grid(null, {
            css: "dhx_demo-grid",
            columns: [
                { width: 120, id: "trans_id", header: [{ text: "Mã Giao dịch", align: "center" }], align: "center", editable: false },
                {
                    width: 120, id: "trans_type", header: [{ text: "Loại giao dịch" }], editorType: "combobox", editorConfig: {
                        template: ({ value }) => getOptionsTemplate(value)
                    },
                    options: result.transTypeOptions,
                    template: (value) => getOptionsTemplate(value),
                    htmlEnable: true
                },
                { id: "trans_name", header: [{ text: "Tên Giao dịch", align: "center" }], type: "text", align: "center" },
                // // {
                // //     width: 200, id: "trans_name", header: [{ text: "Tên Giao dịch" }], type: "text", editorType: "combobox", editorConfig: {
                // //         template: ({ value }) => getOptionsTemplate(value)
                // //     },
                // //     options: result.transNameOptions,
                // //     template: (value) => getOptionsTemplate(value),
                // //     htmlEnable: true
                // // },
                {
                    width: 200, id: "trans_form", header: [{ text: "Hình thức thanh toán" }], editorType: "combobox", editorConfig: {
                        template: ({ value }) => getOptionsTemplate(value)
                    },
                    options: result.transFormOptions,
                    template: (value) => getOptionsTemplate(value),
                    htmlEnable: true
                },
                { id: "trans_money", header: [{ text: "Số tiền", align: "center" }], type: "number", format: "#,#", align: "center" },
                {
                    width: 120, id: "status", header: [{ text: "Trạng thái" }], editorType: "combobox", editorConfig: {
                        template: ({ value }) => getOptionsTemplate(value)
                    },
                    options: result.transStatusOptions,
                    template: (value) => getOptionsTemplate(value),
                    htmlEnable: true
                },
                { width: 300, id: "description", header: [{ text: "Mô tả", align: "center" }], type: "text", align: "left" },
                {
                    width: 150, id: "action", gravity: 1.5, header: [{ text: "Actions", align: "center" }], htmlEnable: true, align: "center",
                    template: function () {
                        return "<span class='action-buttons'><a class='btn btn-warning md-edit-button'>Lưu</a><a class='btn btn-danger md-remove-button'>Xóa</a></span>";
                    }
                }
            ],
            editable: true,
            autoWidth: true,
            resizable: true,
            selection: "row",
            multiselection: true,
            align: "center",
            eventHandlers: {
                onclick: {
                    "md-remove-button": function (e, dataR) {
                        console.log(`md data: ${JSON.stringify(dataR.row)}`);
                        if (dataR.row.trans_id == 'new') {
                            dhx.alert({ header: "Thông báo", text: "Đây là dòng dữ liệu trống, vui lòng chọn lại", buttonsAlignment: "center", });
                        } else {

                            getAjaxData2(function (data) {

                                var result = JSON.parse(data)
                                var css = 'dhx_message--error'
                                if (result.status) {
                                    css = 'dhx_message--success'
                                    transGrid.data.remove(dataR.row.id)
                                }
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-delete-empty-outline", css: css, expire: 5000 })

                            }, "deleteTransaction", dataR.row)
                        }

                    },
                    "md-edit-button": function (e, data) {
                        console.log(`md data: ${JSON.stringify(data.row)}`);
                        if (!data.row.trans_id == 'new') {
                            dhx.alert({ header: "Thông báo", text: "Bạn đang chọn dòng dữ liệu trống", buttonsAlignment: "center", });
                        } else if (!data.row.trans_type) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Loại Giao Dịch không được trống", buttonsAlignment: "center", });
                        } else if (!data.row.trans_name) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Tên Giao Dịch không được trống", buttonsAlignment: "center", });
                        } else if (!data.row.trans_form) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Hình Thức Thanh Toán không được trống", buttonsAlignment: "center", });
                        } else if (!data.row.trans_money) {
                            dhx.alert({ header: "Thông báo", text: "Dữ liệu: Số Tiền không được trống", buttonsAlignment: "center", });
                        } else {

                            let trans_form = "Hình Thức Giao Dịch đang chọn là " + data.row.trans_form;
                            dhx.message({ node: "message_container", text: trans_form, icon: "mdi mdi-square-edit-outline", expire: 3000 });

                            getAjaxData2(function (data) {

                                var result = JSON.parse(data);
                                let css = (result.status == true) ? 'dhx_message--success' : 'dhx_message--error';
                                // creating DHTMLX Message 
                                dhx.message({ node: "message_container", text: result.message, icon: "mdi mdi-square-edit-outline", css: css, expire: 5000 });

                                if (result.status)
                                    transaction();
                                // // đợi 4s sau đó load lại trang
                                // setTimeout(function () {
                                //     location.reload();
                                // }, 4000)
                            }, "saveTransaction", data.row);
                        }

                    },
                },
            },
            data: result.data
        });

        transGrid.selection.enable();

        // edit events
        transGrid.events.on("afterEditEnd", function (value, row, column) {

            // console.log('Đang cập nhật dữ liệu chung ... ');
            var trans_money = row.trans_money
            if (trans_money) {
                if (!isNumber(trans_money)) {
                    dhx.alert({ header: "Cập nhậ Đơn hàng", text: "Vui nhập Số tiền kiểu số", buttonsAlignment: "center", buttons: ["Đồng ý"] });
                    // dhx.alert({ header: "Cập nhậ Đơn hàng", text: "Vui nhập nhập kiểu số", buttonsAlignment: "center", buttons: ["Đồng ý"] });
                    row.trans_money = 0
                } else {
                    // trường hợp nhập số tiền đơn vị là 1000 đồng
                    if (trans_money.toString().length >= 1 && trans_money.toString().length <= 3) {
                        trans_money = trans_money * 1000
                        row.trans_money = trans_money
                    }

                }
            }


        });

        /*  layout -------------------------------------------------------------------------------------- */
        transLayout = new dhx.Layout(null, {
            type: "line",
            cols: [
                {
                    rows: [
                        { id: "toolbar", height: "content" },
                        { type: "space", rows: [{ id: "grid" }] }
                    ],
                },
            ],
        });

        // attaching widgets to Layout cells
        transLayout.getCell("toolbar").attach(transToolbar);
        transLayout.getCell("grid").attach(transGrid);


        transWindow.attach(transLayout);
        // transWindow.setFullScreen();
        transWindow.show();

    }, "transaction")

}



function reports() {

    getAjaxData2(function (data) {

        var result = JSON.parse(data)

        /*  window -------------------------------------------------------------------------------------- */
        reportsWindow = new dhx.Window({ width: 1548, height: 620, closable: true, movable: true, modal: true, title: "Báo cáo", })

        /*  toolbar-------------------------------------------------------------------------------------- */
        var structure = [
            { type: "button", view: "flat", color: "primary", circle: true, icon: "mdi mdi-menu" },
            { id: "dashboard", value: "Các chức năng", icon: "mdi mdi-view-dashboard", group: "page", twoState: true, active: true },
            { type: "spacer" },
            { id: "from_date_label", value: "Từ ngày" },
            {
                id: 'from_date',
                type: "datePicker",
                value: new Date(),
                editable: true,
                // marked dates
                mark: (date) => {
                    if (date.getDay() === 5) return "highlight-date";
                },
                // disabled dates
                disabledDates: (date) => {
                    const disabled = { 2: true }
                    return disabled[date.getDay()];
                },
                weekStart: "monday", // "saturday" | "sunday" | "monday"
                weekNumbers: false,
                mode: "calendar", // "calendar" | "year" | "month" | "timepicker"
                timePicker: false,
                timeFormat: 24, // 24 | 12
                thisMonthOnly: false,
            },
            { id: "to_date_label", value: "đến" },
            {
                id: 'report_date',
                type: "datePicker",
                value: new Date(),
                editable: true,
                // marked dates
                mark: (date) => {
                    if (date.getDay() === 5) return "highlight-date";
                },
                // disabled dates
                disabledDates: (date) => {
                    const disabled = { 2: true }
                    return disabled[date.getDay()];
                },
                weekStart: "monday", // "saturday" | "sunday" | "monday"
                weekNumbers: false,
                mode: "calendar", // "calendar" | "year" | "month" | "timepicker"
                timePicker: false,
                timeFormat: 24, // 24 | 12
                thisMonthOnly: false,
            },
            { id: "search-distance", type: "button", circle: true, value: "Lấy dữ liệu", size: "small", icon: "mdi mdi-map-marker-distance", full: true, tooltip: "Lấy dữ liệu từ khoảng cách các ngày đã chọn" },
            {
                id: "language", value: "Chọn báo cáo", circle: true, full: true, icon: "mdi mdi-finance",
                items: [
                    { id: "daily", value: "Ngày" },
                    { id: "weekly", value: "Tuần" },
                    { id: "monthly", value: "Tháng" },
                    { id: "yearly", value: "Năm dương lịch" }
                ]
            },
            { id: "settings2", icon: "mdi mdi-cog", type: "button", view: "link", color: "secondary", circle: true },
            { type: "text", icon: "mdi mdi-help-circle", value: "Hướng dẫn", tooltip: "Chức năng:: Lưu tất cả các sản phẩm đã sửa." },
        ]

        // Toolbar initialization
        reportsToolbar = new dhx.Toolbar(null, {})

        // loading structure into Toolbar
        reportsToolbar.data.parse(structure)

        reportsToolbar.events.on("click", function (id, e) {
            dhx.alert({ header: "Thông báo", text: "Chức năng chưa được hỗ trợ", buttonsAlignment: "center", })
        })

        /*  html -------------------------------------------------------------------------------------- */
        var html = result.html

        /*  layout -------------------------------------------------------------------------------------- */
        reportsLayout = new dhx.Layout(null, {
            type: "line",
            rows: [
                { id: "toolbar", html: "Header", height: "60px" },
                { id: "items", html: "Items", height: "270px" },
                {
                    cols: [
                        { id: "treemap-chart", html: "Chart 1" },
                        // { id: "bestsales", html: "Chart 2" },
                        { id: "donut-chart", html: "Chart 3", width: "500px" },
                    ]
                },

            ]
        });

        /* chart tree map -------------------------------------------------------------------------------------- */
        const treeMapData = [
            {
                "food": "Mercury",
                "radius": "40"
            },
            {
                "food": "Venus",
                "radius": "52"
            },
            {
                "food": "Earth",
                "radius": "71"
            },
            {
                "food": "Mars",
                "radius": "90"
            },
            {
                "food": "Jupiter",
                "radius": "611"
            },
            {
                "food": "Saturn",
                "radius": "232"
            },
            {
                "food": "Uranus",
                "radius": "62"
            },
            {
                "food": "Neptune",
                "radius": "22"
            }
        ]

        const treeConfig = {
            type: "treeMap",
            css: "dhx_widget--bg_white dhx_widget--bordered",
            series: [
                {
                    value: "radius",
                    text: "food",
                    stroke: "#eeeeee",
                    strokeWidth: 1,
                    tooltipTemplate: item => `${item[1]} - ${item[0]}`,
                }
            ],
            legend: {
                type: "range",
                treeSeries: [
                    // setting the color for each value range, related tiles and legend
                    { greater: 300, color: "#16AAAA" },
                    { from: 250, to: 300, color: "#B4FAED" },
                    { from: 200, to: 250, color: "#F28587" },
                    { from: 150, to: 200, color: "#F7F172" },
                    { from: 100, to: 150, color: "#463BAC" },
                    { from: 50, to: 100, color: "#D9BB41" },
                    { from: 10, to: 50, color: "#ECBDBF" },
                    { less: 10, color: "A01D1E" },
                ],
                halign: "right",
                valign: "top",
                direction: "row",
                size: 50,
            },
            data: treeMapData
        };

        treeChart = new dhx.Chart(null, treeConfig);

        /* chart pie donut -------------------------------------------------------------------------------------- */
        const pieData = [
            { id: "Thu", value: 34.25, color: "#9A8BA5", type: "Thu" },
            { id: "Chi", value: 24.65, color: "#E3C5D5", type: "Chi" }
        ];
        const donutConfig = {
            type: "donut",
            css: "dhx_widget--bg_white dhx_widget--bordered",
            series: [
                {
                    value: "value",
                    color: "color",
                    text: "type"
                }
            ],
            legend: {
                values: {
                    text: "id",
                    color: "color"
                },
                halign: "right",
                valign: "top"
            }
        };

        donutChart = new dhx.Chart("chart", donutConfig);
        donutChart.data.parse(pieData);


        // attaching widgets to Layout cells
        reportsLayout.getCell("toolbar").attach(reportsToolbar);

        // const html = "<p>Hello world</p>";
        reportsLayout.getCell("items").attachHTML(html);
        reportsLayout.getCell("treemap-chart").attach(treeChart);
        reportsLayout.getCell("donut-chart").attach(donutChart);


        reportsWindow.attach(reportsLayout);
        reportsWindow.setFullScreen();
        reportsWindow.show();

    }, "reports")

}








/* -------------------------------------------------------------------------------------------------------------------------------------------
    |
    | jQuery
    |
*/

function getWindowData(callBack) {
    $.ajax("getDataToAddForm")
        .done(function (data) {
            callBack(data);
            console.log(data);
        })
        .fail(function () {
            alert("Không lấy được dữ liệu từ hệ thống!!");
        })
        .always(function () {
            console.log("Done!!");
        });
}

function getAjaxData(callBack, url) {
    $.ajax(url)
        .done(function (data) {
            callBack(data);
            // console.log(data);
        })
        .fail(function () {
            alert("Không lấy được dữ liệu từ hệ thống??");
        })
        .always(function () {
            console.log("Done!!");
        });
}

function getAjaxData2(callBack, url, objData = null) {

    $.ajax({ method: "POST", url: url, data: { data: JSON.stringify(objData) } })
        .done(function (data) {
            callBack(data);
            // console.log(data);
        })
        .fail(function () {
            alert("Không lấy được dữ liệu từ hệ thống ");
        })
        .always(function () {
            console.log("Done!!");
        });

}


/* -------------------------------------------------------------------------------------------------------------------------------------------
    |
    | running
    |
*/

// layout()
toolbar();
// grid()
orderGrid();

// area
$("#area").on("click", function () {
    area();
});

// table
$("#table-order").on("click", function () {
    tableOrder();
});

// food
$("#food").on("click", function () {
    food();
});


// promotion
$("#promotion").on("click", function () {
    promotion();
});


// size
$("#size").on("click", function () {
    size();
});

// unit
$("#unit").on("click", function () {
    unit();
});

// unit
$("#size-unit").on("click", function () {
    sizeUnit();
});

// money
$("#transaction").on("click", function () {
    transaction();
});

// reports
$("#reports").on("click", function () {
    reports();
});