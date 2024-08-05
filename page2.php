<?php
include('connection.php');
$questions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[$row['question_id']]['question'] = $row['question'];
        $questions[$row['question_id']]['options'][] = [
            'option_id' => $row['option_id'],
            'option_value' => $row['options'],
            'is_answer' => $row['answer']
        ];
    }
} else {
    echo "No questions found.";
    $conn->close();
    exit();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Questions</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="responseMessage">
        <h2>Hello, <i><?php echo $name; ?></i>. Please answer the following questions:</h2>
    <form action="" method="post" id="questionsForm">
        <input type="hidden" name="name" value="<?php echo $name; ?>">
        <?php foreach ($questions as $question_id => $question): ?>
            <div>
                <?php echo $question['question']; ?><br>
                <?php foreach ($question['options'] as $option): ?>
                    <label>
                        <input type="radio" name="question_<?php echo $question_id; ?>" value="<?php echo $option['option_id']; ?>">
                        <?php echo $option['option_value']; ?>
                    </label><br>
                <?php endforeach; ?>
                <button type="button" class="clear-button" id="<?php echo $question_id; ?>">Clear response</button>
                <br><br>
            </div>
        <?php endforeach; ?>
        <input type="submit" value="Submit Answers">
    </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#questionsForm').on('submit', function(event) {
                event.preventDefault(); 
                $.ajax({
                    url: 'page3.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#responseMessage').html(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#responseMessage').html('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            });

            $('.clear-button').on('click', function() {
                var questionId = this.id;
                $('input[name="question_' + questionId + '"]').prop('checked', false);
            });
        });
    </script>
</body>
</html>
