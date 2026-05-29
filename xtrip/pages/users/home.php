<?php
ob_start();
require_once "../../config/conn.php";
require_once "../../config/format-time.php";
require_once "includes/page-titles.php";

$page_name = isset($_GET["page"]) ? $_GET["page"] : "dashboard";
$image_path = "../../uploads/user-images/";
$tripwire_location_path = "../../uploads/tripwire-locations/";
$captured_images_path = "../../uploads/captured-images/";

if (empty($_SESSION["user-id"]) || $_SESSION["user-id"] === "") {
    header("../../index.php");
    exit();
} else {
    $user_id = htmlspecialchars(trim($_SESSION["user-id"]));

    $get_user_data = $conn->prepare("SELECT
                                         ua.*, ui.*
                                        FROM user_accounts_tbl ua
                                        LEFT JOIN user_info_tbl ui
                                        ON ua.user_id = ui.user_id
                                        WHERE ua.user_id = :user_id   
                                    ");
    $get_user_data->execute([":user_id" => $user_id]);

    while ($user_data = $get_user_data->fetch(PDO::FETCH_OBJ)) {

        // Primary Data
        $first_name = $user_data->first_name;
        $middle_name = $user_data->middle_name;
        $last_name = $user_data->last_name;
        $email_address = $user_data->email_address;

        // Secondary Data
        $profile_picture = $user_data->profile_picture;
        $gender = $user_data->gender;
        $civil_status = $user_data->civil_status;
        $phone_number = $user_data->cellphone_number;
        $telephone_number = $user_data->telephone_number;
        $address = $user_data->address;
        $updated_at = $user_data->updated_at;
    }

    if (empty($profile_picture) || !file_exists($image_path . $profile_picture)) {
        $profile_picture = "default-img.png";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php
    include_once "../global-includes/web-title.php";
    ?>

    <?php
    include_once "../global-includes/css-files.php";
    ?>

    <!-- Custom CSS -->
    <style>
        .active-page i,
        .active-page span {
            color: #212529;
        }

        .custom-table {
            cursor: pointer;
        }

        .custom-table thead tr th {
            text-align: center;
        }

        .custom-table thead tr th,
        .custom-table tr td {
            text-align: center;
            vertical-align: middle !important;
        }

        .custom-table tr th {
            background-color: #212529;
            height: 50px;
            color: #f2f2f2;
        }

        .custom-table tr td img {
            width: 50px;
        }

        .custom-add-btn,
        .custom-save-btn {
            background-color: #212529;
            border: none;
        }

        .custom-add-btn:hover {
            background-color: #212529;
            filter: brightness(90%);
        }

        .custom-card-title {
            font-size: 24px;
        }

        .custom-form input:focus,
        .custom-form select:focus {
            outline: none;
            border: 1px solid #212529;
            box-shadow: none;
        }

        .custom-form select,
        .custom-form .date-time {
            height: 50px;
        }

        .edit-dropdown {
            height: 40px;
        }

        .custom-overview .custom-title {
            color: #2b3c49;
        }

        .custom-form label {
            color: #2b3c49;
        }

        .custom-table tr th,
        .custom-table tr td {
            font-size: 13px;
        }

        .custom-table a {
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <?php
        include_once "includes/nav-bar.php";
        ?>

        <?php
        include_once "includes/sidebar.php";
        ?>



        <!-- Main -->
        <?php
        $page_path = "pages/$page_name.php";

        if (file_exists($page_path)) {
            include_once $page_path;
        } else {
            $page_name = "dashboard";
            include_once "pages/dashboard.php";
        }

        ?>

        <?php
        include_once "../global-includes/footer.php";
        ?>

    </div>

    </div>

    <?php
    include_once "../global-includes/script-files.php";
    ?>

    <?php if (isset($_SESSION["alert-status"]) && $_SESSION["alert-status"] !== ""): ?>
        <script>
            const notification = <?php echo $_SESSION["alert-status"]; ?>;
            Swal.fire({
                icon: notification.icon || 'info',
                title: notification.title || '',
                text: notification.text || '',
                showConfirmButton: false,
                timer: 3000
            });
        </script>

        <?php unset($_SESSION["alert-status"]); ?>
    <?php endif; ?>

    <!-- Confirm Action -->
    <script>
        function confirmAction(event, formElement, formId, title, icon, message, confirmButtonTitle, confirmButtonBgColor) {

            const form = document.getElementById(formId);

            if (!formElement.checkValidity()) {
                formElement.reportValidity();
                return;
            }

            event.preventDefault();

            Swal.fire({
                title: title,
                text: message,
                icon: icon,
                showCancelButton: true,
                confirmButtonText: confirmButtonTitle,
                cancelButtonText: 'Cancel',
                confirmButtonColor: confirmButtonBgColor,
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    formElement.submit();
                }
            });

            return false;
        }
    </script>

</body>

</html>

<?php ob_end_flush(); ?>