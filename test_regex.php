<?php
$text = "১. ‘বাংলা ভাষার ইতিবৃত্ত’ গ্রন্থের রচয়িতা কে
ক) ড. মুহম্মদ শহীদুল্লাহ
খ. দীনেশচন্দ্র সেন
গ. সুনীতিকুমার চট্রোপাধ্যায়
ঘ. সুকুমার সেন";

$prefixRegex = '(?:\()?([কখগঘa-dA-D])[\)\.]';
$optionPattern = '/(?:^|\s+)' . $prefixRegex . '\s+(.+?)(?=(?:\s+' . $prefixRegex . '\s+)|$)/us';

preg_match_all($optionPattern, $text, $optionMatches, PREG_SET_ORDER);
print_r($optionMatches);

$firstOptionStart = mb_strpos($text, $optionMatches[0][0]);
$titleRaw = mb_substr($text, 0, $firstOptionStart);
echo "Title Raw: " . $titleRaw . "\n";
$title = trim(preg_replace('/^[০-৯\d]+[.)।]\s*/u', '', trim($titleRaw)));
echo "Title: " . $title . "\n";
