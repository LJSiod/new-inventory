<?php
error_reporting(0);
session_start();
$servername = "192.168.0.103";
$username = "root";
$password = "neocashmarbel2020";

// $servername = "192.168.0.79";
// $username = "root";
// $password = "admin1234";

$dbname = "payroll";

$conn = new mysqli($servername, $username, $password, $dbname);
date_default_timezone_set('Asia/Manila');
$_SESSION['version'] = '2.0.0';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT id,
                    firstname, 
                    CONCAT(FirstName, ' ', MiddleName, '. ', LastName) AS fullname
                    FROM employee 
                    WHERE username = '" . $username . "' 
                    AND password = '" . $password . "'
                    AND employmentstatus <> 'RESIGNED'
                    AND departmentid = 2";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) == 1) {
        $success = "Welcome " . htmlspecialchars($user['fullname'] . "!");
        $_SESSION['userid'] = $user['id'];
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['fullname'] = $user['fullname'];
    } else {
        $error = "Invalid username or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Management</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="assets/image/oms_logo.ico">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: "Fira Sans", sans-serif;
            color: #0D9849;
        }

        .light {
            background: linear-gradient(135deg, #e0f7fa 0%, #e8f5e9 100%);
            /* background-image: url('assets/image/login_bg.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center; */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form {
            animation: fadeIn 0.5s ease;
            background-color: #fff;
            display: flex;
            flex-direction: row;
            height: auto;
            max-width: 900px;
            width: 100%;
            border-radius: 2rem;
            box-shadow:
                0 4px 24px 0 rgba(13, 152, 73, 0.10),
                0 1.5px 6px 0 rgba(0, 0, 0, 0.08);
            margin: 0 auto;
            /* overflow: hidden; */
            opacity: 95%;
            backdrop-filter: blur(10px);
        }

        .form-logo {
            background-image: url('assets/image/8.png');
            background-size: cover;
            background-position: left;
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-right: 1px solid #ddd;
            border-radius: 2rem 0 0 2rem;
        }

        .form-logo img {
            max-width: 100%;
            height: auto;
            max-height: 150px;
        }

        .form-logo h5 {
            margin-top: 10px;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
        }

        .form-content {
            flex: 1;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-title {
            font-family: Raleway, sans-serif;
            line-height: 1.75rem;
            letter-spacing: 0.10rem;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            color: #0D9849;
            margin-bottom: 20px;
        }

        .input-container {
            position: relative;
            margin-bottom: 20px;
        }

        .input-container input {
            width: 100%;
            padding: 10px 40px 10px 40px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }

        .input-container i.fa-lock,
        .input-container i.fa-user {
            position: absolute;
            left: 10px;
            top: 65%;
            transform: translateY(-50%);
            color: #0D9849;
            font-size: 1.5rem;
        }

        .input-container i#togglePassword {
            position: absolute;
            right: 15px;
            top: 80%;
            transform: translateY(-50%);
            color: #0D9849;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .submit {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background-color: #0D9849;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
        }

        .submit:hover {
            background-color: #0d8240;
        }

        .copyright {
            text-align: center;
            color: #555;
            margin-top: 15px;
            font-size: 0.9rem;
            font-style: italic;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form {
                flex-direction: column;
                border-radius: 1rem;
            }

            .form-logo {
                border-right: none;
                border-bottom: 1px solid #ddd;
                padding: 20px;
                border-radius: 0;
            }

            .form-content {
                padding: 20px;
            }

            .form-logo img {
                max-height: 150px;
            }

            .form-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body class="light">
    <form class="form mx-3 border" method="POST" action="">
        <!-- <img src="assets/image/xmas.png" alt="Xmas Hat!"
            style="height: 100px; width: 100px; position: absolute; top: -40px; right: -50px; z-index: 1;"> -->
        <div class="form-logo">
            <!-- <img src="assets/image/xmas-balls.png" alt="Xmas Balls!"
                style="height: 80px; width: 80px; position: absolute; top: 0; left: 150px; z-index: 1;">
            <img src="assets/image/xmas-tree.png" alt="Xmas Tree!"
                style="height: 150px; width: 150px; position: absolute; bottom: 0; left: 290px; z-index: 1;"> -->
            <img src="assets/image/Neologo.png" alt="Logo" draggable="false">
            <h5>NEOCASH LENDING INC.</h5>
            <h6 style="margin-top: -10px; font-size: 0.8rem;">Equipment Tracking System</h6>
        </div>
        <div class="form-content">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    <h6 class="fw-bold"><i class="fa fa-exclamation-triangle text-danger me-2"></i><?php echo $error; ?>!
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <h2 class="form-title">ACCOUNT LOGIN</h2>
            <div class="input-container">
                <i class="fa fa-user fa-2x mr-2"></i>
                <label class="small m-0" for="username">Username</label>
                <input type="text" placeholder="Enter username" name="username" autocomplete="username" required
                    style="padding-left: 3rem;"
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            <div class="input-container" style="position: relative;">
                <i class="fa fa-lock fa-2x mr-2"></i>
                <label class="small m-0" for="password">Password</label>
                <input type="password" placeholder="Enter password" name="password" autocomplete="password"
                    id="password" style="width: 100%; padding-left: 3rem;" required>
                <i class="fa fa-eye" id="togglePassword"
                    style="position:absolute; right:15px; top:50px; cursor:pointer;"></i>
            </div>
            <button type="submit" class="submit">Sign in</button>
            <div class="copyright">
                NLI|Equipment Tracking System. &copy; <?php echo date('Y'); ?>. All rights reserved.
            </div>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.5/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.7/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function () {

            $('#togglePassword').on('click', function () {
                const pass = $('#password');
                const type = pass.attr('type') === 'password' ? 'text' : 'password';
                pass.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });

            <?php if (isset($success)): ?>
                Swal.fire({
                    icon: 'success',
                    title: '<?php echo $success; ?>',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                }).then(function () {
                    window.location.href = "index.php";
                })
            <?php endif; ?>

        });
    </script>
</body>

</html>