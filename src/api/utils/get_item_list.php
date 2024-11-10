<?php

const URL = "https://eor-api.exile-studios.com/api/items";
const MAX_AGE = 2 * 60 * 60; // 2 hours in seconds
const FILE_PATH = "/tmp/eor_items.json";


function getItemList() {
  if (file_exists(FILE_PATH)) {
      $fileAge = time() - filemtime(FILE_PATH);
      
      if ($fileAge < MAX_AGE) {
          // File is up-to-date, no need to download
          $data = json_decode(file_get_contents(FILE_PATH), true);
          return $data['data'];
      }
  }

  $jsonData = file_get_contents(URL);

  if ($jsonData == false) {
      throw new Exception("Failed to download data from " . URL);
  }

  file_put_contents(FILE_PATH, $jsonData);

  $data = json_decode($jsonData, true);
  return $data['data'];
}

?>
