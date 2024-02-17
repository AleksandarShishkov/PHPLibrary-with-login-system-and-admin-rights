<?php 
    require_once '../inc/header.php'; 

    if(isset($_SESSION['admin_id'])) {
?>

<h1 class="header_h1">Create new book</h1>

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

<div>
    <form class="form_style" method="POST" action="../../../index.php">

        <label for="name">Name:</label><br>
        <input type="text" name="name" id="name" required><br><br>

        <label for="ISBN">ISBN:<br>(978-0-13-601970-1)</label><br>
        <input type="text" name="ISBN" id="ISBN" requried><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description" rows="5" required></textarea><br><br>

        <input type="submit" class="submit_btn" name="create_book" value="Create">
    </form>
</div>
<div class="back_btn_div">
    <a href="../home.php"><button class="back_btn">Back</button></a>
</div>

<?php } else { ?>
    <h1 class="helper_text">You should have admin rights to create new book!</h1>
    
    <div class="back_btn_div">
        <a href="../home.php"><button class="back_btn">Back</button></a>
    </div>
<?php } ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var name = document.getElementById('name');
        var ISBN = document.getElementById('ISBN');
        var description = document.getElementById('description');

        name.value = localStorage.getItem('savedName') || '';
        ISBN.value = localStorage.getItem('savedISBN') || '';
        description.value = localStorage.getItem('savedDescription') || '';

        document.getElementById('name').addEventListener('input', function() {
            localStorage.setItem('savedName', this.value);
        });

        document.getElementById('ISBN').addEventListener('input', function() {
            localStorage.setItem('savedISBN', this.value);
        });

        document.getElementById('description').addEventListener('input', function() {
            localStorage.setItem('savedDescription', this.value);
        });
    });
</script>

<?php 
    require_once '../inc/footer.php'; 
?>