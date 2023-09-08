<?php
$dbconn = pg_connect("host=localhost port=5433 dbname=lazo-db user=postgres password=tudor sslmode=prefer connect_timeout=10")
    or die('Could not connect: ' . pg_last_error());
