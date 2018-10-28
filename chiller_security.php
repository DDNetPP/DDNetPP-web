<?php
/*
 * Probably the worst idea ever
 * ChillerDragon's own security lib
 *
 */

// Thats why it is unused and replaced by:
// htmlspecialchars()

function filterXSS($raw)
{
    $type = gettype($raw);
    if ($type !== "string")
    {
        return $raw; //ignore non strings
    }
    /*
    for ($i = 0; $i < strlen($raw); $i++)
    {
        if ($raw[$i] === '<')
        {
         $raw[$i] = 'multiple chars dont work'
        }
    }
    */
    $raw = str_replace("&","&amp;",$raw);
    $raw = str_replace("<","&lt;",$raw);
    $raw = str_replace(">","&gt;",$raw);
    $raw = str_replace('"',"&quot;",$raw);
    $raw = str_replace("'","&#x27;",$raw);
    $raw = str_replace("/","&#x2F;",$raw);
    return $raw;
}
?>
