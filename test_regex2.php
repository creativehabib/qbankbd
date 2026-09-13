<?php
$text = "2. What is your favorite? a. Apple b. Banana c) Cat (d) Dog";

$prefixRegex = '(?:\()?([কখগঘa-dA-D])[\)\.]';
$optionPattern = '/(?:^|\s+)' . $prefixRegex . '\s+(.+?)(?=(?:\s+' . $prefixRegex . '\s+)|$)/us';

preg_match_all($optionPattern, $text, $optionMatches, PREG_SET_ORDER);
print_r($optionMatches);
