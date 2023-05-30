<?php

// Disable user's session
session_start();
session_unset();
session_destroy();
