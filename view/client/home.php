<?php
$title = "Trang Chủ";
$header = "
";
$script = "
  
";
include_once(__DIR__ . "/header.php");
$perPage = 5; // Số sản phẩm mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Số trang hiện tại
$offset = ($page - 1) * $perPage; // Tính toán offset


$category = isset($_GET['category']) && !empty($_GET['category']) ? $_GET['category'] : null;
$ctg = $db->fetch_assoc("SELECT * FROM `categories` where `name`='" . $category . "'", 1);

$brand = isset($_GET['brand']) && !empty($_GET['brand']) ? $_GET['brand'] : null;

$sql = "SELECT * FROM products";

if (isset($ctg['id'])) {
    $sql .= " WHERE `category_id` = " . $ctg['id'];
}

if (isset($brand)) {
    if (strpos($sql, 'WHERE') !== false) {
        $sql .= " OR `brand` = '" . $brand . "'";
    } else {
        $sql .= " WHERE `brand` = '" . $brand . "'";
    }
}


// Truy vấn tổng số bản ghi

$totalProduct =  $db->num_rows($sql);
echo $totalProduct;
$totalPages = ceil($totalProduct / $perPage); // Tính tổng số trang
$sql .= " LIMIT $offset, $perPage";

// Truy vấn lấy dữ liệu phân trang
$products = $db->fetch_assoc($sql, 0);


?>
<style>
    /* Style cho các liên kết phân trang */
    .pagination {
        display: inline-block;
        text-align: center;
    }

    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color 0.3s;
        margin: 0 4px;
        border: 1px solid #ccc;
    }

    /* Trang hiện tại */
    .pagination strong {
        background-color: #4CAF50;
        color: white;
        float: left;
        padding: 8px 16px;
        margin: 0 4px;
        border: 1px solid #4CAF50;
    }

    /* Hover effect cho các liên kết */
    .pagination a:hover {
        background-color: #ddd;
        border-color: #888;
    }

    /* Nút hiện tại khi hover không thay đổi */
    .pagination strong:hover {
        background-color: #4CAF50;
        border-color: #4CAF50;
    }

    .product-image {
        overflow: hidden;

        img {
            width: 100%;
            height: 100%;
            transition: all .5s;
            object-fit: contain;
        }

        a:hover img {
            transform: translateY(-10px);
            transition: all .5s;
        }
    }

    .card-item {
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px !important;
        height: 100%;
        margin-bottom: 0;
    }

    .hide-text-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .filter {
        font-size: 1rem;

        i {
            font-size: 1.4em;
        }
    }

    .product-info {
        font-size: 1rem;

        .mb-3 label:first-child {
            min-width: 130px;
        }
    }
</style>


<div class="row">
    <!-- [ sample-page ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">

                <div class="row align-items-center justify-content-center mb-4">
                    <h2 class="col-auto">Danh sách sản phẩm</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="multi-collapse collapse show">
            <div class="row">
                <div class="filter">
                    <i class="ti ti-filter"></i>Bộ lọc
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <?php $categories = $db->fetch_assoc("SELECT * FROM categories ", 0); ?>
                            <select name="category_id" id="category" class="form-control">
                                <option value="">Danh mục</option>
                                <?php foreach ($categories as $cate) { ?>
                                    <option value="<?= $cate['name'] ?>"
                                        <?= (isset($_GET['category']) && strtolower(trim($cate['name'])) == strtolower(trim($_GET['category']))) ? 'selected' : 'sa' ?>>
                                        <?= $cate['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <?php $brands = $db->fetch_assoc("SELECT brand FROM products group by brand ", 0); ?>
                            <select name="" id="brand" class="form-control">
                                <option value="">Thương hiệu</option>
                                <?php
                                foreach ($brands as $brand) { ?>
                                    <option value="<?= $brand['brand'] ?>"
                                        <?= (isset($_GET['brand']) && strtolower(trim($brand['brand'])) == strtolower(trim($_GET['brand']))) ? 'selected' : '' ?>>
                                        <?= $brand['brand'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php foreach ($products as $product) { ?>
                    <div class="col-md-4 col-xxl-3 col-sm-6 mb-3">
                        <div class="card card-item">
                            <div class="card-body">
                                <div class="product-image">
                                    <a href="<?= BASE_URL("/client/products/details?id=" . $product['id']) ?>"
                                        class="d-block">
                                        <img src="<?= $product['image'] ?>" alt="image">
                                    </a>
                                </div>
                                </br>
                                <a href="<?= BASE_URL("/client/products/details?id=" . $product['id']) ?>"
                                    class="product-name hide-text-2">
                                    <h4><?= $product['name'] ?></h4>
                                </a>
                                <div class="text-danger" style="font-size: 1rem;">Price:
                                    <?= number_format($product['price']) ?></div>
                                <div style="font-size: 1rem;"> Kho: <?= $product['quantity'] ?></div>
                                <div class=" d-flex justify-content-end mt-3">
                                    <?php if ($product['quantity'] == 0) { ?>
                                        <button class="btn btn-danger " disabled>Hết hàng</button>
                                    <?php
                                    } else { ?>
                                        <button class="col-6 btn btn-success buy-now" data-id="<?= $product['id'] ?>"
                                            data-name="<?= $product['name'] ?>"
                                            data-price="<?= number_format($product['price']) ?>"
                                            data-quantity="<?= $product['quantity'] ?>"
                                            data-desc="<?= $product['description'] ?>"
                                            data-brand="<?= $product['brand'] ?>">Thuê
                                            Ngay</button>
                                        <a href="<?= BASE_URL("/client/products/details?id=" . $product['id']) ?>"
                                            class="col-6 btn btn-primary btn-detail ">Chi tiết</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php
            if ($totalPages > 1) {
                echo '<div class="pagination w-100 r">'; // Bắt đầu thẻ phân trang
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i == $page) {
                        echo "<strong>$i</strong> "; // Trang hiện tại được bôi đậm
                    } else {
                        echo "<a href='?page=$i'>$i</a> "; // Các trang khác là liên kết
                    }
                }
                echo '</div>'; // Kết thúc thẻ phân trang
            }
            ?>
        </div>
    </div>
    <div class="bar">
        <hr>
    </div>
    <!-- [ sample-page ] end -->
</div>
<div class="modal fade" id="order" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thông tin sản phẩm</h5>
                <a href="javascript:;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body row">
                <div class="col-md-8 product-info">
                    <input type="hidden" id="idProduct">
                    <div class="mb-3 d-flex">
                        <label for="" class="form-labe"><b>Tên sản phẩm: </b></label>
                        <label for=""><span id="txtName" class="text-info"></span></label>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"><b>Thương hiệu: </b></label>
                        <label for=""><span id="txtBrand" class="text-danger"></span> </label>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"><b>Giá thuê 1 ngày: </b></label>
                        <label for=""><span id="txtPrice" class="text-danger"></span></label>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"><b>Kho: </b>
                        </label>
                        <label for=""><span id="txtQuantity" class="text-danger"></span></label>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"><b>Mô tả: </b> </label>
                        <label for=""><span id="txtDesc" class="text-danger"></span></label>
                    </div>
                    <div class="text-center">
                        <span id="add-status" class="text-danger "></span>
                    </div>
                </div>
                <div class="col-md-4" style="font-size: 1rem;">
                    <div class="mb-3">
                        <label for="" class="form-label"><b>Ngày thuê: </b> </label>
                        <input type="date" id="startDate" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"><b>Ngày trả: </b> </label>
                        <input type="date" id="endDate" disabled class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"><b>Tổng tiền: </b><span id="txtTotal"
                                class="text-danger">0</span> </label>
                    </div>
                </div>
                <div style="font-size: 1rem;">
                    <input type="hidden" id="userId" value="<?= $User_data['id'] ?>">
                    <div class="mb-3">
                        <label for="txtSdt" class="form-label"><b>Số điện thoại: </b> </label>
                        <input type="number" id="txtSdt" class="form-control" value="<?= $User_data['phone'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="txtAdd" class="form-label"><b>Địa chỉ: </b> </label>
                        <textarea rows="4" placeholder="Nhập địa chỉ nhận hàng..." id="txtAdd"
                            class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger closed-btn" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-success btn-add" data-bs-dismiss="modal">Thuê</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('.btn-add').on('click', function() {
        var id = $('#idProduct').val();
        var userId = $('#userId').val();
        var phone = $('#txtSdt').val();
        var address = $('#txtAdd').val();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        console.log(id)
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
            url: '<?= BASE_URL("/ajaxs/order?submit=store") ?>',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                id: id,
                userId: userId,
                phone: phone,
                address: address,
                startDate: startDate,
                endDate: endDate,
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

    });

    $(document).on('click', '.buy-now', function() {
        $('#idProduct').val($(this).data('id'))
        $('#txtName').text($(this).data('name'))
        $('#txtBrand').text($(this).data('brand'))
        $('#txtPrice').text($(this).data('price'))
        $('#txtQuantity').text($(this).data('quantity'))
        $('#txtDesc').text($(this).data('desc'))
        $('#order').modal('show');
    });

    document.addEventListener("DOMContentLoaded", function() {
        var today = new Date();
        var year = today.getFullYear();
        var month = ("0" + (today.getMonth() + 1)).slice(-2); // Thêm số 0 vào đầu nếu tháng nhỏ hơn 10
        var day = ("0" + today.getDate()).slice(-2); // Thêm số 0 vào đầu nếu ngày nhỏ hơn 10

        var minDate = year + '-' + month + '-' + day; // Định dạng ngày: YYYY-MM-DD
        var maxDate = new Date(today.setDate(today.getDate() + 30)); // Giới hạn thuê trong 30 ngày
        var maxDateFormatted = maxDate.getFullYear() + '-' + ("0" + (maxDate.getMonth() + 1)).slice(-2) + '-' + (
            "0" + maxDate.getDate()).slice(-2);

        document.getElementById('startDate').setAttribute('min', minDate);
        document.getElementById('startDate').setAttribute('max', maxDateFormatted);

    });

    $('#startDate').on('change', function() {
        var startDate = document.getElementById('startDate');
        var endDate = document.getElementById('endDate');
        if (startDate.value) {
            // Lấy giá trị ngày từ startDate
            var start = new Date(startDate.value);
            var minEndDate = new Date(start);
            var maxEndDate = new Date(start);

            // Cộng thêm 1 ngày để làm ngày bắt đầu hợp lệ cho endDate
            minEndDate.setDate(minEndDate.getDate() + 1);

            // Giới hạn tối đa là 30 ngày từ startDate
            maxEndDate.setDate(maxEndDate.getDate() + 30);

            // Định dạng ngày theo 'YYYY-MM-DD' cho min và max của endDate
            var minDateFormatted = minEndDate.toISOString().split('T')[0];
            var maxDateFormatted = maxEndDate.toISOString().split('T')[0];

            // Cập nhật thuộc tính min và max cho endDate
            endDate.setAttribute('min', minDateFormatted);
            endDate.setAttribute('max', maxDateFormatted);

            // Kích hoạt endDate để người dùng có thể chọn
            endDate.disabled = false;
            if ($('#startDate').val() && $('#endDate').val()) {
                cal()
            }
        } else {
            // Nếu không có startDate, disable endDate
            endDate.disabled = true;
        }
    })

    $('#endDate').on('change', function() {
        if ($('#startDate').val() && $('#endDate').val()) {
            cal();
        }
    });

    function cal() {
        var start = new Date($('#startDate').val());
        var end = new Date($('#endDate').val());

        // Tính toán số ngày giữa 2 ngày
        var timeDiff = end.getTime() - start.getTime();
        var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)); // Chuyển từ mili giây sang ngày
        var price = $('#txtPrice').text().replace(/,/g, '');
        var amount = daysDiff * price;
        // Hiển thị số ngày thuê
        $('#txtTotal').text(amount.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }));

    }
</script>

<script>
    $('#category , #brand').on('change', function() {
        const currentUrl = new URL(window.location.href);

        ['category', 'brand'].forEach(param => {
            const value = $(`#${param}`).val();
            currentUrl.searchParams.set(param, value);
        });

        window.location.href = currentUrl;
    });
</script>
<?php
include_once(__DIR__ . "/footer.php");
?>