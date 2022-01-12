<?php

function my_filter($input) {
  return filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_AMP);
}

?>