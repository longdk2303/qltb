<?php
$title = "Danh mục sản phẩm";
$header = "
    <script src='https://cdn.datatables.net/2.1.7/js/dataTables.min.js'></script>
    <link rel='stylesheet' href='https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css'>
";
$script = "
";

$categories = $db->fetch_assoc("SELECT * from `categories`", 0);
include_once(__DIR__ . "/../header.php");
?>
<div class="row">
    <!-- [ sample-page ] start -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>
                <i class="ti ti-device-desktop-analytics"></i>
                <b>Danh mục sản phẩm</b>
            </h4>
            <button type="button" class="btn btn-success btn-addnew"><i class="ti ti-circle-plus"></i>Thêm
                mới</button>
        </div>
        <div class="card-body">
            <div class="dt-responsive table-responsive overflow-x-scroll">
                <table id="listKh" class="table table-striped" style="width:100%; white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>Tên danh mục</th>
                            <th width="90">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($categories as $item) { ?>
                        <tr>
                            <td><?= $item['name'] ?></td>
                            <td class="text-end"><a href="javascript: void(0)"
                                    class="btn btn-info btn-sm btn-edit-category" data-id="<?= $item['id'] ?>"
                                    data-name="<?= $item['name'] ?>">Sửa</a>
                                <a href="javascript: void(0)" class="btn btn-danger btn-sm btn-delete-category"
                                    data-id="<?= $item['id'] ?>">Xóa</a>
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
                <input type="hidden" id="txtId">
                <div class="mb-3">
                    <label for="txtName" class="form-label"><b>Tên Danh Mục</b></label>
                    <input type="text" class="form-control" placeholder="Nhập tên danh mục..." id="txtName">
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
<!-- end modal -->
<!-- modal add new-->
<div class="modal fade" id="addCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm mới</h5>
                <a href="javascript:;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="txtAddName" class="form-label"><b>Tên danh mục</b></label>
                    <input type="text" class="form-control" placeholder="Nhập tên danh mục..." id="txtAddName">
                </div>
                <div class="text-center">
                    <span id="add-status" class="text-danger "></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger closed-btn" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-success btn-add" data-bs-dismiss="modal">Thêm</button>
            </div>
        </div>
    </div>
</div>

<!-- end modal -->
<script>
$(document).on('click', '.btn-edit-category', function() {
    var id = $(this).data('id');
    $('.modal-detail-title').text("Cập nhật mã danh mục: " + id);
    $('#txtId').val(id);
    $('#txtName').val($(this).data('name'));
    $('#editCategory').modal('show');
});

$('.btn-update').on('click', function() {
    var name = $('#txtName').val();

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
        url: '<?= BASE_URL("/ajaxs/admin/order?submit=updateCategory") ?>',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            id: $('#txtId').val(),
            name: name
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

$(document).on('click', '.btn-addnew', function() {
    $('#addCategory').modal('show');
});

$('.btn-add').on('click', function() {
    var name = $('#txtAddName').val();

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
        url: '<?= BASE_URL("/ajaxs/admin/order?submit=addCategory") ?>',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            name: name
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

$('.btn-delete-category').on('click', function() {
    var id = $(this).data('id');
    Swal.fire({
        title: 'Các sản phẩm trong danh mục này sẽ bị xóa',
        text: "Bạn có chắc muốn xóa không?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Đồng ý!',
        cancelButtonText: 'Không, quay lại'
    }).then((result) => {
        if (result.isConfirmed) {
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
                url: '<?= BASE_URL("/ajaxs/admin/order?submit=deleteCategory") ?>',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    id: id
                }),
                success: function(data) {
                    data = JSON.parse(data)
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