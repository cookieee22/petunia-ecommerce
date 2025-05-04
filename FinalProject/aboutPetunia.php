<?php
session_start();
include('config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Petunia | About Petunias</title>
    <style>
        body {
            background-color: #e3bff2;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .panel {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            max-width: 1000px;
            margin: 60px auto 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .panel img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .panel-heading {
            font-size: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .about-wrapper {
            display: flex;
            flex-direction: row;      /* Arrange items in a row */
            gap: 30px;                /* Space between boxes */
            justify-content: center; /* Center the row horizontally */
            flex-wrap: nowrap;       /* Prevent wrap (optional) */
            margin-top: 40px;
        }

        .about-box {
            width: 100%;
            max-width: 600px;
            text-align: center;
            border: 1px solid #ccc;
            padding: 15px;
            background-color: #f9f9f9;
            box-sizing: border-box;
            margin: 0 auto;
        }

        .about-image {
            width: 100%;      
            height: auto;      /* Keeps the image aspect ratio */
            margin: 0 auto;    /* Centers the image horizontally */
            display: block;    
            margin-bottom: 10px; /* Adds space below the image */
        }

        .small-image {
            width: 300px;
            height: auto;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <?php
    include('header.php');
    ?>

    <div class="panel">
        <div class="panel-heading"><strong>Learn About Us and The Petunia Flower</strong></div>
        
        <div class="panel-body" align="justify">

            <?php
            $sql = "SELECT ABOUT_ID, ABOUT_DESCRIPTION, IMAGE FROM ABOUT";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                echo "<div class='about-wrapper'>"; // wrapper starts here
                
                while($row = $result->fetch_assoc()) {
                    echo "<div class='about-box'>";
                    echo "<img src='Images/" . htmlspecialchars($row["IMAGE"]) . "' alt='Flower image' class='small-image'>";
                    echo "<p>" . nl2br(htmlspecialchars($row["ABOUT_DESCRIPTION"])) . "</p>";
                echo "</div>";
                }
                echo "</div>"; // wrapper ends here
                } else 
                {
                    echo "<p>No about info found.</p>";
                }

            $db->close();
            ?>
        </div>
    </div>

</body>
</html>
