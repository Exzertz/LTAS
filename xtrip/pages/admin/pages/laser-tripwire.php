<main class="main" id="main">

    <?php
    include_once "../global-includes/page-titles.php";
    ?>

    <div class="row">

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">


            <div class="card flex-fill">

                <div class="card-header bg-dark ">
                    <h5 class="card-title mb-0 text-white fs-4 py-3 px-1 d-flex justify-content-between">
                        Laser Tripwire Products

                        <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#add-product-modal">
                            <i class="bi bi-plus"></i> Add New Product
                        </button>
                    </h5>
                </div>

                <table class="table table-hover my-0 text-center datatable custom-table">

                    <thead>
                        <tr>
                            <th> Tripwire Image </th>
                            <th> Device ID </th>
                            <th> Product Name </th>
                            <th> Model Name </th>
                            <th> Version </th>
                            <th> Description </th>
                            <th> Owner </th>
                            <th> Update/Status </th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $get_products = $conn->prepare("SELECT
                                                                    pt.*,
                                                                    COALESCE(CONCAT(ua.first_name, ' ', ua.last_name), 'N/A') AS 'owner_name'
                                                                FROM laser_tripwire_products_tbl pt
                                                                LEFT JOIN laser_tripwire_owners_tbl o
                                                                ON pt.device_id = o.device_id
                                                                LEFT JOIN user_accounts_tbl ua
                                                                ON o.owner = ua.user_id
                                                                ");
                        $get_products->execute();

                        if ($get_products->rowCount() > 0) {
                            while ($product_data = $get_products->fetch()) {
                                $product_image = $product_data["product_image"];

                                if (empty($product_image) || !file_exists($product_image_path . $product_image)) {
                                    $product_image = "no-product-img.png";
                                }

                        ?>
                                <tr>

                                    <td>
                                        <img
                                            src="<?php echo htmlspecialchars($product_image_path . $product_image); ?>"
                                            class="rounded-circle"
                                            alt="Product Image"
                                            width="40" height="40"
                                            data-bs-toggle="modal"
                                            data-bs-target="#productImageView"
                                            onclick="setModalImage('<?php echo htmlspecialchars($product_image_path . $product_image); ?>')">
                                    </td>

                                    <!-- Image Modal -->
                                    <div class="modal fade" id="productImageView" tabindex="-1" aria-hidden="true">

                                        <div class="modal-dialog modal-lg modal-dialog-centered">

                                            <div class="modal-content bg-transparent border-0">

                                                <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>

                                                <img
                                                    class="img-fluid rounded"
                                                    id="productImage"
                                                    alt="Product Image">

                                            </div>

                                        </div>
                                    </div>

                                    <script>
                                        function setModalImage(src) {
                                            document.getElementById('productImage').src = src;
                                        }
                                    </script>

                                    <td class="fw-bold">
                                        <?php echo htmlspecialchars($product_data["device_id"]); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($product_data["product_name"]); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($product_data["model_name"]); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($product_data["version"]); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($product_data["description"] ?? "N/A"); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($product_data["owner_name"]); ?>
                                    </td>

                                    <td>
                                        <?php
                                        if ($product_data["owner_name"] === "N/A") {
                                        ?>
                                            <button class="btn btn-outline-primary btn-sm" title="Update Status" data-bs-target="#laser-tripwire-<?php echo htmlspecialchars($product_data["device_id"]); ?>" data-bs-toggle="modal">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        <?php
                                        } else {
                                        ?>

                                            <span class="fw-bold text-success">
                                                Installed
                                            </span>

                                        <?php
                                        }
                                        ?>
                                    </td>

                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="laser-tripwire-<?php echo htmlspecialchars($product_data["device_id"]); ?>" tabindex="-1" aria-labelledby="viewDetails" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">

                                            <!-- Header -->
                                            <div class="modal-header bg-dark text-white">
                                                <h5 class="modal-title" id="viewDetails"> Laser Tripwire Information</h5>
                                                <span class="ms-auto small">Device ID: <?php echo htmlspecialchars($product_data["device_id"]); ?></span>
                                                <button type="button" class="btn-close ms-2 fs-1" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <!-- Form Start -->
                                            <form action="../../process/admin/product-management.php" method="POST" enctype="multipart/form-data">

                                                <input type="hidden" name="device-id" value="<?php echo htmlspecialchars(base64_encode($product_data["device_id"])); ?>">

                                                <div class="modal-body">

                                                    <div class="container-fluid">

                                                        <!-- Image Preview -->
                                                        <div class="mb-3 text-center">
                                                            <img id="item-preview" src="<?php echo htmlspecialchars($product_image_path . $product_image); ?>" alt="Image Preview"
                                                                class="img-fluid rounded border" style="max-height: 180px; object-fit: cover;">
                                                        </div>

                                                        <!-- Product Name -->
                                                        <div class="row mb-3">

                                                            <div class="col-md-12">
                                                                <label for="productName" class="form-label"> Product Name: </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                                                    <input type="text" class="form-control" id="productName" name="product-name" placeholder="Enter Product Name" value="<?php echo htmlspecialchars($product_data["product_name"]); ?>" required>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- Product Model and Version -->
                                                        <div class="row mb-3">

                                                            <div class="col-md-6">
                                                                <label for="productModel" class="form-label"> Product Model: </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text"><i class="bi bi-diagram-3"></i></span>
                                                                    <input type="text" class="form-control" id="productModel" name="product-model" placeholder="Enter Product Model" value="<?php echo htmlspecialchars($product_data["model_name"]); ?>" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="productVersion" class="form-label"> Product Version: </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                                                    <input type="text" class="form-control" id="productVersion" name="product-version" placeholder="Enter Product Version" value="<?php echo htmlspecialchars($product_data["version"]); ?>" required>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- Product Description -->
                                                        <div class="row mb-0">

                                                            <div class="col-md-12">
                                                                <label for="productDescription" class="form-label"> Product Description(Optional): </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text"><i class="bi bi-file-text"></i></span>
                                                                    <input type="text" class="form-control" id="productDescription" name="product-description" placeholder="Enter Product Description" value="<?php echo htmlspecialchars($product_data["description"]); ?>">
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <!-- Footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success custom-add-btn" name="update-product">
                                                        <i class="bi bi-pencil-square me-1"></i> Update Product
                                                    </button>

                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Cancel </button>

                                                    <form action="../../process/admin/product-management.php" method="POST" id="delete-product-form">
                                                        <input type="hidden" name="device-id" value="<?php echo htmlspecialchars(base64_encode($product_data["device_id"])); ?>">
                                                        <input type="hidden" name="delete-product" value="1">

                                                        <button
                                                            type="submit"
                                                            class="btn btn-danger"
                                                            onclick="confirmAction(
                                                                    event, 
                                                                    this.form, 
                                                                    'delete-product-form',
                                                                    'Delete Product?', 
                                                                    'warning',
                                                                    'Are you sure you want to delete this product: <?php echo htmlspecialchars($product_data['product_name']); ?>?',
                                                                    'Delete',
                                                                    '#dc3545'
                                                                )"
                                                            title="Delete Product">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>

                                            </form>
                                            <!-- Form End -->

                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="8"> No Laser Tripwire Products </td>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>

                </table>

            </div>


        </div>

    </div>

</main>

<!-- Modal -->
<div class="modal fade" id="add-product-modal" tabindex="-1" aria-labelledby="addProductModal">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title fw-bold" id="addProductModal"> Add New Tripwire </h5>
                <button type="button" class="btn-close p-3" style="transform: scale(2);" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form Start -->
            <form action="../../process/admin/product-management.php" method="POST" enctype="multipart/form-data">

                <div class="modal-body">

                    <div class="container-fluid">

                        <!-- Image Preview -->
                        <div class="mb-3 text-center">
                            <img id="item-preview" src="<?php echo htmlspecialchars($product_image_path . "no-product-img.png"); ?>" alt="Image Preview"
                                class="img-fluid rounded border" style="max-height: 180px; object-fit: cover;">
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="upload-pic" class="form-label"> Upload Product Image(Optional): </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-image"></i></span>
                                <input class="form-control" type="file" id="upload-item-pic" name="product-image" accept="image/*">
                            </div>
                        </div>

                        <!-- Device ID and Name -->
                        <div class="row mb-3">

                            <div class="col-md-6">
                                <label for="deviceId" class="form-label"> Device ID: </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-cpu"></i></span>
                                    <input type="text" class="form-control" id="deviceId" name="device-id" placeholder="Enter Device ID" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="productName" class="form-label"> Product Name: </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                    <input type="text" class="form-control" id="productName" name="product-name" placeholder="Enter Product Name" required>
                                </div>
                            </div>

                        </div>

                        <!-- Product Model and Version -->
                        <div class="row mb-3">

                            <div class="col-md-6">
                                <label for="productModel" class="form-label"> Product Model: </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-diagram-3"></i></span>
                                    <input type="text" class="form-control" id="productModel" name="product-model" placeholder="Enter Product Model" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="productVersion" class="form-label"> Product Version: </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                    <input type="text" class="form-control" id="productVersion" name="product-version" placeholder="Enter Product Version" required>
                                </div>
                            </div>

                        </div>

                        <!-- Product Description -->
                        <div class="row mb-0">

                            <div class="col-md-12">
                                <label for="productDescription" class="form-label"> Product Description(Optional): </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-file-text"></i></span>
                                    <input type="text" class="form-control" id="productDescription" name="product-description" placeholder="Enter Product Description">
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success custom-add-btn" name="add-new-tripwire">
                        <i class="bi bi-plus-circle me-1"></i> Add Item
                    </button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Cancel </button>
                </div>

            </form>
            <!-- Form End -->

        </div>

    </div>

</div>
<!-- End Modal -->


<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('upload-item-pic').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('item-preview');
            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        });
    })
</script>