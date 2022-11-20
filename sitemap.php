<?php
header( 'Content-type: text/xml' );

include( './admin/inc/db.php' );

$base_url = 'https://powliberia.com/';

// define basic structure of XML
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">';

  echo '<url>'. PHP_EOL;
    echo '<loc>'.$base_url.'</loc>'. PHP_EOL;
    echo '<changefreq>daily</changefreq>'. PHP_EOL;
    echo '<priority>0.9</priority>'. PHP_EOL;
    echo '</url>'. PHP_EOL;

  global $conn;
  $sql = 'SELECT * FROM posts';
  $stmt = $conn->query( $sql );
  if ( !empty( $stmt ) ) {
  // fetch single page
  while ( $row = $stmt->fetch() ) {
  $url = $base_url;
  $url .= '?id='. $row[ 'id' ];
  echo '<url>'. PHP_EOL;
    echo '<loc>'.$url.'</loc>'. PHP_EOL;
    echo '<changefreq>daily</changefreq>'. PHP_EOL;
    echo '<priority>0.9</priority>'. PHP_EOL;
    echo '</url>'. PHP_EOL;
  }
  }
  echo '</urlset>'. PHP_EOL;

?>