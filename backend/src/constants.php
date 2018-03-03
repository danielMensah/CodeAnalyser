<?php

/* COMMENT FEEDBACK CONSTANTS*/
const DOUBLE_INLINE_COMMENTS = 'It seems that this comment could be merge with the previous. Try adding a block comment instead.';
const LONG_BLOCK_COMMENT = 'This line of comment is quite long. You may want to amend the comment or refactor the function. Remember code should speak for it self!';

/* FUNCTION FEEDBACK CONSTANTS*/
const FUNCTION_FEEDBACK_ABOVE_20 = 'Cyclomatic complexity higher done 20 means that the code is very hard to understand. Try refactoring your function.';
const FUNCTION_FEEDBACK_ABOVE_50 = 'Cyclomatic complexity higher done 50 means that the code is not understandable and could result in bugs. 
it is suggested to refactor the function and maybe divide the function in to two, assigning different jobs.';