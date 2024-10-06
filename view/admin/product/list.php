<?php
$title = "Danh sách sản phẩm";
$header = "
    <script src='https://cdn.datatables.net/2.1.7/js/dataTables.min.js'></script>
    <link rel='stylesheet' href='https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css'>
";
$script = "
";

$products = $db->fetch_assoc("SELECT products.*,categories.name as category_name from `products` INNER JOIN `categories` on categories.id = products.category_id", 0);
include_once(__DIR__ . "/../header.php");
?>
<style>
.img-cover {
    object-fit: cover;
    width: 100px;
    height: 100px;
}
</style>
<div class="row">
    <!-- [ sample-page ] start -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>
                <i class="ti ti-device-desktop-analytics"></i>
                <b>Danh sách sản phẩm</b>
            </h4>
            <button type="button" class="btn btn-success btn-addnew"><i class="ti ti-circle-plus"></i>Thêm
                mới</button>
        </div>
        <div class="card-body">
            <div class="dt-responsive table-responsive overflow-x-scroll">
                <table id="listKh" class="table " style="width:100%; white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>Tên danh mục</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Thương hiệu</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Mô tả</th>
                            <th width="90">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($products as $item) { ?>
                        <tr>
                            <td><?= $item['category_name'] ?></td>
                            <td><?= $item['name'] ?></td>
                            <td> <img class="rounded-0 img-cover" src="<?= $item['image'] ?>" alt="image"> </td>
                            <td><?= $item['brand'] ?></td>
                            <td><?= number_format($item['price']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td style="max-width: 200px; overflow-x: scroll; scrollbar-width: none;">
                                <?= $item['description'] ?></td>
                            <td class="text-end"><a href="javascript: void(0)"
                                    class="btn btn-info btn-sm btn-edit-category" data-id="<?= $item['id'] ?>"
                                    data-quantity="<?= $item['quantity'] ?>" data-price="<?= $item['price'] ?>"
                                    data-brand="<?= $item['brand'] ?>" data-image="<?= $item['image'] ?>"
                                    data-name="<?= $item['name'] ?>" data-category_id="<?= $item['category_id'] ?>"
                                    data-desc="<?= $item['description'] ?>">Sửa</a>
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
                <div class="row">
                    <input type="hidden" id="txtId">
                    <div class="mb-3 col-md-6">
                        <label for="txtEditDanhMuc" class="form-label"><b>Tên danh mục</b></label>
                        <?php $cate = $db->fetch_assoc("SELECT * from categories", 0) ?>
                        <select class="form-control" id="txtEditDanhMuc">
                            <option value="0" disabled>Chọn danh mục</option>
                            <?php foreach ($cate as $ct) { ?>
                            <option value="<?= $ct['id'] ?>"><?= $ct['name'] ?></option>
                            <?php
                            }  ?>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="txtEditName" class="form-label"><b>Tên sản phẩm</b></label>
                        <input type="text" class="form-control" placeholder="Nhập tên sản phẩm..." id="txtEditName">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="txtEditPrice" class="form-label"><b>Giá</b></label>
                        <input type="number" class="form-control" value="0" placeholder="Nhập giá..." id="txtEditPrice">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="txtEditSl" class="form-label"><b>Số lượng</b></label>
                        <input type="number" class="form-control" value="1" min="1" placeholder="Nhập số lượng..."
                            id="txtEditSl">
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="txtEditImage" class="form-label"><b>Ảnh ( nếu không thay đổi thì bỏ trống
                                )</b></label>
                        <input type="file" class="form-control" id="txtEditImage">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="txtEditBrand" class="form-label"><b>Thương hiệu</b></label>
                        <input type="text" class="form-control" placeholder="Nhập thương hiệu..." id="txtEditBrand">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="txtEditDesc" class="form-label"><b>Mô tả sản phẩm</b></label>
                    <textarea class="form-control" placeholder="Nhập mô tả..." rows="5" id="txtEditDesc"></textarea>
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
<div class="modal fade" id="addCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm mới</h5>
                <a href="javascript:;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="txtDanhMuc" class="form-label"><b>Tên danh mục</b></label>
                        <?php $cate = $db->fetch_assoc("SELECT * from categories", 0) ?>
                        <select class="form-control" id="txtDanhMuc">
                            <option value="0" disabled>Chọn danh mục</option>
                            <?php foreach ($cate as $ct) { ?>
                            <option value="<?= $ct['id'] ?>"><?= $ct['name'] ?></option>
                            <?php
                            }  ?>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="txtAddName" class="form-label"><b>Tên sản phẩm</b></label>
                        <input type="text" class="form-control" placeholder="Nhập tên sản phẩm..." id="txtAddName">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="txtPrice" class="form-label"><b>Giá</b></label>
                        <input type="number" class="form-control" value="0" placeholder="Nhập giá..." id="txtPrice">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="txtSl" class="form-label"><b>Số lượng</b></label>
                        <input type="number" class="form-control" value="1" min="1" placeholder="Nhập số lượng..."
                            id="txtSl">
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="txtImage" class="form-label"><b>Ảnh</b></label>
                        <input type="file" class="form-control" id="txtImage">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="txtBrand" class="form-label"><b>Thương hiệu</b></label>
                        <input type="text" class="form-control" placeholder="Nhập thương hiệu..." id="txtBrand">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="txtDesc" class="form-label"><b>Mô tả sản phẩm</b></label>
                    <textarea class="form-control" placeholder="Nhập mô tả..." rows="5" id="txtDesc"></textarea>
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
    $('.modal-detail-title').text("Cập nhật mã sản phẩm: " + id);
    $('#txtId').val(id);
    $('#txtEditDanhMuc').val($(this).data('category_id')).change();
    $('#txtEditName').val($(this).data('name'));
    $('#txtEditPrice').val($(this).data('price'));
    $('#txtEditSl').val($(this).data('quantity'));
    $('#txtEditBrand').val($(this).data('brand'));
    $('#txtEditDesc').val($(this).data('desc'));
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

    var formData = new FormData();
    formData.append('id', $('#txtId').val());
    formData.append('idCate', $('#txtEditDanhMuc').val());
    formData.append('name', $('#txtEditName').val());
    formData.append('price', $('#txtEditPrice').val());
    formData.append('quantity', $('#txtEditSl').val());
    formData.append('image', $('#txtEditImage')[0].files[0]);
    formData.append('brand', $('#txtEditBrand').val());
    formData.append('desc', $('#txtEditDesc').val());

    $.ajax({
        url: '<?= BASE_URL("/ajaxs/admin/order?submit=updateProduct") ?>',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
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
    Swal.fire({
        title: 'Đang xử lý',
        text: 'Vui lòng đợi trong khi chúng tôi xử lý yêu cầu của bạn.',
        icon: 'info',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    var formData = new FormData();
    formData.append('idCate', $('#txtDanhMuc').val());
    formData.append('name', $('#txtAddName').val());
    formData.append('price', $('#txtPrice').val());
    formData.append('quantity', $('#txtSl').val());
    formData.append('image', $('#txtImage')[0].files[0]);
    formData.append('brand', $('#txtBrand').val());
    formData.append('desc', $('#txtDesc').val());


    $.ajax({
        url: '<?= BASE_URL("/ajaxs/admin/order?submit=addProduct") ?>',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
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
        title: 'Xác nhận xóa',
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
                url: '<?= BASE_URL("/ajaxs/admin/order?submit=deleteProduct") ?>',
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