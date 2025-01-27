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
        <title>
            Quiz
        </title>
        <link rel="stylesheet" href="style.css">
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
                    <span>
                        Back
                    </span>
            </button>

        </form>
    </div>
    
    <?php if ($_SESSION['Subject'] === 'Contemporary_World'): ?>
        <body class="bodiCw">
    <?php else:  ?>
        <body class="bodiCcs05">
    <?php endif; ?>
       
        <div align="center">
            <h1 align="center" class="quizh1"><?php echo $question->getNumber(); ?></h1> 
                <form method="POST" action="quiz.php" class="ques">
                
                    <div class="kwesyun">
                        <h3 style="color: black" align="center" ><?php echo $question->getQuestion(); ?></h3><hr>
                    </div>

                    <input type="hidden" name="current_question_number" value="<?php echo $number; ?>" />
                        <br><br><br><br>
                        <input type="hidden" name="number" value="<?php echo $question->getNumber();?>" />
                        <?php foreach ($question->getChoices() as $choice): ?>
                                <div class="radio-container">
                                    <input type="radio" name="answer" value="<?php echo $choice->letter; ?>" <?php if (isset($_SESSION['answers'][$number]) && $_SESSION['answers'][$number] === $choice->letter) echo 'checked'; ?>/>
                                    <?php echo $choice->letter; ?>)
                                    <?php echo $choice->label; ?>
                                </div>
                    <?php endforeach; ?>
                        <?php if ($_SESSION["current_question_number"] < 10){ 
                            echo "<input type='submit' value='Next Question' class='next'>";
                        } else {
                            echo "<input type='submit' value='Finish' class='next'>";
                        }?>
                </form>
        </div>
    </body>
</html>

<?php 
var_dump($_SESSION)
?>

