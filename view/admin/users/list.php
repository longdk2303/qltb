<?php
$title = "Danh sách khách hàng";
$header = "
    <script src='https://cdn.datatables.net/2.1.7/js/dataTables.min.js'></script>
    <link rel='stylesheet' href='https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css'>
";
$script = "
";

$users = $db->fetch_assoc("SELECT * from `users` where role_id = '1'", 0);
include_once(__DIR__ . "/../header.php");
?>

<div class="row">
    <!-- [ sample-page ] start -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>
                <i class="ti ti-device-desktop-analytics"></i>
                <b>Danh sách khách hàng</b>
            </h4>
        </div>
        <div class="card-body">
            <div class="dt-responsive table-responsive overflow-x-scroll">
                <table id="listKh" class="table " style="width:100%; white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>Tài khoản</th>
                            <th>Email</th>
                            <th>Họ tên</th>
                            <th>Số điện thoại</th>
                            <th>Tình trạng</th>
                            <th>Ngày tạo</th>
                            <th width="90">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($users as $item) { ?>
                            <tr>
                                <td><?= $item['username'] ?></td>
                                <td><?= $item['email'] ?></td>
                                <td><?= $item['name'] ?></td>
                                <td><?= $item['phone'] ?></td>
                                <td> <?= textStatus($item['active']) ?></td>
                                <td><?= $item['created_at'] ?></td>
                                <td class="text-end"><a href="javascript: void(0)"
                                        class="btn btn-info btn-sm btn-edit-category" data-id="<?= $item['id'] ?>"
                                        data-username="<?= $item['username'] ?>" data-email="<?= $item['email'] ?>"
                                        data-phone="<?= $item['phone'] ?>" data-name="<?= $item['name'] ?>"
                                        data-active="<?= $item['active'] ?>">Sửa</a>
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
    <!-- [ sample-page ] end -->
</div>

<!-- modal -->
<div class="modal fade" id="editCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-detail-title"></h5>
                <a href="javascript:;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="txtId">
                    <div class="mb-3 col-md-6">
                        <label for="txtEditUsername" class="form-label"><b>Tài khoản</b></label>
                        <input type="text" class="form-control" readonly id="txtEditUsername">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="txtEmail" class="form-label"><b>Email</b></label>
                        <input type="email" class="form-control" placeholder="Nhập email..." id="txtEmail">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="txtName" class="form-label"><b>Họ tên</b></label>
                        <input type="text" class="form-control" placeholder="Họ tên..." id="txtName">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="txtPhone" class="form-label"><b>Số điện thoại</b></label>
                        <input type="number" class="form-control" placeholder="Nhập số điện thoại..." id="txtPhone">
                    </div>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="txtActive" class="form-label"><b>Tình trạng</b></label>
                    <select class="form-control" id="txtActive">
                        <option value="active">Hoạt động</option>
                        <option value="ban">Khóa</option>
                    </select>
                </div>
                <div class="text-center">
                    <span id="add-status" class="text-danger "></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger closed-btn" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-success btn-update" data-bs-dismiss="modal">Cập nhật</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->
<!-- modal add new-->

<!-- end modal -->
<script>
    $(document).on('click', '.btn-edit-category', function() {
        var id = $(this).data('id');
        $('.modal-detail-title').text("Cập nhật tài khoản: " + $(this).data('username'));
        $('#txtId').val(id);
        $('#txtEditUsername').val($(this).data('username'));
        $('#txtName').val($(this).data('name'));
        $('#txtEmail').val($(this).data('email'));
        $('#txtPhone').val($(this).data('phone'));
        $('#txtActive').val($(this).data('active')).change();
        $('#editCategory').modal('show');
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
            url: '<?= BASE_URL("/ajaxs/admin/order?submit=updateUser") ?>',
            type: 'POST',
            data: JSON.stringify({
                id: $('#txtId').val(),
                name: $('#txtName').val(),
                user: $('#txtEditUsername').val(),
                email: $('#txtEmail').val(),
                phone: $('#txtPhone').val(),
                active: $('#txtActive').val(),
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
include_once(__DIR__ . "/../footer.php");
?>