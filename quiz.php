<?php

require "vendor/autoload.php";

session_start();

// 3.

use App\QuestionManager;

$number = null;
$question = null;

try {
    $manager = new QuestionManager;
    $manager->initialize();

    if (isset($_SESSION['is_quiz_started'])) {
        $number = $_SESSION['current_question_number'];
    } else {
        // Marker for a started quiz
        $_SESSION['is_quiz_started'] = true;
        $_SESSION['answers'] = [];
        $number = 1;
    }

    if (isset($_POST['answer'])) {
        $_SESSION['answers'][$number] = $_POST['answer'];
        $number++;
    } elseif (isset($_POST['selected_answer'])) {
        $_SESSION['answers'][$number] = $_POST['selected_answer'];
        $number--;
    }

    // Has user answered all items
    if ($number > $manager->getQuestionSize()) {
        header("Location: result.php");
        exit;
    }

    // Marker for question number
    $_SESSION['current_question_number'] = $number;

    $question = $manager->retrieveQuestion($number);
} catch (Exception $e) {
    echo '<h1>An error occurred:</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
    exit;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Quiz</title>
        <style>
        form.ques {
            background-color: #fff;
            border: 0px solid #ccc;
            border-radius: 45px;
            padding: 10px;
            margin: 0px;
            max-width: 1085px; /* set a maximum width */
            height: 650px;
            background-image: url('https://lh3.googleusercontent.com/drive-viewer/AFGJ81oFCJykTM1tzAv5m5KJDd8VpE2h4GFvfJD94RRe8lJaOVV7fbSkxvBqW1mU4_Ari2BNUerx78_yfyCBVTSPOTmUh2qQ=s1600');
            background-size: cover;
            margin-top: 25px;
            position: relative;
        }
        .bodi{
            background-color: #94ecf7;
        }
        div.quiz{
            display: flex;
            align-items: center;
        }

        input[type="radio"] {
            /* Move the radio circle to the right */
            position: left;
            margin-left: 400px;
        }
        .radio-container {
            display: flex;
            align-items: center;
            font-size: 45px;
        }

        .radio-container input[type="radio"] {
            margin-right: 100px;
            -ms-transform: scale(1.5); /* IE 9 */
            -webkit-transform: scale(1.5); /* Chrome, Safari, Opera */
            transform: scale(1.5);
        }
        .next {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            height: 50px;
            width: 196px;
            font-size: 20px;
            position: relative;
            left:  46%;
            top: -93.5%;
        }

        .next:hover {
            background-color: #3e8e41;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);
            transform: translate(2px, 2px);
        }
        .kwesyun{
            font-size: 30px;
        }

        .b_button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            height: 50px;
            width: 196px;
            font-size: 20px;
            position: relative;
            left: 26%;
            top: 20%;
        }

        .b_button:hover {
            background-color: #880808;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);
            transform: translate(2px, 2px);
        }
        .b_button > svg {
            margin-right: 5px;
            margin-left: -10px;
            font-size: 20px;
            transition: all 0.4s ease-in;
            top: ;
            height: 20;
            width: 20;
        }

        .b_button:hover > svg {
            font-size: 3em;
            transform: translateX(-20px);
        }


        </style>
    </head>
    <div>
        <form method="POST" action="back_button.php" class="rel">
            <input type="hidden" name="selected_answer" value="<?php echo isset($_SESSION['answers'][$number]) ? $_SESSION['answers'][$number] : ''; ?>" />   
            
            <button type="submit" name="back" value="true" class="b_button">  
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" 
                viewBox="0 0 16 16"> 
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 
                .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                    <span>Back</span>
            </button>

        </form>
    </div>
    <body class="bodi">
        <div align="center">
            <form method="POST" action="quiz.php" class="ques">
                <div class="kwesyun">
                    <h1 align="center">Question #<?php echo $question->getNumber(); ?></h1>
                    <h2 style="color: blue" align="center"><?php echo $question->getQuestion(); ?></h2>
                    <h4 style="color: blue" align="center">Choices</h4>
                </div>

                <input type="hidden" name="current_question_number" value="<?php echo $number; ?>" />

                    <input type="hidden" name="number" value="<?php echo $question->getNumber();?>" />
                    <?php foreach ($question->getChoices() as $choice): ?>
                            <div class="radio-container">
                                <input type="radio" name="answer" value="<?php echo $choice->letter; ?>" <?php if (isset($_SESSION['answers'][$number]) && $_SESSION['answers'][$number] === $choice->letter) echo 'checked'; ?>/>
                                <?php echo $choice->letter; ?>)
                                <?php echo $choice->label; ?>
                            </div>
                <?php endforeach; ?>
                    <input type="submit" value="Next Question" class="next">
                </div>
            </form>
        </div>
    </body>
</html>

<?php 
//var_dump($_SESSION)
?>

