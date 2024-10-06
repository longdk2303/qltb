<?php
$title = "Bảng điều khiển";
$header = "
    <script src='https://cdn.datatables.net/2.1.7/js/dataTables.min.js'></script>
    <link rel='stylesheet' href='https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css'>
";
$script = "
";
include_once(__DIR__ . "/header.php");
$history = $db->fetch_assoc("SELECT rental_requests.*, products.name as pname, users.name as uname FROM `rental_requests`
                            INNER JOIN products ON products.id = rental_requests.product_id 
                            INNER JOIN users ON users.id = rental_requests.user_id ", 0);
?>

<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL("/") ?>">Đơn hàng</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- [ breadcrumb ] end -->

<div class="row">
    <!-- [ sample-page ] start -->
    <div class="card">
        <div class="card-header">
            <h4>
                <i class="ti ti-device-desktop-analytics"></i>
                <b>Danh sách đơn hàng</b>
            </h4>
        </div>
        <div class="card-body">
            <div class="card-body">
                <div class="dt-responsive table-responsive overflow-x-scroll">
                    <table id="listKh" class="table table-striped" style="width:100%; white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>Tên khách hàng</th>
                                <th>Tên sản phẩm</th>
                                <th>Tổng thanh toán</th>
                                <th>Tình trạng đơn hàng</th>
                                <th>Trạng thái đơn</th>
                                <th>Địa chỉ nhận</th>
                                <th>Ngày thuê</th>
                                <th>Ngày trả</th>
                                <th style="width: 90px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($history as $item) { ?>
                            <tr>
                                <td><?= $item['uname'] ?></td>
                                <td><?= $item['pname'] ?></td>
                                <td><?= number_format($item['price']) ?></td>
                                <td><?= textStatus($item['status1']) ?></td>
                                <td><?= textStatus($item['status2']) ?></td>
                                <td style="max-width: 200px; overflow-x: scroll; scrollbar-width: none;">
                                    <?= $item['address'] ?></td>
                                <td><?= $item['start_date'] ?></td>
                                <td><?= $item['end_date'] ?></td>
                                <td class="text-end"><a href="javascript: void(0)" class="btn btn-info btn-sm btn-edit"
                                        data-id="<?= $item['id'] ?>" data-status1="<?= $item['status1'] ?>"
                                        data-status2="<?= $item['status2'] ?>">Cập
                                        nhật</a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>

                            </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>

<div class="modal fade" id="editOrder" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-detail-title">Cập nhật đơn hàng</h5>
                <a href="javascript:;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtId">
                <div class="mb-3">
                    <label for="txtStatus1" class="form-label"><b>Tình trạng đơn hàng</b></label>
                    <select class="form-control" id="txtStatus1">
                        <option value="pending">Đang xử lý</option>
                        <option value="success">Đã duyệt</option>
                        <option value="refuse">Hủy</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="txtStatus2" class="form-label"><b>Trạng thái đơn hàng</b></label>
                    <select class="form-control" id="txtStatus2">
                        <option value="paid">Đã trả</option>
                        <option value="notpaid">Chưa trả</option>
                        <option value="expired" disabled>Quá hạn</option>
                    </select>
                </div>
                <div class="text-center">
                    <span id="pass-status" class="text-danger "></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger closed-btn" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-success btn-update" data-bs-dismiss="modal">Cập nhật</button>
            </div>
        </div>
    </div>
</div>
<script>
function setDisabled(id, b) {
    $(id).attr('disabled', b);
}

$(document).on('click', '.btn-edit', function() {
    var id = $(this).data('id');
    $('#txtId').val(id);
    $('#txtStatus1').val($(this).data('status1')).change();
    $('#txtStatus2').val($(this).data('status2')).change();

    const isStatus2Expired = $(this).data('status2') === "expired";
    const isStatus1NotSuccess = $(this).data('status1') !== 'success';
    const isStatus1Success = $(this).data('status1') === 'success';
    // Xác định trạng thái disabled cho #txtStatus2 và #txtStatus1
    setDisabled('#txtStatus2', isStatus2Expired || isStatus1NotSuccess);
    setDisabled('#txtStatus1', isStatus2Expired || isStatus1Success);

    $('#editOrder').modal('show');
});

$('.btn-update').on('click', function() {
    Swal.fire({
        title: 'Đang xử lý',
        text: 'Vui lòng đợi trong khi chúng tôi xử lý yêu cầu của bạn.',
        icon: 'info',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: '<?= BASE_URL("/ajaxs/admin/order?submit=update") ?>',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            id: $('#txtId').val(),
            status1: $('#txtStatus1').val(),
            status2: $('#txtStatus2').val(),
        }),
        success: function(data) {
            data = JSON.parse(data);
            if (data.error != 0) {
                Swal.fire({
                    icon: "error",
                    title: "Thất bại!",
                    text: data.message,
                    confirmButtonText: 'Thử lại'
                });
            } else {
                Swal.fire({
                    icon: "success",
                    title: "Thành công!",
                    text: data.message,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                title: 'Đã xảy ra lỗi!',
                text: error,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });

});

$(document).ready(function() {
    var table = $('#listKh').DataTable({
        language: {
            lengthMenu: "Hiển thị _MENU_ bản ghi",
            zeroRecords: "Không tìm thấy bản ghi nào",
            info: "Hiển thị từ _START_ đến _END_ trong tổng số _TOTAL_ bản ghi",
            infoEmpty: "Không có bản ghi nào",
            infoFiltered: "(Lọc từ _MAX_ tổng số bản ghi)",
            search: "Tìm kiếm:",
            paginate: {
                first: "Đầu tiên",
                last: "Cuối cùng",
                next: "Tiếp theo",
                previous: "Trước"
            }
        }
    });
});
</script>
<?php
include_once(__DIR__ . "/footer.php");
?>