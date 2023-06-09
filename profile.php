<!DOCTYPE html>
<html>
    <head>
        <title>
            PROFILE
        </title>
        <link rel="stylesheet" href="style.css">
    </head>
    
        <?php
        require "config.php";
        use App\User;

        $table = User::profile();

        echo "<div align='center'>";
        echo "<table border='1' class='pf_tbl'>";
        echo "<tr>";
            echo "<th class='pf'>Username</th>";
            echo "<th class='pf'>Subject</th>";
            echo "<th class='pf'>Score</th>";
            echo "<th class='pf'>Saved_at</th>";
        echo "</tr>";
        foreach($table as $data){
            echo "<tr>";
            foreach ($data as $columnName => $Value){
                echo "<td>" . $Value . "</td>";
            }
            echo "<tr>";
        }
        echo "</div>";
        ?>

    <body class="pf-body">
        <img src="images/logo_bw.png" alt="logo" class="pf-logo">
            <div class="user">
                <h4 class="user"><?php echo $_SESSION['user']['username'] ?></h4>
            </div>
            <br>
            <div class="email">
                <h4 class="email"><?php echo $_SESSION['user']['email'] ?></h4>
            </div>
            <br>
                <img src="images/LB_CROWN.png" alt="logo" class="crown">
            <div>
                <button class="leaderboard" onclick = "window.location.href='leaderboard.php';">
                    <span class="btn-txt">
                        VIEW LEADERBOARDS
                    </span>
                </button>
            </div>
    </body>
</html>