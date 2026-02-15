<?php
    //Connect to Database  
    $hostname = "localhost";
    $username = "ecpi_user";
    $password = "Password1";
    $dbname = "sdc310_wk3pa";
    $conn = mysqli_connect($hostname, $username, $password, $dbname);
        
    //Establish variables to support add/edit/delete
    $userNo = -1;
    $fullName = "";
    $birthDate = "";
    $favColor = "";
    $favPlace = "";
    $nickName = "";

    //Variables to detemine the type of operation
    $add = false;
    $edit = false;
    $update = false;
    $delete = false;

    if (isset($_POST['user_no'])) {
        $userNo = $_POST['user_no'];
        $add = isset($_POST['add']);
        $update = isset($_POST['update']);
        $edit = isset($_POST['edit']);
        $delete = isset($_POST['delete']);
    }

    if ($add) {
        //Need to add a new user
        $fullName = $_POST['fname'];
        $birthDate = $_POST['bdate'];
        $favColor = $_POST['fcolor'];
        $favPlace = $_POST['fplace'];
        $nickName = $_POST['nname'];

        $addQuery = "INSERT INTO
            personal_info (FullName, Birthdate, FavoriteColor, FavoritePlace, Nickname)
            VALUES ('$fullName', '$birthDate', '$favColor', '$favPlace', '$nickName')";
        mysqli_query($conn, $addQuery);

        //Clear the fields
        $userNo = -1;
        $fullName = "";
        $birthDate = "";
        $favColor = "";
        $favPlace = "";
        $nickName = "";
    }
    else if ($edit) {
        //Get the user information
        $selQuery = "SELECT * FROM personal_info WHERE UserNo = $userNo";
        $result = mysqli_query($conn, $selQuery);
        $personal_info = mysqli_fetch_assoc($result);

        //Fill in the values to allow for edit
        $fullName = $personal_info['FullName'];
        $birthDate = $personal_info['Birthdate'];
        $favColor = $personal_info['FavoriteColor'];
        $favPlace = $personal_info['FavoritePlace'];
        $nickName = $personal_info['Nickname'];
    }
    else if ($update) {
        $fullName = $_POST['fname'];
        $birthDate = $_POST['bdate'];
        $favColor = $_POST['fcolor'];
        $favPlace = $_POST['fplace'];
        $nickName = $_POST['nname'];

        $updQuery = "UPDATE personal_info SET
            FullName = '$fullName', Birthdate = '$birthDate',
            FavoriteColor = '$favColor', FavoritePlace = '$favPlace',
            Nickname = '$nickName'
            WHERE UserNo = $userNo";
        mysqli_query($conn, $updQuery);

        //Clear the fields
        $userNo = -1;
        $fullName = "";
        $birthDate = "";
        $favColor = "";
        $favPlace = "";
        $nickName = "";
    }
    else if ($delete) {
        //Need to delete the selected user
        $delQuery = "DELETE FROM personal_info WHERE UserNo = $userNo";
        mysqli_query($conn, $delQuery);
        $userNo = -1;
    }

    //Query for all users
    $query = "SELECT * FROM personal_info";
    $result = mysqli_query($conn, $query);
?>

<style>
    table {
    border-spacing: 5px;
        }
    table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
        }
    th, td {
    padding: 15px;
    text-align: center;
        }
    th {
    background-color:lightskyblue;
        }
    tr:nth-child(even) {
    background-color:whitesmoke;
        }
    tr:nth-child(odd) {
    background-color:lightgray;
        }
</style>
<html>
    <head>
    <title>Christopher Crayton Week 3 Performance Assessment</title>
    </head>

    <body>
        <h2>Current Users:</h2>
        <table>
            <tr style="font-size:large;">
                <th>User #</th>
                <th>Full Name</th>
                <th>Birthdate</th>
                <th>Favorite Color</th>
                <th>Favorite Place</th>
                <th>Nickname</th>
            </tr>
            <?php while($row = mysqli_fetch_array($result)):;?>
            <tr>
                <td><?php echo $row["UserNo"];?></td>
                <td><?php echo $row["FullName"];?></td>
                <td><?php echo $row["Birthdate"];?></td>
                <td><?php echo $row["FavoriteColor"];?></td>
                <td><?php echo $row["FavoritePlace"];?></td>
                <td><?php echo $row["Nickname"];?></td>

                <td>
                    <form method='POST'>
                        <input type="submit" value="Edit" name="edit">
                        <input type="hidden"
                            value="<?php echo $row["UserNo"]; ?>"
                            name="user_no">
                    </form>
                </td>
                <td>
                    <form method='POST'>
                        <input type="submit" value="Delete" name="delete">
                        <input type="hidden"
                            value="<?php echo $row["UserNo"]; ?>"
                            name="user_no">
                    </form>
                </td>
            </tr>
            <?php endwhile;?>
        </table>
        <form method='POST'>
            <input type="hidden" value="<?php echo $userNo; ?>" name="user_no">
            <h3> Enter your full name: <input type="text" name="fname"
                value="<?php echo $fullName; ?>"></h3>
            <h3> Enter your birthdate: <input type="text" name="bdate"
                value="<?php echo $birthDate; ?>"></h3>
            <h3> Enter your favorite color: <input type="text" name="fcolor"
                value="<?php echo $favColor; ?>"></h3>
            <h3> Enter your favorite place: <input type="text" name="fplace"
                value="<?php echo $favPlace; ?>"></h3>
            <h3> Enter your nickname: <input type="text" name="nname"
                value="<?php echo $nickName; ?>"></h3>
            <?php if (!$edit): ?>
                <input type="submit" value="Add User" name="add">
            <?php else: ?>
                <input type="submit" value="Update User" name="update">
            <?php endif; ?>
        </form>
    </body>
</html>