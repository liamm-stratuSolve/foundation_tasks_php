<?php
class Palindrome {
    public static function isPalindrome($word) {
        $word = strtolower(str_replace(' ', '', $word));
        $reversedWord = strrev($word);

        if ($reversedWord === $word)
            return true;
        else
            return false;
    }
}

if (Palindrome::isPalindrome('Never Odd Or Even'))
    echo 'Palindrome';
else
    echo 'Not palindrome';

?>