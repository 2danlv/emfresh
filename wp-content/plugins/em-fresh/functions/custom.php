<?php

function em_ucwords($str)
{
    return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
}