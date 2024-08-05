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
        if ($row['answer'] == 1) {
            $correct_answers[$row['question_id']] = $row['option_id'];
        }
    }
    foreach ($_POST as $key => $value) {
            $question_id = str_replace('question_', '', $key);
            $user_answers[$question_id] = $value;
      
    }
  
$passed = 0;
$failed = 0;
foreach ($questions as $question_id => $question) {
    $correct_option_id = $correct_answers[$question_id]??"" ;
    $user_option_id = $user_answers[$question_id]??"" ;

    if ($correct_option_id === $user_option_id) {
        $passed++;
    } else {
        $failed++;
    }
}
} else {
    echo "No questions found.";
    $conn->close();
    exit();
}
$conn->close();
 ?><h2>Check your result  <?php echo $name;?></h2>
<?php foreach ($questions as $question_id => $question): ?>
    <div>
        <?php echo $question['question']; ?><br>
        <?php foreach ($question['options'] as $option): ?>
            <label>
                <input type="radio"  name="question_<?php echo $question_id; ?>" value="<?php echo $option['option_id'];?>" <?php echo (isset($user_answers[$question_id]) && $user_answers[$question_id] == $option['option_id']) ? 'checked' : 'disabled'; ?>>
                <?php 
                echo $option['option_value']; 
                if ($option['is_answer'] == 1) {
                    echo ' <b><span style="color: green;">&#9745;</span></b>';
                }
                ?>
            </label><br>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
<?php echo "<b><p style='color:blue'>Total questions: " . count($questions) . "</p><p style='color:green'>Correct: " . $passed . "</p><p style='color:red'>Wrong: " . $failed; ?></p>

