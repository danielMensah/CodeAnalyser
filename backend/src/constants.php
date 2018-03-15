<?php

/* COMMENT FEEDBACK CONSTANTS*/
const DOUBLE_INLINE_COMMENTS = 'It seems that this comment could be merge with the previous. Try adding a block comment instead.';
const LONG_BLOCK_COMMENT = 'This line of comment is quite long. You may want to amend the comment or refactor the function. Remember code should speak for it self!';

/* FUNCTION FEEDBACK CONSTANTS*/
const FUNCTION_FEEDBACK_ABOVE_20 = 'Cyclomatic complexity higher done 20 means that the code is very hard to understand. Try refactoring your function.';
const FUNCTION_FEEDBACK_ABOVE_50 = 'Cyclomatic complexity higher done 50 means that the code is not understandable and could result in bugs. 
it is suggested to refactor the function and maybe divide the function in to two, assigning different jobs.';

// Grade levels
const GRADE_1_5 = 'Comment should be easily understood by primary or elementary level developers.';
const GRADE_6_8 = 'Comment should be easily understood by secondary or middle school level developers.';
const GRADE_9_12 = 'Comment should be easily understood by secondary or sixth form or high school level developers.';
const GRADE_OVER_12 = 'Comment should be easily understood by higher education or college level developers.';

//Flesch Kincaid Reading Ease levels
const FK_READING_EASE_LEVEL_GRADE_5 = 'Comment is very easy to read. Easily understood by an average 11-year-old student.';
const FK_READING_EASE_LEVEL_GRADE_6 = 'Comment is easy to read. Conversational English for consumers.';
const FK_READING_EASE_LEVEL_GRADE_7 = 'Comment is fairly easy to read.';
const FK_READING_EASE_LEVEL_GRADE_8_9 = 'Comment is plain English. Easily understood by 13- to 15-year-old students.';
const FK_READING_EASE_LEVEL_GRADE_10_12 = 'Comment is fairly difficult to read.';
const FK_READING_EASE_LEVEL_GRADE_COLLEGE = 'Comment is difficult to read.';
const FK_READING_EASE_LEVEL_GRADE_GRADUATE = 'Comment is very difficult to read. Best understood by university graduates.';
