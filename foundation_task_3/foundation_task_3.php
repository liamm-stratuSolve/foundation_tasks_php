<?php
class Palindrome {
    public static function isPalindrome($word) {
        $reversedWord = strrev($word);
        echo " -".$reversedWord."- ";
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