<?php 

require_once '../../db_ini.php';
require_once '../inc/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

    if(isset($_SESSION['admin_id'])) {

        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    
        if($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $get_all_users = "SELECT * 
                          FROM users";
                          
        $users = $conn->query($get_all_users);

        if($users->num_rows > 0) {
            echo '<h1 class="header_h1">Manage users</h1>';
        ?>

            <div class="message_div">
                <?php 
                    if(!empty($_SESSION['success_message'])) {
                        echo "<h4 class='success_message'>" . $_SESSION['success_message'] . "</h4><br>";
                        $_SESSION['success_message'] = null;
                    } elseif(!empty($_SESSION['error_message'])) {
                        echo "<h4 class='error_message'>" . $_SESSION['error_message'] . "</h4><br>";
                        $_SESSION['error_message'] = null;
                    } 
                ?>
            </div>

            <script>
                localStorage.removeItem("savedName");
                localStorage.removeItem("savedISBN");
                localStorage.removeItem("savedDescription");
            </script>

            <div>
            <table>
            <thead>
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Access</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                    <?php while($user = $users->fetch_assoc()) {?>                
                    <tr>
                        <td><?= $user['first_name'] ?></td>
                        <td><?= $user['last_name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td>
                            <?php
                                if($user['active']) {
                                    echo '<span style="color:green">Active</span>';
                                } else {
                                    echo '<span style="color:red">Inactive</span>';
                                }
                            ?>

                        </td>
                        <td>
                            <div class="action_btn_container_div">
                                <?php if($user['active']) { ?>    
                                    <a href="../../../index.php?user_id_reject=<?=$user['id']?>"><button class="reject_user_btn">Reject access</button></a>    
                                <?php } else { ?>
                                    <a href="../../../index.php?user_id_allow=<?=$user['id']?>"><button class="allow_user_btn">Allow access</button></a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            </table>

            </div>
            <div class="back_btn_div">
                <a href="../home.php"><button class="back_btn">Back</button></a>
            </div>

        <?php

        } else { ?>
            <div>
                <h1 class='helper_text'>No user profiles detected!</h1>
            </div>
            <div class='back_btn_div'>
                <a href='../home.php'><button class='back_btn'>Back</button></a>
            </div>";
       <?php }
    
 } else { ?>

    <h1 class="helper_text">You should have admin rights to manage the users!</h1>
<?php } ?>

<?php 
    require_once '../inc/footer.php'; 
?>