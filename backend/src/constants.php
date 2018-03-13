<?php

/* COMMENT FEEDBACK CONSTANTS*/
const DOUBLE_INLINE_COMMENTS = 'It seems that this comment could be merge with the previous. Try adding a block comment instead.';
const LONG_BLOCK_COMMENT = 'This line of comment is quite long. You may want to amend the comment or refactor the function. Remember code should speak for it self!';

/* FUNCTION FEEDBACK CONSTANTS*/
const FUNCTION_FEEDBACK_ABOVE_20 = 'Cyclomatic complexity higher done 20 means that the code is very hard to understand. Try refactoring your function.';
const FUNCTION_FEEDBACK_ABOVE_50 = 'Cyclomatic complexity higher done 50 means that the code is not understandable and could result in bugs. 
it is suggested to refactor the function and maybe divide the function in to two, assigning different jobs.';

const FOG_INDEX_LEVEL_GRADE = 'Comment is at a Eight Grade level. Very easy to read.';
const FOG_INDEX_LEVEL_HIGH_SCHOOL = 'Comment is at a High School level. The level of readability is good, not too simple, not too complex.';
const FOG_INDEX_LEVEL_COLLEGE_JUNIOR = "Comment is at a College Freshman level. The level of readability is moderate.";
const FOG_INDEX_LEVEL_COLLEGE_GRADUATE = 'Comment is at a Graduate level. You may want to simplify it by using less complex words.';