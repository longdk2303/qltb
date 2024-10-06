<?php
$title = "Sản phẩm đã thuê";
$header = "
    <script src='https://cdn.datatables.net/2.1.7/js/dataTables.min.js'></script>
    <link rel='stylesheet' href='https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css'>
";
$script = "
";

$history = $db->fetch_assoc("SELECT rental_requests.*, products.name as pname FROM `rental_requests`
                            INNER JOIN products ON products.id = rental_requests.product_id
                             where `user_id` ='" . $User_data['id'] . "'", 0);
include_once(__DIR__ . "/header.php");
?>
<div class="row">
    <!-- [ sample-page ] start -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>
                <i class="ti ti-device-desktop-analytics"></i>
                <b>Danh sách sản phẩm đã thuê</b>
            </h4>
        </div>
        <div class="card-body">
            <div class="dt-responsive table-responsive overflow-x-scroll">
                <table id="listKh" class="table table-striped" style="width:100%; white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Tổng thanh toán</th>
                            <th>Tình trạng đơn hàng</th>
                            <th>Trạng thái đơn</th>
                            <th>Địa chỉ nhận</th>
                            <th>Ngày thuê</th>
                            <th>Ngày trả</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($history as $item) { ?>
                            <tr>
                                <td><?= $item['pname'] ?></td>
                                <td><?= number_format($item['price']) ?></td>
                                <td><?= textStatus($item['status1']) ?></td>
                                <td><?= textStatus($item['status2']) ?></td>
                                <td style="max-width: 200px; overflow-x: scroll; scrollbar-width: none;">
                                    <?= $item['address'] ?></td>
                                <td><?= $item['start_date'] ?></td>
                                <td><?= $item['end_date'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>

                        </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>


<script>
    $(document).ready(function() {
        $('#listKh').DataTable({
            "language": {
                "sProcessing": "Đang xử lý...",
                "sLengthMenu": "Hiển thị _MENU_ mục",
                "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
                "sInfo": "Đang hiển thị _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty": "Đang hiển thị 0 đến 0 của 0 mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sInfoPostFix": "",
                "sSearch": "Tìm Kiếm:",
                "sUrl": "",
                "sEmptyTable": "Không có dữ liệu trong bảng",
                "sLoadingRecords": "Đang tải...",
                "sInfoThousands": ",",
                "oPaginate": {
                    "sFirst": "Đầu",
                    "sLast": "Cuối",
                    "sNext": "Tiếp",
                    "sPrevious": "Trước"
                },
                "oAria": {
                    "sSortAscending": ": Sắp xếp tăng dần",
                    "sSortDescending": ": Sắp xếp giảm dần"
                }
            }
        });
    });
</script>
<?php
include_once(__DIR__ . "/footer.php");
?>